<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:./front_end/loginandRegistration.php");
    exit();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=cake" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dashboard" />

</head>

<body>

    <header><button id="side-bar-togle" onclick="sideBarToggle()"><span class="material-symbols-outlined">
                menu
            </span></button>
    <div id="info-div" class="info-div" onclick="activateProfileCard()">
        <button id="profile" class="profile" onclick="activateProfileCard()"><?= $_SESSION["bakery-name"][0] ?></button>
        <p id='bakery-name'><?= $_SESSION["bakery-name"] ?> Bakery</p>
        <form id="profile-form" action="" method="">
            <input type="text" name='bakery-name' value="bakery: <?= $_SESSION["bakery-name"] ?> Bakery"/>
            <input type="text" name="user-name" value="name: <?= $_SESSION['fist-name']?> <?=$_SESSION['last-name']?>"/>
            <input type="text" name="user-email" value="Email:<?= $_SESSION["email"]?>"/> 
            <input type="text" name="registration-date" value="Reg-date:<?= $_SESSION["registrationDate"]?>" readonly/> 
            <button type="submit" name="submit-edit" >submit edit</button>
        </form>
    </div>
        <button id="logout" onclick="window.location.href='./backend/logout.php'">Logout</button>
    </header>
    <div id="hidder" class="" onclick="sideBarToggle(); deactivateProfileCard();"></div>
    <div id="cover-for-large" onclick="deactivateProfileCardForLargeScreen();"></div>
    <section id="content-section">
        <aside class="">
            <button class="side-bar-card active-effect" id="dashboard-button" onclick="showMain('dashboard')" draggable="true"><span class="material-symbols-outlined">dashboard</span>Dashboard</button>
            <button class="side-bar-card" id="product-button" onclick="showMain('product')" draggable="true"></span>Product</button>
            <button class="side-bar-card" id="solled-button" onclick="showMain('solled')" draggable="true">Sold</button>
            <button class="side-bar-card" id="delivered-button" onclick="showMain('delivered')" draggable="true">Delivered</button>
            <button class="side-bar-card" id="report-button" onclick="showMain('report')" draggable="true">Report</button>
        </aside>
        <main>
            <div id="dashboard" class="main-card show">
                <h1>Dashboard</h1>
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
            <div id="delivered" class="main-card">
                <h1>Delivered</h1>
                <p>Check your delivered items here.</p>
            </div>
            <div id="report" class="main-card">
                <h1>Report</h1>
                <p>Generate reports here.</p>
            </div>
        </main>
    </section>
    <script src="./front_end/index.js" type="text/javascript" defer></script>
</body>

</html>