 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Cust_home/compose');
	?>
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
              <a href="<?php echo base_url()?>index.php/Cust_home/mailbox" class="btn btn-primary btn-block margin-bottom">Folders</a>
              <div class="box box-solid">
                
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                   <li class="active"><a href="<?php echo base_url()?>index.php/Cust_home/mailbox"><i class="fa fa-inbox"></i>Open<span class="label label-primary pull-right"><?php echo $NotificationsCount->Open_notify;?></span></a></li>
                    <li><a href="<?php echo base_url()?>index.php/Cust_home/readnotifications"><i class="fa fa-envelope-o"></i> Read<span class="label label-primary pull-right"><?php echo $ReadNotificationsCount->Read_noty;?></span></a></li>                    
					<li><a href="<?php echo base_url()?>index.php/Cust_home/allnotifications"><i class="fa fa-file-text-o"></i> All Notification<span class="label label-primary pull-right"><?php echo $AllNotificationsCount->All_noty;?></span></a></li>
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
                  <!--<div class="form-group">
                    <div class="btn btn-default btn-file">
                      <i class="fa fa-paperclip"></i> Attachment
                      <input type="file" name="attachment">
                    </div>
                    <p class="help-block">Max. 32MB</p>
                  </div> -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                    <!--<button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button> 
                  </div>
                   <button type="button" id="Discard" class="btn btn-default"  ><i class="fa fa-trash-o"></i> &nbsp;Delete</button>-->
                </div><!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
		<?php echo form_close(); ?>
		<?php $this->load->view('header/footer');?>
	
<style>
/* p>img{
	width:100%;
} */
</style>