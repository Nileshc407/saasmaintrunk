<?php 	
 $this->load->view('header/header');
 $i = 1; 
 $GameLevelScore = 500 * $gm_result['CurrentLevel'];
?>
	
<style>
    #tetris   { margin: 1em auto; padding: 0.50em; border: 4px solid black; border-radius: 10px; background-color: #F8F8F8; }
    #stats    { display: inline-block; vertical-align: top; }
    #canvas   { display: inline-block; vertical-align: top; background: url('<?php echo $this->config->item('base_url2'); ?>Game_TertisGame/texture.jpg'); box-shadow: 10px 10px 10px #999; border: 2px solid #333; }
    #menu     { font-size:14px; display: inline-block; vertical-align: top; position: relative; }
    #menu p   { margin: 0.2em 0; text-align: center; }
    #menu p a { text-decoration: none; color: black; }
    #upcoming { display: block; margin: 0 auto; background-color: #E0E0E0; }
    #score,#score12    { color: red; font-weight: bold; vertical-align: middle; }
    #rows     { color: blue; font-weight: bold; vertical-align: middle; }
    #stats    { position: absolute; bottom: 0em; right: 1em; }
	#menu button { height: 6%; width: 37%; }
	
	#tetris { font-size: 12px;width: 97%; height: 650px;}
	#menu { height: 730px; width: 35%; } 
	#upcoming { width: 150px; height: 150px; } 
	#canvas { height: 795px;width: 45%;  height: 620px;}
	
	/*
	 @media screen and (min-width: 320px) and (min-height: 480px)  
	{ 
		#canvas { height: 335px; width: 56%; }
		#upcoming { height: 50px; width: 84px;}
		#menu button{ font-size:10px; height: 5%; width: 58%;}
		#tetris { font-size: 1em; width: 265px;  height: 380px;}
		
	}
	 */
  </style>
  

	<script>

	
	function countdown(min,sec,i) 
			{

				// alert("---hour--"+hour+"--min--"+min+"---I---"+i);

				if(sec <= 0 && min > 0) {
					sec = 59;
					min -= 1;
				}
				else if(min <= 0 && sec <= 0) {
					min = 0;
					sec = 0;
				}
				else {
					sec -= 1;
				}

				
				 
				var pat = /^[0-9]{1}$/;
				sec = (pat.test(sec) == true) ? '0'+sec : sec;
				min = (pat.test(min) == true) ? '0'+min : min;

				var Minutes = 'Minutes_'+i;
				var Seconds = 'Seconds_'+i;
				
				//document.getElementById(Minutes).innerHTML = min+" : Min ";
				document.getElementById(Seconds).innerHTML = "Remaining Time : "+sec+"  Seconds";
				
				if(sec > 0)
				{
					setTimeout(
						function()
						{ 
							countdown(min,sec,i);
						}, 
					1000
					);
				}
				else
				{
					level_fail();
				}
		 }
		 

	function callmenow()
	{
		var Flag = 1;
	
		sec = 0;
		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';

		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		var score = 0;
		
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_next_level/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type+"&score="+score;
		
	}
	
	function level_fail()
	{
		sec = 0;
		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var GameLevelScore = 500;
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';

		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		var score = 0;
		
		
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_level_fail/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type;
	}
