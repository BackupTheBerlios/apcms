<!--
var blinkColTbl = new Array();
blinkColTbl[0] = "red";
blinkColTbl[1] = "black";

var blinkTimeout = 1000;

function blinky() {
var blinkTimeout = 10000;
blink();
}
function zucki() {
var blinkTimeout = 20000;
blink();}

var blinkIdx = 0;
function blink () {
if ( document.all && document.all.blink ) {
blinkIdx = (blinkIdx+=1) % 2 ;
var color = blinkColTbl [ blinkIdx ];
if ( document.all.blink.length ) {
for(i=0;i<document.all.blink.length;i++)
document.all.blink[i].style.color=color;
} else
document.all.blink.style.color=color;
setTimeout( "blink();" , blinkTimeout);
}
}
//-->


