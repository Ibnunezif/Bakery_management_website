<?php
require_once ("connection.php");
session_start();

    $workerId=$_POST['id'];
    $bakeryName=$_SESSION['bakery-name'];
    $q="SELECT * from users where userId='$workerId' and bakeryName='$bakeryName'";
    $result=$conn->query($q);
    $userData=$result->fetch_assoc();
    $firstName=$userData['firstName'];
    $lastNmae=$userData['lastName'];
    $conn->query("DELETE FROM users WHERE userId='$workerId' AND bakeryName='$bakeryName'");

    $_SESSION['worker-success-message']="You have deleted $firstName $lastNmae successfully!";

    //to show updated report
    $workerQuery="SELECT * from users where bakeryName='$bakeryName' and Role='worker'";
    $result=$conn->query($workerQuery);
    $resultList=[];
    while ($row=$result->fetch_assoc()){
        $resultList[]=$row; 
    }

    $_SESSION["workerList"]=$resultList ?? [];

    header("Location:../manager.php");
    exit();



?>