<?php
function convertAddress($address)
{
	$address=trim($address);
	$ainfo=array();
	$lastspace=strripos($address," ");
	//Trim Zip
	$ainfo["zip"]=substr($address,$lastspace+1);
	$ainfo["zip"]=substr($ainfo["zip"],0,5);
	
	$ainfo["unused"]=$address=substr($address,0,$lastspace);
	//Trim State
	$comma=strripos($address,",");
	$ainfo["state"]=trim(substr($address,$comma+1));
	$ainfo["unused"]=$address=substr($address,0,$comma);
	//Address 2
	$hashtag=stripos($address,"#",0);
	$suite=stripos($address,"suite",0);
	if($hashtag!==FALSE)
	{
		$first=stripos($address," ",$hashtag);
		$ainfo["address2"]=trim(substr($address,$hashtag,$first-$hashtag));
		$ainfo["address1"]=trim(substr($address,0,$hashtag-1));
	}
	else if($suite!==FALSE)
	{
		$first=stripos($address," ",$suite);
		$second=stripos($address," ",$first+1);
		$ainfo["address2"]=substr($address,$suite,$second-$suite);
		$ainfo["address1"]=trim(trim(substr($address,0,$suite-1)),",");
		$city=trim(substr($address,$second));
		$paren=stripos($city,")");
		if($paren!==FALSE)
		{
			$ainfo["city"]=trim(trim(substr($city,$paren),')'));
		}
		else
		{
			$ainfo["city"]=$city;
		}
		//$ainfo["city"]=$city;
		//break;	
	}
	else
	{
		$streetends=array("blvd ","blvd.","ave ","ave.","avenue","boulevard","street","st.","dr ","drive","dr.","road","rd.","rd ","parkway","pkwy ","pkwy.","court","ct.","ct ","ln ","ln.","lane");
		$ainfo["address2"]="";
		for($i=0;$i<sizeof($streetends);$i++)
		{
			$offset=stripos($address,$streetends[$i]);
			if($offset!==FALSE)
			{
				$ainfo["sep"]=$streetends[$i];
				$space=stripos($address," ",$offset+1);
				$ainfo["address1"]=substr($address,0,$space);
				$city=trim(substr($address,$space));
				$paren=stripos($city,")");
				if($paren!==FALSE)
				{
					$ainfo["city"]=trim(trim(substr($city,$paren),')'));
				}
				else
				{
					$ainfo["city"]=$city;
				}
				break;	
			}
		}
	}
	
	
	echo "<br><hr><hr><br>";
	var_dump($ainfo);
	echo "<br>";
	//echo "<br><hr><hr><br>";
	return $ainfo;
}
function bwwHoursSuck($hours)
{
	$rhours["open"]=array_fill(0,7,"00:00:00");
	$rhours["close"]=array_fill(0,7,"00:00:00");
	$rhours["unknown"]=1;
	if($hours[0]=="Please call for hours.")
	{
		$rhours["unknown"]=1;
		return $rhours;
	}
	//Check for Daily
	//{
		
	//}
	foreach($hours as $entry)
	{
		$days=hoursDays($entry);
		$day=explode(",",$days);
		$hours=octimes($entry);
		$oc=explode("|",$hours);
		for($i=0;$i<sizeof($day);$i++)
		{
			echo $day[$i]."-".$hours."<br>";	
			$rhours["open"][$day[$i]]=$oc[0];
			$rhours["close"][$day[$i]]=$oc[1];		
		}
	}
	$rhours["unknown"]=0;
	return $rhours;
	
}
function octimes($times)
{
	$hours=substr($times,stripos($times,":")+1);
	//$hours=str_replace("AM",":00:00",$hours);
	//$hours=str_replace("PM","^",$hours);
	$oc=explode(" to ",$hours);
	for($i=0;$i<=1;$i++)
	{
		if(stripos($oc[$i],"PM"))
		{
			if(strlen(trim($oc[$i]))<=4)
			{
				$oc[$i]=(intval(substr($oc[$i],0,stripos($oc[$i],"PM")))+12).":00:00";	
			}
			else
			{
				$oc[$i]="<span style='color:#FF0000;'>".$oc[$i]."</span>";
			}
		}
		else if(stripos($oc[$i],"AM"))
		{
			$oc[$i]=str_replace("AM",":00:00",$oc[$i]);
			if(strlen($oc[$i])<8)
			{
				$oc[$i]="0".$oc[$i];	
			}
		}
	}
	
	return $oc[0]."|".$oc[1];
}
function hoursDays($hours)
{
	$search=array("Mon","Tue","Wed","Thurs","Fri","Sat","Sun","Daily");
	$replace=array("1","2","3","4","5","6","0","0-6");
	$days=str_replace($search,$replace,$hours);
	$days=substr($days,0,stripos($days,":"));
	if(stripos($days,"-")!==FALSE)
	{
		$first=substr($days,0,1);
		$last=substr($days,stripos($days,"-")+1,1);
		$n="";
		for($i=$first;$i<=$last;$i++)
		{
			$n.=$i.",";
		}
		$days=str_replace(substr($days,0,$last),$n,$days);
		$days=trim($days,",");
	}
	/*echo "<hr>";
	echo "|".$days."|";
	echo "<hr>";*/
	return $days;
}
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
	if ($mysqli->connect_error) 
	{
    		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
	}
	$url1="http://www.buffalowildwings.com/services/FetchStoresByLatLng.aspx?zip=92887&latLng%5B%5D=33.8976995&latLng%5B%5D=-117.72560829999998&lat=33.8976995&lng=-117.72560829999998&radius=50000";
	//$url1="http://www.buffalowildwings.com/services/FetchStoresByLatLng.aspx?zip=92887&latLng%5B%5D=33.8976995&latLng%5B%5D=-117.72560829999998&lat=33.8976995&lng=-117.72560829999998&radius=10";
	$jsondata=file_get_contents($url1);
	$json=json_decode($jsondata,true);
	
	//var_dump($json);
	foreach($json["Markers"] as $marker)
	{
		
		$store=$marker['Store_Data'];
		$ainfo=convertAddress($store["Address"]);
		$hours=bwwHoursSuck($store["StoreHours"]);		
		$name="Buffalo Wild Wings";
		$subname=ucwords(strtolower($store["Name"]));
		$address1=$ainfo["address1"];
		$address2=$ainfo["address2"];
		$city=$ainfo["city"];
		$state=$ainfo["state"];
		$zip=$ainfo["zip"];
		$country="US";
		$latitude=$store["Latitude"];
		$longitude=$store["Longitude"];
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
		
		echo "<br>".$name="Buffalo Wild Wings";
		echo "<br>".$subname=ucwords(strtolower($store["Name"]));
		echo "<br>".$address1;
		echo "<br>".$address2;
		echo "<br>".$city;
		echo "<br>".$state;
		echo "<br>".$zip;
		echo "<br>".$country;
		echo "<br>".$latitude=$store["Latitude"];
		echo "<br>".$longitude=$store["Longitude"];
		echo "<br>".$phone=$store["PhoneNumber"];
		echo "<br>"; var_dump($open);
		echo "<br>"; var_dump($close);
		echo "<br>".$type="food";
		echo "<br>".$storeno=$store["Store_Id"];
		echo "<br>".$drivethru=0;
		echo "<br>".$wifi=0;
		echo "<br>".$hours_unknown;
		
		echo "<hr>";
		echo "<br><br>";	
	}
	//echo sizeof($json->{"Markers"});
	
?>