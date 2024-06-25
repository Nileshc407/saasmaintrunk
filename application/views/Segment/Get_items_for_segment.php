	
							
								<legend><span  id="title2">Select Items</span></legend>
							
							
							<div class="row">
							
								
								<div class="col-md-3">
								
									<b>Item Code.</b>
									
								</div>	
								<div class="col-md-5">
								
									<b>Item Name</b>
									
								</div>	
								<div class="col-md-4">
								
									<b>Quantity</b>
									
								</div>	
								<!--
								<div class="col-md-2">
								
									<b>Valid From</b>
									
								</div>	
								<div class="col-md-2">
								
									<b>Valid Till</b>
									
								</div>	
								-->
								<?php	
									$style="style='overflow: auto;'";
									if($Get_Linked_Items_for_segment != NULL){
									$Count_items= count($Get_Linked_Items_for_segment);

									if(count($Get_Linked_Items_for_segment)>7)
									{
										$style="style='height: 390px;overflow: auto;'";
									}}
									
									?>
							</div>	
							<br>	<br>
							<div class="row" <?php echo $style;?>>	
							
							<?php	
							//print_r($Get_Linked_Items_for_segment);
							$ci_object = &get_instance();
							$ci_object->load->model('administration/Administration_model');
							if($Get_Linked_Items_for_segment!=NULL){
								$i=0;
							foreach($Get_Linked_Items_for_segment as $Items_by_category)
							{
								$Merchandize_category_id= $Items_by_category->Merchandize_category_id;
								
								$Merchandize_category_name= $Items_by_category->Merchandize_category_name;
								
								
								
								$Check_code =0;
								
								$Price =0.00;
								
							?>
							
							
							<div class="col-md-3">
							<label>
								<input type="checkbox" name="Item_check[]" id="Item_check_<?php echo $i; ?>"  value="<?php echo $Items_by_category->Company_merchandize_item_code; ?>" onclick="toggle_items(<?php echo $i; ?>);" <?php if($Check_code==1){echo 'checked';} ?> class="check">
								<?php echo $Items_by_category->Company_merchandize_item_code; ?>
								</label>
							</div>	
							<div class="col-md-5">
							
								
									<?php echo $Items_by_category->Merchandize_item_name; ?>
									<input type="hidden" id="Merchandize_item_name_<?php echo $i; ?>" name="Merchandize_item_name[]" value="<?php echo $Items_by_category->Merchandize_item_name; ?>" >
								
							</div>	
							<div class="col-md-4">
							
								<div class="form-group has-feedback">
									
									<input type="text" name="Seg_Quantity[]" id="Seg_Quantity_<?php echo $i; ?>" class="form-control qty" placeholder="Enter Quantity" onkeypress="return isNumberKey2(event);"  value="1" />
								</div>
							</div>		
							<!--
							<div class="col-md-2">
							
								<div class="input-group">
									<input type="text" name="Valid_from" id="datepicker1" class="single-daterange form-control" placeholder="Rule Start Date" required />			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>		
							
							<div class="col-md-2">
							
								<div class="input-group">
									<input type="text" name="Valid_till" id="datepicker2" class="single-daterange form-control" placeholder="Rule End Date" required />			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>		
							-->
							<?php $i++;}}else{ 
								$Merchandize_category_name= '';
								$Merchandize_category_id=0;
								$Company_merchandize_item_code=0;
								
							echo 'Items Not Found !!!';} ?>	
							
							</div>	
							
						<div class="modal-footer">
								<span  id="error" style="color:red;"></span>
								<button type="button" id="select_id" class="btn btn-primary" onclick='select_all();' >Select All</button>
								<button type="submit" id="close_modal" class="btn btn-primary" onclick="Save_items_for_Segment();" >Save</button>
								<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
						</div>
						
<script>
	$( "#close_modal12" ).click(function(e)
	{
		
		$('#Item_modal').hide();
		$("#Item_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$( "#close_modal3" ).click(function(e)
	{
		
		$('#Item_modal').hide();
		$("#Item_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$('#title2').html('<?php echo "<b>".$Merchandize_category_name." Group Items</b>";?>');
	
	function select_all()//  
	{
		$(".check").prop("checked", true);
		$(".qty").removeAttr("disabled"); 
	}


	function Save_items_for_Segment()
	{
		
		var Count_items = '<?php echo $Count_items; ?>';
		var Merchandize_category_id = '<?php echo $Merchandize_category_id; ?>';
		var Segment_Code = '<?php echo $Segment_Code; ?>';
		var Company_id = '<?php echo $Company_id; ?>';
		var Item_code = new Array();
		var Merchandize_item_name = new Array();
		var Seg_Quantity = new Array();
		if(Segment_Code== "")
		{
			var Title = "Application Information";
			var msg = 'Please Enter Item Code first';
			// runjs(Title,msg);
			// alert('Please Enter Discount Code first');
			$('#error').html('Please Enter Segment Code first');
			return false;
		}
		
		var error_count = 0;		
		var error_qty = 1;		
		for(var i=0; i<Count_items; i++ )
		{
			 if(document.getElementById('Item_check_'+i).checked==true)
			{
				var Item_check = $('#Item_check_'+i).val();
				var Merchandize_item_name2 = $('#Merchandize_item_name_'+i).val();
				var Seg_Quantity2 = $('#Seg_Quantity_'+i).val();
				if(Seg_Quantity2 > 0)
				{
					Item_code.push(Item_check);
					Merchandize_item_name.push(Merchandize_item_name2);
					Seg_Quantity.push(Seg_Quantity2);
					
					error_count = 1;	
					
				}
				else
				{
					var error_qty = 0;	
				}
				
				
			} 
			
		}
		
		if(error_qty==0)
		{
			var Title = "Application Information";
			var msg = 'Please Enter Quantity greater than 0 !!!';
			// runjs(Title,msg);
			// alert(msg);
			$('#error').html(msg);
			return false;
		} 
		
		if(error_count==0)
		{
			var Title = "Application Information";
			var msg = 'Please Select atleast One !!!';
			// runjs(Title,msg);
			// alert(msg);
			$('#error').html(msg);
			return false;
		} 
		
					
			$.ajax({
			  type: "POST",
			  data: {Item_code: Item_code,Merchandize_category_id: Merchandize_category_id,Segment_Code: Segment_Code,Company_id:Company_id,Merchandize_item_name:Merchandize_item_name,Seg_Quantity:Seg_Quantity,},
			  url: "<?php echo base_url()?>index.php/SegmentC/Save_items_segment",
			  success: function(data)
				{
				   
				   var Title = "Application Information";
					var msg = 'Main Items Saved Successfully !!!';
					$('#error').html(msg);
					$('#Item_modal').hide();
					$("#Item_modal").removeClass( "in" );
					$('.modal-backdrop').remove();
					// alert(msg);
					$("#selected_items").show();
					$('#Linked_items').html(data.Linked_items);
					
					$("#help-block22").html("");
					$("#Register").prop("type", "submit");
					
					$("#linked_itemcode").val(data.linked_itemcode);
					$("#linked_Category_id").val(data.linked_Category_id);
					$("#linked_Quantity").val(data.linked_Quantity);
				}
			});  
				
		
	}
	/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
});

/******calender *********/
function isNumberKey2(evt)
{
	
  var charCode = (evt.which) ? evt.which : event.keyCode
// alert(charCode);
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
</script>	