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
	if ('txt' in param) elem.innerHTML = param.txt;
	if ('class' in param) elem.classList.add(param.class);
	if ('attr' in param) {
		for (prop in param.attr) {
			elem.setAttribute(prop, param.attr[prop]);
		}
	}
	return elem;
}
//notification system
function notify(text, param) { //notify('text',{'title':'Text.','delTime': '1000','btn':[{'txt':'btn1','onclick':"func()"},{'txt':'btn2','onclick':"func2()"}]})
	var notifID = "notif-"+UUID();
	console.debug("%cDTK Notification","color:#003399;background-color:#FFFFFF;padding:5px;font-weight:bold;","Generating notification with ID "+notifID,{'text':text,'param':param});

	document.getElementById("notifs").appendChild(newElement("div",{'class':'notif','attr':{'id':notifID}}));
	let notif = document.getElementById(notifID);

	let textSpan = notif.appendChild(newElement("span",{'txt':text}));
	if (param) if ('title' in param) notif.insertBefore(newElement("b",{'txt':param.title}), textSpan);
	if (param) if ('btn' in param) {
		param.btn.forEach((item)=>{
			notif.appendChild(newElement("button",{'txt':item.txt,'attr':{'onclick':item.onclick}}));
		})
	}
	notif.innerHTML += '<svg onclick="this.parentNode.remove();" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path class="svg-color" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
	if (param) if ('delTime' in param) notif.appendChild(newElement("div",{'attr':{'style':'animation-duration:'+param.delTime+'ms;'}}));

	if (param) if ('delTime' in param) setTimeout(()=>{try{document.getElementById(notifID).remove()}catch{}}, param.delTime);
	return notif;
}
