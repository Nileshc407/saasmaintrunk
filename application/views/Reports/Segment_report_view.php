<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Segment_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Segment Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-8">	
							
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Segment</label>
								<select class="form-control" name="Segment_id" ID="Segment_id" required onchange="Show_criteria(this.value);">
									<option value="">Select Segment</option>
									<?php
									
											foreach($Segment_records as $rec)
											{
												echo "<option value=".$rec->Segment_code.">".$rec->Segment_name."</option>";
											}
										?> 
							</select>
							</div>
							
							<div class="form-group" id="Segment_Criteria" style="display:none;">
									<label for="">&nbsp;Segment Criteria</label>
									<textarea class="form-control" rows="3" name="S_Criteria" id="S_Criteria" readonly>
									</textarea>
						</div>	

								
								
								
							</div>
							
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>

				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header"> Segment Report Records
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Total Spend  <?php echo '('.$Symbol_of_currency.')';?></th>
							

							</tr>

							</thead>						
							<tfoot>
								<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Total Spend <?php echo '('.$Symbol_of_currency.')';?></th>
							</tr>
								

							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						// print_r($Trans_Records);die;
						if(count($MembershipID) > 0)
						{
							 
							for($i=0;$i<count($MembershipID);$i++)
							{
								
								echo "<tr>";
								echo "<td>".$MembershipID[$i]."</td>";
								echo "<td>".$Member_name[$i]."</td>";
								echo "<td>".$Phone_no[$i]."</td>";
								echo "<td>".$User_email_id[$i]."</td>";
								echo "<td>".$total_purchase[$i]."</td>";
								
								
								echo "</tr>";
								
							}
							
						}
						?>
							</tbody>
						</table>
						<?php 
						if(count($MembershipID) != 0)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Segment_report/?pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Segment_report/?pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
					<?php 
						} 
						
						?>
					  </div>
					</div>
				</div>
				<!-----------Table------------>
				
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>



<script>
$('#Register').click(function()
{
	 if($('#Segment_id').val() != ""  )
		{
			show_loader();
		} 

});
function Show_criteria(Segment_id)
	{
		if(Segment_id !=0)
		{
			$.ajax({
				type: "POST",
				data: {Segment_id: Segment_id,Company_id:'<?php echo $Company_id; ?>'},
				url: "<?php echo base_url()?>index.php/Administration/Get_Segment_Criteria",
				success: function(data)
				{ 
					$("#Segment_Criteria").show();
					$("#S_Criteria").html(data.Criteria_data);			
				}
			});
		}
		else
		{
			$("#Segment_Criteria").hide();
		}
	}
	
</script>
