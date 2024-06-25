<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Delivery Address</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
	// var_dump($Medium_font_details);
	?>
  </head>
<body> 
 <?php 
	$item_count=0;
	if($Redemption_Items != "") {
		foreach($Redemption_Items as $item)
		{
			$item_count=$item_count+$item["Total_points"]; 
			if($item["Redemption_method"]==29)
	{
		$Delivery_method=1;
	}
		}
	}
	if($item_count <= 0 ) {
			$item_count=0;
	}
	else {
			$item_count = $item_count;
	}
?> 
<?php  echo form_open('Redemption_Catalogue/Review_Redemption'); ?>
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
      <div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font">Delivery Address</p>
		</div>
		
          <?php 
            $Exist_Delivery_method=0;
            if(isset($_SESSION["To_Country"]))
            {
                    $To_Country=$_SESSION["To_Country"];
                    $To_State=$_SESSION["To_State"];
            }
            $Sub_total2=0;
            foreach ($Redemption_Items as $item2) 
            {									
                    $Sub_total2=$Sub_total2+$item2["Total_points"];
            }
            foreach ($Redemption_Items as $item) 
            {									
                    $Get_Code_decode = $this->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
                    $Redemption_method=$Get_Code_decode->Code_decode;
                    if($item["Redemption_method"]==29)
                    {
                            $Exist_Delivery_method=1;
                            $Get_weight_items = $this->Redemption_Model->get_weight_items_same_location($item["Partner_state"],$enroll);
                            $Weight_in_KG=0;
                            foreach($Get_weight_items as $rec)
                            {
                                    $Total_weight_same_location=$rec["Total_weight_same_location"];
                                    $lv_Weight_unit_id=$rec["Weight_unit_id"];
                                    /*******Total Weight convert into KG for same location****/
                                    $kg=1;
                                    switch ($lv_Weight_unit_id)
                                    {
                                            case 2://gram
                                            $kg=0.001;break;
                                            case 3://pound
                                            $kg=0.45359237;break;
                                    }
                                    $Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
                                    // echo "<br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id;
                            }
                            /*******Single Weight convert into KG****/

                            $kg2=1;
                            switch ($item["Weight_unit_id"])
                            {
                                    case 2://gram
                                    $kg2=0.001;break;
                                    case 3://pound
                                    $kg2=0.45359237;break;
                            }

                            /**************************/


                            $Single_Item_Weight_in_KG=($item["Weight"]*$item["Quantity"]*$kg2);

                            // echo "<br><br><b>Merchandize_item_name </b>".$item["Merchandize_item_name"]." <br><b>Weight </b>".$item["Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["Quantity"]." <br><b>Weight_unit_id </b>".$item["Weight_unit_id"]." <br><b>Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$item["Partner_state"]." <br><b>Temp_cart_id </b>".$item["Temp_cart_id"];
                    }
                    else
                    {
                            $Total_Weighted_avg_shipping_pts[]=0;
                            $Weighted_avg_shipping_pts="-";
                    }
                    if($Shipping_charges_flag==2)
                    {
                            if($item["Redemption_method"]==29)
                            {
                                    $Get_shipping_points = $this->Igain_model->Get_delivery_price_master($item["Partner_Country_id"],$item["Partner_state"],$To_Country,$To_State,$Weight_in_KG,1);
                                    $Shipping_cost= $Get_shipping_points->Delivery_price;
                                    $Shipping_pts=round($Shipping_cost*$Redemptionratio);
                                    $Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
                                    $Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
                                    // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
                            }
                    }
                    elseif($Shipping_charges_flag==1)//Standard Charges
                    {
                            if($item["Redemption_method"]==29)
                            {
                                    $Cost_Threshold_Limit2=round($Cost_Threshold_Limit*$Redemptionratio);
                                    if($Sub_total2 >= $Cost_Threshold_Limit2)
                                    {	
                                            $Shipping_pts=round($Standard_charges*$Redemptionratio);
                                            $Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
                                            $Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
                                    }
                                    else
                                    {
                                            $Shipping_pts=0;
                                            $Weighted_avg_shipping_pts=0;
                                            $Total_Weighted_avg_shipping_pts[]=0;
                                    }
                                    // echo "<br><b>Standard_charges </b>".$Standard_charges;
                            }
                    }
                    else
                    {
                            $Shipping_pts=0;
                            $Weighted_avg_shipping_pts=0;
                            $Total_Weighted_avg_shipping_pts[]=0;
                    }

                    // echo "<br><b>Shipping_pts </b>".$Shipping_pts;
                    // echo "<br><b>Weighted_avg_shipping_pts </b>".$Weighted_avg_shipping_pts;
                    $Sub_Total[]=$item["Total_points"];
                    echo '<input type="hidden" name="Hidden_Weighted_avg_shipping_pts_'.$item['Temp_cart_id'].'" id="Hidden_Weighted_avg_shipping_pts_'.$item['Temp_cart_id'].'" value="'.$Weighted_avg_shipping_pts.'">';
            }	
                $lv_Sub_Total=array_sum($Sub_Total);
                $Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
                $Grand_total=($lv_Sub_Total+$Total_Shipping_Points);
                ?>
                <input type="hidden" name="Current_balance" value="<?php echo $Enroll_details->Current_balance;?>">
                <input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
                <input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
                <input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
                <input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
                <input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
		
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12">
            
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                
              <div class="pricing-details">
                <ul>
                    
                        <form>
                                <label class="radio-inline">
                                  <input type="radio" name="shipping_address" id="current_address" value="1" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 1){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>><font id="Medium_font" > &nbsp;Current Address</font> 
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="shipping_address" id="change_address" value="2" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 2){echo 'checked="checked"';}} ?> ><font id="Medium_font" >&nbsp;New</font>
                                </label>
                        </form>
                    </li>
                <!-- -------------------------------------------Current Address----------------------------------- -->
                      <div id="Current_address" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 2){echo 'style="display:none;"';}} ?>>

                              <li>
                                     
                                      <input type="text" readonly name="firstname" class="txt"  id="firstname" value="<?php echo $Enroll_details->First_name ?>" placeholder="First Name">

                              </li>                                                              

                              <li>
                                      
                                      <input type="text" readonly name="lastname" class="txt" id="lastname" value="<?php echo $Enroll_details->Last_name ?>" placeholder="Last Name">
                              </li>
                              <li>
                                      
                                      <input type="text" name="Email" placeholder="Email Id" class="txt"  id="email" readonly value="<?php echo $Enroll_details->User_email_id ?>" >
                              </li>


                              <li>
							  <textarea type="text" class="txt" readonly name="LastName" placeholder="Address" id="address" ><?php echo $Enroll_details->Current_address ?></textarea></li>

                              <li>
							 
								  <select name="city" id="city"  class="txt"  readonly>
								  <option value="">Select City</option>
									  <?php 
											foreach($City_array as $rec) {
												if($Enroll_details->City == $rec->id){
												?>
												<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
												<?php }                                                         
											}
									  ?>
								  </select>
                              </li>
                              <li>
                                     
								  <select name="state" id="state"  class="txt"  readonly>
								  
								   <option value="">Select State</option>
										  <?php 
												  foreach($States_array as $rec)
												  {
														  if($Enroll_details->State == $rec->id){
														  ?>
														  <option value="<?php echo $rec->id;?>" <?php if($Enroll_details->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
												  <?php } }
										  ?>	
								  </select> 
                              </li>
                              <li> 
                                     
                                      <select name="country" id="country"  class="txt"  readonly>
									   <option value="">Select Country</option>
                                         <?php 
										  foreach($Country_array as $Country)
										  {
												  if($Enroll_details->Country == $Country['id']){
												  ?>
												  <option value="<?php echo $Country['id'];?>" <?php if($Enroll_details->Country == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>
										  <?php } }
                                              ?>
                                      </select> 
                              </li>						
                              <li>
                                     
                                      <input type="text" name="zip" placeholder="Zip Code" class="txt"  id="zip" value="<?php echo $Enroll_details->Zipcode ?>" readonly >
                              </li>
                              <li>
                                      
                                      <input type="text" name="phone" placeholder="Phone No." id="phone" class="txt"  value="<?php echo $Enroll_details->Phone_no ?>" readonly>
                              </li>



                      </div>
                        <!-- -------------------------------------------Current Address----------------------------------- -->

                       <!-- -------------------------------------------New Address----------------------------------- -->
                      <div id="New_address"  <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 1){echo 'style="display:none;"';}}else {echo 'style="display:none;"';}  ?> >
                                
                        <li>
							 <div id="firstname1_div" style="float:right;"></div>
							  <input type="text" name="firstname1" class="txt"  value="<?php if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"];} ?>" id="firstname1" placeholder="First Name" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" autocomplete="off">

                              </li> 
                              <li>
                                      <div id="lastname1_div" style="float:right;"></div>
                                      <input type="text" name="lastname1" class="txt"  value="<?php if(isset($_SESSION["lastname"])){echo $_SESSION["lastname"];} ?>" id="lastname1" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" placeholder="Last Name" autocomplete="off">
                              </li>
                              <li>
                                      <div id="email1_div" style="float:right;"></div>
                                      <input type="email1"  name="email1" class="txt"  id="email1" value="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?>" placeholder="Email Id" autocomplete="off">


                              </li>


                              <li>
                                      <div id="address1_div" style="float:right;"></div>
                                       <textarea  name="address1" id="address1" class="txt"  placeholder="Address" ><?php if(isset($_SESSION["address"])){echo $_SESSION["address"];} ?></textarea>
                              </li>
                              <li> 
                                     <div id="country_div" style="float:right;"></div>
                                      <select  name="country1" id="country1" class="txt"   onchange="Get_states(this.value);">
									  <option value="">Select country</option>
                                              <?php 
                                                      if(isset($_SESSION["To_Country"]))
                                                      { 
                                                              foreach($Country_array as $Country)
                                                              {
                                              ?>
                                                              <option value="<?php echo $Country['id'];?>" <?php if($_SESSION["To_Country"]==$Country['id']){echo 'selected';}?>><?php echo $Country['name'];?></option>
                                              <?php	}}
                                              else{
                                              ?>
                                              <option value="">Select Country</option>
                                              
                                                <?php 
                                                      foreach($Country_array as $Country)
                                                      {
                                                          echo "<option value=".$Country['id'].">".$Country['name']."</option>";
                                                      }
                                                ?>
                                              <?php } ?>	
                                      </select> 
                              </li>	
                              <li>
									<div id="state_div" style="float:right;"></div>
                                      <?php 
                                              if(isset($_SESSION["To_State"]))
                                              { ?>
                                              <div  id="Show_States">

                                              
                                              <select  name="state" id="state1" class="txt"  onchange="Get_cities(this.value);">
                                      <?php 

                                                      $States_array2 = $this->Igain_model->Get_states($_SESSION["To_Country"]);
                                                      foreach($States_array2 as $State)
                                                      {
                                      ?>
                                                      <option value="<?php echo $State->id;?>" <?php if($_SESSION["To_State"]==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
                                              <?php	}  ?></select></div>
                                              <?php
                                              } else{
                                      ?>
                                      <div  id="Show_States">

                                              
                                              <select  name="state" id="state1" class="txt"  onchange="Get_cities(this.value);">

                                                      <option value="">Select Country first</option>
                                              </select>	
                                      </div>
                                      <?php }  ?>
									  
                              </li>	
                              <li>
									<div id="city_div" style="float:right;"></div>
                                      <?php 
                                              if(isset($_SESSION["To_State"]))
                                              { ?>
                                                      <div  id="Show_Cities">

                                                     
                                                      <select name="city" id="city1" class="txt"  >

                                                      <?php 

													  $City_array2 = $this->Igain_model->Get_cities($_SESSION["To_State"]);
													  foreach($City_array2 as $City)
													  {
									  ?>
														<option value="<?php echo $City->id;?>" <?php if($_SESSION["City_id"]==$City->id){echo 'selected';}?>><?php echo $City->name;?></option>
											  <?php	} ?>
                                                              </select>							
                                                      </div>
                                              <?php 
                                              }
                                              else
                                              {
                                                      ?>
                                                      <div  id="Show_Cities">					
                                                              <label for="exampleInputEmail1"></label>
                                                              <select  name="city" id="city1"  class="txt" >
                                                                      <option value="">Select State first</option>

                                                              </select>							
                                                      </div>
                                              <?php } ?>
                              </li>





                              <li>
                                     <div id="zip1_div" style="float:right;"></div>
                                      <input type="text" name="zip1" placeholder="Zip Code" class="txt"  id="zip1" value="<?php if(isset($_SESSION["zip"])){echo $_SESSION["zip"];} ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                              </li>
                              <li>
                                     <div id="phone1_div" style="float:right;"></div>
                                      <input type="text" name="phone1" placeholder="Phone No." class="txt"  id="phone1" value="<?php if(isset($_SESSION["phone"])){echo $_SESSION["phone"];} ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                              </li>

                      </div>
                <!-- -------------------------------------------New Address----------------------------------- -->
                 <div id="missing_value_div" style="float:right;"></div><br>
                </ul>
                  
              </div>
				
				
				<div class="pricing-details">
					<div class="row">
                                            <div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
                                                    <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_Proceed_Redemption_Catalogue();" >Back</button>
                                            </div>
                                            <div class="col-xs-4 main-xs-6 text-right" style="width: 50%;">
                                                     <!--<span id="button" class="b-items__item__add-to-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</span>
                                                     <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="window.location.href='<?php echo base_url()?>index.php/Shopping/checkout'"  > Cart Details</button>
                                                     -->
                                                    <button type="submit"   class="b-items__item__add-to-cart" id="ContinuetoCart" >
                                                        Proceed
                                                    </button>
                                            </div>
					</div>
				</div>
			
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
           
          </div>

        </div>
		
		 
		
		
      </div>
    </div>
    <!-- End Pricing Table Section -->
	<?php echo form_close(); ?>	
	
	
    
<!-- Loader -->	
    <div class="container" >
        <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" style="margin-top: 65%;">
              <!-- Modal content-->
              <div class="modal-content" id="loader_model">
                    <div class="modal-body" style="padding: 10px 0px;;">
                      <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                    </div>							
              </div>						  
            </div>
        </div>					  
    </div>
<!-- Loader -->	
<?php $this->load->view('front/header/footer');?> 
<script>   
    function Go_to_Proceed_Redemption_Catalogue()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');	
           window.location.href='<?php echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },2000);
    }
    function Go_to_Cart()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');	
            window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },2000);
    }
    $('#change_address').click(function()
    {
        $( "#New_address" ).show();
        $( "#Current_address" ).hide();
    });

    $('#current_address').click(function()
    {
        $( "#Current_address" ).show();
        $( "#New_address" ).hide();

        $("#firstname1").removeAttr("required");
        $("#lastname1").removeAttr("required");
        $("#address1").removeAttr("required");
        $("#city").removeAttr("required");
        $("#zip1").removeAttr("required");
        $("#state").removeAttr("required");
        $("#country").removeAttr("required");
        $("#phone1").removeAttr("required");
        $("#email1").removeAttr("required");
    });
    
    $('#ContinuetoCart').click(function()
    {
		var shiptype1 = $("input[type=radio]:checked").val(); 
		var shiptype ='2';
		if(shiptype1 == 2)
		{
			var email = $("#email1").val()
			var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			if($("#firstname1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please enter First Name';
				$('#firstname1_div').show();
				$('#firstname1_div').css("color","red");
				$('#firstname1_div').html(msg);
				setTimeout(function(){ $('#firstname1_div').hide(); }, 3000);
				$( "#firstname1" ).focus();
				return false;			
			}
			else if($("#lastname1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please enter Last Name';
				$('#lastname1_div').show();
				$('#lastname1_div').css("color","red");
				$('#lastname1_div').html(msg);
				setTimeout(function(){ $('#lastname1_div').hide(); }, 3000);
				$( "#lastname1" ).focus();
				return false;			
			}
			else if(filter.test(email) == false)
			{				
				var msg = 'Please enter valid email id';
				$('#email1_div').show();
				$('#email1_div').css("color","red");
				$('#email1_div').html(msg);
				setTimeout(function(){ $('#email1_div').hide(); }, 3000);
				$( "#email1" ).val('');	
				$( "#email1" ).focus();
				return false;
			}
			else if($("#address1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please enter Address';
				$('#address1_div').show();
				$('#address1_div').css("color","red");
				$('#address1_div').html(msg);
				setTimeout(function(){ $('#address1_div').hide(); }, 3000);
				$( "#address1" ).focus();
				return false;			
			}
			else if($("#country1").val() == "")
			{
				var msg = 'Please Select Country';
				$('#country_div').show();
				$('#country_div').css("color","red");
				$('#country_div').html(msg);
				setTimeout(function(){ $('#country_div').hide(); }, 3000);
				$( "#country1" ).focus();
				return false;			
			}
			else if($("#state1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please Select State';
				$('#state_div').show();
				$('#state_div').css("color","red");
				$('#state_div').html(msg);
				setTimeout(function(){ $('#state_div').hide(); }, 3000);
				$("#state1").focus();
				return false;			
			}
			else if($("#city1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please Select City';
				$('#city_div').show();
				$('#city_div').css("color","red");
				$('#city_div').html(msg);
				setTimeout(function(){ $('#city_div').hide(); }, 3000);
				$( "#city1").focus();
				return false;			
			}
			else if($("#zip1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please enter Zipcode';
				$('#zip1_div').show();
				$('#zip1_div').css("color","red");
				$('#zip1_div').html(msg);
				setTimeout(function(){ $('#zip1_div').hide(); }, 3000);
				$( "#zip1" ).focus();
				return false;			
			}
			else if($("#phone1").val() == "")
			{	
				// alert('here....');
				var msg = 'Please enter Phone Number';
				$('#phone1_div').show();
				$('#phone1_div').css("color","red");
				$('#phone1_div').html(msg);
				setTimeout(function(){ $('#phone1_div').hide(); }, 3000);
				$( "#phone1" ).focus();
				return false;			
			}
			else
			{
				setTimeout(function() 
				{
						$('#myModal').modal('show');	
				}, 0);
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide');
				},1000);
				return true;
			}
		}
		else if( shiptype1 == 1)
		{   
			if( $("#firstname").val() =="" || $("#lastname").val() =="" || $("#email").val() == "" || $("#address").val() == "" ||  $("#city").val() == "" || $("#state").val() == "" || $("#country").val() == "" ||  $("#phone").val() == "" ||  $("#zip").val() == "" )
			{	   
				var msg = 'Please update your address details from profile';
				$('#missing_value_div').show();
				$('#missing_value_div').css("color","red");
				$('#missing_value_div').html(msg);
				setTimeout(function(){ $('#missing_value_div').hide(); }, 3000);
			   // $( "#missing_value_div" ).focus();
				return false;
			}
			else
			{
			   return true; 
			}
		}
		else
		{
				return true;
		}
		return false;
    });

/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	 // alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url(); ?>index.php/Redemption_Catalogue/Get_states",
		success: function(data)
		{
			// alert(data.States_data);
			$("#Show_States").html(data.States_data);	
			
		}
	});
}
function Get_cities(State_id)
{
	// alert(State_id);
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url(); ?>index.php/Redemption_Catalogue/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			
		}
	});
}
/************************************************************************/	
</script>

<style>
		
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 13px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
		    
	}
	
	.pricing-table .pricing-details span {
		display: inline-block;
		font-size: 13px;
		font-weight: 400;
		color: #000000;
		margin-bottom: 20px;
	}
	
	h1, h2, h3, h4, h5, h6 {
		margin-top: 10px;
	}
	
	
	
         @media screen and (min-width: 320px) {
            #cart_count {
			<?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 11%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 13%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 15%; 
			<?php } ?>
			width: 20%; 
				margin-left:-10%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        @media screen and (min-width: 768px) {
            #cart_count {
               <?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 6%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 6%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 6%; 
			<?php } ?>
			
                margin-left:-9%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        
        .txt {
   
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: medium;
    border-top-color: -moz-use-text-color;
   
    border-top-style: none;
    border-top-width: medium;
    margin-left: 0;
    outline-color: -moz-use-text-color;
    outline-style: none;
    outline-width: medium;
    padding-bottom: 2%;
    padding-left: 1%;
    padding-right: 1%;
    padding-top: 4%;
    width: 100%;
}
</style>