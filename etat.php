<?php
function json_len_etat($arr){
	$count = 0;
    for($i = 0; $i < count($arr); $i++) {
      $count++;
    }
	return $count;
}
$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, 'http://localhost:5000/states'); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_REFERER, 'http://localhost:5000/states'); 

curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
$result = curl_exec ($ch);
$result = json_decode(curl_exec ($ch), true); 

curl_close($ch);
$etat='<select name="state" id="eta-select"><option value="">--Selectionner votre Etat--</option>';
for($i=0;$i<json_len_etat($result);$i++){
	$etat.='<option value="'.$result[$i]["address"].'">'.$result[$i]["address"].'</option>';
	}
$etat.="</select>";
$result=NULL;
$ch=NULL;
$tab="";

?>