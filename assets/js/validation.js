console.log('in Validation');

/* Set maximum length for Input Text field */
$("input").each(function(index){
	
	var $this = $(this);
	
	$("#"+$this.attr("id")).prop('maxlength','25');
	
	if($this.attr("id") == 'zip' || $this.attr("id") == 'gained_points' ){
		
		$("#"+$this.attr("id")).prop('maxlength','6');
	}
	if($this.attr("id") == 'phno' || $this.attr("id") == 'Company_primary_phone_no' || $this.attr("id") == 'Phone_no'){
		
		$("#"+$this.attr("id")).prop('maxlength','10');
	}
	if($this.attr("id") == 'Email' || $this.attr("id") == 'userEmailId'){
		
		$("#"+$this.attr("id")).prop('maxlength','50');
	}
	if($this.attr("id") == 'Discount_Percentage_Value' || $this.attr("id") == 'max_discount'){
		
		$("#"+$this.attr("id")).prop('maxlength','6');
	}
	
})
/* Set maximum length for Input Textarea field */
$("textarea").each(function(index){
	
	var $this = $(this);
	$("#"+$this.attr("id")).prop('maxlength','100');
	
	if($this.attr("id")=='currentAddress'){
		console.log("--input--id--currentAddress--"+$this.attr("id"));
		$("#"+$this.attr("id")).prop('maxlength','100');
	}
})



/* Restrict special Char in filed allow only space */
/* Restrict .. double in filed  */
$('.form-control').keypress(function (e) {
	
	
	var $this = $(this);
	
	console.log("--input--4444--id---"+$this.attr("id"));
		
	if($this.attr("id")=='purchase_amt'  || $this.attr("id")=='reedem'  || $this.attr("id")=='Discount_Percentage_Value' ){
		
		
		const regex1 = /[^\d.]|\.(?=.*\.)/g;
		const subst='';
		
		
		
		$('#'+$this.attr("id")).keyup(function(){
			console.log("--input---555---id---"+$this.attr("id"));
			const str=this.value;
			const result = str.replace(regex1, subst);
			this.value=result;

		});
		
		
	}else
	{
		if($this.attr("id") != 'old_Password' && $this.attr("id") != 'new_Password' && $this.attr("id") != 'confirm_Password'&& $this.attr("id") != 'Email')
		{
			// var regex = new RegExp("^[a-zA-Z0-9\'('\')'\' '\&\,\.\-\]");
			var regex = new RegExp("^[a-zA-Z0-9' '\]");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			
			// console.log("--str---)"+str);
			// console.log("--charCode---)"+e.charCode);
			
			if(e.charCode == 39) {
				e.charCode = 0;
				return false;
			}
			
			
			// console.log("--input--id---"+$this.attr("id"));	
			if($this.attr("id") != 'phno' && $this.attr("id") != 'userEmailId'){
				
				
				if(regex.test(str)) {
					
					return true;
				}
				else
				{
					e.preventDefault();
					return false;
				} 
			}
		}	
	}
});

