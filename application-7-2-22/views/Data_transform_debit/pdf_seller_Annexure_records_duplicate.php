<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Duplicate Merchant Annexure </title>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/invoice_css/style.css" media="all" />
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
            <th class="qty">Cancelled Amount (<?php echo $Symbol_currency; ?>)</th>
            <th class="qty">Debited <?php echo $Company_details->Currency_name; ?></th>
          </tr>
        </thead>
        <tbody>
		
		<?php 
				
			$todays = date("Y-m-d");
			if($Annexure_Data != NULL)
			{							
				$i=1;	
				$tax_amout=0;
				$total_grand_amt=0;
				$Total_Loyalty_pts[]=array();
				foreach($Annexure_Data as $row)
				{
					if($row->Item_code == "") {
						$Bill_Item_Code="-";
					} else {  
						$Bill_Item_Code=$row->Item_code;
					}
					
					if($row->Quantity == 0) {
						$Bill_Quantity="-";
					} else {  
						$Bill_Quantity=$row->Quantity;
					}
					echo "<tr>";
						echo "<td class=\"qty\">".$i."</td>";	
						echo "<td class=\"service\">".date("j, F Y h:i:s A",strtotime($row->Trans_date))."</td>";	
						echo "<td class=\"service\">".$row->Bill_no."</td>";
						echo "<td class=\"service\">".$row->Card_id."</td>";
						echo "<td class=\"service\">".$Bill_Item_Code."</td>";									
						echo "<td class=\"qty\">".$Bill_Quantity."</td>";									
						echo "<td class=\"qty\">".$row->Purchase_amount."</td>";
						echo "<td class=\"qty\">".round($row->Loyalty_pts)."</td>";
						echo "</tr>";
				
					$i++;	
					$Total_Loyalty_pts[]=round($row->Loyalty_pts);			
				}
				echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td class=\"qty\">Total :</td>";
				echo "<td class=\"qty\">".array_sum($Total_Loyalty_pts)."</td>";
				echo "</tr>";
			}
			else{		
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