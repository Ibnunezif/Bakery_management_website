<?php
require_once 'header.html';
session_start();

$errors=[
    'login'=>$_SESSION['login_error']??'',
    'register'=>$_SESSION['register_error']??''
];

function showError($error){
    return !empty($error)?"<p class='error-message'>$error</p>":"";
}

?>
<div class="form-box active" id="Regisistration-form">
        <form action="../backend/workers_register_logic.php"  method="POST">
            <h2>Register worker</h2>
            <?=showError($errors['register']);?>
            <input type="text" id="first-name" name="first-name" placeholder="first name" required>
            <input type="text" id="last-name" name="last-name" placeholder="last name" required>
            <input  id="salary" name="salary" placeholder="salary" type="text" required>
            <input type="email" id="email" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="password" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="confirm password" required>
            <select id="role" name="role" required>
                <option value="" disabled selected>---select role---</option>
                <option value="manager">manager</option>
                <option value="worker">worker</option>
            </select>
            <button type="submit" name="register">Register</button>
            
        </form>
       </div>

<?php
require_once 'footer.html';
?>