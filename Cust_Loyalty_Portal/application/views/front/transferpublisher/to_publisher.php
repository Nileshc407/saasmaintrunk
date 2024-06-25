<div class="list-group" id="message2">
	
	<?php 
		//echo "-----From_publisher-----".$From_publisher."--<br>";
		//echo "-----From_beneficiary_id-----".$From_beneficiary_id."--<br>";
		// die;
		if($Get_Beneficiary_members!=NULL)	
		{
			foreach($Get_Beneficiary_members as $Rec2)
			{		
				// if($From_beneficiary_id != $Rec2->Beneficiary_membership_id ) {
				
				?>							
					<a href="javascript:void(0);" onclick="check_to_publisher(<?php echo $From_publisher; ?>,<?php echo $From_beneficiary_id; ?>,<?php echo $Rec2->Register_beneficiary_id; ?>,<?php echo $Rec2->Beneficiary_membership_id; ?>);" class="list-group-item text-center" >
						<div class="row">
							<div class="col-lg-6">
							
									<img src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" width="60" > 
									<span><?php echo $Rec2->Beneficiary_company_name ?></span>
									
							</div><!-- col-lg-6 -->
							<div class="col-lg-6">
								<span >Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span><?php echo $Rec2->Beneficiary_name; ?></span><br>
								<span>Identifier&nbsp;:</span>  <span><?php echo $Rec2->Beneficiary_membership_id; ?></span> 
							</div><!-- col-lg-6 -->
						</div><!-- /.row -->
					</a>
				<?php 
				//}
			}
		} 
	?>		
</div>
<script>
$(document).ready(function() {	
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {		
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>