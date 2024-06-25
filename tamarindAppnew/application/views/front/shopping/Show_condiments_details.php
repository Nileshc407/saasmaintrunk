<?php 
$i=1; 
$Condiments_compulsary= array();
$CondimentsCompulsaryQuestion= array();
?>
<form id="form">
	<div class="modal-content">
		<div class="modal-body"  style="margin-top:0%;">
			<button type="button" class="close" aria-label="Close" data-dismiss="modal" id="close_modal">
			  &times;
			</button>
			<div class="modal-header">			
				<p style="color: var(--dark);font-weight: bolder;">Condiments And More For <b><?php echo $Merchandize_item_name; ?></b></p>
			</div>			
			<table id="myTable" align="left" class="text-left"> 
			
		
		<?php
		$Condiments_compulsary = 0;
		
			//****Main ITem QUESTION
			if($MainItemQuestions != NULL)	
			{ 
				//echo "main requires and options are<br>".count($MainItemQuestions);
				// print_r($MainItemQuestions);echo "<br><br>";		
			?>
			
			
				<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					
				<?php 
					foreach($MainItemQuestions as $que=>$Menuitem)
					{
						$set1 = 0;		
				 ?>
					<?php 
					 	if(count($Menuitem) == 1)
						{
							$CondimentsCompulsaryQuestion[]=1;
							foreach($Menuitem as $lp1)
							{

							?>
							
							
							
							
									<div class="col-md-12" style="display:none;"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="radio" checked name="Main_Required_Que_set" onclick="Show_next_required('<?php echo '#'.$q0; ?>');Add_message('<?php echo $lp1->Merchandize_item_name; ?>',<?php echo $lp1->Company_merchandize_item_code; ?>);" value="<?php echo $lp1->Company_merchandize_item_code; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $lp1->Merchandize_item_name; ?>
													</font>
												</span>
											</div>
										</div> 	
										<input type="text" name="message" id="message_<?php echo $lp1->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
									</div>
					<?php		
							}
						}
						else if(count($Menuitem) > 1)
						{ 
							$Condiments_compulsary++;
							$CondimentsCompulsaryQuestion[]=1;
							$q0=$i+1;		
							echo "<h5 id=\"Medium_font\"> &nbsp; &nbsp; Q  $i:".$que."</h5>";	
							
							foreach($Menuitem as $lp1)
							{

							?>	
									<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="radio" id="" name="Main_Required_Que_set"  onclick="Show_next_required('<?php echo '#'.$q0; ?>');Add_message('<?php echo $lp1->Merchandize_item_name; ?>',<?php echo $lp1->Company_merchandize_item_code; ?>);" value="<?php echo $lp1->Company_merchandize_item_code; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $lp1->Merchandize_item_name; 
														if($lp1->Billing_price > 0)
															{
																echo "(".$lp1->Billing_price.")";
															}
															?> 
													</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $lp1->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
					<?php		
							}
							
							$i=$i+1; 
						}
					?>
				</div> <br/>
			<?php 	
					}
				?>
			
			<?php }
			
			
				//****Main ITem condiments REQUIRED QUESTIONS 
			if($main_prepare_req_condiments != NULL)	
			{ 
				//echo "main requires and options are<br>".count($MainItemQuestions);
				// print_r($MainItemQuestions);echo "<br><br>";		
			?>
			
			
				<div class="row" <?php if($i != 1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					
				<?php 
					foreach($main_prepare_req_condiments as $main_req_condiments41)
					{
						
				 ?>
					<?php 
						foreach($main_req_condiments41 as $que=>$Menuitem) 
						{
									
							if(count($Menuitem) == 1)
							{
								
								foreach($Menuitem as $lp1)
								{

								?>
								<div class="col-md-3" style="width: 250px;margin-left: 0px;"> 
									<input type="radio" checked name="Main_Required_Condiments_set" value="<?php echo $lp1->Company_merchandize_item_code.':'.$lp1->Merchandize_item_name; ?>">
								</div>
							<?php		
									}
								}
							else if(count($Menuitem) > 1)
							{ 
								$Condiments_compulsary++;
								$CondimentsCompulsaryQuestion[]=1;
								$q1=$i+1;	
								echo "<h5 id=\"Medium_font\"> &nbsp; &nbsp; Q  $i:".$que."</h5>";							
								foreach($Menuitem as $lp1)
								{
								?>
									
									
									<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="radio" name="Main_Required_Condiments_set"  onclick="Show_next_required('<?php echo '#'.$q1; ?>');Add_message('<?php echo $lp1->Merchandize_item_name; ?>',<?php echo $lp1->Company_merchandize_item_code; ?>);" value="<?php echo $lp1->Company_merchandize_item_code.':'.$lp1->Merchandize_item_name; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $lp1->Merchandize_item_name; 
															if($lp1->Billing_price > 0)
															{
																echo "(".$lp1->Billing_price.")";
															}
															?> 
													</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $lp1->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
						<?php		
								}
								
								$i=$i+1; 
							}
						?>
			</div> 
			<br/>
							<?php 	
						}
					}
				?>
			
			<?php 
			}
			?>
		<?php
		
		//**** REQUIRED QUESTIONS 
		if($prepare_req_condiments != NULL)	
		{ 
			//echo "requires and options are<br>";
			// print_r($prepare_req_condiments);echo "<br><br>";
			foreach($prepare_req_condiments as $dItem)
			{
				//print_r($dItem);echo "<br><br>";
				foreach($dItem as $que=>$ReqItem)
				{
					// echo "$i:".$que;
					$q2=$i+1;
					$Condiments_compulsary++;
					$CondimentsCompulsaryQuestion[]=1;
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5  id="Medium_font"> &nbsp; &nbsp; Q 
				<?php 
				
						echo "$i:".$que;
					?></h5>
					<?php
							foreach($ReqItem as $reqItem11)
							{
								
								?> 	
									<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="radio" name="Required_Condiments_set_<?php echo $i;?>"  onclick="Show_next_required('<?php echo '#'.$q2; ?>');Add_message('<?php echo $reqItem11->Merchandize_item_name; ?>',<?php echo $reqItem11->Company_merchandize_item_code; ?>);" value="<?php echo $reqItem11->Company_merchandize_item_code.':'.$reqItem11->Merchandize_item_name.':'.$reqItem11->Billing_price; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $reqItem11->Merchandize_item_name; 
											
														if($reqItem11->Billing_price > 0)
														{
															echo "(".$reqItem11->Billing_price.")";
														}
														?> 
													</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $reqItem11->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
							<?php
							}
						
					?>
			</div>

			<br/>
		<?php 
				$i++; 
				}
				
			}
		
		}
		
		// SIDE QUESTIONS 
		if($Prepare_side_condiments != NULL)	
		{ 
			// print_r($Prepare_side_condiments);

			foreach($Prepare_side_condiments as $dItem)
			{
				
				
				foreach($dItem as $que=>$sideItem)
				{	
					$q3=$i+1;
					$Condiments_compulsary++;
					$CondimentsCompulsaryQuestion[]=1;
				?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5 id="Medium_font"> &nbsp; &nbsp; Q 
					<?php 
				
						echo "$i:".$que;
						
					?>
					</h5>
					<?php
							foreach($sideItem as $AsideItem)
							{
								?>

									<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="radio" id="" name="Side_Condiments_set_<?php echo $i;?>"  onclick="Show_next('<?php echo '#'.$q3; ?>');Add_message('<?php echo $AsideItem["Item_name"]; ?>',<?php echo $AsideItem["Item_code"]; ?>);" value="<?php echo $AsideItem["Item_code"].':'.$AsideItem["Item_name"].":".$AsideItem["Item_qty"].':'.$AsideItem["Item_rate"]; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $AsideItem["Item_name"];									
														if($AsideItem["Item_rate"] > 0)
														{
															echo "(".$AsideItem["Item_rate"].")";
														} 
														?>
														</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $AsideItem["Item_code"]; ?>" class="form-control" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
											 
											 
										
							<?php
							}
						
					?>
			</div> <br/>
		<?php 
				$i++; 
				}
				
			}
			
		}
		
		// OPTIONAL QUESTIONS
		if($prepare_opt_condiments != NULL)	
		{ 
			//echo "requires and options are<br>";
			//print_r($prepare_opt_condiments);echo "<br><br>";
	
			foreach($prepare_opt_condiments as $dItem)
			{

				foreach($dItem as $que=>$OptItem)
				{	
					$q4=$i+1;
				//	$Condiments_compulsary++;
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5 id="Medium_font"> &nbsp; &nbsp; Q 
				<?php 
				
						echo "$i:".$que;
					?></h5>
						<?php
							foreach($OptItem as $OptItem11)
							{
								?>
								
								
									<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="checkbox" id="" name="Optional_Condiments_set_<?php echo $i;?>"  onclick="Show_next_required('<?php echo '#'.$q4; ?>');Add_message('<?php echo $OptItem11->Merchandize_item_name; ?>',<?php echo $OptItem11->Company_merchandize_item_code; ?>);" value="<?php echo $OptItem11->Company_merchandize_item_code.':'.$OptItem11->Merchandize_item_name.':'.$OptItem11->Billing_price; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $OptItem11->Merchandize_item_name;
														
														if($OptItem11->Billing_price > 0)
														{
															echo "(".$OptItem11->Billing_price.")";
														}
														?>
													</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $OptItem11->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
								
							<?php							
							}						
					?>
			</div> <br/>
		<?php 
				$i++; 
				}
				
			}
		
		}
		
			// ?Main OPTIONAL QUESTIONS
			if($main_prepare_opt_condiments != NULL)	
			{ 
				//echo "main requires and options are<br>";
				//print_r($main_prepare_opt_condiments);echo "<br><br>";
					
				foreach($main_prepare_opt_condiments as $main_opt_condiments41)
				{
			?>
				<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					<h5 id="Medium_font"> &nbsp; &nbsp; Q 
				<?php 
					foreach($main_opt_condiments41 as $que=>$Menuitem)
					{
						//	$Condiments_compulsary++;
						$q5=$i+1;
						
					//	foreach($Menuitem["question"] as $e)
					//	{
							echo "$i:".$que;	
					//	}
							
				 ?></h5>
					<?php 
						foreach($Menuitem as $lp2)
						{
							?>
						
								 
								<div class="col-md-12"> 
										<div class="row">
											<div class="col-md-3" style="width:20%;">
												<input type="checkbox" id="" name="Main_Optional_Condiments_set"  onclick="Show_next_required('<?php echo '#'.$q4; ?>');Add_message('<?php echo $OptItem11->Merchandize_item_name; ?>',<?php echo $lp2->Company_merchandize_item_code; ?>);" value="<?php echo $lp2->Company_merchandize_item_code.":".$lp2->Merchandize_item_name; ?>">
											</div>
											<div class="col-md-9" style="width:80%;">
												<span class="pull-left">										
													<font id="Small_font" style="float: left;">
														<?php echo $lp2->Merchandize_item_name; 
															if($lp2->Billing_price > 0)
															{
																echo "(".$lp2->Billing_price.")";
															}
														?>
													</font>
												</span>
											</div>
											<input type="text" name="message" id="message_<?php echo $lp2->Company_merchandize_item_code; ?>" onblur="prependMe('<?php echo $OptItem11->Merchandize_item_name; ?>',this.value,this.id);" class="form-control" style="display:none;color: #322210 !IMPORTANT;background: #fff !IMPORTANT;margin: 10px !IMPORTANT;"/>
										</div> 			 
									</div>
				<?php		
						}			
						$i=$i+1; 
					?>
				</div> <br/>
			<?php 	
					}
				}
			
			}
		?> 
			
			
			<!--</table> -->
			
		</div>
	</div>

	</form>
		
			<div class="row" style="display:none;" id="error_display1">	
				<div id="popup1">
					<div class="alert alert-success text-center" role="alert" id="popup_info1" style="color:red;" ></div>
				</div>
			</div>
			<div class="modal-footer">			
				<input type="hidden" name="CondimentsCompulsaryQuestion" id="CondimentsCompulsaryQuestion" value="<?php echo array_sum($CondimentsCompulsaryQuestion); ?>" >
				
				<?php
					
					function garbagereplace($string) {

						$garbagearray = array('@','#','$','%','^','&','*','(',')','');
						$garbagecount = count($garbagearray);
						for ($i=0; $i<$garbagecount; $i++) {
							$string = str_replace($garbagearray[$i], ' ', $string);
						}

						return $string;
					} 
					
					$item_name= preg_replace('#[^\w()/.%\-&]#',' ',$Merchandize_item_name);
					$Merchandize_item_name = garbagereplace($item_name);
					
					// echo "--Merchandize_item_name---".$Merchandize_item_name."---<br>";
					/* $item_name= preg_replace('#[^\w()/.%\-&]#',' ',$Merchandize_item_name);
					$Merchandize_item_name=str_replace('&', '', $item_name); */
				?>
				<div class="alert alert-success text-center" role="alert" id="popup_info12" style="background-color:#ffffff; color:#322010; border-color:#322010; width:100% !IMPORTANT;display:none"></div>
				
				<button type="button" class="cust-btn btn-block" onclick="add_to_cart_condiments('<?php echo $Merchandise_item_id; ?>', '<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $Merchandize_item_name); ?>', '<?php echo $price; ?>', '<?php echo $Delivery_method; ?>','<?php echo $Branch; ?>',<?php echo $Merchandise_item_id; ?>, '<?php echo $Item_size; ?>',<?php echo $Item_Weight; ?>,<?php echo $Weight_unit_id; ?>,<?php echo $Partner_id; ?>, '<?php echo $Partner_state; ?>', '<?php echo $Partner_Country_id; ?>',<?php echo $Seller_id; ?>,<?php echo $Merchant_flag; ?>, '<?php echo $Cost_price; ?>', '<?php echo $VAT; ?>', '<?php echo $Product_category_id; ?>','<?php echo $Item_code; ?>','<?php echo $Merchandize_item_name; ?>',<?php echo array_sum($CondimentsCompulsaryQuestion); ?>);">Add to Cart</button>		 
			</div>
		</div>
		
		
	
	</div>
	
	

<?php /*
<script>
	var Title = "Application Information";
	var msg = "The item is currently unavailable";
	runjs(Title,msg);
</script> */ ?>
<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function()
	{
		// $('#item_info_modal').hide();
		$('#item_info_modal').modal('hide');
		
		// $("#item_info_modal").removeClass( "in" );
		// $('.modal-backdrop').remove();
	});
	
});

