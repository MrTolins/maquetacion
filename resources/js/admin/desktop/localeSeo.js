import {renderTable} from './form';
import {showMessage} from './messages';

export let renderLocaleSeo = () => {

    let table = document.getElementById("table");
    let importSeo = document.getElementById('import-seo');

    if(importSeo){

        importSeo.addEventListener("click", () => {

            let url = importSeo.dataset.url;
        
            let sendEditRequest = async () => {
    
                try {
                    await axios.get(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                        showMessage('success', response.data.message);
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendEditRequest();
        });
    }
}
