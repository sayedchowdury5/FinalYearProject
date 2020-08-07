<?php
class dht11{
 public $link='';
 function __construct($device, $temperature, $humidity, $photocell){
  $this->connect();
  $this->storeInDB($device, $temperature, $humidity, $photocell);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','id14314173_fypsayed','#AbuSayed59395') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'id14314173_sayedfyp') or die('Cannot select the DB');
 }
 
 function storeInDB($device, $temperature, $humidity, $photocell){
  $query = "insert into sayed_IoT set device='".$device."', 
  humidity='".$humidity."', temperature='".$temperature."', photocell='".$photocell."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
//if($_GET['temperature'] != '' and  $_GET['humidity'] != ''){
// $dht11=new dht11($_GET['device'],0,0, $_GET['photocell']);
 $dht11=new dht11($_GET['device'],$_GET['temperature'],$_GET['humidity'], $_GET['photocell']);
//}
?>
