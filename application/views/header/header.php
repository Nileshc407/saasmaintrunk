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
$Expiry_license = $_SESSION['Expiry_license'];
$_SESSION['Company_id']= $Company_id; 
$_SESSION['Enrollement_id']= $session_data['enroll']; 

// echo "<br>Expiry_license $Expiry_license";


/********************************************************************************************/
$ci_object = &get_instance();
$ci_object->load->model('Saas_model');
$resultis = $ci_object->Saas_model->get_company_details($Company_id);
	if($resultis != Null)
	{
		$Company_License_type = $resultis->Company_License_type;
		$Comp_regdate = $resultis->Comp_regdate;
		$_SESSION['Session_Company_License_type'] = $resultis->Company_License_type;
		
		 if($Company_License_type != 121)//not basic
		 {
			$FetchedSaasCompany = $ci_object->Saas_model->Get_saas_company_payment_details($Company_id);
			if($FetchedSaasCompany != NULL)
			{
				$Expiry_license=$FetchedSaasCompany->Pyament_expiry_date;
				$_SESSION['Expiry_license'] = $Expiry_license;
				if(date('Y-m-d') > $Expiry_license)
				{
					$_SESSION['Expiry_license'] = date('Y-m-d');
				}
			} 
			else
			{
			   $_SESSION['Expiry_license'] = date('Y-m-d');
			}
		 }
		 else
		 {
			 $Expiry_license = date('Y-m-d',strtotime($Comp_regdate.'+365 day'));
			 $_SESSION['Expiry_license'] = $Expiry_license;
			 if(date('Y-m-d') > $Expiry_license)
			{
				$_SESSION['Expiry_license'] = date('Y-m-d');
			}
		 }
	}
/*************************************************************************************/

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

// $_SESSION['current_url']=base_url().'index.php/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
$_SESSION['current_url'] =$_SERVER[REQUEST_URI];


// echo $actual_link;
/****Login Masking*********XXX****************/
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$Enrollement_id = $session_data['enroll'];
$enrollment_details=  $ci_object->Igain_model->get_enrollment_details($Enrollement_id);


if($enrollment_details->Photograph != "") { 
$Photograph=$enrollment_details->Photograph;
} else {
$Photograph='images/no_image.jpeg';
} 
//-------------AMIT KAMBLE------MENU PRIVILEGES--------

$ci_object->load->model('Menu/Menu_model');
$home_controller = $this->router->fetch_class();
$Current_controller = $this->router->fetch_method();
$Menu_href = $home_controller."/".$Current_controller;
if($Menu_href==$home_controller.'/index'){$Menu_href=$home_controller;}
$get_current_menu=  $ci_object->Menu_model->get_current_menu($Menu_href);
$Menu_id = $get_current_menu->Menu_id;


// echo $Menu_href;
// echo $Menu_id;
//--------------Privileges-------------------------------------
$Privileges = $ci_object->Menu_model->Get_member_assign_privileges($Company_id,$Menu_id,$Enrollement_id);

if($Privileges != NULL){
$_SESSION['Privileges_Add_flag'] = $Privileges->Add_flag;
$_SESSION['Privileges_Edit_flag'] = $Privileges->Edit_flag;
$_SESSION['Privileges_View_flag'] = $Privileges->View_flag;
$_SESSION['Privileges_Delete_flag'] = $Privileges->Delete_flag;
}
else
{
	$_SESSION['Privileges_Add_flag'] =0;
	$_SESSION['Privileges_Edit_flag'] = 0;
	$_SESSION['Privileges_View_flag'] = 0;
	$_SESSION['Privileges_Delete_flag'] = 0;
}
//--------------Privileges---------xxx----------------------------

// print_r($_SESSION['Privileges_Add_flag']);
//-------------------------------------
if($_SERVER['HTTP_REFERER']!=''){$_SESSION['Prev_URL']= $_SERVER['HTTP_REFERER'];}else{$_SESSION['Prev_URL']= $_SESSION['Prev_URL'];}

