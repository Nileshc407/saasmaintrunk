<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header"><?php if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){echo 'PERFORM ADJUSTMENT TRANSACTION';}else{echo "PERFORM ADJUSTMENT / DEBIT TRANSACTION";} ?></h6>
                    <div class="element-box">
                       
                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Transactionc/redeem_done', $attributes);
                        ?>
                        <h5 class="form-header">

                        </h5>					  
                        <div class="form-group">
                            <label for=""> Membership ID / Phone No.</label>
                            <input class="form-control" data-error="Enter Membership ID or phone no" placeholder="Enter Membership ID or phone no" required="required" type="text" id="cardId" name="cardId" value="<?php echo $get_card; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Bill No.</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Bill No" type="text" id="manual_bill_no" name="manual_bill_no" class="form-control" placeholder="Bill No">
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNO"></div>
                        </div>
                         <?php if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){ ?>
                           <input type="hidden"  name="Redeem_type" id="Redeem_type"  value="1" >
						   
						   <div class="form-group" id="Redeem_feedback" >
                                <label for="exampleInputEmail1"> <span class="required_info">*</span>Adjustment <?php echo $Company_details->Currency_name; ?></label>
                                <input type="text" name="Redeem_points" id="Redeem_points" value=""  data-error="Enter Adjustment <?php echo $Company_details->Currency_name; ?>" required="required" placeholder="Enter Adjustment <?php echo $Company_details->Currency_name; ?> "   class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" />		<!-- onblur="Check_redeem_points(this.value);"-->						
                                <div class="help-block form-text with-errors form-control-feedback" id="RedeemPoints"></div>						

                            </div>
							
                            <?php } else {  ?>
							<input type="hidden"  name="Redeem_type" id="Redeem_type"  value="1" >
						   
						   <div class="form-group" id="Redeem_feedback" >
                                <label for="exampleInputEmail1"> <span class="required_info">*</span>Adjustment / Debit <?php echo $Company_details->Currency_name; ?></label>
                                <input type="text" name="Redeem_points" id="Redeem_points" value="" data-error="Enter Adjustment / Debit <?php echo $Company_details->Currency_name; ?>" required="required" placeholder="Enter Adjustment / Debit <?php echo $Company_details->Currency_name; ?>" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" />		<!-- onblur="Check_redeem_points(this.value);"-->						
                                <div class="help-block form-text with-errors form-control-feedback" id="RedeemPoints"></div>						

                            </div>
							<?php } /*else { ?>
							 <div class="form-group">
                                <label class="col-sm-6 col-form-label">Transaction Type</label>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" checked="" class="form-check-input"  name="Redeem_type" id="Redeem_type" onclick="redeem_trans_show(this.value);"  value="1" >Normal
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"  name="Redeem_type" id="Redeem_type" onclick="redeem_trans_show('this.value');" value="0" <?php if(isset($_REQUEST["Page_cardId"])){echo 'checked=checked';}?>>Merchandize Gift
                                        </label>
                                    </div>

                                </div>
                            </div>
							
							<div class="form-group" id="Redeem_feedback" >
                                <label for="exampleInputEmail1"> Redeem <?php echo $Company_details->Currency_name; ?></label>
                                <input type="text" name="Redeem_points" id="Redeem_points" value=""  data-error="Enter Redeem <?php echo $Company_details->Currency_name; ?>" required="required" placeholder="Enter Redeem <?php echo $Company_details->Currency_name; ?> "   class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" />		<!-- onblur="Check_redeem_points(this.value);"-->						
                                <div class="help-block form-text with-errors form-control-feedback" id="RedeemPoints"></div>						

                            </div>
							
							
                            <?php } */ ?>
                        
                            <div class="form-group"  id="bal_div2" style="display:none;">
                                <label for="exampleInputEmail1">Current Balance</label>
                                <input type="text" name="cust_Current_balance" id="cust_Current_balance" value="<?php echo $Current_balance; ?>" class="form-control" placeholder="Membership ID / Phone No" readonly/>									
                            </div>
                        
                            
                            <div class="form-group"  id="Remarks_div">
                                <label for="exampleInputEmail1">Remarks</label>
                                <input type="text" name="Remarks" id="promo_reedem"   placeholder="Remarks" class="form-control"/>	
                            </div>

                        
                        
                          <?php if ($Pin_no_applicable == 1) { ?>
                            <div class="form-group" id="pin_feedback">
                                <label for=""> Customer Pin</label>
                                <input type="text" name="cust_pin" name="cust_pin" class="form-control"  placeholder="Customer Pin" data-error="Enter customer pin" required="required"/>
                                <div class="help-block form-text with-errors form-control-feedback" id="CustomerPin"></div>
                            </div>
                          <?php } ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="element-wrapper">
                    <h6 class="element-header">Member Details</h6>
                    <div class="element-box">
                        <div class="profile-tile">
                            <a class="profile-tile-box" href="javascript:void(0);"  style="margin-top:-137px">
                                <div class="pt-avatar-w">									  
                                      <?php if ($Photograph == "") { ?>
                                        <img src="<?php echo base_url(); ?>images/no_image.jpeg" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
                                      <?php } else { ?>
                                        <img src="<?php echo base_url() . $Photograph; ?>" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
                                      <?php } ?>										
                                </div>
                                <div class="pt-user-name">
                                    <?php echo $Full_name; ?>
                                </div>
                            </a>
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        Member Tier:<strong><?php echo $Tier_name; ?></strong>
                                    </li>
                                    <li>
                                        Membership Id:<strong><?php echo $MembershipID; ?></strong>
                                    </li>
                                    <br>
                                    <li>
                                        <?php echo $Company_details->Currency_name; ?> Balance:<strong><?php echo $Current_balance; ?></strong>
                                    </li>
                                    <li>
                                        <?php echo $Company_details->Currency_name; ?> Earned:<strong><?php echo $Gained_points; ?></strong>
                                    </li>
                                    <hr>
                                    <strong class="p-3">No. of Times :</strong>
                                    <hr>
                                    <li>
                                        Bonus <?php echo $Company_details->Currency_name; ?> Issued:<strong><?php echo $Topup_count; ?></strong>
                                    </li>
                                    <li>
                                        Loyalty Transactions: <strong><?php echo $Purchase_count; ?></strong>
                                    </li>
                                    <li> 
                                        <br>
                                        <div class="pt-btn">
                                            <a class="btn btn-success btn-sm" href="javascript:void(0);" id="details" >Details</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="redeem_item_div" style="display:none">
			<div class="col-sm-12">
				<div class="element-wrapper">                
					<div class="element-box">
															
						  <?php
						  if($Redemption_Items != NULL){ ?>
						  <div class="col-md-12 clearfix" id="basket">

							<div class="box">
								<div class="table-responsive">
									<span class="required_info">Please Tick the Checkbox to get Merchandize Gift !!!</span>
										<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
											<thead>
												<tr>
													<th >Item</th>
													<th>Quantity</th>
													<th>Redeem <?php echo $Company_details->Currency_name; ?></th>
													<th>Total <?php echo $Company_details->Currency_name; ?></th>												
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th >Item</th>
													<th>Quantity</th>
													<th>Redeem <?php echo $Company_details->Currency_name; ?></th>
													<th>Total <?php echo $Company_details->Currency_name; ?></th>												
												</tr>
											</tfoot>
											<tbody>
												<?php
												foreach ($Redemption_Items as $item) 
												{
												?>
													
													<tr>
														<td>
															<label>
															
																<input type="checkbox" class="form-check-input" name="<?php echo $item['Company_merchandise_item_id']; ?>" id="<?php echo $item['Company_merchandise_item_id']; ?>"  onclick="Update_Total_Points(<?php echo $item['Company_merchandise_item_id']; ?>,<?php echo $item["Billing_price_in_points"]; ?>,Quantity_<?php echo $item['Company_merchandise_item_id']; ?>.value);Add_product_array(<?php echo $item['Company_merchandise_item_id']; ?>,1);" value="<?php echo $item['Company_merchandise_item_id']; ?>">
																<a>
																	<img src="<?php echo $item["Thumbnail_image1"]; ?>"  style="width:50px;height:50px;" >
																</a>
																<a><?php echo $item["Merchandize_item_name"]; ?></a>
															</label>
														</td>
														<td>
														
															<input   type='tel' pattern='[0-9]*'  name="Quantity_<?php echo $item['Company_merchandise_item_id']; ?>"   id="Quantity_<?php echo $item['Company_merchandise_item_id']; ?>" value="0" class="form-control" style="text-align: center;width:60px;" maxlength="2" size="10"    onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Update_Quantity(<?php echo $item['Company_merchandise_item_id']; ?>,<?php echo $item["Billing_price_in_points"]; ?>,Quantity_<?php echo $item['Company_merchandise_item_id']; ?>.value);Add_product_array(<?php echo $item['Company_merchandise_item_id']; ?>,this.value);">
														</td>

														<td><?php echo $item["Billing_price_in_points"]; ?></td>

														<td>&nbsp;
															<span id="Total_points_div_<?php echo $item['Company_merchandise_item_id']; ?>"></span>
														</td>
													</tr>
												<?php
												}
												?>

																										   
											</tbody>
												<tr>
													<th colspan="3">Grand Total</th>
													<th colspan="2">
														<input   type='text' pattern='[0-9]*'    name="Grand_total"    id="Grand_total" value="0" class="form-control" style="text-align: center;width:90px;" size="10"  readonly>
														<span class="required_info" id="insufficent_block" style="display:none;">Insufficient Current Balance !!!</span>
													</th>
												</tr>
										</table>										
											
								</div>
							</div>
						</div>
						  <?php } else { ?>								  
								  <span class="required_info text-center">Sorry. No Merchandize Gift Found..!!</span>		 

						  <?php } ?>
						<input type="hidden" name="RedeemItemArray[]" id="RedeemItemArray" class="form-control"/>
					</div>
				</div>
			</div>	
			
					
			
			
		</div>	
		<div class="element-wrapper">                
			<div class="element-box">						
				<div class="form-group"  id="Remarks_div_merchant" style="display:none">
					<label for="exampleInputEmail1">Remarks</label>
					<input type="text" name="Remarks1" class="form-control" placeholder="Remarks"/>
					
				</div>					
				<div class="form-buttons text-center" id="submit_id">								  
					<input type="hidden" name="Balance" id="Balance" class="form-control"  />
					<input type="hidden" name="grandTotalPointsValue" id="grandTotalPointsValue" class="form-control" placeholder="Total Points"/>
					<button class="btn btn-primary" type="submit"  id="submit"> Submit</button>							
				</div>
				<div class="help-block form-text with-errors form-control-feedback" id="OnSubmit_error"> </div>
			</div>
		</div>
		
		<?php echo form_close(); ?>		
    </div>	