function add_to_cart_condiments(serial, name, price, Redemption_method, Branch, Company_merchandise_item_id, Item_size, Item_Weight, Weight_unit_id, Partner_id, Partner_state, Partner_Country_id, Seller_id, Merchant_flag, Cost_price, VAT, Product_category_id,Item_code,Item_name,Condiments_compulsary)
{	

	// alert("Condiments_compulsary------"+Condiments_compulsary);	
	
	
	// alert("Condiments_compulsary---checked---"+$('input:radio:checked').length); 
	if($('input:radio:checked').length == Condiments_compulsary) {		
		//alert("Condiments_compulsary---checked---"); 	 
	} else {	
		// alert("Condiments_compulsary- not--checked---");		
		// ShowPopup('Please select required option');
		
		
		
		$('#popup_info12').html('Please select required option');
		$('#popup_info12').css('display','inline');
		setTimeout(function(){ $('#popup_info12').css('display','none'); }, 3000);
		
		
		return false;
	}
	
	
	
	// alert("Condiments_set1------"+Condiments_set1+"----Condiments_set2----"+Condiments_set2+"---Condiments_set3----"+Condiments_set3+"----Condiments_set4----"+Condiments_set4+"----Condiments_set5----"+Condiments_set5);
	
	// 
	
	var Required_Condiments_set = [];
	$("input[name^='Required_Condiments']:checked").each(function()
	{
        Required_Condiments_set.push($(this).attr("value"));
    });
	
	var MainRequired_Condiments_set = $("input[name='Main_Required_Condiments_set']:checked").val();	
	var Main_Required_Que_set = $("input[name='Main_Required_Que_set']:checked").val();	
		//console.log(Required_Condiments_set);
		
	var Condiments_set6_optional = [];
	$("input:checkbox[name^=Optional_Condiments]:checked").each(function()
	{
        Condiments_set6_optional.push($(this).attr("value"));
    });
	
	var MainCondiments_set_optional = [];
	$("input:checkbox[name=Main_Optional_Condiments_set]:checked").each(function()
	{
        MainCondiments_set_optional.push($(this).attr("value"));
    });
	
	var Condiments_Sides_set = [];
	$("input[name^='Side_Condiments']:checked").each(function()
	{
        Condiments_Sides_set.push($(this).attr("value"));
		
		alert($(this).attr("value")); 
		
    });
	
	
	//var message_set = [];

 	/* $("input[type='text']").each(function () { 
  
		if($(this).val()){
			message_set.push($(this).val());
		}
	})  */
	
	
	$.ajax(
		{
			type: "POST",
			data: {id: serial, name: name, price: price, Delivery_method: 29, Branch: Branch, Item_size: Item_size, Item_Weight: Item_Weight, Weight_unit_id: Weight_unit_id, Partner_id: Partner_id, Partner_state: Partner_state, Partner_Country_id: Partner_Country_id, Seller_id: Seller_id, Merchant_flag: Merchant_flag, Cost_price: Cost_price, VAT: VAT, Product_category_id: Product_category_id,Item_code:Item_code,Required_Condiments_set:Required_Condiments_set,Condiments_set6_optional:Condiments_set6_optional,Condiments_Sides_set:Condiments_Sides_set,MainCondiments_set_optional:MainCondiments_set_optional,MainRequired_Condiments_set:MainRequired_Condiments_set,Selected_Main_Item:Main_Required_Que_set,message_set:message_set},
			url: "<?php echo base_url() ?>index.php/Shopping/add_to_cart_with_condiments",
			success: function (data)
			{
				if (data.cart_success_flag == 1)
				{
					$('#item_info_modal').modal('hide');
					$("#footer_cart").load(location.href + " #footer_cart");
					ShowPopup(Item_name + ' is added to cart successfuly.');
					
					
					var input = $('#cart_count').html();
					$('#cart_count').html(parseInt(input) + 1); 
					
				} 
			    else
				{
					ShowPopup('Error adding item ' + name + ' to Cart. Please try again.');
				}
			}
		});
}
/*function ShowPopup(x)
{
	$('#popup_info1').html(x);
	$('#popup1').show();
	$('#error_display1').show();
	setTimeout('HidePopup()', 2000);
}
function HidePopup()
{
	$('#popup1').hide();
	$('#error_display1').hide();
}*/
function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup_info').css('position','fixed');
	$('#popup_info').css('z-index','1');
	$('#popup_info').css('right','0');
	$('#popup_info').css('top','auto');
	$('#popup_info').css('bottom','4%');
	$('#popup').show();
	setTimeout('HidePopup()', 5000);
}

function HidePopup()
{
  $('#popup').hide();
}

	var message_set = [];
	
	
function prependMe(Merchandize_item_name,textvalue,id)
{
	// alert(Merchandize_item_name+'--'+textvalue+'--'+id);
	
	message_set.push(Merchandize_item_name+':'+textvalue+':'+id);
	//$(id).val("test msg");
}
	
	//console.log(message_set);	

 </script>
 
 <style>
#popup 
{
	display:none;
}
div.square 
{
  border: solid 13px <?php echo $Product_details->Item_Colour; ?>;
  width: 0.5px;
  height: 0.5px;
  
  outline-color:gray;
  outline:1px solid;
}
.circle 
{
	color:white;
	height: 30px;
	margin: 9px;
	width: 30px;
     -webkit-border-radius: 25px;
     -moz-border-radius: 25px;
     border-radius: 25px;
     background: #45aed6;
	 float: left;
}
#b1
{
	margin-top:10px;
}
.modal-footer 
{
    text-align: left ! IMPORTANT;
}
h5{
	font-size: 1rem;
}
 </style>

	