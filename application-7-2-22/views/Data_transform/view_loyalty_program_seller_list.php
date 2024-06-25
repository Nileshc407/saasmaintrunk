	<div class="form-group"  id="seller_loyalty_list">
		<label for="exampleInputEmail1"><span class="required_info">*</span>Below LOYALTY RULE will be apply on this transaction</label>
		<abbr title="Below LOYALTY RULE will be apply on this transaction.">
					<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>									
		</abbr>
		
		<!--<select required class="form-control" name="lp_rules"  id="lp_rules" onchange="loyalty_program_info(this.value);" multiple readonly>-->
		<select  class="form-control" name="lp_rules[]"  id="lp_rules"  multiple>
			
			
			<?php
				$today = date("Y-m-d");
				foreach($lp_array as $lp)
				{
					// if(($today >= $lp->From_date && $today <= $lp->Till_date) && ($lp->Flat_file_flag==1))
					if($today >= $lp->From_date && $today <= $lp->Till_date)
					{
						echo "<option value='".$lp->Loyalty_name."' selected >".$lp->Loyalty_name."</option>";
					}
					
				}
			?>
		</select>
		
		 
		<!--<input type="hidden" name="lp_rules"  id="lp_rules" value="<?php echo $Loyalty_name; ?>">-->
	</div>