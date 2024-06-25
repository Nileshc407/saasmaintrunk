<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   APPROVE AUCTION WINNER
			  </h6>
			 
			
					<!-----------------------------------Flash Messege-------------------------------->

					<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
					<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
					<?php 	} ?>
					<!-----------------------------------Flash Messege-------------------------------->
			
			<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			  Approve Auction Winner
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Details</th>
							<th class="text-center">Auction name</th>
							<th class="text-center">Prize</th>
							<th class="text-center">Winner Name</th>
							<th class="text-center">Bid value</th>
							<th class="text-center">Status</th>
							<th class="text-center">Cancel</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				if($results != NULL)
				{
					foreach($results as $row1)
					{
						foreach( (array)$row1 as $row)
						{
							if($row != NULL)
							{
						?>
						<tr>
							<td class="text-center">
								<a href="javascript:void(0);" id="cust_details" onclick="cust_details('<?php echo $row['Enrollment_id']; ?>');" title="Receipt">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
							</td>
							<td class="text-center"><?php echo $row['Auction_name']; ?></td>
							<td class="text-center"><?php echo $row['Prize']; ?></td>
							<td class="text-center"><?php echo $row['First_name']." ".$row['Last_name']; ?></td>
							<td class="text-center"><?php echo $row['Bid_value']; ?></td>
							<td class="text-center">
								
							
					  	<div class="pt-btn">
                         <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="approve_auction_winner('<?php echo $row['Id']; ?>','<?php echo $row['Auction_id']; ?>','<?php echo $row['Enrollment_id']; ?>','<?php echo $Company_id; ?>');" ><span>Click to Approve</span></a>
                      </div>
							</td>
							<td class="text-center">
								
								<a class="btn btn-sm btn-danger"  href="javascript:void(0);" onclick="delete_auction_winner('<?php echo $row['Id']; ?>','<?php echo $row['Auction_id']; ?>','<?php echo $row['Enrollment_id']; ?>','<?php echo $Company_id; ?>');">Delete</a>
							</td>
						</tr>
					<?php
							}
						}
					}
				}
				?>		
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div> 
	<!--------------Table--------------->
				
		

	<!--------------Table2------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			 Approved Auction Winner
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Details</th>
							<th class="text-center">Auction name</th>
							<th class="text-center">Prize</th>
							<th class="text-center">Winner</th>
							<th class="text-center">Bid value</th>
							<th class="text-center">Date</th>
							<th class="text-center">Status</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				if($approved_auction_list != NULL)
				{
					foreach($approved_auction_list as $approved_auction)
					{
						if($approved_auction != NULL)
						{
						?>
						<tr>
							<td class="text-center">
								<a href="javascript:void(0);" id="cust_details" onclick="cust_details('<?php echo $approved_auction['Enrollment_id']; ?>');" title="Receipt">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
							</td>
							<td class="text-center"><?php echo $approved_auction['Auction_name']; ?></td>
							<td class="text-center"><?php echo $approved_auction['Prize']; ?></td>
							<td class="text-center"><?php echo $approved_auction['First_name']." ".$approved_auction['Last_name']; ?></td>
							<td class="text-center"><?php echo $approved_auction['Bid_value']; ?></td>
							<td class="text-center">
								<?php echo date("Y-m-d",strtotime($approved_auction['Creation_date'])); ?>
							</td>
							<td class="text-center">
								
								<a class="btn btn-success btn-sm" href="#">Approved</a>
							</td>
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
	</div> 
	<!--------------Table--------------->
		
				  
			  </div>
			  
			</div>
		  </div>
		</div>
		



	
	
</div>			
<?php $this->load->view('header/footer'); ?>

<!-- Modal -->
<div id="custdetail_myModal" class="modal fade" role="dialog" style="margin-top:10%;">
	<div class="modal-dialog" style="width: 90%;">

	<!-- Modal content --> 
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center" style="margin-top:23%;">Customer Details</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="show_cust_details"></div>
			</div>
			<div class="modal-footer">
				<button type="button" id="close_modal" class="btn btn-primary">Close</button>
			</div>
		</div>
	<!-- Modal content-->

	</div>
</div>
<!-- Modal -->

<script type="text/javascript">
function delete_auction(Auction_id,Auction_name)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Auction "+Auction_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_auction/?Auction_id='+Auction_id;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		}
	});
}

function cust_details(Enrollment_id)
{	
	$.ajax({
		type: "POST",
		data: {Enrollment_id: Enrollment_id},
		url: "<?php echo base_url()?>index.php/Administration/auction_cust_details",
		success: function(data)
		{
			$("#show_cust_details").html(data.auction_cust_details);	
			$('#custdetail_myModal').show();
			$("#custdetail_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}

function approve_auction_winner(ID,Auction_id,Enrollment_id)
{
	show_loader();
			window.location='<?php echo base_url()?>index.php/Administration/approve_auction_winner/?ID='+ID+'&Auction_id='+Auction_id+'&Enrollment_id='+Enrollment_id;
			return true;
	/* BootstrapDialog.confirm("Are you sure you want to Approve Auction Winner?", function(result) 
	{
		if (result == true)
		{				
			spinnerLoader();
			window.location='<?php echo base_url()?>index.php/Administration/approve_auction_winner/?ID='+ID+'&Auction_id='+Auction_id+'&Enrollment_id='+Enrollment_id;
			return true;
		}
		else
		{
			return false;
		}
	}); */
}

function delete_auction_winner(ID,Auction_id,Enrollment_id)
{
	show_loader();
	window.location='<?php echo base_url()?>index.php/Administration/delete_auction_winner/?ID='+ID+'&Auction_id='+Auction_id+'&Enrollment_id='+Enrollment_id;
			return true;
			
	/* BootstrapDialog.confirm("Are you sure you want to Delete Auction Winner?", function(result) 
	{
		if (result == true)
		{				
			spinnerLoader();
			window.location='<?php echo base_url()?>index.php/Administration/delete_auction_winner/?ID='+ID+'&Auction_id='+Auction_id+'&Enrollment_id='+Enrollment_id;
			return true;
		}
		else
		{
			return false;
		}
	}); */
}
</script>