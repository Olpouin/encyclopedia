/*Parameters*/
function changeParameters() {
	if (document.querySelector('#nightmode').checked) {
		document.cookie = "nightmode=true; expires=Thu, 18 Dec 9999 12:00:00 UTC;"
	} else {
		document.cookie = "nightmode=false; expires=Thu, 18 Dec 9999 12:00:00 UTC;"
	}
	checkParameters();
}
function checkParameters() {
	if (document.cookie.split(';').filter((item) => item.includes('nightmode=true')).length) {
		document.getElementById('mainColorsCSS').innerHTML = document.getElementById('css_nightmode').innerHTML;
		document.querySelector('#nightmode').checked = true;
	} else {
		document.getElementById('mainColorsCSS').innerHTML = document.getElementById('css_daymode').innerHTML;
	}
}
checkParameters();
/*Others*/

function openNav() {
    document.getElementById("sidenav").classList.add("open");
}

function closeNav() {
    document.getElementById("sidenav").classList.remove("open");
}

function openImg(e) {
	document.getElementById("fs-img_title").innerHTML = e.target.getAttribute('alt');
	document.getElementById("fs-img_img").setAttribute("src", e.target.getAttribute('src'));

	document.getElementById("sidenav").style.filter = "blur(3px)";
	document.getElementById("card").style.filter = "blur(3px)";

	document.getElementById("fullscreen-image").classList.add("open");
}

function closeImg() {
	document.getElementById("sidenav").style.filter = "";
	document.getElementById("card").style.filter = "";
	document.getElementById("fullscreen-image").classList.remove("open");
}

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
	if((e.shiftKey || e.shiftKey) && ((e.keyCode==9 || e.which==9) || (e.keyCode==49 || e.which==49) || (e.keyCode==50 || e.which==50) || (e.keyCode==51 || e.which==51))){
		switch (e.keyCode) {
			case 49:
				var textAdd = "[ib]\r\n[h1][/h1]\r\n![]()\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[/ib]";
				var selectAdd = 9;
				break;
			case 50:
				var textAdd = "[quote][author][/author][/quote] ";
				var selectAdd = 7;
				break;
			case 51:
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
}
