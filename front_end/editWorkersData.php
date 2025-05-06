<?php
require_once 'header.html';
session_start();
require ("../backend/connection.php");

$errors=[
    'login'=>$_SESSION['login_error']??'',
    'register'=>$_SESSION['register_error']??''
];

function showError($error){
    return !empty($error)?"<p class='error-message'>$error</p>":"";
}

$workerId = $_GET['workerId'];

$query="SELECT * from users WHERE userId=$workerId";
$row=$conn->query($query);
$workerData=$row->fetch_assoc();

?>
<div class="form-box active" id="Regisistration-form">
        <form action="../backend/workers_register_logic.php"  method="POST">
            <h2>Edit workers data</h2>
            <?=showError($errors['register']);?>
            <input type="hidden" id="id" name="workerId" value="<?=$workerId?>"/>
            <input type="text" id="first-name" name="first-name" placeholder="first name" value="<?=$workerData["firstName"]?>" required>
            <input type="text" id="last-name" name="last-name" placeholder="last name" value="<?=$workerData["lastName"]?>" required>
            <input  id="salary" name="salary" placeholder="salary" type="text" value="<?=$workerData["Salary"]?>" required>
            <input type="email" id="email" name="email" placeholder="email" value="<?=$workerData["email"]?>" required>
            <select id="role" name="role" required>
                <option value="" disabled selected>---select role---</option>
                <option value="manager">manager</option>
                <option value="worker">worker</option>
            </select>
            <button type="submit" name="edit">Edit</button>
            
        </form>
       </div>

<?php
require_once 'footer.html';
?>