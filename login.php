<?php
$msg="";

session_start();
function json_len($arr){
	$count = 0;
    for($i = 0; $i < count($arr); $i++) {
      $count++;
    }
	return $count;
}
if (($_SERVER['REQUEST_METHOD'] === 'POST')&&(isset($_POST["user"]))&&(!(empty($_POST["user"])))&&(isset($_POST["pass"]))&&(!(empty($_POST["pass"])))) {
$username=$_POST["user"]; 
$password=$_POST["pass"]; 
$url="http://localhost:5000/login"; 
$postdata = "user=".$username."&pass=".$password; 

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
//$result = curl_exec ($ch); 
$result = json_decode(curl_exec ($ch), true); 
curl_close($ch);
//header('Content-type:application/json;charset=utf-8');
if (json_len($result)>0){
	$_SESSION=$result;
	header('location: recherche.php');
}else{
	$msg=" <br>incorrect username/password <br> <br>";
}

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
  <a href="create.php">Creer compte</a>
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
            <!-- zone de connexion -->
            <center><form action="login.php" method="POST">
                <h1>Connexion</h1>
				 <span style="color:red;"> <?php echo $msg; ?></span>
                
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Entrer l'email" name="user" required></br>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="pass" required></br>

                <input type="submit" id='submit' value='LOGIN' ><p class="message">Not registered? 
				<a href="create.php">Create an account</a></p>
               
            </form></center>
        </div>
 

    </body>
</html>