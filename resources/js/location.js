/*$(document).ready(function(e) 
{
	getLocation();
});*/
function getLocation()
{
	if (navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(showPosition);
		
	}
	else
	{
	//x.innerHTML="Geolocation is not supported by this browser.";
		lat.val(-1);
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
		//var ndata=current+"<br><span id='locationDesc'>"+data.results[2].formatted_address.substr(0,data.results[2].formatted_address.lastIndexOf(","))+"</span>";
		//var ndata=current+"<br><span id='locationDesc'>"+data.results[2].formatted_address+"</span>";
		$("#Nlocation").html(ndata);
	});
}
