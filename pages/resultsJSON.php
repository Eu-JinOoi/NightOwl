<?php
//var_dump($_REQUEST);
//echo "{\"status\":\"success\"}";
if($_GET['latitude']==0 && $_GET['longitude']==0)
	echo "{\"gps\":\"failure\"}";
else
	echo "{\"gps\":\"success\"}";

$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
if ($mysqli->connect_error) 
{
	die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

?>