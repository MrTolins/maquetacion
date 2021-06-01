const plusButtons = document.querySelectorAll('.mobile-plus-button');
const mobileElements = document.querySelectorAll(".mobile");

plusButtons.forEach(plusButton => { 

    plusButton.addEventListener("click", () => {

        let activeElements = document.querySelectorAll(".active");

        if(plusButton.classList.contains("active")){

            plusButton.classList.remove("active");

            activeElements.forEach(activeElement => {
                activeElement.classList.remove("active");
            });

        }else{

            activeElements.forEach(activeElement => {
                activeElement.classList.remove("active");
            });
            
            plusButton.classList.add("active");

            mobileElements.forEach(mobileElement => {

                if(mobileElement.dataset.content == plusButton.dataset.button){
                    mobileElement.classList.add("active"); 
                }else{
                }
            });
        }
    });
    
});

