<?php $this->load->view('header/header'); ?>


<script type="text/javascript" src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/js/functions.js"></script>

        <!-- Content Header (Page header) -->
		<?php echo form_open('Cust_home/game_to_play');	?>
		<?php
			if(@$this->session->flashdata('select_game'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('select_game'); ?>';
					runjs(Title,msg);
				</script>
			<?php
				
				$this->session->set_flashdata("select_game","");
			}	
			?>

        <!-- Main content -->
        <section class="content">
		
			
      <div class="row">

			<div class="pure-u-1 pure-u-md-1-2" style="width: 80%;">
				<a style="text-decoration:underline;" class="fancybox fancybox.ajax"  data-toggle="modal" data-target="#myModal1" href="#">
					<span style="font:bold 1em sans-serif;color: #636363;">Game Instructions</span>
				</a>
	
	<?php if($gm_result['livesFlag'] && ($gm_result['game_type'] == 2 || $gm_result['game_type'] == 3) ){ ?>
			
			|&nbsp;&nbsp;
				<a style="text-decoration:underline;" class="fancybox fancybox.ajax" href="#" onclick="transferLives();"> 
					<span style="font:bold 1em sans-serif;color: #636363;">Transfer Lives</span>
				</a>
			|&nbsp;&nbsp;
			
				<a style="text-decoration:underline;" class="fancybox fancybox.ajax" href="#" onclick="purchaseLives();">
					<span style="font:bold 1em sans-serif;color: #636363;">Purchase Lives</span>
				</a>
			|&nbsp;&nbsp;
			
	<?php  } ?>
			
			</div>

			<br>
			<div class="col-md-2">
				<div class="alert alert-info">
				<p class="text-center"><b>Game Level</b></p>
                    <h4 class="text-center"><b><?php echo $gm_result['CurrentLevel']; ?></b></h4>       
				</div>
			
			</div>
				
	<?php if($gm_result['livesFlag'] && ($gm_result['game_type'] == 2 || $gm_result['game_type'] == 3) ){ ?>
			<div class="col-md-2">
				<div class="alert alert-info">
				<p class="text-center"><b>Remaining Lives</b></p>
                    <h4 class="text-center"><b><?php echo $gm_result['game_lives']; ?></b></h4>       
				</div>
			
			</div>
			
	<?php  } ?>
			

	</div>		
       <br>
        <div class="box box-info">
			    
				<form action="#" method="post">

				<div id="title" ><h2>The Memory Game</h2><h4>[ Find the pair of images]</h4></div> 
						<div id="scorebord">
							<table align="center">
							
								<tr >
									<td align="left" >
									   <b> Required Moves: </b><br><input type="text" value="<?php echo $gm_result["Total_moves"]; ?>" name="cnt11" size="6" readonly />
									</td>
									<td  align="left">
									   <b> Required Time (In second):</b> <br><input type="text" value="<?php echo $gm_result["Time_for_level"]; ?>" name="time11" size="6" readonly />
									</td>
								</tr>
								
								<tr >
									<td  align="left">
									   <b>Your Moves:</b> <br><input type="text" id="counting" name="cnt" size="6" readonly />
									</td>
									<td  align="left">
										<b>Your Time (In second):</b> <br><input type="text" id="timecount" name="time" size="6" readonly />
									</td>
								</tr>
							</table>
						</div>

						 <div id="card" onclick="count();" align="center"> 
						 
							<div id="image1"  class="bordimage" onclick="doTimer();">
								<img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/speaker.png" style='display: inline;  border: none;' id="im" />
							</div>
							<div id="image2"  class="bordimage" onclick="doTimer();">
								<img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/floppy.png" style='display: none;  border: none;' id="im1" />
								
							</div>
							<div id="image3"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/mphone.png" style='display: none; border: none;' id="im2"></div>
							<div id="image4"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/call.png" style='display:none; border: none;' id="im3"></div>
						
							<div id="image5"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/WinZip.png" style='display: none; border: none; ' id="im4"></div>
							<div id="image6"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/window.png" style='display: none; border: none; ' id="im5"></div>
							<div id="image7"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/tablet-android.png" style='display: none; border: none; ' id="im6"></div>
							<div id="image8"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/to_pa3923u1lc3_100.png" style='display: none; border: none; ' id="im7"></div>
							

							
							<div id="image9"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/index_articleImage-Monitor.png" style='display: none; border: none; ' id="im8"></div>
							<div id="image10"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/usb.png" style='display: none; border: none; ' id="im9"></div>
							<div id="image11"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/speaker.png" style='display: none; border: none; ' id="im10"></div>
							<div id="image12"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/floppy.png" style='display: none; border: none; ' id="im11"></div>
							
							
							<div id="image13"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/mphone.png" style='display: none; border: none; ' id="im12"></div>
							<div id="image14"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/call.png" style='display: none; border: none; ' id="im13"></div>
							<div id="image15"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/WinZip.png" style='display: none; border: none; ' id="im14"></div>
							<div id="image16"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/window.png" style='display: none; border: none; ' id="im15"></div>

							<div id="image17"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/tablet-android.png" style='display: none; border: none; ' id="im16"></div>
							<div id="image18"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/to_pa3923u1lc3_100.png" style='display: none; border: none; ' id="im17"></div>
							<div id="image19"  class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/index_articleImage-Monitor.png" style='display: none; border: none; ' id="im18"></div>
							<div id="image20" class="bordimage" onclick="doTimer();"><img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/usb.png" style='display: none; border: none; ' id="im19"></div>
						
						</div>

					
			  <div class="row">				
				 <div class="col-xs-12">				 
				
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
					  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
					  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
					  
					  <input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
					
				</div><!-- /.col -->
			  </div>
			</form>
			  
		</div>   <!-- /.row -->
		  
		
		
		<!-- Modal -->
		<div id="myModal1" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				
				<h4 class="modal-title text-center" style="color:red;">Game Instructions </h4>
			  </div>
			  <div class="modal-body">
				<p>
					<?php echo $gm_result['Description']; ?>
				</p>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
			  </div>
			</div>

		  </div>
		</div>
	<!-- Modal -->
		  
		<?php echo form_close(); ?>
        </section><!-- /.content -->
      <?php $this->load->view('header/footer');?>
<script>
	var Flag = 1;
	
	var Total_moves = '<?php echo $gm_result['Total_moves']; ?>';
	
	var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
	var GameLevelScore = 500;
	var MemberID = '<?php echo $Enroll_details->Card_id; ?>';
	var MemberLPID = 0;
	var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
	var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
	var CompID = '<?php echo $Company_id; ?>';
	var game_type = '<?php echo $gm_result['game_type']; ?>';
	
	
var showimg = "";
var imageopen = "";
var pair = 0;

$(document).ready(function() {


    $(".bordimage img").hide();
    shuffle();
    $("#card div").click(function()
    {
        id = $(this).attr("id");
        if ($("#"+id+" img").is(":hidden"))
        {
            $("#"+id+" img").fadeIn('slow');
            if (imageopen == "")
            {
                showimg = id;
                imageopen = $("#"+id+" img").attr("src");
            }
            else
            {
                currentopened = $("#"+id+" img").attr("src");
                if (imageopen != currentopened)
                {
                    $("#"+id+" img").slideUp("slow");
                    $("#"+showimg+" img").slideUp("slow");
                    showimg = "";
                    imageopen = "";
                }
                else
                {
                    $("#"+id+" img").show();
                    $("#"+showimg+" img").show();
                    showimg = "";
                    imageopen = "";
                    pair+=1;
                }
            }
            if(pair==10)
            {
                setTimeout('finish()', 400);
            }  
			
        }
    });
});


function finish()
{
	var cnt1 = $("#counting").val();
    var tim = $("#timecount").val();
    
    //alert("cnt1--"+cnt1+"--Total_moves---"+Total_moves);
	pair = 0;
	var score = 0;
	stopCount();
	 
	if(parseInt(cnt1) <= parseInt(Total_moves) && parseInt(tim) <= parseInt(level_time))
	{
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_next_level/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type+"&score="+score;
		
	}
	else
	{
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_level_fail/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type;
	}
	
}	

function level_fail(Comp_Game_ID,GameLevel,MemberID,game_type)
{
	//alert("Comp_Game_ID--"+Comp_Game_ID+"--GameLevel--"+GameLevel+"--MemberID--"+MemberID+"--game_type--"+game_type);
	
	window.location="<?php echo base_url()?>index.php/Cust_home/game_level_fail/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type;
}
</script>
<script>
	function transferLives()
	{
		var gameID = '<?php  echo $gm_result['Game_id']; ?>';
		var Company_gameID = '<?php  echo $gm_result['Company_game_id']; ?>';
		var gameType = '<?php  echo $gm_result['game_type']; ?>';
		var GameLevel = '<?php  echo $gm_result['CurrentLevel']; ?>';
		var livesFlag = '<?php  echo $gm_result['livesFlag']; ?>';

		window.location = "<?php echo base_url()?>index.php/Cust_home/transfer_lives/?Comp_Game_ID="+Company_gameID+"&GameLevel="+GameLevel+"&gameID="+gameID+"&game_type="+gameType+"&livesFlag="+livesFlag;

	}
	
	function purchaseLives()
	{
		var gameID = '<?php  echo $gm_result['Game_id']; ?>'; 
		var Company_gameID = '<?php  echo $gm_result['Company_game_id']; ?>';
		var gameType = '<?php  echo $gm_result['game_type']; ?>';
		var GameLevel = '<?php  echo $gm_result['CurrentLevel']; ?>';
		var livesFlag = '<?php  echo $gm_result['livesFlag']; ?>';

		window.location = "<?php echo base_url()?>index.php/Cust_home/purchase_lives/?Comp_Game_ID="+Company_gameID+"&GameLevel="+GameLevel+"&gameID="+gameID+"&game_type="+gameType+"&livesFlag="+livesFlag;

	}
</script>	  
<style>
.login-box{
	margin: 2% auto;
}

#homediv
{
	display: inline !important;
}
#card
{
   margin: 10px 0px 0px 80px;
   width: 80%;
}

.bordimage
{
   position:relative;
   width: 18%;
   float: left;
   height: 90px !important;
   background: #5cacee none repeat scroll 0 0;
   margin: 3px;
   border: 1px solid #999;
   cursor: pointer;
   padding: 15px !important;
   -webkit-border-radius: .3em;
   -moz-border-radius: .3em;
}

#title
{
	padding-left: 5%; 
	margin-top: 20px; 
	font-weight: bold;
	color: green;
}

#scorebord
{
	padding:0px 5px 0px 2px;
	margin-top: 25px;
}
#scorebord table
{
	width:80%;
}
.bordimage  img
{
	 height: 68px;
    max-width: 90%;

}

@media only screen and (max-width:980px)
{
	
	#title 
	{
		padding-left: 3%;
	}
}

@media only screen and (max-width:800px)
{
	#card
	{
	   width: 85%;
	   margin: 10px 0 0 20px;
	}
	
	#title 
	{
		padding-left: 3%;
	}
	
	#scorebord table
	{
		width:80%;
	}
	
	.bordimage
	{
		height: 85px !important;
		margin: 3px;
		padding: 15px !important;
		width: 22%;
	}
	
	.bordimage  img
	{
		 height: 65px;
		max-width: 90%;

	}
}

@media only screen and (max-width:360px)
{
	.bordimage
	{
		 height: 53px !important;
		margin: 5px;
		padding: 14px !important;
		width: 20%;
	}
	#card
	{
		margin: 10px 15px 0;
		width: 95%;
	}

	#title 
	{
		padding-left: 3%;
	}
}

@media only screen and (max-width:360px)
{
	#card
	{
		margin: 10px 15px 0;
		width: 95%;
	}
	
	.bordimage img 
	{
		 height: 45px;
		margin: -9px;
		max-width: 48px;
	}

}
</style>

