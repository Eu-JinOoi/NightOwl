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
		$phone=str_replace(".","-",$store["phoneNumber"]);
		$open=$hours["open"];
		$close=$hours["close"];
		$type="food";
		$storeno=$store["Store_Id"];
		$drivethru=0;
		$wifi=0;
		$plus18=0;
		$plus21=0;
		$alcohol=0;
		$hours_unknown=0;
		$hours_closed=0;
		$hours_24=0;

		
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
		
		$hash=sha1($address1.$address2.$city.$state.$country.$zip);
		$query="INSERT INTO placesPending VALUES(NULL,'".$hash."','".$name."','".$subname."','".$storeno."','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."','".$phone."','".$latitude."','".$longitude."','".$type."','".$drivethru."','".$wifi."','".$plus18."','".$plus21."','".$alcohol."','-8','1','".$hours_unknown."','".$hours_closed."','".$hours_24."','".$open[0]."','".$close[0]."','".$open[1]."','".$close[1]."','".$open[2]."','".$close[2]."','".$open[3]."','".$close[3]."','".$open[4]."','".$close[4]."','".$open[5]."','".$close[5]."','".$open[6]."','".$close[6]."')";
		if($res=$mysqli->query($query))
		{
			echo "SUCCESS!<br>";		
		}
		else
		{
			echo "NEED TO UPDATE:".$mysqli->error."<br>";	
		}
	}
	//echo sizeof($json->{"Markers"});
	
?>