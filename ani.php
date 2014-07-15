<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<title>eatnon</title>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src='/resources/js/menu.js'></script>
<script>
	var counter=0;
	var currentLocation_full=null;
	var citystate="";
	var menuState=1;//0 is away 1 is in frame
	var searchState=0;//0 is away, 1 is shown
	var selfLat=0;
	var selfLong=0;
	var locSet=false;
	var dowToString= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	
	
	function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);
	$("#dumpdata").html(out);
	}
	$(document).ready(function(e) {
				$(function()
			{
			$(".xpandB").click(function(){
		
				alert("!");	
			});
		});
		$( "#menubutton" ).click(function() {
			toggleMenu();
		  	
		});
		$("#searchbutton").click(function(){
			//toggleSearch();
		});
		
		window.onpopstate = function(event) {
		  //if(event.state!=null)
			//  loadPg(event.state.hash.substr(1))
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
		$(".ui-icon-carat-d:after").css({"background-image":"url(/resources/images/donotuse/dropdown.png)"});
		getLocation();
		//loadPg("");
	});
	function xpand(PID)
	{
		var src=$("#xpandB-"+PID).attr("src");
		if(src=='/resources/images/donotuse/expander_max.png')
		{
			$("#xpandB-"+PID).attr("src","/resources/images/donotuse/expander_min.png");
			$("#xpand-"+PID).show();
		}
		else
		{
			$("#xpandB-"+PID).attr("src","/resources/images/donotuse/expander_max.png");
			$("#xpand-"+PID).hide();
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
		
		ret+="<div id='xpander-"+pjson.PID+"' class='xpander close' style='position:absolute; bottom:0px; right:0;' onClick='xpand("+pjson.PID+");'>";
		ret+="<img class='xpandB' id='xpandB-"+pjson.PID+"' src='/resources/images/donotuse/expander_max.png'>";
		ret+="</div>";

		ret+="</div>"
		ret+="<div class='clear'>&nbsp;</div>";
		ret+="<div class='xpand' id='xpand-"+pjson.PID+"' style='margin-top:.5em; margin-bottom:.5em; display:none;'>";
		
		
		var vdow=pjson.dow;
		for(var i=0;i<7;i++)
		{
			lstyle="";
			if(vdow==pjson.dow)
			{
				lstyle=" font-weight:bold;";	
			}
			ret+="<div style='"+lstyle+" float:left; width:8em;'>"+dowToString[vdow]+": </div><div style='"+lstyle+" float:left;'>";
			
			if(pjson.hours[vdow].unknown=='1')
			{
				ret+="Data unavailable";	
			}
			else if(pjson.hours[vdow].closed=='1')
			{
				ret+="<span style='color:#ff0000;'>Closed</span>";	
			}
			else
			{
				ret+=pjson.hours[vdow].open+" - "+pjson.hours[vdow].close;
			}
			ret+="</div>";
			ret+="\n";
			ret+="<div class='clear'>&nbsp;</div>";
			vdow++;
			vdow=vdow%7;
		}
		ret+="</div>";
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
			$("#scrollableContent").html(extraextra+fdata);
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
		if(page=="")
			page=(document.URL.split('#')[1]);
		if(page==undefined)
			page="home";
		var colorCode="#196A9F";
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
			//distance 40.3
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
					  var nheight=wheight+50;
					  isLoaded=true;
				  }
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
		});
		locSet=true;
		//loadPg(document.URL.split('#')[1]);
		
		
	}
	function fillLocation()
	{
		$("#vlocation").val(currentLocation_full);
	}
	function driveThruHours()
	{
			if($("#vdt").prop('checked'))
			{
				$(".dth").css("opacity","1");
			}
			else
			{
				$(".dth").css("opacity","0");
			}
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
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
		var c = 2 * Math.atan2(Math.sqrt(Math.abs(a)), Math.sqrt(Math.abs(1-a))); 
		var d = R * c;
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
          		<!--<select name="category" id='category' style="margin:0;" onChange="loadPg(this.value.toLowerCase());">
                	<option value='home'>Everything</option>
                	<option value='food'>Food</option>
                    <option value='entertainment'>Entertainment</option>
                    <option value='shopping'>Shopping</option>
                    <option value='special'>Events</option>
                </select>-->
                </div>
        	<span id='siteTitle'>eatnon</span>
    </div>
	<div id='maincont'>
        <div id='menu'>
        	<div class='menusection'>
                <div class="menuitem" id='Nhome' onClick="loadPg('home');"><div class='menuicon' style="background-image:url(/resources/images/donotuse/home.png);"></div>Home</div>
                <div class="menuitem" id='Nadd' onClick="loadPg('addplace');"><div class='menuicon' style="background-image:url(/resources/images/donotuse/addplace.png);"></div>Add a Place</div>
            </div>
            <div class='menusection'>
            	<div class='menuitem' id='Nlocation' style="" onClick="loadPg('location');">
	                <div class='menuicon' id='iconlocation' style="background-image:url(/no_location.png);">&nbsp;</div>
                		Location 
                    </div>
            	</div>
            <div class="menubottom">
                <div class='menuitemr' onClick="loadPg('about');">&copy; 2014 - Company Name</div>
            </div>
        </div>
        <div class='clear'>&nbsp;</div>
        <div id='pagearea' style="position:relative;">
        
        	<div id='scrollableContent2' style="background-color:#e5e5e5; position:relative;">
                <div class='img_portion' style="height:20%; width:100%; position:absolute; top:40px; left:0; background-image:url('food.jpg');">
                    <!--<img src="/food.jpg" style='display:block;'>-->
                </div>
                <div class="desc_portion" style="height:50%;">
                        hELLO
                </div>	
            </div>
        
        	
        
           
        </div> 
    </div>
</body>
</html>