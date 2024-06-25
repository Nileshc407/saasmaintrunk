<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Merchant Error File</title>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/invoice_css/style.css" media="all" />
  </head>
  <body>
     
     
     
    
    <main>
      <table >
        <thead>
          <tr>
				<th>Sr. No.</th>
				<th>Error Row No.</th>
				<th>Error Details</th>
				<th>Trans Date</th>
				<th>Bill No.</th>						
				<th>Membership Id</th>
				<th>Transaction amount</th>
          </tr>
        </thead>
        <tbody>
		
		<?php			
			if($file_error_details != NULL)
			{			
				
				$i=1;					
				foreach($file_error_details as $row)
				{
					

					// echo "----Transaction_date----".$row->Transaction_date."--<br>";
					if($row->Transaction_date=='0000-00-00 00:00:00'){

						$Transaction_date="";
						
					} else {									

						$Transaction_date= date('Y-m-d',strtotime($row->Transaction_date));
					}
					/* if($row->Transaction_date=='0.00'){

						$Transaction_date="";
						
					} else {									

						$Transaction_date= date('Y-m-d',strtotime($row->Transaction_date));
					} */
					
					// echo "----Transaction_date----".$Transaction_date."--<br>";

					
						echo "<tr>";
						echo "<td>".$i."</td>";	
						echo "<td>".$row->Error_row_no."</td>";	
						echo "<td>".$row->Error_in."</td>";								
						// echo "<td>".$Transaction_date."</td>";
						echo "<td>".$row->Error_transaction_date."</td>";
						echo "<td>".$row->Bill_no."</td>";									
						echo "<td>".$row->Card_id."</td>";
						echo "<td>".round($row->Transaction_amount)."</td>";
						echo "</tr>";
				
					$i++;
					
				}
			}
			else{
				
				echo "<tr>";
				echo "<td colspan=8 style=\"text-align:center\"> No Error Found In this File</td>";
				echo "</tr>";
				
			}
			?>	
        </tbody>
      </table>  
	</main>	  
  </body>
</html>
<style>
table td{
	    text-align: left !IMPORTANT;
}
</style>