</script>

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
		
		<?php
	if($gm_result['livesFlag'] &&  $gm_result['game_type'] == 3 )
	{
		if($gm_result['Highest_game_score']  >  0 && $gm_result['max_score_user_enrollID'] == $Enroll_details->Enrollement_id)
		{
	?>
		<span style="font:bold 1em sans-serif;color: red;">Congratulations! you have the Highest Score!</span>
	<?php
		}
		else if( $gm_result['CurrentLevel'] ==1 && $gm_result['Game_iteration'] =="")
		{
		?>
			<span style="font:bold 1em sans-serif;color: red;">Please play the game and make high score to get on the TOP!</span>
		<?php 
		}
		else
		{
	?>
		<span style="font:bold 1em sans-serif;color: red;">You are No more Higest Scorer. Please play the game and get to the TOP!</span>
	<?php
		}
	}
	?>	
		<br><br>
		
		
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
	
	<?php if($gm_result['Game_for_competition'] == 1 && $gm_result['game_type'] == 3){ ?>
		
		
				<a style="text-decoration:underline;" class="fancybox fancybox.ajax" href="#" onclick="competition_details();">
					<span style="font:bold 1em sans-serif;color: #636363;">View Competiton Details</span>
				</a>

			
	<?php } ?>
			
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
			
	<?php if($gm_result['game_type'] == 3 ){ ?>
			<div class="col-md-2">
				<div class="alert alert-info">
				<p class="text-center"><b>Highest Score</b></p>
                    <h4 class="text-center"><b><?php echo $gm_result['Highest_game_score']; ?></b></h4>       
				</div>
			
			</div>
			
	<?php  } ?>					
		</div>		


        <div class="box box-info">
			 
				<form action="#" method="post"> 
					 
					<div class="description-block">
						<span class="label label-info" id="Seconds_<?php echo $i; ?>"></span>
								
					</div>
				  <div id="tetris">
					<div id="menu">
						<?php if($gm_result['livesFlag'] ){ 
								if($gm_result['game_lives'] > 0)
								{
							?>
						   <p id="start"><a href="javascript:play();"><u>START GAME </u></a></p>
						<?php 
							}
							else
							{
								echo "<h4>Please purchase lives to play game.</h4>";
							}
						
						}else { ?>
							<p id="start"><a href="javascript:play();"><u>START GAME </u></a></p>
						<?php } ?>   
						   <div id="clockcontainer">
								<div id="countdown-1"></div>
							</div>
						   
						  <p><canvas id="upcoming"></canvas></p>
						  <p>score <span id="score">00000</span></p>
						  <p>required score <span  id="score12"><?php echo $GameLevelScore; ?></span></p>
						  <p>rows <span id="rows">0</span></p>
						  <p>Controlls: <br>
							<button name="upbutton" onclick="return keydown(this.value);" value="38"> action</button><br>
							<button name="leftbutton" onclick="return keydown(this.value);" value="37"> < </button>
							<button name="rightbutton" onclick="return keydown(this.value);" value="39"> > </button><br>
							<button name="downbutton" onclick="return keydown(this.value);" value="40"> pull down</button>

						  </p>
					</div>
					<canvas id="canvas">
						
					  Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
					</canvas>
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
	<!-- Modal -->
		<div id="competition_myModal" class="modal fade" role="dialog">
			<div class="modal-dialog" id="show_competition_details">

			</div>
	 
		</div>
	<!-- Modal -->
		  
		<?php echo form_close(); ?>
        </section><!-- /.content -->
      <?php $this->load->view('header/footer');?>
      
