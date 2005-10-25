var txtbox=0;
var st='';

function txtsel(){
st='';
if (window.getSelection)  st=window.getSelection();
   else if (document.getSelection) st=document.getSelection();
        else if (document.selection) st=document.selection.createRange().text;

return st;
}


function curpos (textEl) {
       codeareaname=textEl.name;
       txtbox=textEl;
       if (textEl.createTextRange)
         textEl.caretPos = document.selection.createRange().duplicate();
     }

function clpSet(as)
{
 sel = document.selection.createRange();
 window.clipboardData.setData("Text",sel.text);
}


function clpGet()
{
 a = window.clipboardData.getData('Text');
 if(a==null)a='';
 einfuegen (a);
}

function einfuegen (text) {
     st=txtsel();
     if(txtbox==0){
     document[codeareaform][codeareaname].focus();
     curpos (document[codeareaform][codeareaname])
     };
     textEl=txtbox;
       if (textEl.createTextRange && textEl.caretPos) {
         var caretPos = textEl.caretPos;
         caretPos.text =
           caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
             text + ' ' : text;
       }
       else {
       textEl.value  += text;
       }

       document[codeareaform][codeareaname].focus();
       textEl.caretPos.select();

       txtbox=0; st='';
}


function trcol_on(trn,col){
 mbgc=trn.style.backgroundColor;
 trn.style.backgroundColor=col;
}
function trcol_off(trn){
 trn.style.backgroundColor=mbgc;
}




function codeDivselectAll(elementId) {
  var element = document.getElementById(elementId);
  if ( document.selection ) {
    var range = document.body.createTextRange();
    range.moveToElementText(element);
    range.select();
  }
  if ( window.getSelection ) {
    var range = document.createRange();
    range.selectNodeContents(element);
    var blockSelection = window.getSelection();
    blockSelection.removeAllRanges();
    blockSelection.addRange(range);
  }
}

function codeDivresizeLayer(layerId, newHeight) {
  var myLayer = document.getElementById(layerId);
  myLayer.style.height = newHeight + 'px';
}

function codeDivStart(imgSrc) {
  var randomId = Math.floor(Math.random() * 2000);
  document.write('<div class="codetitle">Code:<img src="' + imgSrc + 'nav_expand.gif" width="14" height="10" title="View More of this Code" onclick="codeDivresizeLayer(' + randomId + ', 200)" onmouseover="this.style.cursor = \'pointer\'" /><img src="' + imgSrc + 'nav_expand_more.gif" width="14" height="10" title="View Even More of this Code" onclick="codeDivresizeLayer(' + randomId + ', 500)" onmouseover="this.style.cursor = \'pointer\'" /><img src="' + imgSrc + 'nav_contract.gif" width="14" height="10" title="View Less of this Code" onclick="codeDivresizeLayer(' + randomId + ', 50)" onmouseover="this.style.cursor = \'pointer\'" /><img src="' + imgSrc + 'nav_select_all.gif" width="14" height="10" title="Select All of this Code" onclick="codeDivselectAll(' + randomId + ')" onmouseover="this.style.cursor = \'pointer\'" /></div><div class="codediv" id="' + randomId + '">');
}


function showhelp(helptext,boardid){helpwindow = open("useraction.{suffix}?action=gethelp" + sess_link1 + "&BoardID=" + boardid + "&helptext=" + helptext, "Helpfenster", "width=400,height=500,dependent=yes,locationbar=no,menubar=no,status=no,resizable=yes"); helpwindow.document.write(windowtext);}
function popup(x){xwin=window.open(x + sess_link1,'vxbpopup','left=30,top=100,width=590,height=350,resizable=yes,menubar=no,toolbar=no,location=no,directories=no,scrollbars=yes,status=no'); xwin.focus();}
function newspopup(){window.open('allnews.php' + sess_link2,'NewsPopup','left=30,top=100,width=300,height=500,resizable=yes,menubar=no,toolbar=no,location=no,directories=no,scrollbars=yes,status=no');}
function nix(){return;}

function showtip(current,e,text){

if (document.all){
thetitle=text.split('<br>')
if (thetitle.length>1){
thetitles=''
for (i=0;i<thetitle.length;i++)
thetitles+=thetitle[i]
current.title=thetitles
}
else
current.title=text
}


else if (document.layers){
document.tooltip.document.write('<layer bgColor="yellow" style="border:1px solid black;font-size:12px;">'+text+'</layer>')
document.tooltip.document.close()
document.tooltip.left=e.pageX+5
document.tooltip.top=e.pageY+5
document.tooltip.visibility="show"
}
}

function hidetip(){

if (document.layers)
document.tooltip.visibility="hidden"
}


function editor_insertHTML(objname, str1) {
          if (str1 == null) { str1 = ''; }
          if (document.all[objname]) {
                document.all[objname].focus();
                var ThisCode = str1;
                if (ThisCode)
                        {
                        text = ' '+ThisCode+' ';
                        if (document.all[objname].createTextRange && document.all[objname].caretPos)
                                {
                                var caretPos = document.all[objname].caretPos;
                                caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
                                document.all[objname].focus();
                                }
                        else
                                {
                                document.all[objname].value  += text;
                                document.all[objname].focus();
                                }
                        }
                return;
          }
        }
function storeCaret(textEl)
        {
        if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
        }


function run_uhrzeit() { setInterval('time()',1000);}

function time() {
zeit = new Date();
var hour = zeit.getHours();
var min = zeit.getMinutes();
var sec = zeit.getSeconds();
if (hour < 10) { hour = "0" + hour; }
if (min < 10) { min = "0" + min; }
if (sec < 10) { sec = "0" + sec; }

 if(navigator.appName == "Netscape") {
document.time.innerText = "" + hour + ":" + min + ":" + sec + "";
 }
 if (navigator.appVersion.indexOf("MSIE") != -1){
  if (navigator.appVersion.indexOf("Mac") == -1){
document.all.time.innerText = "" + hour + ":" + min + ":" + sec + "";
}}
}