// echo "url ".$_SESSION['Prev_URL'];
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
	<!----------------AMIT Dashboard js------------------------------------------------------------------------>
	<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/dist/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/samples/utils.js"></script>
	<!-----------------------------***----------------------------------------------------------------------------->
	
	
	<link href="<?php echo base_url(); ?>assets/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/icon_fonts_assets/feather/style.css" rel="stylesheet">

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
                <a class="ssg-item" href="#">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/company6.png)"></div>
                  <div class="item-name">
                    Integ<span>ration</span> with API
                  </div>
                </a>
				<a class="ssg-item" href="#">
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
                <a class="ssg-item" href="#">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/avatar1.jpg)"></div>
                  <div class="item-name">
                    John Ma<span>yer</span>s
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-media" style="background-image: url(<?php echo base_url(); ?>assets/img/avatar2.jpg)"></div>
                  <div class="item-name">
                    Th<span>omas</span> Mullier
                  </div>
                </a><a class="ssg-item" href="#">
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
          <?php $this->load->view('header/mobile_menu'); ?>  
        <!--------------------  END - Mobile Menu  -------------------->
		
                                    <!--------------------  START - Main Menu -------------------->
        <div class="menu-w color-scheme-dark color-style-bright menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
         <!-- <div class="logo-w">
            <a class="logo" href="JavaScript:void(0);">
               <div class="logo-element"></div>
              <div class="logo-label">
                <?php //echo $LogginUserName; ?>
              </div>
            </a>
          </div> -->
          <div class="logged-user-w avatar-inline">
            <div class="logged-user-i">
              <div class="avatar-w">
                  <img alt="" src="<?php echo base_url(); ?>/<?php echo $Photograph; ?>">
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  <?php echo $LogginUserName; ?>
                </div>
                
              </div>
              <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
              </div>
              <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                  <div class="avatar-w">
                    <img alt="" src="<?php echo base_url(); ?>/<?php echo $Photograph; ?>">
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
                  <!--<li>
                    <a href="#"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                  </li>
                  
                  <li>
                    <a href="#"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                  </li>
                  <li>
                    <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                  </li> -->
				   <?php if($Loggin_User_id == 2 && $enrollment_details->Super_seller==1) { ?>	
				  <li>
                        <a href="<?php echo base_url()?>index.php/Register_saas_company/edit_saas_company"><i class="os-icon os-icon-grid"></i><span>Company Profile</span></a>
                      </li>
				   <?php  } ?>					  
				 
				  <li>
                    <a href="<?php echo base_url()?>index.php/User_Profile"><i class="os-icon os-icon-user-male-circle2"></i><span>User Profile</span></a>
                  </li>
				 <?php  if($enrollment_details->Super_seller==1){?>					  
                      <li>
                        <a href="<?php echo base_url()?>index.php/Register_saas_company/UpgradePlan"><i class="os-icon icon-feather-layers"></i><span>Renew/Upgrade</span></a>
                      </li>   
					  <?php  if($Company_License_type ==120){?>					  
                      <li>
                        <a href="<?php echo base_url()?>index.php/Gift_payment"><i class="os-icon icon-feather-layers"></i><span>eGifting Account</span></a>
                      </li>   
					<?php }  ?>	
					<?php }  ?>	
					
                  <li>
                    <a href="<?php echo base_url()?>index.php/Home/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
		  <?php /* ?>
          <div class="menu-actions">
            <!--------------------
            START - Messages Link in secondary top menu
            -------------------->
			
            <div class="messages-notifications os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-mail-14"></i>
              <div class="new-messages-count">
                12
              </div>
              <div class="os-dropdown light message-list">
                <ul>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>/<?php echo $enrollment_details->Photograph; ?>">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          John Mayers
                        </h6>
                        <h6 class="message-title">
                          Account Update
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>assets/img/avatar2.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Phil Jones
                        </h6>
                        <h6 class="message-title">
                          Secutiry Updates
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>assets/img/avatar3.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Bekky Simpson
                        </h6>
                        <h6 class="message-title">
                          Vacation Rentals
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>assets/img/avatar4.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Alice Priskon
                        </h6>
                        <h6 class="message-title">
                          Payment Confirmation
                        </h6>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
			
			
            <!--------------------
            END - Messages Link in secondary top menu
            --------------------><!--------------------
            START - Settings Link in secondary top menu
            -------------------->
            <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-ui-46"></i>
              <div class="os-dropdown">
                <div class="icon-w">
                  <i class="os-icon os-icon-ui-46"></i>
                </div>
                <ul>
                  <li>
                    <a href="<?php echo base_url()?>index.php/User_Profile"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
                  </li>
                  <li>
                    <a href="#"><i class="os-icon os-icon-grid-10"></i><span>Billing Info</span></a>
                  </li>
                  <li>
                    <a href="#"><i class="os-icon os-icon-ui-44"></i><span>My Invoices</span></a>
                  </li>
                  <li>
                    <a href="#"><i class="os-icon os-icon-ui-15"></i><span>Cancel Account</span></a>
                  </li>
                </ul>
              </div>
            </div>
            <!--------------------
            END - Settings Link in secondary top menu
            --------------------><!--------------------
            START - Messages Link in secondary top menu
            -------------------->
            <div class="messages-notifications os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-zap"></i>
              <div class="new-messages-count">
                4
              </div>
              <div class="os-dropdown light message-list">
                <div class="icon-w">
                  <i class="os-icon os-icon-zap"></i>
                </div>
                <ul>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>/<?php echo $enrollment_details->Photograph; ?>">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          John Mayers
                        </h6>
                        <h6 class="message-title">
                          Account Update
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>/<?php echo $enrollment_details->Photograph; ?>">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Phil Jones
                        </h6>
                        <h6 class="message-title">
                          Secutiry Updates
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>assets/img/avatar3.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Bekky Simpson
                        </h6>
                        <h6 class="message-title">
                          Vacation Rentals
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo base_url(); ?>assets/img/avatar4.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Alice Priskon
                        </h6>
                        <h6 class="message-title">
                          Payment Confirmation
                        </h6>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!--------------------
            END - Messages Link in secondary top menu
            -------------------->
          </div>
          <div class="element-search autosuggest-search-activator">
            <input placeholder="Start typing to search..." type="text">
          </div>
          <h1 class="menu-page-header">
            Page Header
          </h1>
		  
		  <?php */ ?>
		  
			<!-------------------- Include Main Menu  -------------------->
				<?php
				
				//$this->load->view('header/mainmenu');
				if(date('Y-m-d') < $Expiry_license) 
				{
					$this->load->view('header/mainmenu');
				} 
				?>			
			<!-------------------- Include Main Menu  -------------------->
		  
          
          <!--<div class="side-menu-magic">
            <h4>
              Light Admin
            </h4>
            <p>
              Clean Bootstrap 4 Template
            </p>
            <div class="btn-w">
              <a class="btn btn-white btn-rounded" href="#" target="_blank">Purchase Now</a>
            </div>
          </div> -->
        </div>
        <!--------------------  END - Main Menu -------------------->
		
		<div class="content-w">
          <!-------------------- START - Top Bar -------------------->
          <div class="top-bar color-scheme-bright">
            <div class="fancy-selector-w">
              <div class="fancy-selector-current">
                <!--<div class="fs-img shadowless">
                  <img alt="" src="<?php echo base_url(); ?>assets/img/company5.png">
                </div>
                <div class="fs-main-info">
                  <div class="fs-name">
                    Quick Menu
                  </div>
                  <div class="fs-sub">
                    <span>Access Menu Instantly</strong>
                  </div>
                </div>
                <div class="fs-selector-trigger">
                  <i class="os-icon os-icon-arrow-down4"></i>
                </div>-->
              </div>
              <!--<div class="fancy-selector-options">
					<a href="<?php echo base_url();?>index.php/Enrollmentc/fastenroll">
						<div class="fancy-selector-option">
						  <div class="fs-img shadowless">
							<img alt="" src="<?php echo base_url(); ?>assets/img/company5.png">
						  </div>
						  <div class="fs-main-info">
							<div class="fs-name">
								Quick Enrollment
							</div>
						   
						  </div>
						</div>
					</a>
					<a href="<?php echo base_url();?>index.php/Transactionc/loyalty_transaction">
						<div class="fancy-selector-option">
						  <div class="fs-img shadowless">
							<img alt="" src="<?php echo base_url(); ?>assets/img/company5.png">
						  </div>
						  <div class="fs-main-info">
							<div class="fs-name">
								Loyalty Transaction
							</div>
						   
						  </div>
						</div>
					</a>
					<a href="<?php echo base_url();?>index.php/CatalogueC/Validate_EVoucher">
						<div class="fancy-selector-option">
						  <div class="fs-img shadowless">
							<img alt="" src="<?php echo base_url(); ?>assets/img/company5.png">
						  </div>
						  <div class="fs-main-info">
							<div class="fs-name">
								Redemption Fullfilment 
							</div>
						   
						  </div>
						</div>
					</a>
                
              </div>-->
            </div>
            <!-------------------- START - Top Menu Controls -------------------->
            <div class="top-menu-controls">
             
				<!--<div class="element-search autosuggest-search-activator">
					<input placeholder="Start typing to search..." type="text">
				</div> -->
				
              <!-------------------- START - Messages Link in secondary top menu --------------------
              <div class="messages-notifications os-dropdown-trigger os-dropdown-position-left">
                <i class="os-icon os-icon-mail-14"></i>
                <div class="new-messages-count">
                  12
                </div>
                <div class="os-dropdown light message-list">
                  <ul>
                    <li>
                      <a href="#">
                        <div class="user-avatar-w">
                          <img alt="" src="<?php echo base_url(); ?>assets/img/avatar1.jpg">
                        </div>
                        <div class="message-content">
                          <h6 class="message-from">
                            John Mayers
                          </h6>
                          <h6 class="message-title">
                            Account Update
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="user-avatar-w">
                          <img alt="" src="<?php echo base_url(); ?>assets/img/avatar2.jpg">
                        </div>
                        <div class="message-content">
                          <h6 class="message-from">
                            Phil Jones
                          </h6>
                          <h6 class="message-title">
                            Secutiry Updates
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="user-avatar-w">
                          <img alt="" src="<?php echo base_url(); ?>assets/img/avatar3.jpg">
                        </div>
                        <div class="message-content">
                          <h6 class="message-from">
                            Bekky Simpson
                          </h6>
                          <h6 class="message-title">
                            Vacation Rentals
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="user-avatar-w">
                          <img alt="" src="<?php echo base_url(); ?>assets/img/avatar4.jpg">
                        </div>
                        <div class="message-content">
                          <h6 class="message-from">
                            Alice Priskon
                          </h6>
                          <h6 class="message-title">
                            Payment Confirmation
                          </h6>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <!-------------------- END - Messages Link in secondary top menu -------------------->
			  <!-------------------- START - Settings Link in secondary top menu -------------------->
			  <?php if($Loggin_User_id == 3 || $Loggin_User_id == 4) { ?>
              <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left">
                <i class="os-icon os-icon-ui-46"></i>
                <div class="os-dropdown">
                  <div class="icon-w">
                    <i class="os-icon os-icon-ui-46"></i>
                  </div>
                  <ul>
                    <li>
						
						<a href="<?php echo base_url()?>index.php/Login/Select_company">
							<i class="os-icon os-icon-ui-49"></i><span>Change Company</span>
						</a>		
                      
                    </li>
                    
                  </ul>
                </div>
              </div>
              <?php } ?>
              <!-------------------- END - Settings Link in secondary top menu -------------------->
              <!-------------------- START - User avatar and menu in secondary top menu -------------------->
              <div class="logged-user-w">
                <div class="logged-user-i">
                  <div class="avatar-w">
                    
                     <img alt="" src="<?php echo base_url(); ?><?php echo $Photograph; ?>">
                      
                  </div>
                  <div class="logged-user-menu color-style-bright">
                    <div class="logged-user-avatar-info">
                      <div class="avatar-w">
                        <img alt="" src="<?php echo base_url(); ?><?php echo $Photograph; ?>">
                      </div>
                      <div class="logged-user-info-w">
                        <div class="logged-user-name">
                          <?php echo $enrollment_details->First_name.' '.$enrollment_details->Last_name; ?>
                        </div>
                        <div class="logged-user-role">
                          <?php if($Loggin_User_id == 2 && $enrollment_details->Super_seller==1) {
                                    echo "Super Seller";
                                } else if($Loggin_User_id == 2 && $enrollment_details->Super_seller==0){
                                    echo "Sub Seller";
                                } else if($Loggin_User_id == 3){
                                    echo "iGainSpark Admin";
                                }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="bg-icon">
                      <i class="os-icon os-icon-wallet-loaded"></i>
                    </div>
                    <ul>
					<?php if($Loggin_User_id == 2 && $enrollment_details->Super_seller==1) { ?>					
					<li>
                        <a href="<?php echo base_url()?>index.php/Register_saas_company/edit_saas_company"><i class="os-icon os-icon-grid"></i><span>Company Profile</span></a>
                      </li> 
					<?php } ?>       
                      <li>
                        <a href="<?php echo base_url()?>index.php/User_Profile"><i class="os-icon os-icon-user-male-circle2"></i><span>User Profile</span></a>
                      </li>
					<?php  if($enrollment_details->Super_seller==1){?>					  
                      <li>
                        <a href="<?php echo base_url()?>index.php/Register_saas_company/UpgradePlan"><i class="os-icon icon-feather-layers"></i><span>Renew/Upgrade</span></a>
                      </li>   
					<?php }  ?>					  
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
		  
		  
	