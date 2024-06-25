<?php $this->load->view('header/header'); ?>
<div class="content-i" style="min-height:900px;">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">Update Order Status</h6>
                    <div class="element-box">
						<?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php }
						  
                        $attributes = array('id' => 'formValidate');
                        echo form_open('#', $attributes);   //Get_order(this.value);?>
                        <h5 class="form-header"> </h5>					  
                        <div class="form-group">
                            <label for=""> Order No. / Pos Bill No.</label>
                            <input class="form-control" data-error="Please enter order no. / Pos bill no." placeholder="Enter online order no. / Pos bill no." required="required" type="text" id="Order_no" name="Order_no" onblur="Get_order(this.value); Fetch_Member_info(this.value);" class="form-control">
							<div class="help-block form-text with-errors form-control-feedback" id="MembershipID"></div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="button" name="button" id="submit">Click here</button>
                        </div> <br/>
						<div class="form-group">
							<div id="Bill_details" style="display:none;"> 
							 <ul>
                                <li>
								Order Amount (<?php echo $Symbol_of_currency; ?>) : <strong id="Bill_amount"> </strong> 
								</li><hr>
                                <li>
								Paid Amount (<?php echo $Symbol_of_currency; ?>) : <strong id="Paid_amount"> </strong>
								</li><hr>
                                <li>
								Amount Due (<?php echo $Symbol_of_currency; ?>) : <strong id="Amount_due"> </strong>
								</li><hr>
							</ul>
							</div>
						</div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="element-wrapper">
                    <h6 class="element-header">Member Details</h6>
                    <div class="element-box">
                        <div class="profile-tile">
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        Member Name : <strong id="member_name"></strong>
                                    </li><hr>
                                    <li>
                                        Membership Id : <strong id="cardId"></strong>
                                    </li><hr>
                                    <li>
										 Email ID : <strong id="member_email"></strong>    
                                    </li><hr>
                                    <li>
										Phone No. : <strong id="member_phn"></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>	
        <div id="records">				
        </div>
	</div>
</div>		
<?php $this->load->view('header/footer'); ?>
<script>
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31
		  && (charCode < 48 || charCode > 57))
	  return false;

  return true;
}

var Pin_no_applicable = <?php echo $Pin_no_applicable; ?>;
var Allow_merchant_pin = <?php echo $Allow_merchant_pin; ?>;
var Merchant_pin = <?php echo $Merchant_pin; ?>;

function check_pin(Entered_pin,Customer_pin)
{
	if(Pin_no_applicable==1)
	{
		var Entered_pin = $('#cust_pin').val();

		if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
		{
			$('#cust_pin').val("");
			// has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
			//document.getElementById("pin_glyphicon").innerHTML="Please Enter Valid Member Pin Number !!!";
		}
		else
		{
			 // has_success("#pin_feedback","#pin_glyphicon","#pin_help","Valid Pin");
			// document.getElementById("pin_glyphicon").innerHTML="";
		}
	}
}

function check_pin2(Entered_pin2)
{
	if(Allow_merchant_pin==1)
	{
		var Entered_pin2 = $('#seller_pin').val();

		if( (Entered_pin2 != Merchant_pin) || (Entered_pin2 == "") )
		{
			$('#seller_pin').val("");
			 has_error("#pin_feedback2","#pin_glyphicon2","#pin_help2","Please Enter Valid Pin Number...!!!");
			//document.getElementById("pin_glyphicon2").innerHTML="Please Enter Valid Merchant Pin Number !!!";
		}
		else
		{
			 has_success("#pin_feedback2","#pin_glyphicon2","#pin_help2","Valid Pin");
			document.getElementById("pin_glyphicon2").innerHTML="";
		}
	}
}

function Proceed_to_fullfill()
{
	var flag_access=0;
	var flag_access2=0;

	if(Pin_no_applicable==1)
	{
		var Entered_pin = $('#cust_pin').val();

		if( Entered_pin != "")
		{
				 flag_access=1;
		}
		else
		{
			runjs("Data Validation","Please Enter Valid Member Pin Number !!!");
			return false;
		}
	}
	else
	{
		 flag_access=1;
	}

	if(Allow_merchant_pin==1)
	{
		var Entered_pin2 = $('#seller_pin').val();

		if( Entered_pin2 != "")
		{
				 flag_access2=1;
		}
		else
		{
			runjs("Data Validation","Please Enter Valid Outlet Pin Number !!!");
			return false;
		}
	}
	else
	{
		 flag_access2=1;
	}

	if(flag_access==1 && flag_access2==1)
	{
		show_loader();
	}

	//$("#amt_deposit").removeAttr("required");
}
function Get_order(Order_no)
{
	var Company_id = '<?php echo $Company_id; ?>';
	var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
	var Allow_merchant_pin = '<?php echo $Allow_merchant_pin; ?>';

	$.ajax({
			type:"POST",
			data:{Order_no:Order_no, Company_id:Company_id, Pin_no_applicable:Pin_no_applicable, Allow_merchant_pin:Allow_merchant_pin},
			url: "<?php echo base_url()?>index.php/CatalogueC/Get_order_details",
			success : function(data)
			{
				document.getElementById("records").innerHTML=data;
			}
		});
}

function Fetch_Member_info(Order_no) 
{	
	var Company_id = '<?php echo $Company_id; ?>';
	var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
	var Allow_merchant_pin = '<?php echo $Allow_merchant_pin; ?>';
	
	if(Order_no != "" && Order_no != 0 )
	{								
		$.ajax({
			type:"POST", 
			data:{Order_no:Order_no, Company_id:Company_id, Pin_no_applicable:Pin_no_applicable, Allow_merchant_pin:Allow_merchant_pin},
			url: "<?php echo base_url()?>index.php/CatalogueC/Fetch_Member_info/",
			dataType: "json",
			success: function(json)
			{ 
				
				if(json['Error_flag'] == 1001) // Status Is OK
				{
					if(parseInt(json['Bill_amount']) > 0) 
					{
						$('#Bill_details').show(); 
					}
					$("#cardId").html(json['Card_id']);
					$("#member_email").html(json['User_email_id']);  
					$('#member_name').html(json['Full_name']);
					$('#member_phn').html(json['Phone_no']);
					$('#Bill_amount').html(json['Bill_amount']);
					$('#Paid_amount').html(json['Paid_amount']);
					$('#Amount_due').html(json['Amount_due']);
				}
			}
		});
	}
}

$("#checkAll").attr("data-type", "check");
function Check_all()
{
	if ($("#checkAll").attr("data-type") === "check") 
	{
		$(".checkbox2").prop("checked", false);
	
		$("#checkAll").attr("data-type", "uncheck");
	} 
	else 
	{
		$(".checkbox2").prop("checked", true);
		$("#checkAll").attr("data-type", "check");
	} 
}	
</script>