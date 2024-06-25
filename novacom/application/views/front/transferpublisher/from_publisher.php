<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Load Publisher </title>	
	<?php $this->load->view('header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
  </head>
  <body>
	<?php
	if(@$this->session->flashdata('error_transfer'))
	{
		?>
		<script>
			var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('error_transfer'); ?>';
			runjs(Title,msg);
		</script>
		<?php
	}
	?>
	<section class="content-header">
		<h1> Transfer Points</h1>         
	</section>  
	<section class="content">
        <div class="row">				
				<div class="panel panel-info" style="margin-bottom:0px">
				<div class="panel-heading text-center">
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-center">From Publisher Accounts</h4>							
						</div>
						<div class="col-md-6">							
							<h4 class="text-center">To Publisher Accounts</h4>
						</div>
					</div>
				</div>
				<div class="col-md-6 bhoechie-tab-menu" >
					<div class="list-group">
					<?php 
						if($Get_Beneficiary_members!=NULL)	
						{
							foreach($Get_Beneficiary_members as $Rec2)
							{								 
								?>							
									<a href="javascript:void(0);" onclick="get_to_publisher_account(<?php echo $Rec2->Beneficiary_company_id; ?>,<?php echo $Rec2->Beneficiary_membership_id; ?>);" class="list-group-item text-center" >
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
							}
						}
						else{
							?>
								<div class="panel panel-info">
									<div class="panel-heading text-center">
										<div class="row">
											<div class="col-lg-3">
											
											</div>
											<div class="col-lg-6">
												<span>No records found</span>
											</div><!-- col-lg-6 -->
											
										</div><!-- /.row -->
									</div><!-- /.row -->
								</div><!-- /.row -->
							<?php
						}
					?>					
					</div>
				</div>
				</div>
				<div class="col-md-6 bhoechie-tab-menu" id="message2"  >
				
					<div class="panel panel-info">
						<div class="panel-heading text-center">
							<div class="row">
								<div class="col-lg-3">
								
								</div>
								<div class="col-lg-6">
									<span>Please Select From Publisher Accounts</span>
								</div><!-- col-lg-6 -->
								
							</div><!-- /.row -->
						</div><!-- /.row -->
					</div><!-- /.row -->
						
				</div>
		</div><!-- /.row -->
		
	</section><!-- /.content -->
	
	
   
	
        
  </body>
<?php $this->load->view('header/loader'); ?> 
<?php $this->load->view('header/footer'); ?> 

<script>
function get_to_publisher_account(Beneficiary_company_id,Beneficiary_membership_id){
	
	if( Beneficiary_company_id > 0 &&  Beneficiary_membership_id > 0 )
	{		
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {From_publisher: Beneficiary_company_id, Company_id: Company_id,From_beneficiary_id:Beneficiary_membership_id},
			url: "<?php echo base_url()?>index.php/Transfer_publisher/To_publisher",
			success: function(data)
			{
				$("#message2").html(data.TOPublisher);		
			}
		});
	}
}
function check_to_publisher(From_publisher,From_beneficiary_id,To_publisher,To_beneficiary_id){
	
	// alert('--From_publisher---'+From_publisher+'---From_beneficiary_id--'+From_beneficiary_id+'--To_publisher---'+To_publisher+'--To_beneficiary_id---'+To_beneficiary_id);
	
	
	var match = ((From_publisher == To_publisher) && (From_beneficiary_id==To_beneficiary_id));
	// alert(match);
	if(match== false)
	{
		if( From_publisher > 0 &&  From_beneficiary_id > 0 &&  To_publisher > 0 &&  To_beneficiary_id > 0 )
		{		
			var Company_id = '<?php echo $Company_id; ?>';
			
			
			
			BootstrapDialog.confirm("Are you sure to use account <b> "+To_beneficiary_id+"</b> for this transaction. ", function(result) 
			{
				var url = '<?php echo base_url(); ?>index.php/Transfer_publisher/Transfer_publisher_points/?From_publisher='+From_publisher+'&From_beneficiary_id='+From_beneficiary_id+'&To_publisher='+To_publisher+'&To_beneficiary_id='+To_beneficiary_id;
				if (result == true)
				{
					show_loader();
					window.location = url;
					return true;
				}
				else
				{
					return false;
				}
			});
			
			// window.location.href='<?php echo base_url(); ?>index.php/Transfer_publisher/Transfer_publisher_points/?From_publisher='+From_publisher+'&From_beneficiary_id='+From_beneficiary_id+'&To_publisher='+To_publisher+'&To_beneficiary_id='+To_beneficiary_id;
		}		
	}
	else {
		
			var Title = "Application Information";
			var msg = "Can not use same publisher account for transfer";
			runjs(Title,msg);
		
	}
}
</script>
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

<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 5px 5px 10px 40px;
  border: 1px solid #ddd;
  
}

#myInput1 {
  background-image: url('<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 5px 5px 10px 40px;
  border: 1px solid #ddd;
  
}

#myTable {
     width: 100%;
/*  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;*/
}

#myTable th, #myTable td {
  text-align: left;
/*  padding: 12px;*/
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}

.highlight { background-color: #382921; }
</style>
<script>

/* 

function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function myFunction1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable1");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
} */
</script>