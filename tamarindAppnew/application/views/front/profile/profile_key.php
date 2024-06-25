<?php $this->load->view('front/header/header'); ?>
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url();?>index.php/Cust_home/myprofile"><span>Profile Details</span></a>
				</div>
			</div>
		</div>
	</header>
	<div class="custom-body">
		<div class="login-box">
		<?php
		if(@$this->session->flashdata('error_code'))
		{
		?>
			<div class="alert bg-warning alert-dismissible" id="msgBox" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
			</div>
		<?php
		}
	?>
		<?php echo form_open_multipart('Cust_home/profile'); ?>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" class="form-control" placeholder="Firstname" name="firstName" id="firstName" value="<?php echo ucwords($Enroll_details->First_name); ?>" onblur="allLetter(this.value);" required />
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.366" height="16" viewBox="0 0 15.366 16"><g transform="translate(-6.783 -5)"><path d="M30.489,13.437A4.219,4.219,0,1,0,26.27,9.219,4.223,4.223,0,0,0,30.489,13.437Zm0-7.563a3.344,3.344,0,1,1-3.344,3.344A3.348,3.348,0,0,1,30.489,5.875Z" transform="translate(-16.023 0)" fill="#322210"/><path d="M14.466,59.355c-6.3,0-7.683,3.173-7.683,4.4a1.937,1.937,0,0,0,1.969,1.942H20.18a1.937,1.937,0,0,0,1.969-1.942C22.149,62.528,20.769,59.355,14.466,59.355Zm5.714,5.462H8.752A1.059,1.059,0,0,1,7.658,63.75c0-.914,1.251-3.52,6.808-3.52s6.808,2.607,6.808,3.52A1.059,1.059,0,0,1,20.18,64.817Z" transform="translate(0 -44.692)" fill="#322210"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="firstName" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" class="form-control" placeholder="Lastname" name="lastName" id="lastName" value="<?php echo ucwords($Enroll_details->Last_name); ?>" onblur="allLetter1(this.value);" required />
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.366" height="16" viewBox="0 0 15.366 16"><g transform="translate(-6.783 -5)"><path d="M30.489,13.437A4.219,4.219,0,1,0,26.27,9.219,4.223,4.223,0,0,0,30.489,13.437Zm0-7.563a3.344,3.344,0,1,1-3.344,3.344A3.348,3.348,0,0,1,30.489,5.875Z" transform="translate(-16.023 0)" fill="#322210"/><path d="M14.466,59.355c-6.3,0-7.683,3.173-7.683,4.4a1.937,1.937,0,0,0,1.969,1.942H20.18a1.937,1.937,0,0,0,1.969-1.942C22.149,62.528,20.769,59.355,14.466,59.355Zm5.714,5.462H8.752A1.059,1.059,0,0,1,7.658,63.75c0-.914,1.251-3.52,6.808-3.52s6.808,2.607,6.808,3.52A1.059,1.059,0,0,1,20.18,64.817Z" transform="translate(0 -44.692)" fill="#322210"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="lastName" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" class="form-control" id="datepicker1" name="dob" value="<?php if($Enroll_details->Date_of_birth != Null) { echo date('Y-m-d', strtotime($Enroll_details->Date_of_birth)); } ?>" required placeholder="Date of Birth" onfocus="(this.type='date')" />
						<div class="icon">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20.2222 5H7.77778C6.79594 5 6 5.79594 6 6.77778V19.2222C6 20.2041 6.79594 21 7.77778 21H20.2222C21.2041 21 22 20.2041 22 19.2222V6.77778C22 5.79594 21.2041 5 20.2222 5Z" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M18 3V7" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10 3V7" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M6 10H22" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<div class="line"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<select class="form-control" name="Sex" id="Sex" >               
							<?php if($Enroll_details->Sex=='Male') 
							{ 
							?>	
								<option selected value="Male">Male</option> 
								<option value="Female" >Female</option>
							<?php  
							} 										
							else if($Enroll_details->Sex=='Female') 
							{
							?>										
								<option  value="Male">Male</option> 
								<option value="Female" selected >Female</option>
							<?php 
							}
							else 
							{
							?>
								<option  value="">Gender</option> 
								<option  value="Male">Male</option> 
								<option value="Female" >Female</option>
							<?php 
							}											
							?>	
						  </select>
						<div class="icon">
							<svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.8917 0V1.11418H17.0979L14.2347 3.97743C13.3732 3.28727 12.2809 2.87376 11.0937 2.87376C9.9567 2.87376 8.9067 3.25299 8.06308 3.89138C7.2195 3.25303 6.1695 2.87376 5.03244 2.87376C2.25755 2.87376 0 5.13131 0 7.90621C0 10.4928 1.96166 12.6295 4.47536 12.9076V16.0357H2.97281V17.1499H4.47539V19.0153H5.58957V17.1499H7.09211V16.0358H5.58957V12.9077C6.51155 12.8057 7.35922 12.4537 8.06312 11.9211C8.9067 12.5594 9.9567 12.9387 11.0938 12.9387C13.8687 12.9387 16.1262 10.6811 16.1262 7.90624C16.1262 6.71905 15.7127 5.62682 15.0226 4.76526L17.8858 1.90201V4.10827H19V0H14.8917ZM8.06312 10.387C7.5087 9.71091 7.17549 8.84679 7.17549 7.90624C7.17549 6.96569 7.5087 6.10157 8.06312 5.42549C8.61753 6.10157 8.95075 6.96569 8.95075 7.90624C8.95075 8.84679 8.61753 9.71088 8.06312 10.387ZM1.11422 7.90624C1.11422 5.7457 2.87194 3.98798 5.03248 3.98798C5.85133 3.98798 6.61224 4.24063 7.2416 4.67186C6.50546 5.54716 6.06128 6.67571 6.06128 7.90624C6.06128 9.13678 6.50546 10.2653 7.2416 11.1406C6.61224 11.5718 5.85136 11.8245 5.03248 11.8245C2.87194 11.8245 1.11422 10.0668 1.11422 7.90624ZM11.0937 11.8245C10.2749 11.8245 9.51396 11.5718 8.8846 11.1406C9.62074 10.2653 10.0649 9.13678 10.0649 7.90624C10.0649 6.67571 9.62074 5.54716 8.8846 4.67186C9.51396 4.24063 10.2748 3.98798 11.0937 3.98798C13.2543 3.98798 15.012 5.7457 15.012 7.90624C15.012 10.0668 13.2543 11.8245 11.0937 11.8245Z" fill="#86869D"/>
							</svg>
						</div>
						<div class="line"></div>
					</div>
					
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="tel" class="form-control" placeholder="Mobile Number (Without Dial Code)" name="phno" id="phno" value="<?php echo $phnumber; ?>"  required maxlength="9" />
						<div class="icon">
							<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.875 1.75H6.125C5.1585 1.75 4.375 2.5335 4.375 3.5V17.5C4.375 18.4665 5.1585 19.25 6.125 19.25H14.875C15.8415 19.25 16.625 18.4665 16.625 17.5V3.5C16.625 2.5335 15.8415 1.75 14.875 1.75Z" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10.5 15.75H10.5089" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<div class="line"></div>
						<div class="help-block1" style="float: center;"></div>
					</div>
					
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="email" class="form-control" placeholder="Email"name="userEmailId" id="userEmailId" value="<?php echo $User_email_id; ?>" required />
						<?php if($Enroll_details->Email_verified == 1){ ?>
						<span class="form-ver ver">Verified</span>
						<?php } else { ?>
						<a href="<?php echo base_url(); ?>index.php/Cust_home/Verify_email"><span class="form-ver unver">Unverified</span></a>
						<?php } ?>
						<div class="icon">
						<svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.6 1H15.4C16.28 1 17 1.675 17 2.5V11.5C17 12.325 16.28 13 15.4 13H2.6C1.72 13 1 12.325 1 11.5V2.5C1 1.675 1.72 1 2.6 1Z" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M17 2L9 8L1 2" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<div class="line"></div>
						<div class="help-block" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<select class="form-control" name="Marital_status" id="Marital_status" onchange="hide_anniversary('this.value');" required>
							<?php if($Enroll_details->Married=='Single') 
							{ 
							?>	
								<option selected value="Single">Single</option> 
								<option value="Married" >Married</option>
							<?php  
							} 										
							else if($Enroll_details->Married=='Married') 
							{
							?>										
								<option value="Married" selected>Married</option>
								<option value="Single">Single</option> 
							<?php 
							}
							else 
							{
							?>
								<option value="Married" >Married</option>
								<option value="Single">Single</option> 
							<?php 
							}											
							?>						
						</select>
						<div class="icon">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.2754 5.86768C14.3434 5.89539 14.4154 5.90923 14.4874 5.90923C14.5594 5.90923 14.6315 5.89539 14.6994 5.86768C14.8334 5.81309 17.9807 4.50436 17.9807 2.1988C17.9807 0.99094 16.9842 0.00830078 15.7595 0.00830078C15.2989 0.00830078 14.8566 0.148201 14.4874 0.402853C14.1182 0.148201 13.6759 0.00830078 13.2153 0.00830078C11.9905 0.00830078 10.9941 0.99094 10.9941 2.1988C10.9941 4.50436 14.1414 5.81309 14.2754 5.86768ZM13.2153 1.13228C13.5426 1.13228 13.8505 1.27299 14.06 1.5183C14.1668 1.6433 14.323 1.71531 14.4874 1.71531C14.6518 1.71531 14.808 1.6433 14.9148 1.5183C15.1243 1.27299 15.4321 1.13228 15.7595 1.13228C16.3645 1.13228 16.8567 1.61071 16.8567 2.1988C16.8567 3.37163 15.3088 4.34482 14.4912 4.73105C13.8772 4.4339 12.1181 3.471 12.1181 2.1988C12.1181 1.61071 12.6103 1.13228 13.2153 1.13228Z" fill="#86869D"/>
							<path d="M12.2359 6.19175C11.3147 4.92474 10.0553 4.04062 8.57755 3.62805C7.31669 3.27885 6.00918 3.29128 4.79648 3.66399C3.66137 4.01284 2.62769 4.6664 1.80726 5.55399C0.989458 6.43874 0.419601 7.51636 0.159294 8.67033C-0.11731 9.89666 -0.0325199 11.1806 0.404568 12.3837C1.1988 14.6194 3.13865 16.2902 5.4676 16.744C5.46936 16.7444 5.47108 16.7447 5.47284 16.745C5.90416 16.8248 6.29467 16.8612 6.47497 16.8612C6.78533 16.8612 7.03696 16.6095 7.03696 16.2992C7.03696 15.9888 6.78533 15.7372 6.47497 15.7372C6.39018 15.7372 6.07248 15.7128 5.67975 15.6402C3.73969 15.2612 2.12408 13.8687 1.46304 12.0056C1.46255 12.0042 1.46206 12.0028 1.46156 12.0014C0.739689 10.0163 1.17748 7.8912 2.63265 6.31693C4.09298 4.73704 6.20318 4.1368 8.27643 4.71094C9.28569 4.99271 10.1745 5.54121 10.8872 6.31538C8.21278 6.87586 6.19819 9.25241 6.19819 12.0909C6.19819 15.3447 8.8453 17.9918 12.0991 17.9918C15.3529 17.9918 18 15.3447 18 12.0909C18 8.88287 15.4267 6.2647 12.2359 6.19175ZM12.0991 16.8678C11.2153 16.8678 10.3869 16.6262 9.67613 16.2061C12.1674 15.0093 13.7285 12.3591 13.48 9.55209C13.4574 9.2764 13.4031 8.84774 13.2725 8.36738L13.2699 8.35797C13.1991 8.06693 12.9107 7.88091 12.6141 7.94017C12.3097 8.0009 12.1122 8.29682 12.1728 8.60121C12.1742 8.60816 12.1788 8.62895 12.1879 8.66215C12.2963 9.06098 12.3412 9.41704 12.3598 9.64552C12.3599 9.64686 12.3601 9.64819 12.3602 9.64953C12.5847 12.1776 11.0448 14.5537 8.66831 15.4111C7.83558 14.5509 7.3222 13.3798 7.3222 12.0908C7.3222 9.4568 9.46514 7.3139 12.0991 7.3139C14.7331 7.3139 16.876 9.4568 16.876 12.0908C16.876 14.7248 14.7331 16.8678 12.0991 16.8678ZM13.2708 8.36187C13.273 8.371 13.2743 8.37757 13.2751 8.38143C13.2738 8.37483 13.2724 8.36833 13.2708 8.36187Z" fill="#86869D"/>
							</svg>
						</div>
						<div class="line"></div>
					</div>
					
				</div>
				<div class="form-group">
					<div class="field-icon">
						 <?php 	
							if($Enroll_details->Wedding_annversary_date != "" ) {
							?>
								<input type="text" class="form-control" id="datepicker2" name="Wedding_annversary_date" value="<?php echo date('Y-m-d', strtotime( $Enroll_details->Wedding_annversary_date)); ?>" placeholder="Anniversary Date" required onfocus="(this.type='date')">
								
							<?php	} else {
							?>										
								<input type="text" class="form-control" id="datepicker2" name="Wedding_annversary_date" placeholder="Anniversary Date" onfocus="(this.type='date')">							
							<?php }	?>
						<div class="icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20.2222 5H7.77778C6.79594 5 6 5.79594 6 6.77778V19.2222C6 20.2041 6.79594 21 7.77778 21H20.2222C21.2041 21 22 20.2041 22 19.2222V6.77778C22 5.79594 21.2041 5 20.2222 5Z" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M18 3V7" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10 3V7" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M6 10H22" stroke="#86869D" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<div class="line"></div>
					</div>
					
				</div>
				<div class="submit-field">
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
					<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>">
					<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
					<input type="hidden" name="Password" value="<?php echo $Enroll_details->User_pwd; ?>">
					<button type="submit" class="submit-btn">Save</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer');  ?>
