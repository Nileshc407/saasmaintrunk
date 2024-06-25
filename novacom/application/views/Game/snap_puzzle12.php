<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');

?>
<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>

<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/css/pure-min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/css/grids-responsive-min.css">	

<script src="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/js/jquery-ui.min.js"></script>	
<link href="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/css/timeTo.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/js/jquery.timeTo.js"></script>
<script>
	$(function(){
		// countdown();
		$('#pile').hide();
		$('#puzzle_start').show();
	});	
	
	function countdown()
	{
		var Title = "Unsuccessfull Data Operation";
		$('#countdown-1').timeTo('<?php echo $gm_result["Time_for_level"]; ?>', function()
		{
			$('#pile').hide();
			$('#puzzle_unsolved').show();
			level_fail();
			// var msg = "Your Time for Level Is Over. Please Try Again!";
			// runjs(Title,msg);
		});
	}
	
	function countdown_stop()
	{
		var Title = "Successfull Data Operation";
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		// alert('Congrats!! You completed the Level-'+GameLevel);	
		// var msg = "Congratulations!!! You have Successfully Completed the Game Level - "+GameLevel;
		// runjs(Title,msg);		
			
		$('#countdown-1').timeTo(1, function()
		{
			callmenow();
		});
	}
	
	function callmenow()
	{
		var Flag = 1;
	

		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';
		var MemberLPID = 0;
		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		var score = 0;
		
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_next_level/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type+"&score="+score;
		
	}
	
	function level_fail()
	{
		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var GameLevelScore = 500;
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';
		var MemberLPID = 0;
		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		var score = 0;
		
		
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_level_fail/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type;
	}
</script>
	
