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
	echo "{\n\t\"gps\":\"success\",\n";
	
	$type=$_GET['category'];
	$distance=$_GET['distance'];//in km
	$whereType;
	if(stripos($type,"search")!==FALSE)
	{
		
		$param=explode("|",$type);
		$type=$param[1];
		if(sizeof($param)==1)
			$type="home";
		else
		{
			$type=$param[1];
		}
		echo "\t\"searching\":\"".$type."\",\n";
	}
	else
	{
		echo "\t\"searching\":\"false\",\n";
	}
	$whereType=" WHERE type='".$type."'";
	if($type=="home")
	{
		$whereType="";
	}
	
	//MySQL setup
	$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
		echo "\t\"mysql\":\"failure\",\n";
		echo "\t\"mysql_query_error\":\"".$mysqli->error."\"\n";
	}
	else 
		echo "\t\"mysql\":\"success\",\n";
	//$distance=12;
	$query="SELECT *, (acos(sin(RADIANS(".$lat."))*sin(RADIANS(places.latitude))+cos(RADIANS(".$lat."))*cos(RADIANS(places.latitude))*cos(RADIANS(places.longitude) - RADIANS(".$lon.")))*6371) AS kmdist 
			FROM places 
			
			".$whereType." 
			HAVING kmdist <='".$distance."' 
			ORDER BY kmdist";
	//echo "\"queryCont\":\"".$query."\",";
	//LEFT JOIN hours ON places.PID=hours.PID
	if($result=$mysqli->query($query))
	{
		echo "\t\"query\":\"success\",\n";
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
			echo '"PID":"'.$row['PID'].'",';
			echo '"name":"'.$row['name'].'",';
			echo '"distance":"'.$row['kmdist'].'",';

			//Address Components
			echo '"address1":"'.str_replace('"','\"',$row['address1']).'",';
			echo '"address2":"'.$row['address2'].'",';
			echo '"city":"'.$row['city'].'",';
			echo '"state":"'.$row['stateprov'].'",';
			echo '"zip":"'.$row['zip'].'",';
			echo '"wifi":"'.$row['wifi'].'",';
			echo '"drivethru":"'.$row['drivethru'].'",';
			//Time Components
			$dow=date("w");
			$isOpen=false;
			$isUnknown=false;
			$previous=false;
			echo '"dow":"'.$dow.'",';
			echo '"hours":[';
				for($i=0;$i<7;$i++)
				{
					//echo '"hours_'.$i.'":[';
					echo "{";
						echo '"open":"'.$row['hours_'.$i.'_o'].'",';
						echo '"close":"'.$row['hours_'.$i.'_c'].'",';
						echo '"closed":"'.(intval($row["hours_closed"]&(0x0001<<$i))>0 ? 1 : 0).'",';
						echo '"unknown":"'.(intval($row["hours_unknown"]&(0x0001<<$i))>0 ? 1 : 0).'"';
					echo "}";		
					
					if($i==$dow)
					{
						/*if(
							($row['hours_'.$i.'_o']=="00:00:00" && $row['hours_'.$i.'_c']=="00:00:00") 
							||
							($row['hours_'.$i.'_o']==NULL && $row['hours_'.$i.'_c']==NULL))*/
						if(($row['hours_unknown']&(0x0001<<$i))!=0)
						{	
							$isUnknown=true;
						}
						else if(($row['hours_closed']&(0x0001<<$i))!=0)
						{
							$isOpen=false;	
						}
						else
						{
							$now=strtotime(date("H:i:s"));
							$open=strtotime($row['hours_'.$i.'_o']);
							$close=strtotime($row['hours_'.$i.'_c']);
							$popen=strtotime($row['hours_'.(($i+5)%6).'_o'] ." yesterday");
							$pclose=strtotime($row['hours_'.(($i+5)%6).'_c']);
							if($close>$open)//Normal
							{
								if($now>=$open && $now<$close)
								{
									$isOpen=true;	
								}
							}
							else if($close<$open)
							{
								if($now>=$open)
								{
									$isOpen=true;	
								}
								else if($now<$pclose)
								{
									
									$previous=true;
									$isOpen=true;
								}
								else
								{
									//echo "|".date("H:i:s",$now)."/".date("H:i:s",$pclose)."|";	
								}
							}
						}
						
					}
					if($i!=6)
					echo ",";
					//echo '],';
				}
			echo '],';
			if($previous)
				echo '"previous":"true",';
			if($isOpen)
			{
				echo '"status":"open"';
			}
			else
			{
				if(!$isUnknown)
				{
						echo '"status":"closed"';
				}
				else	
				{
						echo '"status":"unknown"';
				}
			}
			echo "}";
		}
		echo ']';
		echo '}';
		$result->free();	
	}	
	else
	{
		echo "\"query\":\"failure\",";
		echo "\"mysql_query_error\":\"".$mysqli->error."\"";
		echo "}";
	}
}
?>