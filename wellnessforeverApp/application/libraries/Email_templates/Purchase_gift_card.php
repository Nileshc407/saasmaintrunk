<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Personal Details</title>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Lato', sans-serif;background: linear-gradient(200.05deg, #943F4F 16.68%, #382638 73.29%), #E7ECF2;overflow-x: hidden;font-size: 15px;color: #030303;margin: 0px;">

	<div>
		<header style="text-align: center;">
			<img style="width: 160px;margin: 20px 0 10px 0;" src="images/logo.png" alt="">
		</header><br>
		<div style="background: #FFFFFF; border-radius: 36px 36px 0 0; min-height: 450px;">
			<div style="padding: 40px 25px 25px;">
				<h3 style="font-weight: 700; color: #86869d; font-size: 20px; margin: 0 0 15px 0;">Dear $Customer_name,</h3>
				<p style="font-weight: 600; font-size: 14px; margin:0 0 18px 0; color: #86869d; line-height: 24px;">Thank You for purchasing the gift card.</p>
				<p style="font-weight: 600; font-size: 14px; margin:0 0 18px 0; color: #86869d; line-height: 24px;">Please find below the details of your gift card.</p>
				<p style="font-weight: 600; font-size: 14px; margin:0 0 18px 0; color: #86869d; line-height: 24px;">Date: $Transaction_date
				<br>Order No: $Bill_no</p>
				<table style="margin: 30px 0 30px 0; font-size: 13px; display: block; width: 100%; color: #030303; border: 1px solid #dee2e6;">
					<tbody>
						<tr>
						  <th style="padding: 0.75rem; text-align: left; border-bottom: 1px solid #dee2e6; border-right: 1px solid #dee2e6;" scope="row">Gift Gift Card No.</th>
						  <td style="padding: 0.75rem; font-weight: 600; border-bottom: 1px solid #dee2e6;">$GiftCardNo</td>
						</tr>
						<tr>
						  <th style="padding: 0.75rem; text-align: left; border-bottom: 1px solid #dee2e6;border-right: 1px solid #dee2e6;" scope="row">Gift Amount ($Symbol_currency)</th>
						  <td style="padding: 0.75rem; font-weight: 600; border-bottom: 1px solid #dee2e6;">$GiftCard_balance</td>
						</tr>
						<tr>
						  <th style="padding: 0.75rem; text-align: left;border-right: 1px solid #dee2e6;" scope="row">Valid Till</th>
						  <td style="padding: 0.75rem; font-weight: 600;">$Valid_till</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>  
</body>
</html>