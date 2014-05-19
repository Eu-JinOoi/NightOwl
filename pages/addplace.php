<div class="card" style="color:#fff; background-color:#0755e6;">
	<p style="padding:10px; font-weight:300;">Chances are you know about places that we don't so why not share it with everyone? While we only require that you provide us with the name of the place and it's location, we would appreciate any other information you could provide. </p>
</div>
<form>
    <!--<div class="card_dynamic" style="color:#000;">
            Venue Name <input type="text" name='vname' id='vname' style="max-width:100%;"><br>
            Address <input type='text' name='vlocation' id='vlocation'><br>
            
    </div>
    <div class="card_dynamic" style="color:#000;">
            Phone Number <input type='text' name='vphone' id='vphone'><br>
            
            Drive Thru <input type='checkbox' value="1" name='vdt' id='vdt' onChange="driveThruHours();">
            
            Does this place have...<br>
            WiFi <input type='checkbox' value="1" name='vwifi' id='vwifi'>
            
            24 Hour Location <input type='checkbox' value="1" name='h24' id='h24'>
            Must be over 18 <input type='checkbox' value="1" name='a18' id='a18'>
            Must be over 21 <input type='checkbox' value="1" name='a21' id='a21'>
            <br><input type="button" name="Submit" value="Add Place">
        
    </div>
    <div class="card_dynamic" style="color:#000;">
    	<h3>New Hours Card</h3>
        <div id='dayDiv'>
        	<span class='day' id='dayM' onClick="daySelect('M');">M</span>
            <span class='day' id='dayT' onClick="daySelect('T');">T</span>
            <span class='day' id='dayW' onClick="daySelect('W');">W</span>
            <span class='day' id='dayR' onClick="daySelect('R');">T</span>
            <span class='day' id='dayF' onClick="daySelect('F');">F</span>
            <span class='day' id='dayS' onClick="daySelect('S');">S</span>
            <span class='day' id='dayU' onClick="daySelect('U');">S</span>
            <div style="clear:both;">&nbsp;</div>
        </div>
        <div id='hourDiv'>
        	<div class='hours' id='h_M'>
                Open<input type="time" id='nho_m' name='nho_m'>
                Close<input type="time" id='nhc_m' name='nhc_m'>
                <span class='dth'><br>Drive Thru<input type="time" id='dt_m' name='dt_m'></span>
            </div>
        </div>
        
        
    </div>
    <div class="card_dynamic" style="color:#000;">
    	<h3>Business Hours</h3>
        <table style="border-spacing:10px;">
        	<tr>
            	<th>Day</th>
                <th>Normal Hours</th>
            </tr>
        	<tr>
            	<td>
                	Monday
                	<span class='dth'><br>Drive Thru</span>
                </td>
                <td>
                	<input type="time" id='nh_m' name='nh_m'>
                	<span class='dth'><br><input type="time" id='dt_m' name='dt_m'></span>
                </td>
               
            </tr>
            <tr>
            	<td>
                	Tuesday
                	<span class='dth'><br>Drive Thru</span>
                </td>
                <td>
                	<input type="time" id='nh_t' name='nh_t'>
                	<span class='dth'><br><input type="time" id='dt_t' name='dt_t'></span>
                </td>
               
            </tr>
        </table>
    </div>-->
    <div class="card">
    	<div style='margin:5px;'>
            <h2>What and Where</h2>
             Name<br>
             <input type="text" name='vname' id='vname' style="width:95%;"><br>
             Address - All of it<br>
             <input type='text' name='vlocation' id='vlocation' style="width:95%;"><br>
             <input type='hidden' name='vlat' id='vlat'>
             <input type='hidden' name='vlon' id='vlon'>
             Category<br>
             <select id='vcat' name='vcat'>
             	<option value="-1">----</option>
             	<option value="food">Food</option>
                <option value="entertainment">Entertainment</option>
                <option value="shopping">Shopping</option>
                <option value="events">Events</option>
             </select>
         </div>
    </div>
    
    <div class="card">
    	<div style='margin:5px;'>
            <h2>What's it like?</h2>
        	<h3>It has...</h3>
            Wifi <input type="checkbox" id="wifi" name='wifi'>
            Drive Thru <input type="checkbox" id="drivethru" name='drivethru'>     
            Alcohol <input type="checkbox" id="alcohol" name='alcohol'>       
            <h3>You should...</h3>
            be over 18 <input type="checkbox" id="age_18" name='age_18'> <br>
            be over 21 <input type="checkbox" id="age_21" name='age_21'> <br>
            be dressed...<br>
            	<select id='dresscode' name='dresscode'>
	                <option value='-1'>----</option>
                	<option>Casual</option>
                    <option>Business Casual</option>
                    <option>Formal</option>
                    <option>Anything Goes</option>
                </select>
        </div>
    </div>
    <div class="card">
    	<div style='margin:5px;'>
            <h2>When is it open?</h2>
            <?php
			$dz=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			for($i=0;$i<7;$i++)
			{
				echo "<h3>".$dz[$i]."</h3>";
				echo "Open 24 hours <input type='checkbox' name='open24_".$i."' id='open24_".$i."' onChange='hideDay(this);'>";
				echo "Closed <input type='checkbox' name='closed_".$i."' id='closed_".$i."' onChange='hideDay(this);'><br>";
				echo "<label for='open_".$i."' id='lopen_".$i."'>Open:</label>\n"; 
	            echo "<input type='time' name='open_".$i."' id='open_".$i."' style='width:95%;'><br>\n";
				echo "<label for='close_".$i."' id='lclose_".$i."'>Close:</label>\n";
			    echo "<input type='time' name='close_".$i."' id='close_".$i."' style='width:95%;'><br>\n";
			}
			?>
             <!--Sunday Open:<br>
             <input type="time" name="open_0" id="open_0" style="width:95%;"><br>
             Sunday Close:<br>
             <input type="time" name="close_0" id="close_0" style="width:95%;"><br>-->
             
            
         </div>
    </div>
    
</form>

<script>
function hideDay(element)
{
	//var eid=(element.id).substr(2,element.id.length-3);
	var field="#"+element.id;
	var isChecked=$(field).is(":checked");
	var dow=$(field).attr("id").match(/\d+/);
	if(isChecked)
	{
		//alert(element.id + " is checked");	
		$("#lopen_"+dow).hide();
		$("#open_"+dow).hide();
		$("#lclose_"+dow).hide();
		$("#close_"+dow).hide();
	}
	else
	{
		//alert(element.id + " is NOT checked");		
		$("#lopen_"+dow).show();
		$("#open_"+dow).show();
		$("#lclose_"+dow).show();
		$("#close_"+dow).show();
	}
}	
</script>