<?php 				
	$Cust_min_age=$Company_Details->Cust_min_age;
	if($Cust_min_age != ""){
		$Cust_min_age= $Cust_min_age;
	} else {
		$Cust_min_age=18;
	}

	if($Enroll_details->Date_of_birth != ""){
		$Date_of_birth= date('Y', strtotime($Enroll_details->Date_of_birth));
		$today_DOB = date('Y');
		$yearDiff= $today_DOB - $Date_of_birth;
		$yearDiff_1 = $yearDiff - $Cust_min_age;
		$time = strtotime("-$yearDiff_1 year", time());
		$dateYear = date("Y", $time);
	}	
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">

<!--Select DorpDown custom JS-->
  <script type="text/javascript">
    /*$('select').each(function(){
      var $this = $(this), numberOfOptions = $(this).children('option').length;
    
      $this.addClass('select-hidden'); 
      $this.wrap('<div class="select"></div>');
      $this.after('<div class="select-styled"></div>');
  
      var $styledSelect = $this.next('div.select-styled');
      $styledSelect.text($this.children('option').eq(0).text());
    
      var $list = $('<ul />', {
          'class': 'select-options'
      }).insertAfter($styledSelect);
    
      for (var i = 0; i < numberOfOptions; i++) {
          $('<li />', {
              text: $this.children('option').eq(i).text(),
              rel: $this.children('option').eq(i).val()
          }).appendTo($list);
      }
    
      var $listItems = $list.children('li');
    
      $styledSelect.click(function(e) {
          e.stopPropagation();
          $('div.select-styled.active').not(this).each(function(){
              $(this).removeClass('active').next('ul.select-options').hide();
          });
          $(this).toggleClass('active').next('ul.select-options').toggle();
      });
    
      $listItems.click(function(e) {
          e.stopPropagation();
          $styledSelect.text($(this).text()).removeClass('active');
          $this.val($(this).attr('rel'));
          $list.hide();
          //console.log($this.val());
      });
    
      $(document).click(function() {
          $styledSelect.removeClass('active');
          $list.hide();
      });
  
  }); */
  
  function hide_anniversary(InputVal){
		console.log('---InputVal----'+InputVal);
		if(InputVal=='Single'){
			
			$('#annversary_div').css('display','none');
			
		} else{
			$('#annversary_div').css('display','block');
		}
	}