<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
<style>
	/* body { margin: 0; padding: 0; border: 0; min-width: 320px; color: #777; } */
	html, button, input, select, textarea, .pure-g [class *= "pure-u"] { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 1.02em; }
	p, td { line-height: 1.5; }
	ul { padding: 0 0 0 20px; }

	th { background: #eee; white-space: nowrap; }
	th, td { padding: 10px; text-align: left; vertical-align: top; font-size: .9em; font-weight: normal; border-right: 1px solid #fff; }
	td:first-child { white-space: nowrap; color: #008000; width: 1%; font-style: italic; }

	h1, h2, h3 { color: #4b4b4b; font-family: "Source Sans Pro", sans-serif; font-weight: 300; margin: 0 0 1.2em; }
	h1 { font-size: 4.5em; color: #1f8dd6; margin: 0 0 .4em; }
	h2 { font-size: 2em; color: #636363; }
	h3 { font-size: 1.8em; color: #4b4b4b; margin: 1.8em 0 .8em }
	h4 { font: bold 1em sans-serif; color: #636363; margin: 4em 0 1em; }
	.game_links { color: #4e99c7; text-decoration: none;text-decoration: underline; }
	p, pre { margin: 0 0 1.2em; }
	::selection { color: #fff; background: #328efd; }
	::-moz-selection { color: #fff; background: #328efd; }

	@media (max-width:480px) {
		h1 { font-size: 3em; }
		h2 { font-size: 1.8em; }
		h3 { font-size: 1.5em; }
		td:first-child { white-space: normal; }
	}

	.inline-code { padding: 1px 5px; background: #eee; border-radius: 2px; }
	pre { padding: 15px 10px; font-size: .9em; color: #555; background: #edf3f8; }
	pre i { color: #aaa; } /* comments */
	pre b { font-weight: normal; color: #cf4b25; } /* strings */
	pre em { color: #0c59e9; } /* numeric */

	/* Pure CSS */
	.pure-button { margin: 5px 0; text-decoration: none !important; }
	.button-lg { margin: 5px 0; padding: .65em 1.6em; font-size: 105%; }

	/* required snapPuzzle styles */
	.snappuzzle-wrap { position: relative; display: block; }
	.snappuzzle-pile { position: relative; }
	.snappuzzle-piece { cursor: move; }
	.snappuzzle-slot { position: absolute; background: #fff; opacity: .8; }
	.snappuzzle-slot-hover { background: #eee; }
</style>



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
		 
			<div class="pure-u-1 pure-u-md-1-2" style="width: 45%;">
				<a style="text-decoration:underline;" class="fancybox fancybox.ajax" href="#">
					<span style="font:bold 1em sans-serif;color: #636363;">Game Instructions</span>
				</a>
			</div>

			<br><br>
		<div class="col-md-2">
			<div class="alert alert-info">
				<p class="text-center"><b>Game Level</b></p>
                    <h4 class="text-center"><b><?php echo $gm_result['CurrentLevel']; ?></b></h4>       
			</div>
		</div>
	</div>		
       <br>
        <div class="box box-info">
			    
				<form action="#" method="post">

				<div id="title" ><h2>Snap Puzzle</h4></div> 


				<div id="puzzle-containment" style="border-top: 1px solid #eee;border-bottom:1px solid #eee;background:#fafafa;margin:30px 0;padding:10px;text-align:center">
	
					<div class="pure-g" style="max-width:1280px;margin:auto">
						
						<div style="max-width:900px;margin:15px auto;text-align:center">
							<div id="clockcontainer">
								<div id="countdown-1"></div>
							 </div>
						</div>
					
						<div class="pure-u-1 pure-u-md-1-2">
							<div style="margin:10px">
								<img id="source_image" class="pure-img" src="<?php echo $this->config->item('base_url2');echo $gm_result['Game_image']; ?>">
							</div>
						</div>
						<div class="pure-u-1 pure-u-md-1-2">
							<div id="pile" style="margin:10px">
							
								<div id="puzzle_solved" style="display:none;text-align:center;position:relative;top:25%">
									<h2 style="margin:0 0 20px">Well done!</h2>
									<a class="pure-button button-lg restart-puzzle" data-grid="3">Restart Puzzle</a>
								</div>
								
							</div>
							
							<div id="puzzle_start" style="display:none;text-align:center;position:relative;margin-top:22%">
								<h2 style="margin:0 0 20px">Click To Start Puzzle</h2>
								<a class="pure-button button-lg start-puzzle" data-grid="3">Start Puzzle</a>
							</div>
							
							<div id="puzzle_unsolved" style="display:none;text-align:center;position:relative;top:25%">
								<h2 style="margin:0 0 20px">Time is Over!! Try Again</h2>
								<a class="pure-button button-lg restart-unpuzzle" data-grid="3">Restart Puzzle</a>
							</div>
						</div>
					</div>
			</div>

				<div id="fb-root"></div>
			   
						
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
		  
			  
		<?php echo form_close(); ?>
        </section><!-- /.content -->
      <?php $this->load->view('header/footer');?>
  <script src="<?php echo $this->config->item('base_url2'); ?>Game_SnapPuzzle/jquery.snap-puzzle.js"></script>    
   
<script>
	// jQuery UI Touch Punch 0.2.3 - must load after jQuery UI
	// enables touch support for jQuery UI
	!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

	

	function start_puzzle(x)
	{
		var Puzzle_image = '<?php  echo $this->config->item('base_url2');echo $gm_result['Game_image']; ?>';
		$('#puzzle_solved').hide();
		$('#puzzle_unsolved').hide();
		$('#source_image').snapPuzzle({
			rows: x, columns: x,
			pile: '#pile',
			image: Puzzle_image,
			containment: '#puzzle-containment',
			onComplete: function(){
				$('#source_image').fadeOut(150).fadeIn();
				$('#puzzle_solved').show();
				countdown_stop();				
			}
		});
	}

	$('#puzzle_start').click(function()
		{	
			//alert("why why");		
			$('#puzzle_start').hide();
			$('#pile').show();
			$('#source_image').snapPuzzle('destroy');
			// start_puzzle($(this).data('grid'));
			start_puzzle('<?php echo $gm_result['Game_matrix']; ?>');
			countdown();
		});
		
		
	$(function()
	{	
		$('#pile').height($('#source_image').height());
		start_puzzle('<?php echo $gm_result['Game_matrix']; ?>');
		
		
		
		
		$('.restart-puzzle').click(function()
		{
			$('#source_image').snapPuzzle('destroy');
			start_puzzle($(this).data('grid'));
			countdown();
		});
		
		$('.restart-unpuzzle').click(function()
		{
			$('#pile').show();
			$('#source_image').snapPuzzle('destroy');
			start_puzzle($(this).data('grid'));
			countdown();
		});

		$(window).resize(function()
		{
			$('#pile').height($('#source_image').height());
			$('#source_image').snapPuzzle('refresh');
		});
	});


	if (~window.location.href.indexOf('http')) {
		(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
		(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=114593902037957";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
		$('#github_social').html('\
			<iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-snapPuzzle&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
			<iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-snapPuzzle&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
		');
	}
</script>
