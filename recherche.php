<html>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
body {
   
  margin: 0 auto;
  font-family: "Lato", sans-serif;
  background-repeat: no-repeat;
  background-size: 100% 720px;
  background-image: url('background.jpg');
}
</style>
</head>
<body>

<div id="mySidenav" class="sidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<?php
if(!isset($_SESSION["token"])){
echo '  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="profile.php">Profile</a>
  <a href="recherche.php">Offres</a>
  <a href="changermdp.php">Changer mot de passe</a>
  <a href="logout.php">Deconnexion</a>';
}else{
	echo '<a href="login.php">Connexion</a>
  <a href="create.php">Creer compte</a>';
}
?>
</div>

<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
   
    <body><center><font size="2" face="Courier New" >
<table width="100%"><tr><td><b>Organisation</b></td><td><b>Etat</b></td><td><b>Date expiration</b></td><td><b>Description</b></td><td><b>URL</b></td></tr>
<?php
$tab='';
function json_len($arr){
	$count = 0;
    for($i = 0; $i < count($arr); $i++) {
      $count++;
    }
	return $count;
}
$result=[];
session_start();
$etat=[];
if(!(isset($_SESSION["token"]))){
include "etat.php";
}
if(!(isset($_SESSION["token"]))){
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$s=$_POST["state"]; 
$k=$_POST["keywords"]; 
$url="http://localhost:5000/search"; 
$postdata = "state=".$s."&keywords=".$k; 

$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_REFERER, $url); 

curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($ch, CURLOPT_POST, 1); 
$result = curl_exec ($ch); 
$result = json_decode(curl_exec ($ch), true); 
curl_close($ch);}

echo '<center><form method="POST">
          <div>
            <center><input type="text" placeholder="Entrer votre keywords" name="keywords" required></center>
			
            <center><!-- <label for="etat-select">Choose your etat:</label> -->

            '.$etat.'</center><center><button>Rechercher</button></center>
          </div>
        </form></center>';
}else{
$s=$_SESSION["state"]; 
$k=$_SESSION["keywords"]; 
$url="http://localhost:5000/search"; 
$postdata = "state=".$s."&keywords=".$k; 

$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_REFERER, $url); 

curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($ch, CURLOPT_POST, 1); 
$result = curl_exec ($ch); 
$result = json_decode(curl_exec ($ch), true); 
curl_close($ch);
//header('Content-type:application/json;charset=utf-8');
for($i=0;$i<json_len($result);$i++){
	$tab.="<tr><td>".$result[$i]["organisation"]."</td><td>".$result[$i]["address"]."</td><td>".$result[$i]["expiration_date"]."</td><td>".$result[$i]["description"]."</td><td><a href='".$result[$i]["url"]."'>Voir l'offre</a></td></tr>";
}
}
//echo json_encode($result,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

echo $tab;


?>
    </table></font></center>
</html>