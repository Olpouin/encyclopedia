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
