<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/invoice_css/style.css" media="all" />
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="<?php echo base_url() . '' . $Company_details->Company_logo; ?>">
            </div>
            <h1>INVOICE: <?php echo $billing_bill_no; ?></h1>
            <div id="company" class="clearfix">
                <h3>FROM</h3>
                <div><?php echo $Company_details->Company_name; ?></div>
                <div><?php echo $Company_details->Company_address; ?>,<br /> <?php echo $Company_City_name; ?>,
                    <?php echo $Company_State_name; ?>,	<br /> 						
                    <?php echo $Company_Country_name; ?></div>
                <div><?php echo $Company_details->Company_primary_phone_no; ?></div>
                <div><a href="mailto:<?php echo $Company_details->Company_primary_email_id; ?>"><?php echo $Company_details->Company_primary_email_id; ?></a></div>
            </div>



            <div id="project" class="clearfix">
                <h3>BILL TO</h3>
                <div>M-<?php echo $seller_id; ?></div>
                <div><?php echo $Seller_name; ?></div>       
                <div><?php echo $Current_address; ?></div>
                <div><?php echo $City_name; ?>,<?php echo $State_name; ?>,<br /> <?php echo $Country_name; ?>-<?php echo $Zipcode; ?></div>
                <div><a href="mailto:<?php echo $User_email_id; ?>"><?php echo $User_email_id; ?></a></div>
                <div><?php echo $Phone_no; ?></div>


                <?php
                  // echo"----total_coins_issued-----".$total_coins_issued."---<br>";
                  $sub_total = ($total_coins_issued * $Seller_Billingratio);
                  $tax_amout = ($sub_total * $Merchant_sales_tax) / 100;
                  $total_grand_amt1 = $sub_total + $tax_amout;
                  $total_grand_amt = number_format($total_grand_amt1, 4);
                ?>
                <br>
                <div>Status:<?php if ($Settlement_flag == 1) { ?> <b style="color:green">PAID </b> <?php } else { ?><b style="color:red">UNPAID </b> <?php } ?></div>
                <div>Invoice Amount:  (<?php echo $Symbol_currency; ?>) <?php echo $total_grand_amt; ?> </div>       
                <div>Due Amount:  (<?php echo $Symbol_currency; ?>) <?php echo $total_grand_amt; ?> </div>  
                <div>Invoice Date:<?php echo date("j, F Y h:i:s A"); ?></div>

            </div>

        </header>
        <main>
            <table>
                <thead>
                    <tr>					
                        <th class="service">Sr. No.</th>
                        <th class="desc">DESCRIPTION</th>
                        <th>No. of <?php echo $Company_details->Currency_name; ?> Issued</th>
                        <th>Rate (<?php echo $Symbol_currency; ?>)</th>
                        <th>Amount (<?php echo $Symbol_currency; ?>)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>	 


                        <td class="service">1.</td>
                        <td class="desc">

                            Total Number of Transactions processed successfully(without errors): <?php echo $Total_row; ?> <br>
                            <?php /* ?>Total Number of Transaction : <?php echo $Total_row; ?> <br>

                                Total Number of Transactions processed successfully(without errors):<?php echo $Total_row; ?> <br>

                                Total Number of Transactions (with errors): <?php echo ($Total_row-$Success_row); */ ?>
                        </td>
                        <td class="unit"><?php echo round($total_coins_issued); ?></td>
                        <td class="qty"><?php echo $Seller_Billingratio; ?></td>
                        <td class="total"><?php
                            $sub_total = ($total_coins_issued * $Seller_Billingratio);
                            echo $sub_total;
                            ?></td>
                    </tr>		
                    <?php
                      // $tax_amout= ($sub_total*$Merchant_sales_tax)/100; 							
                      // $total_grand_amt= $sub_total+$tax_amout;
                      // $total_grand_amt1= $sub_total+$tax_amout;	
                      // $total_grand_amt= number_format((float)$total_grand_amt1, 4, '.', '');				
                    ?>




                    <tr>
                        <td colspan="4">SUBTOTAL</td>
                        <td class="total"><?php echo $sub_total; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">TAX (<?php echo round($Merchant_sales_tax); ?>%)</td>
                        <td class="total"><?php echo $tax_amout; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="grand total">GRAND TOTAL</td>
                        <td class="grand total"><?php echo $total_grand_amt; ?></td>
                    </tr>
                </tbody>
            </table>
            <div id="notices">
                <div>NOTICE:</div>
                <div class="notice">Please see attached Annexure for details of Successful records processed.</div>
                <div class="notice">If you have any questions about this invoice , please contact.</div>
                <div class="notice">Name:<?php echo $Company_primary_contact_person; ?>,Email:<?php echo $Company_contactus_email_id; ?>,Contact No:<?php echo $Company_primary_phone_no; ?></div>
            </div>
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.<br>Thank You for your Business.	  
        </footer>
    </body>
</html>