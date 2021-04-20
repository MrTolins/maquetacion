import {renderForm, renderTable} from './form'

const sidebarItems = document.querySelectorAll(".sidebar-item");
const openSidebar = document.querySelectorAll(".sidebar-title");
const closeSidebar = document.querySelectorAll(".sidebar");
const form = document.getElementById("form");
const table = document.getElementById("table");




sidebarItems.forEach(sidebarItem => {

    sidebarItem.addEventListener("click", (event) => {

        let refreshRequest = async () => {

            let url = sidebarItem.dataset.url;

            try {
                axios.get(url).then(response => {
                    form.innerHTML = response.data.form;
                    table.innerHTML = response.data.table;

                    window.history.pushState('','',url);

                    //introducir con la clase active en el css
                    document.getElementById("menu").style.width = "0%";
                    document.getElementById("main").style.filter = "blur(0px)";
                    document.getElementById("lang-faqs").style.filter = "blur(0px)";
                    document.getElementById("table-filter").style.filter = "blur(0px)";

                    renderForm();
                    renderTable();
                });
            } catch (error) {   
                console.error(error);
            }
        }

        refreshRequest();
    });
});

// openSidebar.addEventListener("click", () => {
   
//     document.getElementById("menu").style.height = "100%";
//     document.getElementById("main").style.filter = "blur(10px)";
//     document.getElementById("lang-faqs").style.filter = "blur(10px)";

// });

