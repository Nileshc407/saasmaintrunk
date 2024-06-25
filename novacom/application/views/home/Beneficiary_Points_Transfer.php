 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Beneficiary/Beneficiary_Points_Transfer');	?>
        <section class="content-header">
          <h1>
            Beneficiary Transfer Points
          </h1>
         
        </section>

		<?php
			if(@$this->session->flashdata('success'))
			{
				?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('success'); ?>';
					runjs(Title,msg);
				</script>
				<?php
			}
			?>
			<?php 
			
			
			if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
				<script>
						BootstrapDialog.show({
						closable: false,
						title:'Application Information',
						message:'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
						buttons:[{
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
				<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">Select Beneficiary to Transfer Points</h3>                 
		</div>
		<form action="#" method="post">		
		<div class="box-body">
			<div class="table-responsive">
				
				<table class="table table-bordered">
				<thead>
				<tr> 
				
							<th>Select</th>
							<th>Beneficiary Company Name</th>
							<th>Beneficiary Name</th>
							<th>Beneficiary Membership ID</th>
							
							
					
				</tr>					
				</thead>				
				<tbody>					 
					<?php 
					if($Get_Beneficiary_members != "")
					{
						foreach($Get_Beneficiary_members as $Rec2)
						{
							if($Rec2->Beneficiary_status==1)//Approved
							{
								$ci_object = &get_instance();
								$ci_object->load->model('Igain_model');
								$Login_Company_Details= $ci_object->Igain_model->get_company_details($Rec2->Igain_company_id);
								$Company_logo=$Login_Company_Details->Company_logo;
							
							?>
									<tr>	
										<td><div class="funkyradio">
										 <div class="funkyradio-primary">
											<input type="radio" name="Beneficiary_membership_id" id="<?php echo $Rec2->Beneficiary_membership_id; ?>" value="<?php echo $Rec2->Beneficiary_membership_id; ?>" required onclick="Get_Beneficiary_company_list(<?php echo $Rec2->Beneficiary_company_id; ?>);Lable_Beneficiary_name(Company_name_<?php echo $Rec2->Beneficiary_membership_id; ?>.value);">
											<label for="<?php echo $Rec2->Beneficiary_membership_id; ?>">Select</label>
										</div>	
										</div>	</td>
										<td>
											<img src="<?php echo $this->config->item('base_url2')?><?php echo $Company_logo; ?>" width="50px;">
											<?php echo $Rec2->Beneficiary_company_name; ?>
											<input type="hidden" name="Company_name_<?php echo $Rec2->Beneficiary_membership_id; ?>" value="<?php echo $Rec2->Beneficiary_company_name; ?>">
										</td>
										<td>
												
												<?php echo $Rec2->Beneficiary_name; ?>
												<input type="hidden" name="Beneficiary_name_<?php echo $Rec2->Beneficiary_membership_id; ?>" value="<?php echo $Rec2->Beneficiary_name; ?>">
											<input type="hidden" name="Beneficiary_company_id_<?php echo $Rec2->Beneficiary_membership_id; ?>" value="<?php echo $Rec2->Beneficiary_company_id; ?>">
											
										
										</td>
										<td><?php echo $Rec2->Beneficiary_membership_id; ?></td>
										<input type="hidden" name="Igain_company_id_<?php echo $Rec2->Beneficiary_membership_id; ?>" id="Igain_company_id_<?php echo $Rec2->Beneficiary_membership_id; ?>" value="<?php echo $Rec2->Igain_company_id; ?>">
																  
									</tr>
								<?php 
							}	
								
						}
							
					}
						
				?>
			  
				</tbody>	  
				</table>
			</div>
		</div>
				
	</div>
			<div class="login-box" style="width: 500px;">
			  <div class="login-box-body">
				<p class="login-box-msg"> </p>
				<div class="form-group has-feedback">
					<label class="radio-inline" >
					<input type="radio"  name="Transfer_other"  id="1"    value="0" onclick="toggle_company(this.value);" checked>'<b>From '<?php echo $Company_name;  ?>' to Other'</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>	
					<label class="radio-inline">
					<input type="radio"  name="Transfer_other"  id="2"     value="1" onclick="toggle_company(this.value);" ><b>From 'Other' to 'Other'</b>
					</label>						
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>
				<div class="form-group has-feedback" id="Beneficiary_company" style="display:none;">
						<font color='red'>Please first Select Beneficiary to Transfer Points ....</font>
				</div>
				
				 <div class="form-group has-feedback" id="Beneficiary_Reference_current_balance" style="display:none;">
						<label for="exampleInputEmail1">Current Balance</label>
						<input type="text" class="form-control" disabled id="Reference_current_balance"/>					
				</div>
					<div class="form-group has-feedback">
						<label for="exampleInputEmail1">Transfer Points</label>
						<input type="text" name="Transfer_Points" id="Transfer_Points" class="form-control" placeholder="Enter Transfer Points" required onchange="Check_current_balance(this.value);Get_Equi_points(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"/>					
					</div>
					<div class="form-group has-feedback" id="Equivalent" >
						<label for="exampleInputEmail1">Equivalent Points (For Beneficiary <span id="Lable_Beneficiary"></span>)</label>
						<input type="text"  class="form-control" disabled id="Equivalent_points"/>					
					</div>
					
					<input type="hidden" id="From_Beneficiary_company_name" name="From_Beneficiary_company_name" value="">
					<div class="row">
					
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat" id="submit" >Submit</button>
					
					</div><!-- /.col -->
				  </div>
				</form>


			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
         </div><!-- /.row -->
		<?php echo form_close(); ?>
		
		
		<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">Beneficiary Transfer Points History</h3>                 
		</div>
				
		<div class="box-body">
			<div class="table-responsive">
				
				<table class="table table-bordered">
				<thead>
				<?php 
					if($Beneficiary_Trans_points_history != "")
					{ ?>
				<tr> 
				
							<th>Transaction Date</th>
							<th>Sender Company</th>
							<th>Sender Member</th>
							<th>Transfered Points</th>
							<th>Recieving Company</th>
							<th>Recieving Member</th>
							<th>Recieving Points</th>
				</tr>			
				<?php 	} ?>	
				</thead>				
				<tbody>					 
						<?php 
					if($Beneficiary_Trans_points_history != "")
					{
						$ci_object = &get_instance();
						$ci_object->load->model('Beneficiary/Beneficiary_model');
						// echo"----Redeemption_report-------".$Redeemption_report."---<br>";
						// echo"----Report_type-------".$Report_type."---<br>";
						// print_r($Beneficiary_Trans_points_history);
						foreach($Beneficiary_Trans_points_history as $Trans_RPT)
						{ 
							$Topup_amount= $ci_object->Beneficiary_model->get_received_points_beneficiary($Trans_RPT->Manual_billno,$Trans_RPT->From_Beneficiary_company_id,$Trans_RPT->To_Beneficiary_company_id);
							
							// $Topup_amount=$Details->Topup_amount;
						?>
							<tr>							  
								<td><?php echo $Trans_RPT->Trans_date; ?></td>
								<td><?php echo $Trans_RPT->From_Beneficiary_company_name; ?></td>
								<td><?php echo $Trans_RPT->Card_id; ?></td>
								<td><?php echo $Trans_RPT->Transfer_points; ?></td>
								<td><?php echo $Trans_RPT->To_Beneficiary_company_name; ?></td>
								<td><?php echo $Trans_RPT->To_Beneficiary_cust_name."(".$Trans_RPT->Card_id2.")"; ?></td>
							<td><?php echo $Topup_amount; ?></td>
							</tr>
				<?php 	} 
					}
					else
					{
						echo "<h4 align='center' style='color:red;'>No Records Found !!!</h4>";
					}
						?>					
										
				</tbody>	  
				</table>
			</div>
		</div>
		
				
	</div>
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>	
		
        </section><!-- /.content -->
		<script>
			$('#submit').click(function()
			{	
				if (!$('input[name=Beneficiary_membership_id]:checked').val() ) { 
						var Title = "Application Information";
						var msg = 'Please Select One Beneficiary Person !!!';
						runjs(Title,msg);
						return false;
					}
				else
				{
					var Transfer_other=$('input[name=Transfer_other]:checked').val();
					if(Transfer_other==1)//Yes other
					{
						
						if($('#Beneficiary_company_id').val()=="")
						{		
							var msg = "Please Select From Company !!!";
							var Title = "Application Information";		
							runjs(Title,msg);
							return false;
						}
						if($('#Transfer_Points').val()!="" && $('#Beneficiary_company_id').val()!="")
						{
							show_loader();
						}
					}
					else
					{
						if($('#Transfer_Points').val()!="")
						{
							show_loader();
						}
					}
			
					
				}		
					// alert($('input[name=Beneficiary_membership_id]:checked').val());
			});

		function Check_current_balance(transPoints)
		{
			var Transfer_other=$('input[name=Transfer_other]:checked').val();
			
			if(Transfer_other==1)//Yes other
			{
				if(parseFloat(transPoints) > parseFloat(window.Reference_current_balance))
				{		
					document.getElementById('Transfer_Points').value='';
					var msg = "Insufficient Current Balance!";
					var Title = "Application Information";		
					runjs(Title,msg);
					return false;
				}
			}
			else
			{
				var login_curr_bal='<?php echo $Enroll_details->Total_balance; ?>';
				// alert(login_curr_bal);
				if(parseFloat(transPoints) > parseFloat(login_curr_bal))
				{		
					document.getElementById('Transfer_Points').value='';
					var msg = "Insufficient Current Balance!";
					var Title = "Application Information";		
					runjs(Title,msg);
					return false;
				}
			}
			
		}
		function Get_Equi_points(Points)
		{
				var Company_id = '<?php echo $Company_id; ?>';
				var Transfer_other=$('input[name=Transfer_other]:checked').val();
				var Beneficiary_company_id=$('#Beneficiary_company_id').val();
				var Beneficiary_membership_id=$('input[name=Beneficiary_membership_id]:checked').val();
				var Igain_company_id=$('#Igain_company_id_'+Beneficiary_membership_id).val()
				// alert('Transfer_other '+Transfer_other);
				/*  alert('Company_id '+Company_id);
				alert('Transfer_other '+Transfer_other);
				alert('Beneficiary_company_id '+Beneficiary_company_id);
				alert('Beneficiary_membership_id '+Beneficiary_membership_id);
				alert('Igain_company_id '+Igain_company_id);
				
				alert('Points '+Points);
				  */
				  
			
				 	$.ajax({
						type: "POST",
						data: { Company_id: Company_id ,Transfer_Points: Points,Transfer_other: Transfer_other,Beneficiary_company_id: Beneficiary_company_id,Beneficiary_membership_id: Beneficiary_membership_id,Igain_company_id: Igain_company_id},
						url: "<?php echo base_url()?>index.php/Beneficiary/Get_Equivalent_beneficiary_points",
						success: function(data)
						{
								if(Transfer_other==0)
							  {
								  if(Points!="")
								 {
									  // alert(data);
									 document.getElementById("Equivalent_points").value=data;
								 }
							  }
							  else
							  {
								  var Reference_current_balance=  $('#Reference_current_balance').val();
								  if(Points!="" && Reference_current_balance!="")
								 {
									  // alert(data);
									 document.getElementById("Equivalent_points").value=data;
								 }
							  }
							  /*  alert(data);
							   document.getElementById("Equivalent_points").value=data;
							 if(Points!="" && Reference_current_balance!="")
							 {
								  // alert(data);
								 document.getElementById("Equivalent_points").value=data;
							 } */
							 
						}
					});
		}
		function Lable_Beneficiary_name(Beneficiary_name)
		{			
			document.getElementById("Lable_Beneficiary").innerHTML="'"+Beneficiary_name+"'";			 
		}
		function Get_Beneficiary_company_list(Beneficiary_company_id)
		{
			//alert(Beneficiary_company_id);
				Get_Equi_points(document.getElementById('Transfer_Points').value);
				var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
						type: "POST",
						data: { Company_id: Company_id ,Beneficiary_company_id: Beneficiary_company_id},
						url: "<?php echo base_url()?>index.php/Beneficiary/Get_Beneficiary_Company_list",
						success: function(data)
						{
							// alert(data);
							document.getElementById("Beneficiary_company").innerHTML=data;
						}
					});
		}
		function Get_Beneficiary_Company_details(Beneficiary_company_id)
		{
				var transPoints=document.getElementById('Transfer_Points').value;
				Get_Equi_points(transPoints);
				
				var Enroll_id = '<?php echo $enroll; ?>';
				var From_Beneficiary_company_name = document.getElementById("Beneficiary_company_id").options[document.getElementById("Beneficiary_company_id").selectedIndex].text;
				document.getElementById("From_Beneficiary_company_name").value=From_Beneficiary_company_name;
				$.ajax({
						type: "POST",
						data: { Beneficiary_company_id: Beneficiary_company_id,Enroll_id:Enroll_id},
						url: "<?php echo base_url()?>index.php/Beneficiary/Get_Beneficiary_Company_details",
						success: function(data)
						{
							if(data==0)
							{
								$('#Reference_current_balance').val(0);
								window.Reference_current_balance=0;
								Check_current_balance(transPoints);
							}
							else
							{
								json = eval("(" + data + ")");
								$('#Reference_current_balance').val(json[0].Reference_current_balance);
								window.Reference_current_balance=json[0].Reference_current_balance;
							}
							 
							
						}
					});
		}
		function toggle_company(flag)
		{
			if(flag==1)//Yes
			{
				document.getElementById('Beneficiary_company').style.display="";
				// document.getElementById('Equivalent').style.display="";
				document.getElementById('Beneficiary_Reference_current_balance').style.display="";
			}
			else
			{
				document.getElementById('Beneficiary_company').style.display="none";
				// document.getElementById('Equivalent').style.display="none";
				document.getElementById('Beneficiary_Reference_current_balance').style.display="none";
			}
		}
	  </script>
<style>
@import('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css') .funkyradio div {
    clear: both;
    /*margin: 0 50px;*/
    overflow: hidden;
}
.funkyradio label {
    /*min-width: 400px;*/
    width: 100%;
	 border-radius: 3px;
    border: 1px solid #D1D3D4;
    font-weight: normal;
}
.funkyradio input[type="radio"]:empty, .funkyradio input[type="checkbox"]:empty {
    display: none;
}
.funkyradio input[type="radio"]:empty ~ label, .funkyradio input[type="checkbox"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.funkyradio input[type="radio"]:empty ~ label:before, .funkyradio input[type="checkbox"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content:'';
    width: 2.5em;
    background: #D1D3D4;
    border-radius: 3px 0 0 3px;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="radio"]:checked ~ label:before, .funkyradio input[type="checkbox"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="radio"]:checked ~ label, .funkyradio input[type="checkbox"]:checked ~ label {
    color: #777;
}
.funkyradio input[type="radio"]:focus ~ label:before, .funkyradio input[type="checkbox"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}
.funkyradio-default input[type="radio"]:checked ~ label:before, .funkyradio-default input[type="checkbox"]:checked ~ label:before {
    color: #333;
    background-color: #ccc;
}
.funkyradio-primary input[type="radio"]:checked ~ label:before, .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #337ab7;
}
.funkyradio-success input[type="radio"]:checked ~ label:before, .funkyradio-success input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #5cb85c;
}
.funkyradio-danger input[type="radio"]:checked ~ label:before, .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #d9534f;
}
.funkyradio-warning input[type="radio"]:checked ~ label:before, .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #f0ad4e;
}
.funkyradio-info input[type="radio"]:checked ~ label:before, .funkyradio-info input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #5bc0de;
}	
		</style>	