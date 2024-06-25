<?php $this->load->view('front/header/header'); 
$this->load->view('front/header/menu'); ?> 
<header>
	<div class="container">
		<div class="d-flex align-items-center">
			<button class="toggle-menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<div class="only-link">
			<a href="#"><span>Notifications</span></a>
			</div>
		</div>
	</div>
</header>
	<div class="custom-body">
		<!--<div class="container">
			<div class="s_box">
				<form>
					<div class="field">
						<div class="icon"><img src="<?php echo base_url()?>/assets/images/search-icon.svg" /></div>
						<input type="text" placeholder="Search Notification" />
					</div>
				</form>
			</div>
		</div>-->
		<div class="top-liner h-auto">
			<ul class="nav mailtab" id="mailTab" role="tablist">
				<li>
					<a href="<?php echo base_url();?>index.php/Cust_home/mailbox">
						<svg id="noun_envelope_309620" xmlns="http://www.w3.org/2000/svg" width="24.91" height="16.281" viewBox="0 0 24.91 16.281">
						  <g id="Group_455" data-name="Group 455" transform="translate(0 0)">
							<path id="Path_159" data-name="Path 159" d="M24.959,22.281H1.351A.642.642,0,0,1,.7,21.63V6.57A.691.691,0,0,1,1.351,6H24.959a.642.642,0,0,1,.651.651v15.06A.629.629,0,0,1,24.959,22.281ZM2,21.06H24.389V7.221H2Z" transform="translate(-0.7 -6)" fill="#86869D"/>
						  </g>
						  <g id="Group_456" data-name="Group 456" transform="translate(15.286 7.387)">
							<rect id="Rectangle_294" data-name="Rectangle 294" width="11.56" height="1.221" transform="matrix(0.738, 0.675, -0.675, 0.738, 0.824, 0)" fill="#86869D"/>
						  </g>
						  <g id="Group_457" data-name="Group 457" transform="translate(0.286 7.387)">
							<rect id="Rectangle_295" data-name="Rectangle 295" width="1.221" height="11.56" transform="matrix(0.675, 0.738, -0.738, 0.675, 8.529, 0)" fill="#86869D"/>
						  </g>
						  <g id="Group_458" data-name="Group 458" transform="translate(0.051 0)">
							<path id="Path_160" data-name="Path 160" d="M13.167,17.234c-.163,0-.244-.081-.407-.163L1.037,7.058a.545.545,0,0,1-.244-.651A.612.612,0,0,1,1.363,6H24.889a.612.612,0,0,1,.57.407.633.633,0,0,1-.163.651L13.574,17.071A.448.448,0,0,1,13.167,17.234ZM3.072,7.221,13.167,15.85,23.261,7.221Z" transform="translate(-0.762 -6)" fill="#86869D"/>
						  </g>
						</svg>
						<span>Unread</span> 
					</a>
				</li>
				<li>
					<a class="active" href="<?php echo base_url();?>index.php/Cust_home/readnotifications">
						<svg id="noun_Letter__309666" data-name="noun_Letter _309666" xmlns="http://www.w3.org/2000/svg" width="22.79" height="22.604" viewBox="0 0 22.79 22.604">
						  <g id="Group_828" data-name="Group 828" transform="translate(0 7.734)"><path id="Path_568" data-name="Path 568" d="M22.894,26.1H1.3a.587.587,0,0,1-.6-.6V11.8a.754.754,0,0,1,.3-.521.562.562,0,0,1,.6.074l10.5,7.6,10.5-7.6a.562.562,0,0,1,.6-.074.5.5,0,0,1,.3.521V25.583A.576.576,0,0,1,22.894,26.1Zm-21-1.117H22.373V12.922l-9.906,7.224a.559.559,0,0,1-.67,0L1.892,12.922Z" transform="translate(-0.7 -11.234)" fill="#86869D"/>
						  </g><g id="Group_829" data-name="Group 829" transform="translate(13.925 13.689)"><rect id="Rectangle_636" data-name="Rectangle 636" width="11.246" height="1.117" transform="translate(0.799 0) rotate(45.656)" fill="#86869D"/>
						  </g><g id="Group_830" data-name="Group 830" transform="translate(0.156 13.666)"><rect id="Rectangle_637" data-name="Rectangle 637" width="1.117" height="11.246" transform="translate(7.862 0) rotate(44.352)" fill="#86869D"/>
						  </g><g id="Group_831" data-name="Group 831" transform="translate(18.768 5.649)"><path id="Path_569" data-name="Path 569" d="M26.421,13.771A.274.274,0,0,1,26.2,13.7a.5.5,0,0,1-.3-.521V9a.754.754,0,0,1,.3-.521.562.562,0,0,1,.6.074l2.9,2.085a.559.559,0,0,1,0,.894l-2.9,2.085C26.645,13.7,26.57,13.771,26.421,13.771Zm.6-3.649v2.011l1.415-.968Z" transform="translate(-25.9 -8.434)" fill="#86869D"/>
						  </g><g id="Group_832" data-name="Group 832" transform="translate(6.75 0)"><path id="Path_570" data-name="Path 570" d="M18.5,4.909H10.312a.56.56,0,0,1-.521-.372.5.5,0,0,1,.223-.6L14.11.962a.559.559,0,0,1,.67,0l4.1,2.979a.5.5,0,0,1,.223.6A.59.59,0,0,1,18.5,4.909Zm-6.48-1.117h4.841L14.408,2Z" transform="translate(-9.762 -0.85)" fill="#86869D"/>
						  </g><g id="Group_833" data-name="Group 833" transform="translate(0.074 5.723)"><path id="Path_571" data-name="Path 571" d="M4.226,13.8c-.149,0-.223,0-.3-.074l-2.9-2.085a.559.559,0,0,1,0-.894l2.9-2.085a.562.562,0,0,1,.6-.074.45.45,0,0,1,.223.447V13.2a.754.754,0,0,1-.3.521A.274.274,0,0,1,4.226,13.8ZM2.29,11.115l1.415.968V10.073Z" transform="translate(-0.8 -8.534)" fill="#86869D"/>
						  </g><g id="Group_834" data-name="Group 834" transform="translate(2.905 2.867)"><path id="Path_572" data-name="Path 572" d="M13.09,18.553c-.149,0-.223,0-.3-.074L4.823,12.744A.531.531,0,0,1,4.6,12.3v-7a.587.587,0,0,1,.6-.6H20.985a.587.587,0,0,1,.6.6v6.926a.531.531,0,0,1-.223.447L13.463,18.4A.41.41,0,0,1,13.09,18.553ZM5.717,12l7.373,5.362L20.464,12V5.892H5.717Z" transform="translate(-4.6 -4.7)" fill="#86869D"/>
						  </g><g id="Group_835" data-name="Group 835" transform="translate(7.969 6.368)"><rect id="Rectangle_638" data-name="Rectangle 638" width="6.703" height="1.117" fill="#86869D"/>
						  </g><g id="Group_836" data-name="Group 836" transform="translate(7.969 9.272)"><rect id="Rectangle_639" data-name="Rectangle 639" width="6.703" height="1.117" fill="#86869D"/>
						  </g>
						</svg>
						<span>Read</span>
					</a>
				</li>
				<li>
					<a href="javascript:myFunction:Select_delected();">
						<svg id="noun_Delete_860236" xmlns="http://www.w3.org/2000/svg" width="18.66" height="18.824" viewBox="0 0 18.66 18.824">
						  <path id="Path_577" data-name="Path 577" d="M28.376,12.738H23.641V11.607A1.226,1.226,0,0,0,22.321,10.5H17.138a1.211,1.211,0,0,0-1.319,1.107v1.131H11.083a.683.683,0,0,0,0,1.366h1.107L13.227,26.78A2.569,2.569,0,0,0,15.8,29.324h7.869A2.549,2.549,0,0,0,26.232,26.8l1.037-12.722h1.107a.684.684,0,0,0,.683-.683A.664.664,0,0,0,28.376,12.738Zm-11.215.024v-.9H22.3v.9ZM25.9,14.081,24.889,26.709v.047a1.247,1.247,0,0,1-1.225,1.225H15.772a1.252,1.252,0,0,1-1.225-1.249L13.51,14.081H25.9Z" transform="translate(-10.4 -10.5)" fill="#86869D"/>
						  <path id="Path_578" data-name="Path 578" d="M37.168,45.589a.679.679,0,0,0,.683.66.689.689,0,0,0,.683-.707l-.306-6.6a.678.678,0,0,0-.212-.495.636.636,0,0,0-.495-.165.678.678,0,0,0-.471.212.666.666,0,0,0-.165.495Z" transform="translate(-30.642 -31.736)" fill="#86869D"/>
						  <path id="Path_579" data-name="Path 579" d="M56.941,46.263a.7.7,0,0,0,.707-.636l.306-6.62a.711.711,0,0,0-.613-.707h-.024a.712.712,0,0,0-.707.636l-.33,6.6a.651.651,0,0,0,.66.73Z" transform="translate(-45.467 -31.75)" fill="#86869D"/>
						</svg>
						<span>Delete</span>
					</a>
				</li>
				<li class="edite close">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home">
					<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.24685 7L13.7418 1.50509C13.9071 1.33974 14 1.11549 14 0.88166C14 0.647829 13.9071 0.423575 13.7418 0.258232C13.5764 0.0928889 13.3522 0 13.1183 0C12.8845 0 12.6603 0.0928889 12.4949 0.258232L7 5.75314L1.50509 0.258232C1.33974 0.0928889 1.11549 1.06764e-08 0.88166 1.31402e-08C0.647829 1.5604e-08 0.423575 0.0928889 0.258232 0.258232C0.0928889 0.423575 1.5604e-08 0.647829 1.31402e-08 0.88166C1.06764e-08 1.11549 0.0928889 1.33974 0.258232 1.50509L5.75314 7L0.258232 12.4949C0.0928889 12.6603 0 12.8845 0 13.1183C0 13.3522 0.0928889 13.5764 0.258232 13.7418C0.423575 13.9071 0.647829 14 0.88166 14C1.11549 14 1.33974 13.9071 1.50509 13.7418L7 8.24685L12.4949 13.7418C12.6603 13.9071 12.8845 14 13.1183 14C13.3522 14 13.5764 13.9071 13.7418 13.7418C13.9071 13.5764 14 13.3522 14 13.1183C14 12.8845 13.9071 12.6603 13.7418 12.4949L8.24685 7Z" fill="#030303"/>
					</svg>
				</a>
				</li>
			</ul>
			<div class="tab-content" id="mailContent">
				<div class="tab-pane fade show active" id="unread">
					<div class="notification-body">
					<?php 
					foreach($ReadNotifications as $note)
					{
							
						$date11 = date('d-M',strtotime($note['Date']));
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
						if($days=='0'){$days='';}elseif($days==1){$days=$days.' Day';}
						else{$days=$days.' Days';}
						?>
						<div class="notification-check">
							<label>
								<input type="checkbox"  name='note' value="<?php echo $note['Id']; ?>" />
								<span><b><a id="mail_body" style="text-decoration: none" href="<?php echo base_url();?>index.php/Cust_home/compose?Id=<?php echo $note['Id']; ?>"><?php echo $note['Offer']; ?></a></b>
							
								<small class="date">
								<?php
									if( $years=="" && $months =="" &&  $days== "")
									{
									// echo 'Some time before';
										echo $date11;
									  }
									  else
									  {
										 // echo $years, $months, $days.' ago';
										 echo $date11;
									  }
								?>
									</small></span>
							</label>
						</div>
						<?php 
					} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('front/header/footer');  ?>
<script>
function Select_delected()
{
	var result=1;
	if (result == 1)
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
					
		});	
		if(theArray !='')
		{
			/*setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},2000); */
			
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
					var msg='Notification deleted successfuly';
					$('.help-block').show();
					$('.help-block').css("color","green");
					$('.help-block').html(msg);
					setTimeout(function(){ $('.help-block').hide(); }, 5000);
					location.reload(); 
				 }
			});
		}
		else
		{
			var msg='Please select at least anyone notification';
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg);
			setTimeout(function(){ $('.help-block').hide(); }, 5000);
			return true;
		}
	}
	else
	{
		return false;
	}	
} 
function Page_refresh()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	// window.location.reload();
}
</script>
<script>
function form_submit()
{ 
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	document.Read_mail_search.submit();
} 
</script>