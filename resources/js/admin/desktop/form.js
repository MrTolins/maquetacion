const forms = document.querySelectorAll(".admin-form");
const labels = document.getElementsByTagName('label');
const inputs = document.querySelectorAll('.input')
const sendButton = document.getElementById("send-button");
const editButtons = document.querySelectorAll(".table-edit");
const deleteButtons = document.querySelectorAll(".table-delete");
const formContainer = document.getElementById("form-container");

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
                });
            } catch (error) {
                console.error(error);
            }
        });
    }

    sendDeleteRequest();
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
        let url = form.action;

        let sendPostRequest = async () => {

            try {
                await axios.post(url, data).then(response => {
                    form.id.value = response.data.id;
                    table.innerHTML = response.data.table;
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