</div>
<!-- ----Grand Total------------>
	<div class="floated-colors-btn second-floated-btn" id="grandTotalDiv" style="display:none;cursor: not-allowed;">		
		<span>Redeem <?php echo $Company_details->Currency_name; ?>:</span><span id="grandTotalPoints">0</span>		
	</div>
<!-- ----Grand Total------------>
<div id="detail_myModal" aria-labelledby="myLargeModalLabel" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 100%;margin-top:170px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close_modal" class="close"  data-dismiss="modal">&times;</button>					
            </div>
            <div class="modal-body">
                <div  id="show_transaction_details"></div>
            </div>					
        </div>
    </div>
</div>	
<?php $this->load->view('header/footer'); ?>

<style>	


    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 500px;
        overflow-y: auto;
    }
    .modal-content{
        width:119%;
    }
</style>
<script>  


var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
var lv_Current_balance = <?php echo $Current_balance; ?>;

var Redeemtion_limit = <?php echo $Redeemtion_limit; ?>;
var Tier_name = '<?php echo $Tier_name; ?>';

$('#submit').click(function ()
{
    var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
	var Redeem_type=$("input[name=Redeem_type]:checked").val();

	if(lv_Current_balance >= Redeemtion_limit)
	{  
		if(Redeem_type==1)
		{
			
			if(Pin_no_applicable == 1)
			{
			
				if( $('#Redeem_points').val() != "" && $('#cust_pin').val() != "")
				{
					show_loader();
				}
			}
			else
			{
				if( $('#Redeem_points').val() != ""  )
				{
					show_loader();
				}
			}
		}
		else
		{
			
			
			
			var lv_Grand_total=document.getElementById('Grand_total').value;
			
			var count_checked = ($('input[type=checkbox]:checked').length);			
			if(count_checked == 0) 
			{
				/* var Title = "Application Information";
				var msg = 'Please Select atleast one Merchandize Gift !!!';
				runjs(Title,msg);
				return false; */
				
				$('#OnSubmit_error').html('Please select atleast one merchandize gift');
				$('#OnSubmit_error').css('text-align','center');
				return false;
			}else{
				$('#OnSubmit_error').html('');
				// $('#OnSubmit_error').css('text-align','center');
				// return true;
			}
			
			if(Pin_no_applicable == 1)
			{
				if($('#cust_pin').val() != "")
				{					
					show_loader();									
				}
			}
			else
			{
				show_loader();
			}
		}
	}
	else
	{
		/* var Title = "Application Information";
		var msg = 'Sorry ! You can not redeem as your Current Balance is less than Minimum required for your Tier '+Tier_name+' ! You need atleast '+Redeemtion_limit+'  Current balance to Redeem !  !!!';
		runjs(Title,msg);
		return false;  */
		
	}
    
}) 
  

