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
	var citystate="";
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
				$("#menu").stop().animate({"left":"-100%"});
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
		$("#menu").stop().animate({"left":"-100%"});
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
		
		$( "#menubutton" ).click(function() {
			toggleMenu();
		  	
		});
		$("#searchbutton").click(function(){
			toggleSearch();
		});
		$("#filteropennow").click(function(){
			alert("CLICK");
			/*if($(this).hasClass("filterselected"))
			{
				$(this).removeClass("filterselected");
			}
			else
			{
				$(this).addClass("filterselected");	
			}*/
		});
		window.onpopstate = function(event) {
		  if(event.state!=null)
			  loadPg(event.state.hash.substr(1))
		  //Add in fix for scrolling
		};
		
		
		
		
		
		
		$(".day").click(function(e)
		{
			alert ("DAY");	
		});			
    });
	$(window).load(function()
	{
		$("#category-button").css({"background-color":"#196a9f","color":"#FFF","border-color":"#104a6f","border-radius":"0","padding-left":".2em"});
		//$(".ui-icon-carat-d:after")
		$(".ui-icon-carat-d:after").css({"background-image":"url(/resources/images/donotuse/dropdown.png)"});
		//"background-image":"url(/resources/images/donotuse/dropdown.png)",
		getLocation();
		loadPg("");
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
	function filterthis(self)
	{
			if($(self).hasClass("filterselected"))
			{
				$(self).removeClass("filterselected");
				if($(self).attr("id")=="filteropennow")
				{
					$(".closed").show();
					$(".unknown").show();
				}
				if($(self).attr("id")=="filterwifi")
				{
					$(".noWiFi").show();
				}
			}
			else
			{
				$(self).addClass("filterselected");	
				if($(self).attr("id")=="filteropennow")
				{
					$(".closed").hide();
					$(".unknown").hide();
				}
				if($(self).attr("id")=="filterwifi")
				{
					$(".noWiFi").hide();
				}
			}
	}
	function startLoading()
	{
		closeMenu();
		var loadingMessages=new Array("Loading...","Looking for good places for you!");
		var r=Math.floor((Math.random()*100)%loadingMessages.length);
		$("#scrollableContent").html("<div style='text-align:center; margin-left:auto; margin-right:auto; margin-top:20px; color:#000;'>"+loadingMessages[r]+"<br><img src='ajax-loader.gif'></div>"+"<div id='fixScroll'>&nbsp;</div>");
		var dheight=$(document).height();
		var scheight=$("#scrollableContent").height();
		var nheight=dheight-scheight-50+150;
		 //alert(dheight+"/"+scheight+"/"+nheight);
		//$("#fixScroll").css("height",nheight+"px");
		
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
	function openplace(PID)
	{
		alert("This will open details about place with PID "+PID+".");	
	}
	function createCard(pjson)
	{
		//var d=new Date();
		//ret+= d.toLocaleTimeString();
		//if(pjson.hours[2].open<d)
		
		
		var ret="";
		var wificlass="";
		if(pjson.wifi==0)
		{
			wificlass=" noWiFi";
		}
		ret+="<div class='"+pjson.status+wificlass+"' id='place-"+pjson.PID+"'>";
		ret+="<div class='leftcard'>";
		if(pjson.status=="open")
		{
			var lclose=pjson.hours[<?php echo date("w");?>].close;
			if(pjson.previous=="true")
				lclose=pjson.hours[<?php echo ((date("w")+6)%7);?>].close
			lclose=lclose.trim();
			if(lclose.substr(0,1)=="0")
			{
				if(lclose=="00:00:00")
				    lclose="Midnight"
				else
				  lclose=lclose.substr(1,lclose.length-4)+" am";
			}
			else
			{
				var first=Number(lclose.substr(0,2));
				first-=12;
				if(first==0)
				    lclose="Noon";
				else
				    lclose=first+lclose.trim().substr(2,lclose.length-5)+" pm";	
			}
			ret+="<h2 style='margin-bottom:0px; margin-top:2px;'>"+pjson.name+"</h2>";
			ret+="<h3 style='margin-top:0; margin-bottom:0; color:green; font-weight:bold;'>Open Until "+lclose+"</h3>";
		}
		else if(pjson.status=="closed")
		{
			var lopen=pjson.hours[<?php echo (date("w"))%7;?>].open;
			if(Number(lopen.substr(0,2))<12)
			{
				lopen=Number(lopen.substr(0,2))+lopen.substr(2,lopen.length-5)+" am";
			}
			else
			{
				var first=Number(lopen.substr(0,2));
				first-=12;
				if(first==0)
				    lopen="Noon";
		        else
				    lopen=first+lopen.substr(2,lopen.length-3);	
			}
			ret+="<h2 style='margin-bottom:0px; margin-top:2px;'>"+pjson.name+"</h2>";
			if(pjson.hours[<?php echo (date("w"))%7;?>].closed==1)
			{
				ret+="<h3 style='margin-top:0; margin-bottom:0; color:red;'>Closed Today</h3>";
			}
			else
			{
				ret+="<h3 style='margin-top:0; margin-bottom:0; color:green;'>Opens at "+lopen+"</h3>";
			}
		}
		else
		{
			ret+="<h2 style='margin-top:2px;'>"+pjson.name+"</h2>";
		}
		
		//ret+="<h3 style='margin:0;'>"+(Math.round(pjson.distance*100)*.01)+" km away</h3>";
		//ret+="<h3 style='margin:0;'>"+(Math.round(pjson.distance*0.62137*100)*.01)+" mi</h3>";
		//ret+="<h3 style='margin:0;'>"+((Math.round(pjson.distance*0.62137*10))/10).toFixed(2)+" mi</h3>";
		var miles=pjson.distance*0.62137;
		ret+="<h3 style='margin:0;'>"+miles.toFixed(2)+" mi</h3>";
		ret+="<a href='https://maps.google.com/maps?q="+pjson.address1+","+pjson.city+","+pjson.state+" "+pjson.zip+"' target='_blank' style='text-decoration:none;'>";
		ret+="<address>"+pjson.address1+"<br>"+pjson.address2+"<br>"+pjson.city+", "+pjson.state+" "+pjson.zip+"</address>";
		ret+="</a>";
		ret+="</div>";
		ret+="<div class='rightcard'>";
		if(pjson.wifi=="1")
		{
			ret+="<div style='background-color:#33b5e5; width:24px; height:24px; float:right;'><img src='resources/images/donotuse/wifi.png' style='z-index:44448;'></div>";	
		}
		if(pjson.drivethru=="1")
		{
			ret+="<div style='width:24px; height:24px; float:right;'><img src='resources/images/donotuse/car.png' style='z-index:44448;'></div>";	
		}
		ret+="<div class='clear'>&nbsp;</div>";
		//ret+="<div class='rightcard' onclick='openplace("+pjson.PID+")'>&nbsp;";
		//ret+="<img src='resources/images/arrow.png'>";
		ret+="</div>"
		ret+="<div class='clear'>&nbsp;</div>";
		ret+="</div>"
		return ret;
	}
	function handleJSON(json,page)
	{
		var fdata="";
		$.each(json.places,function(i, item)
		{
			fdata+=createCard(item);
		});
		if(json.places.length!=0)
		{
			var extraextra="";
			if(page=="home")
			{	
				extraextra="<div class='darkcard'>";
				extraextra+="<h2 style='font-weight:400; margin-left:3px;'>Welcome to 240&deg;</h2>";
				extraextra+="<p style='margin-left:7px;'>Instructions on how to do things on the site. Have an option to hide this box forever (maybe - maybe not may be good references since this is the 'landing' page.</p>";
				extraextra+="</div>";
			}
			var filters="<div id='filters'>";
			//filters+="Filters";
			filters+="<div id='filteropennow' class='filter' onclick='filterthis(this);'>Open Now</div>";
			filters+="<div id='filterwifi' class='filter' onclick='filterthis(this);'>WiFi</div>";
			filters+="<div id='filter2' class='filter' onclick='filterthis(this);'>Filter 3</div>";
			filters+="</div>";
			filters+="<div class='clear'>&nbsp;</div>";
			$("#scrollableContent").html(extraextra+filters+fdata);//+json.places.length+" results were returned."+fdata);
		}
		else
		{
			$("#scrollableContent").html("<div style='margin:10px;'><h3 style='color:#000;'>Um....you must live in the middle of nowhere...or we haven't gottent your area yet. We couldn't find anything in this category.</h3></div>");	
		}
	}
	function loadPg(page)
	{
		startLoading();
		var isOk=true;
		var isLoaded=false;
		var xtra=document.URL.split('|')[1];
		//if(xtra)
			//alert(xtra);
		//var sterms=page.split('|')[1];
		//if(sterms)
		//	alert(sterms);
		//page=page.split('|')[0];
		if(page=="")
			page=(document.URL.split('#')[1]);
	//		page=(document.URL.split('#')[1]).split('|')[0];
		if(page==undefined)
			page="home";
		/*var getArgs="";
		var loadpage=page;*/
		var colorCode="#196A9F";
		//colorCode="#0755e6";
		var colorCodeBorder="#104a6f";
		if(page=="food")
		{
			colorCode="#de0907";
			colorCodeBorder="#8c0604"
		}
		else if(page=="shopping")
		{
			colorCode="#4da900";
			colorCodeBorder="#265400";
		}
		else if(page=="entertainment")
		{
			colorCode="#fb8521";
			colorCodeBorder="#c45c04";
		}
		else if(page=="special")
		{
			colorCode="#1aa1e1";
			colorCodeBorder="#116b95";
		}
		$("#category-button").css({"background-color":colorCode,"color":"#FFF","border-color":colorCodeBorder,"border-radius":"0","padding-left":".2em"});
		$("#brandingBar").css({"background-color":colorCode});
		
		
		if(page=="entertainment" || page=="food" || page=="shopping" || page=="special" || page=="home" || page.indexOf("search|")==0)
		{
			/*Temp Fix*/
				if(page=="home")
					isOk=false;
			/*Temp Fix*/
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
			var locfail=true;
			var a;
			//if(page!="search")
			//if(sterms)
				a={category: page, latitude: selfLat, longitude: selfLong, distance:'40.3', resultsperpage:'15', page:'1'};
			//else
				//a={category: page, latitude: selfLat, longitude: selfLong, distance:'40.3', resultsperpage:'15', page:'1',searchterms: $("#searchBox").val()};		
			$.getJSON("pages/resultsJSON.php",a)
				.done(function(json){
					console.log(json);
					if(json.gps=="success")
					{
						//alert("Correct GPS Data");
						isLoaded=true;
						locfail=false;
						location.hash=page;
						handleJSON(json,page);
						
					}
					else
					{
						var extraextra="";
						extraextra+="<div class='card' style='background-color:#fc6e51; border:1px solid white;'>";
						extraextra+="<img src='/resources/images/donotuse/xxhmap.png' style='float:left;'>";
						extraextra+="<h1 style='margin-left:3px;'>Not so fast!</h1>";
						extraextra+="<div class='clear'>&nbsp;</div>";
						extraextra+="<p style='margin-left:7px;'>So we have a bit of a problem here, we don't know where you are. It's going to be awfully hard to tell you where things are if we don't know where you are. You're going to need to either allow your browser to tell us or set your <a onclick='loadPg(\"location\")'> location.</a></p>";
						extraextra+="</div>";
						$("#scrollableContent").html(extraextra);
					}
				})
				.fail(function(jqxhr, textStatus,error)
				{
					alert("Correct! You failed.");		
				});
		}
		else
		{
			$("#dropDownArea").css("opacity","0");	
			$("#category").prop("disabled",true);
			$("#category").css("cursor","default");
			$("#siteTitle").removeAttr("style");
		
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
					  if(page=="location")
					  {
						$("#location_currentlocation").html(citystate);  
					  }
					  location.hash=page;
					  //var param = document.URL.split('#')[1];	
					  //Check Doc Height and scrollable;
					  var dheight=$(document).height();
					  var wheight=$(window).height();
					  var scheight=$("#scrollableContent").height();
					  //var nheight=dheight-scheight-50+150;
					  var nheight=wheight+50;
					  //alert(dheight+" "+wheight+" "+scheight);
					  //alert(dheight+"/"+scheight+"/"+nheight);
					 //$("#fixScroll").css("height",nheight+"px");
					  //alert(nheight+" "+dheight+" ");
					 //$(".menubottom").css("bottom",nheight-125+"px");
					  isLoaded=true;
				  }
			  });
		  }
		  /*if(isLoaded==false)
		  {
			  if(isOk==false)
			  {
					page="home";
			  
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
			 //$("#fixScroll").css("height",nheight+"px");
			  //alert(nheight+" "+dheight+" ");
			 //$(".menubottom").css("bottom",nheight-125+"px");
			});
			  }
		  }*/
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
		selfLat=position.coords.latitude;
		selfLong=position.coords.longitude;
		
		$("#Ilocation").prop("src","location.png");
		$("#Ilocation").prop("alt","Location Found");
		$("#iconlocation").css("background-image","url(/location.png)");
		
		
		$.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true",function( data ) {
			$("#Nlocation").stop().animate({"height":"80px"});
			var current=$("#Nlocation").html();
			var ndata="Unknow";
			for(var i=0; i<data.results.length;i++)
			{
				if(data.results[i].types[0]=="locality" && data.results[i].types[1]=="political")
				{
					var cpos=(data.results[i].formatted_address).indexOf(",");
					if((data.results[i].formatted_address).indexOf(",",cpos)==-1)
					{
						
					}
					else
					{
						ndata=(data.results[i].formatted_address).substr(0,(data.results[i].formatted_address).indexOf(",",cpos+1));
					}
				}
			}
			//#locationDesc
			citystate=ndata;
			if($("#locationDesc").length==0)
			{
				ndata=current+"<div id='locationDesc'>"+citystate+"</div>";
				$("#Nlocation").html(ndata);
			}
			else
			{
				$("#locationDesc").html(citystate);
			}
			
			
			currentLocation_full=data.results[0].formatted_address;
			$("#location_currentlocation").html(citystate);			
			//var d=getDistance(34.05482801970849,-118.2381269802915);
			//alert("You are currently "+Math.round(d*100)/100+" mi from L.A. Union Station");
		});
		locSet=true;
		//-------------------
		
		loadPg(document.URL.split('#')[1]);
		
		
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

