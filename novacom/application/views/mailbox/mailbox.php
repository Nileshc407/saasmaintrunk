<?php $this->load->view('header/header');?>
<?php $this->load->view('header/loader');?>
 <?php echo form_open_multipart('Cust_home/mailbox');  ?>

<script type="text/javascript">
  function Select_delected()
	{
		BootstrapDialog.confirm("Are you sure you want to Delete Notifications?", function(result)
		{
			show_loader();
			if (result == true)
			{
				var urlid = "<?php echo base_url()?>index.php/Cust_home/delete_notification";

				var favorite = [];
				var theArray = new Array();
				var i=0;
				$.each($("input[name='note']:checked"), function(){


				if(jQuery(this).prop('checked'))
				{
					theArray[i] = jQuery(this).val();
					i++;
				}

							/* var valIS = $(this).val();
							var myval=favorite.push($(this).val());
							$.ajax({
							type: "POST",
							data: {Note_Id: valIS},
							url: "<?php echo base_url()?>index.php/Cust_home/delete_notification",
							success: function(data)
							{
								BootstrapDialog.show({
								closable: false,
								title: 'Valid Data Operation',
								message: 'Notification Deleted Successfully ',
								buttons: [{
								label: 'OK',
								action: function(dialog) {
								location.reload();
										}
									}]
								});

							}
							});  */


				});
				jQuery.ajax({
					 url: '<?php echo base_url()?>index.php/Cust_home/delete_notification',
					 type: 'post',
					 data: {
						 NoteID: theArray,
						 other_id: ''
					 },
					 datatype: 'json',
					 success: function(data)
					 {
						BootstrapDialog.show({
							closable: false,
							title: 'Valid Data Operation',
							message: 'Notification Deleted Successfully ',
							buttons: [{
							label: 'OK',
							action: function(dialog) {
							location.reload();
									}
								}]
							});

					 }
				});
				return true;

			}
			else
			{
				return false;
			}
		});
	}
</script>
<script>
 /* refresh()
  {
	alert('Working');
	 location.reload();
  } */
</script>
 <script src="<?php echo base_url()?>dist/js/demo.js"></script>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Notifications
            <small><?php echo $NotificationsCount->Open_notify;?> new messages</small>
          </h1>
        </section>
		<?php
			if(@$this->session->flashdata('error_code'))
			{

				//echo" Delete Notification";
			  ?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>

			<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
			<script>
					BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
					buttons: [{
						label: 'OK',
						action: function(dialog) {
							window.location='<?php echo base_url()?>index.php/Cust_home/home';
						}
					}]
				});
				runjs(Title,msg);
			</script>
		<?php } ?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <a href="#" class="btn btn-primary btn-block margin-bottom">Folders</a>
              <div class="box box-solid">

                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="<?php echo base_url()?>index.php/Cust_home/mailbox"><i class="fa fa-envelope"></i>Un-Read<span class="label label-primary pull-right"><?php echo $NotificationsCount->Open_notify;?></span></a></li>
                    <li><a href="<?php echo base_url()?>index.php/Cust_home/readnotifications"><i class="fa fa-envelope-o"></i> Read<span class="label label-primary pull-right"><?php echo $ReadNotificationsCount->Read_noty;?></span></a></li>
					<li><a href="<?php echo base_url()?>index.php/Cust_home/allnotifications"><i class="fa fa-list"></i> All Notification<span class="label label-primary pull-right"><?php echo $AllNotificationsCount->All_noty;?></span></a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->

            </div><!-- /.col -->
            <div class="col-md-9">
               <div class="box-header with-border">
                  <h3 class="box-title">Un-read</h3>
                  <!--<div class="box-tools pull-right">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" placeholder="Search Mail">
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div> /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
				  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button  type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button type="button" id="Discard"  onclick="Select_delected()" class="btn btn-default btn-sm" id="Discard" ><i class="fa fa-trash-o"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" onclick="window.location.reload();" ><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">

                    </div><!-- /.pull-right -->
                  </div>
                  <div class="table-responsive mailbox-messages">
				  <table class="table table-hover table-striped">
				 <tbody>
				<?php
								
					foreach($AllNotifications as $note)
					{

						$Company_name=$note['Company_name'];
						$Offer=$note['Offer'];
						

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

						
							//echo "---Before Encryption--".$note['Id']."---<br>";
							

							$note1 = string_encrypt($note['Id'], $key, $iv);	
							$note = preg_replace("/[^(\x20-\x7f)]*/s", "", $note1);
							
						//	echo "---Encryption---".$note."---<br>";
							// $decryptnote = string_decrypt($note, $key, $iv);	
							// $decryptnote1 = preg_replace("/[^(\x20-\x7f)]*/s", "", $decryptnote);							
						//	echo "---Decryption---".$decryptnote."---<br>";
							//echo "<br>---******--- <br>";


						
							// echo "---Company_name---".$Company_name."---<br>";
							


							?>
							<tr>
									<td><input type="checkbox" name='note' value="<?php echo $note; ?>"></td>
								 	<td class="mailbox-name"><small><a href="<?php echo base_url()?>index.php/Cust_home/compose?Id=<?php echo urlencode($note); ?>"><?php echo $Company_name; ?></a><small></td>
								  <td class="mailbox-subject"><small><b><a href="<?php echo base_url()?>index.php/Cust_home/compose?Id=<?php echo urlencode($note); ?>"><?php echo $Offer; ?></a></b><small></td>
									
									<td class="mailbox-date" ><small><?php
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

				<?php
					}
				?>

				</tbody>
			</table>


                </div><!-- /.Responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button  type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button type="button" id="Discard"  onclick="Select_delected()" class="btn btn-default btn-sm" id="Discard" ><i class="fa fa-trash-o"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" onclick="window.location.reload();" ><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
					<?php echo $pagination; ?>
                        <!-- 1-50/200<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>-->
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
		<?php echo form_close(); ?>
		<?php $this->load->view('header/footer');?>


<style type="text/css" class="init">
	tfoot input {
		width: 100%;
		padding: 3px;
		box-sizing: border-box;
	}
	</style>
	<!-- iCheck -->
    <script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/icheck.min.js"></script>
    <!-- iCheck -->
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
