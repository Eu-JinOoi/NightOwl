<div class='card' style="background-color:#222222; color:#eee; border-left:3px solid #196a9f;">
    <h1 style='margin-left:10px;'>Settings</h1>
    <div style='margin-left:10px; line-height:50px;'>
    
    
    
    <div style='float:left; width:85px;'>Data Saver</div>
    <div class='eutoggle' style="position:relative; float:left;" >
    	<div class='eutoggleon' style="float:left; width:50px; height:50px; line-height:50px; text-align:center; background-color:#196a9f; position:relative;">
        On
        </div>
        <div class='eutoggleon' style="float:left; width:50px; height:50px; line-height:50px;  text-align:center; background-color:#fc6e51; position:relative;">
        Off
        </div>
        <div class='eutoggletoggle' style='height:50px; width:50px; position:absolute; left:50px; background-color:#cdcdcd;' onClick="toggletoggle(this);">&nbsp;</div>
        <div class='clear' style="height:10px;">&nbsp;</div>
    </div>
    <div class='clear'>&nbsp;</div>
    
    
   <div style='float:left; width:85px;'> Night Mode</div>
    <div class='eutoggle' style="position:relative; float:left;" >
    	<div class='eutoggleon' style="float:left; width:50px; height:50px; line-height:50px; text-align:center; background-color:#196a9f; position:relative;">
        On
        </div>
        <div class='eutoggleon' style="float:left; width:50px; height:50px; line-height:50px;  text-align:center; background-color:#fc6e51; position:relative;">
        Off
        </div>
        <div class='eutoggletoggle' style='height:50px; width:50px; position:absolute; left:50px; background-color:#cdcdcd;' onClick="toggletoggle(this);">&nbsp;</div>
        <div class='clear'>&nbsp;</div>
    </div>
    <div class='clear'>&nbsp;</div>
    </div>
</div>
<script>
position=0;//0 is off
function toggletoggle(self)
{
	if(position==0)
	{
		//$(self).children("eutoggletoggle").stop().animate({"left":"0px"});
		$(self).stop().animate({"left":"0px"});
		position=1;
	}
	else
	{
		$(self).stop().animate({"left":"50px"});
		position=0;	
	}
}
</script>