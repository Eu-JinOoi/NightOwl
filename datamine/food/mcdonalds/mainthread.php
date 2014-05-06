<?php
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
if ($mysqli->connect_error) 
{
   		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
$url1="http://www1.mcdonalds.com/googleapps/GoogleSearchUSAction.do?method=searchLocation&searchTxtLatlng=(33.8976995%2C%20-117.72560829999998)&actionType=searchRestaurant&language=en&country=us";
$json=file_get_contents($url1);

$data=json_decode($json);
$results=$data->{"results"};
$length=sizeof($results);
for($i=0;$i<$length;$i++)
{
	$name="McDonalds";
	$address1=$results->{"linksMethods"}[3]->{"parameters"}[0];
	$address2="";
	$city=$results->{"linksMethods"}[3]->{"parameters"}[1];
	$state=$results->{"linksMethods"}[3]->{"parameters"}[2];
	$zip=$results->{"linksMethods"}[3]->{"parameters"}[3];
	$country="";
	$latitude=$results->{"latitude"};
	$longitude=$results->{"longitude"};
	$phone=$results->{"linksMethods"}[3]->{"parameters"}[4];
	$open=array_fill(0,7,"00:00:00");
	$close=array_fill(0,7,"00:00:00");
	$type="food";
	$storeno=$results->{"natlStrNumber"};
	$drivethru=0;	
}