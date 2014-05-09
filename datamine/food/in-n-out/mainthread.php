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
	//$zip=92024;
	//$zips=array(92807, 92882, 91710, 92865, 92869, 92870, 91766, 92860, 91765, 91761, 92881, 91789, 92832, 90631, 92782, 91767, 91748, 92703, 91764, 92804, 92610, 92557, 92504, 92408, 92509, 92335, 92410, 92376, 92346, 91739, 91950, 91915, 91945, 92108, 92110, 92081, 92057, 92008, 92024, 92078, 90024, 90068, 91403, 90028, 90034, 91605, 90292, 91402, 91502, 91406, 91204, 91364, 90045, 91206, 91325, 90301, 91324, 91340, 91303, 91042, 90255, 90278, 91326, 92311, 93612, 93720, 93726, 93706, 93722, 93111, 92688, 92653, 92677, 92675, 92612, 92704, 92626, 91801, 90280, 91107, 91770, 90660, 90241, 90503, 90502, 90713, 90505, 90755, 90650, 90670, 90808, 90815, 90732, 90638, 90620, 90803, 91780, 91791, 91744, 91724, 91740, 91790, 91702, 91745, 91706, 91750, 91786, 91006, 92029, 92128, 92126, 92064, 92230, 92276, 92201, 89102, 89103, 89119, 89128, 89110, 89147, 89139, 89030, 89149, 89123, 89084, 89014, 95054, 95035, 95110, 94087, 94040, 94043, 94538, 95148, 95123, 94534, 94559, 95687, 85204, 85210, 85296, 85249, 85281, 85224, 85209, 85226, 85242, 85027, 85029, 85050, 85382, 85086, 85032, 85260, 75074, 75040, 75002, 75034, 75251, 75248, 75244, 75206, 75039, 76051, 76054, 76017, 76063, 76107, 76132, 84058, 84003, 95841, 95670, 95825, 95661, 95834, 95678, 95605, 95630, 84405, 84014, 84119, 84084, 84047, 84096, 84020, 84780, 89705, 96003, 95616, 95776, 95603, 95667, 95624, 94928, 95403, 94952, 94564, 94523, 94941, 94133, 94621, 94579, 94587, 94583, 94030, 94015, 94063, 94070, 94550, 95376, 94588, 95356, 95350, 95336, 95020, 95037, 95322, 95340, 93239, 93230, 93309, 93307, 93905, 93422, 93420, 93454, 93036, 93001, 93010, 91320, 93021, 91350, 91351, 91321, 93063, 91730, 92345, 92394, 92545, 92584, 92563, 92590, 92592, 92532, 92109, 92111, 92071, 92020, 85365, 85194, 85037, 85323, 85705, 85716, 85713, 85743, 85710, 85755, 78751, 78664, 78613, 75146, 76135, 75087, 86301, 86401, 86403, 89029, 90740, 93550, 93536, 92683, 92844, 92648, 92627, 89511, 89431, 95219, 95242, 94513, 94565, 95993, 95928, 95380, 93243, 92243);
	$zips=array(93239);
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
			$storeno=-1;
			$drivethru=0;
			
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
				else if($epoi->getName()=="clientkey")
					$storeno=intval($epoi);
				else if($epoi->getName()=="drive_through")
					$drivethru=intval($epoi);
				else if($epoi->getName()=="friday_hours")
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
				else if($epoi->getName()=="saturday_hours")
				{
					$hours=explode("-",$epoi);
					$hours[0]=trim($hours[0]);
					$hours[1]=trim($hours[1]);
					if(stripos($hours[0],"a.m.")!==false)
					{
						$open[6]=substr($hours[0],0,strpos($hours[0]," ")).":00";
					}
					else
					{
						$open[6]=((substr($hours[0],0,2)+12)%24).substr($hours[0],2,strpos($hours[0]," ")).":00";	
					}
					if(stripos($hours[1],"a.m.")!==false)
					{
						$close[6]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
					}
					else
					{
						$close[6]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
					}
				}
				else if($epoi->getName()=="weekday_hours")
				{
					$hours=explode("-",$epoi);
					$hours[0]=trim($hours[0]);
					$hours[1]=trim($hours[1]);
					if(strpos($hours[0]," a.m.")!==false)
					{
						for($i=0; $i<=4; $i++)
						{
							$open[$i]=substr($hours[0],0,strpos($hours[0]," ")).":00";
						}
						//$open[6]=substr($hours[0],0,strpos($hours[0]," ")).":00";
					}
					else
					{
						
					}
					if(strpos($hours[1]," a.m.")!==false)
					{
						for($i=0; $i<=4; $i++)
						{
							$close[$i]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
						}
						//$close[6]=str_pad(substr($hours[1],0,strpos($hours[1]," ")).":00",8,"0",STR_PAD_LEFT);
					}
					else
					{
						for($i=0; $i<=4; $i++)
						{
							$close[$i]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
						}
						//$close[6]=str_pad(((substr($hours[1],0,2)+12)%24),3,"0",STR_PAD_LEFT).substr($hours[1],2,strpos($hours[1]," ")).":00";	
					}
				}
			}
			$hash=sha1($address1.$address2.$city.$state.$country.$zip);
			$query="INSERT INTO places VALUES(NULL,'".$hash."','".$name."','".$storeno."','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."','".$phone."','".$latitude."','".$longitude."','".$type."','".$drivethru."','-8','1','".$open[0]."','".$close[0]."','".$open[1]."','".$close[1]."','".$open[2]."','".$close[2]."','".$open[3]."','".$close[3]."','".$open[4]."','".$close[4]."','".$open[5]."','".$close[5]."','".$open[6]."','".$close[6]."')";
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