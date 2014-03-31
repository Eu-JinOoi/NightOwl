<?php
$url="https://openapi.starbucks.com/v1/stores/nearby?callback=jQuery17209456273284740746_1395992295744&radius=50&limit=50&latLng=33.909999678637824%2C-117.72432349999997&ignore=storeNumber%2CownershipTypeCode%2CtimeZoneInfo%2CextendedHours%2ChoursNext7Days&brandCodes=SBUX&access_token=4mjdrpjeqppzezfn5pvnh6z5&_=1395996685915";
$json=file_get_contents($url);
$json=substr($json,strpos($json,'[')+1,-3);
$json=str_replace("}}},{","}}},\n\n{",$json);
$stores=explode("\n\n",$json);
foreach($stores as $store)
{
	$fj=substr($store,strpos($store,'{"id":"'),-2);
	$sdata=json_decode($fj);
	if(strtolower($sdata->{'operatingStatus'}->{'status'})=="active")
	{
		echo "UID: ".$sdata->{'id'}."<br>";
		echo "Store:".$sdata->{'name'}."<br>";
		echo "Phone:".$sdata->{'phoneNumber'}."<br>";
		echo "Address:".$sdata->{'address'}->{'streetAddressLine1'}."<br>";
		if($sdata->{'address'}->{'streetAddressLine2'}!=NULL)
			echo $sdata->{'address'}->{'streetAddressLine2'};
		echo $sdata->{'address'}->{'city'}." ".$sdata->{'address'}->{'countrySubdivisionCode'}.", ";
		if(strlen($sdata->{'address'}->{'postalCode'})==9)
			echo substr_replace($sdata->{'address'}->{'postalCode'},'-',-4,-4)."<br>";
		else
			echo $sdata->{'address'}->{'postalCode'}."<br>";
		//Hours
		
	}
	else
	{
		echo "Inactive Store<br>";	
	}
	echo "<hr>";
}
//var_dump($stores);


?>