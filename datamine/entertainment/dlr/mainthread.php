<?php
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
if ($mysqli->connect_error) 
{
   		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

?>