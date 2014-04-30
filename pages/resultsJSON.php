<?php
//var_dump($_REQUEST);
//echo "{\"status\":\"success\"}";
if($_GET['latitude']==0 && $_GET['longitude']==0)
{
	echo "{\"gps\":\"failure\"}";
}
else
{
	$lat=$_GET['latitude'];
	$lon=$_GET['longitude'];
	$type=$_GET['type'];
	$whereType=" AND type='".$type."'";
	if($type=="home")
	{
		$whereType="";
	}
	echo "{\"gps\":\"success\",";
	//MySQL setup
	$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
		//die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
		echo "\"mysql\":\"failure\"";
	}
	else 
		echo "\"mysql\":\"success\",";
	$distance=12;
	$query="SELECT *, (acos(sin(RADIANS(".$lat."))*sin(RADIANS(latitude))+cos(RADIANS(".$lat."))*cos(RADIANS(latitude))*cos(RADIANS(longitude) - RADIANS(".$lon.")))*6371) AS kmdist FROM places WHERE acos(sin(RADIANS(".$lat."))*sin(RADIANS(latitude))+cos(RADIANS(".$lat."))*cos(RADIANS(latitude))*cos(RADIANS(longitude) - RADIANS(".$lon.")))*6371 <='".$distance."' ".$whereType." ORDER BY kmdist";
	//echo $query;
	if($result=$mysqli->query($query))
	{
		echo "\"query\":\"success\",";
		echo '"places":[';
		$first=true;
		while($row=$result->fetch_assoc())
		{
			//$place=new place($row['PID'],$row['name'],$row['address1']."<br>".$row['address2']."<br>".$row['city'].", ".$row['stateprov']." ".$row['zip'],"open","12:00-18:00");
			//array_push($placeArray,$place);	
			if($first)
			{
				$first=false;	
			}
			else
			{
				echo ",";	
			}
			echo "{";
			echo '"name":"'.$row['name'].'",';
			echo '"distance":"'.$row['kmdist'].'",';
			echo '"status":"closed",';
			echo '"address1":"'.$row['address1'].'",';
			echo '"address2":"'.$row['address2'].'"';
			echo "}";
		}
		echo ']';
		echo '}';
		$result->free();	
	}	
	else
	{
		echo "\"query\":\"failure\",";
	}
	/*
	echo '"places":[';
	echo "{";
	echo '"name":"Test",';
	echo '"status":"open"';
	echo "},";
	echo "{";
	echo '"name":"Test2",';
	echo '"status":"closed"';
	echo "}";
	echo ']';
	echo "}";
	*/
}
?>