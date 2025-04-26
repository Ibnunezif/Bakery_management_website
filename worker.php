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
    <h1><?= $_SESSION['fist-name'] ?>! Dashboard</h1>
    <div class="dashboard-grid">
        <!-- Add Product Section -->
        <div class="dashboard-card">
            <span class="material-icons">lunch_dining</span>
            <h2>Add Product</h2>
            
            <button onclick="showMain('product')">Go to Add Product</button>
        </div>

        <!-- Add Sold Items Section -->
        <div class="dashboard-card">
            <span class="material-icons">shopping_basket</span>
            <h2>Add Sold Items</h2>
            
            <button onclick="showMain('solled')">Go to Add Sold Items</button>
        </div>

        <!-- Add Purchased Ingredients Section -->
        <div class="dashboard-card">
            <span class="material-icons">fastfood</span>
            <h2>Add Ingredients</h2>
            <button onclick="showMain('purchased')">Go to Add Ingredients</button>
        </div>
    </div>
</div>
            <div id="product" class="main-card">
                <h1>Add Product</h1>
                 <form class='main-card-forms' method='post' action=''>
                    <input type=hidden id="user-id" name="user-id" value="<?=$_SESSION['userId']?>" required>
                    <input type="text" id="product-quantity" name="product-quantity" placeholder="product quantity" required>
                    <select name="product-type" id="product-name" required>
                        <option value="" disabled selected>---select product---</option>
                        <option value="bread">bread</option>
                        <option value="cake">cake</option>
                        <option value="cookie">cookie</option>
                        <option value="pastry">pastry</option>
                    </select>
                    <input type="text" id="unit-price" name="unit-price" placeholder="unit price" required>
                    <button type="submit">Add Product</button>
                </form>
        

            </div>
            <div id="solled" class="main-card">
                <h1> Add Sold Items</h1>
                <form class='main-card-forms' method='post' action=''>
                    <input type=hidden id="user-id" name="user-id" value="<?=$_SESSION['userId']?>" required>
                    <input type="text" id="sold-quantity" name="sold-quantity" placeholder="sold quantity" required>
                    <input type="text" id="sale-price" name="sale-price" placeholder="unit sale price" required>
                    <select name="outline" id="outline" required>
                        <option value="" disabled selected>---select outline---</option>
                        <option value="delivered">delivered</option>
                        <option value="solled in shop">sold in shop</option>
                    </select>
                    <input type="text" id="product-id" name="product-id" placeholder="product id" required>
                    <select name="product-type" id="product-name" required>
                        <option value="" disabled selected>---select product---</option>
                        <option value="bread">bread</option>
                        <option value="cake">cake</option>
                        <option value="cookie">cookie</option>
                        <option value="pastry">pastry</option>
                    </select>
                    <button type="submit">Add Sold</button>
                </form>

            </div>
            <div id="purchased" class="main-card">
                <h1>Add purchased ingredient</h1>
                <form  class='main-card-forms' method='post' action='' action="" method="POST">
                    <input type=hidden id="user-id" name="user-id" value="<?=$_SESSION['userId']?>" required>
                    <input type="text" id="ingredient-quantity" name="ingredient-quantity" placeholder="ingredient quantity" required>
                    <input type="text" id="cost-per-unit" name="cost-per-unit" placeholder="cost per unit" required>
                    <select name="ingredient-name" id="ingredient-name" required>
                        <option value="" disabled selected>---select ingredient---</option>
                        <option value="flour">flour</option>
                        <option value="sugar">sugar</option>
                        <option value="egg">egg</option>
                        <option value="milk">milk</option>
                        <option value="yeast">yeast</option>
                        <option value="butter">butter</option>
                        <option value="salt">salt</option>
                        <option value="baking powder">baking powder</option>
                        <option value="vanilla extract">vanilla extract</option>
                        <option value="chocolate">chocolate</option>
                        <option value="cream">cream</option>
                        <option value="fruit">fruit</option>
                        <option value="nuts">nuts</option>
                        <option value="spices">spices</option>
                        <option value="food coloring">food coloring</option>
                        <option value="glazing">glazing</option>
                        <option value="frosting">frosting</option>
                        <option value="toppings">toppings</option>
                        <option value="packaging">packaging</option>
                        <option value="preservatives">preservatives</option>
                        <option value="flavoring">flavoring</option>
                        <option value="sweeteners">sweeteners</option>
                        <option value="thickeners">thickeners</option>
                        <option value="emulsifiers">emulsifiers</option>
                        <option value="stabilizers">stabilizers</option>
                        <option value="acidulants">acidulants</option>
                        <option value="leavening agents">leavening agents</option>
                        <option value="dough conditioners">dough conditioners</option>
                        <option value="flour enhancers">flour enhancers</option>
                        <option value="baking soda">baking soda</option>
                        <option value="baking powder">baking powder</option>
                        <option value="cornstarch">cornstarch</option>
                        <option value="gelatin">gelatin</option>
                        <option value="pectin">pectin</option>
                        <option value="agar-agar">agar-agar</option>
                        <option value="xanthan gum">xanthan gum</option>
                        <option value="guar gum">guar gum</option>
                        <option value="cocoa powder">cocoa powder</option>
                        <option value="powdered sugar">powdered sugar</option>
                        <option value="brown sugar">brown sugar</option>
                        <option value="granulated sugar">granulated sugar</option>
                        <option value="confectioners' sugar">confectioners' sugar</option>
                        <option value="honey">honey</option>
                        <option value="maple syrup">maple syrup</option>
                        <option value="agave syrup">agave syrup</option>
                        <option value="molasses">molasses</option>

                        <option value="other">other</option>
                    </select>
                    <button type="submit">Add Ingredient</button>
                </form>
    
            </div>
        </main>
    </section>
    <script src="./front_end/index.js" type="text/javascript" defer></script>
</body>

</html>