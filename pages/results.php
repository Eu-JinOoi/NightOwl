<?php
$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
if ($mysqli->connect_error) 
{
	die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}


$page=$_GET['page'];
$searchTerms=$_GET['search'];
$lat=$_GET['lat'];
$long=$_GET['long'];
//**************************CLASS ****************************************//
class place
{	
	private $pid;
	private $name;
	private $address;
	
	private $hours;
	
	
	private $status;
	

	public function __construct($pid,$name,$address,$status,$hours)
	{
		$this->pid=$pid;
		$this->name=$name;
		$this->address=$address;
		$this->status=$status;
		
	}
	public function display()
	{
		echo "<div class='".$this->status."' id='".$this->pid."'>";
			echo "<h2>".$this->name."</h2>";
			echo "<address>".$this->address."</address>";
		echo "</div>";
	}
}

//**************************CLASS ****************************************//
$placeArray=array();
if($page=="food")
{
	$query="SELECT * FROM places";
	if($result=$mysqli->query($query))
	{
		while($row=$result->fetch_assoc())
		{
			$place=new place($row['PID'],$row['name'],$row['address1']."<br>".$row['address2']."<br>".$row['city'].", ".$row['stateprov']." ".$row['zip'],"open","12:00-18:00");
			array_push($placeArray,$place);	
		}
		$result->free();
	}
	
}
else
{
	$place=new place("1","Test Location","1234 Sesame Street","open","12:00-18:00");
	array_push($placeArray,$place);
}
echo "<div id='searchResults'>\n";
	for($i=0;$i<sizeof($placeArray);$i++)
	{
		$placeArray[$i]->display();	
	}
echo "</div>";
?>