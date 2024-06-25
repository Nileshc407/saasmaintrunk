<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Edit Special Offer Images
			  </h6>
			  <div class="element-box">
			
					

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
					
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Administration/Edit_special_offer_images',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  
				

					</div>
				  
				    <div class="col-sm-6">
					
					<div class="form-group">
					<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
					<select class="form-control" name="seller_id" ID="seller_id" data-error="Please Select Business/Merchant Name"    required="required">
						
						<?php
								
								
								foreach($Seller_array as $seller_val)
								{
									if($_REQUEST['Brand_id']==$seller_val->Enrollement_id){
									echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
									}
								}
							?> 
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div>  
				  
							
					
					
						
						
						</div>	
				<!--
					<div class="row">
							
								<div class="table-responsive" id='Uploaded_images'></div>
						
					</div>-->
					
				</div>	
					
					<div class="row">
		 
				
								<?php 
								$Sequence = 1;
									foreach($results3 as $rec)
									{
								?>
								 <div class="col-md-3">
								<div class="form-group">
									<div class="thumbnail">
										<div class="caption"><p class="text-left"><strong>Offer Image-<?php echo $Sequence; ?></strong></p></div>
										<img src="<?php echo $rec->Spl_Image; ?>" id="no_image<?php echo $rec->Spl_offer_id; ?>" class="img-responsive" style="width: 80%;">									
										<div class="caption">
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file<?php echo $rec->Spl_offer_id; ?>" id="file<?php echo $rec->Spl_offer_id; ?>" onchange="readImage(this,'#no_image<?php echo $rec->Spl_offer_id; ?>');" data-error="Please select merchandise item image-1" />
													
													<div class="help-block form-text with-errors form-control-feedback"></div>
													
												</div>
												
												<div class="form-group upload-btn-wrapper">
													<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $rec->Brand_id.'*'.$rec->Spl_offer_id;?>','Offer Image-<?php echo $Sequence; ?>','','Administration/delete_single_special_offer_images/?Spl_offer_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
													<i class="os-icon os-icon-ui-15">Remove</i>
												</a>
													
													<div class="help-block form-text with-errors form-control-feedback"></div>
													
												</div>
												
											</div>
										</div>
									</div>
								
								</div>
								</div>	
								<?php 
								$Sequence = ($Sequence + 1);
									}
								?>
							
						

				
					
				
				</div>	
		
				<!--Reorder images------------------------------------------------>	
				  <div class="row">
							
								<div id="gallery">
        
									<div id="image-container">
									<h5>Reorder images </h5>
									<div class="alert alert-success alert-dismissible fade show" role="alert" id="txtresponse" style="display:none;">
										  <button aria-label="Close" class="close" onclick='javascript:$("#txtresponse").hide();' type="button">
										  <span aria-hidden="true"> &times;</span></button>
										  Save Successfully !!!
									</div>
										<ul id="image-list" >
											<?php
											if($results3 != NULL)
											{
												
												foreach($results3 as $row)
												{

													$imageId = $row->Spl_offer_id;
													$imageName = $row->Spl_Image;
													$imagePath = $row->Spl_Image;

													echo '<li id="image_' . $imageId . '" >
													<img src="' . $imagePath . '" alt="' . $imageName . '" style="width: 100%;"></li>';
												}
											}
											?>
										</ul>

									</div>            
									<div id="submit-container"> 
										<input type='button' class="btn-submit" value='Save' id='submit' />
									</div>
									</div>
						
					</div>
				  <!--------------------------------------------------------->
				  <div class="form-buttons-w"  align="center">
				  <input type="hidden" name="Brand_id" value="<?php echo $_REQUEST['Brand_id']; ?>">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<!--<button class="btn btn-primary" type="button" id="myBtn">Preview</button>-->
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	  
		
		
		
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Special Offer Images
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Action</th>
							<th>Business/Merchant Name</th>
							
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
						$todays = date("Y-m-d");
						
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{
									
							?>
						<tr>
									<td>
										<a href="<?php echo base_url()?>index.php/Administration/Edit_special_offer_images/?Brand_id=<?php echo $row->Brand_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										
										<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Brand_id;?>','All Special offer images for selected Business/Merchant','','Administration/delete_special_offer_images/?Brand_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									
									<td><?php echo $row->First_name." ".$row->Last_name;?></td>
									
									
								</tr>
							<?php
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

<!-- The Modal -->
<div id="myModal" class="modal2">

  <!-- Modal content -->
  <div class="modal-content2">
    <span class="close2">&times;</span>
    <p id="Uploaded_images">Loading...</p>
  </div>

</div>
<style>


/* The Modal (background) */
.modal2 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  //left: 30%;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content2 {
  background-color: white;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
      width: 32%;
    margin-right: 50%;
}

