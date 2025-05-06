<?php
session_start();
require_once ("connection.php");
if (isset($_POST['register'])){
$firstName=$_POST["first-name"];
$lastName=$_POST["last-name"];
$bakeryName=$_SESSION['bakery-name'];
$userEmail=$_POST["email"];
$role=$_POST["role"];
$salary=$_POST["salary"];
$password=password_hash($_POST["password"],PASSWORD_DEFAULT);
$confirmPassword=$_POST["confirm-password"];

if (password_verify($confirmPassword,$password)){
        $checkEmail=$conn->query("SELECT email from users where email ='$userEmail'");
        if ($checkEmail->num_rows>0){
            $_SESSION["register_error"]="The email is already registered!";
             
            header("Location:../front_end/workerRegistrationForm.php");
            exit();     
        }else{
            $conn->query("INSERT INTO users (firstName,lastName,bakeryName,email,password,salary,role) values ('$firstName','$lastName','$bakeryName','$userEmail','$password','$salary','$role')");
            

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
            
            
            header("Location:../index.php");
            exit();
        }
}else{
     $_SESSION["register_error"]="The confirmation password is not match.";
     
     header("Location:../front_end/workerRegistrationForm.php");  
     exit();  
}

}

if (isset($_POST['edit'])){
    $firstName=$_POST["first-name"];
    $lastName=$_POST["last-name"];
    $userEmail=$_POST["email"];
    $role=$_POST["role"];
    $salary=$_POST["salary"];
    $workerId=$_POST['workerId'];

    $query="UPDATE users SET firstName='$firstName', lastName='$lastName', email='$userEmail', role='$role', salary='$salary' WHERE userId='$workerId'";
try{
    $conn->query($query);
    $bekaryName=$_SESSION["bakery-name"];
    $workerQuery="SELECT * from users where bakeryName='$bekaryName' and Role='worker'";
    

    $result=$conn->query($workerQuery);
    $resultList=[];
    while ($row=$result->fetch_assoc()){
        $resultList[]=$row; 
    }

    $_SESSION["workerList"]=$resultList ?? [];

    header("Location:../index.php");
    exit();
  }
    catch (Exception $e){
        $_SESSION['register_error']="Can't edit worker data!";
        header("Location:../front_end/editWorkersData.php?workerId=$workerId");
        exit();
    }
    
}

//eddition users profile data 
if (isset($_POST['profile-edit'])){
    $userId=$_SESSION['userId'];

    
    $row=$conn->query("SELECT * from users WHERE userId=$userId");
    $userData=$row->fetch_assoc();

    $userEmail=$userData['email'];
    $userPassword=$userData['password'];
    $userFirstName=$userData['firstName'];
    $userLastName=$userData['lastName'];


    $firstName=!empty($_POST["user-first-name"])?$_POST["user-first-name"]:$userFirstName;
    $lastName=!empty($_POST["user-last-name"])?$_POST["user-last-name"]:$userLastName; 
    $userEmail=!empty($_POST["user-email"])?$_POST["user-email"]:$userEmail;
    $password=!empty($_POST["user-password"])?$_POST["user-password"]:$userPassword;
    $hashedPassword=password_hash($password,PASSWORD_DEFAULT);
    $query="UPDATE users SET firstName='$firstName', lastName='$lastName', email='$userEmail',password='$hashedPassword' WHERE userId=$userId";
    try{
        $conn->query($query);
        $_SESSION['fist-name']=$firstName;
        $_SESSION['last-name']=$lastName;
        $_SESSION['email']=$userEmail;
        header("Location:../index.php");
        exit();
    }catch (Exception $e){
        $_SESSION['profile_edit_error']="Can't edit your data!";
        header("Location:../front_end/editProfile.php");
        exit();
    }
}
?>