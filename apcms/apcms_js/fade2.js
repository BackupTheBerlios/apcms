/*** Create some global variables ***/
var LinkFadeRunning=false;
var LinkFadeInterval=4;
var LinkSteps=20;
var LinkStartColor="417092";
var LinkEndColor="F4B82B";

if (navigator.userAgent.indexOf("MSIE") != -1)
{
    document.onmouseover = theOnOver;
    document.onmouseout  = theOnOut;
}
else
{
    document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
    document.onmouseover = theOnOver;
    document.onmouseout  = theOnOut;
}
function getStartColor(el)
{
        if (el.currentStyle)
                return (el.currentStyle.color).slice(1,8);
        else if (document.defaultView)
        {
//              alert("color=[" + document.defaultView.getComputedStyle(el,'').getPropertyValue('color') + "]");
                return LinkStartColor;
        }
        else
                return LinkStartColor;
}


function findObj1(o)
{
      while (o && o.tagName != 'A')
            o = o.parentElement;
        return(o);
}
function findObj2(o)
{
      while (o && o.nodeName != 'A')
            o = o.parentNode;
        return(o);
}
function theOnOver(e)
{
        var lnk;
        if(window.event)
                lnk=findObj1(event.srcElement);
        else
                lnk=findObj2(e.target);

        if(lnk)
        {
                if(lnk.state == null)
                {
                        lnk.state = "OFF";
                        lnk.index = 0;
                        lnk.startColor = getStartColor(lnk);
                }

                if(lnk.state == "OFF")
                {
                        lnk.state = "FADE_UP";
                        start_fading();
                }
                else if( lnk.state == "FADE_UP_DOWN"
                        || lnk.state == "FADE_DOWN")
                {
                        lnk.state = "FADE_UP";
                }
        }
}
function theOnOut(e)
{
        var lnk;
        if(window.event)
                lnk=findObj1(event.srcElement);
        else
                lnk=findObj2(e.target);

        if(lnk)
        {
                if(lnk.state=="ON")
                {
                        lnk.state="FADE_DOWN";
                        start_fading();
                }
                else if(lnk.state == "FADE_UP")
                {
                        lnk.state="FADE_UP_DOWN";
                }
        }
}

var hexDigit=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");

function dec2hex(dec)
{
        return(hexDigit[dec>>4]+hexDigit[dec&15]);
}

function hex2dec(hex)
{
        return(parseInt(hex,16))
}
function getColor(f)
{
        var r1 = hex2dec(f.startColor.slice(0,2));
        var g1 = hex2dec(f.startColor.slice(2,4));
        var b1 = hex2dec(f.startColor.slice(4,6));

        var r2 = hex2dec(LinkEndColor.slice(0,2));
        var g2 = hex2dec(LinkEndColor.slice(2,4));
        var b2 = hex2dec(LinkEndColor.slice(4,6));

        var r = Math.floor(r1+(f.index*(r2-r1))/(LinkSteps) + .5);
        var g = Math.floor(g1+(f.index*(g2-g1))/(LinkSteps) + .5);
        var b = Math.floor(b1+(f.index*(b2-b1))/(LinkSteps) + .5);

        return("#" + dec2hex(r) + dec2hex(g) + dec2hex(b));
}
function setColor(lnk)
{
        var theColor=getColor(lnk);
        lnk.style.color=theColor;
}
function start_fading()
{
        if(!LinkFadeRunning)
                LinkFadeAnimation();
}
function LinkFadeAnimation()
{
        LinkFadeRunning = false;
        for(i=0 ; i<document.links.length ; i++)
        {
                var lnk = document.links[i];
                if(lnk.state)
                {
                        if(lnk.state == "FADE_UP")
                        {
                                if(lnk.index < LinkSteps)
                                        lnk.index++;
                                else
                                        lnk.index = LinkSteps;
                                setColor(lnk);

                                if(lnk.index == LinkSteps)
                                        lnk.state="ON";
                                else
                                        LinkFadeRunning = true;
                        }
                        else if(lnk.state == "FADE_UP_DOWN")
                        {
                                if(lnk.index < LinkSteps)
                                        lnk.index++;
                                else
                                        lnk.index = LinkSteps;
                                setColor(lnk);

                                if(lnk.index == LinkSteps)
                                        lnk.state="FADE_DOWN";
                                LinkFadeRunning = true;
                        }
                        else if(lnk.state == "FADE_DOWN")
                        {
                                if(lnk.index > 0)
                                        lnk.index--;
                                else
                                        lnk.index = 0;
                                setColor(lnk);

                                if(lnk.index == 0)
                                        lnk.state="OFF";
                                else
                                        LinkFadeRunning = true;
                        }
                }
        }
        /*** Check to see if we need to animate any more frames. ***/
        if(LinkFadeRunning)
                setTimeout("LinkFadeAnimation()", LinkFadeInterval);
}