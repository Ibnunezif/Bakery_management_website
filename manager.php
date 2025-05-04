<?php
session_start();
$workersList=$_SESSION['workerList'];
if (!isset($_SESSION['email']) || $_SESSION['role']!='manager'){
    header("Location:./index.php");
}
$rollNumber=1;
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
    <div id="message-display-conatiner" onclick='closeDialog()'><div id="message-display"><p>This action delete the worker from the list!</p><button onclick="closeDialog()">cancel</button><button class="ok" onclick="confirmAction()">ok</button></div></div>
    <section id="content-section">
        <aside class="">
            <button class="side-bar-card active-effect" id="dashboard-button" onclick="showMain('dashboard')" draggable="true"><span class="material-icons">dashboard</span> Dashboard</button>
            <button class="side-bar-card" id="product-button" onclick="showMain('product')" draggable="true"><span class="material-icons">lunch_dining</span>Add Product</button>
            <button class="side-bar-card" id="solled-button" onclick="showMain('solled')" draggable="true"><span class="material-icons">shopping_basket</span>Add Sold</button>
            <button class="side-bar-card" id="manage-workers-button" onclick="showMain('manage-workers')"  draggable="true"><span class="material-icons">groups</span>workers</button>
            <button class="side-bar-card" id="report-button" onclick="showMain('report')" draggable="true" ><span class="material-icons">analytics</span> Report</button>
        </aside>
        <main>
            <div id="dashboard" class="main-card show">
                <h1>Dashboard</h1>
                <p>Welcome to the dashboard!</p>
                <div class="dashboard-grid">
                    <!-- Add Product Section -->
                    <div class="dashboard-card">
                        <span class="material-icons">lunch_dining</span>
                    
                        <h2>Add Product</h2>
                        <button onclick="showMain('product')">Go to Add Sold Items</button>
                    </div>
                    <!-- Add Sold Section -->
                    <div class="dashboard-card">
                        <span class="material-icons">shopping_basket</span>
                        <h2>Add Sold</h2>
                        <button onclick="showMain('solled')">Go to Add Sold Items</button>
                    </div>
                    <!-- workers section -->
                    <div class="dashboard-card">
                    <span class="material-icons">groups</span>
                        <h2>workers</h2>
                        <ul>
                            <li>total workers <?=count($workersList)?></li>
                            <li>total product <?=array_sum(array_column($workersList, 'totalProduct'))?></li>
                        </ul>
                        <button onclick="showMain('manage-workers')">Go to Add Sold Items</button>
                    </div>

                    <!-- report section -->
                    <div class="dashboard-card">
                        <span class="material-icons">analytics</span>
                        <h2>Report</h2>
                        <button onclick="showMain('report')">Go to Report</button>  
                    </div>

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
            <div id="delivered" class="main-card">
                <h1>Delivered</h1>
                <p>Check your delivered items here.</p>
            </div>
            <div id="manage-workers" class="main-card">
                <h1>mange workers </h1>
            <div class="table-container">
                <table class="worker-table">
                    <thead>
                        <tr>
                        <th>R.no</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>salary</th>
                        <th>total product</th>
                        <th>total sold</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($workersList as $worker): ?>
                        <tr>
                            <td><?=$rollNumber?></td>
                            <td><?= $worker["firstName"] ?></td>
                            <td><?= $worker["lastName"] ?></td>
                            <td><?= $worker["email"] ?></td>
                            <td><?= $worker["Salary"] ?? 0 ?></td>
                            <td><?= $worker["totalProduct"] ?? 0 ?></td>
                            <td><?= $worker["totalSold"] ?? 0 ?></td>
                            <td><?= substr($worker["regDate"],0,10) ?></td>
                            <td>
                                <button onclick="showDialog(<?= $worker['userId']?>)">delete</button>
                                <button onclick="window.location.href='./front_end/editWorkersData.php?workerId=<?=$worker['userId']?>'">edit</button>
                            </td>
                        </tr>
                        <?$rollNumber+=1?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="add-wokers"><button onclick="window.location.href='./front_end/workerRegistrationForm.php'" class="worker-button">+</button> <p id="worker-parag">Add new workers</p> </div>
            </div>
                    
            </div>
            <div id="purchased" class="main-card">
                <h1>purchased</h1>
    
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