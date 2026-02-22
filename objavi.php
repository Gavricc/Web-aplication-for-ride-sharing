<?php
require_once ("db.php");
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
} 
echo "Dobrodošli, " . $_SESSION['user'] ['ime']. "!";

if(isset($_POST['submit'])){
    $polaziste = htmlspecialchars($_POST['polaziste']);
    $odrediste = htmlspecialchars($_POST['odrediste']);
    $vreme_polaska = htmlspecialchars($_POST['vreme_polaska']);
    $slobodna_mesta = htmlspecialchars($_POST['slobodna_mesta']);
    $cena = htmlspecialchars($_POST['cena']);
    $opis = htmlspecialchars($_POST['opis']);
    $user_id = $_SESSION['user']['id'];

    $db = new DataBase();
    if($db->insertRide($polaziste,$odrediste,$vreme_polaska,$slobodna_mesta,$cena,$opis,$user_id)){
        echo "Voznja je uspesno objavljena!";
    } else {
        echo "Greska prilikom objavljivanja voznje.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objavi voznju</title>
</head>
<body>
    <h1>Objavi voznju</h1>
    <form method="POST" action="">
        <div>
            <label for="polaziste">Polaziste:</label>
            <input type="text" id="polaziste" name="polaziste" required>
        </div>
        <div>
            <label for="odrediste">Odrediste:</label>
            <input type="text" id="odrediste" name="odrediste" required>
        </div>
        <div>
            <label for="vreme_polaska">Vreme polaska:</label>
            <input type="datetime-local" id="vreme_polaska" name="vreme_polaska" required>
        </div>
        <div>
            <label for="slobodna_mesta">Slobodna mesta:</label>
            <input type="number" id="slobodna_mesta" name="slobodna_mesta" min="1" required>
        </div>
        <div>
            <label for="cena">Cena:</label>
            <input type="number" id="cena" name="cena" step="100" min="0" required>
        </div>
        <div>
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" rows="5" cols="50"></textarea>
        </div>
        <button type="submit"name="submit">Objavi voznju</button>
    </form>
    <a href="profile.php" class="btn btn-publish"> Pretraga voznji</a>
</body>
</html>