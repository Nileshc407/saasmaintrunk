<?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		
        <section class="content-header">          <h1>
           Error 
          </h1>
         
        </section>

			
			<?php 	
			
			    if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
				<script>
						BootstrapDialog.show({
						closable: false,
						title:'Application Information',
						message:'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
						buttons:[{
							label: 'OK',
							action: function(dialog) {
								window.location='<?php echo base_url()?>index.php/Cust_home/home';
							}
						}]
					});
					runjs(Title,msg);
				</script>
            <?php } ?>
            
        <div class="login-box">
            <div class="login-box-body">           
                <section class="error-container text-center"> 
                    <h1 style="color:red;">404</h1> 
                    <div class="error-divider"> 
                    <h2>PAGE NOT FOUND.</h2> 
                    <p class="description">We Couldn't Processed Your Requested Data</p> 
                    </div> 
                <h3><a href="<?php echo base_url()?>index.php/Cust_home/home" class="return-btn"><i class="fa fa-home"></i> Home</a> </h3> 
                </section>             
            </div> 
        </div> 
            
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>	