<?php
require ("connection.php");
session_start();
if (!isset($_SESSION['email'])){
    header("Location:../front_end/loginandRegistration.php");
    exit();
}

if (isset($_POST["add-product"])){
    $role = $_SESSION["role"];
    $user_id = $_SESSION["userId"];
    $product_name = $_POST["product-type"];
    $product_price = $_POST["unit-price"];
    $product_quantity = $_POST["product-quantity"];
    
    $sql = "INSERT INTO product (productType, unitCost, quantity, userId) VALUES ('$product_name', '$product_price', '$product_quantity', ' $user_id')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["message"] = "New product added successfully";
        $_SESSION["product_name"] =  $product_name;
        header("Location: ../$role.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST["add-sold"])){
    $role = $_SESSION["role"];
    $user_id = $_SESSION["userId"];
    $sold_quantity = $_POST["sold-quantity"];
    $sold_price = $_POST["sale-price"];
    $outline=$_POST["outline"];
    $product_name = $_POST["product-type"];

    
    
    $sql = "INSERT INTO sales (userId,soldQuantity, salePrice,outline,productName) VALUES ('$user_id', '$sold_quantity', '$sold_price', ' $outline' ,'$product_name')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["message"] = "sold product added successfully";
        $_SESSION["product_name"] =  $product_name;
        header("Location: ../$role.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}   

?>