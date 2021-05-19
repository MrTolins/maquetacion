import {renderCkeditor} from './ckeditor';
import {startWait, stopWait} from './wait';
import {renderUploadImage} from './uploadImage';
import {showMessage} from './messages';
import {renderTabs} from './tabs';
import {renderLocaleTabs} from './localeTabs';

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
    
                startWait();

                try {
                    await axios.post(url, data).then(response => {
                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;

                        stopWait();
                        showMessage('success', response.data.message);
                        renderTable();
                        
                    });
                     
                } catch (error) {
                    stopWait();

                    if(error.response.status == '422'){
    
                        let errors = error.response.data.errors;      
                        let errorMessage = '';
    
                        Object.keys(errors).forEach(function(key) {
                            errorMessage += '<li>' + errors[key] + '</li>';
                        })
        
                        showMessage('error', errorMessage);
                    }
                }
            };
    
            sendPostRequest();
    
          
        });
    });

    clearButton.addEventListener("click", (event) => {

        event.preventDefault();
        
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

    renderCkeditor();
    renderTabs();
    renderLocaleTabs();
    renderUploadImage();
}

export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let formContainer = document.getElementById("form");
    let paginationButtons = document.querySelectorAll('.table-pagination-button');
    let deleteConfirm = document.getElementById('delete-confirm');
    let deleteCancel = document.getElementById('delete-cancel');
 
    
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

    deleteCancel.addEventListener("click", () => {
        modalDelete.classList.remove('open');
    });

    deleteConfirm.addEventListener("click", () => {

        let url = deleteConfirm.dataset.url;

        startWait();

        let sendDeleteRequest = async () => {

            try {
                await axios.delete(url).then(response => {
                    table.innerHTML = response.data.table;
                    form.innerHTML = response.data.form;
                    modalDelete.classList.remove('open');
                    renderTable();
                    renderForm();

                    stopWait();
                    showMessage('success', response.data.message);
                });
                
            } catch (error) {
                stopWait();
                console.error(error);
            }
        };

        sendDeleteRequest();
    });

    paginationButtons.forEach(paginationButton => {

        paginationButton.addEventListener("click", () => {

            let url = paginationButton.dataset.pagination;

            let sendPaginationRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendPaginationRequest();
            
        });
    });

}

renderForm();
renderTable();