<script src="<?php echo $this->config->item('base_url2'); ?>Game_TertisGame/stats.js"></script>
<script>
    //-------------------------------------------------------------------------
    // base helper methods
    //-------------------------------------------------------------------------
    function get(id)        { return document.getElementById(id);  }
    function hide(id)       { get(id).style.visibility = 'hidden'; }
    function show(id)       { get(id).style.visibility = null;     }
    function html(id, html) { get(id).innerHTML = html;            }
    function timestamp()           { return new Date().getTime();                             }
    function random(min, max)      { return (min + (Math.random() * (max - min)));            }
    function randomChoice(choices) { return choices[Math.round(random(0, choices.length-1))]; }
    if (!window.requestAnimationFrame) { // http://paulirish.com/2011/requestanimationframe-for-smart-animating/
      window.requestAnimationFrame = window.webkitRequestAnimationFrame ||
                                     window.mozRequestAnimationFrame    ||
                                     window.oRequestAnimationFrame      ||
                                     window.msRequestAnimationFrame     ||
                                     function(callback, element) {
                                       window.setTimeout(callback, 1000 / 60);
                                     }
    }
    //-------------------------------------------------------------------------
    // game constants
    //-------------------------------------------------------------------------
    var KEY     = { ESC: 27, SPACE: 32, LEFT: 37, UP: 38, RIGHT: 39, DOWN: 40 },
        DIR     = { UP: 0, RIGHT: 1, DOWN: 2, LEFT: 3, MIN: 0, MAX: 3 },
        stats   = new Stats(),
        canvas  = get('canvas'),
        ctx     = canvas.getContext('2d'),
        ucanvas = get('upcoming'),
        uctx    = ucanvas.getContext('2d'),
        speed   = { start: 0.6, decrement: 0.04, min: 0.1 }, // how long before piece drops by 1 row (seconds)
        // speed   = { start: 0.10, decrement: 0.05, min: 0.4 }, // how long before piece drops by 1 row (seconds)
        nx      = 12, // width of tetris court (in blocks)
        ny      = 24, // height of tetris court (in blocks)
        nu      = 3;  // width/height of upcoming preview (in blocks)
    //-------------------------------------------------------------------------
    // game variables (initialized during reset)
    //-------------------------------------------------------------------------
    var dx, dy,        // pixel size of a single tetris block
        blocks,        // 2 dimensional array (nx*ny) representing tetris court - either empty block or occupied by a 'piece'
        actions,       // queue of user actions (inputs)
        playing,       // true|false - game is in progress
        dt,            // time since starting this game
        current,       // the current piece
        next,          // the next piece
        score,         // the current score
        vscore,        // the currently displayed score (it catches up to score in small chunks - like a spinning slot machine)
        rows,          // number of completed rows in the current game
        step;          // how long before current piece drops by 1 row
    //-------------------------------------------------------------------------
    // tetris pieces
    //
    // blocks: each element represents a rotation of the piece (0, 90, 180, 270)
    //         each element is a 16 bit integer where the 16 bits represent
    //         a 4x4 set of blocks, e.g. j.blocks[0] = 0x44C0
    //
    //             0100 = 0x4 << 3 = 0x4000
    //             0100 = 0x4 << 2 = 0x0400
    //             1100 = 0xC << 1 = 0x00C0
    //             0000 = 0x0 << 0 = 0x0000
    //                               ------
    //                               0x44C0
    //
    //-------------------------------------------------------------------------
    var i = { size: 4, blocks: [0x0F00, 0x2222, 0x00F0, 0x4444], color: 'cyan'   };
    var j = { size: 3, blocks: [0x44C0, 0x8E00, 0x6440, 0x0E20], color: 'blue'   };
    var l = { size: 3, blocks: [0x4460, 0x0E80, 0xC440, 0x2E00], color: 'orange' };
    var o = { size: 2, blocks: [0xCC00, 0xCC00, 0xCC00, 0xCC00], color: 'yellow' };
    var s = { size: 3, blocks: [0x06C0, 0x8C40, 0x6C00, 0x4620], color: 'green'  };
    var t = { size: 3, blocks: [0x0E40, 0x4C40, 0x4E00, 0x4640], color: 'purple' };
    var z = { size: 3, blocks: [0x0C60, 0x4C80, 0xC600, 0x2640], color: 'red'    };
    //------------------------------------------------
    // do the bit manipulation and iterate through each
    // occupied block (x,y) for a given piece
    //------------------------------------------------
    function eachblock(type, x, y, dir, fn) {
      var bit, result, row = 0, col = 0, blocks = type.blocks[dir];
      for(bit = 0x8000 ; bit > 0 ; bit = bit >> 1) {
        if (blocks & bit) {
          fn(x + col, y + row);
        }
        if (++col === 4) {
          col = 0;
          ++row;
        }
      }
    }
    //-----------------------------------------------------
    // check if a piece can fit into a position in the grid
    //-----------------------------------------------------
    function occupied(type, x, y, dir) {
      var result = false
      eachblock(type, x, y, dir, function(x, y) {
        if ((x < 0) || (x >= nx) || (y < 0) || (y >= ny) || getBlock(x,y))
          result = true;
      });
      return result;
    }
    function unoccupied(type, x, y, dir) {
      return !occupied(type, x, y, dir);
    }
    //-----------------------------------------
    // start with 4 instances of each piece and
    // pick randomly until the 'bag is empty'
    //-----------------------------------------
    var pieces = [];
    function randomPiece() {
      if (pieces.length == 0)
        pieces = [i,i,i,i,j,j,j,j,l,l,l,l,o,o,o,o,s,s,s,s,t,t,t,t,z,z,z,z];
      var type = pieces.splice(random(0, pieces.length-1), 1)[0];
      return { type: type, dir: DIR.UP, x: Math.round(random(0, nx - type.size)), y: 0 };
    }
    //-------------------------------------------------------------------------
    // GAME LOOP
    //-------------------------------------------------------------------------
    function run() {
      showStats(); // initialize FPS counter
      addEvents(); // attach keydown and resize events
      var last = now = timestamp();
      function frame() {
        now = timestamp();
        update(Math.min(1, (now - last) / 1000.0)); // using requestAnimationFrame have to be able to handle large delta's caused when it 'hibernates' in a background or non-visible tab
        draw();
        stats.update();
        last = now;
        requestAnimationFrame(frame, canvas);
      }
      resize(); // setup all our sizing information
      reset();  // reset the per-game variables
      frame();  // start the first frame
    }
    function showStats() {
      stats.domElement.id = 'stats';
      get('menu').appendChild(stats.domElement);
    }
    function addEvents() {
      document.addEventListener('keydown', keydown, false);
      window.addEventListener('resize', resize, false);
    }
    function resize(event) {
      canvas.width   = canvas.clientWidth;  // set canvas logical size equal to its physical size
      canvas.height  = canvas.clientHeight; // (ditto)
      ucanvas.width  = ucanvas.clientWidth;
      ucanvas.height = ucanvas.clientHeight;
      dx = canvas.width  / nx; // pixel size of a single tetris block
      dy = canvas.height / ny; // (ditto)
      invalidate();
      invalidateNext();
    }
    function keydown(ev) {
	
	//alert("here ..."+ev);
      var handled = false;
      if (playing) {
        switch(ev) {
         // case KEY.LEFT:   actions.push(DIR.LEFT);  handled = true; break;
         // case KEY.RIGHT:  actions.push(DIR.RIGHT); handled = true; break;
         // case KEY.UP:     actions.push(DIR.UP);    handled = true; break;
        //  case KEY.DOWN:   actions.push(DIR.DOWN);  handled = true; break; 
		
		case '37':   actions.push(DIR.LEFT);  handled = true; break;
          case '39':  actions.push(DIR.RIGHT); handled = true; break;
          case '38':     actions.push(DIR.UP);    handled = true; break;
          case '40':   actions.push(DIR.DOWN);  handled = true; break;
		  
		  
          //case KEY.ESC:    lose();                  handled = true; break;
        }
      }
      else if (ev.keyCode == KEY.SPACE) {
        play();
        handled = true;
      }
	  
	  return false;
      if (handled)
	  
	 // alert("here ..."+ev+"--handled--"+handled);
        ev.preventDefault(); // prevent arrow keys from scrolling the page (supported in IE9+ and all other browsers)
    }
    //-------------------------------------------------------------------------
    // GAME LOGIC
    //-------------------------------------------------------------------------
    function play() 
	{
		show('clockcontainer');
		var hour = '00';
		var min = '00';
		var sec = '<?php echo $gm_result['Time_for_level']; ?>';

		var i = '<?php echo $i; ?>';
		countdown(min,sec,i);
		hide('start'); reset();          playing = true;  
	}
    function lose() 
	{		
		show('start'); setVisualScore(); playing = false; 
		
		sec = 0;
		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var GameLevelScore = 500;
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';

		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		var score = 0;
		
		
		window.location = "<?php echo base_url()?>index.php/Cust_home/game_level_fail/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type;
	}
	
    function setVisualScore(n)      { vscore = n || score; invalidateScore(); }
    function setScore(n)            { score = n; setVisualScore(n);  }
    function addScore(n)            
	{
		score = score + n;  
		var Flag = 1;
		
		sec = 0;
		var level_time = '<?php echo $gm_result['Time_for_level']; ?>';
		var MemberID = '<?php echo $Enroll_details->Card_id; ?>';

		var Comp_Game_ID = '<?php echo $gm_result['Company_game_id']; ?>';
		var GameLevel = '<?php echo $gm_result['CurrentLevel']; ?>';
		var GameLevelScore = '<?php echo $GameLevelScore; ?>';
		var CompID = '<?php echo $Company_id; ?>';
		var game_type = '<?php echo $gm_result['game_type']; ?>';
		
		if(score > GameLevelScore)
		{
			window.location = "<?php echo base_url()?>index.php/Cust_home/game_next_level/?Comp_Game_ID="+Comp_Game_ID+"&GameLevel="+GameLevel+"&MemberID="+MemberID+"&game_type="+game_type+"&score="+score;
		
		}
	}
    function clearScore()           { setScore(0); }
    function clearRows()            { setRows(0); }
    function setRows(n)             { rows = n; step = Math.max(speed.min, speed.start - (speed.decrement*rows)); invalidateRows(); }
    function addRows(n)             { setRows(rows + n); }
    function getBlock(x,y)          { return (blocks && blocks[x] ? blocks[x][y] : null); }
    function setBlock(x,y,type)     { blocks[x] = blocks[x] || []; blocks[x][y] = type; invalidate(); }
    function clearBlocks()          { blocks = []; invalidate(); }
    function clearActions()         { actions = []; }
    function setCurrentPiece(piece) { current = piece || randomPiece(); invalidate();     }
    function setNextPiece(piece)    { next    = piece || randomPiece(); invalidateNext(); }
    function reset() {
      dt = 0;
      clearActions();
      clearBlocks();
      clearRows();
      clearScore();
      setCurrentPiece(next);
      setNextPiece();
    }
    function update(idt) {
      if (playing) {
        if (vscore < score)
          setVisualScore(vscore + 1);
        handle(actions.shift());
        dt = dt + idt;
        if (dt > step) {
          dt = dt - step;
          drop();
        }
      }
    }
    function handle(action) {
      switch(action) {
        case DIR.LEFT:  move(DIR.LEFT);  break;
        case DIR.RIGHT: move(DIR.RIGHT); break;
        case DIR.UP:    rotate();        break;
        case DIR.DOWN:  drop();          break;
      }
    }
    function move(dir) {
      var x = current.x, y = current.y;
      switch(dir) {
        case DIR.RIGHT: x = x + 1; break;
        case DIR.LEFT:  x = x - 1; break;
        case DIR.DOWN:  y = y + 1; break;
      }
      if (unoccupied(current.type, x, y, current.dir)) {
        current.x = x;
        current.y = y;
        invalidate();
        return true;
      }
      else {
        return false;
      }
    }
    function rotate() {
      var newdir = (current.dir == DIR.MAX ? DIR.MIN : current.dir + 1);
      if (unoccupied(current.type, current.x, current.y, newdir)) {
        current.dir = newdir;
        invalidate();
      }
    }
    function drop() {
      if (!move(DIR.DOWN)) {
        addScore(1);
        dropPiece();
        removeLines();
        setCurrentPiece(next);
        setNextPiece(randomPiece());
        clearActions();
        if (occupied(current.type, current.x, current.y, current.dir)) {
          lose();
        }
      }
    }
    function dropPiece() {
      eachblock(current.type, current.x, current.y, current.dir, function(x, y) {
        setBlock(x, y, current.type);
      });
    }
    function removeLines() {
      var x, y, complete, n = 0;
      for(y = ny ; y > 0 ; --y) {
        complete = true;
        for(x = 0 ; x < nx ; ++x) {
          if (!getBlock(x, y))
            complete = false;
        }
        if (complete) {
          removeLine(y);
          y = y + 1; // recheck same line
          n++;
        }
      }
      if (n > 0) {
        addRows(n);
        addScore(100*Math.pow(2,n-1)); // 1: 100, 2: 200, 3: 400, 4: 800
      }
    }
    function removeLine(n) {
      var x, y;
      for(y = n ; y >= 0 ; --y) {
        for(x = 0 ; x < nx ; ++x)
          setBlock(x, y, (y == 0) ? null : getBlock(x, y-1));
      }
    }
    //-------------------------------------------------------------------------
    // RENDERING
    //-------------------------------------------------------------------------
    var invalid = {};
    function invalidate()         { invalid.court  = true; }
    function invalidateNext()     { invalid.next   = true; }
    function invalidateScore()    { invalid.score  = true; }
    function invalidateRows()     { invalid.rows   = true; }
    function draw() {
      ctx.save();
      ctx.lineWidth = 1;
      ctx.translate(0.5, 0.5); // for crisp 1px black lines
      drawCourt();
      drawNext();
      drawScore();
      drawRows();
      ctx.restore();
    }
    function drawCourt() {
      if (invalid.court) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (playing)
          drawPiece(ctx, current.type, current.x, current.y, current.dir);
        var x, y, block;
        for(y = 0 ; y < ny ; y++) {
          for (x = 0 ; x < nx ; x++) {
            if (block = getBlock(x,y))
              drawBlock(ctx, x, y, block.color);
          }
        }
        ctx.strokeRect(0, 0, nx*dx - 1, ny*dy - 1); // court boundary
        invalid.court = false;
      }
    }
    function drawNext() {
      if (invalid.next) {
        var padding = (nu - next.type.size) / 2; // half-arsed attempt at centering next piece display
        uctx.save();
        uctx.translate(0.5, 0.5);
        uctx.clearRect(0, 0, nu*dx, nu*dy);
        drawPiece(uctx, next.type, padding, padding, next.dir);
        uctx.strokeStyle = 'black';
        uctx.strokeRect(0, 0, nu*dx - 1, nu*dy - 1);
        uctx.restore();
        invalid.next = false;
      }
    }
    function drawScore() {
      if (invalid.score) {
        html('score', ("00000" + Math.floor(vscore)).slice(-5));
        invalid.score = false;
      }
    }
    function drawRows() {
      if (invalid.rows) {
        html('rows', rows);
        invalid.rows = false;
      }
    }
    function drawPiece(ctx, type, x, y, dir) {
      eachblock(type, x, y, dir, function(x, y) {
        drawBlock(ctx, x, y, type.color);
      });
    }
    function drawBlock(ctx, x, y, color) {
      ctx.fillStyle = color;
      ctx.fillRect(x*dx, y*dy, dx, dy);
      ctx.strokeRect(x*dx, y*dy, dx, dy)
    }
    //-------------------------------------------------------------------------
    // FINALLY, lets run the game
    //-------------------------------------------------------------------------
    run();
  </script>
<script>
	
	function competition_details()
	{
		var gameID = '<?php  echo $gm_result['Game_id']; ?>';
		var Company_gameID = '<?php  echo $gm_result['Company_game_id']; ?>';

		$.ajax({
			type: "POST",
			data: {gameID: gameID, Company_gameID:Company_gameID},
			url:"<?php echo base_url()?>index.php/Cust_home/get_game_competition_details",
			success: function(data)
			{	 
				$("#show_competition_details").html(data.competitionHtml);	
				$('#competition_myModal').show();
				$("#competition_myModal").addClass( "in" );	
				$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
			}
		});
	}
	
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
