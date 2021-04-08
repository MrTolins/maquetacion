import {renderForm, renderTable} from './form'

const sidebarItems = document.querySelectorAll(".sidebar-item");
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
