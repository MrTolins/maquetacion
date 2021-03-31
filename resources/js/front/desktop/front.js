let button = document.querySelectorAll(".accordion");
let i;

for (i = 0; i < button.length; i++) {
  button[i].addEventListener("click", () => {
    
    this.classList.toggle("active");
    let panel = document.querySelectorAll(".panel");
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}