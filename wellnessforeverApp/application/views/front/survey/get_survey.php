<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
$Photograph=$Enroll_details->Photograph;
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Application Information</h4>
        </div>
        <div class="modal-body">
          <p>Company work in progress... Will be up soon...Sorry for the inconvenience</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="redBtn w-100 text-center" data-dismiss="modal" onClick="window.location.href='<?php echo base_url()?>index.php/Cust_home/front_home';">OK</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/Redeem_history';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Survey</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 pointHistoryWrapper">
			 <?php 			
			$all_survey=array();
			$all_check_survey=array();
			if($get_survey_details)
			{
                        foreach($get_survey_details as $survey)
                        {
                                $all_survey[]=$survey['Survey_id'];
                                if($survey['Survey_type']==1)
                                {
                                        $Survey_type='Feedback Survey';

                                }
                                else if($survey['Survey_type']==2)
                                {
                                        $Survey_type='Service Related Survey';
                                }
                                else if($survey['Survey_type']==3)
                                {
                                        $Survey_type='Product Survey';
                                }					
                                
                               /*  $survey_total_response = $this->Survey_model->Check_total_survey_response($Enroll_details->Company_id,$Enroll_details->Enrollement_id,$survey['Survey_id']);
                                $all_check_survey[]=$survey_total_response->Survey_id;	 */			
                                $survey_response = $this->Survey_model->Check_survey_response($Enroll_details->Company_id,$Enroll_details->Enrollement_id,$survey['Survey_id']);					

                                // echo"--survey_response----".$survey_response->Survey_id."---<br>";
                                if($survey_response==0)
                                {
                                        $survey_question = $this->Survey_model->Check_survey_question($Enroll_details->Company_id,$survey['Survey_id']);	
                                        // $all_check_survey[]=$survey['Survey_id'];
                                        // echo"--survey_question----".$survey_question."---<br>";
                                        if($survey_question >0)
                                        {

                                                ?>
                <ul class="poinHistHldr">
                  
                    <li>
                        <div class="cardMain d-flex align-items-center w-100">
                          
                            <div class="titleTxtMain d-flex flex-column">
                                <div class="cf d-flex align-items-center">
                                    <div class="flex-grow-1"><h2><?php echo $survey['Survey_name']; ?></h2></div>
                                    <div class="greyTxt"><?php //echo $Trans_date; ?></div>
                                </div>
                               <br>
                                <div class="cf d-flex align-items-center">
                                    <div class="flex-grow-1"><span class="greyTxt">Reward <?php echo $Company_Details->Currency_name; ?></span> <b><?php echo $survey['Survey_reward_points']; ?></b></div>
                                 </div><br>
                                <div class="cf d-flex align-items-center">
                                    <div class="flex-grow-1"><span class="greyTxt">Survey Type</span> <b><?php echo $Survey_type; ?></b></div>
                                 </div>
								 <br>
                                <div class="cf d-flex align-items-center">
                                     <a href="#"  onclick="return get_new_survey(<?php echo $survey['Survey_id']; ?>);" class="redBtn w-100 text-center">Take Survey</a>
                                 </div>
                            </div>
                            
                        </div>
                    </li>
                  
                </ul>
                	 <?php } else {  ?>				
					<div class="row">
						<div class="col-12 pr-2">
							<h6 class="text-center dark-bg p-2"><b>It seems you have given the survey or you do not have any survey</b></h6>
						</div>
					</div>	
			  <?php
                                        }
                                }	
                        }
                }
                // print_r($all_survey);
                // print_r($all_check_survey);
                if($all_survey == $all_check_survey) 
                {
                 ?>
				 <div class="row">
						<div class="col-12 pr-2">
							<h6 class="text-center dark-bg p-2"><b>It seems you have given the survey or you do not have any survey</b></h6>
						</div>
					</div>	
				      <?php	
			}
			?>	
            </div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
<script>
function get_new_survey(surID)
{
	// alert('---surID---'+surID);
        // return false;
        var smartphone_flag=<?php echo $smartphone_flag; ?>;
    // alert('---smartphone_flag---'+smartphone_flag);
   // return false;
    
	if(surID != "" || surID != 0)
	{
		
		var Survey_id=surID;
		// url='<?php echo base_url()?>index.php/Cust_home/getsurveyquestion?Survey_id='+surID+'&Company_id='+Comp+'&Enroll_id='+Enroll_id+'&Card_id='+Card_id+'&smartphone_flag='+smartphone_flag;	
		url='<?php echo base_url()?>index.php/Cust_home/getsurveyquestionApp?Survey_data='+surID;	
		
		/* if(smartphone_flag==2)
		{
			window.open(url, '_blank','width=700, height=500');
		}
		else
		{ */
			window.location=url;
		// }
	}
	
}
</script>
<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
		$('#myModal').modal('show');		
	</script>
<?php } ?>
<!------------------------------------------------------------------------------------------------------->