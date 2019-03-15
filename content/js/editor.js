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

//FORMATTING : https://codepen.io/chrisdavidmills/pen/gzYjag

function addFormat(format, param) {
	if ('prompt' in param) val = (typeof param.def !== "undefined") ? prompt("Valeur à envoyer ?", param.def) : "";
	val = (typeof param.def !== "undefined") ? param.def : "";

	document.execCommand(format, false, val);
}
document.execCommand('insertBrOnReturn');

function addText(format,cursorMove) { // Note to self : /!\ insertNode() might be broken in the future
	formatStart = format.substring(0, cursorMove);
	formatEnd = format.substring(cursorMove);

	let sel = window.getSelection();
	sel.removeAllRanges();

	if (format == "[quote][au][/au][/quote]") {
		let oldData = range.cloneContents();
		let quoteText = (oldData.textContent.length == 0) ? "Consectetur adipiscing elit" : oldData.textContent;
		range.deleteContents();
		let blockquote = newElement('blockquote',{});
		blockquote.append(newElement('span',{'txt':quoteText}));
		blockquote.append(newElement('cite',{'txt':'Lorem Ipsum'}));
		range.insertNode(blockquote);
	} else if (format == "[ib][/ib]") {
		let oldData = range.cloneContents();
		let ibText = (oldData.textContent.length == 0) ? "Consectetur adipiscing elit" : oldData.textContent;
		range.deleteContents();
		let infobox = newElement('aside',{'class':'infobox','txt':ibText})
		range.insertNode(infobox);
	} else if (format == "[ibd][/ibd]") {
		let oldData = range.cloneContents();
		range.deleteContents();
		let ibdText = (oldData.textContent.length == 0) ? "Consectetur" : oldData.textContent;
		let ibd = newElement('div',{'class':'infobox-data'});
		ibd.append(newElement('span',{'class':'infobox-data-title','txt':ibdText}));
		ibd.append(newElement('span',{'txt':'1957'}));
		range.insertNode(ibd);
	} else {
		formatStartID = "format-"+UUID();
		range.insertNode(newElement('span',{'txt':formatStart,'class':'format-txt','attr':{'id':formatStartID}}));
		range.collapse()
		formatEndID = "format-"+UUID();
		range.insertNode(newElement('span',{'txt':formatEnd,'class':'format-txt','attr':{'id':formatEndID}}));
		range.setStartBefore(document.getElementById(formatStartID));
		range.setEndAfter(document.getElementById(formatEndID));
	}

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
				addFormat("italic",{});
				break;
			case 66:
				e.preventDefault();
				addFormat("bold",{});
				break;
			case 83:
				e.preventDefault();
				addFormat("strikeThrough",{});
				break;
			case 85:
				e.preventDefault();
				addFormat("underline",{});
				break;
			case 79:
				e.preventDefault();
				addFormat("foreColor",{"def":"#003399"});
				break;
		}
	}
}
}
