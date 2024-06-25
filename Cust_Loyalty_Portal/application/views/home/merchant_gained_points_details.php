<script src="<?php echo $this->config->item('base_url2') ?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>

<?php
  if ($MerchantGainedPoints != NULL) {
    ?>

    <table  class="table table-bordered table-hover" id="detail_myModal" style="width:90%;" align="center">

        <thead>
        <h4 class="modal-title"  align="center"><?php echo $this->lang->line('Merchant Transaction Summary'); ?></h4>
    </thead>
    <thead>
        <tr>                         
            <th><?php echo $this->lang->line('Merchant Name'); ?></th>
            <th><?php echo $this->lang->line('Current Balance'); ?> (<?php echo $Company_details->Currency_name; ?>) </th>
            <th><?php echo $this->lang->line('Total Purchase'); ?> (<?php echo $Symbol_currency; ?>)</th>
            <th><?php echo $this->lang->line('Total Gained'); ?> (<?php echo $Company_details->Currency_name; ?>)</th>
            <th><?php echo $this->lang->line('Total Redeemed'); ?> (<?php echo $Company_details->Currency_name; ?>)</th>
            <th><?php echo $this->lang->line('Total Bonus'); ?> (<?php echo $Company_details->Currency_name; ?>)</th>
           <th><?php echo $this->lang->line('Total Debit'); ?> (<?php echo $Company_details->Currency_name; ?>)</th>
           <th><?php echo $this->lang->line('Total Block'); ?> (<?php echo $Company_details->Currency_name; ?>)</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $Total_Seller_total_gain_points = array();
        $Total_Seller_total_redeem = array();
        $Total_Seller_total_topup = array();
        $Total_Seller_total_purchase = array();
        $Total_Cust_seller_balance_points = array();
         $Total_Seller_debit_points=array();
          $Total_Seller_total_block=array();
        foreach ($MerchantGainedPoints as $points_details) {
          
          $mercahnt_name = $points_details['First_name'] . ' ' . $points_details['Last_name'];

          $Cust_seller_balance=round($points_details['Cust_seller_balance']-($points_details['Cust_block_points'] + $points_details['Cust_debit_points']));
          
          echo "<tr>
                    <td>" . $mercahnt_name . "</td>					
                    <td>" .$Cust_seller_balance . "</td>
                    <td>" . round($points_details['Seller_total_purchase']) . "</td>
                    <td>" . round($points_details['Seller_total_gain_points']) . "</td>
                    <td>" . round($points_details['Seller_total_redeem']) . "</td>
                    <td>" . round($points_details['Seller_total_topup']) . "</td>
                    <td>" . round($points_details['Cust_debit_points']) . "</td>
                    <td>" . round($points_details['Cust_block_points']) . "</td>
					
              </tr>";
          $Total_Cust_seller_balance_points[] = $Cust_seller_balance;
          $Total_Seller_total_gain_points[] = $points_details['Seller_total_gain_points'];
          $Total_Seller_total_redeem[] = $points_details['Seller_total_redeem'];
          $Total_Seller_total_topup[] = $points_details['Seller_total_topup'];
          $Total_Seller_total_purchase[] = $points_details['Seller_total_purchase'];
          $Total_Seller_debit_points[]=$points_details['Cust_debit_points'];
          $Total_Seller_total_block[]=$points_details['Cust_block_points'];
        }
        $Total_Cust_seller_balance_points1 = array_sum($Total_Cust_seller_balance_points);
        $Total_Seller_total_gain_points1 = array_sum($Total_Seller_total_gain_points);
        $Total_Seller_total_redeem1 = array_sum($Total_Seller_total_redeem);
        $Total_Seller_total_topup1 = array_sum($Total_Seller_total_topup);
         $Total_Seller_debit_points1=array_sum($Total_Seller_debit_points);
         $Total_Seller_total_block1=array_sum($Total_Seller_total_block);
          $Total_Seller_total_purchase1 = array_sum($Total_Seller_total_purchase);
         
         $Merchant_available_balance=$Total_Cust_seller_balance_points1-($Total_Seller_debit_points1 + $Total_Seller_total_block1);
        
       
        echo "<tr colsapn='6' >
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                  <td>".$this->lang->line('Total')."</td>	
                  <td>" . $Total_Cust_seller_balance_points1 . "</td>	
                  <td>" . $Total_Seller_total_purchase1 . "</td>	
                  <td>" . $Total_Seller_total_gain_points1 . "</td>	
                  <td>" . $Total_Seller_total_redeem1 . "</td>	
                  <td>" . $Total_Seller_total_topup1 . "</td>	
                  <td>" . $Total_Seller_debit_points1 . "</td>	
                  <td>" . $Total_Seller_total_block1 . "</td>	
              </tr>";
        
        ?>
    </tbody>
    </table>
        <?php
      } else {
        ?>
    <div class="progress-bar" style="width: 100%;height:10%"><span class="info-box-number" >You haven't any current balance at merchant </span></div>
    <?php
  }
?>
	



