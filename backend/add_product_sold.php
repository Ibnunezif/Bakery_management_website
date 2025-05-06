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

        $bakeryName=$_SESSION["bakery-name"];
        //to show updated report
        $query = "
        SELECT 
            product.productType AS productType,
            COALESCE(SUM(product.quantity), 0) AS totalProduced,
            COALESCE(SUM(sales.soldQuantity), 0) AS totalSold
        FROM 
            product
        LEFT JOIN 
            sales ON product.productType = sales.productName
        WHERE 
            product.userId IN (SELECT userId FROM users WHERE bakeryName = ?)
        GROUP BY 
            product.productType
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bakeryName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    $_SESSION["chart-data"]=$data;


        //to show the updated product data on the dashboard
        if ($role=='worker'){
            $queryForProd="SELECT * FROM product where userId= $user_id";

            
            $prodResult=$conn->query($queryForProd);
        
            $quantity=0;
            $prodCost=0;
            $soldQuantity=0;
            $soldCost=0;
            while ($row=$prodResult->fetch_assoc()){
                $quantity+=$row["quantity"];
                $prodCost+=$row["unitCost"]*$row["quantity"];
            }

            $_SESSION['unitCost']=$prodCost;
            $_SESSION['quantity']=$quantity;
        }

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
    $bakeryName=$_SESSION["bakery-name"];

    
    // Check if the product exists in the database
    $chechSql="SELECT COALESCE(SUM(product.quantity), 0) AS totalProductProduced FROM product JOIN users ON product.userId = users.userId WHERE users.bakeryName = '$bakeryName' AND product.productType = '$product_name'";
    $checkResult=$conn->query($chechSql);
    $checkRow=$checkResult->fetch_assoc();
    $totalProductProduced=$checkRow["totalProductProduced"];
    if ($totalProductProduced<$sold_quantity){
        $_SESSION["sold_error"] = "The sold quantity is greater than the produced quantity.";
        header("Location: ../$role.php");
        exit();
    }else{
    $sql = "INSERT INTO sales (userId,soldQuantity, salePrice,outline,productName) VALUES ('$user_id', '$sold_quantity', '$sold_price', ' $outline' ,'$product_name')";


    if ($conn->query($sql) === TRUE) {
        $_SESSION["sold_success"] = "sold product added successfully";

        //to show updated report
        $query = "
        SELECT 
            product.productType AS productType,
            COALESCE(SUM(product.quantity), 0) AS totalProduced,
            COALESCE(SUM(sales.soldQuantity), 0) AS totalSold
        FROM 
            product
        LEFT JOIN 
            sales ON product.productType = sales.productName
        WHERE 
            product.userId IN (SELECT userId FROM users WHERE bakeryName = ?)
        GROUP BY 
            product.productType
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bakeryName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    $_SESSION["chart-data"]=$data;

        // to show the update sold data on the dashboard
        $queryForsales="SELECT * from sales where userId= $user_id";

            
            $salesResult=$conn->query($queryForsales);

    
            $soldQuantity=0;
            $soldCost=0;
         

            while ($row=$salesResult->fetch_assoc()){
                $soldQuantity+=$row["soldQuantity"];
                $soldCost+=$row["salePrice"]*$row["soldQuantity"];
            }

            $_SESSION['soldQuantity']=$soldQuantity;
            $_SESSION['soldPrice']=$soldCost;
        header("Location: ../$role.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}   

?>