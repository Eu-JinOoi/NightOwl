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
	$zip=93101;
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
		$open=array_fill(0,7,"00:00:00");
		$close=array_fill(0,7,"00:00:00");
		$type="food";
		
		foreach($poi as $epoi)
		{
			echo $epoi->getName().":".$epoi."<br>";
			if($epoi->getName()=="name")
				$name="In-N-Out";
				//$name.=$epoi;
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
			else if($epoi->getName()=="friday_hours")
			{
				$hours=explode("-",$epoi);
				$hours[0]=trim($hours[0]);
				$hours[1]=trim($hours[1]);
				if(stripos($hours[0],"a.m.")!==false)
				{
					$open[4]=substr($hours[0],0,strpos($hours[0]," ")).":00";
				}
				else
				{
					$open[4]=((substr($hours[0],0,2)+12)%24).substr($hours[0],2,strpos($hours[0]," ")).":00";	
				}
				if(stripos($hours[1],"a.m.")!==false)
				{
					$close[4]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
				}
				else
				{
					$close[4]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
				}
				
			}
			else if($epoi->getName()=="saturday_hours")
			{
				$hours=explode("-",$epoi);
				$hours[0]=trim($hours[0]);
				$hours[1]=trim($hours[1]);
				if(stripos($hours[0],"a.m.")!==false)
				{
					$open[5]=substr($hours[0],0,strpos($hours[0]," ")).":00";
				}
				else
				{
					$open[5]=((substr($hours[0],0,2)+12)%24).substr($hours[0],2,strpos($hours[0]," ")).":00";	
				}
				if(stripos($hours[1],"a.m.")!==false)
				{
					$close[5]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
				}
				else
				{
					$close[5]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
				}
			}
			else if($epoi->getName()=="weekday_hours")
			{
				$hours=explode("-",$epoi);
				$hours[0]=trim($hours[0]);
				$hours[1]=trim($hours[1]);
				if(strpos($hours[0]," a.m.")!==false)
				{
					for($i=0; $i<4; $i++)
					{
						$open[$i]=substr($hours[0],0,strpos($hours[0]," ")).":00";
					}
					$open[6]=substr($hours[0],0,strpos($hours[0]," ")).":00";
				}
				else
				{
					
				}
				if(strpos($hours[1]," a.m.")!==false)
				{
					for($i=0; $i<4; $i++)
					{
						$close[$i]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
					}
					$close[6]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
				}
				else
				{
					for($i=0; $i<4; $i++)
					{
						$close[$i]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
					}
					$close[6]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
				}
			}
		}
		$hash=sha1($address1.$address2.$city.$state.$country.$zip);
		$query="INSERT INTO places VALUES(NULL,'".$hash."','".$name."','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."','".$phone."','".$latitude."','".$longitude."','".$type."','-8','1','".$open[0]."','".$close[0]."','".$open[1]."','".$close[1]."','".$open[2]."','".$close[2]."','".$open[3]."','".$close[3]."','".$open[4]."','".$close[4]."','".$open[5]."','".$close[5]."','".$open[6]."','".$close[6]."')";
		if($res=$mysqli->query($query))
		{
				
		}
		var_dump($open);
		var_dump($close);
		//var_dump($poi);
		//echo $poi["name"];
		echo "<br><br><br>";
	}
	
	$mysqli->close();
?>