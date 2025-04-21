//To show and hide the side bar when the screen is small
//for home page
function sideBarToggle() {
    const hidder = document.getElementById("hidder");
    const asideElements = document.getElementsByTagName("aside");

    hidder.classList.toggle("show");
    
    if (asideElements.length > 0) {
        asideElements[0].classList.toggle("show");
    }
}

// to show the main contents when clicked on the cards on the side bar
//for home page
function showMain(id){
    mainObjects=document.getElementsByClassName("main-card");
    Array.from(mainObjects).forEach(element => {
        element.classList.remove("show");
    });
    mainObjects[id].classList.add("show");
    sideBarCard=document.getElementsByClassName("side-bar-card");
    Array.from(sideBarCard).forEach(element => {
        element.classList.remove("active-effect");
    })
    document.querySelector(`#${id}-button`).classList.add("active-effect");
    sideBarToggle();
}


//To switch between the login and registration form 
//for login and registration page
function showForm(formId){
document.querySelectorAll(".form-box").forEach(form=>form.classList.remove("active"));
document.getElementById(formId).classList.add("active");
}
