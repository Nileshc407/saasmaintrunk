
	
<?php $this->load->view('header/header');?>
<?php echo form_open_multipart('Cust_home/merchandisecatalog'); 
		
		?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Redempton Catalogue
          </h1>
          
        </section>

        <!-- Main content -->

            <section class="content">
			<div class="row">
            <!-- left column -->
            
			  <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Account Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                   <div class="form-group">
                      <label for="exampleInputEmail1">Current Balance</label>
                      <input type="text" readonly class="form-control" id="Current_Balance" value="<?php echo $Enroll_details->Current_balance; ?>" placeholder="Current Balance">
                    </div>
                   <div class="form-group">
                      <label for="exampleInputEmail1">My Cart</label>
                      <input type="text" readonly class="form-control" id="My_Cart" placeholder="My Cart">
                    </div>             
                 </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
              </div><!-- /.box -->			  
			  <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sort</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                     <div class="form-group">
                    <label>Merchandise Category</label>
                    <select class="form-control select2" style="width: 100%;" name="Merchandise_Category" id="Merchandise_Category">
                      <option selected="selected">All</option>
                     <?php 
						foreach($MerchandiseProductCategory as $Category)
						{
							?>
							<option value="<?php echo $Category['Merchandize_category_id']; ?>"><?php echo $Category['Merchandize_category_name']; ?> </option>
							
							<?php 
						}					 
						?>
                    </select>
                  </div><!-- /.form-group -->
                   <div class="form-group">
                    <label>Redeemption Method</label>
                    <select class="form-control select2" style="width: 100%;">
                      <option value="0">Select Redeemption Method</option>
                      <option value="1">e-Voucher</option>
                      <option value="2" >Delivery</option>
                      <option value="3" >Both</option>
                    </select>
                  </div><!-- /.form-group -->
                     <div class="form-group">
                    <label>Sort</label>
                    <select class="form-control select2" style="width: 100%;">
                      <option  value="0" >All</option>
                      <option  value="1">Points:Low-High</option>
                      <option  value="2" >Points:High-Low</option>
                      <option  value="3" >Recently Added</option>
                      <option  value="4" >More Relevance</option>
                    </select>
                  </div><!-- /.form-group -->
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
              </div><!-- /.box -->
			  
              </div><!-- /.box -->
			  
			  	<div class="row" id="row_id">
			  
		<?php 
		foreach($results as $MCategory)
		{
			// echo $MCategory['Item_image'];
			
		?>
			 <div class="col-md-4" >
             <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php 
							echo $MCategory->Merchandize_item_name;
					//echo $MCategory['Merchandize_item_name']; ?></h3>
                </div>
                <div class="box-body">
                 <div class="direct-chat-messages">
                   <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left"><?php 
							echo $MCategory->Merchandise_item_description;
						// echo $MCategory['Merchandise_item_description'];
						?></span>
                      </div>
						<div class="zoom">
							<div class="small">
								<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?><?php 
								echo $MCategory->Item_image;
								// echo $MCategory['Item_image'];
								
								?>" alt="<?php 
									echo $MCategory->Merchandize_item_name;
								//echo $MCategory['Merchandize_item_name']; ?>">
							</div>

							<div class="large">
								<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?><?php 
								echo $MCategory->Item_image;
								// echo $MCategory['Item_image'];
								?>" alt="big rushmore">
							</div>
						</div>
                     </div>
                  </div>
                  
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input type="text" name="message" placeholder="Redeem Now ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Redeem Now</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
			<?php } ?>			  
        </div><!-- /.row -->		
		<div class="panel-footer"><?php echo $pagination; ?></div>
		
        </section>
		<!-- /.content -->
		
		
		
			<!--<?php $countries['#'] = 'Please Select'; ?>
 
			<label for="country">Country: </label><?php echo form_dropdown('country_id', $countries, '#', 'id="country"'); ?><br />
			 <?php $cities['#'] = 'Please Select'; ?>
			<label for="city">City: </label><?php echo form_dropdown('city_id', $cities, '#', 'id="cities"'); ?><br /> -->

					<?php echo form_close(); ?>
     <?php $this->load->view('header/footer');?>
	 
	 
	<!--
	<link href="//fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url()?>magnifier/style.css">-->
	<link rel="stylesheet" href="<?php echo base_url()?>magnifier/style.css">
	<link rel="stylesheet" href="<?php echo base_url()?>magnifier/anythingzoomer.css">
	<script src="<?php echo base_url()?>magnifier/jquery.anythingzoomer.js"></script>
	<script>
	$(function() {
		$(".zoom").anythingZoomer({
			overlay : true,
			edit: true,
			// If you need to make the left top corner be at exactly 0,0, adjust the offset values below
			offsetX : 10,
			offsetY : 10
		});

		$('.president')
		.bind('click', function(){
			return false;
		})
		.bind('mouseover click', function(){
			var loc = $(this).attr('rel');
			if (loc && loc.indexOf(',') > 0) {
				loc = loc.split(',');
				$('.zoom').anythingZoomer( loc[0], loc[1] );
			}
			return false;
		});

	});
	</script>

 <script type="text/javascript">
 // <![CDATA[
	 $(document).ready(function(){
		$('#Merchandise_Category').change(function(){
			//any select change on the dropdown with id country trigger this code
			 // $("#row_id").remove(); //first of all clear select items
			 var MerchandiseCategory = $('#Merchandise_Category').val(); // here we are taking country id of the selected one.
			$.ajax({
			
				type: "POST",
				data: {Merchandise_Category: MerchandiseCategory},
				url: "<?php echo base_url()?>index.php/Cust_home/getmerchandisemategory",
				 
				 success: function(cities) //we're calling the response json array 'cities'
				 {
					
				 } 
			 
			 });
		 
		 });
	});
 // ]]>
</script>
	
	<style>
	.control-sidebar {
    padding-top: 50px !Important;
    position: fixed !Important;
    z-index: 1010 !Important;
	}

	</style>
	 