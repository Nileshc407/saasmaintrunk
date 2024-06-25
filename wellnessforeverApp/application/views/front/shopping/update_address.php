<?php $this->load->view('front/header/header');
$ci_object = &get_instance();
$ci_object->load->helper(array('encryption_val'));
	/*  style="background-image:url('<?php echo base_url(); ?>assets/img/statement-bg.jpg')" */
 ?>
<body>
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Cust_home/myprofile?page=2"></a>
					</div>
					<h2>Add New Address</h2>
				</div>
			</div>
		</div>
		<div class="custom-body">
			<div class="box custom-form ptb-30">
				<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
				<?php 
					$attributes = array('onSubmit' => 'return form_submit();');
					echo form_open_multipart('Shopping/Update_address',$attributes); 
					
					?>
					<div class="row">
						<div class="form-group col-12">
							<input type="text" name="Contact_person" id="Contact_person" value="<?php if($Customer_address->Contact_person != ""){echo $Customer_address->Contact_person;} ?>"  onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" class="form-control" required>
							<label class="form-control-placeholder" for="Contact_person">Contact person:</label>
							<div class="help-block_Contact_person" style="float: center;"></div>
						</div>
					</div>
					 <?php 
							// $str_arr = explode (",",$Customer_address->Address);
							if($Customer_address->Address) {
								
								/* $str_arr2 = explode(",",$Customer_address->Address);
								$str_arr20 =App_string_decrypt($str_arr2[0]);
								$str_arr21 =App_string_decrypt($str_arr2[1]);
								$str_arr22 =App_string_decrypt($str_arr2[2]);
								$str_arr23 =App_string_decrypt($str_arr2[3]);							
								$Other_address=$str_arr20.",".$str_arr21.",".$str_arr22.",".$str_arr23; */
								
								$Current_address=App_string_decrypt($Customer_address->Address);
								$str_arr2 = explode(",",$Current_address);
								$str_arr20 =$str_arr2[0];
								$str_arr21 =$str_arr2[1];
								$str_arr22= $str_arr2[2];
								$str_arr23=$str_arr2[3];
							}
							if($Customer_address->Phone_no){
								$Phone_no = App_string_decrypt($Customer_address->Phone_no);
								$phnumber = preg_replace("/^\+?{$dial_code}/", '',$Phone_no);
							}
									
									
									
								
						?>
					<div class="row">
						<div class="form-group col-12">
							<input type="text" onkeyup="validate(1);"  name="currentAddress1" id="currentAddress1" value="<?php if($str_arr20 != ""){echo $str_arr20;} ?>" class="form-control" required>
							<label class="form-control-placeholder" for="currentAddress1">Building / Estate</label>
							<div class="help-block_currentAddress1" style="float: center;"></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12">
							<input type="text" value="<?php if($str_arr21 != ""){echo $str_arr21;} ?>" class="form-control" onkeyup="validate(2);" name="currentAddress2" id="currentAddress2" required>
							<label class="form-control-placeholder" for="currentAddress2">House Number / Floor</label>
							<div class="help-block_currentAddress2" style="float: center;"></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12">
							<input type="text"  value="<?php if($str_arr22 != ""){echo $str_arr22;} ?>" class="form-control" onkeyup="validate(3);" name="currentAddress3" id="currentAddress3" required>
							<label class="form-control-placeholder" for="currentAddress3">Street / Road</label>
							<div class="help-block_currentAddress3" style="float: center;"></div>
						</div>
					</div>
					<div class="row">
					
						<div class="form-group col-12">
							<label class="labelin" for="adddetail">Additional Details</label>
							<textarea class="form-control textarea" onkeyup="validate(4);" name="currentAddress4" id="currentAddress4"><?php if($str_arr23 != ""){echo $str_arr23;} ?></textarea>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-12">
							<select name="city" class="form-control" required >				
								<?php 
								foreach($City_array as $rec)
								{?>
									<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
								<?php } ?>	
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group mt-3 col-12">							
							<input type="hidden" name="Address_type" value="<?php echo $Address_type; ?>">
							<button type="submit" class="btn btn-light dark" value="submit" name="submit">Submit</button>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		 <?php $this->load->view('front/header/footer');  ?>
		 
		 <!-- Loader -->	
			<div class="container" >
				 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
					 <!-- <div class="modal-dialog modal-sm" style="margin-top: 65%;">
						<!-- Modal content-
						<div class="modal-content" id="loader_model">
						   <div class="modal-body" style="padding: 10px 0px;;">
							 <img src="<?php //echo base_url(); ?>assets/img/loading.gif" alt="" class="img-rounded img-responsive" width="80">
						   </div>       
						</div>    
						<!-- Modal content--
					  </div> -->
					  
						<div class="loader">
							<div id="ld3">
							  <div>
							  </div>
							  <div>
							  </div>
							  <div>
							  </div>
							  <div>
							  </div>
							</div>
						</div>
				 </div>       
			</div>
		<!-- Loader -->			 
	<script>

function IsAlphaNumeric(e) {	
            var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >=48 && k <= 57));
}

