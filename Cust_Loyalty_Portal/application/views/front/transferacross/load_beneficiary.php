<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Publisher </title>	
	<?php $this->load->view('header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
  </head>
  <body>	
	<section class="content-header">
		<h1> Loyalty Publisher </h1>         
	</section>	
	<?php						
	if(@$this->session->flashdata('error_code'))
	{
	?>
		<script>
			var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
			runjs(Title,msg);
		</script>
	<?php
	}				
	?>
	<section class="content">
        <div class="row">			
			<!--<div class="col-lg-5 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">-->
			
				<div class="col-md-6 bhoechie-tab-menu">
					<div class="list-group">
					<?php 
						if($Publishers_Category!=NULL)	
						{
							foreach($Publishers_Category as $Category)
							{								 
								$CategoryID=$Category->Code_decode_id;
								// echo"----Category-----".$Category[0][0]['Code_decode_id']."<br>";
								// echo"----Category-----".$Category[0][0]->Beneficiary_company_name."<br>";
								if($CategoryID==47)
								{
									$icon_name='air.png';
								}
								else if($CategoryID==48)
								{
									$icon_name='hospitality.png';
								}
								else if($CategoryID==49)
								{
									$icon_name='retail.png';
								}
								else if($CategoryID==50)
								{
									$icon_name='telecom.png';
								}
								else if($CategoryID==51)
								{
									$icon_name='car.png';
								}
								else
								{
								  $icon_name='';
								}
								
								
								?>								
								
									<a href="javascript:void(0);" onclick="get_category_publisher('<?php echo $CategoryID; ?>');" class="list-group-item text-center" >
										<img src="<?php echo base_url(); ?>images/<?php echo $icon_name;?>" > <br> <span id="Medium_font"><?php echo $Category->Code_decode; ?></span>
									</a>
									
								
								<?php 								
							}
						} 
					?>
					
				  </div>
				</div>
				
			
			<div class="col-lg-6" id="message2" style="overflow-y: scroll; height: 480px;">
						
			</div>
			
		</div><!-- /.row -->
		
	</section><!-- /.content -->
	
	
<?php $this->load->view('header/footer'); ?> 
<style>	
#icon{
	float: right;
	 width: 6%;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
	
	
	
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #31859c;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #31859c;
  background-image: #31859c;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #31859c;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  /* padding-left: 20px;
  padding-top: 10px; */
  
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}



</style>
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


<script>
function get_category_publisher(CategoryID){
	
	// alert(CategoryID);
	
	if( CategoryID > 0 )
	{		
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {CategoryID: CategoryID, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Beneficiary/get_category_publisher",
			success: function(data)
			{
				// $('#message2').html(data);
				
				$("#message2").html(data.CategoryPublisher);		
			}
		});
	}
}
</script>