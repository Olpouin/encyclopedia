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

function addTextElement(format,cursorMove) {
	var selectedText = txtarea.value.substring(latestCursorPositionStart, latestCursorPositionEnd);
	txtarea.value = txtarea.value.substring(0, latestCursorPositionStart) + format.substring(0, cursorMove) + selectedText + format.substring(cursorMove) + txtarea.value.substring(latestCursorPositionEnd);
	txtarea.select();
	txtarea.selectionStart = latestCursorPositionStart + cursorMove;
	txtarea.selectionEnd = txtarea.selectionStart + selectedText.length;
}

txtarea.onkeydown = function(e) {
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
		var s = this.selectionStart;
		this.value = this.value.substring(0,this.selectionStart) + textAdd + this.value.substring(this.selectionEnd);
		this.selectionEnd = s+selectAdd;
	}
}



function changeCard(url,type,name) {
	document.documentElement.classList.add("wait");
	var xhr = new XMLHttpRequest();
	xhr.responseType = "json";
	xhr.open("POST", url, true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4) {
			notify(xhr.response.title,xhr.response.message,{'url':window.location.pathname.slice(0,-5)});
			document.documentElement.classList.remove("wait");;
		}
	}

	var text = document.getElementById("textEdit").value;
	var group = document.getElementById("group").value;
	var pass = document.getElementById("pass").value;
	if (document.getElementById("hide-card").checked) var hide = "on";
	else var hide = "no"

	xhr.send("type="+type+"&name="+name+"&text="+text+"&hide-card="+hide+"&group="+group+"&pass="+pass);
}
}
