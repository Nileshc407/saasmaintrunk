		
		<?php 
		$this->load->view('header/header');
		if(($Logged_user_id == 2 && $Super_seller == 0) || $Logged_user_id == 5 || $Logged_user_id == 6 )//|| $Logged_user_id == 4
		{
		?>
        <div class="row">
			<div class="col-md-12">
				<input type="text" name="member_id" tabindex="1" id="member_id" value="" style="border: 0px solid white; color: #fff; outline: none;"/>
				<img src="<?php echo base_url()?>images/landing_page.png" class="img-responsive" style="margin: 0px auto;" />
			</div>
		</div>
<?php
}
else
{
?>
       <div class="content-i">
            <div class="content-box">
            
				<div class="row">
					<div class="col-sm-12">
					  <div class="element-wrapper">
						<h6 class="element-header">Upgrade Plan</h6>
					   
							  <div class="element-box-tp">
						  <div class="table-responsive">
						   <table class="table table-padded">
							  <thead>
							 
								<tr>
								 
								  <th class="text-center">
									Features
								  </th>
								  <th class="text-center">
									BASIC <span  class="smaller lighter"  style="font-size: 0.50rem;">(Free)</span>
								  </th>
								  <th class="text-center">
									STANDARD<br><span  class="smaller lighter" style="font-size: 0.50rem;">($XXX/month)</span>
								  </th>
								  
								 
								  <th class="text-center">
									ENHANCED<br><span  class="smaller lighter" style="font-size: 0.50rem;">($XXX/month)</span>
								  </th>
								 
								 
								 
								</tr>
							  </thead>
							  <tbody>
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Enrollments</a><br>
										 <span  class="smaller lighter">( Members enrolled in Tiers)</span>
										
									</td>
									<td class="text-center smaller lighter">
									Upto 100 members

									</td>
									<td class="text-center smaller lighter">
									Upto 5000 members


									</td>
									<td class="text-center smaller lighter">
									Upto 15000 members


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >CSV / Excel Data Upload</a><br>
										 <span  class="smaller lighter">( Enrollment and Transaction)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty Portal</a><br>
										 <span  class="smaller lighter">(  For Business and Members of Business)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty Campaigns</a><br>
										 <span  class="smaller lighter">(   Loyalty Rule, Referral Rule, Gift Cards, Offers (Stamps))</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Gamifications</a><br>
										 <span  class="smaller lighter">(  Promo Campaign, Auction Bidding)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Discounts</a><br>
										 <span  class="smaller lighter">(  Implement Discount Rules)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Personalization of Email Notifications</a><br>
										 <span  class="smaller lighter">(  Emails sent to Members can be customized with own design etc.)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Create Merchandizing Redemption Catalogue</a><br>
										 <span  class="smaller lighter">(Create own Merchandizing Catalogue Items to be made available for members to Redeem)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >eGifting Catalogue made available</a><br>
										 <span  class="smaller lighter">(E-Vouchers and E-Gift Cards from 12000 brands made available.
The value of those consumed by the members of the business will be billed to the Business at the End of Month)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Surveys</a><br>
										 <span  class="smaller lighter">(Create own Surveys and send to Customers and know your Promoters , Detractors and passive Customers)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty APP</a><br>
										 <span  class="smaller lighter">( Android and iOS APP for Members of the Business)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Basic Reporting</a><br>
										 <span  class="smaller lighter">( Dashboard, Enrollment Report, Transaction Report)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Enhanced Reporting & Segmentation</a><br>
										 <span  class="smaller lighter">( Basic Reporting + Segmentation Feature, Audit Tracking, Company Liability, High Value , Order Report etc.)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							 
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >API Integration</a><br>
										 <span  class="smaller lighter">( if the Business needs integration with any 3rd party System e.g. PoS, E-commerce etc. We make APIs available and help in integration)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							 
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Support & Help</a><br>
										 <span  class="smaller lighter">( Made available through Email and Chat )</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										&nbsp;
										
									</td>
									<td class="text-center smaller lighter">
									 <button class="btn btn-secondary" data-dismiss="modal" type="button">Subscribe</button>
									</td>
									<td class="text-center smaller lighter">
									 <button class="btn btn-secondary" data-dismiss="modal" type="button">Subscribe</button>
									</td>
									<td class="text-center smaller lighter">
									 <button class="btn btn-secondary" data-dismiss="modal" type="button">Subscribe</button>

									</td>
											  
								</tr>
							
							  
							  </tbody>
							</table>
						  </div>
						</div>
					  
						 
						</div>
						</div>
					  
					
					  
					  
					  </div>
			   
					 
            </div>
        </div>

<html>  			  
			  
	<?php 
}
		$this->load->view('header/footer');
	?>
	
