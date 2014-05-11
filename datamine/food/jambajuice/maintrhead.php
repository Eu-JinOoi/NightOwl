<?php
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
    		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
	}
	$url1="http://www.jambajuice.com/storeselector.aspx?lat=33.8976995&long=-117.72560829999998";
	//$url1="http://www.buffalowildwings.com/services/FetchStoresByLatLng.aspx?zip=92887&latLng%5B%5D=33.8976995&latLng%5B%5D=-117.72560829999998&lat=33.8976995&lng=-117.72560829999998&radius=10";
	$jsondata=file_get_contents($url1);
	$json=json_decode($jsondata,true);
	
	//var_dump($json);
	foreach($json as $store)
	{
		$name="Jamba Juice";
		$subname=$store["storeName"];
		$address1=$store["streetAddress"];
		$address2=$store["streetAddress2"];
		$city=$store["city"];
		$state=$store["state"];
		$zip=$store["postalCode"];
		$country="US";
		$latitude=$store["position"]["latitude"];
		$longitude=$store["position"]["longitude"];
		$phone=$store["PhoneNumber"];
		$open=$hours["open"];
		$close=$hours["close"];
		$type="food";
		$storeno=$store["Store_Id"];
		$drivethru=0;
		$wifi=0;
		$hours_unknown=$hours["unknown"];
		/*
		*
		*****************************NEED TO ADD IS 24 hour field to database
		*****************************NEED TO ADD Has ALcholol
		*****************************"          " 18+
		*****************************"          " 21+
		*
		*/
		
		echo "<br>".$name;
		echo "<br>".$subname;
		echo "<br>Address1: ".$address1;
		echo "<br>Address2: ".$address2;
		echo "<br>City: ".$city;
		echo "<br>State: ".$state;
		echo "<br>Zip: ".$zip;
		echo "<br>Country: ".$country;
		echo "<br>Lat: ".$latitude;
		echo "<br>Long: ".$longitude;
		echo "<br>Phone: ".$phone;
		echo "<br>Open Hours: "; var_dump($open);
		echo "<br>Close Hours: "; var_dump($close);
		echo "<br>Type: ".$type="food";
		echo "<br>Store Number: ".$storeno;
		echo "<br>Drive Thru: ".$drivethru;
		echo "<br>Wifi: ".$wifi;
		echo "<br>Hours Unknown: ".$hours_unknown;
		
		echo "<hr>";
		echo "<br><br>";	
	}
	//echo sizeof($json->{"Markers"});
	
?>