		<?php $this->load->view('header/header');?>
		<?php echo form_open_multipart('Cust_home/selectgametoplay'); 
		
		// var_dump($CompanyAuction);
		
		// echo $CompanyAuction->Auction_name;
		?>
        <section class="content-header">
          <h1>
            Play the Game
            <small></small>
          </h1>
          
        </section>

        <!-- Main content -->
        <section class="content">
		 <div class="row">
<?php			
foreach($GameMasterDetails as $game)
{		
	
	if($game['Game_image_flag']== '1')
	{
		?>
            <div class="col-md-3">
			<div class="box-header with-border">
			  <h3 class="box-title">Image Based Games</h3>
			</div><!-- /.box-header -->
             <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $game['Game_name']; ?></h3>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="100 Total Times Played" class="badge bg-light-blue">100 </span>
                    <span class="btn btn-box-tool" data-toggle="tooltip" title="Top 5 Playes" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></span>
                  </div>
                </div>
                <div class="box-body">
                 <div class="direct-chat-messages">
                   <div class="direct-chat-msg">
                      
						<img class="direct-chat-img" src="<?php echo base_url()?><?php echo $game['Game_image']; ?>" alt="<?php echo $game['Game_name']; ?>">
                     </div>
                  </div>
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="<?php echo base_url()?>dist/img/user1-128x128.jpg">
                          <div class="contacts-list-info">
                            <span class="contacts-list-name">
                               First Level
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                            <span class="contacts-list-msg">Ravi Phad</span>
                          </div>
                        </a>
                      </li>					 					  
                    </ul>
                  </div>
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                     <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Play Now...Earn Points</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
		<?php				
		}
		else if($game['Time_based_flag']== '1')
		{
		?>
            <div class="col-md-3">
			<div class="box-header with-border">
			  <h3 class="box-title">Time Based Games</h3>
			</div><!-- /.box-header -->
             <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $game['Game_name']; ?></h3>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="100 Total Times Played" class="badge bg-light-blue">100 </span>
                    <span class="btn btn-box-tool" data-toggle="tooltip" title="Top 5 Playes" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></span>
                  </div>
                </div>
                <div class="box-body">
                 <div class="direct-chat-messages">
                   <div class="direct-chat-msg">                      
						<img class="direct-chat-img" src="<?php echo base_url()?><?php echo $game['Game_image']; ?>" alt="<?php echo $game['Game_name']; ?>">
                     </div>
                  </div>
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="<?php echo base_url()?>dist/img/user1-128x128.jpg">
                          <div class="contacts-list-info">
                            <span class="contacts-list-name">
                               First Level
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                            <span class="contacts-list-msg">Ravi Phad</span>
                          </div>
                        </a>
                      </li>					 					  
                    </ul>
                  </div>
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                     <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Play Now...Earn Points</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>		
		<?php				
		}
		else if($game['Moves_based_flag']== '1')
		{
		?>
            <div class="col-md-3">
				<div class="box-header with-border">
			  <h3 class="box-title">Move Based Games</h3>
			</div><!-- /.box-header -->
             <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $game['Game_name']; ?></h3>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="100 Total Times Played" class="badge bg-light-blue">100 </span>
                    <span class="btn btn-box-tool" data-toggle="tooltip" title="Top 5 Playes" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></span>
                  </div>
                </div>
                <div class="box-body">
                 <div class="direct-chat-messages">
                   <div class="direct-chat-msg">
                      
						<img class="direct-chat-img" src="<?php echo base_url()?><?php echo $game['Game_image']; ?>" alt="<?php echo $game['Game_name']; ?>">
                     </div>
                  </div>
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="<?php echo base_url()?>dist/img/user1-128x128.jpg">
                          <div class="contacts-list-info">
                            <span class="contacts-list-name">
                               First Level
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                            <span class="contacts-list-msg">Ravi Phad</span>
                          </div>
                        </a>
                      </li>					 					  
                    </ul>
                  </div>
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                     <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Play Now...Earn Points</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
			
		<?php
		}
		else if($game['Score_based_flag']== '1')
		{
		?>
			<div class="col-md-3">
				<div class="box-header with-border">
			  <h3 class="box-title">Score Based Games</h3>
			</div><!-- /.box-header -->
             <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $game['Game_name']; ?></h3>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="100 Total Times Played" class="badge bg-light-blue">100 </span>
                    <span class="btn btn-box-tool" data-toggle="tooltip" title="Top 5 Playes" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></span>
                  </div>
                </div>
                <div class="box-body">
                 <div class="direct-chat-messages">
                   <div class="direct-chat-msg">
                      
						<img class="direct-chat-img" src="<?php echo base_url()?><?php echo $game['Game_image']; ?>" alt="<?php echo $game['Game_name']; ?>">
                     </div>
                  </div>
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="<?php echo base_url()?>dist/img/user1-128x128.jpg">
                          <div class="contacts-list-info">
                            <span class="contacts-list-name">
                               First Level
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                            <span class="contacts-list-msg">Ravi Phad</span>
                          </div>
                        </a>
                      </li>					 					  
                    </ul>
                  </div>
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                     <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Play Now...Earn Points</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
		<?php
		}
}			
?>
	</div>	
    </section>
	 <?php echo form_close(); ?>
     <?php $this->load->view('header/footer');?>
	<style> 
	 .direct-chat-img {
    border-radius: 50%;
    float: left;
    height: 90%;
    width: 100%;
}
</style>