<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
</head>
<body>

    
            
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="login_to_lsl();">Login</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="forgot_pass();">Forgot Password</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="change_pass();">Change Password</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_changepin_form();">Change Member Pin</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_notification_form();">Notifications</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="home_api_identification();">Home API</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="get_auctions();">Auction</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="show_transfer_form();">Transfer Points</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="resend_pin();">Resend Pin</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="update_profile();">Profile</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="show_statement_form();">Statement</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Fetch_survey();">Take Survey</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_promocode_form();">Promo Code?</a>
                </li>

                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Fetch_catalogue();">Merchandise Catalogue</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_Benefit_Partners();">Show Benefit Partners</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_enrollment();">Enrollment</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_Enroll_statement();">Fetch All Enrollments</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_Identification_form();">Identification</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_system_changepin_form();">Reset System User Pin</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_system_changepass_form();">Reset System User Password</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_family_enroll_form();">Enroll Family Member</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Customer_lbs();">LBS Polling</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_points_converter_form();">Amount to Points Converter</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_transaction_report();">Transaction Report</a>
                </li>
				
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_product_details();">Products Details</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Fetch_payment_methods();">Fetch Payment Methods</a>
                </li>
                
                <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_menu();">Loyalty Transaction</a>
                </li>
				
				 <li>
                    <a class="text-center" href="javascript:void(0);" onclick="Show_flatfile_menu();">Flat File Loyalty Transaction</a>
                </li>

            </ul>
          </div>

        </div>
    </nav>
    
    <div class="content-wrapper" style="margin-top: 20%;">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Member_details1">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <ul class="list-group list-group-unbordered">
                                
                               <li class="list-group-item">
                                        <b>Member First Name in LSL</b>
                                        <a class="pull-right" id="Member_fname"> - </a>
                                        <br><br>
                                </li>

                                <li class="list-group-item">
                                        <b>Member Middle Name in LSL</b>
                                        <a class="pull-right" id="Member_mname"> - </a>
                                        <br><br>
                                </li>

                                <li class="list-group-item">
                                        <b>Member Last Name in LSL</b>
                                        <a class="pull-right" id="Member_lname"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Member Balance in LSL</b>
                                        <a class="pull-right" id="Member_balance"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Membership ID in LSL</b>
                                        <a class="pull-right" id="Membership_id"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Total Unread Notifications</b>
                                        <a class="pull-right" id="Total_unread_notifications"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item text-center">
                                        <b>Fetch LSL Details</b>
                                        <a class="text-center" href="javascript:void(0);" onclick="fetch_lsl_details();">Click Here</a>
                                </li>
                                
                            </ul>                        
                        </div>
                    </div>                
                </div>

                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Member_details2">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <ul class="list-group list-group-unbordered">

                                    <li class="list-group-item">
                                            <b>Member Current Address in LSL</b>
                                            <a class="pull-right" id="Member_address"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Zip Code in LSL</b>
                                            <a class="pull-right" id="Member_zip"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Country in LSL</b>
                                            <a class="pull-right" id="Member_country"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Region in LSL</b>
                                            <a class="pull-right" id="Member_region"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Zone in LSL</b>
                                            <a class="pull-right" id="Member_zone"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member State in LSL</b>
                                            <a class="pull-right" id="Member_state"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member City in LSL</b>
                                            <a class="pull-right" id="Member_city"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Phone in LSL</b>
                                            <a class="pull-right" id="Member_phone"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Date of Birth in LSL</b>
                                            <a class="pull-right" id="Member_dob"> - </a>
                                            <br><br>
                                    </li>

                                     <li class="list-group-item">
                                            <b>Member Age in LSL</b>
                                            <a class="pull-right" id="Member_age"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Sex in LSL</b>
                                            <a class="pull-right" id="Member_sex"> - </a>
                                            <br><br>
                                    </li>

                                   <li class="list-group-item">
                                            <b>Member Email in LSL</b>
                                            <a class="pull-right" id="Member_email"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Total Purchased Amount</b>
                                            <a class="pull-right" id="Member_purchase"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Total Bonus Points</b>
                                            <a class="pull-right" id="Member_bonus_pts"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Total Gained Points</b>
                                            <a class="pull-right" id="Member_gained_pts"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Tier in LSL</b>
                                            <a class="pull-right" id="Member_tier"> - </a>
                                            <br><br>
                                    </li>                                                        

                                    <li class="list-group-item">
                                            <b>Member Blocked Points in LSL</b>
                                            <a class="pull-right" id="Member_blocked_pts"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Member Validity in LSL</b>
                                            <a class="pull-right" id="Member_validity"> - </a>
                                            <br><br>
                                    </li>

                                    <li class="list-group-item">
                                            <b>Member Enrolled Date in LSL</b>
                                            <a class="pull-right" id="Member_enrolldate"> - </a>
                                            <br><br>
                                    </li>
                            </ul>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Notification_form">
                    
                    <div class="box box-primary">                        
                        <div class="box-body box-profile">
                            
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-left">Enter Start Limit</th>
                                    <td>
                                         <div class="form-group">
                                             <input type="text" class="form-control" id="Start_limit" placeholder="Enter Start Limit">
                                        </div>
                                    </td>                                       
                                </tr>

                                <tr>
                                    <th class="text-left">Enter End Limit</th>
                                    <td>
                                         <div class="form-group">
                                             <input type="text" class="form-control" id="End_limit" placeholder="Enter End Limit">
                                        </div>
                                    </td>                                       
                                </tr>

                                <tr>
                                    <td class="text-center" colspan="2">
                                         <button type="button" class="btn btn-primary" onclick="get_notifications();">Submit</button>
                                    </td>                                       
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                                    
                </div>

                <div class="col-md-12" style="display: none;" id="Member_notification">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered" id="Member_notification_table">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Reference No.</th>
                                        <th class="text-center">Notification</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

                <!--<div class="col-md-12" style="display: none;padding: 10px;" id="Notification_details"></div>-->
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Homeapi_Member_details">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <ul class="list-group list-group-unbordered">
                                
                               <li class="list-group-item">
                                        <b>Member First Name in LSL</b>
                                        <a class="pull-right" id="Homeapi_Member_fname"> - </a>
                                        <br><br>
                                </li>

                                <li class="list-group-item">
                                        <b>Member Last Name in LSL</b>
                                        <a class="pull-right" id="Homeapi_Member_lname"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Member Balance in LSL</b>
                                        <a class="pull-right" id="Homeapi_Member_balance"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Membership ID in LSL</b>
                                        <a class="pull-right" id="Homeapi_Membership_id"> - </a>
                                        <br><br>
                                </li>
                                
                                <li class="list-group-item">
                                        <b>Total Unread Notifications</b>
                                        <a class="pull-right" id="Homeapi_Total_unread_notifications"> - </a>
                                        <br><br>
                                </li>
                                
                            </ul>                        
                        </div>
                    </div>                
                </div>

                <div class="col-md-12" style="display: none;" id="Auction_details">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered" id="Auction_details_table">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Auction Image</th>
                                        <th class="text-center">Auction Name</th>
                                        <th class="text-center">Auction Description</th>
                                        <th class="text-center">Minimum Amount to Bid</th>
                                        <th class="text-center">Bid Value</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Transfer_form">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered">
                                <tbody>                                    
                                    <tr>
                                        <th class="text-left">Your Current Balance</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="My_CurrentBalance" readonly="readonly">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">
                                            Transfer To &nbsp;
                                            <span class="label label-danger">(Please Enter Membership ID)</span>
                                        </th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Transfer_membershipid" onchange="check_membershipid(this.value);">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Transfer To - Name</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="Transfer_to_name" readonly="readonly">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Transfer To - Membership ID</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="Transfer_to_membershipid" readonly="readonly">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Transfer To - Phone Number</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="Transfer_to_phone" readonly="readonly">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Points to Transfer</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="points_to_transfer" placeholder="Enter Points to Transfer">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr id="Customer_pin" style="display: none;">
                                        <th class="text-left">Enter Pin</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="pin_no" placeholder="Enter Your Pin">
                                                 <input type="hidden" class="form-control" id="Cust_pin_validation">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center" colspan="2">
                                             <button type="button" class="btn btn-primary" onclick="Transfer_points();">Submit</button>
                                        </td>                                       
                                    </tr>
                                    
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Statement_form">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered">
                                <tbody>                                    
                                    <tr>
                                        <th class="text-left">Select From Date</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="From_date">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Select Till Date</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Till_date">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Select View</th>
                                        <td>
                                             <div class="form-group">
                                                <select class="form-control" id="View">
                                                    <option value="1">Details</option>
                                                    <option value="2">Summary</option>
                                                </select>
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Enter Start Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Stmt_Start_limit" placeholder="Enter Start Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th class="text-left">Enter End Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Stmt_End_limit" placeholder="Enter End Limit">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center" colspan="2">
                                             <button type="button" class="btn btn-primary" onclick="Get_statement();">Submit</button>
                                        </td>                                       
                                    </tr>
                                    
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-12" style="display: none;" id="Statement_details">

                    <div class="table-responsive">
                        
                        <table class="table table-bordered" id="Statement_details_table">
                            <tbody>
                                <tr id="Detail_tr" style="display: none;">
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Transaction Type</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Bill No</th>
                                    <th class="text-center">Order No</th>
                                    <th class="text-center">Voucher No</th>
                                    <th class="text-center">Transaction Amount</th>
                                    <th class="text-center">Loyalty Points Gained</th>
                                    <th class="text-center">Bonus Points Gained</th>
                                    <th class="text-center">Points Redeemed</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Order Status</th>
                                    <th class="text-center">Voucher Status</th>
                                    <th class="text-center">Redemption Status</th>
                                    <th class="text-center">Transfer Point</th>
                                </tr>

                                <tr id="Summary_tr" style="display: none;">
                                    <th class="text-center">Transaction Type</th>
                                    <th class="text-center">Transaction Amount</th>
                                    <th class="text-center">Loyalty Points Gained</th>
                                    <th class="text-center">Bonus Points Gained</th>
                                    <th class="text-center">Points Redeemed</th>
                                    <th class="text-center">Transfer Point</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="col-md-12" style="display: none;" id="Survey_div">

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Select Survey</th>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" id="Survey_id" onchange="Get_survey_details(this.value);">
                                               <option value="0">Select Survey</option>
                                           </select>
                                       </div>
                                   </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="col-md-12" style="display: none;" id="Survey_details">
                    <form id="Survey_form" method="POST"> <!-- action="PERX_API.php" method="POST"  -->
                        
                        <div class="table-responsive">

                            <table class="table table-bordered" id="survey_questions">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center"><h3>Question Details</h3></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <button class='btn btn-primary' type="submit">Submit</button>
                                <!--<input class='btn btn-primary' type='submit' id="Submit_button"> value='Submit' -->
                                <input type='hidden' name="Company_username" value='diamondbank1234'>
                                <input type='hidden' name="Company_password" value='VDi8eXq/bBKH7YF2jRWwIw=='>
                                <input type='hidden' name="Membership_id" value='gB8N8NUUGZmXq5vVhKnAHQ=='>
                                <input type='hidden' name="API_flag" value='XPoH9UySdBrsZqQPHCsk7w=='>
                            </div>
                        </div>
                    
                    </form>
                </div>

                <div class="col-md-12" style="display: none;" class="form-control" id="PromoCode_form">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enter Promo Code</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Promo_code" id="Promo_code" class="form-control" placeholder="Promo Code">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="Apply_promocode();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    
                </div>

                <div class="col-md-12" style="display: none;" class="form-control" id="Catalogue">
                    
                    <div class="row">
                        <div class="col-md-4 well" id="Redeem_CB"></div>
                        
                        <div class="col-md-1"></div>
                        
                        <div class="col-md-2 well text-center">
                            <button type="button" class="btn btn-success btn-lg" onclick="Show_checkout();">
                                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Checkout
                            </button>
                        </div>
                        
                        <div class="col-md-1"></div>
                        
                        <div class="col-md-4 well" id="Cart_total"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="Catalogue_items"></div>
                    </div>
                    
                </div>
                
                <div class="col-md-12" style="display: none;" class="form-control" id="Redeem_Catalogue">
                    
                    <form id="Redemption_form" method="POST">
                        
                        <div class="table-responsive">

                            <table class="table table-bordered" id="Item_row_table">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Remove</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Redemption Method</th>
                                        <th class="text-center">Partner Location</th>
                                        <th class="text-center">Redeemable Points</th>
                                        <th class="text-center">Shipping Points</th>
                                    </tr>

                                    <tr>
                                        <td class="text-left" colspan="7">
                                            <button type="button" class="btn btn-success" onclick="Show_catalogue();">
                                                <span class="glyphicon glyphicon-backward" aria-hidden="true"></span>&nbsp;Continue Redeem
                                            </button>
                                        </td>
                                    </tr>

                                    <tr><td class="text-right" colspan="7">&nbsp;</td></tr>

                                    <tr>
                                        <td class="text-right" colspan="5">Total Points</td>
                                        <td class="text-right" colspan="2"><input type="text" name="Total_Points" id="Total_Points" class="form-control text-center" readonly="readonly"></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right" colspan="5">Total Shipping Points</td>
                                        <td class="text-right" colspan="2"><input type="text" name="Total_Shipping_Points" id="Total_Shipping_Points" class="form-control text-center" readonly="readonly"></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right" colspan="5">Grand Total Points</td>
                                        <td class="text-right" colspan="2"><input type="text" name="Grand_Total_Points" id="Grand_Total_Points" class="form-control text-center" readonly="readonly"></td>
                                    </tr>
                                    
                                    <tr><td class="text-right" colspan="7">&nbsp;</td></tr>
                                    
                                    <tr class="ShipAddress">
                                        <td>&nbsp;</td>
                                        <th class="text-center" colspan="2">Current Address</th>
                                        <td>&nbsp;</td>
                                        <th class="text-center" colspan="1">Shipping Address</th>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="ShipAddress">
                                        <td>&nbsp;</td>
                                        <td class="text-center" colspan="2">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" readonly="readonly" id="CurrentAddress"></textarea>
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td class="text-center" colspan="1">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" name="ShippingAddress" id="ShippingAddress" required="required"></textarea>
                                            </div>
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="ShipAddress">
                                        <td>&nbsp;</td>
                                        <td class="text-center" colspan="2">
                                            <label for="exampleInputEmail1">Country</label>
                                            <div class="form-group">
                                                <select class="form-control" name="CurrentCountry" id="CurrentCountry"></select>
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        
                                        <td class="text-center" colspan="1">
                                            <label for="exampleInputEmail1">Country</label>
                                            <div class="form-group">
                                                <select class="form-control" name="ShippingCountry" id="ShippingCountry" required="required"></select>
                                            </div>
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="ShipAddress">
                                        <td>&nbsp;</td>
                                        <td class="text-center" colspan="2">
                                            <label for="exampleInputEmail1">State</label>
                                            <div class="form-group">
                                                <select class="form-control" name="CurrentState" id="CurrentState"></select>
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        
                                        <td class="text-center" colspan="1">
                                            <label for="exampleInputEmail1">State</label>
                                            <div class="form-group">
                                                <select class="form-control" name="ShippingState" id="ShippingState" required="required"></select>
                                            </div>
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="ShipAddress">
                                        <td>&nbsp;</td>
                                        <td class="text-center" colspan="2">
                                            <label for="exampleInputEmail1">City</label>
                                            <div class="form-group">
                                                <select class="form-control" name="CurrentCity" id="CurrentCity"></select>
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        
                                        <td class="text-center" colspan="1">
                                            <label for="exampleInputEmail1">City</label>
                                            <div class="form-group">
                                                <select class="form-control" name="ShippingCity" id="ShippingCity" required="required"></select>
                                            </div>
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="ShipAddress">
                                        <td colspan="2">&nbsp;</td>
                                        <td class="text-center" colspan="3">
                                            <div class="checkbox">
                                                <label for="exampleInputEmail1">
                                                    <input type="checkbox" name="new_address" value="1" id="Same_address" onclick="Change_shipping_address();"> Shipping Address same as Current Address
                                                </label>
                                            </div>
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    
                                    <tr id="CustPin" style="display: none;">
                                        <td colspan="2">&nbsp;</td>
                                        <td class="text-right" colspan="2">Member Pin</td>
                                        <td class="text-right" colspan="1">
                                            <input type="text" name="Member_pin" id="Member_pin" class="form-control text-center">
                                        </td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <button type="submit" class="btn btn-success" id="PlaceOrder">
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Place Order
                                            </button>
                                            <input type='hidden' name="Company_username" value='diamondbank1234'>
                                            <input type='hidden' name="Company_password" value='s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw='>
                                            <input type='hidden' name="Membership_id" value='/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY='>
                                            <input type='hidden' name="API_flag" value='e2ZSDe/jEqu/VSTOFQhGM3BEFrRkSR6SoWXBrtvLxG8='>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        
                    </form>
                    
                </div>
    
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Enrollment_form">

                    <div class="box box-primary">

                        <div class="box-body box-profile">
                            
                            <form id="EnrollmentForm" method="POST">

                                <table class="table table-bordered">
                                    <tbody>                                    
                                        <tr>
                                            <th class="text-left">Enter Your First Name</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="FirstName" name="First_name">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Your Last Name</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="LastName" name="Last_name">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Your Email ID</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="EmailID" name="Email_ID">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter your Phone No</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="PhoneNO" name="Phone_NO">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Membership ID</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="MembershipID" name="Membership_ID" required="required">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Receive Communication</th>
                                            <td>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="Communication_flag" onclick="Show_communication_type(this.value);" value="1">Yes
                                                    </label>

                                                    <label>
                                                        <input type="radio" name="Communication_flag" onclick="Show_communication_type(this.value);" value="0">No
                                                    </label>
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr id="CommunicationType" style="display: none;">
                                            <th class="text-left">Select Communication Type</th>
                                            <td>
                                                <select class="form-control" name="Communication_type">
                                                    <option value="">Select Communication Type</option>
                                                    <option value="1">Email</option>
                                                    <option value="2">SMS</option>
                                                    <option value="3">Email and SMS</option>
                                                </select>
                                            </td>                                       
                                        </tr>
                                        
                                        <tr>
                                            <th class="text-left">Referee</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="Referee_id" name="Referee_id" placeholder="Enter Referee Membership ID">
                                                </div>
                                            </td>                                       
                                        </tr>
                                        
                                        <tr>
                                            <th class="text-left">Referee Details</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="Referee_details" name="Referee_details" placeholder="Referee Details">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <td class="text-center" colspan="2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <input type='hidden' name="Company_username" value='diamondbank1234'>
                                                <input type='hidden' name="Company_password" value='s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw='>
                                                <input type='hidden' name="API_flag" value='GSs5V2M6wSS5C95lXJLvHXaeGxyWPDyzjExIznckKKw='>
                                                <input type='hidden' name="Username" value='W+O8+NUO3g348T9VnbnsN9NoZA0yo4IDWOpgZdaILk4='>
                                                <input type='hidden' name="Password" value='JQU4RrOs4vAJRbzXtLzNf6VkjQjoVBKOecFdXPpYeaU='>
                                            </td>                                       
                                        </tr>

                                    </tbody>
                                </table>
                            
                            </form>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="ChangePin_form">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enter Current Pin</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Current_pin" id="Current_pin" class="form-control" placeholder="Enter Current Pin">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Enter New Pin</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="New_pin" id="New_pin" class="form-control" placeholder="Enter New Pin">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Confirm New Pin</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Confirm_pin" id="Confirm_pin" class="form-control" placeholder="Confirm New Pin">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="change_member_pin();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    
                </div>
                
                <div class="col-md-12" style="display: none;" class="form-control" id="Benefit_partner">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered" id="Benefit_partner_table"><tbody></tbody></table>

                    </div>
                    
                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Enroll_Statement">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Enter Username</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="System_user_email2" id="System_user_email2" class="form-control" placeholder="Enter Username">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-center">Enter Your Password</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="System_user_pass2" id="System_user_pass2" class="form-control" placeholder="Enter Your Password">
                                            </div>
                                        </td>
                                    </tr>
                                
                                    <tr>
                                        <th class="text-left">Select From Date</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="Enroll_From_date">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Select Till Date</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Enroll_Till_date">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Enter Start Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Enroll_Start_limit" placeholder="Enter Start Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th class="text-left">Enter End Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Enroll_End_limit" placeholder="Enter End Limit">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center" colspan="2">
                                             <button type="button" class="btn btn-primary" onclick="Fetch_All_Enrollments();">Submit</button>
                                        </td>                                       
                                    </tr>
                                    
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-12" style="display: none;" id="Enroll_Statement_details">

                    <div class="table-responsive">
                        
                        <table class="table table-bordered" id="Enroll_Statement_table">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enrollment Date</th>
                                    <th class="text-center">Membership Id</th>
                                    <th class="text-center">First Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Current Address</th>
                                    <th class="text-center">Phone No.</th>
                                    <th class="text-center">Email Id</th>
                                    <th class="text-center">Current Balance</th>
                                    <th class="text-center">Tier</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Identification">

                    <div class="box box-primary">

                        <div class="box-body box-profile">

                            <table class="table table-bordered">
                                <tbody>                                    
                                    <tr>
                                        <th class="text-left">Enter Username</th>
                                        <td>
                                             <div class="form-group">
                                                <input type="text" class="form-control" id="System_username">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Enter Password</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="System_password">
                                            </div>
                                        </td>                                       
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center" colspan="2">
                                             <button type="button" class="btn btn-primary" onclick="Identification();">Submit</button>
                                        </td>                                       
                                    </tr>
                                    
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="System_ChangePin_form">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enter Username</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_user_email" id="System_user_email" class="form-control" placeholder="Enter Username">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Enter Your Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_user_pass" id="System_user_pass" class="form-control" placeholder="Enter Your Password">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="change_system_user_pin();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    
                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="System_ChangePass_form">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enter User Email ID</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_useremail" id="System_useremail" class="form-control" placeholder="Enter User Email ID">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Enter Current Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_Current_pass" id="System_Current_pass" class="form-control" placeholder="Enter Current Password">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Enter New Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_New_pass" id="System_New_pass" class="form-control" placeholder="Enter New Password">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="text-center">Confirm New Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="System_Confirm_pass" id="System_Confirm_pass" class="form-control" placeholder="Confirm New Password">
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="change_system_user_pass();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    
                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" id="Family_enroll_form">

                    <div class="box box-primary">

                        <div class="box-body box-profile">
                            
                            <form id="Family_EnrollmentForm" method="POST">

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="text-left">Enter Parent Membership ID</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="Parent_memberid" name="Parent_memberid">
                                                </div>
                                            </td>                                       
                                        </tr>
                                        
                                        <tr>
                                            <th class="text-left">Enter Family Member First Name</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="Family_FirstName" name="Family_First_name">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Family Member Last Name</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="Family_LastName" name="Family_Last_name">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Family Member Email ID</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="Family_EmailID" name="Family_Email_ID">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Family Member Phone No</th>
                                            <td>
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" id="Family_PhoneNO" name="Family_Phone_NO">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Enter Redemption Limit Per Day for Family Member</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="Family_Redemption_limit" name="Family_Redemption_limit">
                                                </div>
                                            </td>                                       
                                        </tr>
                                        
                                        <tr>
                                            <th class="text-left">Enter Membership ID for Family Member</th>
                                            <td>
                                                 <div class="form-group">
                                                     <input type="text" class="form-control" id="Family_MembershipID" name="Family_Membership_ID" required="required">
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <th class="text-left">Receive Communication</th>
                                            <td>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="Family_Communication_flag" onclick="Show_Family_communication_type(this.value);" value="1">Yes
                                                    </label>

                                                    <label>
                                                        <input type="radio" name="Family_Communication_flag" onclick="Show_Family_communication_type(this.value);" value="0">No
                                                    </label>
                                                </div>
                                            </td>                                       
                                        </tr>

                                        <tr id="Family_CommunicationType" style="display: none;">
                                            <th class="text-left">Select Communication Type</th>
                                            <td>
                                                <select class="form-control" name="Family_Communication_type">
                                                    <option value="">Select Communication Type</option>
                                                    <option value="1">Email</option>
                                                    <option value="2">SMS</option>
                                                    <option value="3">Email and SMS</option>
                                                </select>
                                            </td>                                       
                                        </tr>

                                        <tr>
                                            <td class="text-center" colspan="2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <input type='hidden' name="Company_username" value='diamondbank1234'>
                                                <input type='hidden' name="Company_password" value='s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw='>
                                                <input type='hidden' name="API_flag" value='g8vnBgXyXpELhkRb2ND9Oo7ejf5tCsWWcjjAw83+GE4='>
                                                <input type='hidden' name="Username" value='W+O8+NUO3g348T9VnbnsN9NoZA0yo4IDWOpgZdaILk4='>
                                                <input type='hidden' name="Password" value='JQU4RrOs4vAJRbzXtLzNf6VkjQjoVBKOecFdXPpYeaU='>
                                            </td>                                       
                                        </tr>

                                    </tbody>
                                </table>
                            
                            </form>

                        </div>

                    </div>

                </div>
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="Show_points_converter_form">
                        
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Enter Cashier Username</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_username" id="cashier_username" class="form-control" placeholder="Enter Cashier Username">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Cashier Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_password" id="cashier_password" class="form-control" placeholder="Enter Cashier Password">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Membership Id</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Membership_id" id="Cnvrt_Membership_id" class="form-control" placeholder="Enter Membership id">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Transaction Amount</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="amount_to_convert" id="amount_to_convert" class="form-control" placeholder="Enter Transaction Amount">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Loyalty program name</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Loyalty_program_name" id="Loyalty_program_name" class="form-control" readonly>
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Converted Points</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Converted_Points" id="Converted_Points" class="form-control" readonly>
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="convert_amt_to_points();">Submit</button>
                                    </th>
                                </tr>
								
                            </tbody>
                        </table>

                    </div>
                    
                </div>
                
                <div class="col-md-12" style="display: none;" class="form-control" id="Show_transaction_report">
                      
                    <div class="col-md-6 col-md-offset-3">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Enter Cashier Username</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="cashier_username2" id="cashier_username2" class="form-control" placeholder="Enter Cashier Username">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-center">Enter Cashier Password</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="cashier_password2" id="cashier_password2" class="form-control" placeholder="Enter Cashier Password">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Enter Start Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Trans_Start_limit" placeholder="Enter Start Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th class="text-left">Enter End Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Trans_End_limit" placeholder="Enter End Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th colspan="2" class="text-center">
                                            <button class='btn btn-primary' type="submit" onclick="get_transaction_report();">Submit</button>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
					
                    <div class="col-md-12">
                        
                        <div class="table-responsive">

                            <table class="table table-bordered" id="transaction_report_table">

                                 <tbody >
                                     <tr>
										<th class="text-center">Transaction_type_id</th>
										<th class="text-center">Transaction_type</th>
                                         <th class="text-center">Transaction_date</th>
                                         <th class="text-center">Member_name</th>
                                         <th class="text-center">Membership_id</th>
                                         <th class="text-center">Branch_name</th>
                                         <th class="text-center">Branch_user_name</th>
                                         <th class="text-center">Bill_no</th>
                                         <th class="text-center">Transaction_amount</th>
                                         <th class="text-center">Expired_points</th>
                                         <th class="text-center">Redeem Points</th>
                                         <th class="text-center">Bonus Points</th>
                                         <th class="text-center">Item_name</th>
                                         <th class="text-center">Quantity</th>
                                         <th class="text-center">Remarks</th>
                                     </tr>
                                 </tbody>
                             </table>

                        </div>
                        
                    </div>

                    
                </div>
                
                <div class="col-md-12" style="display: none;" class="form-control" id="Show_product_details">
                        
                    <div class="col-md-6 col-md-offset-3">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <tbody>

                                    <tr>
                                        <th class="text-center">Enter Cashier Username</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="cashier_username3" id="cashier_username3" class="form-control" placeholder="Enter Cashier Username">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-center">Enter Cashier Password</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="cashier_password3" id="cashier_password3" class="form-control" placeholder="Enter Cashier Password">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-center">Enter Branch Code</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="Inv_branch_code" id="Inv_branch_code" class="form-control" placeholder="Enter Branch Code">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-left">Enter Start Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Prod_Start_limit" placeholder="Enter Start Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th class="text-left">Enter End Limit</th>
                                        <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="Prod_End_limit" placeholder="Enter End Limit">
                                            </div>
                                        </td>                                       
                                    </tr>

                                    <tr>
                                        <th colspan="2" class="text-center">
                                            <button class='btn btn-primary' type="submit" onclick="get_products_details();">Submit</button>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
					
                    <div class="col-md-12">

                        <div class="box box-primary">

                            <div class="box-body box-profile">

                               <table class="table table-bordered" id="product_details_table">

                                    <tbody>
                                        <tr>
                                            <th class="text-center">Product Code</th>	
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Product Cost</th>
                                            <th class="text-center">Total Cost</th>
                                        </tr>
                                    </tbody>
                                    
                                </table>

                            </div>

                        </div>

                    </div>

                    
                </div>
                
                <div class="col-md-12" style="display: none;" id="Payment_div">

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center">Select Payment Methods</th>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" id="Payment_methods">
                                               <option value="0">Select Payment Methods</option>
                                           </select>
                                       </div>
                                   </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
                
                
                <div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="Show_loyalty_transaction">
                        
                    <div class="table-responsive">

                        
						<table class="table table-bordered">
                            <tbody>

                                <tr>
                                    <th class="text-center">Enter Cashier Username</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_username4" id="cashier_username4" class="form-control" placeholder="Enter Cashier Username">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Cashier Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_password4" id="cashier_password4" class="form-control" placeholder="Enter Cashier Password">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Transaction Flag (1,2,3)<br>1-loyalty<br>2-non loyalty<br>3-points award</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="transaction_flag" id="transaction_flag" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Membership id</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="membershipid4" id="membershipid4" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Redeem Points</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="redeem_points" id="redeem_points" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Branch Code</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="branch_code" id="branch_code" class="form-control">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-center">Gift Card Purchase</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="GiftPurchase_Flag" id="GiftPurchase_Flag" value="0" class="form-control">
											
                                            <input type="text" name="Purchase_GiftCardArray[]" id="Purchase_GiftCard1" placeholder="GiftCard No." value="" class="form-control">

                                            <input type="text" name="Purchase_GiftCardArray[]" id="Purchase_GiftCard2" placeholder="GiftCard No." value="" class="form-control">
											 
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Gift Card Redeem?</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="GiftCardFlag" id="GiftCardFlag" class="form-control" placeholder="Redeem Flag">
											
                                            <input type="text" name="GiftCard_no" id="GiftCard_no" class="form-control" placeholder="GiftCard No.">

                                            <input type="text" name="GiftCardRedeem" id="GiftCardRedeem_amt" class="form-control" placeholder="GiftCardRedeem amt">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Branch User Pin</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="BranchUser_Pin" id="BranchUser_Pin" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Payment Type</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="payment_type" id="payment_type" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Voucher/Cheque no.</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="voucher_cheque_no" id="voucher_cheque_no" class="form-control">
                                        </div>
                                    </td>
                                </tr> 
								
								<tr>
                                    <th class="text-center">Remark</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Remark" id="Remarkis" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
								<tr>
                                    <th class="text-center">Amount_collected</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Amount_collected" id="Amount_collected" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								 

                                <tr>
                                    <th class="text-center">Item Code 1</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="items[]" id="item_1" class="form-control" placeholder="Item Code">
											
                                            <input type="text" name="quantity[]" id="quantity_1" class="form-control" placeholder="quantity"> 

                                            <input type="text" name="price[]" id="price_1" class="form-control" placeholder="if points award transaction enter price">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Item Code 2</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="items[]" id="item_2" class="form-control" placeholder="Item Code">
											
                                            <input type="text" name="quantity[]" id="quantity_2" class="form-control" placeholder="quantity">

                                            <input type="text" name="price[]" id="price_2" class="form-control" placeholder="if points award transaction enter price">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Item Code 3</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="items[]" id="item_3" class="form-control" placeholder="Item Code">
                                            <input type="text" name="quantity[]" id="quantity_3" class="form-control" placeholder="quantity">
                                        </div>
                                    </td>
                                </tr>
								
								
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="do_transaction();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
					
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                               <table class="table table-bordered" id="transactions_table">
                                    <tbody>
                                        <tr>
                                            <th class="text-center">Transaction_date</th>
                                            <th class="text-center">Member_name</th>
                                            <th class="text-center">Membership_id</th>
                                            <th class="text-center">Branch_name</th>
                                            <th class="text-center">Branch_user_name</th>
                                            <th class="text-center">Bill_no</th>
                                            <th class="text-center">Transaction_amount</th>
                                            <th class="text-center">Item_name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Remarks</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
				
				
				<div class="col-md-6 col-md-offset-3" style="display: none;" class="form-control" id="Show_flatfile_loyalty_transaction">
                        
                    <div class="table-responsive">

                        
						<table class="table table-bordered">
                            <tbody>

                                <tr>
                                    <th class="text-center">Enter Cashier Username</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_username42" id="cashier_username42" class="form-control" placeholder="Enter Cashier Username">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Cashier Password</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="cashier_password42" id="cashier_password42" class="form-control" placeholder="Enter Cashier Password">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Transaction Flag (4,5)<br>4- single transaction<br>5 - upload flat file</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="transaction_flag2" id="transaction_flag2" value="4" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Membership id</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="membershipid42" id="membershipid42" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Enter Branch Code</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="branch_code2" id="branch_code2" class="form-control">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-center">Branch User Pin</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="BranchUser_Pin2" id="BranchUser_Pin2" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
                               
								<tr>
                                    <th class="text-center">Remark</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Remark2" id="Remarkis2" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
								<tr>
                                    <th class="text-center">Bill no.</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Bill_no2" id="Bill_no2" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
								<tr>
                                    <th class="text-center">transaction_Type</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="transaction_Type2" id="transaction_Type2" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								
								<tr>
                                    <th class="text-center">Transaction_channel</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="Transaction_channel_code2" id="Transaction_channel_code2" class="form-control">
                                        </div>
                                    </td>
                                </tr>
								 

                                <tr>
                                    <th class="text-center">Item Code 1</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="items2[]" id="item2_1" class="form-control" placeholder="Item Code">
											
                                            <input type="text" name="quantity2[]" id="quantity2_1" class="form-control" placeholder="quantity"> 

                                            <input type="text" name="price2[]" id="price2_1" class="form-control" placeholder="if points award transaction enter price">
                                        </div>
                                    </td>
                                </tr>
								
                                <tr>
                                    <th class="text-center">Item Code 2</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="items2[]" id="item2_2" class="form-control" placeholder="Item Code">
											
                                            <input type="text" name="quantity2[]" id="quantity2_2" class="form-control" placeholder="quantity">

                                            <input type="text" name="price2[]" id="price2_2" class="form-control" placeholder="if points award transaction enter price">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <button class='btn btn-primary' type="submit" onclick="do_flatfile_transaction();">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
					
                    
                    
                </div>

            </div>

        </div>
    </div>

