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
	var searchState=0;//0 is away, 1 is shown
	function toggleMenu()
	{
		
		if(menuState==0)
			{
				//$("#menu").css("left","0%");
				$("#menu").stop().animate({"left":"0%"});
				$("#searchRegion").stop().animate({"padding-left":"215px"});
				menuState=1;
			}
			else
			{
				$("#menu").stop().animate({"left":"-65%"});
				$("#searchRegion").stop().animate({"padding-left":"15px"});
				menuState=0;  
			}
	}
	function openMenu()
	{
		$("#menu").stop().animate({"left":"0%"});
		$("#searchRegion").stop().animate({"padding-left":"215px"});
		//,"padding-left":"215px"
		menuState=1;
	}
	function closeMenu()
	{
		$("#menu").stop().animate({"left":"-60%"});
		$("#searchRegion").stop().animate({"padding-left":"15px"});
		menuState=0;  
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
		//$("#scrollableContent").css("height",$(window).height()*1.01);
		$( "#menubutton" ).click(function() {
			toggleMenu();
		  	
		});
		$("#searchbutton").click(function(){
			toggleSearch();
		});
		loadPg("");
		window.onpopstate = function(event) {
		  //alert("location: " + document.location + ", state: " + JSON.stringify(event.state));
		  loadPg(event.state.hash.substr(1))
		  //Add in fix for scrolling
		};
		$(".day").click(function(e)
		{
			alert ("DAY");	
		});
			
    });
	function toggleSearch()
	{
		if(searchState==0)
		{
			$("#scrollableContent").stop().animate({"padding-top":"0px"});
			$("#searchRegion").stop().animate({"padding-top":"55px","height":"40px"});
			$("#searchRegion").html("<div style='margin:auto;'><input type='text' id='searchBox' name='searchBox' style='width:75%; float:left;'> <div id='doSearch'>Search</div></div>");
			searchState=1;
		}
		else
		{
			$("#scrollableContent").stop().animate({"padding-top":"55px"});
			$("#searchRegion").stop().animate({"padding-top":"0px","height":"0px"});
			$("#searchRegion").html("");
			searchState=0;	
		}
	}
	function startLoading()
	{
		closeMenu();
		var loadingMessages=new Array("Loading...","Looking for good places for you!");
		var r=Math.floor((Math.random()*100)%loadingMessages.length);
		$("#scrollableContent").html("<div style='text-align:center; margin-left:auto; margin-right:auto;'>"+loadingMessages[r]+"<br><img src='ajax-loader.gif'></div>");
		
	}
	function loadPg(page)
	{
		startLoading();
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
		  data=data+"<div id='fixScroll'>&nbsp;</div>";
		  $("#scrollableContent").html(data);
		  if(page=="addplace")
		  {
				fillLocation();  
		  }
		  location.hash=page;
		  //var param = document.URL.split('#')[1];	
		  //Check Doc Height and scrollable;
		  var dheight=$(document).height();
		  var scheight=$("#scrollableContent").height();
		  var nheight=dheight-scheight-50+150;
		  //alert(dheight+"/"+scheight+"/"+nheight);
		  $("#fixScroll").css("height",nheight+"px");
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
	function daySelect(dow)
	{
		var dsow=new Array("M","T","W","R","F","S","U");
		for(i=0; i<7; i++)
		{
			if(dsow[i]==dow)
			{
				$("#day"+dow).css("background-color","#19649f");
				$("#day"+dsow[i]).css("color","#FFFFFF");
				$("#h_"+dow).css("opacity","1");
			}
			else
			{
				$("#day"+dsow[i]).css("background-color","#2f2f2f");
				$("#day"+dsow[i]).css("color","#777777");
				$("#h_"+dsow[i]).css("opacity","0");
			}
			
		}
	}
	
</script>
<link href='http://fonts.googleapis.com/css?family=Roboto:900,800,700,600,500,400,300,200,100' rel='stylesheet' type='text/css'>
<link href='/resources/no.css' rel="stylesheet" type="text/css">
<style>
	
</style>
</head>

<body id='bodytag'>
	<div id='brandingBar' >
        	<a id='menubutton'>
            	<div style="width:48px; height:48px; position:absolute; top:2px; left:0; cursor:pointer;" >
                	<div class='border-menu'>&nbsp;</div>
                </div>
            </a>
        	240&deg;
            <a id='searchbutton'>
            	<div style="width:48px; height:48px; position:absolute; top:-5px; right:0; cursor:pointer;">
                	<img src='search.png' alt='Search' style='max-height:48px; max-width:48px;' />
                </div>
            </a>
    </div>
	<div id='searchRegion'>
    </div>
	<div id='maincont'>
        <div id='menu'>
        	<!--<div class="menuitem" id='Nsearch' style=""><input type='text' id='searchBox' name='searchBox' style=" border:1px solid white; text-shadow:none; margin:0; background-color:rgba(0,0,0,0); border-radius:0; max-width:150px; color:#FFF;">Go</div>-->
            <div class="menuitem" id='Nhome' onClick="loadPg('home');">Home</div>
            <div class="menuitem" id='Nadd' onClick="loadPg('addplace');">Add a Place</div>
            
            <div class='menuitem' id='Nlocation'>Location <img src='no_location.png' id='Ilocation' alt='location not found' style='margin-top:6px; position:absolute; right:5px;'/></div>
            
            <div class="menubottom">
                <div class='menuitemr'>Settings</div>
                <div class='menuitemr' onClick="loadPg('about');">&copy; 2014 - Company Name</div>
            </div>
        </div>
        <div id='scrollableContent'>
        	
        </div>
		<!--<div id='fixScroll'>&nbsp;This is to fix the URL bar hiding on Chrome. I know this is a terrible fix but it works</div>-->
		
        

    </div>
</body>
</html>