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
	var selfLat=0;
	var selfLong=0;
	var locSet=false;
	function toggleMenu()
	{
		
		if(menuState==0)
			{
				//$("#menu").css("left","0%");
				$("#menu").stop().animate({"left":"0%"});
				$("#searchRegion").stop().animate({"padding-left":"210px"});
				$("#doSearch").css({"padding-left":"5px","padding-right":"5px"});
				$("#doSearch").html("<img src='search.png' style='max-height:12px;'/>");
				menuState=1;
			}
			else
			{
				$("#menu").stop().animate({"left":"-105%"});
				$("#searchRegion").stop().animate({"padding-left":"15px"});
				$("#doSearch").css({"padding-left":"10px","padding-right":"10px"});
				$("#doSearch").html("Search");
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
		$("#menu").stop().animate({"left":"-105%"});
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
			//$("#searchRegion").html("<div style='margin:auto;'><input type='text' id='searchBox' name='searchBox' style='width:75%; float:left;'> <div id='doSearch'>Search</div></div>");
			searchState=1;
		}
		else
		{
			$("#scrollableContent").stop().animate({"padding-top":"55px"});
			$("#searchRegion").stop().animate({"padding-top":"-10px","height":"0px"});
			//$("#searchRegion").html("");
			searchState=0;	
		}
	}
	function startLoading()
	{
		closeMenu();
		var loadingMessages=new Array("Loading...","Looking for good places for you!");
		var r=Math.floor((Math.random()*100)%loadingMessages.length);
		$("#scrollableContent").html("<div style='text-align:center; margin-left:auto; margin-right:auto; color:#000;'>"+loadingMessages[r]+"<br><img src='ajax-loader.gif'></div>"+"<div id='fixScroll'>&nbsp;</div>");
		var dheight=$(document).height();
		var scheight=$("#scrollableContent").height();
		var nheight=dheight-scheight-50+150;
		 //alert(dheight+"/"+scheight+"/"+nheight);
		$("#fixScroll").css("height",nheight+"px");
		
	}
	function ucwords(str) {
	  //  discuss at: http://phpjs.org/functions/ucwords/
	  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  // improved by: Waldo Malqui Silva
	  // improved by: Robin
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // bugfixed by: Onno Marsman
	  //    input by: James (http://www.james-bell.co.uk/)
	  //   example 1: ucwords('kevin van  zonneveld');
	  //   returns 1: 'Kevin Van  Zonneveld'
	  //   example 2: ucwords('HELLO WORLD');
	  //   returns 2: 'HELLO WORLD'
	
	  return (str + '')
		.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
		  return $1.toUpperCase();
		});
	}
	function loadPg(page)
	{
		startLoading();
		var isOk=true;
		var isLoaded=false;
		if(page=="")
			page=document.URL.split('#')[1];
		if(page==undefined)
			page="home";
		/*var getArgs="";
		var loadpage=page;*/
		if(page=="entertainment" || page=="food" || page=="shopping" || page=="special")
		{
			$("#dropDownArea").css("opacity","1");
			$("#category").prop("disabled",false);
			$("#category").css("cursor","pointer");
			$("#siteTitle").css({"position":"absolute","right":"50px","top":"0"});
			$("select option").each(function(){
			  if ($(this).val() == page)
			  {
				$(this).attr("selected","selected");
				$("#category-button span").first().html($(this).text());
			  }
			  else
			    $(this).removeAttr("selected");
			});
			
		}
		else
		{
			$("#dropDownArea").css("opacity","0");	
			$("#category").prop("disabled",true);
			$("#category").css("cursor","default");
			$("#siteTitle").removeAttr("style");
		}
		$.ajax(
		  {
			  type: "post",
			  url: "pages/"+page+'.php?lat='+selfLat+'&long='+selfLong,
			  cache: false,
			  statusCode: {
							404: function ()
							   {
								  //alert('page not found');
								  isOk=false;
							   }
							
						   },
			  async: false,
			  //async should be false to ensure that it loads the home page if it dne
			  success: function(e)
			  {
				  var data=e+"<div id='fixScroll'>&nbsp;</div>";
				  $("#scrollableContent").html(data);
				  if(page=="addplace")
				  {
						fillLocation();  
				  }
				  location.hash=page;
				  isLoaded=true;
			  }
		  });
		  if(isLoaded==false)
		  {
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
			});
		  }
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
		selfLat=position.coords.latitude;
		selfLong=position.coords.longitude;
		
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
			var d=getDistance(34.05482801970849,-118.2381269802915);
			//alert("You are currently "+Math.round(d*100)/100+" mi from L.A. Union Station");
		});
		locSet=true;
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
	Number.prototype.toRad = function() {
   		return this * Math.PI / 180;
	}
	function getDistance(destLat,destLong)
	{
		var R = 6371; // km
		
		var dLat = (selfLat-destLat).toRad();
		var dLon = (selfLong-destLong).toRad();
		var lat1 = selfLat.toRad();
		var lat2 = destLat.toRad();
		//alert(selfLat+","+selfLong+" "+destLat+","+destLong+" "+dLat+","+dLon+"\n"+lat1+","+lat2);
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
		var c = 2 * Math.atan2(Math.sqrt(Math.abs(a)), Math.sqrt(Math.abs(1-a))); 
		var d = R * c;
		//alert(a+"\n"+c+"\n"+d);
		return d*0.62137;//.62137 converts to mi
	}
	
