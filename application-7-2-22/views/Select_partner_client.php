 <?php 
// $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>

<?php 
error_reporting(E_ERROR |E_PARSE|E_CORE_ERROR);
$session_data = $this->session->userdata('logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$Loggin_User_id = $session_data['userId'];
$Allow_membershipid_once = $session_data['Allow_membershipid_once'];
$Allow_merchant_pin = $session_data['Allow_merchant_pin'];
$Company_id = $session_data['Company_id'];
$Membership_redirection_url = $session_data['Membership_redirection_url'];
$Company_name = $session_data['Company_name'];
$Merchant_pinno = $session_data['pinno'];
$Company_logo = $_SESSION['Company_logo'];
$Coalition = $_SESSION['Coalition'];

/********************Set Membership ID if Allow_membershipid_once  set to YES*************************/
if(isset($_REQUEST["set_membership_id"]))
{
	$this->session->set_userdata('Set_Membership_id', $_REQUEST["set_membership_id"]);
	$session_data2 = $this->session->userdata('Set_Membership_id');
	
	$this->session->set_userdata('Go_to_back','0');
	$session_data22 = $this->session->userdata('Go_to_back');
	
	//echo "Go_to_back header".$_SESSION["Go_to_back"];
}

if(isset($_REQUEST["Reset_membership_id"]))
{
	//echo "Reset_membership_id";
	unset($_SESSION['Set_Membership_id']);

}	

if(isset($_REQUEST["Merchant_pin_back"]))
{
	$this->session->set_userdata('Go_to_back','0');
	$session_data22 = $this->session->userdata('Go_to_back');
	
}
/********************************************************************************************/

$data['enroll'] = $session_data['enroll'];	
$data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];	
$data['Country_id'] = $session_data['Country_id'];	
if($data['Sub_seller_Enrollement_id']!=0)
{
	$Selller_ID=$data['Sub_seller_Enrollement_id'];
}
else
{
	$Selller_ID=$data['enroll'];
}

$Path=base_url()."index.php/".$Membership_redirection_url;
$Reset_Path=base_url()."index.php/Home";

//echo $Path;
/****************Set Flag for Go_to_back *********************/

if(isset($_SESSION["Go_to_back"]))
{
	
	 //echo "Go_to_back ".$_SESSION["Go_to_back"];
	if($_SESSION["Go_to_back"]=='1')//Membership ID pAGE
	{
		header("Location:".base_url()."index.php/Home/Cust_membership");
	}
}
/****Login Masking*************************/
$_SESSION['Login_masking']=1;
// $_SESSION['current_url']=base_url().'index.php/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
$_SESSION['current_url'] =$_SERVER[REQUEST_URI];
 //echo $_SESSION['current_url'];
