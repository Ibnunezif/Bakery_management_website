<?php
include("header.html");
session_start();

$errors=[
    'login'=>$_SESSION['login_error']??'',
    'register'=>$_SESSION['register_error']??''
];

$activeForm=$_SESSION['active_form']??'login';
session_unset();

function showError($error){
    return !empty($error)?"<p class='error-message'>$error</p>":"";
}

function isActiveForm ($formName,$activeForm){
    return $formName === $activeForm? 'active' : '';
}
?>
    <div id="container">
        <div class="form-box <?=isActiveForm('login',$activeForm);?>" id="login-form">
        <form action="../backend/login_registration.php" method="POST">
            <h2>Login</h2>
            <?=showError($errors['login']);?>
            <input type="email" id="email" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="password">
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="#" onclick="showForm('Regisistration-form')">Register here</a></p>
        </form>
       </div>
       <div class="form-box <?=isActiveForm('register',$activeForm);?>" id="Regisistration-form">
        <form action="../backend/login_registration.php"  method="POST">
            <h2>Registration</h2>
            <?=showError($errors['register']);?>
            <input type="text" id="first-name" name="first-name" placeholder="first name" required>
            <input type="text" id="last-name" name="last-name" placeholder="last name" required>
            <input type="text" id="bakery-name" name="bakery-name" placeholder="bakery name" required>
            <input type="email" id="email" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="password" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="confirm password" required>
            <select id="role" name="role" required>
                <option value="" disabled selected>---select role---</option>
                <option value="owner">owner</option>
                <option value="manager">manager</option>
                <option value="worker">worker</option>
            </select>
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login here</a></p>
        </form>
       </div>
    </div>
<?php
include("footer.html");
?>
