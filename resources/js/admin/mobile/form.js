import {renderCkeditor} from './ckeditor'

const table = document.getElementById("table");
const form = document.getElementById("form");

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let labels = document.getElementsByTagName('label');
    let inputs = document.querySelectorAll('.input')
    let sendButton = document.getElementById("send-button");
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
                        console.log('2');
                    });
                     
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendPostRequest();
    
            console.log('1');
        });
    });




    renderCkeditor();
}

export let renderTable = () => {

    let editButtons = document.querySelectorAll(".table-edit");
    let deleteButtons = document.querySelectorAll(".table-delete");
    let formContainer = document.getElementById("form");
    let editSwipes = document.querySelectorAll(".edit-swipe");
    let deleteSwipes = document.querySelectorAll(".delete-swipe");

    editSwipes.forEach(editSwipe => {
    
        let sendGetRequest = async () => {
    
            editSwipe.addEventListener("click", (event) =>{
            //Dataset: La propiedad dataset en HTMLElement proporciona una interfaz lectura/escritura 
            //para obtener todos los atributos de datos personalizados (data-*) de cada uno de los elementos. 
        
                let url = editSwipe.dataset.url;
                
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
    
    deleteSwipes.forEach(deleteSwipe => {
    
        let sendDeleteRequest = async () => {
    
            deleteSwipe.addEventListener("click", (event) =>{
    
                let url = deleteSwipe.dataset.url;
            
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






