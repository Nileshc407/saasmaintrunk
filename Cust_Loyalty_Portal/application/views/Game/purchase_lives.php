<?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
			Purchase Game Lives
          </h1>
          
        </section>
		<?php echo form_open('Cust_home/InsertPurchaseLives'); ?>

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
            
			  <div class="login-box">
			  <div class="login-box-body">
                <div class="box-header with-border">
                  <h3 class="box-title">Purchase Lives</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                  <div class="box-body">
					  
					 <div class="form-group">
                      <label for="exampleInputEmail1">Current Balance</label>
                      <input type="text" class="form-control" id="currentbal" name="currentbalance" value="<?php echo $Enroll_details->Current_balance; ?>" readonly>
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Game Name</label>
						<select class="form-control" name="Game_id" id="Game_id" required>
							<?php 
							foreach($games as $game_details)
							{
								if($game_details->Company_game_id == $Comp_Game_ID)
								{
							?>
								<option value="<?php echo $game_details->Company_game_id; ?>" ><?php echo $game_details->Game_name; ?></option>
							<?php 
								}
							}
							?>
						</select>	
                    </div>
                    
					 <div class="form-group">
                      <label for="exampleInputEmail1">Available Lives</label>
                      <input type="text" class="form-control" id="currentlives" name="currentlives" value="<?php echo $member_total_lives; ?>" readonly>
                      <input type="hidden" class="form-control" id="Points_value_for_one" name="Points_value_for_one" value="<?php echo $Comp_Game_info['0']->Points_value_for_one; ?>" readonly>
                    </div>
 
					<div class="form-group">
                      <label for="exampleInputEmail1">Purchase Lives</label>
                      <input type="text" class="form-control" id="purchase_lives" onblur="Validate_lives(this.value)" name="purchase_lives"  placeholder="Enter Lives You Want" required>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Equivalent Point Value</label>
                      <input type="text" class="form-control" id="bal_pay" name="bal_pay"  readonly placeholder="Points to pay" required>
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
			  
        </section>
		
		
		<!-- /.content -->
		
<?php echo form_close(); ?>
<?php $this->load->view('header/footer');?>
	 
<script type="text/javascript">


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
	
function Validate_lives(transLives)
{
	var ratio_value = '<?php echo $Comp_Game_info['0']->Points_value_for_one; ?>';
	
	var Current_balance = '<?php echo $Enroll_details->Current_balance; ?>';	

	var redeem_amt1 = (transLives * ratio_value).toFixed(2);
	
	//alert(ratio_value+"---"+Current_balance+"----"+redeem_amt1);

	if(redeem_amt1 >= 0 || redeem_amt1 >= 0.00)
	{
		if(Math.round(redeem_amt1) > Current_balance)
		{
			$("#bal_pay").val("");
			
			var msg = "Insufficient Balance to Purchase Lives!";
			var Title = "In-appropriate Data";		
			runjs(Title,msg);
			return false;
		}
		else
		{
			//$("#bal_pay").val = Math.round(redeem_amt1);
			document.getElementById("bal_pay").value = Math.round(redeem_amt1);
		}
	}
	
}


</script>	 
	
	
	 
