function selectAll(elementId) {
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

function resizeLayer(layerId, newHeight) {
  var myLayer = document.getElementById(layerId);
  myLayer.style.height = newHeight + 'px';
}

function codeDivStart() {
  var randomId = Math.floor(Math.random() * 2000);
  document.write('<div class="codetitle">&nbsp;&raquo;&nbsp;&lt;?php Code:&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/icons/nav_expand.gif" width="14" height="10" title="vergrössere das Code Feld" onclick="resizeLayer(' + randomId + ', 200)" onmouseover="this.style.cursor = \'pointer\'" /><img src="images/icons/nav_expand_more.gif" width="14" height="10" title="maximiere das Codefeld" onclick="resizeLayer(' + randomId + ', 500)" onmouseover="this.style.cursor = \'pointer\'" /><img src="images/icons/nav_contract.gif" width="14" height="10" title="minimiere das Codefeld" onclick="resizeLayer(' + randomId + ', 50)" onmouseover="this.style.cursor = \'pointer\'" /><img src="images/icons/nav_select_all.gif" width="14" height="10" title="gesamten Code markieren" onclick="selectAll(' + randomId + ')" onmouseover="this.style.cursor = \'pointer\'" /></div><div class="codediv" id="' + randomId + '">');
}