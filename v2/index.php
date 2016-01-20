<!DOCTYPE html>
<html>
<head>
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/v2/resources/materialize/css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Night Owl</title>
</head>
<body>
<header>
    <nav class="top-nav indigo darken-4">
		<div class="container">
			<div class="nav-wrapper" style="font-size:3em;" id='nwrap'><a class="page-title">Night Owl&nbsp;<div id="html_attribution" style="display:inline;"><img src='/v2/resources/poweredbygoogle/desktop/powered_by_google_on_non_white.png'/></div></a></div>
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
		<div class="row">
        	<div class='col s12 m6 l6' id='col_0'>
            	
            </div>
            <div class='col s12 m6 l6' id='col_1'>
            </div>
      	</div>
        <div class='row'>
            <div class='col s12 m12 l12'>
            	<div class='card-panel center-align'>
                	<div id='html_attributions'><img src='/v2/resources/poweredbygoogle/desktop/powered_by_google_on_white.png'/></div>
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
<script type="text/javascript" src="/v2/resources/materialize/js/materialize.min.js"></script>
<script type="text/javascript">

var map;
var infowindow;
var colCNT=0;
var allRes="";
//var attribution=$("#data_attribution").html();
var attribution=$("#html_attribution");
function initMap() {
  var userLoc = {lat: 33.810188, lng: -117.921142};

  /*map = new google.maps.Map(document.getElementById('map'), {
    center: userLoc,
    zoom: 15
  });*/

  infowindow = new google.maps.InfoWindow();

  var service = new google.maps.places.PlacesService(attribution[0]);
  service.nearbySearch({
    location: userLoc,
    radius: 500,
    types: ['restaurant']
  }, callback);
}

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
	  allRes=results;
    for (var i = 0; i < results.length; i++) {
      //createMarker(results[i]);
	  //alert(results[i].name);
	  createCard(results[i]);
    }
  }
}
function createCard(result)
{
		//alert("creating card");
		var cardHTML="";
		//cardHTML+="<div class='card''>\n\t<div class='card-image'>\n\t\t<!--<img src='https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference="+result.reference+"&key=AIzaSyBIg2RSi_wx3-NAbMc0-aIOac2Xf9AvV3Y'>-->\n\t\t<span class='card-title'>"+result.name+"</span></div>";
		cardHTML+="<div class='card-panel'>";
		cardHTML+="\n\t<span class='card-title'>"+result.name+"</span>";
		cardHTML+="\n\t<i class='small material_icons'>star_rate</i>";
		cardHTML+="\n\t<p></p>";
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