<body id='bodytag' style="background-color:#e5e5e5;">
	<div id='brandingBar' >
        	<a id='menubutton'>
            	<div style="width:48px; height:48px; position:absolute; top:2px; left:0; cursor:pointer;" >
                	<div class='border-menu'>&nbsp;</div>
                </div>
            </a>
            	<div style="width:160px; position:absolute; top:2px; left:55px; margin-top:-22px; height:48px;" id="dropDownArea">
          		<select name="category" id='category' style="margin:0;" onChange="loadPg(this.value.toLowerCase());">
                	<option value='home'>Everything</option>
                	<option value='food'>Food</option>
                    <option value='entertainment'>Entertainment</option>
                    <option value='shopping'>Shopping</option>
                    <option value='special'>Events</option>
                </select>
                </div>
        	<span id='siteTitle'>240&deg;</span>
            <!--<a id='searchbutton'>
            	<div style="width:48px; height:48px; position:absolute; top:-5px; right:0; cursor:pointer;">
                	<img src='search.png' alt='Search' style='max-height:48px; max-width:48px;' />
                </div>
            </a>-->
    </div>
	<div id='searchRegion'>
    	<div style='margin:auto;'><input type='text' id='searchBox' name='searchBox' style='width:75%; float:left;' data-role="none"><div id='doSearch' onClick="loadPg('search|home');">Search</div></div>
    </div>
	<div id='maincont'>
        <div id='menu'>
        	<div class='menusection'>
                <div class="menuitem" id='Nhome' onClick="loadPg('home');"><div class='menuicon' style="background-image:url(/resources/images/donotuse/home.png);"></div>Home</div>
                <!--<div class="menuitem" id='Nhome' onClick="loadPg('food');">Food</div>
                <div class="menuitem" id='Nhome' onClick="loadPg('entertainment');">Entertainment</div>
                <div class="menuitem" id='Nhome' onClick="loadPg('shopping');">Shopping</div>
                <div class="menuitem" id='Nhome' onClick="loadPg('special');">Events</div>-->
                <div class="menuitem" id='Nadd' onClick="loadPg('addplace');"><div class='menuicon' style="background-image:url(/resources/images/donotuse/addplace.png);"></div>Add a Place</div>
            </div>
            <div class='menusection'>
            	<div class='menuitem' id='Nlocation' style="" onClick="loadPg('location');">
	                <div class='menuicon' id='iconlocation' style="background-image:url(/no_location.png);">&nbsp;</div>
                	Location <!--<img src='no_location.png' id='Ilocation' alt='location not found' style='margin-top:6px; position:absolute; right:5px;'/>--></div>
                <!--<div class='menuitem' onClick="loadPg('settings');"><div class='menuicon' style="background-image:url(/resources/images/donotuse/settings.png);">&nbsp;</div>Settings</div>-->
            </div>
            
            <div class="menubottom">
                
                <div class='menuitemr' onClick="loadPg('about');">&copy; 2014 - Company Name</div>
            </div>
        </div>
        <div class='clear'>&nbsp;</div>
        <div id='pagearea' style="position:relative;">
            <div id='scrollableContent' style="background-color:#e5e5e5; position:relative;">
                
            </div>
            <!--<div id='placemat'>
            	<span style="color:#FF0000;">Test</span>
            </div>-->
        </div>
		<!--<div id='fixScroll'>&nbsp;This is to fix the URL bar hiding on Chrome. I know this is a terrible fix but it works</div>-->
		
        

    </div>
    <script>
	
	</script>
</body>

</html>