<!DOCTYPE html> 
<html lang = "en">
 <head> 
    <meta charset = "utf-8"> 
    <title>iGainSpark - Contact Us</title> 
	<script src="<?php echo base_url();?>assets\js\jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets\js\jquery-ui.js"></script>
	<script src="<?php echo base_url();?>assets\js\jquery-1.10.2.js"></script>
	<script src="<?php echo base_url();?>assets\js\jquery-1.11.1.js"></script>
	<link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo base_url()?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet" /> 
	<link href="<?php echo base_url()?>assets/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<form id="myForm">
<?php //echo  form_open('Stud_controller/purchase_transaction'); ?>
<table border='0' width='480px' cellpadding='0' cellspacing='0' align='left'> </br>
<span id="client1">

	<tr>
		<th> # </th>
		<th> Item Id </th>
		<th> Qty </th>
		<th> Rate </th>
		<th> Amount </th>
	</tr>
	<tr> 	
		<td> <input type='text' name='no' size='5' value='1' readOnly> </td>
		<td> <input type='text' name='item_name' id='item_name1'> </td> 
		<td> <input type='text' name='item_qty' id='item_qty1' size='5' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='item_rate' id='item_rate1' size='10' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='itemamt1' readOnly id='item_amt1' size='10'> </td>
	</tr> 
	<tr> 	
		<td> <input type='text' name='no' size='5' value='2' readOnly> </td>
		<td> <input type='text' name='item_name' id='item_name2'> </td>
		<td> <input type='text' name='item_qty' id='item_qty2' size='5' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='item_rate' id='item_rate2' size='10' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='itemamt2' readOnly id='item_amt2' size='10'> </td>
	</tr> 
	<tr> 	
		<td> <input type='text' name='no' size='5' value='3' readOnly> </td>
		<td> <input type='text' name='item_name' id='item_name3'> </td>
		<td> <input type='text' name='item_qty' id='item_qty3' size='5' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='item_rate' id='item_rate3' size='10' onblur="javascript:getpos(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
		<td> <input type='text' name='itemamt3' readOnly id='item_amt3' size='10'> </td>
	</tr>	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Amount</td>
		<td> <input type='text' name='totalbill' readOnly id='totalbill' size='10'> </td>
	</tr> 
</table>

<table border='0' width='480px' cellpadding='0' cellspacing='0' align='left'>	 
<tr> 
	<th> Shipping Address </th>
</tr>

<tr>
	<th> Address </th>
<tr> 
	<td colspan="3"> <textarea rows="1" cols="40" id="address" name="address"></textarea> </td>
</tr>
<tr>
	<th> City</th>
	<th> Zip Code </th> 
	<th> State </th>
</tr>
<tr>
	<td> <input type ="text" name="city" id="city" size='12'> </td>
	<td> <input type="text" name="zip" id="zip" size='12' onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
	<td> <input type="text" name="state" id="state" size='12'> </td>
</tr>
<tr>
	<th colspan="2"> Contact no.</th>  
	<th> Email</th>
<tr>	
	<td colspan="2"> <input type ="text" name="contact" id="contact" size='30' onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
	<td > <input type ="text" name="email" id="email" size='25'> </td>
<tr>
</tr>
</table>
</span>
<span id="client14">
<span id="client">
<table border='0' align="center">
	<tr>
		<th> Membership Id : </th>
		<td> <input type='text' name='CardId' id='CardId' onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
	</tr>
	<tr> <td>&nbsp;</td> </tr>
	<tr>
		<th> <lable> Points to Redeem  : </lable> <font color='red'> * </font>  </th>
		<td> <input type="text" name="points_redeemed" id="reedem" required  
		onkeyup="this.value=this.value.replace(/\D/g,'')"> <br> <span id="error_block"> </span> <span id="error_block2"> </span></td>
	</tr>
	<tr> <td>&nbsp;</td> </tr>
		<th> <lable> Payment Option : </lable> </th>
		<td> 
		<input type="radio" name="payment_option" id="cod" value="2"> Cash on delivery 
		<input type="radio" name="payment_option" id="BrainTree" value="1"> BrainTree <br> </td>
	</tr>
	<tr> <td>&nbsp;</td> </tr>
	
	
	<tr style="display:none;" id="Card_no1">
		<th> Card No : </th>
		<td> <input type='text' name='Card_no' id='Card_no' onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
	</tr>
	
	<tr style="display:none;" id="card_name1">  
		<th> Card Name : </th>
		<td> <input type='text' name='card_name' id='card_name'> </td> 
	</tr>

		<tr style="display:none;" id="Cvv1">
		<th> CVV : </th>
		<td> <input type='text' name='Cvv' id='Cvv' placeholder="123" onkeyup="this.value=this.value.replace(/\D/g,'')"> </td>
	</tr>
	
	<tr style="display:none;" id="valid1">
		<th> Valid Up To : </th>
		<td> <input type='text' name='valid' id='valid' placeholder="05/27" > </td>
	</tr>
	<tr> <td>&nbsp;</td> </tr>
	<tr>
	
	<td>&nbsp;</td><td><button type="button" name="submit" value="Register" id="Register" onclick="javascript:Purchase_transaction();" >Submit</button>
		<input type="RESET" value="RESET" name="reset" id="reset"> </td>
	</tr>
</span>
</table>
</span>
</form>
</body>
</html>


