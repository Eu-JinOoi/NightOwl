<?php

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
		foreach($poi as $epoi)
		{
			echo $epoi->getName().":".$epoi."<br>";
		}
		/*var_dump($poi);
		echo $poi["name"];*/
		echo "<br><br><br>";
	}
	
	
?>