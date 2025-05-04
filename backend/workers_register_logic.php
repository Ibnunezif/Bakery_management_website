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
            

            $workerQuery="SELECT * from users where bakeryName='$bakeryName' and Role='worker'";
            $result=$conn->query($workerQuery);
            $resultList=[];
            while ($row=$result->fetch_assoc()){
                $resultList[]=$row; 
            }
        
            $_SESSION["workerList"]=$resultList ?? [];
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
?>