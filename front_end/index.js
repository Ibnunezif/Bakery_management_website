function sideBarToggle() {
    const hidder = document.getElementById("hidder");
    const asideElements = document.getElementsByTagName("aside");

    hidder.classList.toggle("show");
    
    if (asideElements.length > 0) {
        asideElements[0].classList.toggle("show");
    }
}

function showMain(id){
    mainObjects=document.getElementsByClassName("main-card");
    Array.from(mainObjects).forEach(element => {
        element.classList.remove("show");
    });
    mainObjects[id].classList.add("show");
    sideBarToggle();
}

