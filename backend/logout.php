<?php
session_start();
session_unset();
session_destroy();
header('Location:../front_end/loginandRegistration.php');
exit();
?>