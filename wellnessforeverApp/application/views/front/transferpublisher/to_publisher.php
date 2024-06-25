<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Load Publisher </title>	
	<?php $this->load->view('front/header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
  </head>
  <body>
  <!--<form  name="search_publisher" method="POST" action="<?php echo base_url()?>index.php/Transfer_publisher/Search_publisher" enctype="multipart/form-data">-->      
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            <div class="section-header">          
                <p><a href="<?php echo base_url(); ?>index.php/Cust_home/Transfer_points_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">To Publisher</p>
            </div>
                 <div class="row pricing-tables">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
                                <div class="pricing-details">
                                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search" title="Type in a name">
                                </div>				  
                        </div>
                    </div>
                </div>
                <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                    <div id="Beneficiary_div" ></div>
                         <?php if(empty($Get_Beneficiary_members)) { ?>							
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">			
                                        <address>
                                            <button type="button" id="button1" >No Records Found</button>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <table id="myTable" >
                                        <?php 
                                        
                                        //echo"---From_publisher---".$From_publisher."--<br>";
                                        //echo"---From_beneficiary_id---". $From_beneficiary_id."--<br>";
                                        
                                        if($Get_Beneficiary_members) {                                       
                                            foreach($Get_Beneficiary_members as $Rec2) { 
                                                //echo"---Igain_company_id---". $Rec2->Igain_company_id."--<br>";
                                                $Company_details= $this->Igain_model->get_company_details($Rec2->Igain_company_id);
                                                if($From_beneficiary_id != $Rec2->Beneficiary_membership_id ) {
                                                ?>
                                             
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>index.php/Transfer_publisher/Transfer_publisher_points?From_publisher=<?php echo $From_publisher; ?>&From_beneficiary_id=<?php echo $From_beneficiary_id; ?>&To_publisher=<?php echo $Rec2->Beneficiary_company_id; ?>&To_beneficiary_id=<?php echo $Rec2->Beneficiary_membership_id; ?>">
                                                        <img src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" alt="" class="img-rounded img-responsive" width="80">
                                                    </a>
                                                </td>   
                                                <td>
                                                    <a href="<?php echo base_url(); ?>index.php/Transfer_publisher/Transfer_publisher_points?From_publisher=<?php echo $From_publisher; ?>&From_beneficiary_id=<?php echo $From_beneficiary_id; ?>&To_publisher=<?php echo $Rec2->Beneficiary_company_id; ?>&To_beneficiary_id=<?php echo $Rec2->Beneficiary_membership_id; ?>">
                                                      <span id="Small_font"><?php echo $Rec2->Beneficiary_company_name ?></span><br>
                                                      <span id="Small_font">Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span id="Value_font"><?php echo $Rec2->Beneficiary_name; ?></span><br>
                                                      <span id="Small_font">Identifier&nbsp;:</span>  <span id="Value_font"><?php echo $Rec2->Beneficiary_membership_id; ?></span><br> 
                                                    </a>
                                                </td>
                                                <td> 
                                                    <a href="<?php echo base_url(); ?>index.php/Transfer_publisher/Transfer_publisher_points?From_publisher=<?php echo $From_publisher; ?>&From_beneficiary_id=<?php echo $From_beneficiary_id; ?>&To_publisher=<?php echo $Rec2->Beneficiary_company_id; ?>&To_beneficiary_id=<?php echo $Rec2->Beneficiary_membership_id; ?>">
                                                        <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" alt="" class="img-rounded img-responsive" width="15" >
                                                    </a>
                                                </td>
                                            </tr>
                                            </a>
                                        <?php	
                                           }
                                        
                                            }
                                        }			
                                        ?>   
                                    </table>		
                                </div>
                            </div>
                        </div>
                    <br>
                    </div>                    
                </div>
            </div>  
        </div>
    </div>
  <!--</form>-->
    <!-- End Pricing Table Section-->
		
	<!-- Loader -->
	<div class="container" >
		<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
						<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			</div>
		</div>       
	</div>
	<!-- Loader -->
        
  </body>
<?php $this->load->view('front/header/footer'); ?> 
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

    document.search_publisher.submit();
} 
</script>
<style>	
#icon{
	float: right;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
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
</style>
<script>
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
</script>