if(Pin_no_applicable==1)
 {
	 $("#cust_pin").attr("required","required");	
 }
 else
 {
	 $("#cust_pin").removeAttr("required");
 }
      
  $('#details').click(function ()
  {      
      var Seller_id = '<?php echo $enroll; ?>';
      var Enrollment_id = '<?php echo $Cust_enrollment_id; ?>';
      var Membership_id = '<?php echo $get_card; ?>';

      $.ajax({
          type: "POST",
          data: {Seller_id: Seller_id, Enrollment_id: Enrollment_id, Membership_id: Membership_id},
          url: "<?php echo base_url() ?>index.php/Transactionc/show_transaction_details",
          success: function (data)
          {
              $("#show_transaction_details").html(data.transactionDetailHtml);
              $('#detail_myModal').show();
              $("#detail_myModal").addClass("in");
              $("body").append('<div class="modal-backdrop fade in"></div>');
          }
      });
  });  

   $('#cust_pin').change(function ()
  {
      var Customer_pin = '<?php echo $Customer_pin; ?>';
      var Entered_pin = $('#cust_pin').val();

      if ((Entered_pin != Customer_pin) || (Entered_pin == ""))
      {
          $('#cust_pin').val("");
          $('#CustomerPin').html("Please Enter Valid Pin Number");
          $("#cust_pin").addClass("form-control has-error");

      } 
      else
      {
          $('#CustomerPin').html("");
          $("#cust_pin").removeClass("has-error");
      }
  });
  
  
  function redeem_trans_show(trans_type)
  {
    if(trans_type==1)
    {
        /* document.getElementById("submit_id").style.display = 'inline';    */
	   
	         
		 $('#submit_id').css('display','block');	
        $('#bal_div').hide();
        $('#redeem_item_div').hide();
        $('#grandTotalDiv').hide();
         $('#Redeem_feedback').show();
         $('#submit_button').show();
         $('#info_div').show();
         $('#Remarks_div').show();
         $('#Remarks_div_merchant').hide();		 
         $("#Redeem_points").attr("required","required");

        
    }
    else
    {
         /* document.getElementById("pin_feedback").style.display="none";
			document.getElementById("submit_id").style.display = 'none';		 */
		 $('#pin_feedback').css('display','none');	         
		 $('#submit_id').css('display','none');	
        $("#Redeem_points").removeAttr("required");        
        $('#submit_button').hide();	
        $('#bal_div').show();
        $('#redeem_item_div').show();
        $('#grandTotalDiv').show();
        $('#Redeem_feedback').hide();
        $('#info_div').hide();
        $('#Remarks_div').hide();
        $('#Remarks_div_merchant').show();


        var Calc_Grand_total=document.getElementById('Grand_total').value;
        if(parseInt(Calc_Grand_total) > lv_Current_balance)
        {
            /* document.getElementById('insufficent_block').style.display="";			 */
           $('#insufficent_block').css('display','none');
            /* document.getElementById("submit_id").style.display = 'none'; */
			$('#submit_id').css('display','none');
            // var Title = "Data Validation";
            // var msg='Insufficient Current Balance !!!';
            // runjs(Title,msg);
			
			$('#OnSubmit_error').html('Insufficient Current Balance');
			$('#OnSubmit_error').css('text-align','center');
				
            return false;
        }
        else
        {
            /* document.getElementById('insufficent_block').style.display="none";
             document.getElementById("submit_id").style.display = 'inline'; */
			$('#submit_id').css('display','block');
			$('#insufficent_block').css('display','none');
			$('#OnSubmit_error').html('');
			
        }		 
                      
    }
    if(trans_type==0)
    {

      $('html,body').animate({
      scrollTop: $("#basket").offset().top},'slow');
    }
  }
  
  
  function Check_redeem_points(Points)
{
	
	
	var Company_id = '<?php echo $Company_id; ?>';
	var Current_balance = '<?php echo $Current_balance; ?>';
	var Seller_redemption_limit = '<?php echo $Seller_redemption_limit; ?>';
	
	// console.log("---Points---"+Points+"--Company_id----"+Company_id+"--Current_balance-"+Current_balance+"---Seller_redemption_limit---"+Seller_redemption_limit)
	if( Points == "" || Points == 0)
	{
		$("#Redeem_points").val("");
		$("#RedeemPoints").html("Please Enter Redeem <?php echo $Company_details->Currency_name; ?>");
	}
	else
	{
		if(Points >  parseInt(Current_balance))
		{
			$("#Redeem_points").val("");
			$("#RedeemPoints").html("Insufficient Current Balance!");
		}
		else
		{
			$("#OnSubmit_error").html("");
			$("#RedeemPoints").html("");
			
		}
		if(Points >  parseInt(Seller_redemption_limit))
		{
			$("#Redeem_points").val("");
			$("#OnSubmit_error").html("You Canot Redeem <?php echo $Company_details->Currency_name; ?> More Than Redeemption Limit, Merchant Redeemption Limit is : "+Seller_redemption_limit+" <?php echo $Company_details->Currency_name; ?> ");
			
		}else{
			
			$("#OnSubmit_error").html("");
		}	
	}
}

