/*Cookies functions*/
function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function newElement(type,param) {
	var elem = document.createElement(type);
	if ('txt' in param) elem.appendChild(document.createTextNode(param.txt));
	if ('url' in param) elem.setAttribute('href', param.url);
	if ('onclick' in param) elem.setAttribute('onclick', param.onclick);
	if ('class' in param) elem.classList.add(param.class);
	if ('id' in param) elem.setAttribute('id', param.id);
	return elem;
}

/*Generate UUID*/
function UUID() {
	var S4 = function() {
		return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
	};
	return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}
/*Parameters*/
function changeParameters() {
	if (document.querySelector('#nightmode').checked) {
		document.cookie = "nightmode=true; expires=Thu, 18 Dec 9999 12:00:00 UTC;"
	} else {
		document.cookie = "nightmode=false; expires=Thu, 18 Dec 9999 12:00:00 UTC;"
	}

	document.cookie = "lang="+document.getElementById('pref-chooseLang').value+"; expires=Thu, 18 Dec 9999 12:00:00 UTC;";

	checkParameters();
}
function checkParameters() {
	if (document.cookie.split(';').filter((item) => item.includes('nightmode=true')).length) {
		document.getElementById('mainColorsCSS').innerHTML = document.getElementById('css_nightmode').innerHTML;
		if (document.querySelector('#nightmode')) document.querySelector('#nightmode').checked = true;
	} else {
		document.getElementById('mainColorsCSS').innerHTML = document.getElementById('css_daymode').innerHTML;
	}
	if (document.getElementById('pref-chooseLang')) {
		if (getCookie('lang').length != 0) document.getElementById('pref-chooseLang').value = getCookie('lang');
		else document.getElementById('pref-chooseLang').value = "fr";
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
	document.getElementById("fs-img_img").setAttribute("alt", e.target.getAttribute('alt'));

	document.getElementById("sidenav").style.filter = "blur(3px)";
	document.getElementById("card").style.filter = "blur(3px)";

	document.getElementById("fullscreen-image").classList.add("open");
}

function closeImg() {
	document.getElementById("sidenav").style.filter = "";
	document.getElementById("card").style.filter = "";
	document.getElementById("fullscreen-image").classList.remove("open");
}

function notify(title,text,URL) {
	let notifID = "notif-"+UUID();
	console.log("Generating notification with ID "+notifID)

	document.body.appendChild(newElement("div",{'id':notifID,'class':'notif'}));//Main div
	notif = document.getElementById(notifID);
	notif.appendChild(newElement("div",{'class':'notif-zone'}));//Notif div
	notifZone = notif.firstChild;
	notifZone.appendChild(newElement("div",{'class':'button-area'}));
	notifButtons = notifZone.firstChild;

	notifZone.insertBefore(newElement("h1",{'txt':title}), notifButtons);
	notifZone.insertBefore(newElement("p",{'txt':text}), notifButtons);
	notifButtons.appendChild(newElement("a",{'txt':langNotifShow,'url':URL,'class':'input'}));
	notifButtons.appendChild(newElement("a",{'txt':langNotifClose,'onclick':'document.getElementById(\''+notifID+'\').parentNode.removeChild(document.getElementById(\''+notifID+'\'))','class':'input'}))
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
			notify(xhr.response.title,xhr.response.message,window.location.pathname.slice(0,-5));
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
