<?php $this->load->view('header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
			Transfer <?php echo $Company_Details->Currency_name; ?> 
          </h1>
          
        </section>
		<?php echo form_open_multipart('Cust_home/transferpoints'); ?>
			
			
			<?php
			if(@$this->session->flashdata('transfer'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('transfer'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>
			
			
<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
			<script>
					BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
					buttons: [{
						label: 'OK',
						action: function(dialog) {
							window.location='<?php echo base_url()?>index.php/Cust_home/home';
						}
					}]
				});
				runjs(Title,msg);
			</script>
		<?php } ?>
			
        <!-- Main content -->

            <section class="content">
			<div class="row">
            <!-- left column -->
            
			  <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Transfer <?php echo $Company_Details->Currency_name; ?> </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                  <div class="box-body">
					<div class="form-group has-feedback">
                      <label for="exampleInputEmail1">Enter To Membership ID</label>
					  <span class="required_info" style="color:red;"><br>(Enter Membership ID or Phone No. without Country Code)</span>
                      <input type="text" class="form-control" id="Membership_id" name="Membership_id" placeholder="Enter To Membership Id/Phone No." required>
					  <span class="glyphicon" id="glyphicon3" aria-hidden="true"></span>
					  <div class="help-block" id="Membership_id_help"></div>
                    </div>
					<div class="form-group">
                      <label for="exampleInputEmail1">Transfer <?php echo $Company_Details->Currency_name; ?> </label>
                      <input type="text" class="form-control" id="Transfer_Points" onblur="Check_current_balance(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" name="Transfer_Points"  placeholder="Enter Transfer <?php echo $Company_Details->Currency_name; ?>" required>
                    </div>
                                
                 </div><!-- /.box-body -->
				 <div class="box-footer">
				 <input type="hidden" readonly class="form-control" id="Member_Enrollement_id" name="Member_Enrollement_id" >
				 <input type="hidden" readonly class="form-control" id="Member_Current_balance" name="Member_Current_balance" >
				 <input type="hidden" readonly class="form-control" id="Member_Membership_id" name="Member_Membership_id" >				 
				 <input type="hidden" readonly class="form-control" id="Login_Enrollement_id" name="Login_Enrollement_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
				 <input type="hidden" readonly class="form-control" id="Login_Current_balance" name="Login_Current_balance" value="<?php echo $Enroll_details->Current_balance; ?>">
				 <input type="hidden" readonly class="form-control" id="Company_id" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				 <input type="hidden" readonly class="form-control" id="Login_Membership_id" name="Login_Membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
				 
				 
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div><!-- /.box -->
              </div><!-- /.box   id="enroll_details" style="display:none" -->		
			  
			 
			  
			  <div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">		
								<h4 class="text-center" style="color: aliceblue;">Member Details</h4>								
							</div>
							
							<div class="panel-body bg-primary">
								<div>
									<p class="col-md-6 text-left"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> &nbsp;&nbsp;
										<b>Member Name </b>
									</p>
									<p class="col-md-6" id="Member_name">&nbsp;</p>
								</div>
								
								<div>
									<p class="col-md-6 text-left"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> &nbsp;&nbsp;
										<b>Member Email ID </b>
									</p>
									<p class="col-md-6" id="Member_email_id">&nbsp;</p>
								</div>
								
								<div>
									<p class="col-md-6 text-left"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> &nbsp;&nbsp;
										<b>Member Phone No </b>
									</p>
									<p class="col-md-6" id="Member_phone">&nbsp;</p>
									 <input type="hidden" readonly class="form-control" id="Enrollement_id" name="Enrollement_id" >
									 
								</div>
								
							</div>
						</div>
						
					</div>
              </div><!-- /.box -->
			  
			  		
		
        </section>
		
		
		<!-- /.content -->
		
<?php echo form_close(); ?>
<?php $this->load->view('header/footer');?>


	 
<script type="text/javascript">
$('#Membership_id').blur(function()
{
	var Login_Enrollement_id = '<?php echo $enroll; ?>';
	var Membership_id = $('#Membership_id').val();
	var Company_id = '<?php echo $Company_id; ?>';	
	if(Membership_id != "" && Company_id != "")
	{
		$.ajax({
			type: "POST",			 
			data: {Membership_id: Membership_id, Company_id:Company_id, Login_Enrollement_id:Login_Enrollement_id},
			url: "<?php echo base_url()?>index.php/Cust_home/get_member_details",
			success: function(data)
			{
				if(data == 0)
				{
					$('#Membership_id').val("");
					$('#Member_name').html("&nbsp;");
					$('#Member_email_id').html("&nbsp;");
					$('#Member_phone').html("&nbsp;");
					has_error(".has-feedback","#glyphicon3","#Membership_id_help","Please Enter Valid Membership Id");
				}
				else
				{
					json = eval("(" + data + ")");
					if( (json[0].Enrollement_id) != 0 )
					{
						$('#Member_name').html(json[0].First_name+' '+json[0].Last_name);
						$('#Member_email_id').html(json[0].User_email_id);
						$('#Member_phone').html(json[0].Phone_no);
						// $('#Member_Enrollement_id').html(json[0].Enrollement_id);
						// $('#Member_Current_balance').html(json[0].Current_balance);
						document.getElementById("Member_Enrollement_id").value=(json[0].Enrollement_id);
						document.getElementById("Member_Current_balance").value=(json[0].Current_balance);
						document.getElementById("Member_Membership_id").value=(json[0].Card_id);
						has_success(".has-feedback","#glyphicon3","#Membership_id_help"," ");
					}
					else
					{
						$('#Membership_id').val("");
						$('#Member_name').html("&nbsp;");
						$('#Member_email_id').html("&nbsp;");
						$('#Member_phone').html("&nbsp;");
						has_error(".has-feedback","#glyphicon3","#Membership_id_help","Please Enter Valid Membership Id");
					}
				}
			}
		});
	}
	else
	{
		$('#Membership_id').val("");
		$('#Member_name').html("&nbsp;");
		$('#Member_email_id').html("&nbsp;");
		$('#Member_phone').html("&nbsp;");
		has_error(".has-feedback","#glyphicon3","#Membership_id_help","Please Enter Valid Membership Id");
	}
});

function Check_current_balance(transPoints)
{
	var login_curr_bal='<?php echo $Current_point_balance; ?>';
	if(parseFloat(transPoints) > parseFloat(login_curr_bal))
	{		
		document.getElementById('Transfer_Points').value='';
		var msg = "Insufficient Current Balance!";
		var Title = "Application Information";		
		runjs(Title,msg);
		return false;
	}
}
</script>	 