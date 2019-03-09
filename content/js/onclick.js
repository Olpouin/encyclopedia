//Functions of onclicks to make code easier to read
function addCardOC() {
	API('add',
		{
			'type': value('add-type'),
			'name': value('add-name'),
			'group': value('add-group'),
			'addPass': value('add-pass'),
			'pass': value('pass')
		},
		path+'/'+value('add-type')+'/'+value('add-name')
	);
}

function editCardOC() {
	API(
		'edit',
		{
			'type': value('cardsType'),
			'name': value('cardsName'),
			'text': document.getElementById('textEdit').innerHTML,
			'group': value('group'),
			'pass': value('pass'),
			'hide': document.getElementById('hide-card').checked
		},
		window.location.pathname.slice(0,-5)
	);
}
