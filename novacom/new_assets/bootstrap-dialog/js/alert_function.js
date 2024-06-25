function runjs(Title,msg)
{
	BootstrapDialog.show({
			closable: false,
			title: Title,
			message: msg,
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					dialog.close();	
				}
			
			}]
	});
}

function spinnerLoader()
{
	var element = document.createElement('div');
	element.id = "spinner";
	document.body.appendChild(element);
	
	var time_out = setTimeout(function(){
		document.getElementById('spinner').style.display='inline';
		document.getElementById('spinner').style.backgroundColor='#CCC';
		document.body.style.overflow='hidden';					
	}, 1);
}