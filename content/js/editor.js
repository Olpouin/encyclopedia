if (document.getElementById("textEdit")) {
var txtarea = document.getElementById("textEdit");

function addFormat(format, param) {
	if ('prompt' in param) val = (typeof param.def !== "undefined") ? prompt("Valeur à envoyer ?", param.def) : "";
	val = (typeof param.def !== "undefined") ? param.def : "";

	document.execCommand(format, false, val);
}
document.execCommand('insertBrOnReturn');
document.execCommand('enableInlineTableEditing');
document.execCommand("defaultParagraphSeparator", false, "div");

txtarea.onkeydown = function(e) {
	if((e.shiftKey || e.shiftKey) && ((e.keyCode==9 || e.which==9) || (e.keyCode==49 || e.which==49) || (e.keyCode==50 || e.which==50))){
		switch (e.keyCode) {
			case 49:
				addFormat("insertHTML",{"def":"<aside class=\"infobox\"><h1>Titre</h1>![Desc](URL)<div class=\"infobox-data\"><span class=\"infobox-data-title\">T</span><span>D</span></div><div class=\"infobox-data\"><span class=\"infobox-data-title\">T</span><span>D</span></div><div class=\"infobox-data\"><span class=\"infobox-data-title\">T</span><span>D</span></div><br><br><br></aside>"})
				var textAdd = "[ib]\r\n[h1][/h1]\r\n![]()\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[ibd]|[/ibd]\r\n[/ib]";
				var selectAdd = 9;
				break;
			case 50:
				addFormat("insertHTML",{"def":"<div class=\"infobox-data\"><span class=\"infobox-data-title\">T<\/span><span>D<\/span><\/div>"});
				break;
			default:
				addFormat("insertText",{"def":"   "})
		}
		e.preventDefault();

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
