<?php $this->load->view('header/header'); ?>
<?php $this->load->view('header/loader'); ?>
        <!-- Content Header (Page header) -->
<?php echo form_open_multipart('Cust_home/compose'); ?>
<script src="<?php echo base_url()?>dist/js/demo.js"></script>
        <section class="content-header">
          <h1>
            Mailbox
            <small><?php echo $NotificationsCount->Open_notify;?> new messages</small>
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <a href="#" class="btn btn-primary btn-block margin-bottom">Folders</a>
              <div class="box box-solid">
                
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?php echo base_url()?>index.php/Cust_home/mailbox"><i class="fa fa-envelope"></i>Un-Read<span class="label label-primary pull-right"><?php echo $NotificationsCount->Open_notify;?></span></a></li>
                    <li><a href="<?php echo base_url()?>index.php/Cust_home/readnotifications"><i class="fa fa-envelope-o"></i> Read<span class="label label-primary pull-right"><?php echo $ReadNotificationsCount->Read_noty;?></span></a></li>                    
					<li class="active"><a href="<?php echo base_url()?>index.php/Cust_home/allnotifications"><i class="fa fa-list"></i> All Notification<span class="label label-primary pull-right"><?php echo $AllNotificationsCount->All_noty;?></span></a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
             
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title"><?php echo $Notifications->Offer;   ?></h3>
					</div><!-- /.box-header -->
					<div class="box-body">
					  
					  <div class="form-group">
					  <!--<input type="checkbox" name="note"  value="<?php //echo $note['Id']; ?>">-->
					  <input type="hidden" name="note" value="<?php echo $Notifications->Id; ?>" class="form-control" />
						From: <b><?php echo $Notifications->Company_primary_email_id; ?></b>
					  </div>
					  <div class="form-group">

						<?php echo $Notifications->Offer_description;   ?>
					  </div>

					</div><!-- /.box-body -->
					<div class="box-footer">
						<div class="pull-right">
	   
						</div><!-- /.box-footer -->
					</div><!-- /. box -->
				</div>
			</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
		<?php echo form_close(); ?>
		<?php $this->load->view('header/footer');?>
	
<style type="text/css" class="init">

.content,.main-footer {
    font-family: "cocogoose-regular";
    font-weight: 200;
}

p>img{
	width:100%;
}

tfoot input {
		width: 100%;
		padding: 3px;
		box-sizing: border-box;
	}
</style>
<!-- iCheck -->
    <script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/icheck.min.js"></script>
    <!-- iCheck -->
    <!-- Page Script -->
    <script>
      $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });
        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }
          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
        });
      });
	  
	  
	</script>  
	 

    <!-- AdminLTE for demo purposes -->

	
