<?php
$msg="";

include "verif.php";
$url="http://localhost:5000/reset_password/".strval($_SESSION['id']); 
//echo "<br>".$_POST["password1"]."<br>".$_POST["password2"]."<br>".$_POST["password3"]."<br>";
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$postdata = "token=".$_SESSION["token"]."&old_password=".$_POST["password1"].'&password='.$_POST["password2"]; 
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
if(strval($httpcode)=="401"){$msg=" <br>Un erreur a passé <br> <br>";}else{$_SESSION["password"]=$_POST["password2"];}
}

//echo json_encode($_SESSION,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
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
   
    <div id="container">
	      <center><form action="changermdp.php" method="post">
		    <h1>Changer votre mot de passe</h1>
			   <?php echo $msg;?>
			   <label> <b>Ancien mot de passe:</b></label>
                <input type="text" placeholder="Entrer votre ancien password" value="" name="password1" required></br>
				<label> <b>Nouveau mot de passe:</b></label>
                <input type="text" placeholder="Entrer votre nouveau password" name="password2" required></br>
				<button> changer</button>
		  </form></center>
	  </div> 
	</body>
</html>