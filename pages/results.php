<?php
$page=$_GET['page'];
$searchTerms=$_GET['search'];
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
$place=new place("1","Test Location","1234 Sesame Street","open","12:00-18:00");



echo "<div id='searchResults'>\n";
$place->display();
echo "</div>";
?>