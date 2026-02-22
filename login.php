<?php
 require_once("db.php");
    $d = new DataBase();
    $errors = [];
    session_start();


    if (isset($_POST['Login'])){
    $user=$d->checkUser($_POST['email'],$_POST['password']);
    if($user){
        $_SESSION['user']=$user;
        header( "Location: profile.php" );
        exit();    
    }
    
    }

$name = $surname = $email = $password = $confirm_password = $birthday = $telefon = "";

if (isset($_POST["Register"])) {
      
if(isset($_POST["name"])){
$name=htmlspecialchars($_POST["name"]);
$niz=explode(" ",$name);
if(count($niz)<2){
    $errors[]="Morate uneti ime i prezime";
}else {
    $name=$niz[0];
    $surname=$niz[1];
}
}
if (isset($_POST["email"])){
$email=htmlspecialchars($_POST["email"]);}

if (isset($_POST["password"])){
$password=htmlspecialchars($_POST["password"]);}

if (isset($_POST["confirm_password"])){
$confirm_password=htmlspecialchars($_POST["confirm_password"]);}

if (isset($_POST["birthday"])){
$birthday=htmlspecialchars($_POST["birthday"]);}

if (isset($_POST["number"])){
$telefon=htmlspecialchars($_POST["number"]);}


if (!$name) {
$errors['name']="Unesite ime i prezime";
}
if (!$email) {
$errors[]="Unesite email";
}
if (!$password) {
$errors[]="Unesite lozinku";
}
if ($password != $confirm_password) {
$errors['lozinke']="Lozinke se ne poklapaju";
}
if (!$birthday) {
$errors[]="Unesite datum rođenja";
}
if (!$telefon) {
$errors[]="Unesite broj telefona";
}
$success=false;
if (empty($errors)) {
$success = $d->insertUser($name, $surname, $email, $password, $birthday, $telefon, date("Y-m-d"));
}
if ($success){
echo "Uspešno ste se registrovali";
}else {echo "Registracija nije uspela";}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        
        <div class="tabs">
            <button class="tab-btn active" onclick="switchForm('login')">Login</button>
            <button class="tab-btn" onclick="switchForm('register')">Register</button>
        </div>

        <form id="login"   class="form-section active" method="POST">
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required>
            </div>
            <button type="submit"name= "Login">Login</button>
        </form>

        <form id="register" class="form-section" method="POST">
            <div class="form-group">
                <label for="register-name">Full Name</label>
                
                <input type="text" id="register-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="register-number">Mobile Number</label>
                <input type="text" id="register-number" name="number" required>
            </div>
            <div class="form-group">
                <label for="register-birthday">Birthday</label>
                <input type="date" id="register-birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" name="password" required>
            </div>
            <div class="form-group">
                <label for="register-confirm">Confirm Password</label>
                
                <input type="password" id="register-confirm" name="confirm_password" required>
            </div>
            <button type="submit" name="Register">Register</button>
        </form>
    </div>

    <script>
        function switchForm(form) {
            document.querySelectorAll('.form-section').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            document.getElementById(form).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>