// echo $actual_link;
/****Login Masking*********XXX****************/
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $Company_name; ?></title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="<?php echo base_url(); ?>assets/favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/main.css?version=4.4.0" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bower_components/dragula.js/dist/dragula.min.css" rel="stylesheet">
  </head>
  <body class="menu-position-side menu-side-left full-screen">
    <div class="all-wrapper solid-bg-all">
      <div class="search-with-suggestions-w">
        <div class="search-with-suggestions-modal">
          <div class="element-search">
            <input class="search-suggest-input" placeholder="Start typing to search..." type="text">
              <div class="close-search-suggestions">
                <i class="os-icon os-icon-x"></i>
              </div>
            </input>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-box"></div>
              </div>
              <div class="ssg-name">
                Projects
              </div>
              <div class="ssg-info">
                24 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-boxed">
                <a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/company6.png)"></div>
                  <div class="item-name">
                    Integ<span>ration</span> with API
                  </div>
                </a>
				<a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/company7.png)"></div>
                  <div class="item-name">
                    Deve<span>lopm</span>ent Project
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-users"></div>
              </div>
              <div class="ssg-name">
                Customers
              </div>
              <div class="ssg-info">
                12 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-list">
                <a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/avatar1.jpg)"></div>
                  <div class="item-name">
                    John Ma<span>yer</span>s
                  </div>
                </a><a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/avatar2.jpg)"></div>
                  <div class="item-name">
                    Th<span>omas</span> Mullier
                  </div>
                </a><a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/avatar3.jpg)"></div>
                  <div class="item-name">
                    Kim C<span>olli</span>ns
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-folder"></div>
              </div>
              <div class="ssg-name">
                Files
              </div>
              <div class="ssg-info">
                17 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-blocks">
                <a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-file-text"></i>
                  </div>
                  <div class="item-name">
                    Work<span>Not</span>e.txt
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-film"></i>
                  </div>
                  <div class="item-name">
                    V<span>ideo</span>.avi
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-database"></i>
                  </div>
                  <div class="item-name">
                    User<span>Tabl</span>e.sql
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-image"></i>
                  </div>
                  <div class="item-name">
                    wed<span>din</span>g.jpg
                  </div>
                </a>
              </div>
              <div class="ssg-nothing-found">
                <div class="icon-w">
                  <i class="os-icon os-icon-eye-off"></i>
                </div>
                <span>No files were found. Try changing your query...</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="layout-w">
        <!-------------------- START - Mobile Menu -------------------->
			<?php //$this->load->view('header/mobile_menu'); ?>
        <!--------------------  END - Mobile Menu  -------------------->
		
		<!--------------------  START - Main Menu -------------------->
        <div class="menu-w color-scheme-dark color-style-bright menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
          <div class="logo-w">
            <a class="logo" href="index.html">
              <div class="logo-element"></div>
              <div class="logo-label">
                <?php echo $LogginUserName; ?>
              </div>
            </a>
          </div>
         
          
         
		  
			
        </div>
        <!--------------------  END - Main Menu -------------------->
		
		<div class="content-w">
          <!-------------------- START - Top Bar -------------------->
          <div class="top-bar color-scheme-bright">
           
            <!-------------------- START - Top Menu Controls -------------------->
            <div class="top-menu-controls">
             
              <!-------------------- START - Messages Link in secondary top menu -------------------->
             
              <!-------------------- END - Messages Link in secondary top menu -------------------->
			  <!-------------------- START - Settings Link in secondary top menu -------------------->
             
              <!-------------------- END - Settings Link in secondary top menu -------------------->
			  <!-------------------- START - User avatar and menu in secondary top menu -------------------->
              <div class="logged-user-w">
                <div class="logged-user-i">
                  <div class="avatar-w">
                    <img alt="" src="<?php echo base_url(); ?>assets/img/avatar1.jpg">
                  </div>
                  <div class="logged-user-menu color-style-bright">
                    <div class="logged-user-avatar-info">
                      <div class="avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>/<?php echo $enrollment_details->Photograph; ?>">
                      </div>
                      <div class="logged-user-info-w">
                        <div class="logged-user-name">
                           <?php echo $LogginUserName; ?>
                        </div>
                       
                      </div>
                    </div>
                    <div class="bg-icon">
                      <i class="os-icon os-icon-wallet-loaded"></i>
                    </div>
                    <ul>
                     
                        <li>
                    <a href="<?php echo base_url()?>index.php/User_Profile"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                  </li>
                  <li>
                    <a href="<?php echo base_url()?>index.php/Home/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-------------------- END - User avatar and menu in secondary top menu -------------------->
            </div>
            <!-------------------- END - Top Menu Controls -------------------->
          </div>
          <!-------------------- END - Top Bar -------------------->
