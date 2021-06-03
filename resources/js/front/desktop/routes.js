const mobileItems = document.querySelectorAll(".box-mobiles");
const pageSection = document.querySelector(".page-section");

mobileItems.forEach(mobileItem => {

    mobileItem.addEventListener("click", (event) => {

        let refreshRequest = async () => {

            let url = mobileItem.dataset.url;

            try {
                axios.get(url).then(response => {
                    pageSection.innerHTML = response.data.form;

                    window.history.pushState('','',url);
    
               
                });
            } catch (error) {   
                console.error(error);
            }
        }

        refreshRequest();
    });
});

