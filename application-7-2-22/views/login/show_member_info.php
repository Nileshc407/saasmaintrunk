<?php
if($res14 != NULL)
{
?>
<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">		
				<h4 class="text-center"> Welcome Mr/Mrs. <?php echo $res14['Name']; ?> </h4>								
			</div>
			
			<div class="panel-body bg-primary">
				
				<div>
					<p class="col-md-6 text-left"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> &nbsp;&nbsp;
						<b>Card ID </b>
					</p>
					<p class="col-md-6" id="giftcard_email"><?php echo $res14['Card_id']; ?></p>
				</div>
				
				<div>
					<p class="col-md-6 text-left"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> &nbsp;&nbsp;
						<b>Email ID </b>
					</p>
					<p class="col-md-6" id="giftcard_email"><?php echo $res14['User_email_id']; ?></p>
				</div>
				
				<div>
					<p class="col-md-6 text-left"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> &nbsp;&nbsp;
						<b>Phone No </b>
					</p>
					<p class="col-md-6" id="giftcard_phno"><?php echo $res14['Phone_no']; ?></p>
				</div>
				
			</div>
			<div class="panel-footer">	
				<p class="text-right">
					<button type="button" id="close" class="btn btn-default" data-dismiss="show_member_info">Close</button>
				</p>
			</div>
		</div>
			
	</div>
<?php
}
else
{
?>
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">		
				<h4 class="text-center">Sorry, Your card is invalid!</h4><br>								
			</div>
			<div class="panel-footer">
				<p class="text-right">
					<button type="button" id="close" class="btn btn-default" data-dismiss="show_member_info">Close</button>
				</p>
			</div>
		</div>
		
		
	</div>
<?php
}
?>
 
<script>
$(document).ready(function() 
{	
	$( "#close" ).click(function(e)
	{
		$('#receipt_myModal').hide();
		$("#receipt_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
		$("#member_id").focus();
	});
});
</script>


