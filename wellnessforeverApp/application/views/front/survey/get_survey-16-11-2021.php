<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title?></title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }  
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }?> 	
</head>
<body>
    <div id="application_theme" class="section pricing-section" style="min-height:530px;">
        <div class="container">
            <div class="section-header">          
                   <p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                    <p id="Extra_large_font">Survey</p>
            </div>

            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">

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
                                
                                $survey_total_response = $this->Survey_model->Check_total_survey_response($Enroll_details->Company_id,$Enroll_details->Enrollement_id,$survey['Survey_id']);
                                $all_check_survey[]=$survey_total_response->Survey_id;				
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
                    <!-- 3rd Card -->
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <div class="col-xs-4" style="padding: 10px;">
                                              <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/take_survey.png" alt="" class="img-rounded img-responsive" width="50">
                                        </div>

                                        <div class="col-xs-8 text-left" style="width: 70%;">
                                            <address>
                                                    <strong id="Medium_font"><?php echo $survey['Survey_name']; ?></strong><br>
                                            </address>

                                            <span>
                                                <?php if($survey['Survey_reward_points'] != '0' ) { ?>
                                                    <strong id="Small_font">Reward <?php echo $Company_Details->Currency_name; ?> : <font id="Value_font"><?php echo $survey['Survey_reward_points']; ?></font></strong><br />
                                                    <?php 
                                                        }
                                                        ?>
                                                        <strong id="Small_font">Survey Type : <font id="Value_font"><?php echo $Survey_type; ?></font></strong><br /><br />
                                                        <button type="button" id="button" onclick="return get_new_survey(<?php echo $survey['Survey_id']; ?>);" > Take Survey</button>
                                            </span><br /><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <br>
                    <!-- 3rd Card -->
                    <?php } else {  ?>
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">

                                        <div class="col-xs-12 text-center" style="width: 100%;">
                                            <address>
                                                    <strong id="prodname" style="color:#7d7c7c;">It seems you have given the survey or you do not have any survey</strong><br>
                                            </address>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">

                                        <div class="col-xs-12 text-center" style="width: 100%;">
                                            <address>
                                                    <strong id="prodname" style="color:#7d7c7c;">It seems you have given the survey or you do not have any survey</strong><br>
                                            </address>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php	
			}
			?>
                </div>

            </div>
        </div>
    </div>

	
	
   <?php $this->load->view('front/header/footer');?> 
   <link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>
	<?php
	if(@$this->session->flashdata('survey_feed'))
	{
	?>
		<script>
				// alert('<?php echo $this->session->flashdata('survey_feed'); ?>');
							
				$.alert({
				title: 'Survey Reward Confirmation',
				content: '<?php echo $this->session->flashdata('survey_feed'); ?>',
				});
				
				
				
		</script>
	<?php
	}
	?>
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}
	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	.X{
		color:#1fa07f;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
	}
	
	#sub{
		color:#aeaeae;
		font-size: 10px;
	}
	
	
	
</style>
<script>
function get_new_survey(surID)
{
	//alert('---surID---'+surID);
        //return false;
        var smartphone_flag=<?php echo $smartphone_flag; ?>;
    //alert('---smartphone_flag---'+smartphone_flag);
   // return false;
    
	if(surID != "" || surID != 0)
	{
		var Comp=<?php echo $Enroll_details->Company_id; ?>;
		var Enroll_id=<?php echo $Enroll_details->Enrollement_id; ?>;
		var Card_id='<?php echo $Enroll_details->Card_id; ?>';
		var Survey_id=surID;
		url='<?php echo base_url()?>index.php/Cust_home/getsurveyquestion?Survey_id='+surID+'&Company_id='+Comp+'&Enroll_id='+Enroll_id+'&Card_id='+Card_id+'&smartphone_flag='+smartphone_flag;	
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