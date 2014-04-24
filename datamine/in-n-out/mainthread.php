<?php
	$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
    		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
	}
	$url1="http://hosted.where2getit.com/innout/newdesign/ajax?&xml_request=%3Crequest%3E%3Cappkey%3E409AAB8A-E1C4-11DD-9152-B8EE3B999D57%3C%2Fappkey%3E%3Cformdata+id%3D%22locatorsearch%22%3E%3Cdataview%3Estore_default%3C%2Fdataview%3E%3Cgeolocs%3E%3Cgeoloc%3E%3Caddressline%3E";
	$url2="%3C%2Faddressline%3E%3Clongitude%3E%3C%2Flongitude%3E%3Clatitude%3E%3C%2Flatitude%3E%3C%2Fgeoloc%3E%3C%2Fgeolocs%3E%3Csearchradius%3E15%7C25%7C50%7C100%7C250%3C%2Fsearchradius%3E%3C%2Fformdata%3E%3C%2Frequest%3E";
	/*for($i=90000;$i<96162;$i++)
	{
			
	}*/
	$zip=92887;
	$url=$url1.$zip.$url2;
	$xml=file_get_contents($url);
	
	$st=array('<response code="1">',"</response>");
	$xml=str_replace($st,"",$xml);
	$elem = new SimpleXMLElement($xml);
	//echo $xml;
	foreach ($elem as $poi) 
	{
    	//printf("%s has got %d children.\n", $poi['name'], $poi->count());
		$name="In-N-Out ";
		$address1="";
		$address2="";
		$city="";
		$state="";
		$zip="";
		$country="";
		$latitude="";
		$longitude="";
		$phone="";
		$type="restaurant_fastfood";
		
		foreach($poi as $epoi)
		{
			echo $epoi->getName().":".$epoi."<br>";
			if($epoi->getName()=="name")
				$name.=$epoi;
			else if($epoi->getName()=="address1")
				$address1=$epoi;
			else if($epoi->getName()=="address2")
				$address2=$epoi;
			else if($epoi->getName()=="city")
				$city=$epoi;
			else if($epoi->getName()=="state")
				$state=$epoi;
			else if($epoi->getName()=="country")
				$country=$epoi;
			else if($epoi->getName()=="latitude")
				$latitude=$epoi;
			else if($epoi->getName()=="longitude")
				$longitude=$epoi;
			else if($epoi->getName()=="phone")
				$phone=$epoi;
			else if($epoi->getName()=="postalcode")
				$zip=$epoi;
		}
		$query="INSERT INTO places VALUES(NULL,'".$name."','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."','".$phone."','".$latitude."','".$longitude."','".$type."')";
		if($res=$mysqli->query($query))
		{
				
		}
		/*var_dump($poi);
		echo $poi["name"];*/
		echo "<br><br><br>";
	}
	
	$mysqli->close();
?>