function validate(inputID) {
	
	if(inputID==1){
		var element = document.getElementById('currentAddress1');
	} 
	if(inputID==2){
		var element = document.getElementById('currentAddress2');
	}
	if(inputID==3){
		var element = document.getElementById('currentAddress3');
	}
	if(inputID==4){
		var element = document.getElementById('currentAddress4');
	}    
    element.value = element.value.replace(/[^a-zA-Z0-9 ]+/, '');	
};
function form_submit()
{
	
	
	/* var Contact_person = $('#Contact_person').val();
	
	var currentAddress1 = $('#currentAddress1').val();
	var currentAddress2 = $('#currentAddress2').val();
	var currentAddress3 = $('#currentAddress3').val();
	var city = $('#city').val();
	
	
	if( $("#Contact_person").val() == "" )
	{	  
		var msg1 = 'Please Enter Contact person';
		$('.help-block_Contact_person').show();
		$('.help-block_Contact_person').css("color","red");
		$('.help-block_Contact_person').html(msg1);
		setTimeout(function(){ $('.help-block_Contact_person').hide(); }, 3000);
		return false;
	}
	if( $("#currentAddress1").val() == "" )
	{	  
		var msg1 = 'Please Enter Estate/ Building No';
		$('.help-block_currentAddress1').show();
		$('.help-block_currentAddress1').css("color","red");
		$('.help-block_currentAddress1').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress1').hide(); }, 3000);
		return false;
	}
	if( $("#currentAddress2").val() == "" )
	{	  
		var msg1 = 'Please Enter House Number/ Floor';
		$('.help-block_currentAddress2').show();
		$('.help-block_currentAddress2').css("color","red");
		$('.help-block_currentAddress2').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress2').hide(); }, 3000);
		return false;
	}
	if( $("#currentAddress3").val() == "" )
	{	  
		var msg1 = 'Please Enter Street/ Road';
		$('.help-block_currentAddress3').show();
		$('.help-block_currentAddress3').css("color","red");
		$('.help-block_currentAddress3').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress3').hide(); }, 3000);
		return false;
	}
	if( $("#city").val() == "" )
	{	  
		var msg1 = 'Please select city';
		$('.help-block_city').show();
		$('.help-block_city').css("color","red");
		$('.help-block_city').html(msg1);
		setTimeout(function(){ $('.help-block_city').hide(); }, 3000);
		return false;
	} */	
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 20000);
	
	// return false;
	
	// document.Update_profile.submit();
}
</script>	

<style>
.loader {
  width: 50vw;
  height: 50vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center; }



@keyframes ld1_div1 {
  0% {
    top: 52.5px;
    background: #FE4A49; }
  50% {
    top: -52.5px;
    background: #59CD90; }
  100% {
    top: 52.5px;
    background: #009FB7; } }
@keyframes ld1_div2 {
  0% {
    right: 52.5px;
    background: #FE4A49; }
  50% {
    right: -52.5px;
    background: #FED766; }
  100% {
    right: 52.5px;
    background: #59CD90; } }
@keyframes ld1_div3 {
  0% {
    left: 52.5px;
    background: #FE4A49; }
  50% {
    left: -52.5px;
    background: #D91E36; }
  100% {
    left: 52.5px;
    background: #FE4A49; } }
#ld2 {
  display: flex;
  flex-direction: row; }
  #ld2 div {
    height: 20px;
    width: 5px;
    background: #FE4A49;
    margin: 3px;
    border-radius: 25px; }
  #ld2 div:nth-child(1) {
    animation: ld2 1s ease-in-out infinite 0s; }
  #ld2 div:nth-child(2) {
    animation: ld2 1s ease-in-out infinite 0.1s; }
  #ld2 div:nth-child(3) {
    animation: ld2 1s ease-in-out infinite 0.2s; }
  #ld2 div:nth-child(4) {
    animation: ld2 1s ease-in-out infinite 0.3s; }
  #ld2 div:nth-child(5) {
    animation: ld2 1s ease-in-out infinite 0.4s; }
  #ld2 div:nth-child(6) {
    animation: ld2 1s ease-in-out infinite 0.5s; }
  #ld2 div:nth-child(7) {
    animation: ld2 1s ease-in-out infinite 0.6s; }

@keyframes ld2 {
  0% {
    transform: scaleY(1);
    background: #FED766; }
  25% {
    background: #009FB7; }
  50% {
    transform: scaleY(2);
    background: #59CD90; }
  75% {
    background: #FE4A49; }
  100% {
    transform: scaleY(1);
    background: #D91E36; } }
#ld3 {
  position: relative;
  animation: outercontainer 4s linear infinite; }
  #ld3 div {
    height: 12px;
    width: 12px;
    border-radius: 50%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0; }
  #ld3 div:nth-child(1) {
    top: 20px;
    background: #59CD90;
    animation: ld3_div1 2s linear infinite; }
  #ld3 div:nth-child(2) {
    top: -20px;
    background: #D91E36;
    animation: ld3_div2 2s linear infinite; }
  #ld3 div:nth-child(3) {
    left: 20px;
    background: #F39237;
    animation: ld3_div4 2s linear infinite; }
  #ld3 div:nth-child(4) {
    left: -20px;
    background: #0072BB;
    animation: ld3_div3 2s linear infinite; }

@keyframes outercontainer {
  100% {
    transform: rotate(360deg); } }
@keyframes ld3_div1 {
  0% {
    top: 20px; }
  25% {
    top: 0; }
  50% {
    top: 20px; }
  75% {
    top: 0; }
  100% {
    top: 20px; } }
@keyframes ld3_div2 {
  0% {
    top: -20px; }
  25% {
    top: 0; }
  50% {
    top: -20px; }
  75% {
    top: 0; }
  100% {
    top: -20px; } }
@keyframes ld3_div3 {
  0% {
    left: -20px; }
  25% {
    left: 0; }
  50% {
    left: -20px; }
  75% {
    left: 0; }
  100% {
    left: -20px; } }
@keyframes ld3_div4 {
  0% {
    left: 20px; }
  25% {
    left: 0; }
  50% {
    left: 20px; }
  75% {
    left: 0; }
  100% {
    left: 20px; } }
/*# sourceMappingURL=app.css.map */
</style> 
		 