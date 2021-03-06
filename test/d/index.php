<?php
require("../../resources/classes/place.php");



$url="https://disneyland.disney.go.com/accessible-calendar/";
$url2="https://disneyland.disney.go.com/accessible-calendar/month/".date("Y-m-d",strtotime("first day of next month"));
$fc=file_get_contents($url);
$fcn=file_get_contents($url2);
$need="window.viewData = ";
$start=strpos($fc,$need)+strlen($need);
$start2=strpos($fcn,$need)+strlen($need);
$end=strpos($fc,"</script>",$start);
$end2=strpos($fcn,"</script>",$start2);
$jsondata=substr($fc,$start,$end-$start);
$jsondata2=substr($fcn,$start2,$end2-$start2);
$json=json_decode($jsondata,true);
$json2=json_decode($jsondata2,true);
//var_dump($json["weeks"]);

//Variables
$name="Disneyland";
$subname="";
$address1="1313 Disneyland Drive";
$address2="";
$city="Anaheim";
$state="CA";
$zip="92802";
$country="US";
$latitude="33.809596";
$longitude="-117.918970";
$latitude2="33.808700";
$longitude2="-117.918993";
$phone="(714)781-45655";
$open=array_fill(0,7,"00:00:00");
$close=array_fill(0,7,"00:00:00");
$type="entertainment";
$storeno=-1;
$drivethru=0;
$wifi=0;
$plus18=0;
$plus21=0;
$alcohol=0;
$alcohol2=1;
$hours_unknown=127;
$hours_closed=127;
$hours_24=0;
$timezone=-8;
$dlst=1;
$hash=sha1($address1.$address2.$city.$state.$country.$zip);
function convertDHours($time)
{
	if(strpos($time," ")!==FALSE)
		$time=substr($time,0,strpos($time," "));
	//echo "|".$time."|";
	return date("H:i:s",strtotime($time."m"));	
}
function parseJSON($json)
{
	global $DLRA;
	global $DCA;
	foreach($json["weeks"] as $week)
	{
		foreach($week as $day)
		{
			if($day["id"]!=NULL)
			{
				
				$date=substr($day["id"],0,4)."-".substr($day["id"],4,2)."-".substr($day["id"],-2);
				echo $date."<br>";;
				$dowe=date("l (w)",strtotime($date));
				$dow=date("w",strtotime($date));
				echo "Day of Week:".$dowe."<br>\n";
				//var_dump($day);
				foreach($day["locations"] as $park)
				{
					echo $park["title"]."<br>";
					echo $park["parkHours"]."<br>";	
					$hrs=explode(" - ",$park["parkHours"]);
					$o=convertDHours($hrs[0]);
					$c=convertDHours($hrs[1]);
					$is24=0;
					if($o==$c)
					{
						echo "<span style='color:green; font-weight:bolder;'>OPEN 24 HOURS!</span><br>";
						$is24=1;
					}
					else
					{
						echo "Opens at: ".$o."<br>";
						echo "Closes at: ".$c."<br>";	
						
					}
					if($park["title"]=="Disneyland Park" && !$DLRA->hoursSet())
					{
						$DLRA->addHours($dow,$o,$c,$is24,0);
						echo "<span style='color:green;'>SET</span>";
					}
					else if($park["title"]=="Disney California Adventure Park" && !$DCA->hoursSet())
					{
						$DCA->addHours($dow,$o,$c,$is24,0);
						echo "<span style='color:green;'>SET</span>";	
					}
					else
					{
						echo "<span style='color:red;'>NOT SET</span>";	
					}
					
						
					echo "<br><br>";
	
				}
				echo "<br><hr><br>";
			}
		}
	}	
}
//New Place
$DLRA=new place("Disneyland Park");
$DCA=new place("Disney California Adventure Park");
//Address
$DLRA->addAddress($address1,$address2,$city,$state,$zip,$country,$latitude,$longitude);
$DCA ->addAddress($address1,$address2,$city,$state,$zip,$country,$latitude2,$longitude2);
//Details
$DLRA->addDetails($phone,$type,$drivethru,$wifi,$plus18,$plus21,$alcohol,1);
$DCA->addDetails($phone,$type,$drivethru,$wifi,$plus18,$plus21,$alcohol2,7);
//Time Settings
$DLRA->timeSettings($timezone,$dlst);
$DCA->timeSettings($timezone,$dlst);

parseJSON($json);
if(!$DLRA->hoursSet() || !$DCA->hoursSet())
{
	echo "<h2>Loading 2nd</h2>";
	parseJSON($json2);
}
$DLRA->writeDB();
$DCA->writeDB();