<div class="content-i">
	<div class="content-box">
		<div class="row">
			  <div class="col-sm-6">
				<div class="element-wrapper">
				  <div class="element-box">
					<?php echo form_open('Partner_client/reset_session'); ?>
					  <h5 class="form-header">
						Select Company
					  </h5>					  
						<div class="form-group">
							<label for=""> Select Company</label>
							<select class="form-control" onchange="get_clients(this.value);" id="partner" name="partner" data-error="Select Company" required="required">
								<?php if($User_id==3) { ?>
									<option value="">Select Company</option>
								<?php  }
									foreach($Company_array as $Company)
									{
										echo "<option value=".$Company['Company_id'].">".$Company['Company_name']."</option>";
									}
								?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback">
							</div>
						</div>
						<div class="form-group">
							<span id="client"></span>						
						</div>
						<?php 
							if($User_id==4)
							{
								echo"get_info";
								?>
								<div class="form-group">
									<label for="exampleInputEmail1">Select Company Clients</label>											
									<select class="form-control" onchange="get_info(this.value);"  id="partner_client" name="partner_client">
										<option value="">Select Company Clients</option>
											<?php		
												foreach($Client_company_array as $Client_company)
												{
													echo "<option value=".$Client_company['Company_id'].">".$Client_company['Company_name']."</option>";
												} 
											?>
									</select>	
								</div>
								
						<?php } ?>
							
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit"> Submit</button>
					  </div>
					<?php echo form_close(); ?>	
				  </div>
				</div>
			  </div>
		</div>
		
	</div>
	<!-------------------- START - Data Table -------------------->	   
		<div id="client_Companies_Details">	
		<?php			
		if($Client_company_Trans !=NULL)
		{ ?>
		<div class="element-wrapper">                
			<div class="element-box">
			  <h5 class="form-header">
			   Client Companies Details
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Partner Company</th>
							<th>Client Company</th>
							<th>Total Enrollments</th>
							<th>Total Outlets</th>
							<th>Total Purchase</th>
							<th>Total Gain Points</th>
							<th>Total Bonus Points</th>
							<th>Total Redeem Points</th>
							
						</tr>
					</thead>						
					<tfoot>
						<tr>
							<th>Partner Company</th>
							<th>Client Company</th>
							<th>Total Enrollments</th>
							<th>Total Outlets</th>
							<th>Total Purchase</th>
							<th>Total Gain Points</th>
							<th>Total Bonus Points</th>
							<th>Total Redeem Points</th>
						</tr>
					</tfoot>
					<tbody>
						<?php foreach($Client_company_Trans as $trans) { 
						
							$Company_total_enrollment = $ci_object->Igain_model->Get_total_enrollment($trans['Company_id']);
							foreach($Company_total_enrollment as $tot)
							{
								$Totalenrollment= $tot['Total_enrollment'];
							}
							if($Totalenrollment == "" || $Totalenrollment == '0')
							{
								$Totalenrollment="-";
							}
							else
							{
								$Totalenrollment=$Totalenrollment;
							}
							$Company_total_outlets = $ci_object->Igain_model->Get_total_outlets($trans['Company_id']);
							foreach($Company_total_outlets as $tot)
							{
								$TotalOutlets= $tot['Total_enrollment'];
							}
							if($TotalOutlets == "" || $TotalOutlets == '0')
							{
								$TotalOutlets="-";
							}
							else
							{
								$TotalOutlets=$TotalOutlets;
							}
							if($trans['Purchase_amount'] == "" ||$trans['Purchase_amount']== '0')
							{
								$Purchase_amount="-";
							}
							else
							{
								$Purchase_amount=$trans['Purchase_amount'];
							}
							if($trans['Loyalty_pts'] == "" ||$trans['Loyalty_pts']== '0')
							{
								$Loyalty_pts="-";
							}
							else
							{
								$Loyalty_pts=$trans['Loyalty_pts'];
							}
							if($trans['Topup_amount'] == "" ||$trans['Topup_amount']== '0')
							{
								$Topup_amount="-";
							}
							else
							{
								$Topup_amount=$trans['Topup_amount'];
							}
							if($trans['Total_Redeem_points'] == "" ||$trans['Total_Redeem_points']== '0')
							{
								$Total_Redeem_points="-";
							}
							else
							{
								$Total_Redeem_points=$trans['Total_Redeem_points'];
							}
							
							$Parent_company_details = $ci_object->Igain_model->get_company_details($trans['Parent_company']);
						
							$Sum_redeem = $ci_object->Igain_model->get_total_redeem_point($trans['Company_id']);
							
							if($Sum_redeem->sum_reddemPoints == 0)
							{
							  $sum_reddemPoints ="-";
							}
							else
							{
								$sum_reddemPoints = $Sum_redeem->sum_reddemPoints;
							}
						?>
						<tr>
							<td><?php echo $Parent_company_details->Company_name;?></td>
							<td><?php echo $trans['Company_name'];?></td>
							<td><?php echo $Totalenrollment;?></td>
							<td><?php echo $TotalOutlets;?></td>
							<td><?php echo $Purchase_amount;?></td>
							<td><?php echo $Loyalty_pts;?></td>
							<td><?php echo $Topup_amount;?></td>
							<td><?php echo $sum_reddemPoints;?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			  </div>
			</div>
		</div>
		<?php						
		}
		?>
		</div>	
	
	<!--------------------  END - Data Table  -------------------->
</div>	
		
<?php $this->load->view('header/footer');?>

<script type="text/javascript"> 
	function get_clients(company_id) 
	{
		if(company_id > 0)
		{
		
			$.ajax({
					type:"POST",
					data:{compid:company_id},
					url: "<?php echo base_url()?>index.php/Partner_client/set_session_companyid",
					success: function(data)
					{
						$('#client').html(data);
					}	
				});
		}
		else
		{
			document.getElementById('client').style.display='none';
		}		
	}	
	$('#partner').change(function()
	{
		var company_id = $("#partner").val();
		if(company_id > 0)
		{
			$.ajax({
					type:"POST",
					data:{compid:company_id},
					url: "<?php echo base_url()?>index.php/Partner_client/Client_Companies_Details",
					success: function(data)
					{
						$('#client_Companies_Details').html(data);
					}		
				});
		}
		else
		{	
			// document.getElementById('client_Companies_Details').style.display='none';
			// var company_id='<?php echo $Company_id;?>';
			$.ajax({
					type:"POST",
					data:{compid:company_id},
					url: "<?php echo base_url()?>index.php/Partner_client/Client_Companies_Details",
					success: function(data)
					{
						$('#client_Companies_Details').html(data);
					}		
				});	
		}
	});	
</script>
<style>
	.menu-section 
	{
		display: none !important;
	}
</style>
