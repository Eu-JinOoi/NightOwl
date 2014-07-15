// JavaScript Document
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