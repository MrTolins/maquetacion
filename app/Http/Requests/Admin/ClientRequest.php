<?php
/*
|--------------------------------------------------------------------------
| Validaciones del formulario de la sección FAQ's
|--------------------------------------------------------------------------
|
| **authorize: determina si el usuario debe estar autorizado para enviar el formulario. 
|
| **rules: recoge las normas que se deben cumplir para validar el formulario. Los errores son 
|   devueltos en forma de objeto JSON en un error 422.
| 
| **messages: mensajes personalizados de error.
|    
*/
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:64|regex:/^[a-z0-9áéíóúàèìòùäëïöüñ\s]+$/i',
            'email' => ['required','email','max:255', Rule::unique('t_clients')->ignore($this->id)],
            'age' => 'required|numeric',
            'address' => 'required|max:255',
            'credit' => 'required|numeric',
            'date' => 'required',//validación ya hecha por type="date" en el html

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe añadir un nombre',
            'name.min' => 'El mínimo de caracteres permitidos para el nombre son 3',
            'name.max' => 'El máximo de caracteres permitidos para el nombre son 64',
            'email.required' => 'Debe añadir un email',
            'email.email' => 'El formato de email es incorrecto',
            'email.max' => 'El máximo de caracteres permitidos para el email son 255',
            'age.required' => 'Debe añadir una edad',
            'age.numeric' => 'En este campo solo puede escribir números',
            'address.required' => 'Debe añadir una dirección',
            'address.max' => 'El máximo de caracteres permitidos para la dirección son 255',
            'credit.required' => 'Debe añadir una cantidad',
            'credit.numeric' => 'En este campo solo puede escribir números',
            'date.required' => 'Daebe añadir una fecha de contratación',
        ];
    }
}
