<?php
	$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
    		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
	}
	$url1="http://hosted.where2getit.com/chickfila/newdesign/ajax?&xml_request=%3Crequest%3E%3Cappkey%3E3309B8E6-38D2-315F-A06C-9D7F6129150F%3C%2Fappkey%3E%3Cformdata+id%3D%22locatorsearch%22%3E%3Cdataview%3Estore_default%3C%2Fdataview%3E%3Climit%3E250%3C%2Flimit%3E%3Cgeolocs%3E%3Cgeoloc%3E%3Caddressline%3E";
	$url2="%3C%2Faddressline%3E%3Clatitude%3E%3C%2Flatitude%3E%3Clongitude%3E%3C%2Flongitude%3E%3Ccountry%3EUS%3C%2Fcountry%3E%3C%2Fgeoloc%3E%3C%2Fgeolocs%3E%3Csearchradius%3E20%7C50%7C75%7C100%7C500%3C%2Fsearchradius%3E%3Cwhere%3E%3Coffersonlineordering%3E%3Ceq%3E%3C%2Feq%3E%3C%2Foffersonlineordering%3E%3Chasdrivethru%3E%3Ceq%3E%3C%2Feq%3E%3C%2Fhasdrivethru%3E%3Cofferswireless%3E%3Ceq%3E%3C%2Feq%3E%3C%2Fofferswireless%3E%3Cplayground%3E%3Cin%3E%3C%2Fin%3E%3C%2Fplayground%3E%3Cclientkey%3E%3Cnotin%3E80248%2C80274%3C%2Fnotin%3E%3C%2Fclientkey%3E%3C%2Fwhere%3E%3C%2Fformdata%3E%3C%2Frequest%3E";
	
	$zips=array(92887);
	foreach($zips as $zipx)
	{
	
		$url=$url1.$zipx.$url2;
		$xml=file_get_contents($url);
		
		$st=array('<response code="1">',"</response>");
		$xml=str_replace($st,"",$xml);
		$elem = new SimpleXMLElement($xml);
		//echo $xml;
		foreach ($elem as $poi) 
		{
			//printf("%s has got %d children.\n", $poi['name'], $poi->count());
			$name="IHOP";
			$subname="";
			$address1="";
			$address2="";
			$city="";
			$state="";
			$zip="";
			$country="";
			$latitude="";
			$longitude="";
			$phone="";
			$open=array_fill(0,7,"00:00:00");
			$close=array_fill(0,7,"00:00:00");
			$type="food";
			$storeno=-1;
			$drivethru=0;
			$wifi=0;
			$hours_unknown=1;
			
			foreach($poi as $epoi)
			{
				echo $epoi->getName().":".$epoi."<br>";
				if($epoi->getName()=="name")
					$subname=$epoi;
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
				else if($epoi->getName()=="clientkey")
					$storeno=intval($epoi);
				else if($epoi->getName()=="drive_through")
					$drivethru=intval($epoi);
				else if($epoi->getName()=="offerswireless")
				{
					if($epoi=="true")
					{
						$wifi=1;	
					}
				}
			}
			$hash=sha1($address1.$address2.$city.$state.$country.$zip);
			$query="INSERT INTO places VALUES(NULL,'".$hash."','".$name."','".$subname."','".$storeno."','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."','".$phone."','".$latitude."','".$longitude."','".$type."','".$drivethru."','".$wifi."','-8','1','".$hours_unknown."','".$open[0]."','".$close[0]."','".$open[1]."','".$close[1]."','".$open[2]."','".$close[2]."','".$open[3]."','".$close[3]."','".$open[4]."','".$close[4]."','".$open[5]."','".$close[5]."','".$open[6]."','".$close[6]."')";
			if($res=$mysqli->query($query))
			{
				echo "SUCCESS!";		
			}
			else
			{
				echo "UPDATE: ".$mysqli->error;
				$query="UPDATE places SET name='".$name."',storenumber='".$storeno."',drivethru='".$drivethru."', hours_4_o='".$open[4]."',hours_4_c='".$close[4]."',hours_5_o='".$open[5]."',hours_5_c='".$close[5]."',hours_6_o='".$open[6]."',hours_6_c='".$close[6]."' WHERE hash='".$hash."'";
				if($res=$mysqli->query($query))
				{
				}	
				else
				{
					echo "Unable to update: ".$mysqli->error;
				}
			}
			var_dump($open);
			var_dump($close);
			//var_dump($poi);
			//echo $poi["name"];
			echo "<br><br><br>";
		}
		
		$mysqli->close();
	}
?>