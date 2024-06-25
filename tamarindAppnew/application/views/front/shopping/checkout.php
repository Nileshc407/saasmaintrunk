<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 

  </head>
<body> 
<?php 
	// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart); 
			}
		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}				
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
		
		// echo"--item_count2---".$item_count2."--<br>"; id=""
		?> 
<form method="post" action="<?php echo base_url()?>index.php/Shopping/checkout_cart_details">
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section">
      <div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url(); ?>index.php/Shopping/view_cart" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font">Delivery Address</p>
		</div>
		
		<?php if ($cart = $this->cart->contents()) { ?>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12">
            
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                
              <div class="pricing-details">
                <ul>
                    
                        <form>
                                <label class="radio-inline">
                                  <input type="radio" name="shipping_address" id="current_address"  <?php if($ShippingType == 1){echo 'checked="checked"';} ?> onclick="HideShow(0)" value="1" ><font id="Medium_font" > &nbsp;Existing</font> 
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="shipping_address" name="change_address" <?php if($ShippingType == 2){echo 'checked="checked"';} ?> onclick="HideShow(1)"  value="2" id="change_address" ><font id="Medium_font" >&nbsp;New</font>
                                </label>
                        </form>
                    </li>
                <!-- -------------------------------------------Current Addres----------------------------------- -->
                      <div id="Existing_address" <?php if($ShippingType == 2){echo 'style="display:none;"';} ?>>

                              <li>
                                      <font id="Medium_font" >First Name:</font> 
                                      <input type="text" readonly name="firstname" class="txt" id="firstname" value="<?php echo $Enroll_details->First_name ?>">

                              </li>                                                              

                              <li>
                                      <font id="Medium_font" >Last Name:</font> 
                                      <input type="text" readonly name="lastname" class="txt" placeholder="Last name" id="lastname" value="<?php echo $Enroll_details->Last_name ?>" >
                              </li>
                              <li>
                                      <font id="Medium_font" >Email:</font> 
                                      <input type="text" name="email" class="txt" placeholder="email" id="email" readonly value="<?php echo $Enroll_details->User_email_id ?>" >
                              </li>


                            <li><font id="Medium_font" >Address:</font> <textarea type="text" class="txt" readonly name="LastName" placeholder="Address" id="address" ><?php echo $Enroll_details->Current_address ?></textarea></li>

                              <li>
                                      <font id="Medium_font" >City:</font>  
                                      <select name="city" id="city"   class="txt"  readonly>
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
                                    <font id="Medium_font" >State:</font> 	
                                    <select name="state" id="state"  class="txt" readonly>
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
                                      <font id="Medium_font" >Country:</font>: 
                                      <select name="country" id="country"  class="txt" readonly>
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
                                      <font id="Medium_font" >ZIP/ P.O. Box:</font> 
                                      <input type="text" name="zip" class="txt" placeholder="Zip Code" id="zip" value="<?php echo $Enroll_details->Zipcode ?>" readonly >
                              </li>
                              <li>
                                      <font id="Medium_font" >Telephone:</font> 
                                      <input type="text" name="phone" class="txt" placeholder="phone" id="phone" value="<?php echo $Enroll_details->Phone_no ?>" readonly>
                              </li>
                      </div>
                        <!-- -------------------------------------------Current Addres----------------------------------- -->

                       <!-- -------------------------------------------New Addres----------------------------------- -->
                      <div id="new_address"  <?php if($ShippingType == 1){echo 'style="display:none;"';} ?>>
                        <li>
                                      <font id="Medium_font" >First Name:</font> <div id="firstname1_div" style="float:right;"></div>
                                      <input type="text" name="firstname1"  class="txt" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['firstname1'];} ?>" id="firstname1" placeholder="First Name" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" >

                              </li> 
                              <li>
                                      <font id="Medium_font" >Last Name:</font> <div id="lastname1_div" style="float:right;"></div>
                                      <input type="text" name="lastname1"  class="txt" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['lastname1'];} ?>" id="lastname1" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" placeholder="Last Name">
                              </li>
                              <li>
                                      <font id="Medium_font" >Email:</font> <div id="email1_div" style="float:right;"></div>
                                      <input type="email1"  name="email1"  class="txt" id="email1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['email1'];} ?>" placeholder="Email">


                              </li>


                              <li>
                                      <font id="Medium_font" >Address:</font> <div id="address1_div" style="float:right;"></div>
                                       <textarea  name="address1" id="address1"  class="txt"  placeholder="Address" ><?php if($New_shipping_details != ""){ echo $New_shipping_details['address1']; } ?></textarea>
                              </li>
                              <li> 
                                      <font id="Medium_font">Country:</font>: <div id="country_div" style="float:right;"></div>
                                      <select  name="country1" id="country"  class="txt"  onchange="Get_states(this.value);">
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
                                              <option value=""  class="txt" >Select Country</option>
                                              <option value="101">India</option>
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
                                      <?php 
                                              if(isset($_SESSION["To_State"]))
                                              { ?>
                                              <div  id="Show_States">

                                              <font id="Medium_font" >State:</font><div id="state_div" style="float:right;"></div>
                                              <select  name="state" id="state"  class="txt"  onchange="Get_cities(this.value);">
                                      <?php 

                                                      $States_array2 = $this->Igain_model->Get_states($_SESSION["To_Country"]);
                                                      foreach($States_array2 as $State)
                                                      {
                                      ?>
                                                      <option value="<?php echo $State->id;?>" <?php if($_SESSION["To_State"]==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
                                              <?php	}  ?></select></div>
                                              <?php
                                              }else{
                                      ?>
                                      <div  id="Show_States">

                                              <font id="Medium_font" >State:</font>
                                              <select  name="state" id="state"  class="txt"  onchange="Get_cities(this.value);">

                                                      <option value="">Select Country first</option>
                                              </select>	
                                      </div>
                                      <?php } ?>
                              </li>	
                              <li>
                                      <?php 
                                              if(isset($_SESSION["To_State"]))
                                              { ?>
                                                      <div  id="Show_Cities">

                                                      <font id="Medium_font" >City:</font><div id="city_div" style="float:right;"></div>
                                                      <select name="city" id="city"  class="txt"  >

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
                                                              <label for="exampleInputEmail1"><font id="Medium_font" >City:</font></label>
                                                              <select  name="city" id="city"   class="txt" >
                                                                      <option value="">Select State first</option>

                                                              </select>							
                                                      </div>
                                              <?php } ?>
                              </li>





                              <li>
                                      <font id="Medium_font" >ZIP/ P.O. Box:</font> <div id="zip1_div" style="float:right;"></div>
                                      <input type="text" name="zip1" placeholder="Zip Code"  class="txt"  id="zip1" value="<?php echo $Enroll_details->Zipcode ?>" >
                              </li>
                              <li>
                                      <font id="Medium_font" >Telephone:</font> <div id="phone1_div" style="float:right;"></div>
                                      <input type="text" name="phone1" placeholder="phone"  class="txt"  id="phone1" value="<?php echo $Enroll_details->Phone_no ?>" >
                              </li>

                      </div>
                <!-- -------------------------------------------New Addres----------------------------------- -->
                <div id="missing_value_div" style="float:right;"></div><br>
                </ul>
                   
              </div>
               
				<script>
					function HideShow(InputVal) 
					{
						// alert(InputVal); 
						if(InputVal == 0)
						{
							$('#new_address').css('display','none');
							$('#Existing_address').css('display','block');
						}
						else
						{
							$('#new_address').css('display','block');
							$('#Existing_address').css('display','none');
						}												
					}
				</script>
				
				<div class="pricing-details">
                                    
                                    
					<div class="row">
						<div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
							<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_Cart();" >Back</button>
						</div>
						
						<div class="col-xs-4 main-xs-6 text-right" style="width: 50%;">
							<button type="submit"   class="b-items__item__add-to-cart" id="ContinuetoCart" >
								Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</div>
			
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
           
          </div>

        </div>
		
		 
		<?php } ?>
		
      </div>
    </div>
    <!-- End Pricing Table Section -->
	
	
	
	
	
	
	
