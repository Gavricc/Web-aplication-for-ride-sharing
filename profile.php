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




function getHtml($rides){
    $html="";
    foreach($rides as $ride){
        if($ride['slobodna_mesta'] > 0){
        $html.="<form method='POST' action='?id=" . $ride['id'] . "'>";
        $html.="<div class='ride'>";
        $html.="<h3>" . $ride['polaziste'] . " ➡️ " . $ride['odrediste'] . "</h3>";
        $html.="<p>Vreme polaska: " . $ride['vreme_polaska'] . "</p>";
        $html.="<p>Slobodna mesta: " . $ride['slobodna_mesta'] . "</p>";
        $html.="<p>Cena po osobi: " . $ride['cena_po_osobi'] . " RSD</p>";
        if($ride['opis']){
            $html.="<p>Opis: " . $ride['opis'] . "</p>";
        }
        $html.='<button type="submit"name="reserve">rezervisi</button>';
        $html.="</div>";
        $html.="</form>";
    }
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ProfileStyle.css">
    <title>Glavni Meni </title>
   
</head>
<body>

<div class="container">
        <h2>Dobrodošli <?php echo $_SESSION["user"]["ime"];?> <?php echo $_SESSION["user"]["prezime"];?></h2>
        
    <a href="objavi.php" class="btn btn-publish">➕ Objavi vožnju</a>
    <a href="profile.php?action=logout" class="btn btn-logout">Odjavi se</a>
    </div>
 
    <form method="POST" action="" class ="odakle">
        <div>
            <label for="polaziste">Odakle idete?</label>
            <input type="text" id="polaziste" name="polaziste" required>
        </div>
        <div>
            <label for="odrediste">Dokle idete?</label>
            <input type="text" id="odrediste" name="odrediste" required>
        </div>
        <div>
            <label for="vreme_polaska">Vreme polaska:</label>
            <input type="datetime-local" id="vreme_polaska" name="vreme_polaska" >
        </div>
        <button type="submit"name="search">pretrazi</button>
    </form>


</body>

<?php
$user_id=$_SESSION['user']['id'];
//cookie se koriste da zapamte poslednje birano odrediste i pri sledecem biranju voznji da preporuce korisniku voznje cija je polazna tacka poslednje birano odrediste 
if (isset($_COOKIE[$user_id])){
    if(!isset($_POST['search']) && !isset($_POST['reserve'])){
$from=$_COOKIE[$user_id];
$rides=$d->getRides($from);
if(count($rides)>0){
    $messages[]="Preporučujemo vožnje " . $from;
    echo getHtml($rides);
}
}
}

if(isset($_POST['search'])){
    $from=htmlspecialchars($_POST['polaziste']);
    $to=htmlspecialchars($_POST['odrediste']);
    $_SESSION['from']=$from;
    $_SESSION['to']=$to;
    if(isset($_POST['vreme_polaska'])){
        $time=htmlspecialchars($_POST['vreme_polaska']);
    } else {
        $time=null;
    }
    $rides=$d->getRides($from,$to,$time);
    if(count($rides)==0){
        $messages[]="Nema rezultata pretrage";
    }else {
        $messages[]="Pronađeno " . count($rides) . " rezultata";
    }
    echo getHtml($rides);
}
if(isset($_POST['reserve']) && isset($_GET['id'])){
    $ride_id=htmlspecialchars($_GET['id']);
    if($d->reserveRide($ride_id,$user_id)){
        if(isset($_SESSION['to'])){
             $to=$_SESSION['to'];
            //cookie su postavljeni na 10 dana tako da nema potrebe da ih ikada obrisemo, ali kada bih hteo samo bih uradio setcookie("preporuka", "", time() - 3600);
            setcookie($user_id, $to,time()+(10*24*60*60));
        }
        $driver=$d->getDriverNameByRideId($ride_id);

        echo "Uspešno rezervisano mesto, Vas vozac je ".$driver['ime']." a kontakt telefon je: ".$driver['telefon'];
        } else {
        $errors[]="Greska prilikom rezervacije mesta.";
    }

}
?>
</html>



