<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role']!='worker'){
    header("Location:./index.php");
}

$errors=[
    'sold'=>$_SESSION['sold_error']??'',
    'sold-success'=>$_SESSION['sold_success']??'',
];

function showError($error){
    return !empty($error)?"<p class='error-message'>$error</p>":"";
}
function showSucess($sucess){
    return !empty($sucess)?"<p class='success-message'>$sucess</p>":"";
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
            <input type="text" name="user-first-name" value="<?= $_SESSION['fist-name']?> " readonly/>
            <input type="text" name="user-last-name" value=" <?=$_SESSION['last-name']?>" readonly/>
            <input type="text" name="user-email" value="<?= $_SESSION["email"]?>" readonly/> 
            <input type="text" name="user-password" placeholder="password" readonly/> 
            <p name="registration-date" value="<?= $_SESSION["registrationDate"]?>"><?= substr($_SESSION["registrationDate"],0,10)?></p>
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
            <button class="side-bar-card" id="product-button" onclick="showMain('product')" draggable="true"><span class="material-icons">lunch_dining</span>Add Product</button>
            <button class="side-bar-card" id="solled-button" onclick="showMain('solled')" draggable="true"><span class="material-icons">shopping_basket</span>Add Sold</button>
        </aside>
        <main>
        <div id="dashboard" class="main-card show">
    <h1><?= $_SESSION['fist-name'] ?>! Dashboard</h1>
    <div class="dashboard-grid">
        <!-- Add Product Section -->
        <div class="dashboard-card">
            <span class="material-icons">lunch_dining</span>
        
            <h2>Add Product</h2>
            <ul>
                <li>total product <?=$_SESSION["quantity"]?></li>
                <li>total cost <?=$_SESSION["unitCost"]?> birr</li> 
            </ul>
            
            <button onclick="showMain('product')">Go to Add Product</button>
        </div>

        <!-- Add Sold Items Section -->
        <div class="dashboard-card">
            <span class="material-icons">shopping_basket</span>
            <h2>Add Sold Items</h2>
            <ul>
                <li>total sold <?=$_SESSION["soldQuantity"]?></li>
                <li>total income<?= $_SESSION["soldPrice"]?> birr</li>
            </ul>
            
            <button onclick="showMain('solled')">Go to Add Sold Items</button>
        </div>

        <!-- Add Purchased Ingredients Section -->
    </div>
</div>
            <div id="product" class="main-card">
                <h1>Add Product</h1>
                 <form class='main-card-forms' method='post' action='./backend/add_product_sold.php'>
                    <input type="text" id="product-quantity" name="product-quantity" placeholder="product quantity" required>
                    <select name="product-type" id="product-name" required>
                        <option value="" disabled selected>---select product---</option>
                        <option value="bread">bread</option>
                        <option value="cake">cake</option>
                        <option value="cookie">cookie</option>
                        <option value="pastry">pastry</option>
                    </select>
                    <input type="text" id="unit-price" name="unit-price" placeholder="unit price" required>
                    <button name="add-product" type="submit">Add Product</button>
                </form>
        

            </div>
            <div id="solled" class="main-card">
                <h1> Add Sold Items</h1>
                
                <form class='main-card-forms' method='post' action='./backend/add_product_sold.php'>
                   <?=showError($errors['sold'])?>
                   <?=showSucess($errors['sold-success'])?>
                    <input type="text" id="sold-quantity" name="sold-quantity" placeholder="sold quantity" required>
                    <input type="text" id="sale-price" name="sale-price" placeholder="unit sale price" required>
                    <select name="outline" id="outline" required>
                        <option value="" disabled selected>---select outline---</option>
                        <option value="delivered">delivered</option>
                        <option value="solled in shop">sold in shop</option>
                    </select>
                    <select name="product-type" id="product-name" required>
                        <option value="" disabled selected>---select product---</option>
                        <option value="bread">bread</option>
                        <option value="cake">cake</option>
                        <option value="cookie">cookie</option>
                        <option value="pastry">pastry</option>
                    </select>
                    <button name="add-sold" type="submit">Add Sold</button>
                </form>

            </div>
        </main>
    </section>
    <script src="./front_end/index.js" type="text/javascript" defer></script>
</body>

</html>