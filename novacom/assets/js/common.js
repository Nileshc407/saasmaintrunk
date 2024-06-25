function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
	{
		// alert("Please Enter Numeric Value ");
		return false;
	}
	return true;
}

/*******************Alphanumeric Validation*******************/
function isAlphanumeric(evt)
{
	var key = (evt.which) ? evt.which : event.keyCode
	if ( (key >= 91 && key <= 96) || (key >= 123 && key <=126) || (key >= 58 && key <= 64) || 
		 (key >= 46 && key <= 47) || (key >= 33 && key <= 44) )
	 return false;

  return true;
}
/******************************************************/

function show_loader()
{
	$('#myModal').show();
	$("#myModal").addClass( "in" );	
	$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
}

function has_error(feedback_div_id,glyphicon_div_id,help_div_id,help_data)
{
	$( feedback_div_id ).removeClass( "has-success" );
	$( glyphicon_div_id ).removeClass( "glyphicon-ok form-control-feedback" );		
	$( feedback_div_id ).addClass( "has-error" );
	$( glyphicon_div_id ).addClass( "glyphicon-remove form-control-feedback" );
	$( help_div_id ).html(help_data);
}

function has_success(feedback_div_id,glyphicon_div_id,help_div_id,help_data)
{
	$( feedback_div_id ).removeClass( "has-error" );
	$( glyphicon_div_id ).removeClass( "glyphicon-remove form-control-feedback" );	
	
	$( feedback_div_id ).addClass( "has-success" );
	$( glyphicon_div_id ).addClass( "glyphicon-ok form-control-feedback" );
	$( help_div_id ).html(help_data);
}

function readImage(input,img_div)
{
	console.log(input);
	if(input.files && input.files[0])
	{
		var reader = new FileReader();
		reader.onload = function (e)
		{
			$(img_div).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
   }
}