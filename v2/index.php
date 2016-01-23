<!DOCTYPE html>
<html>
<head>
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#4285f4">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#4285f4">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#4285f4">
	<!--Import Google Icon Font-->
    <!--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <link href="/resources/icons/MaterialIcons.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/resources/materialize/css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Night Owl</title>
    <style>
		.stars
		{
			fill:red;	
		}
	</style>
</head>
<body>
<header>
    <nav class="top-nav" style="background-color:#3367d6;">
		<div class="container">
			<div class="nav-wrapper" style="font-size:3em;" id='nwrap'><a class="page-title">Night Owl&nbsp;<div id="html_attribution" style="display:inline;"><img src='/resources/poweredbygoogle/desktop/powered_by_google_on_non_white.png'/></div></a></div>
		</div>
	</nav>
</header>
<main>
   	<div class="container">
    	<div class="row" style="margin-top:10px;"><!--Tags-->
       		<div class="chip">Open Now<i class="material-icons">close</i></div>
            <div class="chip">Other Filtering Categories<i class="material-icons">close</i></div>
            <div class="chip">Restaurants<i class="material-icons">close</i></div>
        </div>
        <div class="row" id="loadingCircle">
        	<div class='col s12 m12 l12 center-align'>
	        	<div class="preloader-wrapper big active">
					<div class="spinner-layer spinner-blue">
			        	<div class="circle-clipper left">
			          		<div class="circle"></div>
			        	</div>
			        	<div class="gap-patch">
			          		<div class="circle"></div>
			        	</div>
			        	<div class="circle-clipper right">
			          		<div class="circle"></div>
			        	</div>
			      	</div>
			      	<div class="spinner-layer spinner-red">
			        	<div class="circle-clipper left">
			          		<div class="circle"></div>
			        	</div>
			        	<div class="gap-patch">
			          		<div class="circle"></div>
			        	</div>
			        	<div class="circle-clipper right">
			          		<div class="circle"></div>
			        	</div>
			      	</div>
      		 		<div class="spinner-layer spinner-yellow">
			        	<div class="circle-clipper left">
          					<div class="circle"></div>
        				</div>
        				<div class="gap-patch">
          					<div class="circle"></div>
        				</div>
        				<div class="circle-clipper right">
          					<div class="circle"></div>
        				</div>
      				</div>      	
				</div>
			</div>
        </div>
        <div class="row" >
        	<div class='col s12 m12 l12' id="errorInfo" style='display:none;'>
            </div>
        </div>
		<div class="row">
        	<div class='col s12 m6 l6' id='col_0'>
            	
            </div>
            <div class='col s12 m6 l6' id='col_1'>
            </div>
      	</div>
        <div class='row'>
            <div class='col s12 m12 l12'>
            	<div class='card-panel center-align'>
                	<div id='html_attributions'><img src='/resources/poweredbygoogle/desktop/powered_by_google_on_white.png'/></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
	    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    		<a class="btn-floating btn-large red">
		    <i class="large material-icons">search</i>
    		</a>
  		</div>
	</div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/resources/materialize/js/materialize.min.js"></script>
<script type="text/javascript">

