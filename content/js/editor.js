/*Text edition
https://stackoverflow.com/questions/6637341/use-tab-to-indent-in-textarea*/
if (document.getElementById("textEdit")) {
var txtarea = document.getElementById("textEdit");

function cursorPos() {
	let sel = window.getSelection();
	range = sel.getRangeAt(0);
}
cursorPos();

txtarea.onclick = function(e) {
	cursorPos();
}
txtarea.onkeyup = function(e) {
	cursorPos();
}

function addText(format,cursorMove) {
	formatStart = format.substring(0, cursorMove);
	formatEnd = format.substring(cursorMove);

	let sel = window.getSelection();
	sel.removeAllRanges();

	formatStartID = "format-"+UUID();
	range.insertNode(newElement('span',{'txt':formatStart,'class':'format-txt','id':formatStartID}));
	range.collapse()
	formatEndID = "format-"+UUID();
	range.insertNode(newElement('span',{'txt':formatEnd,'class':'format-txt','id':formatEndID}));
	range.setStartBefore(document.getElementById(formatStartID));
	range.setEndAfter(document.getElementById(formatEndID));

	txtarea.focus();
	sel.addRange(range);
}

txtarea.onkeydown = function(e) {
	let select = window.getSelection();
	latestCursorPositionStart = select.anchorOffset;
	latestCursorPositionEnd = select.focusOffset;
	if((e.shiftKey || e.shiftKey) && ((e.keyCode==9 || e.which==9) || (e.keyCode==49 || e.which==49) || (e.keyCode==50 || e.which==50))){
		switch (e.keyCode) {
			case 49:
				var textAdd = "[ib]\r\n[h1][/h1]\r\n![]()\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[/ib]";
				var selectAdd = 9;
				break;
			case 50:
				var textAdd = "[ibd]|[/ibd]";
				var selectAdd = 5;
				break;
			default:
				var textAdd = "\t";
				var selectAdd = 1;
		}
		e.preventDefault();
		addText(textAdd, selectAdd);
	}
	if ((e.keyCode == 17 || e.which == 17) || e.ctrlKey) {
		var selectAdd = 3;
		switch (e.keyCode) {
			case 73:
				e.preventDefault();
				addText("[i][/i]", selectAdd);
				break;
			case 66:
				e.preventDefault();
				addText("[b][/b]", selectAdd);
				break;
			case 83:
				e.preventDefault();
				addText("[s][/s]", selectAdd);
				break;
			case 85:
				e.preventDefault();
				addText("[u][/u]", selectAdd);
				break;
			case 79:
				e.preventDefault();
				addText("[c][/c]", selectAdd);
				break;
		}
	}
}
}
