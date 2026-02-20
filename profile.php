<?php
require_once("db.php");

$d=new DataBase();

session_start();

$errors=[];
$messages=[];

if(!isset($_SESSION["user"])){
    header( "Location: login.php" );
    exit();
}
if(isset($_GET['action']) && $_GET['action']=="logout"){
    session_destroy();
    header( "Location: login.php" );
    exit();
}

?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ProfileStyle.css">
    <title>Glavni Meni - BlaBlaKlon</title>
   
</head>
<body>

    <div class="container">
        <h2>Dobrodošli <?php echo $_SESSION["user"]["ime"];?> <?php echo $_SESSION["user"]["prezime"];?></h2>
        
       <a href="izaberi.php" class="btn btn-search">🔍 Izaberi vožnju</a>
    <a href="objavi.php" class="btn btn-publish">➕ Objavi vožnju</a>
    <a href="profile.php?action=logout" class="btn btn-logout">Odjavi se</a>
    </div>

</body>
</html>



