<?php

class place
{
	private $name;
	private $subname;
	private $address1;
	private $address2;
	private $city;
	private $state;
	private $zip;
	private $country;
	private $latitude;
	private $longitude;
	private $phone;
	private $open;//=array_fill(0,7,"00:00:00");
	private $close;//=array_fill(0,7,"00:00:00");
	private $type;
	private $storeno;
	private $drivethru;
	private $wifi;
	private $plus18;
	private $plus21;
	private $alcohol;
	private $dlst;
	private $timezone;
	private $hours_unknown;
	private $hours_closed;
	private $hours_24;
	
	private $hash;
	
	public function __construct($name,$subname="")
	{
		$this->name=$name;
		$this->subname=$subname;
		
		$this->hours_unknown=127;
		$this->hours_closed=0;
		$this->hours_24=0;
		$this->open=array_fill(0,7,"00:00:00");
		$this->close=array_fill(0,7,"00:00:00");
	}
	public function addHours($dow,$open,$close,$hr24,$hrclosed)
	{
		$this->open[$dow]=$open;
		$this->close[$dow]=$close;
		
		$this->hours_24|=($hr24<<$dow);
		$this->hours_closed|=($hrclosed<<$dow);
		//echo "HR BU:".$this->hours_unknown."<br>";
		//echo "&amp; w/:".(0x01<<$dow)."<br>";
		$this->hours_unknown&=(127&~(1<<$dow));
		//echo "HR AU:".$this->hours_unknown."<br>";
	}
	public function addAddress($addr1,$addr2,$city,$state,$zip,$country,$lat,$lon)
	{
		$this->address1=$addr1;
		$this->address2=$addr2;
		$this->city=$city;
		$this->state=$state;
		$this->zip=$zip;
		$this->country=$country;
		$this->latitude=$lat;
		$this->longitude=$lon;	
	}
	public function addDetails($phone,$type,$drivethru,$wifi,$plus18,$plus21,$alcohol,$storeno=-1)
	{
		$this->phone=$phone;
		$this->type=$type;
		$this->drivethru=$drivethru;
		$this->wifi=$wifi;
		$this->plus18=$plus18;
		$this->plus21=$plus21;
		$this->alcohol=$alcohol;
		$this->storeno=$storeno;
	}
	public function hoursSet()
	{
		//echo "HRSET: ".(($this->hours_unknown == 0) ? 1:0)."<br>";
		return (($this->hours_unknown == 0) ? 1:0);
	}
	public function timeSettings($timezone,$dlst)
	{
		$this->timezone=$timezone;
		$this->dlst=$dlst;	
	}
	private function genHash()
	{
		$this->hash=sha1($this->address1.$this->address2.$this->city.$this->state.$this->zip.$this->country.$this->storeno);
	}
	public function createICS()
	{
		/*$icsdata="
		BEGIN:VCALENDAR
		VERSION:2.0
		PRODID:-//hacksw/handcal//NONSGML v1.0//EN
		BEGIN:VEVENT
		UID:".$this->hash."@project1923.com
		DTSTAMP:19970714T170000Z
		ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
		DTSTART:19970714T170000Z
		DTEND:19970715T035959Z
		SUMMARY:Bastille Day Party
		END:VEVENT
		END:VCALENDAR";*/
	}
	public function writeDB()
	{
		$this->genHash();
		//echo $this->hash."<br>";
	//return;
		$query="INSERT INTO places
		(
		`PID`,
		`hash`,
		`name`,
		`subname`,
		`storenumber`,
		`address1`,
		`address2`,
		`city`,
		`stateprov`,
		`country`,
		`zip`,
		`phone`,
		`latitude`,
		`longitude`,
		`type`,
		`drivethru`,
		`wifi`,
		`plus18`,
		`plus21`,
		`alcohol`,
		`timezone`,
		`dlst`,
		`hours_unknown`,
		`hours_closed`,
		`hours_24`,
		`hours_0_o`,
		`hours_0_c`,
		`hours_1_o`,
		`hours_1_c`,
		`hours_2_o`,
		`hours_2_c`,
		`hours_3_o`,
		`hours_3_c`,
		`hours_4_o`,
		`hours_4_c`,
		`hours_5_o`,
		`hours_5_c`,
		`hours_6_o`,
		`hours_6_c`
		) VALUES ( 
		'NULL',
		'".$this->hash."',
		'".$this->name."',
		'".$this->subname."',
		'".$this->storeno."',
		'".$this->address1."',
		'".$this->address2."',
		'".$this->city."',
		'".$this->state."',
		'".$this->country."',
		'".$this->zip."',
		'".$this->phone."',
		'".$this->latitude."',
		'".$this->longitude."',
		'".$this->type."',
		'".$this->drivethru."',
		'".$this->wifi."',
		'".$this->plus18."',
		'".$this->plus21."',
		'".$this->alcohol."',
		'".$this->timezone."',
		'".$this->dlst."',
		'".$this->hours_unknown."',
		'".$this->hours_closed."',
		'".$this->hours_24."',
		'".$this->open[0]."',
		'".$this->close[0]."',
		'".$this->open[1]."',
		'".$this->close[1]."',
		'".$this->open[2]."',
		'".$this->close[2]."',
		'".$this->open[3]."',
		'".$this->close[3]."',
		'".$this->open[4]."',
		'".$this->close[4]."',
		'".$this->open[5]."',
		'".$this->close[5]."',
		'".$this->open[6]."',
		'".$this->close[6]."'
		)";
		$query=str_replace("\r\n","",$query);
		$mysqli=new mysqli('localhost','eunive5_projNO','NightOwl2014','eunive5_projectNO');
		if ($mysqli->connect_error) 
		{
				die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
		}
		$res=$mysqli->query($query);
		if($res)
		{
			echo "SUCCESS!";
		}
		else
		{
			
			//echo $query;
			echo "<br>".$mysqli->error."<br>";	
			
			//Update
			$query="UPDATE places SET 	
			`name`	=	'".$this->name."',	
			`subname`	=	'".$this->subname."',	
			`storenumber`	=	'".$this->storeno."',	
			`address1`	=	'".$this->address1."',	
			`address2`	=	'".$this->address2."',	
			`city`	=	'".$this->city."',	
			`stateprov`	=	'".$this->state."',	
			`country`	=	'".$this->country."',	
			`zip`	=	'".$this->zip."',	
			`phone`	=	'".$this->phone."',	
			`latitude`	=	'".$this->latitude."',	
			`longitude`	=	'".$this->longitude."',	
			`type`	=	'".$this->type."',	
			`drivethru`	=	'".$this->drivethru."',	
			`wifi`	=	'".$this->wifi."',	
			`plus18`	=	'".$this->plus18."',	
			`plus21`	=	'".$this->plus21."',	
			`alcohol`	=	'".$this->alcohol."',	
			`timezone`	=	'".$this->timezone."',	
			`dlst`	=	'".$this->dlst."',	
			`hours_unknown`	=	'".$this->hours_unknown."',	
			`hours_closed`	=	'".$this->hours_closed."',	
			`hours_24`	=	'".$this->hours_24."',	
			`hours_0_o`	=	'".$this->open[0]."',	
			`hours_0_c`	=	'".$this->close[0]."',	
			`hours_1_o`	=	'".$this->open[1]."',	
			`hours_1_c`	=	'".$this->close[1]."',	
			`hours_2_o`	=	'".$this->open[2]."',	
			`hours_2_c`	=	'".$this->close[2]."',	
			`hours_3_o`	=	'".$this->open[3]."',	
			`hours_3_c`	=	'".$this->close[3]."',	
			`hours_4_o`	=	'".$this->open[4]."',	
			`hours_4_c`	=	'".$this->close[4]."',	
			`hours_5_o`	=	'".$this->open[5]."',	
			`hours_5_c`	=	'".$this->close[5]."',	
			`hours_6_o`	=	'".$this->open[6]."',	
			`hours_6_c`	=	'".$this->close[6]."'	
			WHERE hash='".$this->hash."'";
			$res=$mysqli->query($query);
			if($res)
			{
				echo "UPDATED!<br>";	
			}
			else
			{
				echo "FAILED TO UPDATE<br>";	
				echo $mysqli->error."<br>";
				
			}
		}
		
	}
	
}
?>