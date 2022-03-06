<?php
include "etat.php";
?>
<html>
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
  <a href="recherche.php">Offres</a>
  <a href="login.php">Connexion</a>
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
<center><form action="verification­.php" method="POST">
<h1>Creer un compte</h1>
<label><b>Prenom:</b></label>
<input type="text" placeholder="Entrer votre prenom" name="firt name" required></br>
<label><b>Nom:</b></label>
<input type="text" placeholder="Entrer votre nom" name="last name" required></br>
<label><b>Email:</b></label>
<input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required></br>
<label><b>Mot de passe:</b></label>
<input type="password" placeholder="Entrer le mot de passe" name="password" required></br>
<label><b> Re-ecrire Mot de passe:</b></label>
<input type="password" placeholder="Entrer le mot de passe" name="Re-type password" required></br>

<label><b>Etat:</b></label>
<?php echo $etat;?><br>
<label><b>KeyWords:</b></label>
<input type="text" placeholder="Entrer votre keywords" name="KeyWords" required></br>
<!--<input type="checkbox" checked="checked" name="remember" style="margin-bottom­:15px"> Se rappeler de moi?-->
</label>


<input type="submit" id='submit' value='create' >


</form></center>
</body>
</html>