<!-- Loader -->	
    <div class="container" >
        <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" style="margin-top: 65%;">
              <!-- Modal content-->
              <div class="modal-content" id="loader_model">
                    <div class="modal-body" style="padding: 10px 0px;;">
                      <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                    </div>							
              </div>						  
            </div>
        </div>					  
    </div>
<!-- Loader -->	
  <?php $this->load->view('front/header/footer');?> 

<script>
    
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
            $("#address").removeAttr("required");
            $("#city").removeAttr("required");
            $("#zip1").removeAttr("required");
            $("#state").removeAttr("required");
            $("#country").removeAttr("required");
            $("#phone1").removeAttr("required");
            $("#email1").removeAttr("required");
    });

    $('#ContinuetoCart').click(function()
    {
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
        },2000);
        
            var shiptype1 = $("input[type=radio]:checked").val(); 
            var shiptype ='<?php echo $ShippingType; ?>';
           
            if(shiptype1 == 2)
            {
                var email = $("#email1").val()
                var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (filter.test(email) == true)
                {
                        // alert(filter.test(email));
                        // return true;
                        // alert($("#firstname1").val());
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
                        if($("#lastname1").val() == "")
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
                        if($("#address1").val() == "")
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
                        if($("#country").val() == "")
                        {	
                            var msg = 'Please Select Country';
                            $('#country_div').show();
                            $('#country_div').css("color","red");
                            $('#country_div').html(msg);
                            setTimeout(function(){ $('#country_div').hide(); }, 3000);
                            $( "#country" ).focus();
                            return false;			
                        }
                        if($("#state").val() == "")
                        {	
                            // alert('here....');
                            var msg = 'Please Select State';
                            $('#state_div').show();
                            $('#state_div').css("color","red");
                            $('#state_div').html(msg);
                            setTimeout(function(){ $('#state_div').hide(); }, 3000);
                            $( "#state" ).focus();
                            return false;			
                        }
                        if($("#city").val() == "")
                        {	
                            // alert('here....');
                            var msg = 'Please Select City';
                            $('#city_div').show();
                            $('#city_div').css("color","red");
                            $('#city_div').html(msg);
                            setTimeout(function(){ $('#city_div').hide(); }, 3000);
                            $( "#city").focus();
                            return false;			
                        }
                        if($("#zip1").val() == "")
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
                        if($("#phone1").val() == "")
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

                        return true;
                }
                else 
                {

                        var msg = 'Please enter valid email id';
                        $('#email1_div').show();
                        $('#email1_div').css("color","red");
                        $('#email1_div').html(msg);
                        setTimeout(function(){ $('#email1_div').hide(); }, 3000);
                        $( "#email1" ).focus();
                        return false;
                }

            }
            else if( shiptype1 == 1)
            {
                
                if( $("#firstname").val() =="" || $("#lastname").val() =="" || $("#email").val() == "" || $("#address").val() == "" ||  $("#city").val() == "" || $("#state").val() == "" || $("#country").val() == "" ||  $("#phone").val() == "" ||  $("#zip").val() == "" )
                {
                    //alert('Something missing');
                    var msg = 'Please update your profile details for purchase transaction ';
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
		url: "<?php echo base_url(); ?>index.php/Cust_home/Get_states",
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
		url: "<?php echo base_url(); ?>index.php/Cust_home/Get_cities",
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
	
	#txt, #address1{
	  border-left: none;
	  border-right: none;
	  border-top: none;
	  padding: 5% 0 0 0px;
	  outline: none;
	  width: 100%;
	}	
	#zip, #email, #phone, #lastname, #firstname, #zip1, #email1, #phone1, #lastname1, #firstname1{
	  border-left: none;
	  border-right: none;
	  border-top: none;
	  padding:1%;
	  outline: none;
	  width: 100%;
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