
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title text-center" style="color:red;">
				Competition Details
			</h4>
		</div>	
			
		<div class="modal-body">

				<p>
				<?php 
				
				foreach($gm_details as $gm)
				{
					if($gm->Game_for_competition == 1)
					{
					
					echo "<b>Competition Start Date : </b>".date("d-M-Y",strtotime($gm->Competition_start_date))."<br><br>";
					echo "<b>Competition End Date : </b>".date("d-M-Y",strtotime($gm->Competition_end_date))."<br><br>";

						if($gm->Competition_winner_award == 1)
						{
							$k = 1;
							foreach($gm_prizes as $gm_prize)
							{
								echo "<b>Winner-".$k." get ".$gm_prize->Game_points_prize." Points</b><br><br>";
								$k++;
							}
						}
						else
						{
							$k = 1;
							foreach($gm_prizes as $gm_prize)
							{
								echo "<b>Winner-".$k." get ".$gm_prize->Game_points_prize." </b><br><br>";
							
								echo "<img src='".$this->config->item('base_url2');$gm_prize->Game_prize_image."' width='100px' height='70px'/> <br>";
								$k++;
							}
						}
					}
				}
				?></p>
			
			<div class="modal-footer">
				<button type="button" id="close_modal"  class="btn btn-default" >Close</button>
			</div>
	
		</div>
	</div>

<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#competition_myModal').hide();
		$("#competition_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>

