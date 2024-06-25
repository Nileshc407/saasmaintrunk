<div class="form-group has-feedback" id="Beneficiary_company">
						<label for="exampleInputEmail1"> Select From Company</label>
						<select class="form-control" name="Beneficiary_company_id" id="Beneficiary_company_id"  onchange="Get_Beneficiary_Company_details(this.value);">
							<option value="">Select</option>
							<?php 
							foreach($Get_Beneficiary_Company as $rec)
							{
								if($Beneficiary_company_id!=$rec->Register_beneficiary_id)
								{
							?>
								<option value="<?php echo $rec->Register_beneficiary_id; ?>" ><?php echo $rec->Beneficiary_company_name; ?></option>
							<?php
								}
							}
							?>
						</select>
				</div>