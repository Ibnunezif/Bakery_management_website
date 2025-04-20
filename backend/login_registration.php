<?php
session_start();
require_once "connection.php";

if (isset($_POST['register'])){
    $firstName=$_POST["first-name"];
    $lastName=$_POST["last-name"];
    $bakeryName=$_POST["bakery-name"];
    $userEmail=$_POST["email"];
    $password=password_hash($_POST["password"],PASSWORD_DEFAULT);
    $confirmPassword=$_POST["confirm-password"];
    if (password_verify($confirmPassword,$password)){
            $checkEmail=$conn->query("SELECT email from users where email ='$userEmail'");
            if ($checkEmail->num_rows>0){
                $_SESSION["register_error"]="The email is already registered!";
                $_SESSION['active_form']="register";
            }else{
                $conn->query("INSERT INTO users (firstName,lastName,bakeryName,email,password) values ('$firstName','$lastName','$bakeryName','$userEmail','$password')");
            }
    }else{
         $_SESSION["register_error"]="The confirmation password not match.";
         $_SESSION['active_form']="register";
         header("Location:../front_end/loginandRegistration.php");
    }
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
            $_SESSION['bakery-name']=$db_row['bakeryName'];
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