var map;
var infowindow;
var colCNT=0;
var allRes="";
//var attribution=$("#data_attribution").html();
var attribution=$("#html_attribution");
var userLoc = {lat: 33.810188, lng: -117.921142};
var passLoc;
var browserSupportFlag =  new Boolean();
var locationDetermined=false;
var radarradius=500;
//var loadedPIDs=[];
function initMap() {
  // Try W3C Geolocation (Preferred)
	if(navigator.geolocation) 
	{
    	browserSupportFlag = true;
    	navigator.geolocation.getCurrentPosition(function(position) 
		{
      		passLoc = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			userLoc.lat=position.coords.latitude;
			userLoc.lng=position.coords.longitude;
	  		locationCallback();
	  		
    	}, function() 
		{
      	handleNoGeolocation(browserSupportFlag);
    	});
		
		
  }
}
function locationCallback()
{
	infowindow = new google.maps.InfoWindow();
  			var service = new google.maps.places.PlacesService(attribution[0]);
  			service.nearbySearch({
    			location: userLoc,
    			radius: radarradius,
    			types: ['restaurant']
  			}, callback);	
}
function callback(results, status) {
  	if (status === google.maps.places.PlacesServiceStatus.OK && results.length>=13) 
	{
	  	allRes=results;
		for (var i = 0; i < results.length; i++) 
		{
			//createMarker(results[i]);
			//alert(results[i].name);
			createCard(results[i]);
			}
			$("#loadingCircle").hide();
		}	
	else if(status == "ZERO_RESULTS" ||  results.length<13) 
  	{
		radarradius+=1000;
		if(status=="ZERO_RESULTS")
			console.log("Unable to find a location at "+(radarradius-1000)+" meters. Trying "+radarradius+" meters.");
		else
			console.log("At "+(radarradius-1000)+" meters only "+results.length+" were found. Trying "+radarradius+" meters.");
		if(radarradius>50000)
		{
			dispHTML="<div class='card-panel red darken-1' style='color:#FFFFFF'>";
			/*dispHTML+="<h4>ERROR INFORMATION</h4>";
			dispHTML+="<ul>";
			dispHTML+="<li>Error Returned: No Results Returned";
			dispHTML+="<li>Latitude: "+userLoc.lat+"</li>";
			dispHTML+="<li>Longitude: "+userLoc.lng+"</li>";
			dispHTML+="</ul>";*/
			dispHTML+="<h4>Where are you?</h4>";
			dispHTML+="<p>We looked and looked and looked. You must be in the middle of the desert or something because there isn't anything within at least 30 miles of your location!</p>";
			dispHTML+="</div>";
			$("#errorInfo").html(dispHTML);
			$("#loadingCircle").hide();
			$("#errorInfo").show();		
		}
		else
		{
			locationCallback();	
		}
  	}
}
function createCard(result)
{
		rating=result.rating;
		intRating=Math.floor(rating);
		decRating=rating-intRating;
		//alert(result.photos[0].raw_reference);
		var isSVG=false;
		
		//alert("creating card");
		var cardHTML="";
		//cardHTML+="<div class='card''>\n\t<div class='card-image'>\n\t\t<!--<img src='https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference="+result.reference+"&key=AIzaSyBIg2RSi_wx3-NAbMc0-aIOac2Xf9AvV3Y'>-->\n\t\t<span class='card-title'>"+result.name+"</span></div>";
		cardHTML+="<div class='card-panel' id='card-"+result.id+"'>";
		//cardHTML+="<div><img src='"+result.photos[0].raw_reference[0].fife_url+"' /></div>";
		cardHTML+="\n\t<span class='card-title' style='font-weight:bold; font-size:1.25em'>"+result.name+"</span>";
		//cardHTML+="\n\t<i class='small material_icons'>star_rate</i>";
		cardHTML+="\n\t<div>";
		if(result.hasOwnProperty('rating'))
		{
			for(var i=0; i<5;i++)
			{
				if(isSVG==false)
				{
					if(i<intRating)
						cardHTML+="<img src='/resources/icons/google-material/ic_star_black_24px.svg'>";
					else if(i==intRating && decRating>=0.5)
						cardHTML+="<img src='/resources/icons/google-material/ic_star_half_black_24px.svg'>";
					else
						cardHTML+="<img src='/resources/icons/google-material/ic_star_border_black_24px.svg'>";
				}
				else
				{
					cardHTML+="<svg class='stars'>";
					cardHTML+="<use xlink:href='/resources/icons/google-material/ic_star_black_24px.svg'></use>";
					cardHTML+="</svg>";
				}
			}
			cardHTML+=rating;
		}
		cardHTML+="<div>"+result.vicinity+"</div>";
		cardHTML+="\n\t</div>";
		cardHTML+="</div>";
		var col_m="col_0";
		if(colCNT!=0)
		{
			col_m="col_1";
			colCNT=0;
		}
		else
			colCNT=colCNT+1;
		$("#"+col_m).append(cardHTML);
		//alert("card created");
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIg2RSi_wx3-NAbMc0-aIOac2Xf9AvV3Y&callback=initMap&signed_in=true&libraries=places,visualization" async defer></script>
  
    </script>
</body>
</html>