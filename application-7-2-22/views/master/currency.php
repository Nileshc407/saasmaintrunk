<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				CURRENCY MASTER
			  </h6>
				<div class="element-box panel">
				  <div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					}
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
					
					
					<?php  $attributes = array('id' => 'formValidate');
						echo form_open('Masterc/currency',$attributes); ?>
						
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Currency Nation</label>
						<input class="form-control" type="text" name="Currency_nation" id="Currency_nation" placeholder="Enter currency nation" data-error="Please enter currency nation" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block"></div>
					  </div>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Currency Name</label>
						<input class="form-control" type="text" name="Currency_name" id="Currency_name" placeholder="Enter currency name" data-error="Please enter currency name" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Currency Symbol</label>
						<input class="form-control" type="text" name="currency_symbol" id="currency_symbol" placeholder="Enter currency symbol" data-error="Please enter currency symbol" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					  </div>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Dial Code for Country</label>
						<input class="form-control" type="text" name="dial_code" id="dial_code" placeholder="Enter dial code" data-error="Please enter dial code" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
					  </div>
					  
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
				</div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
					Currency
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>Country</th>
								<th>Currency Name</th>
								<th>Symbol of Currency</th>
								<th>Dial Code(+)</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>Country</th>
								<th>Currency Name</th>
								<th>Symbol of Currency</th>
								<th>Dial Code(+)</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results != NULL)
						{
							foreach($results as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Masterc/edit_currency/?Country_id=<?php echo $row->Country_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								<td><?php echo $row->Country_id;?></td>
								<td><?php echo $row->Country_name;?></td>
								<td><?php echo $row->Currency_name;?></td>
								<td><?php echo $row->Symbol_of_currency;?></td>
								<td><?php echo $row->Dial_code;?></td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<!--------------Table--------------->
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{  
	if( $('#Currency_nation').val() != "" && $('#Currency_name').val() != "" && $('#currency_symbol').val() != "" && $('#dial_code').val() != "" )
	{
		show_loader();
		return true;
	}
});
</script>