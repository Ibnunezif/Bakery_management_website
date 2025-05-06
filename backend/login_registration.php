<?php
session_start();
require_once "connection.php";
require("report_backend.php");

if (isset($_POST['register'])){
    $firstName=$_POST["first-name"];
    $lastName=$_POST["last-name"];
    $bakeryName=$_POST["bakery-name"];
    $userEmail=$_POST["email"];
    $role=$_POST["role"];
    $password=password_hash($_POST["password"],PASSWORD_DEFAULT);
    $confirmPassword=$_POST["confirm-password"];
    if (password_verify($confirmPassword,$password)){
            $checkEmail=$conn->query("SELECT email from users where email ='$userEmail'");
            if ($checkEmail->num_rows>0){
                $_SESSION["register_error"]="The email is already registered!";
                $_SESSION['active_form']="register";      
            }else{
                $conn->query("INSERT INTO users (firstName,lastName,bakeryName,email,password,role) values ('$firstName','$lastName','$bakeryName','$userEmail','$password','$role')");
            }
    }else{
         $_SESSION["register_error"]="The confirmation password is not match.";
         $_SESSION['active_form']="register";   
    }
    header("Location:../front_end/loginandRegistration.php");
    exit();
}

if (isset($_POST["login"])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $db_result=$conn->query("SELECT * from users WHERE email = '$email' ");
    if ($db_result->num_rows>0){
        $db_row=$db_result->fetch_assoc();
        if (password_verify($password,$db_row['password'])){
            $_SESSION['fist-name']=$db_row['firstName'];
            $_SESSION['last-name']=$db_row['lastName'];
            $_SESSION['email']=$db_row['email'];
            $_SESSION['registrationDate']=$db_row['regDate'];
            $_SESSION['bakery-name']=$db_row['bakeryName'];
            $_SESSION['role']=$db_row['Role'];
            $_SESSION['userId']=$db_row['userId'];

            $_SESSION['login-success-message'] = "Welcome back, " . $db_row['firstName'] . "!";
            


    //if role is manager we are going to fetch all worker data from the database
           
if ($db_row['Role'] == 'manager') {
    $bakeryName = $_SESSION["bakery-name"];

    // SQL query to fetch worker details along with total products and sales
    $workerQuery = "
        SELECT 
            users.userId,
            users.firstName,
            users.lastName,
            users.email,
            users.Salary,
            users.regDate,
            COALESCE(SUM(product.quantity), 0) AS totalProduct,
            COALESCE(SUM(sales.soldQuantity), 0) AS totalSold
        FROM 
            users
        LEFT JOIN 
            product ON users.userId = product.userId
        LEFT JOIN 
            sales ON users.userId = sales.userId
        WHERE 
            users.bakeryName = ? AND users.Role = 'worker'
        GROUP BY 
            users.userId, users.firstName, users.lastName, users.email, users.Salary, users.regDate
    ";

    $stmt = $conn->prepare($workerQuery);
    $stmt->bind_param("s", $bakeryName);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultList = [];
    while ($row = $result->fetch_assoc()) {
        $resultList[] = $row;
    }

    $_SESSION["workerList"] = $resultList ?? [];

 
// Fetch product and sales data for the bakery
$data = soldProductReport($bakeryName,$conn);
$monthlyRevenue = monthlyRevenueReport($bakeryName,$conn);

$_SESSION["monthlyRevenue"] = $monthlyRevenue;
$_SESSION["chart-data"]=$data;


}

            //if role is worker we are going to fetch the product and sales data from the database
            if ($db_row['Role']=='worker'){
            $userId=$db_row['userId'];
            $queryForsales="SELECT * from sales where userId= $userId";
            $queryForProd="SELECT * FROM product where userId= $userId";


            $prodResult=$conn->query($queryForProd);
            $salesResult=$conn->query($queryForsales);

            $quantity=0;
            $prodCost=0;
            $soldQuantity=0;
            $soldCost=0;
            while ($row=$prodResult->fetch_assoc()){
                $quantity+=$row["quantity"];
                $prodCost+=$row["unitCost"]*$row["quantity"];
            }

            while ($row=$salesResult->fetch_assoc()){
                $soldQuantity+=$row["soldQuantity"];
                $soldCost+=$row["salePrice"]*$row["soldQuantity"];
            }

            $_SESSION['soldQuantity']=$soldQuantity;
            $_SESSION['soldPrice']=$soldCost;
            $_SESSION['unitCost']=$prodCost;
            $_SESSION['quantity']=$quantity;
            }
            

            header("Location:../index.php");
            exit();
        }
    }
    $_SESSION['login_error']='Incorrect email or password';
    $_SESSION['active_form']='login';
    header("Location:../front_end/loginandRegistration.php");
    exit();
}
?>