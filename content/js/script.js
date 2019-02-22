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
	//param = ( typeof param != 'undefined' && param instanceof Array ) ? param : [] //https://stackoverflow.com/questions/1961528/how-to-check-if-an-array-exist-if-not-create-it-in-javascript
	if ('txt' in param) elem.appendChild(document.createTextNode(param.txt));
	if ('url' in param) elem.setAttribute('href', param.url);
	if ('onclick' in param) elem.setAttribute('onclick', param.onclick);
	if ('class' in param) elem.classList.add(param.class);
	if ('id' in param) elem.setAttribute('id', param.id);
	if ('alt' in param) elem.setAttribute('alt', param.alt);
	if ('src' in param) elem.setAttribute('src', param.src);
	return elem;
}
function deleteElement(id) {
	document.getElementById(id).parentNode.removeChild(document.getElementById(id));
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
function fullscreen(e) {
	let fullscrID = "fullscreen-"+UUID();
	console.log("Generating fullscreen with ID "+fullscrID);

	document.body.appendChild(newElement("div",{'id':fullscrID,'class':'fullscreen-image'}));//Main div
	fullscr = document.getElementById(fullscrID);
	fullscr.appendChild(newElement("div",{}));
	let imgDiv = fullscr.firstChild;

	imgDiv.appendChild(newElement("img",{'src':e.target.getAttribute('src'),'alt':e.target.getAttribute('alt')}));
	fullscr.appendChild(newElement("h1",{'txt':e.target.getAttribute('alt')}));
	fullscr.appendChild(newElement("button",{'class':'button-x','onclick':'deleteElement(\''+fullscrID+'\')','txt':'× '+langNotifClose}));
}

function notify(title,text,param) {
	let notifID = "notif-"+UUID();
	console.log("Generating notification with ID "+notifID);

	document.body.appendChild(newElement("div",{'id':notifID,'class':'notif'}));//Main div
	notif = document.getElementById(notifID);
	notif.appendChild(newElement("div",{'class':'notif-zone'}));//Notif div
	let notifZone = notif.firstChild;
	notifZone.appendChild(newElement("div",{'class':'button-area'}));
	let notifButtons = notifZone.firstChild;

	notifZone.insertBefore(newElement("h1",{'txt':title}), notifButtons);
	notifZone.insertBefore(newElement("p",{'txt':text}), notifButtons);
	if ('url' in param) notifButtons.appendChild(newElement("a",{'txt':langNotifShow,'url':param.url,'class':'input'}));
	notifButtons.appendChild(newElement("a",{'txt':langNotifClose,'onclick':'deleteElement(\''+notifID+'\')','class':'input'}))
}
