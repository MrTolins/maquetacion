
export let renderLocaleTabs = () => {

    let localeItems = document.querySelectorAll('.locale-item');
    let localePanels = document.querySelectorAll(".locale-panel");
    
    localeItems.forEach(localeItem => { 
    
        localeItem.addEventListener("click", () => {
    
            let activeLocale = document.querySelectorAll(".locale-active");
            let activeTab = localeItem.dataset.tab;
    
            activeLocale.forEach(activeLocale => {

                if(activeLocale.dataset.tab == activeTab){
                    activeLocale.classList.remove("locale-active");
                }
            });
             
            localeItem.classList.add("locale-active");
    
            localePanels.forEach(localePanel => {
    
                if(localePanel.dataset.tab == activeTab){
                    if(localePanel.dataset.localetab == localeItem.dataset.localetab){
                        localePanel.classList.add("locale-active"); 
                    }
                }      
            });
        });
    });
}