</script>
<link href='http://fonts.googleapis.com/css?family=Roboto:900,800,700,600,500,400,300,200,100' rel='stylesheet' type='text/css'>
<link href='/resources/no.css' rel="stylesheet" type="text/css">
<link href='/resources/openclose.css' rel="stylesheet" type="text/css">
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
            	<div style="width:160px; position:absolute; top:2px; left:55px; margin-top:-22px; height:48px;" id="dropDownArea">
          		<select name="category" id='category' style="margin:0;" onChange="loadPg(this.value.toLowerCase());">
                	<option value='food'>Food</option>
                    <option value='entertainment'>Entertainment</option>
                    <option value='shopping'>Shopping</option>
                    <option value='special'>Special Events</option>
                </select>
                </div>
        	<span id='siteTitle'>240&deg;</span>
            <a id='searchbutton'>
            	<div style="width:48px; height:48px; position:absolute; top:-5px; right:0; cursor:pointer;">
                	<img src='search.png' alt='Search' style='max-height:48px; max-width:48px;' />
                </div>
            </a>
    </div>
	<div id='searchRegion'>
    	<div style='margin:auto;'><input type='text' id='searchBox' name='searchBox' style='width:75%; float:left;' data-role="none"><div id='doSearch'>Search</div></div>
    </div>
	<div id='maincont'>
        <div id='menu' style="width:100%; left:-105%; background-color:rgba(47,47,47,.6);">
            <!--<div class="menuitem" id='Nhome' onClick="loadPg('home');">Home</div>
           
            <div class="menuitem" id='Nadd' onClick="loadPg('addplace');">Add a Place</div>
            
            <div class='menuitem' id='Nlocation' style="cursor:default;">Location <img src='no_location.png' id='Ilocation' alt='location not found' style='margin-top:6px; position:absolute; right:5px;'/></div>-->
            <svg height="100" width="100">
  				<circle cx="50" cy="50" r="40" stroke="" stroke-width="3" fill="red" />
            </svg>
        	</div>
        <div id='scrollableContent'>
        	
        </div>
		<!--<div id='fixScroll'>&nbsp;This is to fix the URL bar hiding on Chrome. I know this is a terrible fix but it works</div>-->
		
        

    </div>
    <script>
	$(window).load(function()
	{
		$("#category-button").css({"background-color":"#196a9f","color":"#FFF","border-color":"#104a6f"});
	});
	</script>
</body>

</html>