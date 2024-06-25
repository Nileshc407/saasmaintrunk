<?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
			Transfer Game Lives
          </h1>
          
        </section>
		<?php echo form_open('Cust_home/InsertTransferLives'); ?>

			<?php
			if(@$this->session->flashdata('select_game21'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('select_game21'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>

        <!-- Main content -->

            <section class="content">
			<div class="row">
            <!-- left column -->
            
			  <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Transfer Lives</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                  <div class="box-body">
					  
					 <div class="form-group">
                      <label for="exampleInputEmail1">Available Lives</label>
                      <input type="text" class="form-control" id="currentlives" name="currentlives" value="<?php echo $member_total_lives; ?>" readonly>
                    </div>
                     
					<div class="form-group has-feedback" id="Membership_id_help1">
                      <label for="exampleInputEmail1">Transfer To </label>
                      <input type="text" class="form-control" id="Membership_id" name="Membership_id" placeholder="Enter Membership Card" required>
					
					  <span class="glyphicon" id="Membership_id_help2" aria-hidden="true"></span>
					  <div class="help-block" id="Membership_id_help3"></div>
                    </div>
                    
					<div class="form-group">
                      <label for="exampleInputEmail1">Transfer Lives</label>
                      <input type="text" class="form-control" id="transfer_lives" onblur="Check_current_balance(this.value)" name="transfer_lives"  placeholder="Enter Transfer Lives" required>
                    </div>
                    
                    <?php if($Pin_no_applicable==1){?>
						<div class="form-group has-feedback"  id="pin_feedback">
							<label for="exampleInputEmail1" >Member Pin</label>
							<input type="password" name="input_cust_pin"  id="input_cust_pin" value="" class="form-control" placeholder="Enter Pin No."  style="width:100%;padding-right:0px !important;text-align:left;"/>
							
							<span class="glyphicon" id="pin_glyphicon" aria-hidden="true"></span>						
							<div class="help-block" id="pin_help"></div>									
						</div>
					<?php } ?>
                                
                 </div><!-- /.box-body -->
				 <div class="box-footer">
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
					  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
					  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
					  
					  <input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
					  <input type="hidden" name="Comp_Game_ID" value="<?php echo $Comp_Game_ID; ?>" class="form-control" />
					  <input type="hidden" name="GameLevel" value="<?php echo $GameLevel; ?>" class="form-control" />
					  <input type="hidden" name="gameID" value="<?php echo $gameID; ?>" class="form-control" />
					  <input type="hidden" name="game_type" value="<?php echo $game_type; ?>" class="form-control" />
				 
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div><!-- /.box -->
              </div><!-- /.box   id="enroll_details" style="display:none" -->		
			  
			 
			  
			  <div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">		
								<h4 class="text-center">Member Details</h4>								
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
									 <input type="hidden" readonly class="form-control" id="Member_Enrollement_id" name="ToEnrollement_id" >
									 
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
	var Membership_id = $('#Membership_id').val();
	var Company_id = '<?php echo $Company_id; ?>';	
	
	if(Membership_id != "" && Company_id != "")
	{
		$.ajax({
			type: "POST",			 
			data: {Membership_id: Membership_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/get_member_details",
			success: function(data)
			{
				if(data == 0)
				{
					$('#Membership_id').val("");
					$('#Member_name').html("&nbsp;");
					$('#Member_email_id').html("&nbsp;");
					$('#Member_phone').html("&nbsp;");
					has_error("#Membership_id_help1","#Membership_id_help2","#Membership_id_help3","Please Enter Valid Membership Id");
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
						
					}
					else
					{
						$('#Membership_id').val("");
						$('#Member_name').html("&nbsp;");
						$('#Member_email_id').html("&nbsp;");
						$('#Member_phone').html("&nbsp;");
						
					}
					
					has_success("#Membership_id_help1","#Membership_id_help2","#Membership_id_help3","");
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
		has_error("#Membership_id_help1","#Membership_id_help2","#Membership_id_help3","Please Enter Valid Membership Id");
	}
});

var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';

	if(Pin_no_applicable == 1)
	{	
		$("#input_cust_pin").attr("required","required");	
		$('#input_cust_pin').blur(function()
		{	
			var Customer_pin = '<?php echo $Cust_Pin; ?>';
			//alert(Customer_pin);
			var Entered_pin = $('#input_cust_pin').val();
			
			if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
			{
				$('#input_cust_pin').val("");
				has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
			}
			else
			{
				has_success("#pin_feedback","#pin_glyphicon","#pin_help","Valid Pin");
			}
		});
	}
	else
	{
		$("#input_cust_pin").removeAttr("required");	
	}
	
function Check_current_balance(transPoints)
{
	var login_curr_bal='<?php echo $member_total_lives; ?>';
	
	if(parseFloat(transPoints) > parseFloat(login_curr_bal))
	{		
		document.getElementById('transfer_lives').value='';
		var msg = "Insufficient Balance to Transfer Lives!";
		var Title = "In-appropriate Data";		
		runjs(Title,msg);
		return false;
	}
}


</script>	 
	
	
	 
