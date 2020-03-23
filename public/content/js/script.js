//Get Cookies's data
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
//generate special ID
function UUID() {
	var S4 = function() {
		return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
	};
	return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}
//Page elements creations/removing
function newElement(type,param) {
	var elem = document.createElement(type);
	if ('txt' in param) elem.appendChild(document.createTextNode(param.txt));
	if ('class' in param) elem.classList.add(param.class);
	if ('attr' in param) {
		for (prop in param.attr) {
			elem.setAttribute(prop, param.attr[prop]);
		}
	}
	return elem;
}
//smalls functions to make code shorter
function deleteElement(id) {
	document.getElementById(id).parentNode.removeChild(document.getElementById(id));
}
function value(ID) {
	return document.getElementById(ID).value;
}
////Parameters
//Change
function changeParameters() {
	document.cookie = "theme="+document.getElementById('pref-theme').value+"; expires=Thu, 18 Dec 9999 12:00:00 UTC;";

	document.cookie = "lang="+document.getElementById('pref-chooseLang').value+"; expires=Thu, 18 Dec 9999 12:00:00 UTC;";

	document.cookie = (document.querySelector('#prefeditor').checked) ? "prefeditor=txt; expires=Thu, 18 Dec 9999 12:00:00 UTC;" : "prefeditor=html; expires=Thu, 18 Dec 9999 12:00:00 UTC;";

	document.cookie = (document.querySelector('#dyslexic').checked) ? "dyslexic=true; expires=Thu, 18 Dec 9999 12:00:00 UTC;" : "dyslexic=false; expires=Thu, 18 Dec 9999 12:00:00 UTC;";

	location.reload();
}
//http requests function
function API(APIname,data,redirect) {
	document.documentElement.classList.add("wait");
	let url = path+"/api/"+APIname+".php";
	let xhr = new XMLHttpRequest();
	xhr.responseType = "json";
	xhr.open("POST", url, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4) {
			if (xhr.response === null) {;
				var title = "Erreur serveur";
				var message = "Nous n'avons pas pu obtenir de réponse du serveur.";
			} else {
				var title = xhr.response.title;
				var message = xhr.response.message;
			}
			notify(title,message,{'url':redirect});
			document.documentElement.classList.remove("wait");
		}
	}

	xhr.send(JSON.stringify(data));
}
//Navigation bar for mobile users
function openNav() {
    document.getElementById("sidenav").classList.add("open");
}
function closeNav() {
    document.getElementById("sidenav").classList.remove("open");
}
//Larger size pictures
function fullscreen(e) {
	let fullscrID = "fullscreen-"+UUID();
	console.debug("%cGallery","color:#003399;background-color:#FFFFFF;border-radius:100%;padding:5px;","Generating fullscreen image with ID "+fullscrID);

	document.body.appendChild(newElement("div",{'class':'fullscreen-image','attr':{'id':fullscrID}}));//Main div
	fullscr = document.getElementById(fullscrID);
	fullscr.appendChild(newElement("div",{}));
	let imgDiv = fullscr.firstChild;

	imgDiv.appendChild(newElement("img",{'attr':{'src':e.target.getAttribute('src'),'alt':e.target.getAttribute('alt')}}));
	fullscr.appendChild(newElement("h1",{'txt':e.target.getAttribute('alt')}));
	fullscr.appendChild(newElement("button",{'class':'button-x','txt':'× Fermer','attr':{'onclick':'deleteElement(\''+fullscrID+'\')'}}));
}
//notification system
function notify(title,text = "",buttons = {}) {
	let notifID = "notif-"+UUID();
	console.debug("%cGallery","color:#003399;background-color:#FFFFFF;border-radius:100%;padding:5px;","Generating notification with ID "+notifID);

	document.body.appendChild(newElement("div",{'class':'notif','attr':{'id':notifID}}));//Main div
	notif = document.getElementById(notifID);
	notif.appendChild(newElement("div",{'class':'notif-zone'}));//Notif div
	let notifZone = notif.firstChild;
	notifZone.appendChild(newElement("div",{'class':'button-area'}));
	let notifButtons = notifZone.firstChild;

	notifZone.insertBefore(newElement("h1",{'txt':title}), notifButtons);
	notifZone.insertBefore(newElement("p",{'txt':text}), notifButtons);
	if ('url' in buttons) notifButtons.appendChild(newElement("a",{'txt':'Afficher','class':'button','attr':{'href':buttons.url}}));
	notifButtons.appendChild(newElement("a",{'txt':'Fermer','class':'button','attr':{'onclick':'deleteElement(\''+notifID+'\')'}}))
}
