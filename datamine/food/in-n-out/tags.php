<?php
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
if ($mysqli->connect_error) 
{
		die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
echo "Adding the following tags to all In-N-Out Locations:<br>";
$inotags=array("burger","fast food","fries","animal style","in-n-out","milkshakes","milkshake","in n out","innout","palm trees","in-n-out burger","in n out burger","innoutburger");
//Terrible Implimentation, i'm lazy though
for($i=1;$i<=293;$i++)
{
	echo $i." ";
	foreach($inotags as $tag)
	{
		$hash=sha1($i."|".$tag);
		$query="INSERT INTO tags VALUES(NULL,'".$i."','".$tag."','".$hash."')";
		if($res=$mysqli->query($query))
		{
			echo "<span>".$tag.", </span>";
		}
		else
		{
			echo "<span style='color:#ff0000;'>".$tag.", </span>";
		}
	}
	echo "<br>";
}