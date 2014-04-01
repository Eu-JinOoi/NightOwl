<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Night Critter</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<!--<script src="/resources/js/location.js"></script>-->
<script>
	var counter=0;
	var currentLocation_full=null;
	var menuState=1;//0 is away 1 is in frame
	function toggleMenu()
	{
		
		if(menuState==0)
			{
				//$("#menu").css("left","0%");
				$("#menu").stop().animate({"left":"0%"});
				menuState=1;
			}
			else
			{
				$("#menu").stop().animate({"left":"-60%"});
				menuState=0;  
			}
	}
	function openMenu()
	{
		$("#menu").stop().animate({"left":"0%"});
		menuState=1;
	}
	function closeMenu()
	{
		$("#menu").stop().animate({"left":"-60%"});
		menuState=0;  
	}
	function loadingStart()
	{
		//$("#maincont").css("background-color","rgb(23,23,23)");
		//$("#maincont").css("opacity",".5");
		//$("#maincont").css("z-index","77777");
	}
	function loadingStop()
	{
		//$("#maincont").css("background-color","rgb(255,255,255)");
		//$("#maincont").css("opacity","0");
		//$("#maincont").css("z-index","0");
	}
	function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);
	$("#dumpdata").html(out);
	}
	$(document).ready(function(e) {
		getLocation();
		$( "#menubutton" ).click(function() {
			toggleMenu();
		  	
		});
		loadPg("");
		window.onpopstate = function(event) {
		  //alert("location: " + document.location + ", state: " + JSON.stringify(event.state));
		  loadPg(event.state.hash.substr(1))
		};
		/*$(document).mousedown(function(e) {
			if(e.target.className=="menuitem")
			{
				$("#"+e.target.id).css('background-color','#4B0082');
			}
		});
		$(document).mouseup(function(e) {
            if(e.target.className=="menuitem")
			{
				$("#"+e.target.id).css('background-color','');
				//dump(e.target);
			}
        });
		
		$(".menuitem").on("tap",function()
		{
			$(this).delay(2000).css('background-color','');
			$(this).css('background-color','#4B0082');
			
		});*/
		
		
		
    });
	function loadPg(page)
	{
		loadingStart();
		var isOk=true;
		if(page=="")
			page=document.URL.split('#')[1];
		$.ajax(
		  {
			  type: "get",
			  url: "pages/"+page+'.php',
			  cache: false,
			  statusCode: {
							404: function ()
							   {
								  //alert('page not found');
								  isOk=false;
							   }
						   },
			  async: false
			  //async should be false to ensure that it loads the home page if it dne
		  });
		  if(isOk==false)
		  {
		 		page="home";
		  }
		$.get( "pages/"+page+".php", function( data ) {
		  //alert( "Data Loaded: " + data );
		  $("#scrollableContent").html(data);
		  if(page=="addplace")
		  {
				fillLocation();  
		  }
		  location.hash=page;
		  //var param = document.URL.split('#')[1];
		  loadingStop();
		  closeMenu();
		});
	}
	function getLocation()
	{
		if (navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(showPosition);
		}
		else
		{
		//x.innerHTML="Geolocation is not supported by this browser.";
			lat.value=(-1);
			long.value=(-1);
		}
	}
	function showPosition(position)
	{
		//$("#lat").val(position.coords.latitude);
		//$("#long").val(position.coords.longitude);
		$("#Ilocation").prop("src","location.png");
		$("#Ilocation").prop("alt","Location Found");
		//$("#locationmsg").html(" - Location Found");
		$.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true",function( data ) {
			//alert( "Data Loaded: " + data );
			//dump(data);
			//alert( "JSON Data: " + data.results[0].address_components[2].long_name+", "+data.results[0].address_components[4].short_name);
			$("#Nlocation").stop().animate({"height":"80px"});
			var current=$("#Nlocation").html();
			var ndata=current;
			if(data.results[2].address_components[0].types[0]=='locality')
			{
				ndata+="<br><span id='locationDesc'>"+data.results[2].address_components[0].long_name+", "+data.results[2].address_components[2].short_name+"</span>";
			}
			else if(data.results[2].address_components[1].types[0]=='locality')
			{
				ndata+="<br><span id='locationDesc'>"+data.results[2].address_components[1].long_name+", "+data.results[2].address_components[3].short_name+"</span>";
			}
			else
			{
				ndata+="3";	
			}
			currentLocation_full=data.results[0].formatted_address;
			$("#Nlocation").html(ndata);
		});
	}
	function fillLocation()
	{
		$("#vlocation").val(currentLocation_full);
	}
	function driveThruHours()
	{
		//$("#vdt").change(function(){
			if($("#vdt").prop('checked'))
			{
				$(".dth").css("opacity","1");
			}
			else
			{
				$(".dth").css("opacity","0");
			}
		//});	
	}
	
