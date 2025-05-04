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



//To show  the profile card when clicked on the profile icon and text
//for home page
function activateProfileCard(){
   const formElements=document.getElementById("profile-form");
   document.getElementById("info-div").classList.remove("info-div");
   document.getElementById("info-div").classList.add("active-prof-div");
   document.getElementById("profile").classList.remove("profile");
   document.getElementById("profile").classList.add("active-prof");
   const hidder = document.getElementById("hidder");
   hidder.classList.add("show");
   formElements.classList.add("profile-form");
   formElements.style.display="flex";

//    for large sceeen
const cover = document.getElementById("cover-for-large");
cover.classList.add("cover-for-large");
}

//to hide the profile card when clicked on the hidder or outside the profile card
//for home page
function deactivateProfileCard(){
    const formElements=document.getElementById("profile-form");
    document.getElementById("info-div").classList.add("info-div");
    document.getElementById("info-div").classList.remove("active-prof-div");
    document.getElementById("profile").classList.add("profile");
    document.getElementById("profile").classList.remove("active-prof");
    const hidder = document.getElementById("hidder");
    hidder.classList.remove("show");
    formElements.classList.remove("profile-form");
    formElements.style.display="none";
    const asideElements = document.getElementsByTagName("aside");
    if (asideElements.length > 0) {
        asideElements[0].classList.remove("show");
    }
    deactivateProfileCardForLargeScreen();
}

//to hide the profile card when clicked on the hidder or outside the profile card
//for home page large screens
function deactivateProfileCardForLargeScreen(){
    const formElements=document.getElementById("profile-form");
    document.getElementById("info-div").classList.add("info-div");
    document.getElementById("info-div").classList.remove("active-prof-div");
    document.getElementById("profile").classList.add("profile");
    document.getElementById("profile").classList.remove("active-prof");
    const cover = document.getElementById("cover-for-large");
    cover.classList.remove("cover-for-large");
    formElements.classList.remove("profile-form");
    formElements.style.display="none";
    deactivateProfileCard();
}

//toggle the edit button to edit the profile information
//for home page
function toggleEdit() {
    const form = document.getElementById('profile-form');
    const inputs = form.querySelectorAll('input');
    const submitButton = document.getElementById('submit-edit');
    const editButton=document.getElementById("toggle-edit");
    let isReadOnly = inputs[0].hasAttribute('readonly');

    inputs.forEach(input => {
        if (isReadOnly) {
            input.removeAttribute('readonly'); 
            submitButton.style.display="block";
            editButton.innerText="cancel";
        } else {
            input.setAttribute('readonly', true); 
            submitButton.style.display="none";
            editButton.innerText="Edit";
        }
    });
}

let itemId = null; 
function showDialog(id) {
    itemId = id; 
    document.getElementById('message-display-conatiner').style.display = 'flex';
    
}

function confirmAction() {
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = './backend/deleteWorkers.php';
     

    // Create an input element for the ID
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'id'; // Name of the input
    input.value = itemId; // Use the stored ID
    console.log(itemId);

    // Append the input to the form
    form.appendChild(input);

    // Append the form to the body
    document.body.appendChild(form);

    // Submit the form
    form.submit();
}

function closeDialog() {
    document.getElementById('message-display-conatiner').style.display = 'none';
}
