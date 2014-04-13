<h1>This is Entertainment!</h1>
<style>
.open, .closed, .unknown
{
	color:#000;	
	margin:auto;
	width: 97%;
	min-height:100px;
	height:25%;
	margin-top:1%;
	margin-bottom:1%;
	background-color: #E6E6E6;
	z-index:44445;
	position:relative;
	cursor:pointer;
	padding-left:5px;
}
.openT, .closedT, .unknownT
{
	color:#000;	
	margin:auto;
	width: 97%;
	min-height:100px;
	height:25%;
	margin-top:1%;
	margin-bottom:1%;
	background-color: #E6E6E6;
	z-index:44445;
	position:relative;
	cursor:pointer;
}
.open
{
	border-left:3px solid green;
}
.closed
{
	border-left:3px solid red;
}
.unknown
{
	border-left:3px solid gray;
}
.openT .triangle, .closedT .triangle, .unknownT .triangle
{
	width: 0px;
	height: 0px;
	border-style: solid;
	border-width: 30px 30px 0 0;	
}
.openT .triangle
{
	border-color: green transparent transparent transparent;	
}
.closedT .triangle
{
	border-color: red transparent transparent transparent;	
}
.unknownT .triangle
{
	border-color: gray transparent transparent transparent;	
}
.cardCont
{
	margin-top:-30px;
	padding-left:25px;
}
.cardCont h2
{
	margin-top:0;
	margin-bottom:0;	
}
</style>
<div style="" class='open'>
	<h2>This place is open</h2>
    All other details go in here.
</div>
<div style="" class='closed'>
	<h2>This place is closed</h2>
    All other details go in here.
</div>
<div style="" class='unknown'>
	<h2>Unknown if this place is open or closed.</h2>
    All other details go in here.
</div>
<hr>
<h1>Alternate Layout</h1>
<div style="" class='openT'>
	<div class='triangle'>&nbsp;</div>
    <div class='cardCont'>
        <h2>This place is open</h2>
        All other details go in here.
    </div>
</div>
<div style="" class='closedT'>
	<div class='triangle'>&nbsp;</div>
    <div class='cardCont'>
        <h2>This place is closed</h2>
        All other details go in here.
    </div>
</div>
<div style="" class='unknownT'>
	<div class='triangle'>&nbsp;</div>
    <div class='cardCont'>
        <h2>Unknown if this place is open or closed.</h2>
        All other details go in here.
    </div>
</div>