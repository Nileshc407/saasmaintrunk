<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
	<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
	<title>Store Purchase</title>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Lato', sans-serif;background: linear-gradient(200.05deg, #943F4F 16.68%, #382638 73.29%), #E7ECF2;overflow-x: hidden;font-size: 15px;color: #030303;margin: 0px;">
	<div>
		<header style="text-align: center;">
			<img style="width: 160px;margin: 20px 0 10px 0;" src="$Logo" alt="">
		</header><br>
		<div style="background: #FFFFFF; border-radius: 36px 36px 0 0;">
			<div style="padding: 40px 25px 25px;">
				<h2 style="font-weight: 900; color: #030303; font-size: 20px; margin: 0 0 20px 0;">Store Purchase</h2>
				<h3 style="font-weight: 700; color: #86869d; font-size: 20px; margin: 0 0 15px 0;">Dear $Customer_name,</h3>
				<p style="font-weight: 600; font-size: 14px; margin:0 0 18px 0; color: #86869d; line-height: 24px;">Thank you for visiting our restaurant. Your Bill details:</p>
				<ul style="padding: 0;margin: 0;">
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Date :</span> $Transaction_date</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Order Type :</span> $Order_type</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Outlet :</span> $delivery_outlet</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Order No :</span> $Orderno</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Bill No: </span> $POS_bill_no</li>
				</ul>
				<div style="margin: 40px 0 20px 0; border-bottom: 1px solid #dbdbdb; padding-bottom: 15px;">
					<h3 style="font-weight: 700; color: #030303; font-size: 20px; margin: 0 0 15px 0;">Order Total :<span style="font-weight: normal;"> $Symbol_of_currency $subtotal</span></h3>
					
					<h5 style="font-weight: 700; color: #030303; font-size: 19px;margin: 0px;">$Company_Currency Earned :<span style="font-weight: normal;"> $total_loyalty_points</span></h5>
				</div>
				<ul style="padding: 0;margin: 0;">
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Total Due :</span> $Symbol_of_currency $grand_total</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Discount :</span> $Symbol_of_currency $discountVal</li>
					
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Redeem ($Cust_wish_redeem_point) $Company_Currency :</span> $Symbol_of_currency $EquiRedeem</li>
				
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Current $Company_Currency balance :</span> $Current_point_balance</li>
					<?php if($vouchers != Null) { ?>
					<li style="list-style: none; font-weight: 600; font-size: 14px; margin-bottom: 15px; color: #484848;"><span>Note <span style="color:red">* </span> : ($vouchers)</span> this discount vouchers are used</li>
					<?php } ?>
				</ul><br><br>
			</div>
		</div>
	</div>
</body>
</html>