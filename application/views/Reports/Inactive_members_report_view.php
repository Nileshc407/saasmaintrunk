<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
	
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Inactive_members_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Inactive Members Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
								
								  <div class="form-group">
									<label class="col-form-label">Who have not done any transaction since</label>
									<div>
									
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="days" checked type="radio" value="1" required="required">30 days</label>
									  </div>
									  
									  
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="days"  type="radio" value="2" onclick="hide_show_refrence(this.value);"  required="required">60 days</label>
									  </div>
									  
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="days"  type="radio" value="3" required="required">90 days</label>
									  </div>
									  
									
									</div>
									 <div class="help-block form-text with-errors form-control-feedback"></div> 
								  </div>
					  								
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>

					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>
		
				<!---------Table--------->	 
				<div class="element-wrapper">											
				<div class="element-box">
                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>User Name</th>
							<!--	<th>User Type</th>-->
								<th>Membership ID</th>
								<th>Membership Date</th>
								<th>Phone No.</th>
								<th>Total <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Bonus <?php echo $Company_details->Currency_name; ?></th>
								<th>Last Visit Date</th>
							</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>User Name</th>
								<!--	<th>User Type</th>-->
								<th>Membership ID</th>
								<th>Membership Date</th>
								<th>Phone No.</th>
								<th>Total <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Bonus <?php echo $Company_details->Currency_name; ?></th>
								<th>Last Visit Date</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($worry_customers != NULL)
						{
							$Worry_Customer_name = $worry_customers['User_name'];
							$Customer_last_visit = $worry_customers['Customer_last_visit'];
							$Card_id = $worry_customers['Card_id'];
						//	$User_id = $worry_customers['User_id'];
							$Membership_date = $worry_customers['Membership_date'];
							$Phone_no = $worry_customers['Phone_no'];
							$Current_balance = $worry_customers['Current_balance'];
							$Total_reddems = $worry_customers['Total_reddems'];
							$Total_topup_amt = $worry_customers['Total_topup_amt'];								
							$count_worry=count($Worry_Customer_name);
							
							for($i=0;$i<$count_worry;$i++)
							{
								if($Worry_Customer_name[$i] != NULL)
								{ 
									
									if($Card_id[$i]!=0)
									{	$Card_id1=$Card_id[$i];	}
									else {$Card_id1='-'; }
									if($City[$i]!="")
									{	$City1=$City[$i];	}
									else {$City1='-'; }
									if($Phone_no[$i]!="")
									{	$Phone_no1=$Phone_no[$i];	}
									else {$Phone_no1='-'; }
									if($Current_balance[$i]!=0)
									{$Current_balance1=$Current_balance[$i];	}
									else {$Current_balance1='-'; }
									if($Total_reddems[$i]!=0)
									{$Total_reddems1=$Total_reddems[$i];	}
									else {$Total_reddems1='-'; }
									if($Total_topup_amt[$i]!=0)
									{$Total_topup_amt1=$Total_topup_amt[$i];	}
									else {$Total_topup_amt1='-';}
									
									echo '<tr>';
									echo '<td>'.$Worry_Customer_name[$i].'</td>';
								//	echo '<td>'.$User_id1.'</td>';
									echo '<td>'.$Card_id[$i].'</td>';
									echo '<td>'.date("d M Y",strtotime($Membership_date[$i])).'</td>';
									echo '<td>'.$Phone_no1.'</td>';
									echo '<td>'.$Current_balance1.'</td>';
									echo '<td>'.$Total_reddems1.'</td>';
									echo '<td>'.$Total_topup_amt1.'</td>';
									echo '<td>'.date("d M Y",strtotime($Customer_last_visit[$i])).'</td>';
									echo '</tr>';
								}
							}
						} ?>
						</tbody>
					</table>
			<?php 	if($worry_customers != NULL)
					{ ?>
					<a href="<?php echo base_url()?>index.php/Reportc/Inactive_members_report/?pdf_excel_flag=1&days=<?php echo $days; ?>">
					<button class="btn btn-success" type="submit" id="Register"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
					
					<a href="<?php echo base_url()?>index.php/Reportc/Inactive_members_report/?pdf_excel_flag=2&days=<?php echo $days; ?>">
					<button class="btn btn-danger" type="submit" id="Register"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button></a>
			<?php  } ?>
				  </div>
				</div>
			</div>
				<!-----------Table------------>
			
			</div>
		</div>

	</div>	
</div>
<!-------------Activate modal start------------->	
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show" id="MakeActive" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Confirmation
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arg111" id="arg111" value=""/>
                <input type="hidden" name="arg222" id="arg222" value=""/>
                <input type="hidden" name="arg333" id="arg333" value=""/>
                <input type="hidden" name="argUrl11" id="argUrl11" value=""/>
                Are you sure you want to Active this user <b id="arg222"></b> ?<br></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_active(arg111.value, arg222.value, arg333.value, argUrl11.value)">OK</button>
            </div>
        </div>
    </div>
</div>
<!---------------Activate modal end---------------->
<?php $this->load->view('header/footer'); ?>
<script type="text/javascript">
function Active_me(arg1, arg2, arg3, argUrl) 
{
    $(".modal-body #arg111").val(arg1);
    $(".modal-body #arg111").html(arg1);

    $(".modal-body #arg222").val(arg2);
    $(".modal-body #arg222").html(arg2);

    $(".modal-body #arg333").val(arg3);
    // $(".modal-body #arg333").html(arg3);

    $(".modal-body #argUrl11").val(argUrl);
}
function confirmed_active(arg1, arg2, arg3, argUrl) 
{
    if (argUrl)
    {
        var url = '<?php echo base_url(); ?>index.php/' + argUrl + '=' + arg1 + '&Usertype=' +arg3;
        $('#MakeActive').modal('hide');
        show_loader();
        setTimeout(function () {
            window.location = url;
        }, 3000)
        return true;
    } 
	else
    {
        return false;
    }
}

</script>
<link href="<?php echo base_url(); ?>assets/icon_fonts_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">