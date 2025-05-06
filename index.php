<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:./front_end/loginandRegistration.php");
    exit();
}
if ($_SESSION['role']==='manager'){
    header("Location:./manager.php");
    exit();
}
if ($_SESSION['role']==='worker'){
    header("Location:./worker.php");
    exit();
}
?>