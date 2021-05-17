<?php

namespace App\Vendor\Image;

use Illuminate\Support\Facades\Storage;
use App\Vendor\Image\Models\ImageConfiguration;
use App\Vendor\Image\Models\ImageOriginal;
use App\Vendor\Image\Models\ImageResize;
use App\Jobs\ProcessImage;
use App\Jobs\DeleteImage;
use Jcupitt\Vips;
use Debugbar;

class Image
{
	protected $entity;
	protected $extension_conversion;
	
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	//Request, formato de la imagen, clave foranea
	public function storeRequest($request, $extension_conversion, $foreign_id){

		$this->extension_conversion = $extension_conversion;
		//bucle para cada imagen que recibo
		foreach($request as $key => $file){

			//separa el idioma del tag (title.es)
			$key = str_replace(['-', '_'], ".", $key); 
			$explode_key = explode('.', $key);
			$content = reset($explode_key);
			$language = end($explode_key);

			//le pasas los datos a la imagen
			$image = $this->store($file, $foreign_id, $content, $language);
			$this->store_resize($file, $foreign_id, $content, $language, $image->path);
		}
	}

	//Proceso para gestionar imagenes:
	//definir que campos va a tener la tabla
	//montar un objeto en el controlador que se ocupará de meter los datos en la tabla
	//preparar los datos y guardar la imagen

	//Devuelve la imagen que ha guardado en la base de datos
	public function store($file, $entity_id, $content, $language){

		//deja el path(nombre) del archivo en minusculas. Pide el nombre original de la foto
		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		//reemplaza los espacios por guiones
		$name = str_replace(" ", "-", $name);
		//extensión del archivo a minusculas
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

		//contruyes el nombre del archivo más su extensión
		$filename = $name .'.'. $file_extension;

		//si la extension del archivo no es un svg(al redimensionar no pierde calidad), guarda las dimensiones de la imagen
		if($file_extension != 'svg'){
			//se obtiene el tamaño de una imagen. $data es un array.
			$data = getimagesize($file);
			$width = $data[0];
			$height = $data[1];
		}
		
		//donde la entidad sea igual a this entity(faqs).... dame el primero (first())
		$settings = ImageConfiguration::where('entity', $this->entity)
		->where('content', $content)
		->where('grid', 'original')
		->first();
		
		//estructura para guardar la imagen
		$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name . '.' . $file_extension;
		$path = str_replace(" ", "-", $path);

		//si en la imageconfig el type es single, solo voy a meter una foto
		if($settings->type == 'single'){

			//borra directorio
			Storage::disk($this->entity)->deleteDirectory('/' . $entity_id . '/' . $language . '/' . $content . '/original');
			//sube la foto nueva
			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			//crea o actualiza los campos
			$image = ImageOriginal::updateOrCreate([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content],[
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
			]);
		}

		//si fueran muchas fotos hará los siguiente
		elseif($settings->type == 'collection'){

			
			$counter = 2;
 
			//bucle mientras exista el path, si exite un archivo con la misma path, le meterá en el nombre $counter, donde le sumará 1 a $counter
			while (Storage::disk($this->entity)->exists($path)) {
				
				$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name.'-'. $counter.'.'. $file_extension;
				$filename =  $name.'-'. $counter.'.'. $file_extension;
				$counter++;
			}

			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			$image = ImageOriginal::create([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content],[
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
			]);
		}

		return $image;
	}

	//guardo la imagen redimensionada
	public function store_resize($file, $entity_id, $content, $language, $original_path){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
		//donde grid no sea igual a original
		$settings = ImageConfiguration::where('entity', $this->entity)
					->where('content', $content)
					->where('grid', '!=', 'original')
					->get();

		
		// value por cada configuración
		foreach ($settings as $setting => $value) {

			//el campo content accepted lo separa por barras
			$content_accepted = explode("/", $value->content_accepted);

			//si la extension no se encuentra dentro de content accepted
			if(!in_array($file_extension, $content_accepted)){
				continue;//si no está, para
			}
			
			//si la extension es svg... no lo voy a transformar a otro tipo de imagen
			if($file_extension == 'svg'){
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $file_extension;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $file_extension;

			//si no, extension conversion, va a transformar jpg, png, etc a webp (mas optimizado, menos peso)
			//mirar el controlador FaqController
			}else{
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $this->extension_conversion;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $this->extension_conversion;
			}		


			if($value->type == 'single'){

				//hay un Job que se llama ProcessImage, que le pasas los datos a Jobs->ProcessImage.php
				
				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$file_extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				//nombre que va a tener la cola, a que cola se va a ir, si hay otra cola la pones en Horizon.php en config
				)->onQueue('process_image');
			}

			elseif($value->type == 'collection'){

				$counter = 2;

				while (Storage::disk($value->disk)->exists($path)) {
					
					if($file_extension == 'svg'){
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $file_extension;
						$filename = $name .'-'. $counter.'.'. $file_extension;
						$counter++;
					}else{
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $this->extension_conversion;
						$filename = $name .'-'. $counter.'.'. $this->extension_conversion;
						$counter++;
					}		
				}

				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				)->onQueue('process_image');
			}
		}
	}

	public function show($entity_id, $language)
	{
		return ImageOriginal::getPreviewImage($this->entity, $entity_id, $language)->first();
	}

	public function preview($entity_id)
	{
		$items = ImageOriginal::getPreviewImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function galleryImage($entity, $grid, $entity_id, $filename)
	{
		
		$image = ImageOriginal::getGalleryImage($entity, $entity_id, $filename, $grid)->first();

		return response()->json([
			'path' => Storage::url($image->path),
		]); 
	}

	public function galleryPreviousImage($entity, $grid, $entity_id, $id)
	{		

		$image = ImageOriginal::getGalleryPreviousImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function galleryNextImage($entity, $grid, $entity_id, $id)
	{

		$image = ImageOriginal::getGalleryNextImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function original($entity_id)
	{
		$items = ImageOriginal::getOriginalImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function getAllByLanguage($language){ 

        $items = ImageOriginal::getAllByLanguage($this->entity, $language)->get()->groupBy('entity_id');

        $items =  $items->map(function ($item) {
            return $item->pluck('path','grid');
        });

        return $items;
    }

	public function destroy(ImageOriginal $image)
	{
		DeleteImage::dispatch($image->filename, $image->content, $image->entity)->onQueue('delete_image');

		$message = \Lang::get('admin/media.media-delete');

		return response()->json([
            'message' => $message,
        ]);
	}

	public function delete($entity_id)
	{
		if (ImageOriginal::getImages($this->entity, $entity_id)->count() > 0) {

			$images = ImageOriginal::getImages($this->entity, $entity_id)->get();

			foreach ($images as $image){
				Storage::disk($image->entity)->delete($image->path);
				$image->delete();
			}
		}
	}
}
