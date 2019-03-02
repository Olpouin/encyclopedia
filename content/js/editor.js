/*Text edition
https://stackoverflow.com/questions/6637341/use-tab-to-indent-in-textarea*/
if (document.getElementById("textEdit")) {
var txtarea = document.getElementById("textEdit");

var latestCursorPositionStart = 0;
var latestCursorPositionEnd = 0;

txtarea.onblur = function(e) {
	latestCursorPositionStart = this.selectionStart;
	latestCursorPositionEnd = this.selectionEnd;
}

function addText(format,cursorMove) {
	var selectedText = txtarea.value.substring(latestCursorPositionStart, latestCursorPositionEnd);
	txtarea.value = txtarea.value.substring(0, latestCursorPositionStart) + format.substring(0, cursorMove) + selectedText + format.substring(cursorMove) + txtarea.value.substring(latestCursorPositionEnd);
	txtarea.select();
	txtarea.selectionStart = latestCursorPositionStart + cursorMove;
	txtarea.selectionEnd = txtarea.selectionStart + selectedText.length;
}

txtarea.onkeydown = function(e) {
	latestCursorPositionStart = this.selectionStart;
	latestCursorPositionEnd = this.selectionEnd;
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
		addTextElement(textAdd, selectAdd);
	}
	if ((e.keyCode == 17 || e.which == 17) || e.ctrlKey) {
		var selectAdd = 3;
		switch (e.keyCode) {
			case 73:
				var textAdd = "[i][/i]";
				e.preventDefault();
				break;
			case 66:
				var textAdd = "[b][/b]";
				e.preventDefault();
				break;
			case 83:
				var textAdd = "[s][/s]";
				e.preventDefault();
				break;
			case 85:
				var textAdd = "[u][/u]";
				e.preventDefault();
				break;
			case 79:
				var textAdd = "[c][/c]";
				e.preventDefault();
				break;
			default:
				var textAdd = "";
				var selectAdd = 0;
		}
		addTextElement(textAdd, selectAdd);
	}
}
}
