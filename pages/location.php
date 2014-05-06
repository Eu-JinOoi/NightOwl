<div class='darkcard'>
    <h1 style='margin-left:10px; margon-top:0;'>Location Settings</h1>
    
    <div style='margin-left:10px; line-height:50px;'>
    	<div style='margin:auto; margin-left:10px;'>
        	<h2 style="margin-bottom:0;">Detect Location</h2>
	    	Current Location: <span id='location_currentlocation'>Unknown</span><br>
    		
        </div>
        <div class='button' onClick="getLocation();" style="float:none;">Update Location</div>
        <div style="text-align:center; line-height:normal"><hr style="float:left; width:45%; text-align:center;">OR<hr style="float:right; width:45%;"></div>
        <div style='margin:auto; margin-left:10px;'>
        	<h2 style="margin-bottom:0;">Manually Set Location</h2>
            <span>Please enter a location description.</span>
            <input id='location_manual' name='location_manual' type="text">
       	</div>
        <div class='button' onClick="setLocation();" style="float:none;">Manually Set Location</div>
    </div>
</div>
<script>
function setLocation()
{
	var location=$("#location_manual").val();
		var ndata="";
	var postal="";
	if(location=="")
	{
		alert("Please enter a location.");
		return;	
	}

	$.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+location+"&sensor=true",function( data ) {
		for(var i=0; i<data.results.length;i++)
			{
				if(data.results[i].types[0]=="locality" && data.results[i].types[1]=="political")
				{
					alert("In Reg");
					var cpos=(data.results[i].formatted_address).indexOf(",");
					if((data.results[i].formatted_address).indexOf(",",cpos)==-1)
					{
						
					}
					else
					{
						ndata=(data.results[i].formatted_address).substr(0,(data.results[i].formatted_address).indexOf(",",cpos+1));
					}
				}
				if(data.results[i].types[0]=="postal_code")
				{
					var cpos=(data.results[i].formatted_address).indexOf(",");
					postal=(data.results[i].formatted_address).substr(0,(data.results[i].formatted_address).indexOf(",",cpos+1));
				}
				
	
			}	
	    selfLat=data.results[0].geometry.location.lat;
		selfLong=data.results[0].geometry.location.lng;
		if(ndata=="")
			ndata=postal;
		citystate=ndata;
		$("#location_currentlocation").html(citystate);		
		if($("#locationDesc").length==0)
		{
			ndata=current+"<div id='locationDesc'>"+citystate+"</div>";
			$("#Nlocation").html(ndata);
		}
		else
		{
			$("#locationDesc").html(citystate);
		}
		$("#location_currentlocation").html(citystate);		
	});	
}
</script>
