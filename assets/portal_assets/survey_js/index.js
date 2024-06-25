var counter = 1;
$(document).ready(function() 
{
	var erroEle = $('.error-message'),
	focusInput = $('.questions').find('.active');
	var focusInput2 = $('.questions').find('.previous');
	
	if(focusInput.closest('li').next('li').is(':last-child') == false)
	{
		$('#Submitbtn').css( "visibility", "hidden" );
		$('#next-page').css( "visibility", "visible" );
	}

	if (focusInput.val() != '' || focusInput.val() == 'on') 
	{
		// $('#next-page').css('opacity', 1);
		// $('#prev-page').css('opacity', 1);
	}
	
	/****************Next Button Click****************/
		$('#next-page').click(function() 
		{
			$('.previous').removeClass('previous');
			$('.active').addClass('previous');
			var focusInput = $('.questions').find('.active');
			nextMaster('nextpage');
		})
	/****************Next Button Click****************/
	
	/****************Previous Button Click****************/
		$('#prev-page').click(function() 
		{
			var focusInput = $('.questions').find('.previous');
			prevMaster('nextpage');
		})
	/****************Previous Button Click****************/
		  
	function prevMaster(type) 
	{
		var focusInput2 = $('.questions').find('.previous');
		if (focusInput2.val() != '' || focusInput2.length != 0) 
		{
			if (type != 'navi') showLi2(focusInput2);
			
			if(focusInput2.val() == 'on')
			{
				// $('#next-page').css('opacity', 1);
				// $('#prev-page').css('opacity', 1);
			}
			else
			{
				// $('#next-page').css('opacity', 0);
				// $('#prev-page').css('opacity', 0);
			}
			errorMessage(erroEle, '', 'hidden', 0);
		}
		else
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		}
	}

	function nextMaster(type) 
	{
		var focusInput = $('.questions').find('.active');		
		if (focusInput.val() != ''  || focusInput.length != 0) 
		{
			//alert("dsfsdf");
			if (type != 'navi') showLi(focusInput);
			
			if(focusInput.val() == 'on')
			{
				// $('#next-page').css('opacity', 1);
				// $('#prev-page').css('opacity', 1);
			}
			else
			{
				// $('#next-page').css('opacity', 0);
				// $('#prev-page').css('opacity', 0);
			}
			errorMessage(erroEle, '', 'hidden', 0);
		} 
		else
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		}
	}

	$("input[type='text']").keyup(function(event) 
	{
		var focusInput = $(this);
		if (focusInput.val().length >= 1) 
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		} 
		else 
		{
			// $('#next-page').css('opacity', 0);
			// $('#prev-page').css('opacity', 0);
		}
	});
	
	$('.rb-tab').click(function () 
	{
		var focusInput = $(this).attr('data-value');
		if (focusInput >= 1) 
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
			$('.hidden_radio').val(focusInput);
		} 
		else 
		{
			// $('#next-page').css('opacity', 0);
			// $('#prev-page').css('opacity', 0);
			$('.hidden_radio').val("");
		}
	});
	
	$("textarea").keyup(function(event) 
	{
		var focusInput = $(this);
		if (focusInput.val().length >= 1) 
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		} 
		else 
		{
			// $('#next-page').css('opacity', 0);
			// $('#prev-page').css('opacity', 0);
		}
	});
	
	$("input[type='radio']").click(function(event) 
	{		
		var focusInput = $(this);
		if (focusInput.val().length >= 1) 
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		} 
		else 
		{
			// $('#next-page').css('opacity', 0);
			// $('#prev-page').css('opacity', 0);
		}
	});
	
	$("input[type='checkbox']").click(function(event) 
	{
		var focusInput = $(this);
		if (focusInput.val().length >= 1) 
		{
			// $('#next-page').css('opacity', 1);
			// $('#prev-page').css('opacity', 1);
		} 
		else 
		{
			// $('#next-page').css('opacity', 0);
			// $('#prev-page').css('opacity', 0);
		}
	});

});

function showLi(focusInput) 
{
	focusInput.closest('li').animate(
	{
		marginTop: '-350px',
		zIndex: '0',
		opacity: 0
	}, 200);

	focusInput.removeClass('active');
	counter++;
	var nextli = focusInput.closest('li').next('li');
	
	nextli.animate(
	{
		marginTop: '0px',
		zIndex: '1000',
		opacity: 1
	}, 200);

	nextli.find('input').focus().addClass('active');
	nextli.find('textarea').focus().addClass('active');
	
	if(focusInput.closest('li').next('li').is(':last-child') == true)
	{
		$('#Submitbtn').css( "visibility", "visible" );
		// $('#prev-page').css( "visibility", "hidden" );
		$('#next-page').css( "visibility", "hidden" );
	}
}
		
function showLi2(focusInput2) 
{	
	$('.active').removeClass('active');
	focusInput2.removeClass('previous');	
	focusInput2.focus().addClass('active');
	
	focusInput2.closest('li').animate(
	{
		marginTop: '0px',
		zIndex: '1000',
		opacity: 1
	}, 200);
	
	focusInput2.closest('li').prevAll('li').animate(
	{
		marginTop: '-350px',
		zIndex: '0',
		opacity: 0
	}, 200);
	
	focusInput2.closest('li').nextAll('li').animate(
	{
		marginTop: '350px',
		zIndex: '0',
		opacity: 0
	}, 200);
	
	var prevli = focusInput2.closest('li').prev();
	prevli.find('input').focus().addClass('previous');
	prevli.find('textarea').focus().addClass('previous');
	
	if(focusInput2.length == 0)
	{
		var closest_li = $('.questions li').first().find('input');
		closest_li.addClass('active');
	}
	
	if(focusInput2.closest('li').next('li').is(':last-child') == true)
	{
		$('#next-page').css( "visibility", "visible" );
	}
} 

function errorMessage(textmeg, appendString, visib, opaci) 
{
	textmeg.css(
	{
		visibility: visib
	})
	.animate(
	{
		opacity: opaci
	}).html(appendString)
}

function validateEmail(email) 
{
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function validatePhone(phone) 
{
	var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
	return re.test(phone);
}