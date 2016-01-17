<!DOCTYPE html>
<html>
<head>
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/v2/resources/materialize/css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<header>
    <nav class="top-nav indigo darken-4">
		<div class="container">
			<div class="nav-wrapper" style="font-size:3em;"><a class="page-title">Night Owl</a></div>
		</div>
	</nav>
</header>
<main>
   	<div class="container">
		<div class="row">
        	<div class='col s12 m6 l4'>
            	<div class="card-panel light-blue lighten-5">
                	<span class="">I am a very simple card. I am good at containing small bits of information.
                  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
                <div class="card-panel teal">
                	<span class="white-text">
                    I am a very simple card. I am good at containing small bits of information.
                  	I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
                <div class="card-panel teal">
                	<span class="white-text">I am a very simple card. I am good at containing small bits of information.
                  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
                <div class="card-panel teal">
                	<span class="white-text">I am a very simple card. I am good at containing small bits of information.
                  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
            </div>
            <div class='col s12 m6 l4'>
            	<div class="card-panel teal">
                	<span class="white-text">I am a very simple card. I am good at containing small bits of information.
                  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
            </div>
            <div class='col s12 m6 l4'>
            	<div class="card-panel">
                	<span class="blue-text">I am a very simple card. I am good at containing small bits of information.
                  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red">
      <i class="large material-icons">search</i>
    </a>
  </div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/v2/resources/materialize/js/materialize.min.js"></script>
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
	var gRawJSON="";
	
</script>
</body>
</html>