function Change_anniversary_date(dobDate){
	
	console.log(dobDate);	
	var DOBarr = dobDate.split('/');	
	console.log(DOBarr[2]);
	var Anniversary =parseInt(DOBarr[2]) + parseInt(18);
	console.log(Anniversary);
	var Year= new Date().getFullYear();	
	$( "#datepicker2" ).datepicker({      
		changeMonth: true,	   
		yearRange: ''+Anniversary+':'+Year+'',
		changeYear: true
    });
}

	/*$(function() {
  
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
	   // yearRange: "-90:-16",
	   yearRange: "-70:-<?php echo $Company_Details->Cust_min_age; ?>",
      changeYear: true
    });
	
	/* $( "#datepicker2" ).datepicker({
      changeMonth: true,	   
	   yearRange: '<?php echo $dateYear; ?>:<?php echo $today_DOB; ?>',
      changeYear: true
    }); */
	
	/*var DOB='<?php echo $Date_of_birth; ?>';	
		if(DOB) {
			
			var AnniversaryYear =parseInt(DOB) + parseInt(18);	
			var Year= new Date().getFullYear();
			
			$( "#datepicker2" ).datepicker({		  
				changeMonth: true,	   
				yearRange: ''+AnniversaryYear+':'+Year+'',
				changeYear: true
			});
		}
	}); */

