<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box" style="min-height:720px;">
		<div class="row">
			<div class="element-wrapper">
				<h6 class="element-header">Deactivated Members From System</h6>			
				<div class="element-box">
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				<?php  
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} ?>
				  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Activate</th>
								<th>User Name</th>
								<th>User Type</th>
								<th>Membership ID</th>
								<th>Membership Date</th>
								<th>Phone No.</th>
								<th>Total <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Bonus <?php echo $Company_details->Currency_name; ?></th>
							</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Activate</th>
								<th>User Name</th>
								<th>User Type</th>
								<th>Membership ID</th>
								<th>Membership Date</th>
								<th>Phone No.</th>
								<th>Total <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
								<th>Total Bonus <?php echo $Company_details->Currency_name; ?></th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($Users_Records != NULL)
						{
							foreach($Users_Records as $row)
							{	
								//$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name; ?>
							<tr>
								<td class="row-actions">
								<a href="javascript:void(0);" onclick="Active_me('<?php echo $row->Enrollement_id;?>','<?php echo $row->User_type; ?>','<?php echo $row->User_type; ?>','Reportc/Deactivated_members_report/?enrollID');" data-target="#MakeActive" data-toggle="modal" title="Make-Active"><i class="fa fa-check-square-o"></i></a>
								</td>
								<td><?php echo $row->Name; ?></td>
								<td><?php echo $row->User_type;?></td>
								<td><?php echo $row->Membership_id;?></td>
								<td><?php echo date("Y-m-d", strtotime($row->Membership_date));?></td>
								<td><?php echo $row->Phone_no;?></td>
								<td><?php echo $row->Current_balance;?></td>
								<td><?php echo $row->Total_reddems;?></td>
								<td><?php echo $row->Total_topup_amt;?></td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
					<?php if($Users_Records != NULL){?>
					<a href="<?php echo base_url()?>index.php/Reportc/Deactivated_members_report/?pdf_excel_flag=1">
					<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
					
					<a href="<?php echo base_url()?>index.php/Reportc/Deactivated_members_report/?pdf_excel_flag=2">
					<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button></a>
					<?php } ?>
				  </div>
				</div>
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