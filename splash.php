<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Night Owl</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
	$(document).ready(function(e) {
        splashScreen();
    });
	function splashScreen()
	{
		$("#maincont").css("background-color","#4B0082");
		$("#maincont").css("text-align","center");
		$("#splashcont").html("<h1 style=''>Night Owl</h1>");
		
		$("#maincont").delay(2000)
			.stop()
			.animate({
				"background-color":"#FFFFFF",
				"text-align":"left"}, 5000, 
		function() {  // Animation complete.
		});
	}
</script>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<style>
	*
	{
		font-family: 'Roboto', sans-serif;
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
		
	}
	#splashcont
	{
		width:200px;
		margin:auto;
		margin-top:0;
		position:relative;	
		padding-top:50%;	
	}
	h1
	{
	}
</style>
</head>

<body>
	<div id='maincont' style="vertical-align:middle;">
    	<div id='splashcont'>
        
        </div>
    </div>
</body>
</html>