<?php 
if($Surveyanalysis)
{ ?>
	<br><h6 class="form-header">Individual Customer Responses Details</h6>
	<div class="table-responsive">
		<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
			<thead>
			<tr>
				<th>Action</th>
				<th>Customer Name</th>
				<th>Survey Name</th>
			</tr>						
			</thead>
			<tfoot>
			<tr>
				<th>Action</th>
				<th>Customer Name</th>
				<th>Survey Name</th>
			</tr>
			</tfoot>
			<tbody>
			<?php
			// $ci_object = &get_instance();
			// $ci_object->load->model('Survey_model');	
				foreach($Surveyanalysis as $survey)
				{	
					$Survey_id=$survey['Survey_id'];
					$Company_id=$survey['Company_id'];
				?>
					<tr>
						<td class="row-actions">
						<a href="javascript:void(0);" onclick="Survey_question_analysis('<?php echo $survey['Survey_id']; ?>','<?php echo $survey['Company_id']; ?>','<?php echo $survey['Enrollment_id']; ?>');">
						<i class="os-icon os-icon-ui-49"></i>
						</a>
						</td>
						<td><?php echo $survey['First_name'].' '.$survey['Last_name']; ?></td>
						<td><?php echo $survey['Survey_name']; ?></td>					
					</tr>
				<?php
				}
			?>					
			</tbody> 
		</table>
		<a href="<?php echo base_url()?>index.php/Survey/export_survey_analysis_report/?report_type=2&Survey_id=<?php echo $Survey_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=1">
		<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
		</a>
		
		<a href="<?php echo base_url()?>index.php/Survey/export_survey_analysis_report/?report_type=2&Survey_id=<?php echo $Survey_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=2">
		<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
		</a>
	</div>
<?php 
}
?>		