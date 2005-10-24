
 var poll_options = pollform.poll_options;
 var option = pollform.option;


 function trim(string) {
  string = string.replace(/^\s*/,"");
  string = string.replace(/\s*$/,"");
  return string;
 }
  
 
 function SetPollIndex() {
  index=poll_options.selectedIndex;
  if(index!=-1) option.value = poll_options.options[index].text;
 }
 
 function DeletePollEntry() {
  index=poll_options.selectedIndex;
  if(index!=-1) {
   poll_options.options[index] = null;
   option.value="";
   option.focus();
  }
 }

 function AddPollEntry() {
  optionvalue = trim(option.value);  
  if(optionvalue!="") {
   count=poll_options.length;
   if(count>=maxanswers) alert(bpoll_lang9 + maxanswers + bpoll_lang9_2);
   else {
    newoption = new Option(optionvalue);
    poll_options.options[count] = newoption;
    poll_data_newid++;
    poll_options.options[count].value='add'+poll_data_newid;
    option.value="";
    poll_options.selectedIndex=-1;
    option.focus();
   }
  } 
 }
  
 function EditPollEntry() {
  index=poll_options.selectedIndex;
  optionvalue = trim(option.value);
  if(index!=-1) {
   if(optionvalue!="") {
    poll_options.options[index].text = optionvalue;
    option.value="";
    poll_options.selectedIndex=-1;
    option.focus();
   }
  }
  else AddPollEntry();
 }
 
 function ItemPollUp() {
  index=poll_options.selectedIndex;
  if(index!=-1 && index!=0) {
   tmp_txt = poll_options.options[index-1].text;
   tmp_val = poll_options.options[index-1].value;
   poll_options.options[index-1].text = poll_options.options[index].text;
   poll_options.options[index-1].value = poll_options.options[index].value;   
   poll_options.options[index].text = tmp_txt;
   poll_options.options[index].value = tmp_val;
   poll_options.selectedIndex = index-1;
  }
 }
 
 function ItemPollDown() {
  index=poll_options.selectedIndex;
  count=poll_options.length;
  if(index!=-1 && index!=count-1) {
   tmp_txt = poll_options.options[index+1].text;
   tmp_val = poll_options.options[index+1].value;
   poll_options.options[index+1].text = poll_options.options[index].text;
   poll_options.options[index+1].value = poll_options.options[index].value;   
   poll_options.options[index].text = tmp_txt;
   poll_options.options[index].value = tmp_val;
   poll_options.selectedIndex = index+1;
  }
 }
 
 function ItemPollTop() {
  doindex=poll_options.selectedIndex;
  if(doindex!=-1 && doindex!=0) {
   for(i=0;i<doindex;i++) {
    ItemPollUp();
   }
  }
 }
 
 function ItemPollBottom() {
  doindex=poll_options.selectedIndex;
  docount=poll_options.length;
  if(doindex!=-1 && doindex!=docount-1) {
   for(i=0;i<(docount-1-doindex);i++) ItemPollDown();
  }
 }
 
 function PollFormSubmit() {

   if(cancelvoting==1) return true;
   
   if(pollform.poll_titel.value=="") alert(bpoll_lang34);
   else if(poll_options.length<2) alert(bpoll_lang11);
   else if(poll_options.length<parseInt(pollform.multiplevotes[pollform.multiplevotes.selectedIndex].value)) alert(bpoll_lang12);
   else {
    for(i=0;i<poll_options.length;i++) {

     pollform.poll_datas_txt.value += poll_options.options[i].text +'\n§#§';
     pollform.poll_datas_val.value += poll_options.options[i].value +'\n§#§';
    
    }
    return true;
   
   }
   return false;
 }
 
