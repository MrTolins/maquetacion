const localeItems = document.querySelectorAll('.locale-item');
const localePanels = document.querySelectorAll(".locale-panel");


localeItems.forEach(localeItem => { 

    localeItem.addEventListener("click", () => {

        let activeLocale = document.querySelectorAll(".locale-active");

        activeLocale.forEach(activeLocale => {
            activeLocale.classList.remove("locale-active");
        });
        
        localeItem.classList.add("locale-active");

        localePanels.forEach(localePanel => {

            if(localePanel.dataset.tab == localeItem.dataset.tab){
                localePanel.classList.add("locale-active"); 
            }
        });
    });
});
