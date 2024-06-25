<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Purchased <?php echo $Currency; ?></title>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/invoice_css/style.css" media="all" />
  </head>
  
  
  
  <body>
    <main>
      <table>
        <thead>
          <tr>
            <th class="qty">Sr. No.</th>
            <th class="service">Transaction Date</th>
			 <th class="qty">Bill No.</th>
            <th class="service">Membership ID</th>          
            <th class="service">Member Name</th>          
            <th class="qty">Purchased <?php echo $Currency; ?></th>
           
            <th class="qty">Status</th>
            <th class="qty">Remarks</th>
          </tr>
        </thead>
        <tbody>
		
		<?php 
				
			$todays = date("Y-m-d");
			if($publisher_transaction != NULL)
			{							
				$i=1;	
				
				foreach($publisher_transaction as $row)
				{
					echo "<tr>";
					echo "<td class=\"qty\">".$i."</td>";	
					echo "<td class=\"service\">".date("j, F Y h:i:s A",strtotime($row->Transaction_date))."</td>";	
					echo "<td class=\"qty\">".$row->Pos_Billno."</td>";
					echo "<td class=\"service\">".$row->Customerno."</td>";								
					echo "<td class=\"service\">".$row->Customer_name."</td>";								
					echo "<td class=\"qty\">".round($row->Purchased_miles)."</td>";
					echo "<td class=\"qty\">".$row->Status."</td>";
					echo "<td class=\"qty\">".$row->Remarks."</td>";
					echo "</tr>";
				
					$i++;								
				}
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
