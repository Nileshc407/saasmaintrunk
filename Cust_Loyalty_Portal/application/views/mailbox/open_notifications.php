 <?php $this->load->view('header/header');?>
 <?php echo form_open_multipart('Cust_home/mailbox');  ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Mailbox (Notification)
            <small><?php echo $NotificationsCount->Notify;?> new messages</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Mailbox</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <a href="<?php echo base_url()?>index.php/Cust_home/compose" class="btn btn-primary btn-block margin-bottom">Compose</a>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Folders</h3>
                  <div class="box-tools">
                   
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#"><i class="fa fa-inbox"></i>Open  <span class="label label-primary pull-right"><?php echo $NotificationsCount->Notify;?></span></a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> Read<span class="label label-primary pull-right"><?php echo $NotificationsCount->Notify;?></span></a></li>
                    
					<li><a href="#"><i class="fa fa-file-text-o"></i> All Notification<span class="label label-primary pull-right"><?php echo $NotificationsCount->Notify;?></span></a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
             
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Inbox</h3>
                 <!-- <div class="box-tools pull-right">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" placeholder="Search Mail">
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div> /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
						
					<button class="btn btn-default btn-sm checkbox-toggle" ><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                      <!--<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                      <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>-->
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                      1-50/200
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                      <tbody>
					
					  <?php 
					  
							foreach($AllNotifications as $note)
							{ 
								$date1 = date('Y-m-d',strtotime($note['Date']));
								$date2 = date('Y-m-d');
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								if($years=='0')	{ $years=''; }
								else{	$years=$years.' Year-'; }
								if($months=='0'){ $months=''; }
								else{$months=$months.' Months-';}
								if($days=='0'){$days='';}
								else{$days=$days.' Days ago';}							
							?>
										
									<tr>
									


									
									  <td><input type="checkbox" name="check_list"></td>
									  
									  <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
									  
									 <td class="mailbox-name"><small><a href="<?php echo base_url()?>index.php/Cust_home/compose?Id=<?php echo $note['Id']; ?>"><?php echo $note['First_name'].' '.$note['Last_name']; ?></a></small></td>
									 
									  <td class="mailbox-subject"><small><b><a href="<?php echo base_url()?>index.php/Cust_home/compose?Id=<?php echo $note['Id']; ?>"><?php echo $note['Offer']; ?></a></b></small></td>
									  
									  <td class="mailbox-attachment"></td>
									  
									  <!--<td class="mailbox-date">5 mins ago</td> -->
									  <td class="mailbox-date"><small><?php 
									  if( $years=="" && $months =="" &&  $days== "")
									  {
										echo 'Some time before';
									  }
									  else
									  {
										 echo $years, $months, $days;
									  }
									  // echo $years, $months, $days;
									  ?></small></td>
									</tr>
								
					
						<?php	}	?>
					</tbody>
                    </table><!-- /.table -->
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                   <!-- <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                      <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                    </div><!-- /.btn-group
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button> -->
                    <div class="pull-right">
                      1-50/200
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content --> 
		<?php echo form_close(); ?>
		<?php $this->load->view('header/footer');?>
		
		





		
		<!--Script by hscripts.com-->
<!-- Free javascripts @ https://www.hscripts.com -->
<script type="text/javascript">
checked=false;
function checkedAll (frm1) {var aa= document.getElementById('frm1'); if (checked == false)
{
checked = true
}
else
{
checked = false
}for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}
</script>
<!-- Script by hscripts.com -->