function ValidateEmail(mail) 
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
	{
		return true;
	}
    //alert("You have entered an invalid email address!");
	
	var msg1 = 'Please enter valid email id';
	$('.help-block').show();
	$('.help-block').css("color","red");
	$('.help-block').html(msg1);
	setTimeout(function(){ $('.help-block').hide(); }, 3000);
    return false;
}

$('#phno').change(function()
{	
	var Country = '<?php echo $Enroll_details->Country; ?>';
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var phno = $('#phno').val();
	
	if( $("#phno").val() == "" )
	{		
		var msg1 = 'Please Enter Phone Number';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg1);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { phno: phno,Company_id:Company_id, Country:Country},
			url: "<?php echo base_url()?>index.php/Cust_home/check_phone_number",
			success: function(data)
			{				
				if(data == 1)
				{
					$("#phno").val('')
					
					var msg1 = 'Phone Number Already Exist!';
					$('.help-block1').show();
					$('.help-block1').css("color","red");
					$('.help-block1').html(msg1);
					setTimeout(function(){ $('.help-block1').hide(); }, 3000);
				}
				else
				{					
				}
			}
		});
	}
});

$('#userEmailId').change(function()
{		
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
	var validEmailId=ValidateEmail(userEmailId);
	// alert(validEmailId);
	// return false;
	if( $("#userEmailId").val() == "" || validEmailId == false)
	{	
		// alert(validEmailId);
		var msg1 = 'Please Enter Email Id';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { userEmailId: userEmailId, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/check_email_id",
			success: function(data)
			{				
				if(data == 0)
				{
					$("#userEmailId").val("");					
					var msg1 = 'Email Id Already Exist!';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
					
				}
			}
		});
	}
});

function allLetter(uname)
{
	if(uname !="")
	{
		var letters = /^[A-Za-z]+$/;
		if(uname.match(letters))
		{
			return true;
		}
		else
		{
			$("#firstName").val("");					
			var msg1 = 'Name must have alphabet characters only';
			$('.firstName').show();
			$('.firstName').css("color","red");
			$('.firstName').html(msg1);
			setTimeout(function(){ $('.firstName').hide(); }, 3000);
			// uname.focus();
			return false;
		}
	}
}
function allLetter1(uname)
{ 
	if(uname !="")
	{
		var letters = /^[A-Za-z]+$/;
		if(uname.match(letters))
		{
			return true;
		}
		else
		{
			$("#lastName").val("");					
			var msg1 = 'Name must have alphabet characters only';
			$('.lastName').show();
			$('.lastName').css("color","red");
			$('.lastName').html(msg1);
			setTimeout(function(){ $('.lastName').hide(); }, 3000);
			// uname.focus();
			return false;
		}
	}
}
$(document).ready(function() 
{
	setTimeout(function(){ $('#msgBox').hide(); }, 3000);
});
</script>