<?php 


class DataBase {

private $hashing_salt = '4545456';
private $conn;
function __construct(){

$host="127.0.0.1";
$port='3307';
$db='blabla_klon';
$user='root';
$pass='';
$charset = 'utf8mb4';
$dsn="mysql:host=$host;port=$port;dbname=$db;charset=$charset";
 $options = [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, ];

try{
$this->conn=new PDO($dsn,$user,$pass,$options);

}catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
}
public function __destruct() {
         $this->conn = null;
    }

function _destruct(){
    $this->conn=null;
    } 
    
function insertUser($name,$surname,$email, $password,  $birthday, $telefon, $registration_date){

 $statement="SELECT * FROM users where email=?";
        $sql=$this->conn->prepare($statement);
        $sql->execute([$email]);

        if($sql->rowCount()>0){
            return false;
        }

        $hashed_password=crypt($password,$this->hashing_salt);
        $statement ="INSERT INTO users (ime,prezime,email,lozinka,birthday,telefon,datum_registracije) VALUES (?,?,?,?,?,?,?)";
        try{
        $sql=$this->conn->prepare($statement);
        $sql->execute([$name,$surname,$email,$hashed_password,$birthday,$telefon,$registration_date]);
        return "true";
        }   catch(PDOException $e){ return die ($e->getMessage()); }
   
}

function checkUser($email,$password){
    
 try{
        $statement="SELECT * FROM users where email=? and lozinka=?";
        $sql=$this->conn->prepare($statement);
        $sql->execute([$email,crypt($password,$this->hashing_salt)]);
        }catch(PDOException $e){ return null; }
        return $sql->fetch();
        
        
    }

function insertRide($polaziste,$odrediste,$vreme_polaska,$slobodna_mesta,$cena,$opis,$user_id){
    $statement="INSERT INTO rides (driver_id,car_id,polaziste,odrediste,vreme_polaska,slobodna_mesta,cena_po_osobi,opis) VALUES (?,?,?,?,?,?,?,?)";
    try{
        $sql=$this->conn->prepare($statement);
        $sql->execute([$user_id,null,$polaziste,$odrediste,$vreme_polaska,$slobodna_mesta,$cena,$opis]);
        return true;
        }   catch(PDOException $e){ return false; }



}

function getRides($from,$to,$time=null){

if($time!=null){
$statement="SELECT * FROM rides where polaziste=? and odrediste=? and DATE(vreme_polaska)>=?";
try{
$sql=$this->conn->prepare($statement);
$sql->execute([$from,$to,$time]);
}catch(PDOException $e){ return []; }
} else {
$statement="SELECT * FROM rides where polaziste=? and odrediste=? and vreme_polaska>=NOW()";
try{
$sql=$this->conn->prepare($statement);
$sql->execute([$from,$to]);
} catch(PDOException $e){ return []; }
}
return $sql->fetchAll();

}

function reserveRide($ride_id,$user_id){
$this->conn->beginTransaction();

try{
    $statement="UPDATE rides SET slobodna_mesta=slobodna_mesta-1 WHERE id=?";
    $sql=$this->conn->prepare($statement);
    $sql->execute([$ride_id]);


    $statement="INSERT INTO bookings (ride_id,passenger_id,broj_mesta,status)   VALUES (?,?,?,?)";
    $sql=$this->conn->prepare($statement);
    $sql->execute([$ride_id,$user_id,1,'pending']);
    $this->conn->commit();
    return true;
    } catch(PDOException $e){
        $this->conn->rollback();
        die($e->getMessage());
    }
}

function getDriverNameByRideId($ride_id){

    $statement = "
        SELECT u.ime, u.telefon
        FROM rides r
        JOIN users u ON r.driver_id = u.id
        WHERE r.id = ?
    ";

    $sql = $this->conn->prepare($statement);
    $sql->execute([$ride_id]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}
}

