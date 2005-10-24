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


