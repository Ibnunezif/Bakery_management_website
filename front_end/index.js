function sideBarToggle() {
    const hidder = document.getElementById("hidder");
    const asideElements = document.getElementsByTagName("aside");

    hidder.classList.toggle("show");
    
    if (asideElements.length > 0) {
        asideElements[0].classList.toggle("show");
    }
}

