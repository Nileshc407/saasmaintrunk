 <?php $this->load->view('header/header');?> 
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Cust_home/survey');	?>
        <section class="content-header">
          <h1>
           Terms and conditions
          </h1>
         
        </section>

		<?php
			if(@$this->session->flashdata('survey'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('survey'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}	
			?>
			<form action="#" method="post">
			
        <!-- Main content -->
        <section class="content">		
			<div class="row">
                <div class="col-md-12">
						<p style="margin: 0 0 10px 60px;">Your Privileges Card features a membership number and an expiry date.</p>
						 <p style="margin: 0 0 10px 60px;">Your card is non transferable and participating venues reserve the right to see other documents like Driver's license or Registration certificate of the particular Vehicle, etc.  to verify as you are the person to whom the card was originally issued.</p>
						<p style="margin: 0 0 10px 60px;">Your card is invalid if the date is not evident, or is tampered in any manner.</p>
						 <p style="margin: 0 0 10px 60px;">If your card is lost or damaged, an alternate Privilege card will be issued to you as a replacement on the current value of the card i.e. 200 INR as on date.</p>	
						<h4 class="modal-title">Other Terms & Conditions</h4>
						<p style="margin: 0 0 10px 60px;">i. &nbsp;&nbsp; Cannot be used in conjunction with any other special discount offer, or customer loyalty/reward program</p>
						<p style="margin: 0 0 10px 60px;">ii.&nbsp;&nbsp; Is only valid for accessories and services purchased directly from World-class Automobiles and Atrica Automobiles, and not through any third party.</p>
						<p style="margin: 0 0 10px 60px;">iii.	&nbsp;&nbsp;Cannot be used to generate benefits redeemable for cash or for credits towards other goods or services</p>
						<p style="margin: 0 0 10px 60px;">iv.&nbsp;&nbsp;	Can be used at World-class Automobiles and Atrica Automobiles as often as you like, unless otherwise specified, during its validity period.</p>
						<p style="margin: 0 0 10px 60px;">v.&nbsp;&nbsp;	Can cancel any benefit / Privileges without prior notice, if there is evidence of misuse or where the hospitality of participating venues is being abused.</p>
						<p style="margin: 0 0 10px 60px;">vi.&nbsp;&nbsp;	Card points only can be redeemed after 3 months from the purchase of vehicle.</p>
						<p style="margin: 0 0 10px 60px;">vii.&nbsp;&nbsp; 2% of invoice value Points added after sales/Body shop cash payment bills but not in insurance claim.</p>
						<p style="margin: 0 0 10px 60px;">viii.&nbsp;&nbsp;	All Services should be done at correct intervals within World class Automobiles Group.</p>
						<p style="margin: 0 0 10px 60px;">ix.&nbsp;&nbsp;	If any service done from outside, whole benefits will be void.</p>
						<p style="margin: 0 0 10px 60px;">x.&nbsp;&nbsp;	Can withdraw /change any benefit /scheme without prior notice.</p>
						<p style="margin: 0 0 10px 60px;">xi.&nbsp;&nbsp;	Validity of card is for 5 years which can be renewed as per the company policy.</p>
						<p style="margin: 0 0 10px 60px;">xii.&nbsp;&nbsp;	All disputes are subject to the jurisdictions of courts in Delhi Only.</p>
						<p><br></p>
						<p style="margin: 0 0 10px 60px;">Remember to present your card before your bill is prepared, to ensure that you burned your Privileges points against your packages.</p>
						<br>						
					<br>						
				</div>
			</div>		 
				  


			
			
		
		</section>
		</form>
        <?php echo form_close(); ?>
		<?php $this->load->view('header/loader');?> 
		<?php $this->load->view('header/footer');?>	

<style>		
.login-box-body{
background:none;
}
</style>	