export let renderUpload = () => {

    let inputElements = document.querySelectorAll(".upload-input");
    let inputImages = document.querySelectorAll(".images-upload");

    inputElements.forEach(inputElement => {
        
    
        let uploadElement = inputElement.closest(".upload");

        

        uploadElement.addEventListener("click", (e) => {
            inputElement.click();
            
            
        });
      
        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(uploadElement, inputElement.files[0]);
            }
        });
      
        uploadElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadElement.classList.add("upload-over");
        });
      
        ["dragleave", "dragend"].forEach((type) => {
            uploadElement.addEventListener(type, (e) => {
                uploadElement.classList.remove("upload-over");
            });
        });
      
        uploadElement.addEventListener("drop", (e) => {
            e.preventDefault();
        
            if (e.dataTransfer.files.length) {
                    inputElement.files = e.dataTransfer.files;
                    updateThumbnail(uploadElement, e.dataTransfer.files[0]);
            }
        
            uploadElement.classList.remove("upload-over");

        });
    });


    inputImages.forEach(inputImage => {
    
        let uploadElement = inputImage.closest(".images");
        

      
        uploadElement.addEventListener("click", (e) => {
            inputImage.click();

            var p_prime = uploadElement.cloneNode(true);
        });
      
        inputImage.addEventListener("change", (e) => {
            if (inputImage.files.length) {
                updateImages(uploadElement, inputImage.files[0]);

            }
        });
      
        uploadElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadElement.classList.add("images-over");
        });
      
        ["dragleave", "dragend"].forEach((type) => {
            uploadElement.addEventListener(type, (e) => {
                uploadElement.classList.remove("images-over");

                
            });
        });
      
        uploadElement.addEventListener("drop", (e) => {
            e.preventDefault();
        
            if (e.dataTransfer.files.length) {
                    inputImage.files = e.dataTransfer.files;
                    updateImages(uploadElement, e.dataTransfer.files[0]);
            }
        
            uploadElement.classList.remove("images-over");

            
        });

        
    });
      
    function updateThumbnail(uploadElement, file) {
    
        let thumbnailElement = uploadElement.querySelector(".upload-thumb");

        
      
        if (uploadElement.querySelector(".upload-prompt")) {
            uploadElement.querySelector(".upload-prompt").remove();
        }
      
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("upload-thumb");
            uploadElement.appendChild(thumbnailElement);
        }
      
        thumbnailElement.dataset.label = file.name;
      
        if (file.type.startsWith("image/")) {
            let reader = new FileReader();
        
            reader.readAsDataURL(file);
    
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
            
            
        } else {
            thumbnailElement.style.backgroundImage = null;
        }

        
    }

    function updateImages(uploadElement, file) {
    
        let thumbnailElement = uploadElement.querySelector(".images-thumb");
        let images = document.getElementById("images");
        let clon = images.cloneNode(true);

        document.querySelector(".form-images").appendChild(clon);


      
        if (uploadElement.querySelector(".images-prompt")) {
            uploadElement.querySelector(".images-prompt").remove();
        }
      
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("images-thumb");
            uploadElement.appendChild(thumbnailElement);
           
            
        }
      
        thumbnailElement.dataset.label = file.name;
      
        if (file.type.startsWith("image/")) {
            let reader = new FileReader();
        
            reader.readAsDataURL(file);
    
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }

        renderUpload();

    }
 

    // function updateImages(uploadElement, file) {
    //     let fileInput = document.getElementById('upload-images');
        
    //     for (var i = 0; i < fileInput.files.length; i++) {
    //     if (fileInput.files && fileInput.files[i]) {
    //             var reader = new FileReader();
    //             reader.onload = function(e) {
    //             var img = document.createElement("img");
    //             img.src = e.target.result;
    //             document.getElementById('imagePreview').appendChild(img);
    //             };
    //             reader.readAsDataURL(fileInput.files[i]);
    //         }
    //     }
        
    // }

}
