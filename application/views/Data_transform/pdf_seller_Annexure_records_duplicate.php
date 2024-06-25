<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Duplicate Merchant Annexure </title>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/invoice_css/style.css" media="all" />
    </head>
    <body>




        <main>
            <table>
                <thead>
                    <tr>
                        <th class="qty">Sr. No.</th>
                        <th class="service">Transaction Date</th>
                        <th class="service">Bill No.</th>
                        <th class="service">Membership ID</th>
                        <th class="service">Item</th>
                        <th class="qty">QTY</th>
                        <th class="qty">Transaction Amount (<?php echo $Symbol_currency; ?>)</th>
                        <th class="qty">Gained <?php echo $Company_details->Currency_name; ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                       $loylty_points=array();
                       $topup_points=array();
                       $toatl_loylty_points=0;
                      $todays = date("Y-m-d");
                      if ($Annexure_Data != NULL) {
                        $i = 1;
                        $tax_amout = 0;
                        $total_grand_amt = 0;
                        $total_issue_points=0;

                        foreach ($Annexure_Data as $row) {
                           $loylty_points[]=$row->Loyalty_pts;
                           $topup_points[]=$row->Topup_amount;
                           
                          if ($row->Item_code == "") {
                            $Bill_Item_Code = "-";
                          } else {
                            $Bill_Item_Code = $row->Item_code;
                          }

                          if ($row->Quantity == 0) {
                            $Bill_Quantity = "-";
                          } else {
                            $Bill_Quantity = $row->Quantity;
                          }
                          
                          $total_issue_points= round($row->Loyalty_pts) + round($row->Topup_amount);
                          
                          echo "<tr>";
                          echo "<td class=\"qty\">" . $i . "</td>";
                          echo "<td class=\"service\">" . date("j, F Y h:i:s A", strtotime($row->Trans_date)) . "</td>";
                          echo "<td class=\"service\">" . $row->Manual_billno . "</td>";
                          echo "<td class=\"service\">" . $row->Card_id . "</td>";
                          echo "<td class=\"service\">" . $Bill_Item_Code . "</td>";
                          echo "<td class=\"qty\">" . $Bill_Quantity . "</td>";
                          echo "<td class=\"qty\">" . $row->Purchase_amount . "</td>";
                          echo "<td class=\"qty\">" . $total_issue_points. "</td>";
                          echo "</tr>";

                          $i++;
                        }
                        
                        $toatl_loylty_points=round(array_sum($loylty_points))+round(array_sum($topup_points));
                        
                         echo "<tr>";
                          echo "<td class=\"qty\"></td>";
                          echo "<td class=\"service\"></td>";
                          echo "<td class=\"service\"></td>";
                          echo "<td class=\"service\"></td>";
                          echo "<td class=\"qty\"></td>";
                          echo "<td class=\"qty\"></td>";
                          echo "<td class=\"qty\">Total</td>";
                          echo "<td class=\"qty\">" . $toatl_loylty_points. "</td>";
                          echo "</tr>";
                          
                          
                      } else {

                        echo "<tr>";
                        echo "<td colspan=8 style=\"text-align:center\"> No Record Found</td>";
                        echo "</tr>";
                      }
                    ?>	



                </tbody>
            </table>  
        </main>	  
    </body>
</html>