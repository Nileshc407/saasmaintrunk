<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>..:: JAVA HOUSE ::..</title>
  <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
</head>
<body>
<main style="padding-bottom: 5px;padding-top: 5px;">
	<div style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
		<div style="display: flex;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div style="position: relative;color: #333333;-webkit-box-flex: 0;flex: 0 0 100%;max-width: 100%;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;">
                <div style="position: relative;box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.10);padding: 10px 0px;border-radius: 8px;background: #fff;width: 100%;">
                    <div style="position: relative;text-align: center;margin: 0;padding: 15px 0px 5px;"><img src="$Logo"></div>
                    <hr style="border-top: 1px solid rgba(0, 0, 0, .1);margin-top: 1rem;margin-bottom: 1rem;">
                    <div style="position: relative;margin: 0;padding: 0 10px;">
                        <h2 style="font-size: 20px;padding-bottom: 15px;font-family: 'gothammedium';margin: 0;">Dear $Customer_name,</h2>
                        <div style="font-size: 14px;padding-bottom: 15px;color: #999999;">Congratulations !!!</div>
                        <ul style="position: relative;margin: 0;padding: 0;color: #333333;list-style:none;">
                            <li style="margin: 0 0 10px 0;padding: 0;display: flex;width: 100%;">You have received discount voucher</li>
                            <li style="margin: 0 0 10px 0;padding: 0;display: flex;width: 100%;color: #DB1E34;font-weight: bold;">$Voucher_no of <?php if($Reward_percent > 0){ ?>
					$Reward_percent (%)
				<?php } else { ?>
					worth $currency  $reward_amt
				<?php } ?>	</li>
                            <li style="margin: 0 0 10px 0;padding: 0;display: flex;width: 100%;">The voucher is valid upto <span style="margin-left: 15px;font-weight: bold;">$Valid_till.</span></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
		</div>
	</div>
</main>
<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>