</body>
</html>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="Notification_details"></div>
        </div>
    </div>
</div>

<script>
        //var API_URL = "https://demo.perxclm.com/PERX_API.php";
        var API_URL = "http://localhost/LSL_LBS_DEMO/PERX_API.php";
        //var API_URL = "http://localhost/lslloyaltyapppc_LBS/PERX_API.php";
		
        function Show_notification_form()
        {
            $('#Notification_form').css("display","");
        }
    
        function get_notifications()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "R16xY6zxUu1Izhly+znETo36TM2CxN0GoZ1nLh4h6X8=";
            var Start_limit = $('#Start_limit').val();
            var End_limit = $('#End_limit').val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }
                        
                        if(error == '2003')
                        {
                                alert("Invalid Membership ID or User Email ID!");
                        }

                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '2008')
                        {
                                alert("User Email Id is Blank!");
                        }

                        if(error == '1001')
                        {
                            $('#Notification_details').css("display","none;");
                            $('#Member_notification').css("display","");
                            $('#Member_notification_table').css("display","");
                            
                            var Notification_details = json['Notification_details'];                            
                            $.each(Notification_details, function(key,value)
                            {
                                //if(key != "status")
                                {
                                    if(value['Note_open'] == 1)
                                    {
                                        $('#Member_notification_table > tbody:last-child').append('<tr class="success" id="Row_'+value['User_notification_id']+'"><td style="cursor: pointer;" onclick="get_notification('+value['User_notification_id']+');">'+value['Creation_date']+'</td><td style="cursor: pointer;" class="text-center" onclick="get_notification('+value['User_notification_id']+');">'+value['Transaction_type_name']+'</td><td style="cursor: pointer;" class="text-center" onclick="get_notification('+value['User_notification_id']+');">'+value['Reference_no']+'</td><td style="cursor: pointer;" onclick="get_notification('+value['User_notification_id']+');">'+value['Contents']+'</td><td class="text-center">'+value['Note_open_status']+'</td><td style="cursor: pointer;" class="text-center" onclick="delete_notification('+value['User_notification_id']+');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td></tr>');
                                    }
                                    else
                                    {
                                        $('#Member_notification_table > tbody:last-child').append('<tr id="Row_'+value['User_notification_id']+'"><td style="cursor: pointer;" onclick="get_notification('+value['User_notification_id']+');">'+value['Creation_date']+'</td><td style="cursor: pointer;" class="text-center" onclick="get_notification('+value['User_notification_id']+');">'+value['Transaction_type_name']+'</td><td style="cursor: pointer;" class="text-center" onclick="get_notification('+value['User_notification_id']+');">'+value['Reference_no']+'</td><td style="cursor: pointer;" onclick="get_notification('+value['User_notification_id']+');">'+value['Contents']+'</td><td class="text-center">'+value['Note_open_status']+'</td><td style="cursor: pointer;" class="text-center" onclick="delete_notification('+value['User_notification_id']+');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td></tr>');
                                    }
                                }
                            });
                        }
                    }
            });
        }
        
        function get_notification(User_notification_id)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "7kkA/8PXmz3y19BMfUo6m5AxbCJkPWlwA2vGiC98Vxg=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, User_notification_id:User_notification_id, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '1001')
                        {
                            $('#Member_notification').css("display","none;");
                            $('#Notification_details').css("display","");
                            $('#Notification_details').html(json['Contents']);
                            
                            $('#myModal').show();
                            $("#myModal").addClass( "in" );	
                            $( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
                        }
                    }
            });
        }
        
        function delete_notification(User_notification_id)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "NL3WD51HLfiBS2yKr07vgMIaY1LGTIzF4gzCgFe+2Z4=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, User_notification_id:User_notification_id, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '1001')
                        {
                            $('#Notification_details').html('<p class="text-center;">Message Deleted Successfully</p>');
                            $('#Row_'+User_notification_id).remove();
                            
                            $('#myModal').show();
                            $("#myModal").addClass( "in" );	
                            $( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
                        }
                    }
            });
        }
        
        function home_api_identification()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "iTcIxhnv/1a9TQ2gJxOacuo4Q0+mVS7lSvg6PasxedA=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }
                        
                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '1001')
                        {
                            $("#Homeapi_Member_details").css("display","");
                            $("#Homeapi_Member_fname").html(json['First_name']);
                            $("#Homeapi_Member_mname").html(json['Middle_name']);
                            $("#Homeapi_Member_lname").html(json['Last_name']);
                            $("#Homeapi_Member_balance").html(json['Current_balance']);
                            $("#Homeapi_Membership_id").html(json['Membership_id']);
                            $("#Homeapi_Total_unread_notifications").html(json['Total_unread_notifications']);
                        }
                    }
            });
        }
    
        function login_to_lsl()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Cust_username = "GUt8asui0i0BluY8396c3RrrZKmgIBGkvmrdxkRGV0o=";
            var Cust_password = "O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=";
            var API_flag = "ErMVSZl379T1GrCpQCLM0JiPE2rRno1a4VXsHeDqbuU=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Cust_username:Cust_username, Cust_password:Cust_password, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2005')
                        {
                                alert("Invalid Username or Password!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '1001')
                        {
                            $("#Member_details1").css("display","");
                            $("#Member_fname").html(json['First_name']);
                            $("#Member_mname").html(json['Middle_name']);
                            $("#Member_lname").html(json['Last_name']);
                            $("#Member_balance").html(json['Current_balance']);
                            $("#Membership_id").html(json['Membership_id']);
                            $("#Total_unread_notifications").html(json['Total_unread_notifications']);
                        }
                    }
            });
        }
        
        function change_pass()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var Old_password = "O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=";
            var New_password = "xjUedrTDoHVUVn886gUcwg==";
            var API_flag = "dBjEyCoypn+94TUftj42jlLz7X6Ku16gEEThBN7xjuk=";
		
			$.ajax
			({
			type: "POST",
			data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, Old_password:Old_password, New_password:New_password, 
					API_flag:API_flag},
			url: API_URL,
                        dataType: "json", 
			success: function(json)
			{
                            var error = json['status'];
                            if(error == '2001')
                            {
                                    alert("Invalid Company Username!");
                            }
                            
                            if(error == '2002')
                            {
                                    alert("Invalid Company Password!");
                            }
                            
                            if(error == '2003')
                            {
                                    alert("Unable to Locate Membership ID!");
                            }
                            
                            if(error == '2004')
                            {
                                    alert("Membership Disabled!");
                            }
                            
                            if(error == '404')
                            {
                                    alert("Blank Company User Name or Company Password!");
                            }
                            
                            if(error == '2006')
                            {
                                    alert("Blank Membership ID!");
                            }
                            
                            if(error == '2010')
                            {
                                    alert("New Password or Old Password is Blank!");
                            }
                            
                            if(error == '2011')
                            {
                                    alert("Old Password Does not match with current Password!");
                            }
                            
                            if(error == '1001')
                            {
                                    alert("Your Password Changed Successfully. Please check your Email.");
                            }
				}
			});
        }
        
        function Show_changepin_form()
        {
            $("#ChangePin_form").css("display","");
        }
        
        function change_member_pin()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "RodnpM198laOBC5r3zDhwiAt8BtmZegkUowx6Ug3cQQ=";
            
            var Current_pin = $('#Current_pin').val();
            var New_pin = $('#New_pin').val();
            var Confirm_pin = $('#Confirm_pin').val();
            
            if(New_pin != Confirm_pin)
            {
                alert("Confirm Pin not Matches with New Pin!!");
            }
            else
            {
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id,
                               API_flag:API_flag, Current_pin:Current_pin, New_pin:New_pin, Confirm_pin:Confirm_pin},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }

                            if(error == '2047')
                            {
                                alert("New Pin or Old Pin is Blank!");
                            }

                            if(error == '2046')
                            {
                                alert("Old Pin does not match with Current Pin!");
                            }

                            if(error == '1001')
                            {
                                alert("Your Password Changed Successfully. Please check your Email.");
                            }
                        }
                });
            }
        }
        
        function forgot_pass()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var User_email_id = "GUt8asui0i0BluY8396c3RrrZKmgIBGkvmrdxkRGV0o=";
            var API_flag = "RRx9T08m/B4TGYKMZ6kfH+ag5ntjWj6qbRFNuN+7AWo=";
		
		$.ajax
		({
			type: "POST",
			data:{ Company_username:Company_username, Company_password:Company_password, User_email_id:User_email_id, 
					API_flag:API_flag},
			url: API_URL,
                        dataType: "json", 
			success: function(json)
			{
                            var error = json['status'];
                            if(error == '2001')
                            {
                                    alert("Invalid Company Username!");
                            }
                            
                            if(error == '2002')
                            {
                                    alert("Invalid Company Password!");
                            }
                            
                            if(error == '2003')
                            {
                                    alert("Unable to Locate Membership ID!");
                            }
                            
                            if(error == '2004')
                            {
                                    alert("Membership Disabled!");
                            }
                            
                            if(error == '404')
                            {
                                    alert("Blank Company User Name or Company Password!");
                            }
                            
                            if(error == '2008')
                            {
                                    alert("Blank User Email ID!");
                            }
                            
                            if(error == '2009')
                            {
                                    alert("Invalid User Email ID!");
                            }
                            
                            if(error == '1001')
                            {
                                    alert("Your Password Successfully Sent to your Email ID.");
                            }
			}
		});
        }
        
	function fetch_lsl_details()
	{
		var Company_username = "diamondbank1234";
		var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
		var API_flag = "w/xOS/nYeyg1jrtvDV81Um88AL8TALAEeiPxVZdx+tM=";
		
		$.ajax
		({
			type: "POST",
			data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, 
					API_flag:API_flag},
			url: API_URL,
                        dataType: "json", 
			success: function(json)
			{
                            var error = json['status'];
                            if(error == '2001')
                            {
                                    alert("Invalid Company Username!");
                            }
                            
                            if(error == '2002')
                            {
                                    alert("Invalid Company Password!");
                            }
                            
                            if(error == '2003')
                            {
                                    alert("Unable to Locate Membership ID!");
                            }
                            
                            if(error == '2004')
                            {
                                    alert("Membership Disabled!");
                            }
                            
                            if(error == '1001')
                            {
                                    $("#Member_details2").css("display","");
                                    var Member_name =  + " " + json['Last_name'];
                                    $("#Member_fname").html(json['First_name']);
                                    $("#Member_mname").html(json['Middle_name']);
                                    $("#Member_lname").html(json['Last_name']);
                                    $("#Member_address").html(json['Current_address']);
                                    $("#Member_zip").html(json['Zipcode']);
                                    $("#Member_country").html(json['Country_name']);
                                    $("#Member_region").html(json['Region_name']);
                                    $("#Member_zone").html(json['Zone_name']);
                                    $("#Member_state").html(json['State_name']);
                                    $("#Member_city").html(json['City_name']);
                                    $("#Member_phone").html(json['Phone_no']);
                                    $("#Member_dob").html(json['Date_of_birth']);
                                    $("#Member_age").html(json['Age']);
                                    $("#Member_sex").html(json['Sex']);
                                    $("#Member_email").html(json['User_email_id']);                      
                                    $("#Member_purchase").html(json['Total_purchase_amount']);
                                    $("#Member_bonus_pts").html(json['Total_bonus_points']);
                                    $("#Member_gained_pts").html(json['Total_gained_points']);
                                    $("#Member_tier").html(json['Tier_name']);
                                    $("#Member_blocked_pts").html(json['Blocked_points']);
                                    $("#Member_validity").html(json['Membership_validity']);
                                    $("#Member_enrolldate").html(json['Enroll_date']);
                            }
			}
		});
	}
        
        $(document).ready(function() 
        {	
            $( "#close_modal" ).click(function(e)
            {
                    $('#myModal').hide();
                    $("#myModal").removeClass( "in" );
                    $('.modal-backdrop').remove();
            });
        });
        
        function get_auctions()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "C/b3/5ojf7ntS4tzOZJuVRyANLn2lOT+R6CanV+kGXc=";
            var Start_limit = "1";
            var End_limit = "3";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                            Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }
                        
                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }
                        
                        if(error == '2012')
                        {
                                alert("Sorry! There are no Auctions Running.");
                        }

                        if(error == '1001')
                        {
                            var Highest_bid_text = "";
                            var Auction_details = json['Auction_details'];
                            $.each(Auction_details, function(key,value)
                            {
                                //if(key != "status")
                                {
                                    if(value['Highest_bid_flag'] == 1)
                                    {
                                        Highest_bid_text = "You Currently the Highest Bidder";
                                    }
                                    if(value['Highest_bid_flag'] == 2)
                                    {
                                        Highest_bid_text = "You are no longer the Highest Bidder. Bid again.";
                                    }
                                    
                                    if(value['Highest_bid_flag'] == 0)
                                    {
                                        Highest_bid_text = "Not Bidded for Auction. Bid now to become first bidder.";
                                    }
                                    
                                    $("#Auction_details").css("display","");                            
                                    $('#Auction_details_table > tbody:last-child').append('<tr><td style="width: 30%; padding: 50px;"><img src="'+value['Prize_image']+'" class="img-responsive img-circle" alt="'+value['Auction_name']+'"></td><td class="text-center">'+value['Auction_name']+'</td><td class="text-center">'+value['Prize_description']+'</td><td class="text-center">'+value['Min_bid_value']+'</td><td><input type="text" class="form-control" id="BidVal_'+value['Auction_id']+'" placeholder="Enter Bid Value"></td><td><input class="btn btn-default" id="BidVal_'+value['Auction_id']+'" type="button" onclick="insert_bid('+value['Auction_id']+');" value="Bid Now"></td><td class="text-center;"><span class="label label-danger">'+Highest_bid_text+'</span></td></tr>');
                                }
                            });
                        }
                    }
            });
        }
        
        function insert_bid(Auction_id)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "2+MOD7J7pG/l5cKaNn6baPeteQqft+40x8um9XSOr7Y=";
            
            var Bid_value = document.getElementById("BidVal_"+Auction_id).value;
            if(Bid_value == 0 || Bid_value == "")
            {
                alert("Please Enter Bid Value Greater Than 0!");
            }
            else
            {
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Bid_value:Bid_value, Auction_id:Auction_id},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                    alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                    alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                    alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                    alert("Membership Disabled!");
                            }

                            if(error == '2006')
                            {
                                    alert("Membership ID is Blank!");
                            }
                            
                            if(error == '2015')
                            {
                                    alert("Auction ID is Blank!");
                            }
                            
                            if(error == '2013')
                            {
                                    document.getElementById("BidVal_"+Auction_id).value = "";
                                    alert("Your current Bid value is less than Current Highest Bidder. Please check the minimum bid value and bid again!");
                            }
                            
                            if(error == '2014')
                            {
                                    document.getElementById("BidVal_"+Auction_id).value = "";
                                    alert("You don't have sufficient balance to Bid!");
                            }
                            
                            if(error == '2026')
                            {
                                    document.getElementById("BidVal_"+Auction_id).value = "";
                                    alert("You have Exceeded the Transfer Limit for the Day!!");
                            }
                            
                            if(error == '2027')
                            {
                                    document.getElementById("BidVal_"+Auction_id).value = "";
                                    alert("You don't have sufficient Points limit for the Day or Check Your Limit Per Day!");
                            }

                            if(error == '1001')
                            {
                                alert("Congrats! Your Bid For Auction is Successful!");
                            }
                        }
                });
            }
        }
        
        function show_transfer_form()
        {
            $("#Transfer_form").css("display","");
        }
        
        function check_membershipid(Transfer_membershipid)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "2sRLGRaTO+vksKSxFAOYRe4bI66GSwod+nu+FkFxQ5Y=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Transfer_membershipid:Transfer_membershipid},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '2006')
                        {
                            alert("Membership ID is Blank!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '2016')
                        {
                            alert("Transfer To Membership ID is Blank!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }
                        
                        if(error == '2017')
                        {
                            alert("Invalid Transfer To Membership ID. Please Enter Proper Membership ID!");
                            $("#My_CurrentBalance").val("");
                            $("#Transfer_membershipid").val("");
                            $("#Transfer_to_name").val("");
                            $("#Transfer_to_membershipid").val("");
                            $("#Transfer_to_phone").val("");
                        }

                        if(error == '1001')
                        {
                            if(json['Cust_pin_validation'] == 1)
                            {
                                $("#Customer_pin").css("display","");
                                $("#Cust_pin_validation").val(json['Cust_pin_validation']);
                            }
                            
                            $("#My_CurrentBalance").val(json['Current_balance']);
                            $("#Transfer_to_name").val(json['First_name']+json['Last_name']);
                            $("#Transfer_to_membershipid").val(json['Membership_id']);
                            $("#Transfer_to_phone").val(json['Phone_no']);
                        }
                    }
            });
        }
        
        function Transfer_points()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "uVSqXa0x2xTIFR+khEJzHy13HZEN2G2CzYEXk44NY70=";
            
            var Transfer_to_membershipid = $("#Transfer_to_membershipid").val();
            var points_to_transfer = $("#points_to_transfer").val();
            var Cust_pin_validation = $("#Cust_pin_validation").val();
            
            if(Cust_pin_validation == 1)
            {
                var pin_no = $("#pin_no").val();
            }
            else
            {
                var pin_no = "0";
            }
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Transfer_to_membershipid:Transfer_to_membershipid, points_to_transfer:points_to_transfer, pin_no:pin_no},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '2006')
                        {
                            alert("Membership ID is Blank!");
                        }
                        
                        if(error == '2014')
                        {
                            alert("Insufficient Current Balance!");
                        }

                        if(error == '2016')
                        {
                            alert("Transfer To Membership ID is Blank!");
                        }
                        
                        if(error == '2017')
                        {
                            alert("Invalid Transfer To Membership ID. Please Enter Proper Membership ID!");
                        }
                        
                        if(error == '2018')
                        {
                            alert("Invalid Transfer Point Entered!");
                        }
                        
                        if(error == '2025')
                        {
                            alert("Invalid Pin Entered!");
                        }

                        if(error == '1001')
                        {
                            alert("Points Transfer Success!");
                        }
                    }
            });
        }
        
        function resend_pin()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "BTttb0wioAIlXrzr9JvPU9TfXHar2ZrRi/e8pOxThq4=";
		
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, 
                                    API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                                alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                                alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                                alert("Your Pin Successfully Sent to your Email ID.");
                        }
                    }
            });
        }
        
        function update_profile()
        {
            var Company_username = "diamondbank123";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "s6rrVG6mAdPn6p9ScRAJQMKcYr4ggNY9/qV6rxoNIUk=";//"/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "w/xOS/nYeyg1jrtvDV81Um88AL8TALAEeiPxVZdx+tM=";//"6NJcnzOHrLApMB3aMr3BDtPMmrEzKiGoiD2LgtZ+yAo=";
            
            var Changed_firstname = "E0vxU3w/h6K6Z/shJlSpQOWeXKxW1eDrmwYjylQZIS8=";
            var Changed_middlename = "0cnZxbcE0M9llysh1fUyGaRefzRuqW+UyftY8GRfYV8=";
            //var Changed_Communicationflag = "FVEK92GxtTGBBeRqjMwm4g==";
            var Changed_DOB = "3VCPBwunRnvnHt13luDzb\/RvtbxmbEmpgSZGwgXQmgc=";
            //var Changed_DOB = "RKCEDBx4t8T4olxDP3dIuiSMCm8YYVtqNI1tyRqgJp8=";
            
            var Update_profile = {First_name:Changed_firstname, Middle_name:Changed_middlename, Date_of_birth:Changed_DOB}//Communication_flag:Changed_Communicationflag
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id,
                            Update_profile:Update_profile, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                                alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                                alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                                alert("Profile Updated Successfully!");
                        }
                    }
            });
        }
        
        function show_statement_form()
        {
            $("#Statement_form").css("display","");
        }
        
        function Get_statement()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "jbV+3fVKuj0bdnwoSggDp4uocPlUYrxa5d4qN6HvQVM=";
            
            var From_date = $('#From_date').val();
            var Till_date = $('#Till_date').val();
            var View = $('#View').val();
            
            var Start_limit = $('#Stmt_Start_limit').val();
            var End_limit = $('#Stmt_End_limit').val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, 
                            API_flag:API_flag, From_date:From_date, Till_date:Till_date, View:View, Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                                alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                                alert("Blank Membership ID!");
                        }
                        
                        if(error == '2012')
                        {
                            alert("No Data Found!");
                        }

                        if(error == '1001')
                        {
                            $('#Statement_details').css("display","");
                            $('#Statement_details_table').css("display","");
                            var HTML = "";
                            var Result_data = json['Result_data'];
                            
                            $.each(Result_data, function(key,value)
                            {
                                //if(key != "status")
                                {
                                    if(value['View'] == 1)
                                    {
                                        $('#Detail_tr').css("display","");
                                        HTML = "<tr>\n\
                                                <td>"+value['Transaction_date']+"</td>\n\
                                                <td>"+value['Transaction_type_name']+"</td>\n\
                                                <td>"+value['Description']+"</td>\n\
                                                <td>"+value['Bill_no']+"</td>\n\
                                                <td>"+value['Order_no']+"</td>\n\
                                                <td>"+value['Voucher_no']+"</td>\n\
                                                <td>"+value['Transaction_amount']+"</td>\n\
                                                <td>"+value['Loyalty_points']+"</td>\n\
                                                <td>"+value['Bonus_points']+"</td>\n\
                                                <td>"+value['Total_redeem_points']+"</td>\n\
                                                <td>"+value['Quantity']+"</td>\n\
                                                <td>"+value['Order_status']+"</td>\n\
                                                <td>"+value['Voucher_status']+"</td>\n\
                                                <td>"+value['Delevery_flag']+"</td>\n\
                                                <td>"+value['Transfer_points']+"</td>\n\
                                                </tr>";
                                        $('#Statement_details_table > tbody:last-child').append(HTML);
                                    }
                                    
                                    if(value['View'] == 2)
                                    {
                                        $('#Summary_tr').css("display","");
                                        HTML = "<tr>\n\
                                                <td>"+value['Transaction_type_name']+"</td>\n\
                                                <td>"+value['Transaction_amount']+"</td>\n\
                                                <td>"+value['Loyalty_points']+"</td>\n\
                                                <td>"+value['Bonus_points']+"</td>\n\
                                                <td>"+value['Total_redeem_points']+"</td>\n\
                                                <td>"+value['Transfer_points']+"</td>\n\
                                                </tr>";
                                        $('#Statement_details_table > tbody:last-child').append(HTML);
                                    }
                                }
                            });
                        }
                    }
            });
        }
        
        function Fetch_survey()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "w/UQWzenQ/lW2T7SiOItHTORTgYBON4Bb/ZLErTmy+Q=";

            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '2012')
                        {
                            alert("No Survey Found!");
                        }

                        if(error == '1001')
                        {
                            $("#Survey_div").css("display","");
                            var Survey_details = json['Survey_details'];
                            $.each(Survey_details, function(key,value)
                            {
                                //if(key != "status")
                                {
                                    $('#Survey_id').append($('<option>', {
                                        value: value['Survey_id'],
                                        text: value['Survey_name']
                                    }));
                                }
                            });
                        }
                    }
            });
        }
        
        function Get_survey_details(Survey_id)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "7DuWH25sdg7kbKL9BX2x5hnCwLYRPJk38Nm2ftysYUY=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Survey_id:Survey_id},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '2012')
                        {
                            alert("No Survey Found!");
                        }

                        if(error == '1001')
                        {
                            $("#Survey_details").css("display","");
                            $("#survey_questions").css("display","");
                            var questionID1 = new Array();
                            var questionID2 = new Array();
                            var Question_details = json['Question_details'];
                            
                            $.each(Question_details, function(key,value)
                            {
                                var HTML1 = ""; var HTML2 = ""; var HTML3 = "";
                                
                                //if(key != "status" && key != "Survey_id" && key != "Result_count")
                                {
                                    HTML1 = "<tr>\n\
                                            <td>"+value['Question_no']+") "+value['Question']+"</td>\n\
                                            <td>";
                                    
                                    if(value['Response_type'] == 1)
                                    {
                                        questionID1.push(value['Question_id']);
                                        var Value_id = value['Value_id']; 

                                        $.each(Value_id, function(key1,value1)
                                        {
                                            HTML2 += "<div class='radio'>\n\
                                                        <label>\n\
                                                          <input type='radio' name='ans"+value['Question_id']+"' value='"+key1+"'>\n\
                                                          "+value1+"\n\
                                                        </label>\n\
                                                      </div>";
                                        });             
                                    }
                                    else
                                    {
                                        questionID2.push(value['Question_id']);
                                        HTML2 += "<div class='form-group'>\n\
                                                    <textarea class='form-control' rows='3' name='text_ans"+value['Question_id']+"'></textarea>\n\
                                                  </div>";
                                    }
                                    
                                    HTML3 = "</td></tr>";
                                    
                                    var HTML = HTML1 + HTML2 + HTML3;
                                    $('#survey_questions > tbody:last-child').append(HTML);
                                }
                            });
                            
                            $('#survey_questions > tbody:last-child').append("<input type='hidden' name='questionID1[]' value='"+questionID1+"'>\n\
                                                                              <input type='hidden' name='questionID2[]' value='"+questionID2+"'>\n\
                                                                              <input type='hidden' name='Survey_id' value='"+json['Survey_id']+"'>\n\
                                                                              <input type='hidden' name='total_count' value='"+json['Result_count']+"'>");
                        }
                    }
            });
        }
        
        $(document).ready(function()
        {
            $(document).on('submit', '#Survey_form', function()
            {
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
                var API_flag = "itCZsTfksS6ZjbeQikPOTYFfhhNeSWe77hMAEvD7/EQ=";

                var data = $(this).serialize();

                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Survey_id:Survey_id},
                        url: API_URL,
                        data : data,
                        dataType: "json", 
                        success: function(data)
                        {
                            var error = data['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }
                            
                            if(error == '2021')
                            {
                                alert("Sorry!! The Survey given is In-Complete. All Questions are Mandatory. Please Enter / Select response for all Questions...!!!");
                            }
                            
                            if(error == '2020')
                            {
                                alert("Please Provide Valid Data");
                            }

                            if(error == '1001')
                            {
                                alert("Survey Received! Thank you for your Feedback!!");
                                location.reload();
                            }
                        }
                });
                
                return false;
            });
        });
        
        function Show_promocode_form()
        {
            $("#PromoCode_form").css("display","");
        }
        
        function Apply_promocode()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "bebXYGxoaEzHEsKlo1gATvN5wlZY/eJFZMr/WYF3GS0=";
            var Promo_code = $('#Promo_code').val();

            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Promo_code:Promo_code},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '2022')
                        {
                            alert("Promo Code is Blank!");
                        }

                        if(error == '2023')
                        {
                            alert("Invalid Promo Code!");
                        }
                        
                        if(error == '2024')
                        {
                            alert("Sorry, You Entered Invalid Promo Code 3 times. Try Again Tomorrow!");
                        }

                        if(error == '1001')
                        {
                            alert("Congrats! You have got a Extra "+json['Promo_points']+" Bonus Points !!");
                            location.reload();
                        }
                    }
            });
        }
        
        function Fetch_catalogue()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "yfaWlk7Kd6S0jiUxN7Nd6X/0Z8D9YlOPLFeEHj6chUI=";
            var Start_limit = "";
            var End_limit = "";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                            Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '2012')
                        {
                            alert("No Merchandize Items Found!");
                        }
                        
                        if(error == '2027')
                        {
                            alert("You don't have sufficient Points limit for the day OR Check your limit per day!");
                        }

                        if(error == '1001')
                        {
                            $("#Catalogue").css("display","");
                            var CurrentBal = "<p class='text-center'><b>Current Balance</b></p><input type='text' readonly class='form-control text-center' value='"+json['Current_balance']+"' />";
                            var CartTotal = "<p class='text-center'><b>My Cart Total</b></p><input type='text' readonly class='form-control text-center' value='"+json['Total_Redeem_points_incart']+"' />";
                            $("#Redeem_CB").html(CurrentBal);
                            $("#Cart_total").html(CartTotal);
                            var Catalogue_details = json['Catalogue_details'];
                            
                            $.each(Catalogue_details, function(key,value)
                            {
                                var Branch_details = value['Branch_details'];
                                var Company_merchandize_item_code = value['Merchandize_item_code'];
                                var HTML1 = ""; var HTML2 = ""; var HTML3 = ""; var HTML4 = ""; var HTML5 = ""; var HTML6 = "";
                                
                                //if(key != "status" && key != "Current_balance" && key != "Total_Redeem_points_incart" && key != "Total_items_incart")
                                {
                                    HTML1 = "<div class='col-xs-6 col-md-3 well'>\n\
                                                <img src='"+value['Item_image']+"' alt='"+value['Merchandize_item_name']+"' class='img-responsive' style='height: 150px; margin: 0px auto;'>\n\
                                                <div class='panel panel-default' style='margin-top: 10px;'>\n\
                                                    <div class='panel-heading text-center' style='height: 75px;'>"+value['Merchandize_item_name']+"</div>\n\
                                                    <div class='panel-heading text-center'><p class='text-center'><span class='label label-danger'>"+value['Billing_price_in_points']+"</span></p></div>\n\
                                                    <div class='panel-body'>";
                                    
                                    if(value['Delivery_method'] == 1)
                                    {
                                        HTML2 = "<div class='radio'>\n\
                                                    <label>\n\
                                                        <input type='radio' name='delivery_method_"+value['Company_merchandise_item_id']+"' id='radioID_"+value['Company_merchandise_item_id']+"' onclick='show_branch(this.value,"+value['Company_merchandise_item_id']+");' value='1' checked='checked' >\n\
                                                        Redeemed in Person\n\
                                                    </label>\n\
                                                </div>\n\
                                                <div class='radio' style='visibility: hidden;'>\n\
                                                    <label>\n\
                                                        <input type='radio' disabled >\n\
                                                        To be Delivered\n\
                                                    </label>\n\
                                                </div>";
                                    }
                                    else if(value['Delivery_method'] == 2)
                                    {
                                        HTML2 = "<div class='radio'>\n\
                                                    <label>\n\
                                                        <input type='radio' name='delivery_method_"+value['Company_merchandise_item_id']+"' id='radioID_"+value['Company_merchandise_item_id']+"' onclick='show_branch(this.value,"+value['Company_merchandise_item_id']+");' value='2' checked='checked' >\n\
                                                        To be Delivered\n\
                                                    </label>\n\
                                                </div>\n\
                                                <div class='radio' style='visibility: hidden;'>\n\
                                                    <label>\n\
                                                        <input type='radio' disabled >\n\
                                                        To be Delivered\n\
                                                    </label>\n\
                                                </div>";
                                    }
                                    else if(value['Delivery_method'] == 3)
                                    {
                                        HTML2 = "<div class='radio'>\n\
                                                    <label>\n\
                                                        <input type='radio' name='delivery_method_"+value['Company_merchandise_item_id']+"' id='radioID_"+value['Company_merchandise_item_id']+"' onclick='show_branch(this.value,"+value['Company_merchandise_item_id']+");' value='1'>\n\
                                                        Redeemed in Person\n\
                                                    </label>\n\
                                                </div>\n\
                                                <div class='radio'>\n\
                                                    <label>\n\
                                                        <input type='radio' name='delivery_method_"+value['Company_merchandise_item_id']+"' id='radioID_"+value['Company_merchandise_item_id']+"' onclick='show_branch(this.value,"+value['Company_merchandise_item_id']+");' value='2'>\n\
                                                        To be Delivered\n\
                                                    </label>\n\
                                                </div>";
                                    }
                                    
                                    if(value['Delivery_method'] == 1 || value['Delivery_method'] == 3)
                                    {
                                        HTML4 = "<select class='form-control' name='branch_"+value['Company_merchandise_item_id']+"' id='branch_"+value['Company_merchandise_item_id']+"' >\n\
                                                <option value=''>Select Partner Location</option>";

                                        $.each(Branch_details, function(key1,value1)
                                        {
                                            HTML6 += "<option value='"+value1['Branch_code']+"'>"+value1['Branch_name']+"</option>";
                                        });
                                 
                                        HTML5 = "</select/>";
                                    }
                                    else
                                    {
                                        HTML4 = "<select class='form-control' disabled style='visibility: hidden;'>";
                                        HTML6 = "<option></option>";
                                        HTML5 = "</select/>";
                                    }
                                    HTML3 = "       <input type='hidden' id='Item_code_"+value['Company_merchandise_item_id']+"' value='"+Company_merchandize_item_code+"'>\n\
                                                    </div>\n\
                                                    <div class='panel-footer text-center'>\n\
                                                        <button type='button' class='btn btn-success' onclick='add_to_cart("+value['Billing_price_in_points']+","+value['Company_merchandise_item_id']+")'>Add to Cart</button>\n\
                                                    </div>\n\
                                                </div>\n\
                                            </div>";
                                    
                                    var HTML = HTML1 + HTML2 + HTML4 + HTML6 + HTML5 + HTML3;
                                                        
                                    $('#Catalogue_items').append(HTML);
                                }
                            });
                        }
                    }
            });
        }
        
        function show_branch(delivery_method_value,Company_merchandise_item_id)
        {
            if(delivery_method_value == 1)
            {
                $('#branch_'+Company_merchandise_item_id).css("visibility","visible");
            }
            else
            {
                $('#branch_'+Company_merchandise_item_id).css("visibility","hidden");
            }
        }
        
        function add_to_cart(Billing_price_in_points,Company_merchandise_item_id)
        {
            var Redemption_method = $('#radioID_'+Company_merchandise_item_id+':checked').val();
            var Company_merchandize_item_code = $('#Item_code_'+Company_merchandise_item_id).val();
            if(Redemption_method == 1)
            {
                var Branch = $('#branch_'+Company_merchandise_item_id).val();
            }
            else
            {
                var Branch = "";
            }            

            if(Redemption_method == 1 && Branch == "")
            {
                alert("Please Select Partner Location!");
            }
            else
            {
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
                var API_flag = "wAA0HqrviVRQj3mryemy5Rm6D8xJp5o5FVnjMBQdUAw=";
            
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                               Billing_price_in_points:Billing_price_in_points, Redemption_method:Redemption_method, Company_merchandize_item_code:Company_merchandize_item_code,
                               Branch:Branch},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }
                            
                            if(error == '2014')
                            {
                                alert("You don't have sufficient Balance to Redeem Items!");
                            }
                            
                            if(error == '2026')
                            {
                                alert("You have Exceeded the Redeem Limit for the Day!!");
                            }
                            
                            if(error == '2027')
                            {
                                alert("You don't have sufficient Points limit for the Day or Check Your Limit Per Day!");
                            }
                        
                            if(error == '1001')
                            {
                                var CartTotal = "<p class='text-center'><b>My Cart Total</b></p><input type='text' readonly class='form-control text-center' value='"+json['Total_Redeem_points_incart']+"' />";
                                $("#Cart_total").html(CartTotal);
                                
                                alert("Item has been added to cart.");
                            }
                        }
                });
            }
        }
        
        function Show_catalogue()
        {
            $('#Redeem_Catalogue').css("display","none");
            $('#Catalogue').css("display","");
        }
        
        function Show_checkout()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "BC3KDfB3RlMBbxdc5VihY1hdtg8BdjXpgw6jVduPxiQ=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '2014')
                        {
                            alert("You don't have sufficient Balance to Redeem Items!");
                        }
                        
                        if(error == '2012')
                        {
                            alert("There are not Item(s) in your Cart. Please add atleast one Item in Cart!");
                        }

                        if(error == '1001')
                        {
                            $('#Redeem_Catalogue').css("display","");
                            $('#Catalogue').css("display","none");
            
                            Fetch_country();
                            var Redemption_method_array = new Array();
                            var Item_array = new Array();
                            var Remark_value = "";
                            
                            
                            var Cart_details = json['Cart_details'];
                            var Status_array = json['Status_array'];
                            //alert(Status_array['Cust_pin_validation']);
                            
                            $.each(Cart_details, function(key,value)
                            {
                                var HTML = "";  var HTML2 = "";
                                
                                //if(key != "status" && key != "Total_points" && key != "Total_shipping_points" && key != "Grand_Total_Points" && key != "Cart_quantity" && key != "Current_address" && key != "Country_name" && key != "State_name" && key != "City_name" && key != "City_id" && key != "State_id" && key != "Country_id" && key != "Merchandize_item_array" && key != "Remark_item_count" && key != "Delivery_item_count")
                                {
                                    Redemption_method_array.push(value['Delivery_Method']);
                                    Item_array.push(value['Merchandize_item_name']);
                                    
                                    $('#Item_row_'+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']).remove();
                                    HTML = "<tr id='Item_row_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"'>\n\
                                                <td class='text-center'>\n\
                                                    <a href='javascript:void(0);' onclick='Remove_item(\""+value['Company_merchandize_item_code']+"\","+value['Delivery_Method']+",\""+value['Branch']+"\");' >\n\
                                                        <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>\n\
                                                    </a>\n\
                                                </td>\n\
                                                <td class='text-center'>"+value['Merchandize_item_name']+"</td>\n\
                                                <td class='text-center'>\n\
                                                    <input type='number' class='form-control' id='Quantity_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"' value='"+value['Quantity']+"' onchange='Show_update(\""+value['Company_merchandize_item_code']+"\","+value['Delivery_Method']+",\""+value['Branch']+"\");' style='width:40%;margin: 0px auto;' />\n\
                                                    <a class='text-center' href='javascript:void(0);' style='color:red;display:none;' id='Update_"+value.Company_merchandize_item_code+'_'+value.Delivery_Method+'_'+value.Branch+"' onclick='Update_quantity(\""+value['Company_merchandize_item_code']+"\","+value['Delivery_Method']+",\""+value['Branch']+"\");' >Update</a>\n\
                                                </td>\n\
                                                <td class='text-center'>"+value['RedemptionMethod']+"</td>\n\
                                                <td class='text-center'>"+value['Partner_location']+"</td>\n\
                                                <td class='text-center' id='Redeemable_points_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"'>"+value['Total_Redeemable_points']+"</td>\n\
                                                <td class='text-center'>\n\
                                                    <span id='converted_shipping_points_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+"'>"+value.Shipping_points+"</span>\n\
                                                </td>";
                                                 //</tr>       
                                        if(value['Enable_remark'] == 1)
                                        {
                                            if(value['Remark'] != ""){ Remark_value = value['Remark']; }
                                            
                                            $('#Remark_row_'+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']).remove();
                                            HTML2 = "</tr>\n\
                                                    <tr id='Remark_row_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"'>\n\
                                                        <td>&nbsp;</td>\n\
                                                        <td class='text-right'>"+value['Remark_label']+" : </td>\n\
                                                        <td class='text-center' colspan='5'>\n\
                                                            <input type='text' class='form-control' name='Remark_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"' id='Remark_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"' required='required' onchange='Show_remark_update(\""+value['Company_merchandize_item_code']+"\","+value['Delivery_Method']+",\""+value['Branch']+"\");' value='"+Remark_value+"' style='width: 50%;' />\n\
                                                            <a class='text-center' href='javascript:void(0);' style='color:red;display:none;float:left;' id='Remark_Update_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"' onclick='Update_remark(\""+value['Company_merchandize_item_code']+"\","+value['Delivery_Method']+",\""+value['Branch']+"\");' >Update</a>\n\
                                                        </td>\n\
                                                    </tr>";
                                        }
                                        else
                                        {
                                            HTML2 = "   <input type='hidden' name='Remark_"+value['Company_merchandize_item_code']+'_'+value['Delivery_Method']+'_'+value['Branch']+"' value='' />\n\
                                                     </tr>";
                                        }
                                    
                                    var HTML3 = HTML + HTML2;
                                    
                                    $('#Item_row_table > tbody > tr').eq(0).after(HTML3);
                                }
                            });
                            
                            Item_array = Item_array.join("*");
                            
                            $('#Total_Points').val(Status_array['Total_points']);
                            $('#Total_Shipping_Points').val(Status_array['Total_shipping_points']);
                            $('#Grand_Total_Points').val(Status_array['Grand_Total_Points']);
                            
                            $("textarea#CurrentAddress").val(Status_array['Current_address']);
                            
                            $('#CurrentCountry').append($('<option>', {
                                value: Status_array['Country_id'],
                                text: Status_array['Country_name']
                            }));
                            
                            $('#CurrentState').append($('<option>', {
                                value: Status_array['State_id'],
                                text: Status_array['State_name']
                            }));
                            
                            $('#CurrentCity').append($('<option>', {
                                value: Status_array['City_id'],
                                text: Status_array['City_name']
                            }));
                            
                            if(Status_array['Delivery_item_count'] > 0)
                            {
                                $('.ShipAddress').css("display","");
                                $('#ShippingAddress').prop('required', true);
                                $('#ShippingCountry').prop('required', true);
                                $('#ShippingState').prop('required', true);
                                $('#ShippingCity').prop('required', true);
                            }
                            else
                            {
                                $('.ShipAddress').css("display","none");
                                $('#ShippingAddress').prop('required', false);
                                $('#ShippingCountry').prop('required', false);
                                $('#ShippingState').prop('required', false);
                                $('#ShippingCity').prop('required', false);
                            }
                            
                            if(Status_array['Cust_pin_validation'] == 1)
                            {
                                $('#CustPin').css("display","");
                            }
                            
                            HTML2 = "<input type='hidden' class='form-control' name='Cart_quantity' id='Cart_quantity' value='"+Status_array['Cart_quantity']+"' />\n\
                                    <input type='hidden' id='Country_name' value='"+Status_array['Country_name']+"' />\n\
                                    <input type='hidden' id='State_name' value='"+Status_array['State_name']+"' />\n\
                                    <input type='hidden' id='City_name' value='"+Status_array['City_name']+"' />\n\
                                    <input type='hidden' id='Remark_item_count' name='Remark_item_count' value='"+Status_array['Remark_item_count']+"' />\n\
                                    <input type='hidden' name='Merchandize_item_array' value='"+Item_array+"' />";
                            $('#Grand_Total_Points').after(HTML2);
                        }
                    }
            });
        }
        
        function Show_update(Company_merchandize_item_code,Delivery_Method,Branch)
        {
            $('#Update_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).show();
        }
        
        function Show_remark_update(Company_merchandize_item_code,Delivery_Method,Branch)
        {
            $('#Remark_Update_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).show();
        }
        
        function Update_remark(Company_merchandize_item_code,Delivery_Method,Branch)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "kOloHo+sCiBR+iIiP0DOHbiwOIUt4T6p2VloydQYzN8=";
            var Remark = $('#Remark_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Company_merchandize_item_code:Company_merchandize_item_code, Delivery_Method:Delivery_Method, Branch:Branch, Remark:Remark},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                            $('#Remark_Update_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).hide();
                            alert("Remark Added Successfuly Cart!!");
                        }
                    }
            });
        }
        
        function Update_quantity(Company_merchandize_item_code,Delivery_Method,Branch)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "rC4jbAq48FT8jAcPpBa+M8IOoQRAFcQAhpivn90sTUM=";
            var Quantity = $('#Quantity_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).val();
            
            var ShippingCountry = $('#ShippingCountry').val();            
            if(ShippingCountry == 0)
            {
                var State_id = $('#CurrentState').val();
                var Country_id = $('#CurrentCountry').val();
            }
            else
            {
                var State_id = $('#ShippingState').val();
                var Country_id = ShippingCountry;
            }
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Company_merchandize_item_code:Company_merchandize_item_code, Delivery_Method:Delivery_Method, Branch:Branch, Quantity:Quantity},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }
                        
                        if(error == '2014')
                        {
                            alert("You don't have sufficient balance");
                        }
                        
                        if(error == '2027')
                        {
                            alert("You have Exceeded the Transfer Limit for the Day");
                        }
                        
                        if(error == '2026')
                        {
                            alert("You don't have sufficient Points limit for the Day or Check Your Limit Per Day");
                        }

                        if(error == '1001')
                        {
                            if(json['Cart_quantity'] > 0)
                            {
                                $('#Redeemable_points_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).html(json['Total_Redeemable_points']);
                                $('#converted_shipping_points_'+Company_merchandize_item_code+'_'+Delivery_Method).html(json['Item_shipping_cost']);
                                $('#Quantity_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).val(Quantity);
                                $('#Update_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).hide();
                                
                                $('#Total_Points').val(json['Total_points']);
                                $('#Total_Shipping_Points').val(json['Total_shipping_points']);
                                $('#Grand_Total_Points').val(json['Grand_Total_Points']);
                            }
                            else
                            {
                                $('#Total_Points').val("0");
                                $('#Total_Shipping_Points').val("0");
                                $('#Grand_Total_Points').val("0");
                            }
                            
                            alert("Item Quantity Updated Successfuly from Cart!!");                           
                        }
                    }
            });
        }
        
        function Remove_item(Company_merchandize_item_code,Delivery_Method,Branch)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "P63/L5KUu0hDknif4PFQTKzB5kq5P1zaKHSOG9QtZoc=";
            
            var ShippingCountry = $('#ShippingCountry').val();            
            if(ShippingCountry == 0)
            {
                var State_id = $('#CurrentState').val();
                var Country_id = $('#CurrentCountry').val();
            }
            else
            {
                var State_id = $('#ShippingState').val();
                var Country_id = ShippingCountry;
            }
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Company_merchandize_item_code:Company_merchandize_item_code, Delivery_Method:Delivery_Method, Branch:Branch},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                            $('#Item_row_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).remove();
                            $('#Remark_row_'+Company_merchandize_item_code+'_'+Delivery_Method+'_'+Branch).remove();
                            //$('#Remark_Update_'+Company_merchandize_item_code+'_'+Delivery_Method).remove();
                            
                            if(json['Cart_quantity'] > 0)
                            {
                                $('#Total_Points').val(json['Total_points']);
                                $('#Total_Shipping_Points').val(json['Total_shipping_points']);
                                $('#Grand_Total_Points').val(json['Grand_Total_Points']);
                            }
                            else
                            {
                                $('#Total_Points').val("0");
                                $('#Total_Shipping_Points').val("0");
                                $('#Grand_Total_Points').val("0");
                            }
                            
                            alert("Item Deleted Successfuly from Cart!!");                            
                        }
                    }
            });
        }
        
        $(document).ready(function()
        {
            $(document).on('submit', '#Redemption_form', function()
            {
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
                var API_flag = "e2ZSDe/jEqu/VSTOFQhGM3BEFrRkSR6SoWXBrtvLxG8=";
                var data = $(this).serialize();

                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag},
                        url: API_URL,
                        data : data,
                        dataType: "json", 
                        success: function(data)
                        {
                            var error = data['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }
                            
                            if(error == '2014')
                            {
                                alert("You don't have sufficient Balance to Redeem Items!");
                            }
                            
                            if(error == '2020')
                            {
                                alert("Please Provide Valid Data");
                            }
                            
                            if(error == '2059')
                            {
                                alert("There are Invalid items present in Cart");
                            }

                            if(error == '1001')
                            {
                                alert("Congrats! Your Redemption is Successfull!!!");
                                location.reload();
                            }
                        }
                });
                
                return false;
            });
        });
        
        function Change_shipping_address()
        {
            var CurrentAddress = $("#CurrentAddress").val();
            var CurrentCountry = $("#CurrentCountry").val();
            var CurrentState = $("#CurrentState").val();
            var CurrentCity = $("#CurrentCity").val();
            var Country_name = $("#Country_name").val();
            var State_name = $("#State_name").val();
            var City_name = $("#City_name").val();
                            
            if($('#Same_address').is(":checked"))
            {
                $('#ShippingCountry').empty();
                $('#ShippingState').empty();
                $('#ShippingCity').empty();
                
                $('#ShippingAddress').val(CurrentAddress);
                $('#ShippingAddress').prop('readonly', true);
                
                $('#ShippingCountry').append($('<option>', {
                    value: CurrentCountry,
                    text: Country_name
                }));
                
                $('#ShippingState').append($('<option>', {
                    value: CurrentState,
                    text: State_name
                }));
                
                $('#ShippingCity').append($('<option>', {
                    value: CurrentCity,
                    text: City_name
                }));
                
                Calculate_shipping_cost(CurrentState,CurrentCountry);
            }
            else
            {
                $('#ShippingAddress').val("");
                $('#ShippingCountry').empty();
                $('#ShippingState').empty();
                $('#ShippingCity').empty();
                Fetch_country();
                $('#ShippingAddress').prop('readonly', false);
            }
        }
        
        function Fetch_country()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "W1Xo+ZcKavt70vsjHXFE6xp5npw5ZBAJlUkpnSj4bR4=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                            $('#ShippingCountry').append($('<option>', {
                                value: 0,
                                text: "Select Country"
                            }));
                                    
                            $.each(json, function(key,value)
                            {
                                if(key != "status")
                                {
                                    $('#ShippingCountry').append($('<option>', {
                                        value: value.Country_id,
                                        text: value.Country_name
                                    }));
                                }
                            });
                        }
                    }
            });
        }
        
        $(document).ready(function()
        {
            $(document).on('change', '#ShippingCountry', function()
            {
                $('#ShippingState').empty();
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var API_flag = "nDemzqLEtvKixMkt5TjtkPnFRnyDkITGpmvOtBf2D28=";
                var Country_id = $('#ShippingCountry').val();
                
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag, Country_id:Country_id},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }

                            if(error == '1001')
                            {
                                $('#ShippingState').append($('<option>', {
                                    value: 0,
                                    text: "Please Select State"
                                }));

                                $.each(json, function(key,value)
                                {
                                    if(key != "status")
                                    {
                                        $('#ShippingState').append($('<option>', {
                                            value: value.State_id,
                                            text: value.State_name
                                        }));
                                    }
                                });
                            }
                        }
                });
                
                return false;
            });
            
            $(document).on('change', '#ShippingState', function()
            {
                $('#ShippingCity').empty();                
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var API_flag = "ljm2MXJdodt9I4C85Gt2V+Fr0CeFwr2yL4kB5+V/VbQ=";
                var State_id = $('#ShippingState').val();
                var Country_id = $('#ShippingCountry').val();
                
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag, State_id:State_id},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }

                            if(error == '1001')
                            {
                                Calculate_shipping_cost(State_id,Country_id);
                                
                                $('#ShippingCity').append($('<option>', {
                                    value: 0,
                                    text: "Please Select City"
                                }));

                                $.each(json, function(key,value)
                                {
                                    if(key != "status")
                                    {
                                        $('#ShippingCity').append($('<option>', {
                                            value: value.City_id,
                                            text: value.City_name
                                        }));
                                    }
                                });
                            }
                        }
                });
                
                return false;
            });
        });
        
        function Calculate_shipping_cost(State_id,Country_id)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "Vyc17fDhcaLMJfwRzWaIM1QbmC0YuOM4OVudH2viXRQ=";
            //var Country_id = $('#ShippingCountry').val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag, Country_id:Country_id, State_id:State_id},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }
                        
                        if(error == '2014')
                        {
                            alert("You don't have sufficient Balance!");
                        }

                        if(error == '1001')
                        {
                            var total = 0;
                            var Shipping_details = json['Shipping_details'];
                            
                            $.each(Shipping_details, function(key,value)
                            {
                                $('#converted_shipping_points_'+value["Item_code"]+'_2').html(value["shipping_points"]);                                    
                                total = total + parseFloat(value["shipping_points"]);
                            });
                            
                            $('#Grand_Total_Points').val(json['Grand_Total_Points']);
                            $('#Total_Shipping_Points').val(json['Total_shipping_points']);
                        }
                    }
            });
        }
        
        function Show_enrollment()
        {
            $("#Enrollment_form").css("display","");
        }
        
        function Show_communication_type(Communication_type)
        {
            if(Communication_type == 1)
            {
                $('#CommunicationType').show();
            }
            else
            {
                $('#CommunicationType').hide();
            }
        }
        
        $(document).ready(function()
        {
            $(document).on('change', '#Referee_id', function()
            {
                $('#Referee_details').val("");
                var Company_username = "diamondbank1234";
                var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                var Membership_id = $('#Referee_id').val();
                var API_flag = "+pVJaJ/xorYxxF3AOwjoRgp3e0NLDB2Pd/6eS24PF8Q=";
                
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag, Referee_MembershipId:Membership_id},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                                $('#Referee_details').val("");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                                $('#Referee_details').val("");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Referee Membership ID!");
                                $('#Referee_details').val("");
                            }

                            if(error == '2004')
                            {
                                alert("Referee Membership Disabled!");
                                $('#Referee_details').val("");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                                $('#Referee_details').val("");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Referee Membership ID!");
                                $('#Referee_details').val("");
                            }

                            if(error == '1001')
                            {
                                var First_name = json['First_name'];
                                var Last_name = json['Last_name'];
                                var Phone_no = json['Phone_no'];
                                var Referee_details = First_name + " " + Last_name + " (" + Phone_no + ")";
                                $('#Referee_details').val(Referee_details);
                            }
                        }
                });
                
                return false;
            });
            
            $(document).on('submit', '#EnrollmentForm', function()
            {
                //var Company_username = "diamondbank1234";
                //var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
                //var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
                //var API_flag = "GSs5V2M6wSS5C95lXJLvHXaeGxyWPDyzjExIznckKKw=";
                var data = $(this).serialize();

                $.ajax
                ({
                        type: "POST",
                        //data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag},
                        url: API_URL,
                        data : data,
                        dataType: "json", 
                        success: function(data)
                        {
                            var error = data['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }
                            
                            if(error == '2020')
                            {
                                alert("Communication Type is Blank!!");
                            }
                            
                            if(error == '2029')
                            {
                                alert("Membership ID Already Exist!!");
                            }
                            
                            if(error == '2030')
                            {
                                alert("Email ID Already Exist!!");
                            }
                            
                            if(error == '2031')
                            {
                                alert("Membership ID length not Matching!!");
                            }
                            
                            if(error == '2032')
                            {
                                alert("Phone No Already Exist!!");
                            }
                            
                            if(error == '2033')
                            {
                                alert("Membership Card Limit Exceeded!!");
                            }

                            if(error == '1001')
                            {
                                alert("Enrollment Done Successfuly!!");
                            }
                        }
                });
                
                return false;
            });
            
            $(document).on('submit', '#Family_EnrollmentForm', function()
            {
                var data = $(this).serialize();

                $.ajax
                ({
                        type: "POST",
                        //data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag},
                        url: API_URL,
                        data : data,
                        dataType: "json", 
                        success: function(data)
                        {
                            var error = data['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("Membership Disabled!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2006')
                            {
                                alert("Blank Membership ID!");
                            }
                            
                            if(error == '2020')
                            {
                                alert("Communication Type is Blank!!");
                            }
                            
                            if(error == '2029')
                            {
                                alert("Membership ID Already Exist!!");
                            }
                            
                            if(error == '2030')
                            {
                                alert("Email ID Already Exist!!");
                            }
                            
                            if(error == '2031')
                            {
                                alert("Membership ID length not Matching!!");
                            }
                            
                            if(error == '2032')
                            {
                                alert("Phone No Already Exist!!");
                            }
                            
                            if(error == '2033')
                            {
                                alert("Membership Card Limit Exceeded!!");
                            }

                            if(error == '1001')
                            {
                                alert("Family Member Enrollment Done Successfuly!!");
                            }
                        }
                });
                
                return false;
            });
        });
        
        function Show_family_enroll_form()
        {
            $("#Family_enroll_form").css("display","");
        }
        
        function Show_Benefit_Partners()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "LgCgiJsHPtKK9LYUKAirn7xu0enTb/F153NqFmWuq0c=";
            var Start_limit = "1";
            var End_limit = "1";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                            Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                            alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                            alert("Blank Membership ID!");
                        }

                        if(error == '1001')
                        {
                            $("#Benefit_partner").css("display","");
                            var HTML1 = ""; var HTML2 = ""; var HTML3 = "";
                            var Benefit_partner_details = json['Benefit_partner_details'];
                            
                            $.each(Benefit_partner_details, function(key,value)
                            {
                                HTML1 = "<tr>\n\
                                            <td class='text-left' colspan='6'><b>Partner : "+value['Partner_name']+"</b></td>\n\
                                        </tr>\n\
                                        <tr>\n\
                                            <td style='padding: 15px;' rowspan='5'>\n\
                                                <img style='height: 150px; margin: 0px auto;' src="+value['Partner_logo']+" class='img-responsive img-rounded' alt="+value['Partner_name']+">\n\
                                            </td>\n\
                                        </tr>\n\
                                        <tr>\n\
                                            <td class='text-center' colspan='3'><b>Address : </b>"+value['Partner_address']+"</td>\n\
                                            <td class='text-center' colspan='3'><b>Partner Category : </b>"+value['Partner_category_name']+"</td>\n\
                                        </tr>\n\
                                        <tr>\n\
                                            <td class='text-center' colspan='3'><b>Phone No : </b>"+value['Partner_contact_person_phno']+"</td>\n\
                                            <td class='text-center' colspan='3'><b>State : </b>"+value['State_name']+"</td>\n\
                                        </tr>\n\
                                        <tr>\n\
                                            <td class='text-center' colspan='3'><b>Email ID : </b>"+value['Partner_contact_person_email']+"</td>\n\
                                            <td class='text-center' colspan='3'><b>City : </b>"+value['City_name']+"</td>\n\
                                        </tr>\n\
                                        <tr>\n\
                                            <td class='text-center' colspan='3'><b>Benefit Description : </b>\n\
                                                <div class='list-group'>";
                                
                                var Benefit_details = value['Benefit_details'];
                                $.each(Benefit_details, function(key2,value2)
                                {
                                    HTML2 += "<a href='javascript:void(0);' class='list-group-item text-left'>"+value2['Benefit_description']+"</a>";
                                });
                                
                                        
                                HTML3 = "       </div>\n\
                                            </td>\n\
                                            <td class='text-center' colspan='3'><b>Website : </b>"+value['Partner_website']+"</td>\n\
                                        </tr>";
    
                                $('#Benefit_partner_table > tbody:last-child').append(HTML1+HTML2+HTML3);
                                //$('#Benefit_partner_table > tbody:last-child').append('<tr><td style="width: 30%; padding: 50px;"><img src="'+value['Prize_image']+'" class="img-responsive img-circle" alt="'+value['Auction_name']+'"></td><td class="text-center">'+value['Auction_name']+'</td><td class="text-center">'+value['Prize_description']+'</td><td class="text-center">'+value['Min_bid_value']+'</td><td><input type="text" class="form-control" id="BidVal_'+value['Auction_id']+'" placeholder="Enter Bid Value"></td><td><input class="btn btn-default" id="BidVal_'+value['Auction_id']+'" type="button" onclick="insert_bid('+value['Auction_id']+');" value="Bid Now"></td><td class="text-center;"><span class="label label-danger">'+Highest_bid_text+'</span></td></tr>');
                            });
                        }
                    }
            });
        }
        
        function Show_Enroll_statement()
        {
            $("#Enroll_Statement").css("display","");
        }
        
        function Fetch_All_Enrollments()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "iEfS3qo0110UwTxg0SyYhZ8sFNDfbFzKU+Cck5gqrAY=";
            var System_username = $('#System_user_email2').val();
            var System_password = $('#System_user_pass2').val();
            var From_date = $('#Enroll_From_date').val();
            var Till_date = $('#Enroll_Till_date').val();            
            var Start_limit = $('#Enroll_Start_limit').val();
            var End_limit = $('#Enroll_End_limit').val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, 
                            API_flag:API_flag, From_date:From_date, Till_date:Till_date, Username:System_username, Password:System_password,
                            Start_limit:Start_limit, End_limit:End_limit},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                                alert("Unable to Locate Membership ID!");
                        }

                        if(error == '2004')
                        {
                                alert("Membership Disabled!");
                        }

                        if(error == '404')
                        {
                                alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2006')
                        {
                                alert("Blank Membership ID!");
                        }
                        
                        if(error == '2007')
                        {
                            alert("Blank Username and Password!");
                        }
                        
                        if(error == '2012')
                        {
                            alert("No Data Found!");
                        }

                        if(error == '1001')
                        {
                            $('#Enroll_Statement_details').css("display","");
                            $('#Enroll_Statement_table').css("display","");
                            var HTML = "";
                            var Result_data = json['Enrollment_details'];
                            
                            $.each(Result_data, function(key,value)
                            {
                                HTML = "<tr>\n\
                                        <td>"+value['Enroll_date']+"</td>\n\
                                        <td>"+value['Membership_id']+"</td>\n\
                                        <td>"+value['First_name']+"</td>\n\
                                        <td>"+value['Last_name']+"</td>\n\
                                        <td>"+value['Current_address']+"</td>\n\
                                        <td>"+value['Phone_no']+"</td>\n\
                                        <td>"+value['User_email_id']+"</td>\n\
                                        <td>"+value['Current_balance']+"</td>\n\
                                        <td>"+value['Tier_name']+"</td>\n\
                                        </tr>";
                                $('#Enroll_Statement_table > tbody:last-child').append(HTML);
                            });
                        }
                    }
            });
        }
        
        function Show_Identification_form()
        {
            $('#Identification').show();
        }
        
        function Identification()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var System_username = $('#System_username').val();
            var System_password = $('#System_password').val();
            var API_flag = "tBvukRvfG3fK8L696Ym6PHV7drsaa3OJ2x0fNIh8pdg=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Username:System_username, Password:System_password, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }
                        
                        if(error == '2004')
                        {
                            alert("User is In-Active!");
                        }

                        if(error == '2005')
                        {
                            alert("Invalid Username or Password!");
                        }

                        if(error == '1001')
                        {
                            alert("System User is Valid!!");
                        }
                    }
            });
        }
        
        function Show_system_changepin_form()
        {
            $("#System_ChangePin_form").css("display","");
        }
        
        function change_system_user_pin()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "V5pr/5na/qsGdeKRTW2v0qtl9ENV92FCXgdX8pJZOxo=";
            
            var User_email_id = $('#System_user_email').val();
            var Password = $('#System_user_pass').val();
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Username:User_email_id,
                           API_flag:API_flag, Password:Password},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '2003')
                        {
                            alert("User is In-Active!");
                        }

                        if(error == '2004')
                        {
                            alert("User is In-Active!");
                        }

                        if(error == '2007')
                        {
                            alert("Blank values Passed!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '2046')
                        {
                            alert("Old Pin does not match with Current Pin!");
                        }

                        if(error == '1001')
                        {
                            alert("Your Pin Changed Successfully. Please check your Email.");
                            location.reload();
                        }
                    }
            });
        }
        
        function Show_system_changepass_form()
        {
            $("#System_ChangePass_form").css("display","");
        }
        
        function Show_Family_communication_type(Communication_type)
        {
            if(Communication_type == 1)
            {
                $('#Family_CommunicationType').show();
            }
            else
            {
                $('#Family_CommunicationType').hide();
            }
        }
        
        function change_system_user_pass()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "2s8BUSa+k584EHbWmiLOUfVaJKZG7cU/8AGPSaTTTN8=";
            
            var User_email_id = $('#System_useremail').val();
            var Current_pass = $('#System_Current_pass').val();
            var New_pass = $('#System_New_pass').val();
            var Confirm_pass = $('#System_Confirm_pass').val();
            
            if(New_pass != Confirm_pass)
            {
                alert("Confirm Password not Matches with New Password!!");
            }
            else
            {
                $.ajax
                ({
                        type: "POST",
                        data:{ Company_username:Company_username, Company_password:Company_password, Username:User_email_id,
                               API_flag:API_flag, Current_pass:Current_pass, New_pass:New_pass},
                        url: API_URL,
                        dataType: "json", 
                        success: function(json)
                        {
                            var error = json['status'];
                            if(error == '2001')
                            {
                                alert("Invalid Company Username!");
                            }

                            if(error == '2002')
                            {
                                alert("Invalid Company Password!");
                            }

                            if(error == '2003')
                            {
                                alert("Unable to Locate Membership ID!");
                            }

                            if(error == '2004')
                            {
                                alert("User is In-Active!");
                            }
                            
                            if(error == '2020')
                            {
                                alert("Blank values Passed!");
                            }

                            if(error == '404')
                            {
                                alert("Blank Company User Name or Company Password!");
                            }

                            if(error == '2011')
                            {
                                    alert("Old Password Does not match with current Password!");
                            }

                            if(error == '1001')
                            {
                                alert("Your Password Changed Successfully. Please check your Email.");
                                location.reload();
                            }
                        }
                });
            }
        }
        
        function Customer_lbs()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "OwOmFnb7cSBIY3aqZh2GZL7idlBC/TahEbjyj4Growg=";
            var Cust_latitude = "";
            var Cust_longitude = "";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Latitude:Cust_latitude, Longitude:Cust_longitude},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }
                        
                        if(error == '2003')
                        {
                                alert("Invalid Membership ID or User Email ID!");
                        }

                        if(error == '2006')
                        {
                                alert("Membership ID is Blank!");
                        }

                        if(error == '2008')
                        {
                                alert("User Email Id is Blank!");
                        }

                        if(error == '1001')
                        {
                            alert("LBS Polling Successful!");
                        }
                    }
            });
        }
        
        function Share_notification(Title,Content,Image_path,Social_icon_flag,Membership_id,User_notification_id,Invite_flag)
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            //var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "6vb9HrGfq+B75rRMjVNH4Vq15LdjYqsfTfpuJ+0s/Jo=";
            
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, Membership_id:Membership_id, API_flag:API_flag,
                           Title:Title, Content:Content, Image_path:Image_path, Social_icon_flag:Social_icon_flag, User_notification_id:User_notification_id, Flag:'0', Invite_flag:Invite_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }
                        
                        if(error == '2003')
                        {
                            alert("Invalid Membership ID or User Email ID!");
                        }

                        if(error == '2006')
                        {
                            alert("Membership ID is Blank!");
                        }
                        
                        if(error == '2004')
                        {
                            alert("Membership is Disabled!");
                        }

                        if(error == '1001')
                        {
                            alert("Notification Shared Successful!");
                            var Redirect_url = "https://demo.perxclm.com/share_notification.php?Title="+Title+"&Content="+Content+"&Image_path="+Image_path+"&Company_id="+json['Company_id']+"&Enrollment_id="+json['Enrollment_id']+"&Social_icon_flag="+Social_icon_flag+"&Flag=0&Invite_flag="+Invite_flag+"&User_notification_id="+json['User_notification_id'];
                            //var Redirect_url = "http://localhost/LSL_LBS/share_notification.php?Title="+Title+"&Content="+Content+"&Image_path="+Image_path+"&Company_id="+json['Company_id']+"&Enrollment_id="+json['Enrollment_id']+"&Social_icon_flag="+Social_icon_flag+"&Flag=0&Invite_flag="+Invite_flag+"&User_notification_id="+json['User_notification_id'];
                            //window.location = Redirect_url;
                            //window.open(Redirect_url, "_blank");
                            var win = window.open(Redirect_url, '_blank');
                        }
                    }
            });
        }
        
        function Show_points_converter_form()
        {
            $("#Show_points_converter_form").css("display","");
        }
        
        function convert_amt_to_points() 
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            //var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var API_flag = "ePsr+651gkJi63TqKALtmncqjaNExw6ADKi0h7RJANw="; //40
            
            var amount_to_convert = $('#amount_to_convert').val(); //zxYcouUqof5HnHX7ku6P+yHHyASjRLbOUUHc+D3xYx4=
            var cashier_username = $('#cashier_username').val(); //qEem0Muw9HUekynHiKrOrppsW/jDVLc6ezbGtb3VoS4=
            var cashier_password = $('#cashier_password').val(); //O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=
            var Membership_id = $('#Cnvrt_Membership_id').val(); //7kkA/8PXmz3y19BMfUo6m5AxbCJkPWlwA2vGiC98Vxg=

            
            $.ajax
            ({
                type: "POST",
                data:{ Company_username:Company_username, Company_password:Company_password, Amount_to_convert:amount_to_convert,API_flag:API_flag,Username:cashier_username,Password:cashier_password,Membership_id:Membership_id},
                url: API_URL,
                dataType: "json", 
                success: function(json)
                {
                    var error = json['status'];
                    if(error == '2001')
                    {
                        alert("Invalid Company Username!");
                    }

                    if(error == '2002')
                    {
                        alert("Invalid Company Password!");
                    }

                    if(error == '2005')
                    {
                        alert("Invalid Username or Password!");
                    }

                    if(error == '404')
                    {
                        alert("Invalid Username or Password!");
                    }
                    
                    if(error == '2006')
                    {
                        alert("Blank Membership ID!");
                    }

                    if(error == '2020')
                    {
                        alert("Blank Transaction Amount!");
                    }

                    if(error == '2049')
                    {
                        alert("Invalid Loyalty Program Id!");
                    }

                    if(error == '1001')
                    {
                        $("#Loyalty_program_name").val(json['Loyalty_program']);
                        $("#Converted_Points").val(json['Points']);

                        alert("Transaction Amount Converted Successfully.");
                    }
                }
            });            
        }
        
        function Show_transaction_report()
        {
            $("#Show_transaction_report").css("display","");
        }
        
        function get_transaction_report() 
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "oU3aRZ6XLPO07rDQBc1SLpUnWSWcfgIGNr1YUX+1pyA="; //41
            
            var cashier_username = $('#cashier_username2').val(); //qEem0Muw9HUekynHiKrOrppsW/jDVLc6ezbGtb3VoS4=
            var cashier_password = $('#cashier_password2').val(); //O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=
            
            var Start_limit = $('#Trans_Start_limit').val();
            var End_limit = $('#Trans_End_limit').val();
            
            var Membership_id = "/kJ8LBiCT/JVfjaMza4YD1ChvCZhI7qwZgc0Lams1xY=";
            var Transaction_flag = '2';
           
            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password,API_flag:API_flag,Username:cashier_username,Password:cashier_password,
                            Start_limit:Start_limit, End_limit:End_limit, Membership_id:Membership_id, Transaction_flag:Transaction_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];

                        if(error == '2001')
                        {
                            alert("Invalid Company Username!");
                        }

                        if(error == '2005')
                        {
                            alert("Invalid Username or Password!");
                        }

                        if(error == '2002')
                        {
                            alert("Invalid Company Password!");
                        }

                        if(error == '404')
                        {
                            alert("Blank Company User Name or Company Password!");
                        }

                        if(error == '1001')
                        {
                            var getVals = json['Transactions']; 
                            var tblvals = "";
							
                            $.each(getVals, function(key,value)
                            {
								tblvals = "<tr><td>"+value['Transaction_type_id']+"</td>";
								tblvals += "<td>"+value['Transaction_type_name']+"</td>";
								tblvals += "<td>"+value['Transaction_date']+"</td>"; 
                                tblvals += "<td>"+value['Member_name']+"</td>";
                                tblvals += "<td>"+value['Membership_id']+"</td>";
                                tblvals += "<td>"+value['Branch_name']+"</td>";
                                tblvals += "<td>"+value['Branch_user_name']+"</td>";
                                tblvals += "<td>"+value['Bill_no']+"</td>";
                                tblvals += "<td>"+value['Transaction_amount']+"</td>";
                                tblvals += "<td>"+value['Expired_points']+"</td>";
                                tblvals += "<td>"+value['Redeem_points']+"</td>";
                                tblvals += "<td>"+value['Bonus_points']+"</td>";
                                tblvals += "<td>"+value['Item_name']+"</td>";
                                tblvals += "<td>"+value['Quantity']+"</td>";
                                tblvals += "<td>"+value['Remarks']+"</td></tr>";

                                $("#transaction_report_table > tbody:last-child").append(tblvals);
                            });
                        }
                    }
            });            
        }
        
        function Show_product_details()
        {
            $("#Show_product_details").css("display","");
        }
        
        function get_products_details() 
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "F26SQl1QcZT8F/tGhfLUe91lmJeN8l0FYMdQMLt9KoI="; //42
            
            
            var cashier_username = $('#cashier_username3').val(); //qEem0Muw9HUekynHiKrOrppsW/jDVLc6ezbGtb3VoS4=
            var cashier_password = $('#cashier_password3').val(); //O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=
            var Inv_branch_code = $('#Inv_branch_code').val();
            
            var Start_limit = $('#Prod_Start_limit').val();
            var End_limit = $('#Prod_End_limit').val();
           
            $.ajax
            ({
                type: "POST",
                data:{ Company_username:Company_username, Company_password:Company_password,API_flag:API_flag,Username:cashier_username,Password:cashier_password,
                        Start_limit:Start_limit, End_limit:End_limit, Branch_code:Inv_branch_code},
                url: API_URL,
                dataType: "json", 
                success: function(json)
                {
                    var error = json['status'];

                    if(error == '2001')
                    {
                        alert("Invalid Company Username!");
                    }

                    if(error == '2002')
                    {
                        alert("Invalid Company Password!");
                    }

                    if(error == '2012')
                    {
                        alert("No Data Found!");
                    }	
                    
                    if(error == '404')
                    {
                        alert("Blank Company User Name or Company Password!");
                    }

                    if(error == '1001')
                    {
                        var getVals2 = json['Products']; 
                        var tblvals2 = "";  var HTML1 = ""; var HTML2 = "";

                        $.each(getVals2, function(key,value)
                        {
                            tblvals2 = "<tr><td>"+value['item_code']+"</td>";
                            tblvals2 += "<td>"+value['Item_name']+"</td>";
                            tblvals2 += "<td>"+value['Item_price']+"</td>";
                            tblvals2 += "<td>"+value['total_cost']+"</td></tr>";

                            $("#product_details_table > tbody:last-child").append(tblvals2);
                        });
                    }
                }
            });            
        }
        
        function Fetch_payment_methods()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
            var API_flag = "S/VOFF4CuyRWjcsksCaUoFM/a0PUdp/+2qoOjsmSOlo=";

            $.ajax
            ({
                    type: "POST",
                    data:{ Company_username:Company_username, Company_password:Company_password, API_flag:API_flag},
                    url: API_URL,
                    dataType: "json", 
                    success: function(json)
                    {
                        var error = json['status'];
                        if(error == '2001')
                        {
                                alert("Invalid Company Username!");
                        }

                        if(error == '2002')
                        {
                                alert("Invalid Company Password!");
                        }

                        if(error == '2012')
                        {
                            alert("No Payment Methods Found!");
                        }

                        if(error == '1001')
                        {
                            $("#Payment_div").css("display","");
                            var Payment_type_details = json['Payment_type_details'];
                            $.each(Payment_type_details, function(key,value)
                            {
                                $('#Payment_methods').append($('<option>', {
                                    value: value['Payment_type_id'],
                                    text: value['Payment_type_name']
                                }));
                            });
                        }
                    }
            });
        }
        
        function Show_menu()
        {
            $("#Show_loyalty_transaction").css("display","");
        }
        
        function do_transaction()
        {
            var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
           var API_flag = "7a2cPwSJrdKnhBCLR5ZKC8ynYXhGgUyqouG+UWlWCQQ="; //43
		   
		  // var API_flag = "Tna2zq0lCX3dCcYvfMCSFDKY2wo8gYULrz1a9Cz4dgs=";
            var cashier_username = $('#cashier_username4').val(); //qEem0Muw9HUekynHiKrOrppsW/jDVLc6ezbGtb3VoS4=
            var cashier_password = $('#cashier_password4').val(); //O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=
            var transaction_flag = $('#transaction_flag').val(); 
            var membershipid = $('#membershipid4').val(); //1112000155 - TkhV3mxLWyB7k+JH4p+7FldX0zq2HvT8r3XVhW5AqJ4=
            var redeem_points = $('#redeem_points').val(); //Fpcdh/+8ZqSw+qPgVksPo/1xYk0QoNrNnF6GwtjkSqY=
            var branch_code = $('#branch_code').val(); //McBRCD002 = 20KzivAByeTz5rdrluUDAXSbzjozQOosc5J95n4RQZw=
            var payment_type_id = $('#payment_type').val(); 
            var Remark = $('#Remarkis').val(); 
            var Amount_collected = $('#Amount_collected').val(); 
            var GiftCardPurchase_Flag = $('#GiftPurchase_Flag').val(); 			
            var Purchase_GiftCardArray = new Array();			
            Purchase_GiftCardArray.push($('#Purchase_GiftCard1').val()); 
            Purchase_GiftCardArray.push($('#Purchase_GiftCard2').val()); 
           
            var GiftCardFlag = $('#GiftCardFlag').val(); 
            var GiftCard_no = $('#GiftCard_no').val();  // dKe+vTv57wE2G3bYathojjmXrPoLpBUS6D19WLkvyYo=
            var GiftCardRedeem_amt = $('#GiftCardRedeem_amt').val(); //100 = Mt7uQINi3jdPKC5gcWdTUoWQqK+H+4QI7CjRFhdjPAo=
            var BranchUser_Pin = $('#BranchUser_Pin').val(); //1515- y+EvSNlOCzRZtN5BVnvJO25aDeCk6RVFPW+APZW3XSI=
            var voucher_cheque_no = $('#voucher_cheque_no').val(); 
            var items_array = new Array();
            var quantity_array = new Array();
            var product_details = new Array();
	
            var item_1 = $('#item_1').val();  //Mac-MinuteMaid
            var quantity_1 = $('#quantity_1').val();
            var price_1 = $('#price_1').val();

            var item_2 = $('#item_2').val(); //Mac Finger-01
            var quantity_2 = $('#quantity_2').val();
            var price_2 = $('#price_2').val();

            var item_3 = $('#item_3').val(); 
            var quantity_3 = $('#quantity_3').val();
			
            $.ajax
            ({
                type: "POST",
                data:{ Company_username:Company_username, Company_password:Company_password,API_flag:API_flag,Username:cashier_username,Password:cashier_password,Transaction_flag:transaction_flag,Membership_id:membershipid,Redeem_points:redeem_points,Branch_code:branch_code,item_1:item_1,item_2:item_2,item_3:item_3,quantity_1:quantity_1,quantity_2:quantity_2,quantity_3:quantity_3,price_1:price_1,price_2:price_2,PaymentBy:payment_type_id,GiftCardPurchase_Flag:GiftCardPurchase_Flag,Purchase_GiftCardArray:Purchase_GiftCardArray,GiftCardRedeemFlag:GiftCardFlag,GiftCard_no:GiftCard_no,GiftCardRedeem_amt:GiftCardRedeem_amt,BranchUser_Pin:BranchUser_Pin,Voucher_cheque_no:voucher_cheque_no,Remark:Remark,Amount_collected:Amount_collected},
                url: API_URL,
                dataType: "json", 
                success: function(json)
                {
                    var error = json['status'];
                    if(error == '2001')
                    {
                        alert("Invalid Company Username!");
                    }

                    if(error == '2002')
                    {
                        alert("Invalid Company Password!");
                    }

                    if(error == '2012')
                    {
                        alert("No Data Found!");
                    }	
                    
                    if(error == '404')
                    {
                        alert("Blank Company User Name or Company Password!");
                    }

                    if(error == '1001')
                    {
                        var getVals = json['Transactions']; 
                        var tblvals = "";
                        alert(getVals);
                    }
                }
            });            
        }
