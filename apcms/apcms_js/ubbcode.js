
function apro(lang, cs, ce){

  ask2 = prompt(lang,st);
  if(ask2 != "" && ask2 != null) {
    einfuegen ("[" + cs + "]" + ask2 + "[" + ce + "]");
  }

return true;
}

function AskPrompt(action)
{

  st=txtsel();

  if(action.indexOf('=') != -1){
    var action_array = action.split('=');
    action=action_array[0];
    action2=action_array[1];
  }	
  
  switch(action) {
     case "url":
                ask1 = prompt(ubbscript_urleingeben, "http://");
                if(ask1.indexOf('/') != -1 && ask1 != "" && ask1 != null ) {
                   apro(ubtp_lang_4, 'url=' + ask1, '/url');
                }
                break;
     case "urlimg":
                ask1 = prompt(ubtp_lang_5, "http://");
                if(ask1.indexOf('/') != -1 && ask1 != "" && ask1 != null ) {
                   apro(ubtp_lang_5_1, 'url=' + ask1 + '][img', '/img][/url');
                }
                break;
     case "email":
                apro(ubbscript_email, 'email', '/email'); break;
     case "italic":
                apro(ubtp_lang_43 + ubbscript_kursiv, 'i', '/i'); break;
     case "ustrich":
                apro(ubtp_lang_43 + ubtp_lang_13, 'u', '/u'); break;
     case "lhoch":
                apro(ubtp_lang_7, 'mhoch', '/mhoch'); break;
     case "lrunter":
                apro(ubtp_lang_8, 'mrunter', '/mrunter'); break;
     case "llinks":
                apro(ubtp_lang_9, 'mlinks', '/mlinks'); break;
     case "lrechts":
                apro(ubtp_lang_10, 'mrechts', '/mrechts'); break;
     case "lwechsel":
                apro(ubtp_lang_11, 'mwechsel', '/mwechsel'); break;
     case "s":
                apro(ubtp_lang_43 + ubtp_lang_13, 's', '/s'); break;
     case "bold":
                apro(ubtp_lang_43 + ubbscript_fett, 'b', '/b'); break;
     case "dustrich":
                apro(ubtp_lang_43 + ubtp_lang_12, 'd', '/d'); break;
     case "arial":
                apro(ubtp_lang_43 + ubtp_lang_14, 'arial', '/arial'); break;
     case "comic":
                apro(ubtp_lang_43 + ubtp_lang_15, 'comic', '/comic'); break;
     case "courier":
                apro(ubtp_lang_43 + ubtp_lang_16, 'courier', '/courier'); break;
     case "verdana":
                apro(ubtp_lang_43 + ubtp_lang_17, 'verdana', '/verdana'); break;
     case "umdrehen":
                apro(ubtp_lang_43 + ubtp_lang_18, 'revL', '/revL'); break;
     case "verkehrt":
                apro(ubtp_lang_19, 'revW', '/revW'); break;
     case "quote":
                apro(ubtp_lang_43 + ubtp_lang_50, 'quote', '/quote'); break;
     case "edit":
                apro(ubtp_lang_43 + ubtp_lang_51, 'edit', '/edit'); break;
     case "del":
                apro(ubtp_lang_43 + ubtp_lang_52, 'del', '/del'); break;                                
     case "ueber2":
                apro(ubtp_lang_43 + ubtp_lang_20, 'f2', '/f2'); break;
     case "ueber3":
                apro(ubtp_lang_43 + ubtp_lang_21, 'f3', '/f3'); break;
     case "ueber4":
                apro(ubtp_lang_43 + ubtp_lang_22, 'f4', '/f4'); break;
     case "ueber5":
                apro(ubtp_lang_43 + ubtp_lang_23, 'f5', '/f5'); break;
     case "hl":
                apro(ubtp_lang_43 + ubtp_lang_46, 'hl', '/hl'); break;
     case "code":
                apro(ubtp_lang_43 + ubtp_lang_24, 'code', '/code'); break;
     case "php":
                apro(ubtp_lang_43 + ubtp_lang_47, 'php', '/php'); break;
     case "html":
                apro(ubtp_lang_43 + ubtp_lang_48, 'html', '/html'); break;
     case "linux":
                apro(ubtp_lang_43 + ubtp_lang_49, 'linux', '/linux'); break;                                                
     case "left":
                apro(ubtp_lang_43 + ubtp_lang_25, 'left', '/left'); break;
     case "center":
                apro(ubtp_lang_43 + ubtp_lang_26, 'center', '/center'); break;
     case "right":
                apro(ubtp_lang_43 + ubtp_lang_27, 'right', '/right'); break;
     case "block":
                apro(ubtp_lang_43 + ubtp_lang_28, 'block', '/block'); break;
     case "flash":
                apro(ubtp_lang_29, 'flash=300,200', '/flash'); break;
     case "glow":
                apro(ubtp_lang_43 + ubtp_lang_30, 'glow=#FF0000,3', '/glow'); break;
     case "image":
                apro(ubtp_lang_31, 'img', '/img'); break;
     case "limg":
                apro(ubtp_lang_32, 'mwechsel][img', '/img][/mwechsel'); break;
     case "mark":
                apro(ubtp_lang_43 + action2 + ubtp_lang_44, 'mark=' + action2, '/mark'); break;
     case "write":
                apro(ubtp_lang_43 + action2 + ubtp_lang_45, 'c=' + action2, '/c'); break;
     case "blink":
                apro(ubtp_lang_43 + ubtp_lang_34, 'blink', '/blink'); break;
     case "blur":
                apro(ubtp_lang_43 + ubtp_lang_35, 'blur', '/blur'); break;
     case "shadow":
                apro(ubtp_lang_43 + ubtp_lang_36, 'shadow', '/shadow'); break;
     case "wave":
                apro(ubtp_lang_43 + ubtp_lang_37, 'wave', '/wave'); break;
     case "sup":
                apro(ubtp_lang_43 + ubtp_lang_38, 'sup', '/sup'); break;
     case "sub":
                apro(ubtp_lang_43 + ubtp_lang_39, 'sub', '/sub'); break;
     case "denkblase":
                apro(ubtp_lang_43 + ubtp_lang_33, 'denk', '/denk'); break;
     case "schild":
                apro(ubtp_lang_43 + ubtp_lang_40, 'schild', '/schild'); break;
     case "copyright":
                einfuegen ("&copy;"); break;
     case "registered":
                einfuegen ("&reg;"); break;
     case "euro":
                einfuegen ("&euro;"); break;
     case "linie":
                einfuegen ("[hr]"); break;
     case "table":
                        if (navigator.userAgent.indexOf("MSIE") != -1)
                                {
                                showModalDialog("./templates/default/insert_table.html?" + textarea_name, window, "resizable: yes; help: no; status: no; scroll: no; ");
                                }
                        else
                                {
                                TOP = (screen.height / 2) - 65;
                                LEFT = (screen.width / 2) - 170;
                                MODALDIALOG = window.open("./templates/default/insert_table.html?" + textarea_name, "TABLE", "left="+LEFT+",top="+TOP+",width=340,height=130");
                                MODALDIALOG.focus();
                                }


                break;

     case "createlist":
                ask1 = prompt(ubtp_lang_41,"");

                if ((ask1 == "a") || (ask1 == "1")) {
                     mylist  = "[list="+ask1+"]\n";
                     listend = "[/list="+ask1+"]        ";
                }
                else {
                      mylist  = "[list]\n";
                      listend = "[/list] ";
                }

                ask2 = "initial";
                while ((ask2 != "") && (ask2 != null)) {
                        ask2 = prompt(ubtp_lang_42,"");
                        if ((ask2 != "") && (ask2 != null))
                             mylist = mylist+"[*]"+ask2+"\n";
                }

                if(mylist != "" && mylist != null) {
                             einfuegen (mylist+listend);
                }
                break;

  }
return true;
}


