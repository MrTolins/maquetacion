const forms = document.querySelectorAll(".admin-form");
const labels = document.getElementsByTagName('label');
const inputs = document.querySelectorAll('.input')
const sendButton = document.getElementById("send-button");
const table = document.getElementById("table");


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
