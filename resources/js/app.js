require('./bootstrap');

/*let enviar = document.getElementById("sendButton");

enviar.addEventListener('click', (event) =>{
    event.preventDefault();
    console.log('Hola');
})*/

const botonGuardar = document.getElementById("sendButton");

botonGuardar.addEventListener("click", (event) => {
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
});
