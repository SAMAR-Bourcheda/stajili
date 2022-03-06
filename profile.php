<?php
$msg="";

include "verif.php";
include "etat.php";
$url="http://localhost:5000/update/".strval($_SESSION['id']); 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$state=$_SESSION['state'];
if (isset($_POST["state"])&&(!(empty($_POST["state"])))){
	$state=$_POST["state"];
}
$postdata = "first_name=".$_POST["f_name"]."&last_name=".$_POST["l_name"].'&email='.$_POST["email"]."&keywords=".$_POST["keywords"]."&state=".$state."&token=".$_SESSION["token"]; 

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
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if(strval($httpcode)=="401"){$msg=" <br>Un erreur a passé <br> <br>";}else{
$_SESSION['first_name']=$_POST['f_name'];
	$_SESSION['last_name']=$_POST['l_name'];
	$_SESSION['state']=$state;
	$_SESSION['email']=$_POST['email'];
	$_SESSION['keywords']=$_POST['keywords'];
}

}
//echo json_encode($_SESSION,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

 
<!DOCTYPE html>
	<html>
		<head> 
			<meta charset="utf-8">
	<link rel="stylesheet" href="page3.css"/>
			<title> profile</title> 
		<style>
body {
   
  margin: 0 auto;
  font-family: "Lato", sans-serif;
  background-repeat: no-repeat;
  background-size: 100% 720px;
  background-image: url('background.jpg');
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
</style>
</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="profile.php">Profile</a>
  <a href="recherche.php">Offres</a>
  <a href="changermdp.php">Changer mot de passe</a>
  <a href="logout.php">Deconnexion</a>
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
   
	
		
	<!--Gros div-->
	
	<div id="searchbar">
		<!--<span class="text">Chercher un expert</span>-->
			<center><form action="profile.php" method="post">
			<h2>User: <?php echo $_SESSION["username"];?></h2>
			<!--<label><b>Prenom</b></label>-->
				<input type="text" value="<?php echo $_SESSION["first_name"];?>" placeholder="Entrer votre prenom" name="f_name" required></br>
			<!--<label><b>Nom</b></label>-->
				<input type="text" value="<?php echo $_SESSION["last_name"];?>" placeholder="Entrer votre nom" name="l_name" required></br>
            <!--<label><b>E-mail</b></label>-->
			  <input type="e-mail" value="<?php echo $_SESSION["email"];?>" placeholder="entrer votre e-mail" name="email" required></br>
			<!--<label><b>Keywords</b></label>-->
			  <input type="text" value="<?php echo $_SESSION["keywords"];?>" placeholder="Entrer votre keywords" name="keywords" required></br>
			   
		<label for="etat-select"><b>Etat:<?php echo "   ".$_SESSION["state"]."   ";?></b></label><br>

            <?php echo $etat;?>
            </br>
        <input type="submit" value="Enregistrer" />
		
		
    </form></center>
	</div>
	
	
	
	
	
	
</body>
</html>
