<?php
function json_len($arr){
	$count = 0;
    for($i = 0; $i < count($arr); $i++) {
      $count++;
    }
	return $count;
}
session_start();
if (isset($_SESSION['token'])){
}else{
header("location: login.php");	
}
?>