<!-- Calculate Total Purchase Amount -->
<script>
	function getpos(val)
	{
		var qty1 = document.getElementById("item_qty1").value; 
		var item_rate1 = document.getElementById("item_rate1").value;
		var billamt1  = qty1 * item_rate1; 
		document.getElementById("item_amt1").value = billamt1;
		
		var qty2 = document.getElementById("item_qty2").value; 
		var item_rate2 = document.getElementById("item_rate2").value;
		var billamt2  = qty2 * item_rate2; 
		document.getElementById("item_amt2").value = billamt2;
		  
		var qty3 = document.getElementById("item_qty3").value; 
		var item_rate3 = document.getElementById("item_rate3").value;
		var billamt3  = qty3 * item_rate3; 
		document.getElementById("item_amt3").value = billamt3;
		  
		var billamt = billamt1 + billamt2 + billamt3 ;
		  
		document.getElementById("totalbill").value = billamt;
		
	}
</script>
<script>
	function Purchase_transaction()
	{	 
	
		if($('#CardId').val() == "")
		{
			$('#CardId').focus();
			return false;
		}
		else if($('#item_name1').val() == "")   
		{
			$('#item_name1').focus();
			return false;
		}
		else if($('#item_qty1').val() == "")
		{
			$('#item_qty1').focus();
			return false;
		}
		else if($('#item_rate1').val() == "")
		{
			$('#item_rate1').focus();
			return false;
		}
		else if($('#reedem').val() == "")
		{
			$('#reedem').focus();
			return false;
		}
		else
		{
		var CardId = $('#CardId').val();
		var item_name1 = $('#item_name1').val();
		var item_qty1 = $('#item_qty1').val();
		var item_rate1 = $('#item_rate1').val();
		var totalbill = $('#totalbill').val();
		var reedem = $('#reedem').val();                        
		var address = $('#address').val();
		var city = $('#city').val();
		var zip = $('#zip').val();
		var state = $('#state').val();
		var contact = $('#contact').val();
		var Card_no = $('#Card_no').val();  	    
		var email = $('#email').val();
		var card_name = $('#card_name').val();
		var Cvv = $('#Cvv').val();
		var valid = $('#valid').val();
		// var Payment_option = $('#payment_option').val();
		var item_name2 = $('#item_name2').val();
		var item_qty2 = $('#item_qty2').val();
		var item_rate2 = $('#item_rate2').val();
		var item_name3 = $('#item_name3').val();
		var item_qty3 = $('#item_qty3').val();
		var item_rate3 = $('#item_rate3').val();
		var company_key = "9jak77l2eacbmamo";
		var Company_id = 3;
		var Payment_option = $("input[type=radio]:checked").val();	
		$.ajax({
				type:"POST",
					data:{API_key:company_key, Membership_id:CardId, item_name1:item_name1, item_qty1:item_qty1, item_rate1:item_rate1, item_name2:item_name2, item_qty2:item_qty2, item_rate2:item_rate2, item_name3:item_name3, item_qty3:item_qty3, item_rate3:item_rate3, Redeem_points:reedem, address:address, city:city, zip:zip, state:state, contact:contact, email:email, Company_id:Company_id, Payment_option:Payment_option, subtotal:totalbill, Card_no:Card_no, card_name:card_name, Cvv:Cvv, valid:valid},
					url: "<?php echo base_url()?>index.php/Customer_Api/DoExpressCheckoutPayment/",
					success: function(data)
					{
					  // alert(data);
						json = eval("(" + data + ")");
						
						if(json[0].Error_flag == 0)
						{
							alert('E-Commerce Transaction done Successfully!!');
							$('#CardId').val("");
							$('#address').val("");
							$('#state').val("");
							$('#city').val(""); 
							$('#reedem').val("");
							$('#zip').val("");
							$('#email').val("");
							$('#contact').val("");	
						}
						else if(json[0].Error_flag == 1)
						{
							alert("Please Provide Valid Company Key!!! ");
							
						}
						else if(json[0].Error_flag == 2)
						{
							alert("Please Provide valid membership id!!! ");
							$('#CardId').val("");
						}
						else if(json[0].Error_flag == 3)
						{
							alert("Insufficient Point Balance !!! ");
							$('#reedem').val("");
						}
						else if(json[0].Error_flag == 4)
						{
							alert("Equivalent Redeem Amount is More than Total Bill Amount");
							$('#reedem').val("");
						}
						else if(json[0].Error_flag == 5)
						{
							alert("Please Provide Valid Item Details !!");
							
						}
						else if(json[0].Error_flag == 6)
						{
							alert("Please Provide Shipping Address!!");
						}
						else if(json[0].Error_flag == 7)
						{
							alert("Please Provide valid Item Details Information");
						}
						else if(json[0].Error_flag == 8)
						{
							alert("E-Commerce Transaction Unsuccessful!!");
						}
						else if(json[0].Error_flag == 9)
						{
							alert("Please provide Card Info!!");
						}
						else if(json[0].Error_flag == 10)
						{
							alert("E-Commerce Transaction Unsuccessful--BrainTree Payment Failed Error--!!");
						}
					}
				});
		}	
	}
</script> 
<script>
$('#cod').click(function()
{
	$("#Card_no1").hide(); 
	$("#card_name1").hide();
	$("#Cvv1").hide();
	$("#valid1").hide();
});
</script>
<script>
$('#BrainTree').click(function()
{
	$("#Card_no1").show();  
	$("#card_name1").show();
	$("#Cvv1").show();
	$("#valid1").show();
});
</script>

<style>
	.menu-section 
	{
		display: none !important;
	}
</style>