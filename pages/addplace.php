<div class="card_dynamic" style="color:#000;">
	<p style="padding:10px; font-weight:300;">Chances are you know about places that we don't so why not share it with everyone? While we only require that you provide us with the name of the place and it's location, we would appreciate any other information you could provide. </p>
</div>
<form>
    <div class="card_dynamic" style="color:#000;">
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
    </div>
    
</form>