import {renderCkeditor} from './ckeditor'

const table = document.getElementById("table");
const form = document.getElementById("form");

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let labels = document.getElementsByTagName('label');
    let inputs = document.querySelectorAll('.input');
    let sendButton = document.getElementById("send-button");
    let clearButton = document.getElementById("clear-button");
    let secondMenu = document.querySelectorAll(".second-menu-form");
    let secondMenuLi = document.querySelectorAll(".sub-menu-parent");
    



    secondMenu.forEach(secondMenuLi => {

        secondMenuLi.addEventListener('click', () => {
    
            for( var i = 0; i < labels.length; i++ ) {
                if (labels[i].htmlFor == secondMenuLi.name){
                    labels[i].classList.add("active");
                }
            }
        });
    });


    inputs.forEach(input => {

        input.addEventListener('focusin', () => {
    
            for( var i = 0; i < labels.length; i++ ) {
                if (labels[i].htmlFor == input.name){
                    labels[i].classList.add("active");
                }
            }
        });
    
        input.addEventListener('blur', () => {
    
            for( var i = 0; i < labels.length; i++ ) {
                labels[i].classList.remove("active");
            }
        });
    });

    sendButton.addEventListener("click", (event) => {

        event.preventDefault();
    
        forms.forEach(form => { 
            
            let data = new FormData(document.getElementById('form-faqs'));

            if( ckeditors != 'null'){

                Object.entries(ckeditors).forEach(([key, value]) => {
                    data.append(key, value.getData());
                });
            }
            
            let url = form.action;
    
            let sendPostRequest = async () => {
    
                try {
                    await axios.post(url, data).then(response => {
                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;
                        renderTable();
                        
                    });
                     
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendPostRequest();
    
          
        });
    });

    clearButton.addEventListener("click", (event) => {

        event.preventDefault();

        forms.forEach(form => { 
            
            let url = clearButton.dataset.url;
    
            let cleanForm = async () => {
    
                try {
                        axios.get(url).then(response => {
                        form.innerHTML = response.data.form;
                        renderForm();
                    });
                     
                } catch (error) {
                    console.error(error);
                }
            };
    
            cleanForm();
    
            console.log('1');
        });

    });


    renderCkeditor();
}

export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let formContainer = document.getElementById("form");
 
    
    editButtons.forEach(editButton => {
    
        let sendGetRequest = async () => {
    
            editButton.addEventListener("click", (event) =>{
            //Dataset: La propiedad dataset en HTMLElement proporciona una interfaz lectura/escritura 
            //para obtener todos los atributos de datos personalizados (data-*) de cada uno de los elementos. 
        
                let url = editButton.dataset.url;
                
                try {
                    axios.get(url).then(response => {
                        console.log(response.data.form);
                        formContainer.innerHTML = response.data.form;
                        renderForm();
                    });
                } catch (error) {   
                    console.error(error);
                }
            });
        }
    
        sendGetRequest();
    });
    
    
    deleteButtons.forEach(deleteButton => {
    
        let sendDeleteRequest = async () => {
    
            deleteButton.addEventListener("click", (event) =>{
    
                let url = deleteButton.dataset.url;
            
                try {
                    axios.delete(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                    });
                } catch (error) {
                    console.error(error);
                }
            });
        }
    
        sendDeleteRequest();
    });
}

renderForm();
renderTable();







