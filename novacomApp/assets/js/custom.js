

$(document).ready(function(){

	jQuery('.form-control').on('focus', function() {
		jQuery(this).closest('.custom-field').addClass('has-focus');
	});

	jQuery('.form-control').on('focusout', function() {
		if(jQuery(this).val() == '') {
			jQuery(this).closest('.custom-field').removeClass('has-focus');
		}
	}); 

});
