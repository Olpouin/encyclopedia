function addText(format,cursorMove) { // just in case
	formatStart = format.substring(0, cursorMove);
	formatEnd = format.substring(cursorMove);

	let sel = window.getSelection();
	sel.removeAllRanges();

	var oldData = range.cloneContents();

	switch (format) {
		case "[quote][au][/au][/quote]":
			let quoteText = (oldData.textContent.length == 0) ? "Consectetur adipiscing elit" : oldData.textContent;
			range.deleteContents();
			let blockquote = newElement('blockquote',{});
			blockquote.append(newElement('span',{'txt':quoteText}));
			blockquote.append(newElement('cite',{'txt':'Lorem Ipsum'}));
			range.insertNode(blockquote);
			break;
		case "[ib][/ib]":
			let ibText = (oldData.textContent.length == 0) ? "Consectetur adipiscing elit" : oldData.textContent;
			range.deleteContents();
			let infobox = newElement('aside',{'class':'infobox','txt':ibText})
			range.insertNode(infobox);
			break;
		case "[ibd][/ibd]":
			range.deleteContents();
			let ibdText = (oldData.textContent.length == 0) ? "Consectetur" : oldData.textContent;
			let ibd = newElement('div',{'class':'infobox-data'});
			ibd.append(newElement('span',{'class':'infobox-data-title','txt':ibdText}));
			ibd.append(newElement('span',{'txt':'1957'}));
			range.insertNode(ibd);
			break;
		default:
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
