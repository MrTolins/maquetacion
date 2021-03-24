const forms = document.querySelectorAll(".admin-form");
const labels = document.getElementsByTagName('label');
const inputs = document.querySelectorAll('.input')
const sendButton = document.getElementById("send-button");

/*
sendButton.addEventListener("click", (event) => {
    event.preventDefault();

    const formularios = document.querySelectorAll(".admin-form");

    formularios.forEach(formulario => {
        const formID = document.getElementById(formulario.id);
        console.log(formID);
        const datosFormulario = new FormData(formID);

        for (var entrada of datosFormulario.entries()) {
            console.log(datosFormulario);
            console.log(entrada[0] + ": " + entrada[1]);
        }
    })
}); */

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
        
        let data = new FormData(document.getElementById(form.id));
        let url = form.action;

        let sendPostRequest = async () => {

            try {
                let response = await axios.post(url, data).then(response => {
                    form.innerHTML = response.data.form;
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