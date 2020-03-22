function generateChart(type, id, data, param) {
	let ctx = document.getElementById(id).getContext('2d');
	let scales = {};
	let display = false;
	if ('yaxis' in param) scales.yAxes = [{ticks:{callback:function(value){return value + param.yaxis;},min:0}}];
	if ('display' in param) display = param.display;
	new Chart(ctx,
		{
			type: type,
			data : data,
			options: {
				legend: {
					display: display
				},
				scales: scales
			}
		}
	);
}



function addCardOC() { //Add a card
	API(
		'add',
		{
			'type': value('add-type'),
			'name': value('add-name'),
			'group': value('add-group'),
			'addPass': value('add-pass'),
			'pass': value('pass')
		},
		path+'/'+value('add-type')+'/'+value('add-name')+'/'
	);
}
function changeMainParam() { //Edit general config
	API(
		'admin-config',
		{
			'site_name': value('gene-sitename'),
			'box-default_image': value('gene-defimg'),
			'pass': value('pass')
		},
		window.location.pathname
	);
}
