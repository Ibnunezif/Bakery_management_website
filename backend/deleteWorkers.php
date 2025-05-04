<?php
require_once ("connection.php");
session_start();


    $workerId=$_POST['id'];
    $bakeryName=$_SESSION['bakery-name'];
    $conn->query("DELETE FROM users WHERE userId='$workerId' AND bakeryName='$bakeryName'");


    
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