var cart = [];
function Add_product_array(Itemid,qty)
{
	var count_checked = ($('input[value='+Itemid+']:checked').length);	
	// console.log('----count_checked----='+count_checked);
	indexi = cart.map(function(e) { return e.Item_id; }).indexOf(Itemid);	
	if(count_checked==1) {
		
		 // var found = jQuery.inArray(Item_id, cart);
		//const index = cart.findIndex(x => x.Item_id === Itemid);
		console.log('----index----='+indexi);
		var item = { Item_id: Itemid,QTY: qty }; 
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1,item);
			$('#RedeemItemArray').val(JSON.stringify(cart));
			
		} else {
			// Element was not found, add it.
			var item = { Item_id: Itemid,QTY: qty }; 
			cart.push(item);
			// add_product_quantity_array(Itemid);
			$('#RedeemItemArray').val(JSON.stringify(cart));
		}
	}
	else{
		
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1);
			$('#RedeemItemArray').val(JSON.stringify(cart));
			
		} 
		
	}
}


function Update_Total_Points(Item_id,Redeem_pts,Qty)
{
	
	
	var Seller_redemption_limit = '<?php echo $Seller_redemption_limit; ?>';
	var Product=document.getElementById(Item_id).checked;
	var Total_points=0;	
	if(Product==true)
	{
		var Quantity=document.getElementById('Quantity_'+Item_id).value;
		if(Quantity==0)
		{
			Qty=1;
			document.getElementById('Quantity_'+Item_id).value='1';
		}
		document.getElementById('Total_points_div_'+Item_id).innerHTML=parseInt(Qty*Redeem_pts);
		Total_points=parseInt(Qty*Redeem_pts);
		// alert(Total_points);
		var lv_Grand_total=document.getElementById('Grand_total').value;

		var Calc_Grand_total=parseInt(lv_Grand_total)+parseInt(Total_points);
		// alert(Calc_Grand_total)
		document.getElementById('Grand_total').value=parseInt(Calc_Grand_total);
		$('#grandTotalPoints').html(parseInt(Calc_Grand_total));
		$('#grandTotalPointsValue').val(parseInt(Calc_Grand_total));
		
		
		
	}
	else
	{
		
		document.getElementById('Total_points_div_'+Item_id).innerHTML=parseInt(Qty*Redeem_pts);
		Total_points=parseInt(Qty*Redeem_pts);
		var lv_Grand_total=document.getElementById('Grand_total').value;
		var Calc_Grand_total=parseInt(lv_Grand_total)-parseInt(Total_points);
		document.getElementById('Grand_total').value=parseInt(Calc_Grand_total);
		
		$('#grandTotalPoints').html(parseInt(Calc_Grand_total));
		$('#grandTotalPointsValue').val(parseInt(Calc_Grand_total));
		
		document.getElementById('Total_points_div_'+Item_id).innerHTML='';
		document.getElementById('Quantity_'+Item_id).value='0';
		
	}
	if(parseInt(Calc_Grand_total) > lv_Current_balance)
	{
		/* document.getElementById('insufficent_block').style.display="";
		document.getElementById("submit_id").style.display = 'none'; */
		$('#submit_id').css('display','none');
		$('#insufficent_block').css('display','inline');
		var Title = "Data Validation";
		var msg='Insufficient Current Balance !!!';
		runjs(Title,msg);
		return false;
	}
	else
	{
		/* document.getElementById('insufficent_block').style.display="none";
		 document.getElementById("submit_id").style.display = 'inline'; */
		$('#submit_id').css('display','block');
		$('#insufficent_block').css('display','none');
		
	}
	if(parseInt(Calc_Grand_total) > Seller_redemption_limit)
	{	
		/* document.getElementById("submit_id").style.display = 'none'; */
		$('#submit_id').css('display','none');
		
		/* var Title = "Data Validation";
		var msg="You Canot Redeem <?php echo $Company_details->Currency_name; ?>  More Than Redeemption Limit, Merchant Redeemption Limit is : "+Seller_redemption_limit+" <?php echo $Company_details->Currency_name; ?>";
		runjs(Title,msg); */
		
		var Cur_name="<?php echo $Company_details->Currency_name; ?>";
		$("#OnSubmit_error").html("You Canot Redeem "+ Cur_name +" More Than Redeemption Limit, Merchant Redeemption Limit is : "+Seller_redemption_limit+" <?php echo $Company_details->Currency_name; ?>");
		
		return false;
	} else {
		
		$("#OnSubmit_error").html("");
	}
	
	/* alert(Grand_total);
	alert(Product);
	alert('Item_id '+Item_id);
	alert('Redeem_pts '+Redeem_pts);
	alert('Qty '+Qty); */
	
	
	
}