</script>
<link href='http://fonts.googleapis.com/css?family=Roboto:900,800,700,600,500,400,300,200,100' rel='stylesheet' type='text/css'>
<style>
	*
	{
		font-family: 'Roboto', sans-serif;
		font-weight:200;
		text-shadow:none;	
	}
	body,html
	{
		margin:0px;
		padding:0px;
		height:100%;	
		width:100%;
	}
	#maincont
	{
		height:100%;
		width:100%;	
		color:#FFF;
		padding-top:0px;
		maring-top:0px;	
		position:relative;
		
		overflow-x: hidden;	
		
	}
	#brandingBar
	{
		width:100%;
		height:40px;
		line-height:40px;
		font-size:30px;
		/*background-color:#4B0082;*/
		background-color:#196A9F;
		color:#FFF;	
		text-align:center;
		position:fixed;
		top:0px;
		z-index:99999;
	}
	#scrollableContent
	{
		position:relative;
		padding:20px;
		padding-top:55px;
		overflow-y: scroll;
		overflow-x: hidden;	
		z-index:44444;
		background-color:#EEE;
		height:110%;
	}
	div.card
	{
		margin:auto;
		margin-top:10px;
		margin-bottom:10px;
		width: 97%;
		height: 100px;
		background-color: #CCE;
		z-index:44445;
		position:relative;
		cursor:pointer;
	}
	div.card_result, div.card_dynamic
	{
		margin:auto;
		margin-top:10px;
		margin-bottom:10px;
		width: 95%;
		background-color: #CCE;
		z-index:44445;
		position:relative;
		cursor:pointer;
	}
	div.cardOverlay
	{
		/*padding-left:10px;
		padding-top:5px;*/
		font-size:38px;
		position:absolute;
		bottom:5px;
		right:10px;
	}
	div.card_result_icons
	{
		float:left;	
		margin:15px;
	}
	#menu
	{
		width:200px;
		height:100%;
		background-color:rgba(47,47,47,.98);
		color:#FFF;
		z-index:55555;
		position:fixed;
		top:40px;
		left:-60%;
	}
	.menubottom
	{
		position:fixed;
		width:inherit;
		bottom:0;	
	}
	.menuitem
	{
		display:block;
		height:40px;
		line-height:40px;
		font-size:24px;
		border-bottom:1px solid #FFF;	
		cursor:pointer;
		position:relative;
	}
	.menuitemr
	{
		display:block;
		height:24px;
		line-height:24px;
		font-size:16px;	
		cursor:pointer;
		position:relative;
		color:#777;
		font-weight:300;
		border-top:1px solid #777;
	}
	.storeOpen
	{
		color:#090;
		font-weight:800;
		margin-top:0px;
		margin-bottom:0px;
	}
	address
	{
		font-color:#CCC;
		font-style:normal;
	}
	table
	{
		border-collapse:collapse;
		border-spacing:10px 50px;
		width:100%;	
	}
	th
	{
		font-weight:500;
	}
	.dth
	{
		opacity:0;	
	}
	tr
	{
		/*outline: thin solid white;*/
		border-bottom:1px solid white;
	}
	/*These next two classes are for the menu button*/
	.border-menu 
	{
  		position: relative;
  		padding-left: 1.25em;
	}
	.border-menu:before 
	{
		  content: "";
		  position: absolute;
		  top: 0.25em;
		  left: 0;
		  width: 1em;
		  height: 0.135em;
		  border-top: 0.4em double #FFF;
		  border-bottom: 0.125em solid #FFF;
	}
	#locationDesc
	{
		/*font-size:15px;*/
		color:#777;
	}
	#fixScroll
	{
		height:100px;	
	}
</style>
</head>

<body id='bodytag'>
	<div id='brandingBar' >
        	<a id='menubutton'><div style="width:48px; height:48px; position:absolute; top:2px; left:0; cursor:pointer;" ><div class='border-menu'>&nbsp;</div></div></a>
        	SomeName
    </div>
	<div id='maincont'>
        <div id='menu'>
            <div class="menuitem" id='Nhome' onClick="loadPg('home');">Home</div>
            <div class="menuitem" id='Nadd' onClick="loadPg('addplace');">Add a Place</div>
            
            <div class='menuitem' id='Nlocation'>Location <img src='no_location.png' id='Ilocation' alt='location not found' style='margin-top:6px; position:absolute; right:5px;'/></div>
            
            <div class="menubottom">
            <div class='menuitemr'>Settings</div>
           	<div class='menuitemr'>&copy; 2014 - Company Name</div>
            </div>
        </div>
        <div id='scrollableContent'>
        	
        </div>
        <div id='fixScroll'>&nbsp;<!--This is to fix the URL bar hiding on Chrome. I know this is a terrible fix but it works--></div>
    </div>
</body>
</html>