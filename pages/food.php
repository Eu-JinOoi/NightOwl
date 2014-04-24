<?php
/*
<div class="card_result" ><!--make page a /v[enue]/venueid-->
	<div style="float:left; margin:15px;">
           	<h3 style="margin-top:0px; margin-bottom:0px;">In-N-Out</h3>
            <h4 class='storeOpen'>Open Now</h4>
            <address>
            5646 E. La Palma<br>
            Anaheim, CA 92807
            </address>
    </div>
    <div class='card_result_icons'>
    [WF] [DT]<br>
    [24] [**]<br>
    [21+][18+]
    </div>
        <div style="clear:both;">&nbsp;</div>
</div>

<div class="card_result" onClick="loadPg('result1')"><!--make page a /v[enue]/venueid-->
	<div style="float:left;">
           	<h3>In-N-Out</h3>
            <address>
            Address Line 1<br>
            Address Line 2
            </address>
    </div>
    	<img src='http://www.in-n-out.com/images_stores/store_138.gif' style="max-width:50%; float:right;">
        <div style="clear:both;">&nbsp;</div>
</div>
*/
echo $_GET['lat'].",".$_GET['long'];
echo file_get_contents("http://nightowl.eu-niverse.com/pages/results.php?page=food&lat=".$_GET['lat']."&long=".$_GET['long']);
?>