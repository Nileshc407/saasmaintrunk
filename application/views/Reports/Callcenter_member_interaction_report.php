 <?php $this->load->view('header/header'); ?>
	<div class="row"> 
		<div class="col-md-12">
			<h1 class="page-head-line">Call Center Member Interaction Report</h1>
		</div>
	</div>	
<div class="row">
		<?php
		if(@$message)
		{
		?>
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-warning">
					<?php echo $message; ?><br>
				</div>
			</div>
		<?php 
		}
		?>
	
		<?php echo form_open_multipart('Reportc/Cc_member_interaction_reports'); ?>
		
			<div class="col-md-12">			
			<?php
			if(@$this->session->flashdata('error_code_CR'))
			{?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('error_code_CR')."<br>".$this->session->flashdata('upload_error_code'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>
		<div class="panel panel-default">                        		
			<div class="panel-body">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Membership Id </label>
						<div class="form-group">
						<input type="text" class="form-control" name="Membership" id="Membership" required>							
						</div>
					</div>					
					<div class="form-group">
						<label for="exampleInputEmail1">Sub Query</label>
						<select class="form-control" name="Sub_query_type" id="Sub_query_type" >
							<option value="">Select Sub Query</option>
							<option value="">All</option>
						</select>							
					</div>			
				</div>
				<div class="col-md-6">
					<div class="form-group">
					<label for="exampleInputEmail1">Query Type</label>
						<select class="form-control" name="Query_Type" id="Query_Type" >
							<option value="">Select Query Type</option>
							<option value="">All</option>
							<?php								
							foreach($query_type as $query_type)
							{	
							?>
							<option value="<?php echo $query_type->Query_type_id; ?>"><?php echo $query_type->Query_type_name; ?></option>
							<?php
							}
							?>
						</select>							
					</div>					
					<br><br><br><br>
					<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Submit</button>	
				</div>			
			</div> 
		</div> 
	</div> 
		<?php echo form_close(); ?>
</div><br>
	<?php 
	if(isset($_REQUEST["submit"]) && ($Member_interaction != NULL))
	{ 	 
		$Query_Type=$_REQUEST["Query_Type"];
		$Sub_query_type=$_REQUEST["Sub_query_type"];
		$Membership=$_REQUEST["Membership"];
	?>
	<div class="panel panel-info">
		<div class="panel-heading"> <h4> Member Query Interaction Report </h4>
			<div align="right">
			<label for="exampleInputEmail1">Page: </label>
				<select  name="page" ID="page" onchange="pagination_item(this.value);"  >
				<?php
					$page=(count($Count_Records)/10); 
					echo "count-->".count($Count_Records);echo "<br>page ".$page;
					$page=($page+0.4);
					for($i=1;$i<=round($page);$i++)
					{
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
				<option value="0">All</option>
				</select>							
			</div>	
		</div>
		<div class="table-responsive">
		<table  class="table table-bordered table-hover">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th>Membership Id</th>
					<th>Customer Name</th>
					<th>Query Log Ticket</th>
					<th>Assign / Forwarded</th>
					<th>Query Type</th>
					<th>Query</th>
					<th>Query Status</th>
					<th>Interaction</th>
					<th>Interaction Date</th>				
				</tr>
				</thead>
				
				<tbody>
				<?php
				if(isset($_REQUEST["submit"]) && ($Member_interaction != NULL))
				{ 
					foreach($Member_interaction as $row)
					{	
						
						echo "<td>".$row->Membership_id."</td>";
						echo "<td>".$row->Full_name."</td>";
						echo "<td>".$row->Querylog_ticket."</td>";
						echo "<td>".$row->Full_name1."</td>";
						echo "<td>".$row->Query_type_name."</td>";
						echo "<td>".$row->Query_details."</td>";
						echo "<td>".$row->Query_status."</td>";
						echo "<td>".$row->Query_interaction."</td>";					
						echo "<td>".$row->Creation_date."</td>";					
						echo "</tr>";
					}
				}
			?>
				<tr>
				</tr>
			<tr>
			<td colspan="12" >
				<a href="<?php echo base_url()?>index.php/Reportc/export_Cc_member_interaction_reports/?Query_Type=<?php echo $Query_Type; ?>&Sub_query_type=<?php echo $Sub_query_type; ?>&Membership=<?php echo $Membership; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=1">
				<img class="img-responsive img-thumbnail" src="<?php echo base_url(); ?>images/Excel.png" width="50" alt="Excel Dump" title="Excel Dump"/>
				</a>
				<a href="<?php echo base_url()?>index.php/Reportc/export_Cc_member_interaction_reports/?Query_Type=<?php echo $Query_Type; ?>&Sub_query_type=<?php echo $Sub_query_type; ?>&Membership=<?php echo $Membership; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=2">
				<img class="img-responsive img-thumbnail" src="<?php echo base_url(); ?>images/pdf.png" width="50" alt="PDF Dump" title="PDF Dump"/>
				</a>
		 <?php //echo $pagination; ?>
		 </td>
		</tr>
				</tbody> 
			</table>
		</div>
	</div>
<?php 
	} 
	else
	{
	?>
	<div class="panel panel-info">
		<div class="panel-heading text-center"><h4>No Record Found</h4></div>
	</div>
<?php } ?>
	
<?php $this->load->view('header/loader');?> 
<?php
	$this->load->view('header/footer');
	if(isset($_REQUEST["page_limit"]))
	{
		$limit=$_REQUEST["page_limit"];
		$Select_index=($limit/10)-1;
		if($limit==0)///All
		{
			//$Select_index=$page+1;
			echo "<script>";
			echo "var theSelect=document.getElementById('page');";
			echo "theSelect.selectedIndex =theSelect.options.length-1;";
			echo "</script>";
		}
		else
		{
			echo "<script>";
			echo "document.getElementById('page').selectedIndex =$Select_index;";
			echo "</script>";
		}
	}
?>

<script>
$('#Register').click(function()
{
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Query_Type').val() != ""  && $('#Sub_query_type').val() != "" )
		{
			show_loader();
		} 
});

function pagination_item(limit) 
{			 
	show_loader();        
	limit=(limit*10);
	var Company_id='<?php echo $Company_id; ?>';
	var Query_Type='<?php echo $Query_Type; ?>';
	var Sub_query_type='<?php echo $Sub_query_type; ?>';
	var Membership='<?php echo $Membership; ?>';
	
	window.location='Cc_member_interaction_reports?page_limit='+limit+'&Company_id='+Company_id+'&Query_Type='+Query_Type+'&Sub_query_type='+Sub_query_type+'&Membership='+Membership+'&submit';
} 	

$('#Query_Type').change(function()
{	
	var Query_Type = $("#Query_Type").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	
	$.ajax({
		type:"POST",
		data:{QueryTypeId:Query_Type, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Get_Sub_Query_Report",
		
		success: function(data)
		{
			$('#Sub_query_type').html(data.Get_Sub_query_Names1);		
		}				
	});
});

/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
		
});
/******calender *********/
</script>