</script>

<script type="text/javascript">

	function Show_flatfile_menu()
	{
		$("#Show_flatfile_loyalty_transaction").css("display","");
	}
		
	function do_flatfile_transaction()
	{
			var Company_username = "diamondbank1234";
            var Company_password = "s/qnMwJe93uGXuZPZkOiWLG0l7qC3kbVaRz7d8zjTgw=";
			var API_flag = "Tna2zq0lCX3dCcYvfMCSFDKY2wo8gYULrz1a9Cz4dgs="; //51
            var cashier_username = $('#cashier_username42').val(); //qEem0Muw9HUekynHiKrOrppsW/jDVLc6ezbGtb3VoS4=
            var cashier_password = $('#cashier_password42').val(); //O0MySyBq0Bb6ptchWYUZX8AaE6wcq6A8AM9/Q2UGuwU=
            var transaction_flag = $('#transaction_flag2').val(); 
            var membershipid = $('#membershipid42').val(); //1112000155 - TkhV3mxLWyB7k+JH4p+7FldX0zq2HvT8r3XVhW5AqJ4=
          // alert(transaction_flag);
            var branch_code = $('#branch_code2').val(); //McBRCD002 = 20KzivAByeTz5rdrluUDAXSbzjozQOosc5J95n4RQZw=
            
            var Remark = $('#Remarkis2').val(); 
            var Bill_no = $('#Bill_no2').val(); 
            var transaction_Type = $('#transaction_Type2').val(); 
            var Transaction_channel = $('#Transaction_channel_code2').val(); 
            
            var BranchUser_Pin = $('#BranchUser_Pin2').val(); //1515- y+EvSNlOCzRZtN5BVnvJO25aDeCk6RVFPW+APZW3XSI=
           
            var items_array = new Array();
            var quantity_array = new Array();
            var product_details = new Array();
	
            var item_1 = $('#item2_1').val();  //Mac-MinuteMaid
            var quantity_1 = $('#quantity2_1').val();
            var price_1 = $('#price2_1').val();

            var item_2 = $('#item2_2').val(); //Mac Finger-01
            var quantity_2 = $('#quantity2_2').val();
            var price_2 = $('#price2_2').val();
			 
            $.ajax
            ({
                type: "POST",
                data:{ Company_username:Company_username, Company_password:Company_password,API_flag:API_flag,Username:cashier_username,Password:cashier_password,
						Transaction_flag:transaction_flag,Membership_id:membershipid,
						Branch_code:branch_code,item_1:item_1,item_2:item_2,item_3:item_3,quantity_1:quantity_1,quantity_2:quantity_2,
						quantity_3:quantity_3,price_1:price_1,price_2:price_2,BranchUser_Pin:BranchUser_Pin,Remark:Remark,Bill_no:Bill_no,
						Company_transaction_Type:transaction_Type,Transaction_channel_code:Transaction_channel},
                url: API_URL,
                dataType: "json", 
                success: function(json)
                {
                    var error = json['status'];
                    if(error == '2001')
                    {
                        alert("Invalid Company Username!");
                    }

                    if(error == '2002')
                    {
                        alert("Invalid Company Password!");
                    }

                    if(error == '2012')
                    {
                        alert("No Data Found!");
                    }	
                    
                    if(error == '404')
                    {
                        alert("Blank Company User Name or Company Password!");
                    }

                }
            }); 
	}	
	
	
$(function()
{  
    $( "#From_date" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
    
    $( "#Till_date" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
    
    $( "#Enroll_From_date" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
    
    $( "#Enroll_Till_date" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
	
});
</script>