<script>
	/**********************************Order Type************************************/
		<?php   if($Transaction_Order_Types_graph_flag==1){?>
		$("select#Order_type").val('6');
		$("select#Order_type2").val('6');
		var myObj22 = JSON.parse('<?php echo $purchase_count; ?>');
		var smry_monthArr = new Array();
		var Delivery_countArr = new Array();
		var Delivery_valueArr = new Array();
		var Pickup_countArr = new Array();
		var Pickup_valueArr = new Array();
		var Instore_countArr = new Array();
		var Instore_valueArr = new Array();
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Delivery_count== null){myObj22[x].Delivery_count=0;}
		  if(myObj22[x].Delivery_value== null){myObj22[x].Delivery_value=0;}
		  if(myObj22[x].Pickup_count== null){myObj22[x].Pickup_count=0;}
		  if(myObj22[x].Pickup_value== null){myObj22[x].Pickup_value=0;}
		  if(myObj22[x].Instore_value== null){myObj22[x].Instore_value=0;}
		  
		  Delivery_countArr.push(myObj22[x].Delivery_count);
		  Delivery_valueArr.push(myObj22[x].Delivery_value);
		  Pickup_countArr.push(myObj22[x].Pickup_count);
		  Pickup_valueArr.push(myObj22[x].Pickup_value);
		  Instore_countArr.push(myObj22[x].Instore_count);
		  Instore_valueArr.push(myObj22[x].Instore_value);
		} 
		get_trans_order_type(6);
		function get_trans_order_type(val)
		{
			
           if(val==9)
			{ 
				var ctx32 = document.getElementById("canvas111").getContext("2d");
				$("#canvas111").show();
				$("#canvas211").hide();
				$("#canvas311").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx32 = document.getElementById("canvas211").getContext("2d");
				$("#canvas111").hide();
				$("#canvas211").show();
				$("#canvas311").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx32 = document.getElementById("canvas311").getContext("2d");
				$("#canvas111").hide();
				$("#canvas211").hide();
				$("#canvas311").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config31 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Pick-up Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Pickup_countArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "In-Store Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Instore_countArr.slice(start_rec, smry_monthArr.length),
						}, 
						{
							label: "Delivery Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Delivery_countArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx32, config31);
		}
      
		get_trans_order_type2(6);
		function get_trans_order_type2(val)
		{
			
           if(val==9)
			{ 
				var ctx321 = document.getElementById("canvas1111").getContext("2d");
				$("#canvas1111").show();
				$("#canvas2111").hide();
				$("#canvas3111").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx321 = document.getElementById("canvas2111").getContext("2d");
				$("#canvas1111").hide();
				$("#canvas2111").show();
				$("#canvas3111").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx321 = document.getElementById("canvas3111").getContext("2d");
				$("#canvas1111").hide();
				$("#canvas2111").hide();
				$("#canvas3111").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config311 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Pick-up Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Pickup_valueArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "In-Store Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Instore_valueArr.slice(start_rec, smry_monthArr.length),
						}, 
						{
							label: "Delivery Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Delivery_valueArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx321, config311);
		}
      
	
		
		/**********************************POS ONLINE GRAPH************************************/
		
		$("select#pos_select").val('6');
		$("select#pos_select2").val('6');
		var myObj22 = JSON.parse('<?php echo $POS_online_count; ?>');
		var smry_monthArr = new Array();
		var Trans_count_posArr = new Array();
		var Trans_count_onlineArr = new Array();
		var Trans_count_thirdpartyArr = new Array();
		var Total_purchase_posArr = new Array();
		var Total_purchase_onlineArr = new Array();
		var Total_purchase_thirdpartyArr = new Array();
		
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Trans_count_posArr== null){myObj22[x].Trans_count_posArr=0;}
		  if(myObj22[x].Trans_count_onlineArr== null){myObj22[x].Trans_count_onlineArr=0;}
		  if(myObj22[x].Trans_count_thirdpartyArr== null){myObj22[x].Trans_count_thirdpartyArr=0;}
		  if(myObj22[x].Total_purchase_posArr== null){myObj22[x].Total_purchase_posArr=0;}
		  if(myObj22[x].Total_purchase_onlineArr== null){myObj22[x].Total_purchase_onlineArr=0;}
		  if(myObj22[x].Total_purchase_thirdpartyArr== null){myObj22[x].Total_purchase_thirdpartyArr=0;}
		  
		  Trans_count_posArr.push(myObj22[x].Trans_count_pos);
		  Trans_count_onlineArr.push(myObj22[x].Trans_count_online);
		  Trans_count_thirdpartyArr.push(myObj22[x].Trans_count_thirdparty);
		  Total_purchase_posArr.push(myObj22[x].Total_purchase_pos); 
		  Total_purchase_onlineArr.push(myObj22[x].Total_purchase_online);
		  Total_purchase_thirdpartyArr.push(myObj22[x].Total_purchase_thirdparty);
		} 
		get_pos_online_trans(6);
		function get_pos_online_trans(val)
		{
			
           if(val==9)
			{ 
				var ctx329 = document.getElementById("canvas1119").getContext("2d");
				$("#canvas1119").show();
				$("#canvas2119").hide();
				$("#canvas3119").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx329 = document.getElementById("canvas2119").getContext("2d");
				$("#canvas1119").hide();
				$("#canvas2119").show();
				$("#canvas3119").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx329 = document.getElementById("canvas3119").getContext("2d");
				$("#canvas1119").hide();
				$("#canvas2119").hide();
				$("#canvas3119").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config319 = {
					type: 'line',  
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "POS",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Trans_count_posArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Online",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Trans_count_onlineArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "3rd Party",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Trans_count_thirdpartyArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Count'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx329, config319);
		}
      
		get_pos_online_trans2(6);
		function get_pos_online_trans2(val)
		{
			
           if(val==9)
			{ 
				var ctx3299 = document.getElementById("canvas11199").getContext("2d");
				$("#canvas11199").show();
				$("#canvas21199").hide();
				$("#canvas31199").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx3299 = document.getElementById("canvas21199").getContext("2d");
				$("#canvas11199").hide();
				$("#canvas21199").show();
				$("#canvas31199").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx3299 = document.getElementById("canvas31199").getContext("2d");
				$("#canvas11199").hide();
				$("#canvas21199").hide();
				$("#canvas31199").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config3199 = {
					type: 'line',  
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),  
						datasets: [{
							label: "POS",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_purchase_posArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Online",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_purchase_onlineArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "3rd Party",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Total_purchase_thirdpartyArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx3299, config3199);
		}
      
		<?php } ?>
/****************************Line chart start**********************************************************/
<?php   if($Member_enrollments_graph_flag==1){?>
	get_enrollment_line_graph(6);
	function get_enrollment_line_graph(enr_val)
	{
			var myObj = JSON.parse('<?php echo $Enrollment_data; ?>');
			var smry_monthArr = new Array();
			var Total_enrollmentsArr = new Array();
		
			for (x in myObj) {
			  smry_monthArr.push(myObj[x].smry_month);
			  Total_enrollmentsArr.push(myObj[x].Total_enrollments);
			}
			
			if(enr_val==6)
			{ 
				var lineChart11 = $("#lineChart_sixmonth");
				$("#lineChart_sixmonth").show();
				$("#lineChart_1year").hide();
				$("#lineChart_3month").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
				
			}
			if(enr_val==0)
			{ 
				var lineChart11 = $("#lineChart_1year");
				$("#lineChart_1year").show();
				$("#lineChart_sixmonth").hide();
				$("#lineChart_3month").hide();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(enr_val==9)
			{ 
				var lineChart11 = $("#lineChart_3month");
				$("#lineChart_3month").show();
				$("#lineChart_1year").hide();
				$("#lineChart_sixmonth").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
				var lineData11 = {
				labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
				datasets: [{
				  label: "Enrolled Member",
				  fill: false,
				  lineTension: 0.3,
				  backgroundColor: "#fff",
				  borderColor: "#047bf8",
				  borderCapStyle: 'butt',
				  borderDash: [],
				  borderDashOffset: 0.0,
				  borderJoinStyle: 'miter',
				  pointBorderColor: "#fff",
				  pointBackgroundColor: "#141E41",
				  pointBorderWidth: 3,
				  pointHoverRadius: 10,
				  pointHoverBackgroundColor: "#FC2055",
				  pointHoverBorderColor: "#fff",
				  pointHoverBorderWidth: 3,
				  pointRadius: 5,
				  pointHitRadius: 10,
				  data: Total_enrollmentsArr.slice(start_rec, smry_monthArr.length),
				  spanGaps: false
				}]
				};
				
			var numbers =Total_enrollmentsArr.slice(start_rec, smry_monthArr.length);
			document.getElementById("Total_enrollments").innerHTML=numbers.reduce(function getSum(total, num) {
			  return total + Math.round(num);}, 0);
			  
			var count =   document.getElementById("Total_enrollments").innerHTML;
			
			var myLineChart = new Chart(lineChart11, {
			type: 'line',
			data: lineData11,
			options: {
			  legend: {
				display: false
			  },
			  scales: {
				xAxes: [{
				  ticks: {
					fontSize: '11',
					fontColor: '#969da5'
				  },
				  gridLines: {
					color: 'rgba(0,0,0,0.05)',
					zeroLineColor: 'rgba(0,0,0,0.05)'
				  }
				}],
				yAxes: [{
				  display: false,
				  ticks: {
					beginAtZero: true,
					max: parseInt(count)
				  }
				}]
			  }
			}
		  });
		
	}
	
<?php } ?>
	
/****************************Line chart finish**********************************************************/
 <?php   if(($Total_point_issued_Vs_total_points_redeemed_graph_flag==1) & ($No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag==1)){ ?>
		/****************Select index 6 Months onload***************************/
		$("select#points_stats").val('6');
		$("select#trans_stats").val('6');
		
		
		/*********************************************************/
		
		/**********************************POINTS STATISTICS************************************/
		var myObj22 = JSON.parse('<?php echo $Trans_data; ?>');
		var smry_monthArr = new Array();
		var Total_loyalty_pointsArr = new Array();
		var Total_redeem_pointsArr = new Array();
		var Total_loyalty_countArr = new Array();
		var Total_redeem_countArr = new Array();
		var Total_online_purchase_countArr = new Array();
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Total_loyalty_points== null){myObj22[x].Total_loyalty_points=0;}
		  if(myObj22[x].Total_redeem_points== null){myObj22[x].Total_redeem_points=0;}
		  if(myObj22[x].Total_loyalty_count== null){myObj22[x].Total_loyalty_count=0;}
		  if(myObj22[x].Total_redeem_count== null){myObj22[x].Total_redeem_count=0;}
		  if(myObj22[x].Total_online_purchase_count== null){myObj22[x].Total_online_purchase_count=0;}
		  
		  Total_loyalty_pointsArr.push(myObj22[x].Total_loyalty_points);
		  Total_redeem_pointsArr.push(myObj22[x].Total_redeem_points);
		  Total_loyalty_countArr.push(myObj22[x].Total_loyalty_count);
		  Total_redeem_countArr.push(myObj22[x].Total_redeem_count);
		  Total_online_purchase_countArr.push(myObj22[x].Total_online_purchase_count);
		} 
		get_points_stats_line_graph(6);
		function get_points_stats_line_graph(val)
		{
			
           if(val==9)
			{ 
				var ctx = document.getElementById("canvas1").getContext("2d");
				$("#canvas1").show();
				$("#canvas2").hide();
				$("#canvas3").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx = document.getElementById("canvas2").getContext("2d");
				$("#canvas1").hide();
				$("#canvas2").show();
				$("#canvas3").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx = document.getElementById("canvas3").getContext("2d");
				$("#canvas1").hide();
				$("#canvas2").hide();
				$("#canvas3").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config3 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Total Points Issued",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_loyalty_pointsArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Total Points Redeemed",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_redeem_pointsArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx, config3);
		}
      
	
		get_trans_line_graph(6);
		function get_trans_line_graph(val)
		{
				
			//var val = $('#trans_stats').val();
		
           if(val==9)
			{ 
				var ctx2 = document.getElementById("canvas4").getContext("2d");
				$("#canvas4").show();
				$("#canvas5").hide();
				$("#canvas6").hide();
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx2 = document.getElementById("canvas5").getContext("2d");
				$("#canvas4").hide();
				$("#canvas5").show();
				$("#canvas6").hide();
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx2 = document.getElementById("canvas6").getContext("2d");
				$("#canvas4").hide();
				$("#canvas5").hide();
				$("#canvas6").show();
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
		
			
				var config1 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Total Loyalty Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_loyalty_countArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Total Redeem Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_redeem_countArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "Total Online Purchase Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Total_online_purchase_countArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};	
				window.myLine = new Chart(ctx2, config1);	
			
		}
	
	
		<?php } ?>
/****************************donutChart start**********************************************************/
<?php if($Active_Vs_inactive_member_graph_flag==1){?>
    if ($("#donutChart11").length) {
      var donutChart11 = $("#donutChart11");

      // donut chart data
      var data1 = {
        labels: ["Total Inactive Members", "Total Active Members"],
        datasets: [{
          data: [<?php echo $Total_inactive_members; ?>, <?php echo $Total_active_members; ?>],
          backgroundColor: ["#f37070", "#4ecc48"],
          hoverBackgroundColor: ["#e65252", "#24b314"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart11, {
        type: 'doughnut',
        data: data1,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }
<?php } ?>
		// -------------------------SURVEY ANALYSIS------------------------------------------------------------
	
	//var myObj = ; //alert(a);


/****************************donutChart finish**********************************************************/



	
	/***************************ITEMS ISSUED VS USED****************************************************/
<?php   if($Total_quantity_issued_Vs_total_quantity_used_graph_flag==1){?>	

	$("select#item_issued_used").val('6');
	$("select#item_order").val('6');
	
	var myObj = JSON.parse('<?php echo $MERCHANDIZING_SNAPSHOT; ?>');
	var smry_monthArr = new Array();
	var Total_issued_quantityArr = new Array();
	var Total_used_quantityArr = new Array();
	var Ordered_quantityArr = new Array();
	var Delivered_quantityArr = new Array();
	var BalanceArr_pick = new Array();
	var BalanceArr_deli = new Array();

	for (x in myObj) {
	  smry_monthArr.push(myObj[x].smry_month);
	  Total_issued_quantityArr.push(myObj[x].Total_issued_quantity);
	  Total_used_quantityArr.push(myObj[x].Total_used_quantity);
	  Ordered_quantityArr.push(myObj[x].Ordered_quantity);
	  Delivered_quantityArr.push(myObj[x].Delivered_quantity);
	  
	  BalanceArr_pick.push(myObj[x].Total_issued_quantity-myObj[x].Total_used_quantity);
	  BalanceArr_deli.push(myObj[x].Ordered_quantity-myObj[x].Delivered_quantity);
	}
	
	get_items_issued_used_qty(6)
	function get_items_issued_used_qty(val)
	{
			//var val = $('#item_issued_used').val();
			
           if(val==9)
			{ 
				$("#canvas7").show();
				$("#canvas8").hide();
				$("#canvas9").hide();
				var ctx77 = document.getElementById("canvas7").getContext("2d");
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				$("#canvas7").hide();
				$("#canvas8").show();
				$("#canvas9").hide();
				var ctx77 = document.getElementById("canvas8").getContext("2d");
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				$("#canvas7").hide();
				$("#canvas8").hide();
				$("#canvas9").show();
				var ctx77 = document.getElementById("canvas9").getContext("2d");
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			} 
		
			var barChartData = {
			labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
			datasets: [{
				type: 'line',
				label: 'Balance',
				borderColor: window.chartColors.blue,
				borderWidth: 2,
				fill: false,
				data: BalanceArr_pick.slice(start_rec, smry_monthArr.length)
			},{
				label: 'Total Issued',
				backgroundColor: ["#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070","#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070"],
				hoverBackgroundColor: ["#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252","#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252"],
				
				stack: 'Stack 0',
				data: Total_issued_quantityArr.slice(start_rec, smry_monthArr.length)
			}, {
				label: 'Total Used',
				backgroundColor: ["#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48","#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48"],
				hoverBackgroundColor: ["#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314","#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314"],
				stack: 'Stack 0',
				data: Total_used_quantityArr.slice(start_rec, smry_monthArr.length)
			}]

		};
				
            window.myBar = new Chart(ctx77, {
                type: 'bar',
                data: barChartData,
                options: {
                    title:{
                        display:true,
						text: 'Pick Up Items'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
					legend: {
							position: 'bottom',
						},
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
		
	}	
		
	get_items_ordered_deliv_qty(6);	
	 function get_items_ordered_deliv_qty(val)
	{
			 if(val==9)
			{ 
				$("#canvas10").show();
				$("#canvas11").hide();
				$("#canvas12").hide();
				
				var ctx78 = document.getElementById("canvas10").getContext("2d");
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				$("#canvas10").hide();
				$("#canvas11").show();
				$("#canvas12").hide();
				
				var ctx78 = document.getElementById("canvas11").getContext("2d");
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				$("#canvas10").hide();
				$("#canvas11").hide();
				$("#canvas12").show();
				
				var ctx78 = document.getElementById("canvas12").getContext("2d");
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var barChartData2 = {
					labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
					datasets: [{
						type: 'line',
						label: 'Balance',
						borderColor: window.chartColors.blue,
						borderWidth: 2,
						fill: false,
						data: BalanceArr_deli.slice(start_rec, smry_monthArr.length)
					}, {
						label: 'Total Ordered',
						backgroundColor: ["#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070","#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070"],
						hoverBackgroundColor: ["#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252","#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252"],
						stack: 'Stack 0',
						data: Ordered_quantityArr.slice(start_rec, smry_monthArr.length)
					}, {
						label: 'Total Delivered',
						backgroundColor: ["#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48","#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48"],
						hoverBackgroundColor: ["#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314","#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314"],
						stack: 'Stack 0',
						data: Delivered_quantityArr.slice(start_rec, smry_monthArr.length)
					}]

				};
			
			
            window.myBar = new Chart(ctx78, {
                type: 'bar',
                data: barChartData2,
                options: {
                    title:{
                        display:true,
						text: 'Delivery Items'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
					legend: {
							position: 'bottom'
							
						},
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
		
		}	
 
<?php } ?>
	/*******************************************************************************/	
		
    if ($("#donutChart3").length) {
      var donutChart3 = $("#donutChart3");
		 var Total_promoters = '<?php echo $Total_promoters_1; ?>';   
		var Total_passive = '<?php echo $Total_passive_1; ?>';   
		 var Total_dectractor = '<?php echo $Total_dectractor_1; ?>';   
		
	
      // donut chart data
      var data = {
        labels: ["Promoters", "Passive", "Dectractor"],
        datasets: [{
          data: [Total_promoters, Total_passive, Total_dectractor],
          backgroundColor: ["#4ecc48", "#ffb84d", "#f37070"],
          hoverBackgroundColor: ["#24b314", "#ffcc29", "#e65252"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart3, {
        type: 'doughnut',
        data: data,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }
	// -----------------
    if ($("#donutChart4").length) {
      var donutChart4 = $("#donutChart4");

      var Total_promoters2 = '<?php echo $Total_promoters_2; ?>';   
		var Total_passive2 = '<?php echo $Total_passive_2; ?>';   
		var Total_dectractor2 = '<?php echo $Total_dectractor_2; ?>';   
		
	
      // donut chart data
      var data = {
        labels: ["Promoters", "Passive", "Dectractor"],
        datasets: [{
          data: [Total_promoters2, Total_passive2, Total_dectractor2],
          backgroundColor: ["#4ecc48", "#ffb84d", "#f37070"],
          hoverBackgroundColor: ["#24b314", "#ffcc29", "#e65252"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart4, {
        type: 'doughnut',
        data: data,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }
	/***************************************************get_popular_category****************/
				
		get_menugroups_bargraph(6);
		$("select#Menu_group").val('6');
		
			
						
		function get_menugroups_bargraph(month)
		{
			// alert(month);
			var Company_id = '<?php echo $Company_id; ?>';
			for(var k=0;k<=20;k++)
				{
					$('#category_item_bar'+month+''+k).hide();
				}
			if(month==3)
			{
				$("#category_bar3").show();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
				
				 var ctx = document.getElementById("category_bar3").getContext("2d");
				
			}
			else if(month==6)
			{
				$("#category_bar3").hide();
				$("#category_bar6").show();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
				
				 var ctx = document.getElementById("category_bar6").getContext("2d");
			}
			else if(month==1)
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").show();
				$("#category_bar12").hide();
				
				
				 var ctx = document.getElementById("category_bar1").getContext("2d");
			}
			else 
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").show();
				
				
				 var ctx = document.getElementById("category_bar12").getContext("2d");
			}
				$.ajax({
					type:"POST",
					data:{ Company_id:Company_id, month:month},
					url: "<?php echo base_url()?>index.php/Home/get_menugroups_bargraph",
					success: function(data)
					{
						var Merchandize_category_nameArr = new Array();
						var Total_qtyArr = new Array();
						
						var popular_category = data.popular_category;
						var myObj2 = JSON.parse(popular_category);
						
					
						for (x in myObj2) {
						  Merchandize_category_nameArr.push(myObj2[x].Merchandize_category_name);
						  Total_qtyArr.push(myObj2[x].Total_qty);
						}  
						
						
						var barChartData = {
							labels: Merchandize_category_nameArr,
							datasets: [{
								label: 'Menu Groups',
								backgroundColor: window.chartColors.blue,
								borderColor: window.chartColors.blue,
								borderWidth: 1,
								data: Total_qtyArr
							}]

						};
						
						
						 // var ctx = document.getElementById("category_bar").getContext("2d");
							window.myBar = new Chart(ctx, {
								type: 'bar',
								 data: barChartData,
								options: {
									responsive: true,
									legend: {
										position: 'top',
									},
									title: {
										display: true,
									}
									,
									onClick: call_item,
									
								}
							});
					}
			});
			 
			
			
		}
		
		function call_item(c,i)
		{
					e = i[0];
					var Menu_group_month = $('#Menu_group').val();
					
					var index_category = e._index;
					var x_value = this.data.labels[e._index];
					var y_value = this.data.datasets[0].data[e._index];
					var Company_id = '<?php echo $Company_id; ?>';
				for(var k=0;k<=20;k++)
				{
					$('#category_item_bar'+Menu_group_month+''+k).hide();
				}		
				$('#category_item_bar'+Menu_group_month+''+index_category).show();
				
				 var ctx21 = document.getElementById('category_item_bar'+Menu_group_month+''+index_category).getContext("2d");	
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			
				
				$.ajax({
						type:"POST",
						data:{ Company_id:Company_id, Category:x_value,Menu_group_month:Menu_group_month},
						url: "<?php echo base_url()?>index.php/Home/Get_popular_category_items",
						success: function(data)
						{
								
							$('#Menu_group').hide();
							
							document.getElementById("back").style.display="";
							var Popular_category_items = data.Popular_category_items;
							/****************************************Get_popular_category_items****************/
							var myObj212 = JSON.parse(Popular_category_items);
							var Merchandize_category_nameArr21 = new Array();
							var Total_qtyArr21 = new Array();
							var Merchandize_item_nameArr = new Array();
							var count_qty = 0;
							for (x in myObj212) {
							  Merchandize_category_nameArr21.push(myObj212[x].Merchandize_category_name);
							  Total_qtyArr21.push(parseInt(myObj212[x].Total_qty));
							  Merchandize_item_nameArr.push(myObj212[x].Merchandize_item_name);
							  count_qty = parseInt(count_qty) + parseInt(myObj212[x].Total_qty);
							  
							}  
								
							 barChartData21 = {
								labels: Merchandize_item_nameArr,
								datasets: [{
									label: Merchandize_category_nameArr21[0]+'('+count_qty+')',
									backgroundColor: window.chartColors.blue,
									borderColor: window.chartColors.blue,
									borderWidth: 1,
									data: Total_qtyArr21
								}]

							};
							 // var ctx21 = document.getElementById("category_item_bar").getContext("2d");
								window.myBar21 = new Chart(ctx21, {
									type: 'bar',
									 data: barChartData21,
									options: {
										legend: {
											position: 'top',
										},
										title: {
											display: false,
										}
										 
								}
								});
									
						}				
						});
		
		
		}					

	   function Call_back()
	   {
		   var month = $('#Menu_group').val();
		   // alert('month '+month);
		     /*  $('html, body').animate({
					scrollTop: $("#myDiv").offset().top
				}, 2000);
				 */
			for(var k=0;k<=20;k++)
			{
				$('#category_item_bar'+month+''+k).hide();
			}
		   if(month==3)
			{
				$("#category_bar3").show();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			}
			else if(month==6)
			{
				$("#category_bar3").hide();
				$("#category_bar6").show();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			}
			else if(month==1)
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").show();
				$("#category_bar12").hide();
			}
			else 
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").show();
			}
			
		   document.getElementById('back').style.display='none';
		   $('#Menu_group').show();
	   }


    </script>
<script>

		
$('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
		//<?php echo number_format($Total_Gained_Points) ;?>
		
    });
	
</script>

	<style>
	.el-tablo .value
	{
		font-size: 1.43rem !important;
	}
	</style>
	