function Update_Quantity(Item_id,Redeem_pts,Qty)
{
	// console.log('--Item_id--'+Item_id+'----Redeem_pts----'+Redeem_pts+'--Qty---'+Qty)
	var Seller_redemption_limit = '<?php echo $Seller_redemption_limit; ?>';
	var Product=document.getElementById(Item_id).checked;
	var Total_points=0;
	if(Product==true)
	{
		var lv_Grand_total=document.getElementById('Grand_total').value;
		// console.log('--lv_Grand_total---'+lv_Grand_total)
		var prev_total_points=document.getElementById('Total_points_div_'+Item_id).innerHTML
		// console.log('--prev_total_points---'+prev_total_points)
		var Calc_Grand_total2=parseInt(lv_Grand_total)-parseInt(prev_total_points);
		// console.log('--Calc_Grand_total2---'+Calc_Grand_total2)
		document.getElementById('Total_points_div_'+Item_id).innerHTML=parseInt(Qty*Redeem_pts);
		Total_points=parseInt(Qty*Redeem_pts);
		
		var Calc_Grand_total=parseInt(Calc_Grand_total2)+parseInt(Total_points);
		// console.log('--Calc_Grand_total---'+Calc_Grand_total)
		document.getElementById('Grand_total').value=parseInt(Calc_Grand_total);
		
		$('#grandTotalPoints').html(parseInt(Calc_Grand_total));
		$('#grandTotalPointsValue').val(parseInt(Calc_Grand_total));
		
		if(parseInt(Calc_Grand_total) > lv_Current_balance)
		{
			/* document.getElementById('insufficent_block').style.display="";			
			document.getElementById("submit_id").style.display = 'none'; */
			
			$('#insufficent_block').css('display','inline');
			$('#submit_id').css('display','none');
			/* var Title = "Data Validation";
			var msg='Insufficient Current Balance !!!';
			runjs(Title,msg); */
			
			$("#OnSubmit_error").html("'Insufficient Current Balance");
			
			
			return false;
		}
		else if(parseInt(Calc_Grand_total) > Seller_redemption_limit)
		{	
			$('#submit_id').css('display','none');
			var Cur_name="<?php echo $Company_details->Currency_name; ?>";
			$("#OnSubmit_error").html("You Canot Redeem "+ Cur_name +" More Than Redeemption Limit, Merchant Redeemption Limit is : "+Seller_redemption_limit+" <?php echo $Company_details->Currency_name; ?>");
			
			return false;
		}
		else
		{
			/* document.getElementById('insufficent_block').style.display="none";
			document.getElementById("submit_id").style.display = 'inline'; */
			$("#OnSubmit_error").html("");
			$('#insufficent_block').css('display','none');
			$('#submit_id').css('display','block');
		}
	}
	
}
	function enable_quqntity(chkbox)
	{	
		$('#'+chkbox+'').show();
	}
	
	
	function Check_current_redeem(quentity,item_points,item_id)
	{
		
		var Company_id = '<?php echo $Company_id; ?>';
		var Current_balance = '<?php echo $Current_balance; ?>';
		var cur_points12=parseInt(quentity*item_points);
		var total_redeem= [];
		var sum = 0;
		if( cur_points12 == "" || cur_points12 == 0)
		{
			$('#'+item_id+'').val("");
			var Title = "Application Information";
			var msg = 'Please Enter Quantity..!!';
			runjs(Title,msg);
		}
		else
		{
			if(cur_points12 >  parseInt(Current_balance))
			{
				$("#item_id").val("");
				var Title = "Application Information";
				var msg = 'Insufficient Current Balance!!';
				runjs(Title,msg);
			}
			else
			{
				 total_redeem.push(cur_points12);
				 
				sum = sum + total_redeem;
				document.getElementById("Redeem_points").value = sum;
				// alert(sum);
			}
			
		} 
	}
  $('#manual_bill_no').blur(function ()
  {
      var Company_id = '<?php echo $Company_id; ?>';
      var Bill_no = $('#manual_bill_no').val();

      if ($("#manual_bill_no").val() == "" || (Bill_no.length < 3))
      {
          $("#manual_bill_no").val("");
          $("#BillNO").html("Please enter valid bill number");
      } 
	  else
      {
          $.ajax({
              type: "POST",
              data: {Bill_no: Bill_no, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/check_redeem_bill_no",
              success: function (data)
              {
                  if (data == 1)
                  {
                      $("#manual_bill_no").val("");
                      $("#BillNO").html("Already exist");
                      $("#manual_bill_no").addClass("form-control has-error");
                  }
				  else
                  {
                      // $("#BillNO").html("Bill Number Available");
                      $("#manual_bill_no").removeClass("has-error");
                      $("#BillNO").html("");
                  }
              }
          });
      }
  });
</script>