/* The Close Button */
.close2 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close2:hover,
.close2:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>	
<?php $this->load->view('header/footer'); ?>

      
<script>	
var seq_arr = new Array('1','2','3','4');
// alert(seq_arr);
function readImage(input,div_id) 
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(div_id)
					.attr('src', e.target.result)
					.width('80%');
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
	/* function check_sequence(id,valS)
	{
		// alert(seq_arr);
		// alert(valS);
		
		if(seq_arr.includes(valS) == true)
		{
			$('#Error'+id).show();
			// var prev_val = $('#'+id).val();
			$('#'+id).val('0');
			 seq_arr = new Array($('#SequenceNo1').val(),$('#SequenceNo2').val(),$('#SequenceNo3').val(),$('#SequenceNo4').val());
			 // alert(seq_arr);
		}
		else
		{
			$('#Error'+id).hide();
			 $('#'+id).val(valS);
			 seq_arr = new Array($('#SequenceNo1').val(),$('#SequenceNo2').val(),$('#SequenceNo3').val(),$('#SequenceNo4').val());
			 // alert(seq_arr);
			// alert('Not exist');
		}
		
		// seq_arr = new Array();
		// alert(seq_arr);
		// $('#'+id).val(valS);
		// alert(id);
		// alert(valS);
	} */
	
/* $('#seller_id').change(function()
	{
		var Brand_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		
		$.ajax({
			type:"POST",
			data:{Brand_id:Brand_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Administration/Get_brands_special_images_sequence/',
			success:function(opData2){
				// alert(opData2.Image_sequence);
				$('#Uploaded_images').html(opData2.Image_sequence);
				
			}
		});
		
				
			
	});	 */
</script>
 
        
       <!-- <script src="http://localhost/dragdrop/vendor/jquery/jquery-ui/jquery-ui.js" type="text/javascript"></script>-->
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dragdropstyle.css" >
		 <script>
            $(document).ready(function () {
                var dropIndex;
                $("#image-list").sortable({
                    	update: function(event, ui) { 
                    		dropIndex = ui.item.index();
                    }
                });

                $('#submit').click(function (e) {
                    var imageIdsArray = [];
                    $('#image-list li').each(function (index) {
                        // if(index <= dropIndex) {
                            var id = $(this).attr('id');
                            var split_id = id.split("_");
                            imageIdsArray.push(split_id[1]);
                        // }
                    });
// alert(imageIdsArray);
  var Brand_id ='<?php echo $Brand_id; ?>';
                    $.ajax({
                        url: '<?php echo base_url()?>index.php/Administration/Save_brands_special_images_sequence/',
                        type: 'post',
                        data: {imageIds: imageIdsArray},
                        success: function (response) {
                          
							// window.location='<?php echo base_url()?>index.php/Administration/Edit_special_offer_images/?Brand_id='+Brand_id;
							$("#txtresponse").show();
                        }
                    });
                    e.preventDefault();
                });
            });

        </script>
		
		<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close2")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
	
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
	
  }
  var Company_id ='<?php echo $Company_id; ?>';
  var Brand_id ='<?php echo $Brand_id; ?>';

		$.ajax({
			url: '<?php echo base_url()?>index.php/Administration/Preview_brands_special_images_sequence/',
			type: 'post',
			data: {Company_id: Company_id,Brand_id: Brand_id},
			success: function (response) {
			 $('#Uploaded_images').html(response.Image_sequence);
			 
			}
		});
}
</script>