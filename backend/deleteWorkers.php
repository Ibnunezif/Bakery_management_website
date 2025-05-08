<?php
require_once ("connection.php");
require ("report_backend.php");
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
    $resultList=workersData($conn,$bakeryName);
    $_SESSION["workerList"]=$resultList ?? [];

    header("Location:../manager.php");
    exit();



?>