<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role']!='worker'){
    header("Location:./index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beakery</title>
    <link href="./front_end/index.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    
</head>

<body>

    <header><button id="side-bar-togle" onclick="sideBarToggle()"><span class="material-icons menu-icon">menu</span></button>
    <div id="info-div" class="info-div" onclick="activateProfileCard()">
        <button id="profile" class="profile" onclick="activateProfileCard()"><?= $_SESSION["bakery-name"][0] ?></button>
        <p id='bakery-name'><?= $_SESSION["bakery-name"] ?> Bakery</p>
        <form id="profile-form" action="" method="">
            <input type="text" name='bakery-name' value="bakery name: <?=$_SESSION["bakery-name"] ?> Bakery" readonly/>
            <input type="text" name="user-name" value="name: <?= $_SESSION['fist-name']?> <?=$_SESSION['last-name']?>" readonly/>
            <input type="text" name="user-email" value="Email: <?= $_SESSION["email"]?>" readonly/> 
            <p name="registration-date" value="Reg-date:<?= $_SESSION["registrationDate"]?>">Reg-date: <?= substr($_SESSION["registrationDate"],0,10)?></p>
            <button type="button" id="toggle-edit" onclick="toggleEdit()">Edit</button>
            <button type="submit" id="submit-edit" name="submit-edit" style="display:none" >save</button>
        </form>
    </div>
        <button id="logout" onclick="window.location.href='./backend/logout.php'"><span class="material-icons">logout</span> Logout</button>
    </header>
    <div id="hidder" class="" onclick="sideBarToggle(); deactivateProfileCard();"></div>
    <div id="cover-for-large" onclick="deactivateProfileCardForLargeScreen();"></div>
    <section id="content-section">
        <aside class="">
            <button class="side-bar-card active-effect" id="dashboard-button" onclick="showMain('dashboard')" draggable="true"><span class="material-icons">dashboard</span> Dashboard</button>
            <button class="side-bar-card" id="purchased-button" onclick="showMain('purchased')" draggable="true"><span class="material-icons">fastfood</span>Add ingredient</button>
            <button class="side-bar-card" id="product-button" onclick="showMain('product')" draggable="true"><span class="material-icons">lunch_dining</span>Add Product</button>
            <button class="side-bar-card" id="solled-button" onclick="showMain('solled')" draggable="true"><span class="material-icons">shopping_basket</span>Add Sold</button>
        </aside>
        <main>
            <div id="dashboard" class="main-card show">
                <h1>Dashboard</h1>
                <p>worker</p>
                <p>Welcome to the dashboard!</p>
            </div>
            <div id="product" class="main-card">
                <h1>Product</h1>
                <p>Manage your products here.</p>

            </div>
            <div id="solled" class="main-card">
                <h1>Sold</h1>
                <p>View your sold items here.</p>
                
            </div>
            <div id="purchased" class="main-card">
                <h1>purchased</h1>
    
            </div>
        </main>
    </section>
    <script src="./front_end/index.js" type="text/javascript" defer></script>
</body>

</html>