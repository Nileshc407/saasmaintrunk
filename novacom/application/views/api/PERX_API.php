<?php
/**************************************************************************************		
Name of File 		: PERX_API.php 
Date of Creation	: 08-06-2016
Created By			: Akshay Mule
Purpose Of File		: This is API called from outside application
Update File History	:  
Change date			:				 		
****************************************************************************************/

require_once("lsl_db.php");
require_once("connect_db.php");
//require_once("API_functions.php");
require_once("includes/functions.php");
error_reporting(E_ERROR |E_PARSE|E_CORE_ERROR);

$API_Company_username = $_REQUEST['Company_username'];
$API_Company_password = $_REQUEST['Company_password'];
$API_flag = $_REQUEST['API_flag']; 
$iv = '56666852251557009888889955123458';

if($API_Company_username == "" || $API_Company_password == "" || $API_flag == "")
{
    echo json_encode(array("status" => "404", "status_message" => "Missing Company Username Information"));
}
else
{
    $SQL1 = "SELECT * FROM lsl_company_master
             WHERE Company_username='".$API_Company_username."'
             AND Active_flag=1";
			 
	//echo "company sql--".$SQL1."<br>";	
	
    $Result1 = mysqli_query($conn,$SQL1);
    $Company_check = mysqli_num_rows($Result1);

    if($Company_check > 0)
    {
            $Company_details = mysqli_fetch_array($Result1);
            $Company_id = $Company_details['Company_id'];
            $Company_encryptionkey = $Company_details['Company_encryptionkey'];
            $DB_Company_password = $Company_details['Company_password'];
            $Company_Solution_type = $Company_details['Solution_type'];
            $key = $Company_encryptionkey;	
			//echo "DB_Company_password sql--".$DB_Company_password."<br>";
			//echo "DB_Company_password --".$_REQUEST['Company_password']."<br>";

            $Decrypt_Company_password = string_decrypt($_REQUEST['Company_password'], $key, $iv);	
            $Decrypt_Company_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Decrypt_Company_password);
	
			//echo "DB_Company_password sql--".$Decrypt_Company_password."<br>";
	
            $Password_match = strcmp($DB_Company_password,$Decrypt_Company_password);

            if($Password_match == 0)
            {
					$API_flag2 = string_decrypt($_REQUEST['API_flag'], $key, $iv);
					$API_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $API_flag2);
                   
				//echo "API_flag sql--".$API_flag."<br>";
                    /************************************Home API********************************/
                    if($API_flag == 6)
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            if($member_details == NULL)
                            {
                                $member_details = array("status" => "2003");
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    $member_details = array("status" => "2004");
                                }
                                else
                                {
                                    $tier_details_result = lslDB::getInstance()->get_tier($member_details['Tier_id']);
                                    $tier_details = mysqli_fetch_array($tier_details_result);
                            
                                    $query1="SELECT * FROM lsl_user_notification_master
                                             WHERE Company_id=".$Company_id."
                                             AND User_email_id='".$member_details['User_email_id']."'
                                             AND Membership_id='".$member_details['Membership_id']."'
                                             AND Disable_flag='0'
                                             AND Note_open='0' ";
                                    $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));

                                     $member_details = array(
                                                            "status" => "1001",
                                                            "First_name" => $member_details['First_name'],
                                                            "Last_name" => $member_details['Last_name'],
                                                            "Tier_name" => $tier_details['Tier_name'],
                                                            "Membership_id" => $member_details['Membership_id'],
                                                            "Current_balance" => $member_details['Current_balance'],
                                                            "Total_unread_notifications" => $Total_unread_notifications
                                                        );
                                }
                                echo json_encode($member_details);
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006"));
                        }
                    }
                    /************************************Home API********************************/

                    /************************************Profile********************************/
                    if($API_flag == 1)  //***Retrive the profile details of customer
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                    echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == "0")
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $query1 = lslDB::getInstance()->get_tier($member_details['Tier_id']);
                                    $tier_details = mysqli_fetch_array($query1);

                                    $query2 = lslDB::getInstance()->get_Country($member_details['Country_id']);
                                    $Country_details = mysqli_fetch_array($query2);

                                    $query3 = lslDB::getInstance()->get_State($member_details['State_id']);
                                    $State_details = mysqli_fetch_array($query3);

                                    $query4 ="SELECT City_name FROM lsl_city_master WHERE City_id='".$member_details['City_id']."' ";
                                    $City_details = mysqli_fetch_array(mysqli_query($conn, $query4));

                                    $query5 ="SELECT Region_name FROM lsl_region_master WHERE Region_id='".$member_details['Region_id']."' ";
                                    $Region_details = mysqli_fetch_array(mysqli_query($conn, $query5));

                                    $query6 ="SELECT Zone_name FROM lsl_zone_master WHERE Zone_id='".$member_details['Zone_id']."' ";
                                    $Zone_details = mysqli_fetch_array(mysqli_query($conn, $query6));
                                    
                                    if($member_details['Photograph'] == "" || $member_details['Photograph'] == NULL)
                                    {
                                        $Photograph = "https://demo.perxclm2.com/images/no_image.jpeg";
                                    }
                                    else
                                    {
                                        $Photograph = "https://demo.perxclm2.com/".$member_details['Photograph'];
                                    }

                                    $member_details = array(
                                                            "status" => "1001",
                                                            "First_name" => string_encrypt($member_details['First_name'],$key, $iv),
                                                            "Middle_name" => string_encrypt($member_details['Middle_name'],$key, $iv),
                                                            "Last_name" => string_encrypt($member_details['Last_name'],$key, $iv),
                                                            "Current_address" => string_encrypt($member_details['Current_address'],$key, $iv),
                                                            "Zipcode" => string_encrypt($member_details['Zipcode'],$key, $iv),
                                                            "Country_name" => $Country_details['Country_name'],
                                                            "Region_name" => $Region_details['Region_name'],
                                                            "Zone_name" => $Zone_details['Zone_name'],
                                                            "State_name" => $State_details['State_name'],
                                                            "City_name" => $City_details['City_name'],
                                                            "Country_id" => $member_details['Country_id'],
                                                            "State_id" => $member_details['State_id'],
                                                            "City_id" => $member_details['City_id'],
                                                            "Photograph" => $Photograph,
                                                            "Phone_no" => string_encrypt($member_details['Phone_no'],$key, $iv),
                                                            "Date_of_birth" => string_encrypt($member_details['Date_of_birth'],$key, $iv),
                                                            "Age" => string_encrypt($member_details['Age'],$key, $iv),
                                                            "Sex" => string_encrypt($member_details['Sex'],$key, $iv),
                                                            "User_email_id" => string_encrypt($member_details['User_email_id'],$key, $iv),
                                                            "Current_balance" => string_encrypt($member_details['Current_balance'],$key, $iv),
                                                            "Total_purchase_amount" => string_encrypt($member_details['Total_purchase_amount'],$key, $iv),
                                                            "Total_bonus_points" => string_encrypt($member_details['Total_bonus_points'],$key, $iv),
                                                            "Total_gained_points" => string_encrypt($member_details['Total_gained_points'],$key, $iv),
                                                            "Tier_name" => string_encrypt($tier_details['Tier_name'],$key, $iv),
                                                            "Blocked_points" => string_encrypt($member_details['Blocked_points'],$key, $iv),
                                                            "Membership_validity" => string_encrypt($member_details['Membership_validity'],$key, $iv),
                                                            "Enroll_date" => string_encrypt($member_details['Enroll_date'],$key, $iv),
                                                            "status_message" => "Success"
                                                        );
                                }				
                            }
                            echo json_encode($member_details);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    /************************************Profile********************************/

                    /************************************Login********************************/
                    if($API_flag == 2)  //***login and return customer details
                    {
                        if($_REQUEST['Membership_id'] == "" || $_REQUEST['Cust_password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            
                            $Cust_password = trim(string_decrypt($_REQUEST['Cust_password'], $key, $iv));
                            $Cust_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Cust_password);
                            
                            $login_sql = "SELECT * FROM lsl_enrollment_master WHERE Membership_id='".$Membership_id."' "
                                       . "AND Password='".$Cust_password."' "
                                       . "AND Company_id='".$Company_id."'"
                                       . "AND User_type_id=1";
                            $member_details_result = mysqli_query($conn,$login_sql);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $query1 = lslDB::getInstance()->get_tier($member_details['Tier_id']);
                                    $tier_details = mysqli_fetch_array($query1);
                                    
                                    $query1="SELECT * FROM lsl_user_notification_master
                                             WHERE Company_id=".$Company_id."
                                             AND User_email_id='".$member_details['User_email_id']."'
                                             AND Membership_id='".$member_details['Membership_id']."'
                                             AND Disable_flag='0'
                                             AND Note_open='0' ";
                                    $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));

                                    $member_details = array(
                                                            "status" => "1001",
                                                            "Tier_name" => string_encrypt($tier_details['Tier_name'],$key, $iv),
                                                            "Membership_id" => string_encrypt($member_details['Membership_id'],$key, $iv),
                                                            "Current_balance" => string_encrypt($member_details['Current_balance'],$key, $iv),
                                                            "Total_unread_notifications" => $Total_unread_notifications,
                                                            "status_message" => "Success"
                                                        );
                                }
                                echo json_encode($member_details);
                            }
                        }
                    }
                    /************************************Login********************************/
                    
                    /************************************Forgot Password********************************/
                    if($API_flag == 3)  //***forgot password
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);

                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);                            
                            $Communication_flag   = $member_details['Communication_flag'];
                            $Communication_type   = $member_details['Communication_type'];

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Communication_flag == 1 && ($Communication_type == 1 || $Communication_type == 2 || $Communication_type == 3) )
                                    {
                                        //$send_forgetpass = lslDB::getInstance()->forgetpass($User_email_id,$Company_id);  
                                        
                                        $newpassword = rand(1000000,9999999);                                        
                                        $sql ="UPDATE lsl_enrollment_master SET Password='".$newpassword."' WHERE Membership_id='".$Membership_id."' AND Enrollment_id='".$member_details['Enrollment_id']."' AND Company_id='".$Company_id."' ";
                                        $result = mysqli_query($conn,$sql);
                                                       
                                        $Template_type_id = 27;     $Email_Type = 23;
                                        $customer_info_template = lslDB::getInstance()->send_customer_info_template($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$newpassword,$Email_Type,$Template_type_id);
                                        
                                        echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2019", "status_message" => "Email Communication is Disabled"));
                                    }
                                }
                            }
                        }
                    }
                    /************************************Forgot Password********************************/
                    
                    /************************************Change Password********************************/
                    if($API_flag == 4)  //***change password
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else if($_REQUEST['Old_password'] == "" || $_REQUEST['New_password'] == "")
                        {
                            echo json_encode(array("status" => "2010", "status_message" => "Kindly Enter Password"));
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $Old_password = trim(string_decrypt($_REQUEST['Old_password'], $key, $iv));
                            $Old_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Old_password);
                            
                            $New_password = trim(string_decrypt($_REQUEST['New_password'], $key, $iv));
                            $New_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $New_password);

                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            $password_expired_date = $Company_details['Cust_password_expiry_period'];
                            $password_date = date("Y-m-d", strtotime("+".$password_expired_date."days"));

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2011", "status_message" => "Passwords Do Not Match"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else if($member_details['Password'] != $Old_password)
                                {
                                    echo json_encode(array("status" => "2011", "status_message" => "Passwords Do Not Match"));
                                }
                                else
                                {
                                    //$send_forgetpass = lslDB::getInstance()->changepassword($member_details['User_email_id'],$Old_password,$New_password,$member_details['Enrollment_id']);
                            
                                    $Update_query ="UPDATE lsl_enrollment_master SET Password='".$New_password."',Password_expiry_date='".$password_date."' WHERE Membership_id='".$Membership_id."' AND Password='".$oldpass."' AND Enrollment_id='".$member_details['Enrollment_id']."' AND Company_id='".$Company_id."' ";
                                    $result = mysqli_query($conn,$Update_query);
                                    
                                    /*----------------------------------------------------------Password Change Email Template---------------------------------------------------*/
                                        $html = "<div class='EmailTemplate' style='padding: 10px;font-size: 12px;font-family: Roboto,sans-serif;background: none repeat scroll 0 0 #FFFFFF;width: 80%;color: #191919;'>";
                                        $html .= "<p>";
                                        $html .= "Dear <strong>".$member_details['First_name']." ".$member_details['Last_name']."</strong>, <br /><br />";
                                        $html .= "Your Password is changed. Your new Password is -&nbsp;<strong>".$New_password."</strong>.";
                                        $html .= "<br /><br />Please login&nbsp;<strong>".$Company_details['Website']."</strong> to check your details.";
                                        $html .= "</p>";
                                        $html .= "</div>";

                                        $subject = "About your Password Change";

                                        $Transaction_date=date("Y-m-d");
                                        $Notification_type=16; // Custom Communication in lsl_transaction_type_master
                                        $html_new = str_replace("'",'"',$html);	
                                        $send_notification_to_user = lslDB::getInstance()->send_notification_to_user($Company_id,"",$Membership_id,$html_new,$Notification_type,$member_details['Enrollment_id'],$Transaction_date,'');
                                    /*----------------------------------------------------------Password Change Email Template---------------------------------------------------*/
                                        
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Change Password********************************/
                    
                    /************************************Notifications********************************/
                    if($API_flag == 5)  //***Retrieve All notifications
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $query1 ="SELECT * FROM lsl_enrollment_master "
                                    . "WHERE Company_id='".$Company_id."'"
                                    . "AND Active_flag='1'"
                                    . "AND Membership_id='".$Membership_id."' ";
                            $member_details = mysqli_fetch_array(mysqli_query($conn, $query1));
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == "0")
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Start_limit = trim($_REQUEST['Start_limit']);
                                    $End_limit = trim($_REQUEST['End_limit']);
                                    $LIMIT = "";
                                    
                                    if($Start_limit == "" && $Start_limit == NULL && $End_limit == "" && $End_limit == NULL)
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( $Start_limit != "" && $End_limit == "" )
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( ($Start_limit == "" || $Start_limit == NULL) && $End_limit != "" )
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit > $End_limit)
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit != "" && $End_limit != "")
                                    {
                                        $LIMIT = "LIMIT ".$Start_limit.",".$End_limit." ";
                                    }                                    
                                    
                                    $query2 = "SELECT * FROM lsl_user_notification_master,lsl_transaction_type_master where 
                                                lsl_user_notification_master.Notification_type= lsl_transaction_type_master.Transaction_type_id AND
                                                lsl_user_notification_master.Company_id=".$Company_id." AND
                                                lsl_user_notification_master.Disable_flag='0' AND
                                                lsl_user_notification_master.Membership_id='".$Membership_id."'
                                                ORDER BY lsl_user_notification_master.User_notification_id DESC
                                                ".$LIMIT."";
                                    $lv_result2 = mysqli_query($conn,$query2);
                                    while($rows2 = mysqli_fetch_array($lv_result2))
                                    {
                                        if($rows2["Note_open"] == 1)
                                        {
                                            $Note_open_status = '<img src="images/envelope-opened1.png">';
                                        }
                                        else
                                        {
                                            $Note_open_status = '<img src="images/envelope-closed1.png">';
                                        }
                                        
                                        $Notification_details[] = array(
                                            "User_notification_id" => $rows2["User_notification_id"],
                                            "Creation_date" => date("F j, Y",strtotime($rows2["Creation_date"])),
                                            "Transaction_type_name" => $rows2["Transaction_type_name"],
                                            "Reference_no" => $rows2["Reference_no"],
                                            "Note_open" => $rows2["Note_open"],
                                            //"Note_open_status" => $Note_open_status,
                                            "Contents" => $rows2["Contents"]
                                        );
                                    }
                                    
                                    $Status_array = array("status" => "1001", "Notification_details" => $Notification_details, "status_message" => "Success");
                                    echo json_encode($Status_array);
                                }
                            }
                        }
                    }
                    
                    if($API_flag == 7)  //***get singel notification details
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => ""));die;
                            }
                            else
                            {
                                if($member_details['Active_flag'] == "0")
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID not found"));die;
                                }
                                else if($_REQUEST['User_notification_id'] == "")
                                {
                                    echo json_encode(array("status" => "2056", "status_message" => "Notification ID id empty"));die;
                                }
                                else
                                {
                                    $query2 = lslDB::getInstance()->get_cust_notifications_single($_REQUEST['User_notification_id']);                                    
                                    $notification_details = mysqli_fetch_array($query2);
                                    
                                    if($notification_details != NULL)
                                    {
                                        $query1="SELECT * FROM lsl_user_notification_master
                                                 WHERE Company_id=".$Company_id."
                                                 AND User_email_id='".$member_details['User_email_id']."'
                                                 AND Membership_id='".$member_details['Membership_id']."'
                                                 AND Disable_flag='0'
                                                 AND Note_open='0' ";
                                        $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));

                                        $New_Membership_id = trim(string_encrypt($Membership_id, $key, $iv));
                                        $Contents = $notification_details['Contents'];
                                        $urls = getUrls($notification_details['Contents']);
                                        foreach($urls as $url)
                                        {
                                            $mystring = $url;
                                            $findme   = 'https://demo.perxclm2.com/share_notification.php';
                                            //$findme = 'http://localhost/LSL_LBS/share_notification.php';
                                            $pos = strpos($mystring, $findme);

                                            if ($pos !== false)
                                            {
                                                $Share_url = $url;
                                                $url = str_replace($findme.'?',"",$url);
                                                parse_str($url);
                                                $URL_title = $Title;
                                                $URL_content = $Content;
                                                $URL_social_icon_flag = $Social_icon_flag;
                                                $URL_image_path = $Image_path;
                                                $URL_invite_flag = $Invite_flag;

                                                //urlencode($URL_title)
                                                $findme2 = 'insert_share_details('.$Company_id.','.$member_details["Enrollment_id"].','.$URL_social_icon_flag.');';
                                                $replace = "Share_notification('".($URL_title)."','".($URL_content)."','".($URL_image_path)."','".$URL_social_icon_flag."','".$New_Membership_id."','".$User_notification_id."','".$URL_invite_flag."')";
                                                $Contents = str_replace($findme2,$replace,$Contents);

                                                $findme4 = 'target="_blank"';
                                                $Contents = str_replace($findme4,"",$Contents);

                                                $findme3 = 'href="'.$Share_url.'"';
                                                $replace2 = "href='javascript:void(0);'";
                                                $Contents = str_replace($findme3,$replace2,$Contents);
                                            }
                                        }
                                        
                                        /*$User_notification_id = $_REQUEST['User_notification_id'];
                                        $query1 = "UPDATE lsl_user_notification_master SET Note_open='1' WHERE User_notification_id=".$User_notification_id;
                                        $update_notification_status = mysqli_query($conn,$query1);*/
                                        
                                        $Notification_array = array("status" => "1001", "Contents" => $Contents, "Total_unread_notifications" => $Total_unread_notifications, "User_notification_id" => $notification_details['User_notification_id'], "status_message" => "Success");
                                        echo json_encode($Notification_array);die;
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
                                    }
                                }				
                            }                            
                        }
                    }
                    
                    if($API_flag == 8)  //***delete notification details
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $User_notification_id = $_REQUEST['User_notification_id'];
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $query2 = lslDB::getInstance()->get_cust_notifications_single($User_notification_id);                                    
                            $notification_details = mysqli_fetch_array($query2);
                                
                            if($notification_details != NULL)
                            {
                                $query1 ="SELECT * FROM lsl_enrollment_master "
                                        . "WHERE Company_id='".$Company_id."'"
                                        . "AND Active_flag='1'"
                                        . "AND Membership_id='".$Membership_id."' ";
                                $member_details = mysqli_fetch_array(mysqli_query($conn, $query1));

                                if($member_details == NULL)
                                {
                                    echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                                }
                                else if($_REQUEST['User_notification_id'] == "" || $_REQUEST['User_notification_id'] == 0 || $_REQUEST['User_notification_id'] == NULL)
                                {
                                    echo json_encode(array("status" => "2056", "status_message" => "Notification ID id empty"));die;
                                }
                                else
                                {
                                    $query2 ="UPDATE lsl_user_notification_master SET Disable_flag='1'"
                                          . "WHERE User_notification_id='".$User_notification_id."'"
                                          . "AND Membership_id='".$Membership_id."' ";
                                    $Delete_user_notification = mysqli_query($conn, $query2);
                                    $Delete_user_notification = lslDB::getInstance()->delete_user_notification($User_notification_id);
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                            else
                            {
                                echo json_encode(array("status" => "2086", "status_message" => "Invalid Notification Id"));die;
                            }
                        }
                    }
                    /************************************Notifications********************************/
                    
                    /************************************Acution Bidding********************************/
                    if($API_flag == 9)  //***get all Auction List
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Today_date = date("Y-m-d");
                            $current_time = date("H:i:s");
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Start_limit = trim($_REQUEST['Start_limit']);
                                    $End_limit = trim($_REQUEST['End_limit']);
                                    $LIMIT = "";
                                    
                                    if($Start_limit == "" && $Start_limit == NULL && $End_limit == "" && $End_limit == NULL)
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( $Start_limit != "" && $End_limit == "" )
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( ($Start_limit == "" || $Start_limit == NULL) && $End_limit != "" )
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit > $End_limit)
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit != "" && $End_limit != "")
                                    {
                                        $LIMIT = "LIMIT ".$Start_limit.",".$End_limit." ";
                                    }
                                    
                                    $query1="SELECT * FROM lsl_auction_master
                                             WHERE Company_id=".$Company_id."
                                             AND To_date>='".$Today_date."'
                                             AND Active_flag=1
                                             ORDER BY Auction_id ASC
                                             ".$LIMIT." ";    //AND End_time>='".$current_time."'
                                    $result1 = mysqli_query($conn,$query1);
                                    $auction_num = mysqli_num_rows($result1);
                                    
                                    if($auction_num > 0)
                                    {
                                        $Highest_bid_flag = 0;
                                        while($Auction = mysqli_fetch_array($result1))
                                        {
                                            $Min_bid_value = $Auction['Min_bid_value'] + $Auction['Min_increment'];
                                            
                                            $query2 = "SELECT MAX(Bid_value) FROM lsl_auction_winner WHERE Company_id='".$Company_id."' AND Auction_id='".$Auction['Auction_id']."' ";
                                            $result2 = mysqli_fetch_array(mysqli_query($conn,$query2));
                                            
                                            $query3 = "SELECT COUNT(*) FROM lsl_auction_winner WHERE Company_id='".$Company_id."' AND Bid_value='".$result2['MAX(Bid_value)']."' AND Enrollment_id='".$member_details['Enrollment_id']."' AND Auction_id='".$Auction['Auction_id']."' ";
                                            $result3 = mysqli_fetch_array(mysqli_query($conn,$query3));
                                            
                                            $query4 = "SELECT * FROM lsl_auction_winner 
                                                       WHERE Company_id='".$Company_id."'
                                                       AND Auction_id='".$Auction['Auction_id']."' 
                                                       AND Bid_value < '".$result2['MAX(Bid_value)']."' 
                                                       ORDER BY Bid_value DESC LIMIT 0,1";
                                            $result4 = mysqli_fetch_array(mysqli_query($conn,$query4));
                                            
                                            $query5 = "SELECT COUNT(*) FROM lsl_auction_winner WHERE Company_id='".$Company_id."' AND Auction_id='".$Auction['Auction_id']."' ";
                                            $result5 = mysqli_fetch_array(mysqli_query($conn,$query5));
                                            
                                            if($result3['COUNT(*)'] > 0)
                                            {
                                                $Highest_bid_flag = 1;  //Highest Bidder
                                            }
                                            else if($result4['Enrollment_id'] == $member_details['Enrollment_id'])
                                            {
                                                $Highest_bid_flag = 2;  //no longer the Highest Bidder
                                            }
                                            else if($result5['COUNT(*)'] == 0)
                                            {
                                                $Highest_bid_flag = 0;  //no Bid for Auction
                                            }
                                            else
                                            {
                                                $Highest_bid_flag = 2;
                                            }
                                            
                                            $Min_bid_value = $Auction['Min_bid_value'] + $Auction['Min_increment'];
                                            $Auction_details[] = array(
                                                                "Auction_id" => $Auction['Auction_id'],
                                                                "Prize_image" => "https://demo.perxclm2.com/".$Auction['Prize_image'],//"https://demo.perxclm2.com/".
                                                                "Auction_name" => $Auction['Auction_name'],
                                                                "Start_date" => $Auction['From_date'],
                                                                "End_date" => $Auction['To_date'],
                                                                "End_time" => $Auction['End_time'],
                                                                "Prize" => $Auction['Prize'],
                                                                "Prize_description" => $Auction['Prize_description'],
                                                                //"Min_bid_value" => $Auction['Min_bid_value'],
                                                                "Min_bid_value" => $Min_bid_value,
                                                                "Min_increment" => $Auction['Min_increment'],
                                                                "Highest_bid_flag" => $Highest_bid_flag
                                                            );
                                        }
                                        /*$Status_array = array("status" => "1001");
                                        $Auction_details = array_merge($Auction_details,$Status_array);*/
                                        
                                        $Status_array = array("status" => "1001", "Auction_details" => $Auction_details, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 10)  //***Bid for Auction
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];                            
                            $Communication_flag = $member_details['Communication_flag'];
                            $Communication_type = $member_details['Communication_type'];
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access=1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                            
                            /*******Get Time Zone*******/
							$lv_timezonequery = "SELECT Timezone FROM lsl_company_master WHERE Company_id=".$Company_id;
							$mv_result_timezonequery = mysqli_query($conn,$lv_timezonequery);			
							$mv_row_timezonequery=mysqli_fetch_assoc($mv_result_timezonequery);
							$mv_date=date("Y-m-d");
							$timezone = new DateTimeZone($mv_row_timezonequery["Timezone"]);
							$date = new DateTime();
							$date->setTimezone($timezone );
							$lv_time=$date->format('H:i:s');
							$mv_datetime = $mv_date.' '.$lv_time;
                            /****************************/
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));die;
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }
                                else
                                {
                                    $Bid_value = $_REQUEST['Bid_value'];
                                    $Bid_value2 = number_format($Bid_value, 2, '.', '');
                                    $Auction_id = $_REQUEST['Auction_id'];
                                    
                                    if($Auction_id == "" || $Auction_id == 0)
                                    {
                                        echo json_encode(array("status" => "2015", "status_message" => "Kindly Enter An Auction ID"));die;
                                    }
                                    else
                                    {
                                        $result2 = lslDB::getInstance()->get_auction_details($Auction_id,$Company_id);
                                        $Auction_details = mysqli_fetch_array($result2);
                                        $lv_auction_name = $Auction_details['Auction_name'];
                                        $lv_prize = $Auction_details['Prize'];
                                        $Min_increment = $Auction_details['Min_increment'];

                                        $query1 = "SELECT MAX(Bid_value) FROM lsl_auction_winner"
                                                . " WHERE Company_id='".$Company_id."'"
                                                . " AND Auction_id='".$Auction_id."' ";
                                        $result1 = mysqli_fetch_array(mysqli_query($conn,$query1));
                                        $Max_bid_for_auction = $result1['MAX(Bid_value)'];
                                        $Minimum_points_to_bid = $Max_bid_for_auction + $Min_increment;

                                        if($Bid_value2 <= $Max_bid_for_auction)
                                        {
                                            echo json_encode(array("status" => "2013", "status_message" => "Bid value should be greater or equal to minimum bid Amount"));die;
                                        }
                                        else if($Bid_value < $Minimum_points_to_bid)
                                        {
                                            echo json_encode(array("status" => "2013", "status_message" => "Bid value should be greater or equal to minimum bid Amount"));die;
                                        }
                                        else if($Bid_value > $Current_balance)
                                        {
                                            echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));die;
                                        }
                                        else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                                        {
                                            echo json_encode(array("status" => "2026", "status_message" => "You have Exceeded your transfer limit for the day"));die;
                                        }
                                        else if($Parent_enroll_id > 0 && $Family_redeem_limit_cust < $Bid_value)
                                        {
                                            echo json_encode(array("status" => "2027", "status_message" => "Insufficient Points limit for the day / Check your Daily Limit"));die;                                        
                                        }
                                        else if($Bid_value == "" || $Bid_value == 0 || $Bid_value < 0)
                                        {
                                            echo json_encode(array("status" => "3006", "status_message" => "Bid value is Invalid"));die;
                                        }
                                        else if( is_numeric($Bid_value) && ( floor($Bid_value) != $Bid_value ) )
                                        {
                                            echo json_encode(array("status" => "3006", "status_message" => "Bid value is Invalid"));die;
                                        }
                                        else
                                        {
                                            if($Bid_value > 0 && $Auction_id > 0)
                                            {
                                                $query3 ="SELECT count(Enrollment_id) FROM lsl_auction_winner
                                                            WHERE Company_id='".$Company_id."' AND 
                                                            Auction_id='".$Auction_id."' AND 
                                                            Enrollment_id='".$Enrollment_id."' AND
                                                            Winner_flag='0' AND Active_flag='0'";
                                                $result3 = mysqli_query($conn,$query3);			
                                                while($row3 = mysqli_fetch_assoc($result3))
                                                {
                                                    $lv_count= $row3['count(Enrollment_id)'];
                                                }

                                                if ($lv_count > 0) //If More than 1 records for that Enrollment_id then get the Maximum Bid Value 
                                                {
                                                    $query4 ="SELECT Max(Bid_value) FROM lsl_auction_winner
                                                              WHERE Company_id='".$Company_id."'	AND 
                                                              Auction_id='".$Auction_id."' AND 
                                                              Enrollment_id='".$Enrollment_id."' AND
                                                              Winner_flag='0' AND Active_flag='0'";
                                                    $result4 = mysqli_query($conn,$query4);
                                                    while($row4 = mysqli_fetch_assoc($result4))
                                                    {
                                                        $lv_max_bid_value = $row4['Max(Bid_value)'];
                                                    }

                                                    $query5 = "SELECT * FROM lsl_auction_winner 
                                                              WHERE Company_id='".$Company_id."'
                                                              AND Auction_id='".$Auction_id."' 
                                                              AND Bid_value < '".$Bid_value."' 
                                                              ORDER BY Bid_value DESC LIMIT 0,1";
                                                    $result5 = mysqli_fetch_array(mysqli_query($conn,$query5));

                                                    if($result5['Enrollment_id'] == $Enrollment_id)
                                                    {
                                                        $lv_max_bid_value1 = round($lv_max_bid_value);
                                                        $lv_temp_blocked_value = $Blocked_points - $lv_max_bid_value1;
                                                        $lv_new_blocked_points = $lv_temp_blocked_value + $Bid_value;

                                                        $query6 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points."' WHERE Enrollment_id='".$Enrollment_id."' AND Company_id='".$Company_id."'";
                                                        $update_userbal13 = mysqli_query($conn,$query6);			
                                                        $mv_balance = $Curr_balance - $lv_new_blocked_points;
                                                        
                                                        if($Parent_enroll_id > 0)
                                                        {
                                                            $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                                            while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                            {
                                                                $parent_temp_blocked_value = $lsl_rows12['Blocked_points'] - $lv_max_bid_value1;
                                                                $new_parent_blocked_points = $parent_temp_blocked_value + $mv_bid_val;
                                                            }

                                                            $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id."' and Company_id='".$Company_id."'";
                                                            $update_parentbal = mysqli_query($conn,$query_parent);

                                                            /********************************************Send Notification To Parent**********************************/
                                                                $Transaction_date=date("Y-m-d");
                                                                $Template_type_id = 33;
                                                                $Email_type = 187;	
                                                                $auction_bid_template = lslDB::getInstance()->send_auction_bid_template99($Enrollment_id,$lv_auction_name,$result5['Bid_value'],$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Parent_enroll_id,$Auction_id,$Bid_value2);
                                                            /********************************************Send Notification To Parent**********************************/
                                                        }
                                                    }
                                                    else
                                                    {
                                                        /******************************************Previous Highest Bidder*************************************/
                                                        $lv_user_detail23 = lslDB::getInstance()->get_user_details($result5['Enrollment_id'],$Company_id);
                                                        while($lsl_rows13 = mysqli_fetch_array($lv_user_detail23))
                                                        {
                                                            $lv_user_enrollid23 = $lsl_rows13['Enrollment_id'];
                                                            $Curr_balance23 = $lsl_rows13['Current_balance'];
                                                            $Blocked_points23 = $lsl_rows13['Blocked_points'];
                                                            $Communication_flag23=$lsl_rows13['Communication_flag'];
                                                            $Communication_type23=$lsl_rows13['Communication_type'];
                                                            $Parent_enroll_id23=$lsl_rows13['Parent_enroll_id'];
                                                        }

                                                        $lv_max_bid_value13 = round($result5['Bid_value']);
                                                        $lv_new_blocked_points23 = $Blocked_points23 - $lv_max_bid_value13;

                                                        $query13 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points23."' WHERE Enrollment_id='".$result5['Enrollment_id']."' AND Company_id='".$Company_id."'";
                                                        $update_userbal13 = mysqli_query($conn,$query13);			
                                                        $mv_balance23 = $Curr_balance23 - $lv_new_blocked_points23;
                                                        
                                                        if($Parent_enroll_id23 != 0)
                                                        {
                                                            $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id23,$Company_id);
                                                            while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                            {
                                                                $new_parent_blocked_points = $lsl_rows12['Blocked_points'] - $lv_max_bid_value13;
                                                            }

                                                            $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id23."' and Company_id='".$Company_id."'";
                                                            $update_parentbal = mysqli_query($conn,$query_parent);
                                                        }

                                                            /******Email notification to Customer********/
                                                            if($Communication_flag23 == 1)
                                                            {
                                                                if($Communication_type23 == 1 || $Communication_type23 == 3)
                                                                {
                                                                    $Transaction_date = date("Y-m-d");
                                                                    $Template_type_id = 50;
                                                                    $Email_type = 187;	
                                                                    $auction_bid_template = lslDB::getInstance()->send_auction_bid_template($result5['Enrollment_id'],$lv_auction_name,$result5['Bid_value'],$mv_balance23,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Auction_id,$Bid_value2); 	
                                                                }

                                                                /*********************Send SMS******************/
                                                                if($Communication_type23 == 2 || $Communication_type23 == 3)
                                                                {
                                                                    $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                                    $company_detail=mysqli_fetch_array($get_company_details);
                                                                    $Auction_bid_sms = $company_detail['Auction_bid_sms'];				
                                                                    $SMS_Type = 187;
                                                                    $Template_smstype_id = 50;
                                                                    if($Auction_bid_sms == 1)
                                                                    {
                                                                        $auction_bid_smstemplate = lslDB::getInstance()->send_auction_bid_smstemplate($result5['Enrollment_id'],$lv_auction_name,$result5['Bid_value'],$mv_balance23,$Company_id,$SMS_Type,$Template_smstype_id,$Transaction_date,$Bid_value2);  	
                                                                    }
                                                                }
                                                                /*********************Send SMS Ends*************/
                                                            }
                                                            /******Email notification to Customer********/	

                                                        /******************************************Previous Highest Bidder*************************************/

                                                        $lv_max_bid_value1 = round($lv_max_bid_value);
                                                        $lv_new_blocked_points = $Blocked_points + $Bid_value;

                                                        $query13 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points."' WHERE Enrollment_id='".$Enrollment_id."' AND Company_id='".$Company_id."'";
                                                        $update_userbal13 = mysqli_query($conn,$query13);			
                                                        $mv_balance = $Curr_balance - $lv_new_blocked_points;
                                                        
                                                        if($Parent_enroll_id != 0)
                                                        {
                                                            $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                                            while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                            {
                                                                $new_parent_blocked_points = $lsl_rows12['Blocked_points'] + $mv_bid_val;
                                                            }

                                                            $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id."' and Company_id='".$Company_id."'"; // Current_balance='".$Current_balance."',
                                                            $update_parentbal = mysqli_query($conn,$query_parent);

                                                            /********************************************Send Notification To Parent**********************************/
                                                                $Transaction_date=date("Y-m-d");
                                                                $Template_type_id = 33;
                                                                $Email_type = 187;	
                                                                $auction_bid_template = lslDB::getInstance()->send_auction_bid_template99($Enrollment_id,$lv_auction_name,$result5['Bid_value'],$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Parent_enroll_id,$Auction_id,$Bid_value2); 
                                                            /********************************************Send Notification To Parent**********************************/
                                                        }
                                                    }
                                                }
                                                else //if ($lv_count == 0)
                                                {
                                                    $sql12 = "SELECT * FROM lsl_auction_winner 
                                                              WHERE Company_id='".$Company_id."'
                                                              AND Auction_id='".$Auction_id."' 
                                                              AND Bid_value < '".$Bid_value."' 
                                                              ORDER BY Bid_value DESC LIMIT 0,1";
                                                    $result12 = mysqli_fetch_array(mysqli_query($conn,$sql12));

                                                    if($result12 != NULL || $result12 != 0)
                                                    {
                                                        if($result12['Enrollment_id'] == $Enrollment_id)
                                                        {
                                                            $lv_new_blocked_points = $Blocked_points + $Bid_value;
                                                            $query11 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points."' WHERE Enrollment_id='".$Enrollment_id."' AND Company_id='".$Company_id."'";
                                                            $update_userbal = mysqli_query($conn,$query11);			
                                                            $mv_balance = $Curr_balance - $lv_new_blocked_points;
                                                            
                                                            if($Parent_enroll_id != 0)
                                                            {
                                                                $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                                                while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                                {
                                                                        $new_parent_blocked_points = $lsl_rows12['Blocked_points'] + $mv_bid_val;
                                                                        $parent_balance = $Current_balance - $new_parent_blocked_points;
                                                                }

                                                                $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id."' and Company_id='".$Company_id."'";
                                                                $update_parentbal = mysqli_query($conn,$query_parent);

                                                                /********************************************Send Notification To Parent**********************************/
                                                                $Transaction_date=date("Y-m-d");
                                                                $Template_type_id = 33;
                                                                $Email_type = 187;	
                                                                $auction_bid_template = lslDB::getInstance()->send_auction_bid_template99($Enrollment_id,$lv_auction_name,$result12['Bid_value'],$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Parent_enroll_id,$Auction_id,$Bid_value2); 
                                                                /********************************************Send Notification To Parent**********************************/
                                                            }
                                                        }
                                                        else
                                                        {
                                                            /******************************************Previous Highest Bidder*************************************/
                                                            $lv_user_detail23 = lslDB::getInstance()->get_user_details($result12['Enrollment_id'],$Company_id);
                                                            while($lsl_rows13=mysqli_fetch_array($lv_user_detail23))
                                                            {
                                                                $lv_user_enrollid23 = $lsl_rows13['Enrollment_id'];
                                                                $Curr_balance23 = $lsl_rows13['Current_balance'];
                                                                $Blocked_points23 = $lsl_rows13['Blocked_points'];
                                                                $Communication_flag23=$lsl_rows13['Communication_flag'];
                                                                $Communication_type23=$lsl_rows13['Communication_type'];
                                                                $Parent_enroll_id23=$lsl_rows13['Parent_enroll_id'];
                                                            }

                                                            $lv_max_bid_value13 = round($result12['Bid_value']);
                                                            $lv_new_blocked_points23 = $Blocked_points23 - $lv_max_bid_value13;

                                                            $query13 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points23."' WHERE Enrollment_id='".$result12['Enrollment_id']."' AND Company_id='".$Company_id."'";
                                                            $update_userbal13 = mysqli_query($conn,$query13);			
                                                            $mv_balance23 = $Curr_balance23 - $lv_new_blocked_points23;
                                                            
                                                            if($Parent_enroll_id23 != 0)
                                                            {
                                                                $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id23,$Company_id);
                                                                while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                                {
                                                                    $parent_blocked_points = $lsl_rows12['Blocked_points'] - $lv_max_bid_value13;
                                                                }

                                                                $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id23."' and Company_id='".$Company_id."'";
                                                                $update_parentbal = mysqli_query($conn,$query_parent);
                                                            }

                                                                /******Email notification to customer********/
                                                                if($Communication_flag23 == 1)
                                                                {
                                                                    if($Communication_type23 == 1 || $Communication_type23 == 3)
                                                                    {
                                                                        $Transaction_date = date("Y-m-d");
                                                                        $Template_type_id = 50;
                                                                        $Email_type = 187;//******** auction rebid template **********/
                                                                        $auction_bid_template = lslDB::getInstance()->send_auction_bid_template($result12['Enrollment_id'],$lv_auction_name,$result12['Bid_value'],$mv_balance23,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Auction_id,$Bid_value2);   	
                                                                    }

                                                                    /*********************Send SMS******************/
                                                                    if($Communication_type23 == 2 || $Communication_type23 == 3)
                                                                    {
                                                                        $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                                        $company_detail=mysqli_fetch_array($get_company_details);
                                                                        $Auction_bid_sms = $company_detail['Auction_bid_sms'];				
                                                                        $SMS_Type = 187;
                                                                        $Template_smstype_id = 50;
                                                                        if($Auction_bid_sms == 1)
                                                                        {
                                                                            $auction_bid_smstemplate = lslDB::getInstance()->send_auction_bid_smstemplate($result12['Enrollment_id'],$lv_auction_name,$result12['Bid_value'],$mv_balance23,$Company_id,$SMS_Type,$Template_smstype_id,$Transaction_date,$Bid_value2);	
                                                                        }
                                                                    }
                                                                    /*********************Send SMS Ends*************/
                                                                }
                                                                /******Email notification to customer********/

                                                            /******************************************Previous Highest Bidder*************************************/
                                                                
                                                                if($Parent_enroll_id23 == $Enrollment_id)
                                                                {
                                                                    $lv_new_blocked_points = $parent_blocked_points + $mv_bid_val;
                                                                }
                                                                else
                                                                {
                                                                    $lv_new_blocked_points = $Blocked_points + $mv_bid_val;
                                                                }
                                                                
                                                                $query11 = "Update lsl_enrollment_master Set Blocked_points='".$lv_new_blocked_points."' where Enrollment_id='".$Enrollment_id."' and Company_id='".$Company_id."'";
                                                                $update_userbal = mysqli_query($conn,$query11);			
                                                                $mv_balance = $Curr_balance - $lv_new_blocked_points;
                                                                
                                                                if($Parent_enroll_id != 0)
                                                                {
                                                                    $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                                                    while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                                    {
                                                                        $new_parent_blocked_points = $lsl_rows12['Blocked_points'] + $mv_bid_val;
                                                                    }

                                                                    $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id."' and Company_id='".$Company_id."'";
                                                                    $update_parentbal = mysqli_query($conn,$query_parent);

                                                                    /********************************************Send Notification To Parent**********************************/
                                                                        $Transaction_date=date("Y-m-d");
                                                                        $Template_type_id = 33;
                                                                        $Email_type = 187;	
                                                                        $auction_bid_template = lslDB::getInstance()->send_auction_bid_template99($Enrollment_id,$lv_auction_name,$result12['Bid_value'],$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Parent_enroll_id,$Auction_id,$Bid_value2); 
                                                                    /********************************************Send Notification To Parent**********************************/
                                                                }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $lv_new_blocked_points = $Blocked_points + $Bid_value;
                                                        $query11 = "UPDATE lsl_enrollment_master SET Blocked_points='".$lv_new_blocked_points."' WHERE Enrollment_id='".$Enrollment_id."' AND Company_id='".$Company_id."'";
                                                        $update_userbal = mysqli_query($conn,$query11);			
                                                        $mv_balance = $Curr_balance - $lv_new_blocked_points;
                                                        
                                                        if($Parent_enroll_id != 0)
                                                        {
                                                            $lv_user_detail22 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                                            while($lsl_rows12=mysqli_fetch_array($lv_user_detail22))
                                                            {
                                                                $new_parent_blocked_points = $lsl_rows12['Blocked_points'] + $mv_bid_val;
                                                                $parent_balance = $Current_balance - $new_parent_blocked_points;
                                                            }

                                                            $query_parent = "Update lsl_enrollment_master Set Blocked_points='".$new_parent_blocked_points."' where Enrollment_id='".$Parent_enroll_id."' and Company_id='".$Company_id."'";// Current_balance='".$Current_balance."',
                                                            $update_parentbal = mysqli_query($conn,$query_parent);

                                                            /********************************************Send Notification To Parent**********************************/
                                                                $Transaction_date=date("Y-m-d");
                                                                $Template_type_id = 33;
                                                                $Email_type = 187;	
                                                                $auction_bid_template = lslDB::getInstance()->send_auction_bid_template99($Enrollment_id,$lv_auction_name,$result12['Bid_value'],$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Parent_enroll_id,$Auction_id,$Bid_value2);
                                                            /********************************************Send Notification To Parent**********************************/
                                                        }
                                                    }
                                                }

                                                $create_auction = lslDB::getInstance()->insert_auction_bid_details($Auction_id,$Company_id,$Enrollment_id,$lv_prize,$Bid_value,$Enrollment_id,$mv_datetime);

                                                $query12 = "UPDATE lsl_auction_master SET Min_bid_value='".$Bid_value."' WHERE Auction_id='".$Auction_id."' AND Company_id='".$Company_id."'";
                                                $update_auctionbal = mysqli_query($conn,$query12);

                                                $lv_new_blocked_points = $Blocked_points + $Bid_value;
                                                $mv_balance = $Curr_balance - $lv_new_blocked_points;

                                                /******Email notification to customer********/
                                                    if($Communication_flag == 1)
                                                    {
                                                        if($Communication_type == 1 || $Communication_type == 3)
                                                        {
                                                            $Transaction_date = date("Y-m-d");
                                                            $Template_type_id = 33;
                                                            $Email_type = 187;	
                                                            $auction_bid_template = lslDB::getInstance()->send_auction_bid_template($Enrollment_id,$lv_auction_name,$Bid_value,$mv_balance,$Company_id,$Email_type,$Template_type_id,$Transaction_date,$Auction_id,$Bid_value2);	
                                                        }

                                                        /*********************Send SMS******************/
                                                        if($Communication_type == 2 || $Communication_type == 3)
                                                        {
                                                            $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                            $company_detail=mysqli_fetch_array($get_company_details);
                                                            $Auction_bid_sms = $company_detail['Auction_bid_sms'];				
                                                            $SMS_Type = 187;
                                                            $Template_smstype_id = 33;
                                                            if($Auction_bid_sms == 1)
                                                            {
                                                                $auction_bid_smstemplate = lslDB::getInstance()->send_auction_bid_smstemplate($Enrollment_id,$lv_auction_name,$Bid_value,$mv_balance,$Company_id,$SMS_Type,$Template_smstype_id,$Transaction_date,$Bid_value2);  	
                                                            }
                                                        }
                                                        /*********************Send SMS Ends*************/
                                                    }
                                                /******Email notification to customer********/

                                                echo json_encode(array("status" => "1001", "status_message" => "Success"));die;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                    }
                    /************************************Acution Bidding********************************/
                    
                    /************************************Transfer Points********************************/
                    if($API_flag == 11)  //***validate Transfer to membership id and retrieve the details
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            
                            $Transfer_membershipid = trim(string_decrypt($_REQUEST['Transfer_membershipid'], $key, $iv));
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);                            
                            $Transfer_membershipid = preg_replace("/[^(\x20-\x7f)]*/s", "", $Transfer_membershipid);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            
                            $Transferto_member_details_result = lslDB::getInstance()->get_member_details($Transfer_membershipid,$Company_id);
                            $Transferto_member_details = mysqli_fetch_array($Transferto_member_details_result);
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access=1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                            
                            $company_details_result = lslDB::getInstance()->get_company_details($Company_id);
                            $company_details = mysqli_fetch_array($company_details_result);
                            $Cust_pin_validation = $company_details['Cust_pin_validation'];
                            
                            if($member_details == NULL)
                            {
                                 echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Transfer_membershipid == "")
                                    {
                                        echo json_encode(array("status" => "2016", "status_message" => "Kindly Enter the Membership ID you want to Transfer to"));
                                    }
                                    else if($Transfer_membershipid == $Membership_id)
                                    {
                                        echo json_encode(array("status" => "2017-1", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }
                                    else if($Parent_enroll_id == $Transferto_member_details['Enrollment_id'])
                                    {
                                        echo json_encode(array("status" => "2017-2", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }
                                    else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                                    {
                                        echo json_encode(array("status" => "2026", "status_message" => "You have Exceeded your transfer limit for the day"));
                                    }
                                    else
                                    {
                                        $query1 = "SELECT Enrollment_id,First_name,Last_name,Phone_no,Membership_id FROM lsl_enrollment_master "
                                                    . "WHERE Membership_id ='".$Transfer_membershipid."' "
                                                    . "AND Company_id=".$Company_id." "
                                                    . "AND User_type_id='1' "
                                                    . "AND Active_flag='1'";
                                        $result1 = mysqli_fetch_array(mysqli_query($conn,$query1));
                                        $Valid_count = mysqli_num_rows(mysqli_query($conn,$query1));
                                        
                                        $New_current_bal = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                        if($Valid_count > 0)
                                        {
                                            /*$Transfer_to_details = array(
                                                            "status" => "1001",
                                                            "Current_balance" => $member_details['Current_balance'] - $member_details['Blocked_points'],
                                                            "First_name" => $result1['First_name'],
                                                            "Last_name" => $result1['Last_name'],
                                                            "Phone_no" => $result1['Phone_no'],
                                                            "Membership_id" => $result1['Membership_id'],
                                                            "Enrollment_id" => $result1['Current_balance']
                                                        );*/
                                            
                                            $Transfer_to_details = array(
                                                            "status" => "1001",
                                                            "First_name" => string_encrypt($result1['First_name'],$key, $iv),
                                                            "Last_name" => string_encrypt($result1['Last_name'],$key, $iv),
                                                            "Phone_no" => string_encrypt($result1['Phone_no'],$key, $iv),
                                                            "Membership_id" => string_encrypt($result1['Membership_id'],$key, $iv),
                                                            "Current_balance" => string_encrypt($New_current_bal,$key, $iv),
                                                            "Cust_pin_validation" => $Cust_pin_validation,
                                                            "status_message" => "Success"
                                            );
                                            echo json_encode($Transfer_to_details);
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 12)  //***Transfer points
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Transfer_to_membershipid1 = trim(string_decrypt($_REQUEST['Transfer_to_membershipid'], $key, $iv));
                            $points_to_transfer1 = trim(string_decrypt($_REQUEST['points_to_transfer'], $key, $iv));
                            $pin_no1 = trim(string_decrypt($_REQUEST['pin_no'], $key, $iv));
                            
                            $Transfer_to_membershipid = preg_replace("/[^(\x20-\x7f)]*/s", "", $Transfer_to_membershipid1);
                            $points_to_transfer = preg_replace("/[^(\x20-\x7f)]*/s", "", $points_to_transfer1);
                            $pin_no = preg_replace("/[^(\x20-\x7f)]*/s", "", $pin_no1);
                            
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Communication_flag = $member_details['Communication_flag'];
                            $Communication_type = $member_details['Communication_type'];
                            $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                            $Today_date = date("Y-m-d H:i:s");
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            
                            $Transferto_member_details_result = lslDB::getInstance()->get_member_details($Transfer_to_membershipid,$Company_id);
                            $Transferto_member_details = mysqli_fetch_array($Transferto_member_details_result);
                            
                            $company_details_result = lslDB::getInstance()->get_company_details($Company_id);
                            $company_details = mysqli_fetch_array($company_details_result);
                            $Cust_pin_validation = $company_details['Cust_pin_validation'];
                            $Company_username = $company_details['Company_username'];
                            $Company_password = $company_details['Company_password'];
                            $Company_password = string_encrypt($Company_password, $key, $iv);
                            
                            $Middleware_flag = 0;
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access=1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                            
                            if($member_details == NULL)
                            {
                                 echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Transfer_to_membershipid == "")
                                    {
                                        echo json_encode(array("status" => "2016", "status_message" => "Kindly Enter the Membership ID you want to Transfer to"));
                                    }
                                    else if($Transfer_membershipid == $Membership_id)
                                    {
                                        echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }
                                    else if($points_to_transfer == "" || $points_to_transfer == 0 || $points_to_transfer < 0)
                                    {
                                        echo json_encode(array("status" => "2018", "status_message" => "Invalid Transfer Points Entered"));die;
                                    }
                                    else if( is_numeric($points_to_transfer) && ( floor($points_to_transfer) != $points_to_transfer ) )
                                    {
                                        echo json_encode(array("status" => "2018", "status_message" => "Invalid Transfer Points Entered"));die;
                                    }
                                    else if($points_to_transfer > $Current_balance)
                                    {
                                        echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                                    }
                                    else if( ($Cust_pin_validation == 1) && ($pin_no == "" || $pin_no != $member_details['Pin']) )
                                    {
                                        echo json_encode(array("status" => "2025", "status_message" => "Incorrect PIN"));
                                    }
                                    else if($Parent_enroll_id == $Transferto_member_details['Enrollment_id'])
                                    {
                                        echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }
                                    else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                                    {
                                        echo json_encode(array("status" => "2026", "status_message" => "You have Exceeded your transfer limit for the day"));
                                    }
                                    else if($Parent_enroll_id > 0 && $Family_redeem_limit_cust < $points_to_transfer)
                                    {
                                        echo json_encode(array("status" => "2027", "status_message" => "Insufficient Points limit for the day / Check your Daily Limit"));                                           
                                    }
                                    else
                                    {
                                        $query1 = "SELECT * FROM lsl_enrollment_master "
                                                    . "WHERE Membership_id ='".$Transfer_to_membershipid."' "
                                                    . "AND Company_id=".$Company_id." "
                                                    . "AND User_type_id='1' "
                                                    . "AND Active_flag='1'";
                                        $result1 = mysqli_fetch_array(mysqli_query($conn,$query1));
                                        $Valid_count = mysqli_num_rows(mysqli_query($conn,$query1));
                                        
                                        $Communication_flag2 = $result1['Communication_flag'];
                                        $Communication_type2 = $result1['Communication_type'];
                            
                                        if($Valid_count > 0)
                                        {
                                            /**************************Insert transaction********************************/
                                                $insert_transafer_points = lslDB::getInstance()->insert_transfer_transaction('6',$Company_id,$Enrollment_id,$member_details['Membership_id'],$Today_date,$result1["Enrollment_id"],$Transfer_to_membershipid,$points_to_transfer,'',$Enrollment_id,$Today_date);
                                            /**************************Insert transaction********************************/
                                                
                                            /************************Insert Other customer Entry in transaction table as Credit Transaction**********************/
                                                $query2 = "INSERT INTO lsl_transaction(Transaction_type_id,Company_id,Member1_enroll_id,Membership1_id,Transaction_date,Member2_enroll_id,Membership2_id,Bonus_points,Member_pin,Create_user_id,Create_date)
                                                            VALUES('3','".$Company_id."','".$result1["Enrollment_id"]."','".$Transfer_to_membershipid."','".$Today_date."','".$Enrollment_id."','".$member_details['Membership_id']."','".$points_to_transfer."','".$pin_no."','".$Enrollment_id."','".$Today_date."')";
                                                $result2 = mysqli_query($conn,$query2);
                                            /************************Insert Other customer Entry in transaction table as Credit Transaction**********************/
                                                
                                            /************************Decrease Current Balance of Login Member************************/
                                                $avail_bal = $member_details['Current_balance'];//+ $member_details['Blocked_points']
                                                $avail_bal = $avail_bal - $points_to_transfer;
                                                
                                                if($Parent_enroll_id > 0)
                                                {
                                                    $Transferfrom_parent_avail_bal = $lv_row292['Current_balance'] - $points_to_transfer;                                                    
                                                    $family_avail_bal = $member_details['Current_balance'] - $points_to_transfer;
                                                    
                                                    $update_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$Enrollment_id,$family_avail_bal);
                                                    $update_parent_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$Parent_enroll_id,$Transferfrom_parent_avail_bal);
                                                }
                                                else
                                                {
                                                    $update_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$Enrollment_id,$avail_bal);
                                                }
                                            /************************Decrease Current Balance of Login Member************************/
                                                
                                            /************************Increase Current Balance of Other Member************************/
                                                $avail_bal2 = $result1["Current_balance"] + $points_to_transfer;
                                                
                                                $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($Company_id,$Enrollment_id,$points_to_transfer,$insert_transafer_points,'',$Enrollment_id,$Today_date,"Transfer Points");
                                                
                                                if($result1["Parent_enroll_id"] > 0)
                                                {
                                                    $Transferto_parent_result = lslDB::getInstance()->get_user_details($result1["Parent_enroll_id"],$Company_id);
                                                    $Transferto_parent_details = mysqli_fetch_array($Transferto_parent_result);
                                                    $Transferto_parent_CB = $Transferto_parent_details['Current_balance'];
                                                    
                                                    $Transferto_parent_avail_bal = $Transferto_parent_CB + $points_to_transfer;
                                                    $update_member_balance3 = lslDB::getInstance()->update_member_balance($Company_id,$result1["Enrollment_id"],$avail_bal2);
                                                    $update_Transferto_parent_balance = lslDB::getInstance()->update_member_balance($Company_id,$result1["Parent_enroll_id"],$Transferto_parent_avail_bal);
                                                }
                                                else
                                                {
                                                    $update_member_balance2 = lslDB::getInstance()->update_member_balance($Company_id,$result1["Enrollment_id"],$avail_bal2);
                                                }
                                            /************************Increase Current Balance of Other Member************************/
                                                
                                            /******Points Transfer From Email Notification********/
                                                $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                $company_detail=mysqli_fetch_array($get_company_details);
                                                $Points_transfers_sms = $company_detail['Points_transfers_sms'];

                                                if($Communication_flag == 1)
                                                {
                                                    if($Communication_type == 1 || $Communication_type == 3)
                                                    {
                                                        $Template_type_id = 32; $Email_type = 186;
                                                        $point_transfer_from_template = lslDB::getInstance()->send_point_transfer_from_template($Enrollment_id,$result1["Enrollment_id"],$points_to_transfer,$Transfer_to_membershipid,$avail_bal,$Company_id,$Email_type,$Template_type_id,$Today_date);
                                                    }

                                                    /*********************Send SMS******************/
                                                        if($Communication_type == 2 || $Communication_type == 3)
                                                        {				
                                                            $SMS_Type = 186;    $Template_smstype_id = 32;
                                                            if($Points_transfers_sms == 1)
                                                            {
                                                                $transferpoints_smstemplate = lslDB::getInstance()->send_point_transfer_from_smstemplate($Enrollment_id,$result1["Enrollment_id"],$points_to_transfer,$Transfer_to_membershipid,$avail_bal,$Company_id,$Email_type,$Template_type_id,$Today_date); 
                                                            }
                                                        }
                                                    /*********************Send SMS Ends*************/
                                                }
                                            /******Points Transfer From Email Notification********/
                                            
                                            /*********************Transfer From Customer Parent**************************/
                                                if($Parent_enroll_id > 0)
                                                {
                                                    $Template_type_id = 32;     $Email_type = 186;	
                                                    $point_transfer_from_template33 = lslDB::getInstance()->send_point_transfer_from_template99($Enrollment_id,$result1["Enrollment_id"],$points_to_transfer,$Transfer_to_membershipid,$family_avail_bal,$Company_id,$Email_type,$Template_type_id,$Today_date,$Parent_enroll_id); 
                                                }
                                            /*********************Transfer From Customer Parent**************************/
                                            
                                            /******Points Transfer To Email Notification********/
                                            if($Communication_flag2 == 1)
                                            {
                                                if($Communication_type2 == 1 || $Communication_type2 == 3)
                                                {
                                                    $Template_type_id1 = 35;    $Email_type1 = 205;
                                                    $point_transfer_to_template = lslDB::getInstance()->send_point_transfer_to_template($result1["Enrollment_id"],$Enrollment_id,$points_to_transfer,$Transfer_to_membershipid,$avail_bal2,$Company_id,$Email_type1,$Template_type_id1,$Today_date);   
                                                }
                                                
                                                /*********************Send SMS******************/
                                                    if($Communication_type2 == 2 || $Communication_type2 == 3)
                                                    {
                                                        if($Points_transfers_sms == 1)
                                                        {
                                                            $transferpoints_to_smstemplate = lslDB::getInstance()->send_point_transfer_to_smstemplate($result1["Enrollment_id"],$Enrollment_id,$points_to_transfer,$Transfer_to_membershipid,$avail_bal2,$Company_id,$Email_type1,$Template_type_id1,$Today_date); 
                                                        }
                                                    }
                                                /*********************Send SMS Ends*************/
                                            }
                                            /******Points Transfer To Email Notification********/
                                            
                                            /*********************Transfer To Customer Parent**************************/
                                                if($result1["Parent_enroll_id"] > 0)
                                                {
                                                    $Template_type_id1 = 35;    $Email_type1 = 205;
                                                    $point_transfer_to_template44 = lslDB::getInstance()->send_point_transfer_to_template99($result1["Enrollment_id"],$Enrollment_id,$points_to_transfer,$Transfer_to_membershipid,$Transferto_parent_avail_bal,$Company_id,$Email_type1,$Template_type_id1,$Today_date,$result1["Parent_enroll_id"]); 
                                                }
                                            /*********************Transfer To Customer Parent**************************/
                                            
                                            $TransferMember_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
												$status_message = "Transfer successful ".$points_to_transfer." points transferred";
                                            echo json_encode(array("status" => "1001", "Current_balance" => $TransferMember_balance, "status_message" => $status_message, "status_message" => "Success"));
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Transfer Points********************************/
                    
                    /************************************Resend Pin********************************/
                    if($API_flag == 13)  //***Resend Customer Pin
                    {
                        //var_dump($_REQUEST);die;
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Middleware_flag = 0;

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Communication_flag   = $member_details['Communication_flag'];
                                    $Communication_type   = $member_details['Communication_type'];
                                    
                                    $NewPin = getRandomString2();
                                    $sql ="UPDATE lsl_enrollment_master SET Pin='".$NewPin."' WHERE Membership_id='".$Membership_id."' AND Enrollment_id='".$member_details['Enrollment_id']."' AND Company_id='".$Company_id."' ";
                                    $result = mysqli_query($conn,$sql);
                                    //echo "NewPin----------".$sql."<br>";die;
                                    
                                    if($Communication_flag == 1)
                                    {
                                        if($Communication_type == 2) //For SMS
                                        {
                                            $SMS_Type = 23;  $Template_smstype_id = 25;    //****Customer Pin Reset sms Template**
                                            $customer_info_template2 = lslDB::getInstance()->callcenter_sendinfo_customer_smstemplate($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$NewPin,$SMS_Type,$Template_smstype_id); 
                                            $Middleware_flag = 0;
                                            echo json_encode(array("status" => "1001","User_email_id" => $member_details['User_email_id'], "status_message" => "Success"));
                                        }
                                        else if($Communication_type == 1) //For Email
                                        {
                                            $Email_Type = 23;   $Template_type_id = 25; //****Customer Pin Reset email Template**
                                            $customer_info_template = lslDB::getInstance()->send_customer_info_template($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$NewPin,$Email_Type,$Template_type_id); 
                                            $Middleware_flag = 1;
                                            echo json_encode(array("status" => "1001","User_email_id" => $member_details['User_email_id'], "status_message" => "Success"));
                                        }
                                        else if($Communication_type == 3) //For Both
                                        {
                                            $SMS_Type = 23;  $Template_smstype_id = 25;    //****Customer Pin Reset sms Template**
                                            $customer_info_template2 = lslDB::getInstance()->callcenter_sendinfo_customer_smstemplate($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$NewPin,$SMS_Type,$Template_smstype_id); 

                                            $Email_Type = 23;   $Template_type_id = 25; //****Customer Pin Reset email Template**
                                            $customer_info_template = lslDB::getInstance()->send_customer_info_template($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$NewPin,$Email_Type,$Template_type_id); 
                                        
                                            $Middleware_flag = 2;
                                            echo json_encode(array("status" => "1001","User_email_id" => $member_details['User_email_id'], "status_message" => "Success"));
                                        }
                                                                                        
                                            /* echo json_encode(array("status" => "1001","User_email_id" => $member_details['User_email_id'], "status_message" => "Success")); */
									}
									else
									{
										echo json_encode(array("status" => "2019", "status_message" => "Email Communication is Disabled"));
									}								
                                }
                            }
                        }
                    }
                    /************************************Resend Pin********************************/
                    
                    /************************************Update Profile********************************/
                    if($API_flag == 14)  //***Update Customer Profile
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Update_profile_array = $_REQUEST['Update_profile'];
                                    $Array_count = COUNT($Update_profile_array);
                                    
                                    if($Array_count > 0)
                                    {
                                        $data_str = '' ;
                                        foreach ($Update_profile_array as $column => $value)
                                        {
                                            if (!empty($data_str))
                                            {
                                                $data_str .= ', ' ;
                                            }

                                            $value = trim(string_decrypt($value, $key, $iv));
                                            $value = preg_replace("/[^(\x20-\x7f)]*/s", "", $value);
                                            
                                            if($column == "Date_of_birth")
                                            {
                                                $value = str_replace('/', '-', $value);
                                                $DOB = date("Y-m-d", strtotime($value));
                                                $data_str .= "$column = '".$DOB."' " ;
                                            }
                                            else
                                            {
                                                $data_str .= "$column = '".$value."' " ;
                                            }
											
                                        }
                                        
                                        $query1 = "UPDATE lsl_enrollment_master SET $data_str "
                                                . "WHERE Membership_id='".$Membership_id."' "
                                                . "AND Company_id='".$Company_id."' ";
                                        //echo $query1;
                                        $result1 = mysqli_query($conn,$query1);

                                        echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                                    }
                                }
                            }
                        }
                    }
                    /************************************Update Profile********************************/
                    
                    /************************************My Statement********************************/
                    if($API_flag == 15)  //***get Customer Report Statement
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                        else
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));die;
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }
                                else
                                {
                                    /*$From_date = trim(string_decrypt($_REQUEST['From_date'], $key, $iv));
                                    $Till_date = trim(string_decrypt($_REQUEST['Till_date'], $key, $iv));*/
                                    
                                    $From_date = $_REQUEST['From_date'];
                                    $Till_date = $_REQUEST['Till_date'];
                                    $View = $_REQUEST['View'];
                                    
                                    $From_date = date("Y-m-d h:i:s", strtotime($From_date));
                                    $Till_date = date("Y-m-d h:i:s", strtotime($Till_date));
                                    $Result_data = array();
                                    
                                    $Start_limit = trim($_REQUEST['Start_limit']);
                                    $End_limit = trim($_REQUEST['End_limit']);
                                    $LIMIT = "";
                                    
                                    $Points_gained = 0;     $Points_used = 0;
                                    
                                    if($Start_limit == "" && $Start_limit == NULL && $End_limit == "" && $End_limit == NULL)
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( $Start_limit != "" && $End_limit == "" )
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( ($Start_limit == "" || $Start_limit == NULL) && $End_limit != "" )
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit > $End_limit)
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit != "" && $End_limit != "")
                                    {
                                        $LIMIT = "LIMIT ".$Start_limit.",".$End_limit." ";
                                    }
                                    
                                    if($View != "")
                                    {
										if($Company_Solution_type == 3)  //*** if coalition company *****
										{/* 
											if($View == 1 || $View == 3)
											{
												if($_REQUEST['From_date'] != "" && $_REQUEST['Till_date'] != "")
												{
													$query1 = "SELECT Member1_enroll_id,Member2_enroll_id,Membership2_id,Benefit_description,Transaction_date,Bonus_points,Transaction_type_id,Item_code,Quantity,Shipping_points,Bill_no,Branch_code,Order_no,Voucher_no,Transaction_amount,Loyalty_points,Redeem_points,Order_status, Voucher_status, Delivery_method,Transfer_points 
															   FROM lsl_transaction 
															   WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
															   AND Transaction_date between '".$From_date."'
															   AND '".$Till_date."'
															   AND Transaction_status='0'
															   AND (Company_id in 	
																		( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
																		  OR (Company_id = ".$Company_id."
																		)
																	) 
															   ORDER BY Transaction_date DESC ".$LIMIT." ";
												}
												else
												{
													$query1 = "SELECT Member1_enroll_id,Member2_enroll_id,Membership2_id,Benefit_description,Transaction_date,Bonus_points,Transaction_type_id,Item_code,Quantity,Shipping_points,Bill_no,Branch_code,Order_no,Voucher_no,Transaction_amount,Loyalty_points,Redeem_points,Order_status, Voucher_status, Delivery_method,Transfer_points 
															   FROM lsl_transaction 
															   WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
															   AND Transaction_status='0'
															   AND (Company_id in 	
																		( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
																		  OR (Company_id = ".$Company_id."
																		)
																	) 
															   ORDER BY Transaction_date DESC ".$LIMIT." ";
												}
												
												$result1 = mysqli_query($conn,$query1);
												$Result_count = mysqli_num_rows($result1);
												
												if($Result_count > 0)
												{
													while($rows1 = mysqli_fetch_array($result1))
													{
															$query2 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$rows1['Transaction_type_id']."' ";
															$result2 = mysqli_query($conn,$query2);
															$Transaction_type_details = mysqli_fetch_array($result2);

															if($rows1['Transaction_type_id'] == 3 && $rows1['Member2_enroll_id'] != "" && $rows1['Membership2_id'])
															{
																$Transaction_type_name = "Transfer Received";
															}
															else
															{
																$Transaction_type_name = $Transaction_type_details["Transaction_type_name"];
															}

															if($rows1['Transaction_type_id'] == 2)
															{
																/*if($rows1["Delivery_method"]=="2")
																{
																	$Total_reddem23 = $rows1['Redeem_points'] * $rows1['Quantity'];
																	$Total_redeem_points = $Total_reddem23 + $rows1['Shipping_points'];
																}
																else
																{
																	$Total_redeem_points = $rows1['Redeem_points'] * $rows1['Quantity'];
																}/****

																$Total_redeem_points = $rows1['Redeem_points'] * $rows1['Quantity'];
																$Points_used = $Total_redeem_points;
																$Points_gained = 0;
															}
															else
															{
																$Total_redeem_points = $rows1['Redeem_points'];
																$Points_used = $Total_redeem_points;
																
																if($rows1['Loyalty_points'] > 0 && $rows1['Transaction_type_id'] == 1)
																{
																	$Points_gained = $rows1['Loyalty_points'];
																}
																else
																{
																	$Points_gained = $rows1['Bonus_points'];
																}
															}

															if($rows1['Item_code'] == '' || $rows1['Item_code'] == null)
															{
																$Item_name = " - ";
															}
															else
															{
																if ($rows1['Transaction_type_id'] == 2 )
																{
																	//$query3 = "SELECT Merchandize_item_name FROM lsl_company_merchandise_catalogue WHERE Company_id = ".$Company_id." AND Company_merchandize_item_code ='".$rows1['Item_code']."' AND Active_flag=1 ";
																	$query3 = "SELECT Merchandize_item_name FROM lsl_company_merchandise_catalogue WHERE Company_id = ".$Company_id." AND Company_merchandize_item_code ='".$rows1['Item_code']."' ";
																	$result3 = mysqli_query($conn,$query3);
																	$rows2 = mysqli_fetch_array($result3);
																	$Count_item = mysqli_num_rows($result3);
																	
																	if($Count_item > 0)
																	{
																		$Item_name = $rows2["Merchandize_item_name"];
																	}
																	else
																	{
																		$Item_name = " - ";
																	}
																}
																else if ($rows1['Transaction_type_id'] == 1)
																{
																	if($Company_details['Company_type'] == "Bank")
																	{
																		$query4 = "SELECT Item_name FROM lsl_pos_inventory_master 
																				   WHERE Item_code ='".$rows1['Item_code']."'
																				   AND (Company_id in (".$Company_id.",
																					( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." ) )
																				   )";
																	}
																	else
																	{
																		$query4 = "SELECT Item_name FROM lsl_branch_pos_inventory_master 
																				   WHERE Item_code ='".$rows1['Item_code']."'
																				   AND Branch_code = '".$rows1['Branch_code']."'
																				   AND (Company_id in (".$Company_id.",
																					( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." ) )
																				   )";
																	}
																	$result4 = mysqli_query($conn,$query4);
																	$rows3 = mysqli_fetch_array($result4);
																	$Count_item = mysqli_num_rows($result3);
																	
																	if($Count_item > 0)
																	{
																		$Item_name = $rows3["Item_name"];
																	}
																	else
																	{
																		$Item_name = " - ";
																	}
																}
																else
																{
																	$Item_name = " - ";
																}
															}
															//echo "Item_name---".$Item_name."<br>";
															
															if($rows1['Transaction_type_id'] == 3 && $rows1['Member2_enroll_id'] != "" && $rows1['Membership2_id'])
															{
																$result79 = lslDB::getInstance()->get_cust_detail99($rows1['Member2_enroll_id']);
																$rows569 = mysqli_fetch_array($result79);
																$Description = "Received From-".$rows569['Membership_id'];
															}
															else if($rows1['Transaction_type_id'] == 3 || $rows1['Transaction_type_id'] == 4)
															{
																$Description = $rows1['Benefit_description'];
															}
															else if($rows1['Transaction_type_id'] == 2 || $rows1['Transaction_type_id'] == 1)
															{
																$Description = $Item_name;

															}
															else if($rows1['Transaction_type_id'] == 6)
															{
																if($rows1['Member2_enroll_id'] == $member_details['Enrollment_id'])
																{
																	$result7 = lslDB::getInstance()->get_cust_detail99($rows1['Member1_enroll_id']);
																	$rows56 = mysqli_fetch_array($result7);
																	$Description = "Received From-".$rows56['Membership_id'];
																}
																else
																{
																	$result7 = lslDB::getInstance()->get_cust_detail99($rows1['Member2_enroll_id']);
																	$rows56 = mysqli_fetch_array($result7);
																	$Description = "Transferred To-".$rows56['Membership_id'];
																}
															}
															else
															{
																$Description = " - ";
															}

															if($rows1['Bill_no'] == '0' || $rows1['Bill_no'] == '') { $Bill_no = " - "; } else { $Bill_no = $rows1['Bill_no']; }

															if($rows1['Order_no'] == '0' || $rows1['Order_no'] == '') { $Order_no = " - ";} else { $Order_no = $rows1['Order_no']; }

															if($rows1['Voucher_no'] == '0' || $rows1['Voucher_no'] == '') { $Voucher_no = " - ";} else { $Voucher_no = $rows1['Voucher_no']; }

															$Transaction_amount = $rows1['Transaction_amount'];
															
															$Loyalty_points = $rows1['Loyalty_points'];
															$Bonus_points = $rows1['Bonus_points'];
															$Quantity = $rows1['Quantity'];
															
															/*if($rows1['Loyalty_points'] > 0 && $rows1['Transaction_type_id'] == 1)
															{
																$Points_gained = $Loyalty_points;
															}
															else if($rows1['Bonus_points'] > 0 && $rows1['Transaction_type_id'] != 2)
															{
																$Points_gained = $Bonus_points;
															}
															else
															{
																$Points_gained = 0;
															}/****

															if($rows1['Order_status'] == '0')
															{
																$Order_status = " - ";
															}
															else
															{
																$sql3 = "SELECT * FROM lsl_codedecode_master WHERE Code_id ='".$rows1['Order_status']."' ";
																$result3 = mysqli_query($conn,$sql3);
																while($rows3 = mysqli_fetch_array($result3)){ $Order_status = $rows3["Decode_description"]; }
																$Order_status = $Order_status;
															}

															if($rows1['Voucher_status'] == 0)
															{
																$Voucher_status = " - ";
															}
															else
															{
																$sql4 = "SELECT * FROM lsl_codedecode_master WHERE Code_id ='".$rows1['Voucher_status']."' ";
																$result4 = mysqli_query($conn,$sql4);
																while($rows4 = mysqli_fetch_array($result4)){ $Voucher_status = $rows4["Decode_description"]; }
																$Voucher_status = $Voucher_status;
															}

															if($rows1["Delivery_method"]=="1")
															{
																$Delevery_flag = "Redeemed in Person";
															}
															else if($rows1["Delivery_method"]=="2")
															{
																$Delevery_flag = "To be Delivered";
															}
															else if($rows1["Delivery_method"]== "3")
															{
																$Delevery_flag = "Both";
															}
															else
															{
																$Delevery_flag = " - ";
															}

															$Transfer_points = $rows1['Transfer_points'];
															
															if($Transfer_points != 0 && $Transfer_points > 0)
															{
																$Points_used = $Transfer_points;
															}
															
															if($View == 3)
															{
																if($Points_used > 0 || $Points_gained > 0)
																{
																	$Result_data[] = array
																					(
																						"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																						"Transaction_type_name" => $Transaction_type_name,
																						"Description" => $Description,                                                                                
																						"Order_no" => $Order_no,                                                                                
																						"Points_gained" => "$Points_gained",
																						"Points_used" => "$Points_used"
																					);
																}
															}
															else
															{
																$Result_data[] = array
																				(
																					"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																					"Transaction_type_name" => $Transaction_type_name,
																					"Description" => $Description,
																					"Bill_no" => $Bill_no,
																					"Order_no" => $Order_no,
																					"Voucher_no" => $Voucher_no,
																					"Transaction_amount" => "$Transaction_amount",
																					"Loyalty_points" => "$Loyalty_points",
																					"Bonus_points" => "$Bonus_points",
																					"Total_redeem_points" => "$Total_redeem_points",
																					"Quantity" => $Quantity,
																					"Order_status" => $Order_status,
																					"Voucher_status" => $Voucher_status,
																					"Delevery_flag" => $Delevery_flag,
																					"Transfer_points" => "$Transfer_points"
																				);
															}
													}
													
													$p_query1 = "SELECT Transaction_date,Transaction_type_id,Member1_enroll_id,Membership1_id,Order_no,Order_status,Total_shipping_points,Total_shipping_cost,Total_shipping_value "
																. "FROM lsl_transaction as trn,lsl_enrollment_master as enrl "
																. "WHERE trn.Member1_enroll_id = enrl.Enrollment_id "
																. "AND Transaction_type_id='2' "
																. "AND Delivery_method='2' "
																. "AND trn.Company_id='".$Company_id."' "
																. "AND Company_shipping_paid_flag='0' "
																. "AND trn.Transaction_date BETWEEN '".$From_date."' AND '".$Till_date."' "
																. "AND Order_status IN (148,149,150,151) GROUP BY Order_no";
													$p_result1 = mysqli_query($conn,$p_query1);
													while($p_row1 = mysqli_fetch_array($p_result1))
													{
														$Shipping_payble_to_partner = $p_row1['Total_shipping_points'];
														
														$query2 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$p_row1['Transaction_type_id']."' ";
														$result2 = mysqli_query($conn,$query2);
														$Transaction_type_details = mysqli_fetch_array($result2);
														$Transaction_type_name = $Transaction_type_details["Transaction_type_name"];
														
														$Description = "Shipping for Order no. ".$p_row1['Order_no'];
														
														$p_query3 = "SELECT Count(*) as order_quantity "
																	. "FROM lsl_transaction "
																	. "WHERE Transaction_type_id='2' "
																	. "AND Delivery_method='2' "
																	. "AND Company_id='".$Company_id."' "
																	. "AND Order_no='".$p_row1['Order_no']."' ";
														$p_row3 = mysqli_fetch_array(mysqli_query($conn,$p_query3));
														$order_quantity = $p_row3['order_quantity'];
															
														if($Shipping_payble_to_partner > 0)
														{
															if($View == 3)
															{
																$Shipping_result_data[] = array
																						(
																							"Transaction_date" => date("Y-m-d",strtotime($p_row1["Transaction_date"])),
																							"Transaction_type_name" => $Transaction_type_name,
																							"Description" => $Description,                                                                                
																							"Order_no" => $p_row1['Order_no'],                                                                                
																							"Points_gained" => "0",
																							"Points_used" => "$Shipping_payble_to_partner"
																						);
															}
															else
															{
																$Shipping_result_data[] = array
																							(
																								"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																								"Transaction_type_name" => $Transaction_type_name,
																								"Description" => $Description,
																								"Bill_no" => $Bill_no,
																								"Order_no" => $p_row1['Order_no'],
																								"Voucher_no" => '-',
																								"Transaction_amount" => '-',
																								"Loyalty_points" => '-',
																								"Bonus_points" => '-',
																								"Total_redeem_points" => "$Shipping_payble_to_partner",
																								"Quantity" => $order_quantity,
																								"Order_status" => 'Delivered',
																								"Voucher_status" => '-',
																								"Delevery_flag" => 'To be Delivered',
																								"Transfer_points" => ''
																							);
															}
														}
													}
													
													/*$Status_array = array("status" => "1001");
													$Result_data = array_merge($Result_data,$Status_array);
													echo json_encode($Result_data);/***
													
													$Status_array = array("status" => "1001", "Result_data" => $Result_data, "Shipping_result_data" => $Shipping_result_data, "status_message" => "Success");
													echo json_encode($Status_array);die;
												}
												else
												{
													echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
												}
											}
											else
											{
												if($_REQUEST['From_date'] != "" && $_REQUEST['Till_date'] != "")
												{
													$sql = "SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id <> 3
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id				
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Member2_enroll_id <> ''
																	AND Membership2_id <> ''
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id = 3
																	AND Member2_enroll_id = ''
																	AND Membership2_id = ''
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id ".$LIMIT." ";
												}
												else
												{
													$sql = "SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id <> 3
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id				
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Member2_enroll_id <> ''
																	AND Membership2_id <> ''
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id = 3
																	AND Member2_enroll_id = ''
																	AND Membership2_id = ''
																	AND	(Company_id in 	
																			  ( Select Company_id from lsl_company_master where Parent_company_id = ".$Company_id." and Active_flag=1) 
																			  OR (Company_id = ".$Company_id.")
																			)
																	Group By Transaction_type_id ".$LIMIT." ";
												}
												$result = mysqli_query($conn,$sql);
												$Result_count = mysqli_num_rows($result);
												
												if($Result_count > 0)
												{
													while($rows = mysqli_fetch_array($result))
													{
														$sql1 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$rows['Transaction_type_id']."' ";
														$result1 = mysqli_query($conn,$sql1);
														while($rows1 = mysqli_fetch_array($result1))
														{ 
															if($rows['Transaction_type_id'] == 3 && $rows['Member2_enroll_id'] != "" && $rows['Membership2_id'])
															{
															   $Transaction_type_name = 'Points Transfer (Received)'; 
															}
															else
															{
																$Transaction_type_name = $rows1["Transaction_type_name"]; 
															}
														}

														$Total_transaction_amount = $rows['Tot_Transaction_amount'];
														$Total_loyalty_points = $rows['Tot_Loyalty_points'];
														$Total_bonus_points = $rows['Bonus_points'];
														$Total_redeem_points = $rows['Tot_Redeem_points'];
														$Total_transfer_points = $rows['SUM(Transfer_points)'];

														$Result_data[] = array
																		(
																			"Transaction_type_name" => $Transaction_type_name,
																			"Transaction_amount" => $Total_transaction_amount,
																			"Loyalty_points" => "$Total_loyalty_points",
																			"Bonus_points" => "$Total_bonus_points",
																			"Total_redeem_points" => "$Total_redeem_points",
																			"Transfer_points" => "$Total_transfer_points"
																		);
													}
													/*$Status_array = array("status" => "1001");
													$Result_data = array_merge($Result_data,$Status_array);
													echo json_encode($Result_data);/***
													
													$Status_array = array("status" => "1001", "Result_data" => $Result_data, "status_message" => "Success");
													echo json_encode($Status_array);die;
												}
												else
												{
													echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
												}
											} */
										}
										else //*** not coalition company *****
										{
											
											if($View == 1 || $View == 3)
											{
												if($_REQUEST['From_date'] != "" && $_REQUEST['Till_date'] != "")
												{
													$query1 = "SELECT Member1_enroll_id,Member2_enroll_id,Membership2_id,Benefit_description,Transaction_date,Bonus_points,Transaction_type_id,Item_code,Quantity,Shipping_points,Bill_no,Branch_code,Order_no,Voucher_no,Transaction_amount,Loyalty_points,Redeem_points,Order_status, Voucher_status, Delivery_method,Transfer_points 
														   FROM lsl_transaction 
														   WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
														   AND Transaction_date between '".$From_date."'
														   AND '".$Till_date."'
														   AND Transaction_status='0'
														   AND Company_id = ".$Company_id." 
															AND (Transaction_type_id = 1 OR Transaction_type_id = 2 OR Transaction_type_id = 3 OR Transaction_type_id = 4 OR Transaction_type_id = 6 OR Transaction_type_id = 7 OR Transaction_type_id = 8 OR Transaction_type_id = 14 OR Transaction_type_id = 30)
																 
															   ORDER BY Transaction_date DESC ".$LIMIT." ";
												}
												else
												{
													$query1 = "SELECT Member1_enroll_id,Member2_enroll_id,Membership2_id,Benefit_description,Transaction_date,Bonus_points,Transaction_type_id,Item_code,Quantity,Shipping_points,Bill_no,Branch_code,Order_no,Voucher_no,Transaction_amount,Loyalty_points,Redeem_points,Order_status, Voucher_status, Delivery_method,Transfer_points 
														   FROM lsl_transaction 
														   WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
														   AND Transaction_status='0'
														   AND Company_id = ".$Company_id." 
															AND (Transaction_type_id = 1 OR Transaction_type_id = 2 OR Transaction_type_id = 3 OR Transaction_type_id = 4 OR Transaction_type_id = 6 OR Transaction_type_id = 7 OR Transaction_type_id = 8 OR Transaction_type_id = 14 OR Transaction_type_id = 30)
															ORDER BY Transaction_date DESC ".$LIMIT." ";
												}
												
												$result1 = mysqli_query($conn,$query1);
												$Result_count = mysqli_num_rows($result1);
												
												if($Result_count > 0)
												{
													while($rows1 = mysqli_fetch_array($result1))
													{
															$query2 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$rows1['Transaction_type_id']."' ";
															$result2 = mysqli_query($conn,$query2);
															$Transaction_type_details = mysqli_fetch_array($result2);

															if($rows1['Transaction_type_id'] == 3 && $rows1['Member2_enroll_id'] != "" && $rows1['Membership2_id'])
															{
																$Transaction_type_name = "Transfer Received";
															}
															else
															{
																$Transaction_type_name = $Transaction_type_details["Transaction_type_name"];
															}

															if($rows1['Transaction_type_id'] == 2)
															{
																/*if($rows1["Delivery_method"]=="2")
																{
																	$Total_reddem23 = $rows1['Redeem_points'] * $rows1['Quantity'];
																	$Total_redeem_points = $Total_reddem23 + $rows1['Shipping_points'];
																}
																else
																{
																	$Total_redeem_points = $rows1['Redeem_points'] * $rows1['Quantity'];
																}*/

																$Total_redeem_points = $rows1['Redeem_points'] * $rows1['Quantity'];
																$Points_used = $Total_redeem_points;
																$Points_gained = 0;
															}
															else
															{
																$Total_redeem_points = $rows1['Redeem_points'];
																$Points_used = $Total_redeem_points;
																
																if($rows1['Loyalty_points'] > 0 && $rows1['Transaction_type_id'] == 1)
																{
																	$Points_gained = $rows1['Loyalty_points'];
																}
																else
																{
																	$Points_gained = $rows1['Bonus_points'];
																}
															}

															if($rows1['Item_code'] == '' || $rows1['Item_code'] == null)
															{
																$Item_name = " - ";
															}
															else
															{
																if ($rows1['Transaction_type_id'] == 2 )
																{
																	//$query3 = "SELECT Merchandize_item_name FROM lsl_company_merchandise_catalogue WHERE Company_id = ".$Company_id." AND Company_merchandize_item_code ='".$rows1['Item_code']."' AND Active_flag=1 ";
																	$query3 = "SELECT Merchandize_item_name FROM lsl_company_merchandise_catalogue WHERE Company_id = ".$Company_id." AND Company_merchandize_item_code ='".$rows1['Item_code']."' ";
																	$result3 = mysqli_query($conn,$query3);
																	$rows2 = mysqli_fetch_array($result3);
																	$Count_item = mysqli_num_rows($result3);
																	
																	if($Count_item > 0)
																	{
																		$Item_name = $rows2["Merchandize_item_name"];
																	}
																	else
																	{
																		$Item_name = " - ";
																	}
																}
																else if ($rows1['Transaction_type_id'] == 1)
																{
																	if($Company_details['Company_type'] == "Bank")
																	{
																		$query4 = "SELECT Item_name FROM lsl_pos_inventory_master 
																				   WHERE Item_code ='".$rows1['Item_code']."'
																				   AND Company_id = '".$Company_id."' ";
																	}
																	else
																	{
																		$query4 = "SELECT Item_name FROM lsl_branch_pos_inventory_master 
																				   WHERE Item_code ='".$rows1['Item_code']."'
																				   AND Branch_code = '".$rows1['Branch_code']."'
																				   AND Company_id = '".$Company_id."'";
																	}
																	$result4 = mysqli_query($conn,$query4);
																	$rows3 = mysqli_fetch_array($result4);
																	$Count_item = mysqli_num_rows($result3);
																	
																	if($Count_item > 0)
																	{
																		$Item_name = $rows3["Item_name"];
																	}
																	else
																	{
																		$Item_name = " - ";
																	}
																}
																else
																{
																	$Item_name = " - ";
																}
															}
															//echo "Item_name---".$Item_name."<br>";
															
															if($rows1['Transaction_type_id'] == 3 && $rows1['Member2_enroll_id'] != "" && $rows1['Membership2_id'])
															{
																$result79 = lslDB::getInstance()->get_cust_detail99($rows1['Member2_enroll_id']);
																$rows569 = mysqli_fetch_array($result79);
																$Description = "Received From-".$rows569['Membership_id'];
															}
															else if($rows1['Transaction_type_id'] == 3 || $rows1['Transaction_type_id'] == 4)
															{
																$Description = $rows1['Benefit_description'];
															}
															else if($rows1['Transaction_type_id'] == 2 || $rows1['Transaction_type_id'] == 1)
															{
																$Description = $Item_name;

															}
															else if($rows1['Transaction_type_id'] == 6)
															{
																if($rows1['Member2_enroll_id'] == $member_details['Enrollment_id'])
																{
																	$result7 = lslDB::getInstance()->get_cust_detail99($rows1['Member1_enroll_id']);
																	$rows56 = mysqli_fetch_array($result7);
																	$Description = "Received From-".$rows56['Membership_id'];
																}
																else
																{
																	$result7 = lslDB::getInstance()->get_cust_detail99($rows1['Member2_enroll_id']);
																	$rows56 = mysqli_fetch_array($result7);
																	$Description = "Transferred To-".$rows56['Membership_id'];
																}
															}
															else
															{
																$Description = " - ";
															}

															if($rows1['Bill_no'] == '0' || $rows1['Bill_no'] == '') { $Bill_no = " - "; } else { $Bill_no = $rows1['Bill_no']; }

															if($rows1['Order_no'] == '0' || $rows1['Order_no'] == '') { $Order_no = " - ";} else { $Order_no = $rows1['Order_no']; }

															if($rows1['Voucher_no'] == '0' || $rows1['Voucher_no'] == '') { $Voucher_no = " - ";} else { $Voucher_no = $rows1['Voucher_no']; }

															$Transaction_amount = $rows1['Transaction_amount'];
															
															$Loyalty_points = $rows1['Loyalty_points'];
															$Bonus_points = $rows1['Bonus_points'];
															$Quantity = $rows1['Quantity'];
															
															/*if($rows1['Loyalty_points'] > 0 && $rows1['Transaction_type_id'] == 1)
															{
																$Points_gained = $Loyalty_points;
															}
															else if($rows1['Bonus_points'] > 0 && $rows1['Transaction_type_id'] != 2)
															{
																$Points_gained = $Bonus_points;
															}
															else
															{
																$Points_gained = 0;
															}*/

															if($rows1['Order_status'] == '0')
															{
																$Order_status = " - ";
															}
															else
															{
																$sql3 = "SELECT * FROM lsl_codedecode_master WHERE Code_id ='".$rows1['Order_status']."' ";
																$result3 = mysqli_query($conn,$sql3);
																while($rows3 = mysqli_fetch_array($result3)){ $Order_status = $rows3["Decode_description"]; }
																$Order_status = $Order_status;
															}

															if($rows1['Voucher_status'] == 0)
															{
																$Voucher_status = " - ";
															}
															else
															{
																$sql4 = "SELECT * FROM lsl_codedecode_master WHERE Code_id ='".$rows1['Voucher_status']."' ";
																$result4 = mysqli_query($conn,$sql4);
																while($rows4 = mysqli_fetch_array($result4)){ $Voucher_status = $rows4["Decode_description"]; }
																$Voucher_status = $Voucher_status;
															}

															if($rows1["Delivery_method"]=="1")
															{
																$Delevery_flag = "Redeemed in Person";
															}
															else if($rows1["Delivery_method"]=="2")
															{
																$Delevery_flag = "To be Delivered";
															}
															else if($rows1["Delivery_method"]== "3")
															{
																$Delevery_flag = "Both";
															}
															else
															{
																$Delevery_flag = " - ";
															}

															$Transfer_points = $rows1['Transfer_points'];
															
															if($Transfer_points != 0 && $Transfer_points > 0)
															{
																$Points_used = $Transfer_points;
															}
															
															if($View == 3)
															{
																if($Points_used > 0 || $Points_gained > 0)
																{
																	$Result_data[] = array
																					(
																						"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																						"Transaction_type_name" => $Transaction_type_name,
																						"Description" => $Description,                                                                                
																						"Order_no" => $Order_no,                                                                                
																						"Points_gained" => "$Points_gained",
																						"Points_used" => "$Points_used"
																					);
																}
															}
															else
															{
																$Result_data[] = array
																				(
																					"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																					"Transaction_type_name" => $Transaction_type_name,
																					"Description" => $Description,
																					"Bill_no" => $Bill_no,
																					"Order_no" => $Order_no,
																					"Voucher_no" => $Voucher_no,
																					"Transaction_amount" => "$Transaction_amount",
																					"Loyalty_points" => "$Loyalty_points",
																					"Bonus_points" => "$Bonus_points",
																					"Total_redeem_points" => "$Total_redeem_points",
																					"Quantity" => $Quantity,
																					"Order_status" => $Order_status,
																					"Voucher_status" => $Voucher_status,
																					"Delevery_flag" => $Delevery_flag,
																					"Transfer_points" => "$Transfer_points"
																				);
															}
													}
													
													$p_query1 = "SELECT Transaction_date,Transaction_type_id,Member1_enroll_id,Membership1_id,Order_no,Order_status,Total_shipping_points,Total_shipping_cost,Total_shipping_value "
																. "FROM lsl_transaction as trn "
																. "WHERE  Transaction_type_id='2' "
																. "AND Delivery_method='2' "
																. "AND trn.Company_id='".$Company_id."' "
																. "AND Company_shipping_paid_flag='0' "
																. "AND trn.Transaction_date BETWEEN '".$From_date."' AND '".$Till_date."' "
																. "AND Order_status IN (148,149,150,151) GROUP BY Order_no";
																
													$p_result1 = mysqli_query($conn,$p_query1);
													while($p_row1 = mysqli_fetch_array($p_result1))
													{
														$Shipping_payble_to_partner = $p_row1['Total_shipping_points'];
														
														$query2 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$p_row1['Transaction_type_id']."' ";
														$result2 = mysqli_query($conn,$query2);
														$Transaction_type_details = mysqli_fetch_array($result2);
														$Transaction_type_name = $Transaction_type_details["Transaction_type_name"];
														
														$Description = "Shipping for Order no. ".$p_row1['Order_no'];
														
														$p_query3 = "SELECT Count(*) as order_quantity "
																	. "FROM lsl_transaction "
																	. "WHERE Transaction_type_id='2' "
																	. "AND Delivery_method='2' "
																	. "AND Company_id='".$Company_id."' "
																	. "AND Order_no='".$p_row1['Order_no']."' ";
																	
														$p_row3 = mysqli_fetch_array(mysqli_query($conn,$p_query3));
														$order_quantity = $p_row3['order_quantity'];
															
														if($Shipping_payble_to_partner > 0)
														{
															if($View == 3)
															{
																$Shipping_result_data[] = array
																						(
																							"Transaction_date" => date("Y-m-d",strtotime($p_row1["Transaction_date"])),
																							"Transaction_type_name" => $Transaction_type_name,
																							"Description" => $Description,                                                                                
																							"Order_no" => $p_row1['Order_no'],                                                                                
																							"Points_gained" => "0",
																							"Points_used" => "$Shipping_payble_to_partner"
																						);
															}
															else
															{
																$Shipping_result_data[] = array
																							(
																								"Transaction_date" => date("Y-m-d",strtotime($rows1["Transaction_date"])),
																								"Transaction_type_name" => $Transaction_type_name,
																								"Description" => $Description,
																								"Bill_no" => $Bill_no,
																								"Order_no" => $p_row1['Order_no'],
																								"Voucher_no" => '-',
																								"Transaction_amount" => '-',
																								"Loyalty_points" => '-',
																								"Bonus_points" => '-',
																								"Total_redeem_points" => "$Shipping_payble_to_partner",
																								"Quantity" => $order_quantity,
																								"Order_status" => 'Delivered',
																								"Voucher_status" => '-',
																								"Delevery_flag" => 'To be Delivered',
																								"Transfer_points" => ''
																							);
															}
														}
													}
													
													/*$Status_array = array("status" => "1001");
													$Result_data = array_merge($Result_data,$Status_array);
													echo json_encode($Result_data);*/
													
													$Status_array = array("status" => "1001", "Result_data" => $Result_data, "Shipping_result_data" => $Shipping_result_data, "status_message" => "Success");
													echo json_encode($Status_array);die;
												}
												else
												{
													echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
												}
											}
											else
											{
												if($_REQUEST['From_date'] != "" && $_REQUEST['Till_date'] != "")
												{
													$sql = "SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id <> 3
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id				
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Member2_enroll_id <> ''
																	AND Membership2_id <> ''
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND	Transaction_date between '".$From_date."' AND '".$Till_date."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id = 3
																	AND Member2_enroll_id = ''
																	AND Membership2_id = ''
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id ".$LIMIT." ";
												}
												else
												{
													$sql = "SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id <> 3
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id				
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Member2_enroll_id <> ''
																	AND Membership2_id <> ''
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id
															UNION
																	SELECT Company_id,Transaction_date,Member2_enroll_id,Membership2_id,Transaction_type_id, 
																	SUM(Transaction_amount) as Tot_Transaction_amount,SUM(Bonus_points) as Bonus_points,SUM(Loyalty_points) as Tot_Loyalty_points ,SUM(Redeem_points) as Tot_Redeem_points,SUM(Transfer_points)	FROM lsl_transaction 
																	WHERE Member1_enroll_id='".$member_details['Enrollment_id']."' 
																	AND Transaction_status IN (1,0)
																	AND Transaction_type_id = 3
																	AND Member2_enroll_id = ''
																	AND Membership2_id = ''
																	AND	Company_id = ".$Company_id."
																	Group By Transaction_type_id ".$LIMIT." ";
												}
												$result = mysqli_query($conn,$sql);
												$Result_count = mysqli_num_rows($result);
												
												if($Result_count > 0)
												{
													while($rows = mysqli_fetch_array($result))
													{
														$sql1 = "SELECT * FROM lsl_transaction_type_master WHERE Transaction_type_id ='".$rows['Transaction_type_id']."' ";
														$result1 = mysqli_query($conn,$sql1);
														while($rows1 = mysqli_fetch_array($result1))
														{ 
															if($rows['Transaction_type_id'] == 3 && $rows['Member2_enroll_id'] != "" && $rows['Membership2_id'])
															{
															   $Transaction_type_name = 'Points Transfer (Received)'; 
															}
															else
															{
																$Transaction_type_name = $rows1["Transaction_type_name"]; 
															}
														}

														$Total_transaction_amount = $rows['Tot_Transaction_amount'];
														$Total_loyalty_points = $rows['Tot_Loyalty_points'];
														$Total_bonus_points = $rows['Bonus_points'];
														$Total_redeem_points = $rows['Tot_Redeem_points'];
														$Total_transfer_points = $rows['SUM(Transfer_points)'];

														$Result_data[] = array
																		(
																			"Transaction_type_name" => $Transaction_type_name,
																			"Transaction_amount" => $Total_transaction_amount,
																			"Loyalty_points" => "$Total_loyalty_points",
																			"Bonus_points" => "$Total_bonus_points",
																			"Total_redeem_points" => "$Total_redeem_points",
																			"Transfer_points" => "$Total_transfer_points"
																		);
													}
													/*$Status_array = array("status" => "1001");
													$Result_data = array_merge($Result_data,$Status_array);
													echo json_encode($Result_data);*/
													
													$Status_array = array("status" => "1001", "Result_data" => $Result_data, "status_message" => "Success");
													echo json_encode($Status_array);die;
												}
												else
												{
													echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
												}
											}
										}
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));die;
                                    }
                                }
                            }
                        }
                    }
                    /************************************My Statement********************************/
                    
                    /************************************Survey********************************/
                    if($API_flag == 16)  //***fetch All Survey
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $todays = date('Y-m-d');
                                    
                                    $query1 = "SELECT DISTINCT ST.Survey_id,ST.Survey_name,ST.Start_date,ST.End_date
                                                FROM lsl_survey_structure_master as ST,lsl_survey_send as SS
                                                WHERE ST.Survey_id = SS.Survey_id
                                                AND SS.Enrollment_id=".$member_details['Enrollment_id']."
                                                AND SS.Company_id=".$Company_id." ";
                                    
                                    $result1 = mysqli_query($conn,$query1);
                                    $Result_count1 = mysqli_num_rows($result1);
                                    
                                    if($Result_count1 > 0)
                                    {
                                        while($row1 = mysqli_fetch_array($result1))
                                        {
                                            if(($todays >= $row1['Start_date']) && ($todays <= $row1['End_date']))
                                            {
                                                $Survey_details[] = array(
                                                                    'Survey_id' => $row1['Survey_id'],
                                                                    'Survey_name' => $row1['Survey_name']
                                                                );
                                            }                                            
                                        }
                                        
											if($Survey_details != NULL)
											{
												/*$Status_array = array("status" => "1001");
												$Survey_details = array_merge($Survey_details,$Status_array);
												echo json_encode($Survey_details);*/
												
												$Status_array = array("status" => "1001", "Survey_details" => $Survey_details, "status_message" => "Success");
												echo json_encode($Status_array);
											}
											else
											{
												echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
											}
                                        
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 17)  //***Fetch all Questions of selected survey
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Question_details = array();
                            //$Option_values_details = array();
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active"));
                                }
                                else
                                {
                                    $Survey_id = $_REQUEST['Survey_id'];
                                    $quetion_count = 1;
                                    
                                    $query = "SELECT * FROM lsl_questionaire_master INNER JOIN lsl_survey_structure_master
                                                ON lsl_survey_structure_master.Survey_id=lsl_questionaire_master.Survey_id
                                                INNER JOIN lsl_multiple_choice ON lsl_multiple_choice.Choice_id=lsl_questionaire_master.Choice_id
                                                WHERE lsl_questionaire_master.Survey_id=".$Survey_id;

                                    $query1 = "SELECT * FROM lsl_questionaire_master INNER JOIN lsl_survey_structure_master
                                                ON lsl_survey_structure_master.Survey_id=lsl_questionaire_master.Survey_id
                                                WHERE lsl_questionaire_master.Response_type ='2' 
                                                AND lsl_questionaire_master.Survey_id=".$Survey_id;

                                    $result = mysqli_query($conn,$query);
                                    $result1 = mysqli_query($conn,$query1);
                                    
                                    //$Result_count1 = mysqli_num_rows($result);
                                    $Result_count1 = mysqli_num_rows($result) + mysqli_num_rows($result1);
                                    
                                    if($Result_count1 > 0)
                                    {
                                        while($row1 = mysqli_fetch_array($result))
                                        {
                                            $question_id = $row1['Question_id'];
                                            $Qustion = $row1['Question'];
                                            $response_type = $row1['Response_type'];
                                            $choice_id = $row1['Choice_id'];
                                            $Option_value_string = "";
                                            $Option_values_details = array();
                                            
                                            if($response_type == 1)
                                            {                                                
                                                $sql = "SELECT option_values,value_id FROM lsl_multiple_choice_values
                                                        WHERE choice_id=".$choice_id;
                                                $result2 = mysqli_query($conn,$sql);
                                                $i = 0;
                                                while($row3 = mysqli_fetch_array($result2))
                                                {
                                                    $Option_values_details[$row3['value_id']] = $row3['option_values'] ;
                                                    $i++;
                                                    
                                                    //$Option_value_string .= $row3['option_values'].",";                                                    
                                                    //$Option_value_id_string .= $row3['value_id'].",";                                                    
                                                }
                                            }                                            
                                            $Question_details[] = array(
                                                        'Question_no' => $quetion_count,
                                                        'Question_id' => $row1['Question_id'],
                                                        'Question' => $row1['Question'],
                                                        'Response_type' => $row1['Response_type'],
                                                        'Value_id' => $Option_values_details
                                                    );    //'Option_values' => $Option_value_string,
                                            
                                            $quetion_count++;
                                            
                                            //echo "Question_id----".$row1['Question_id'];
                                            //break;
                                        }                                        
                                        while($row2 = mysqli_fetch_array($result1))
                                        {
                                            $question_id1 = $row2['Question_id'];
                                            $Qustion1 = $row2['Question'];
                                            $response_type1 = $row2['Response_type'];
                                            $Option_value_string1 = "";
                                            $Option_values_details1 = array();											
                                            if($response_type1 == 2)
                                            {         
												$Option_values_details1[-1]="";                                       
                                                $Question_details[] = array(
                                                        'Question_no' => $quetion_count,
                                                        'Question_id' => $row2['Question_id'],
                                                        'Question' => $row2['Question'],
                                                        'Response_type' => $row2['Response_type'],
                                                        'Value_id' => $Option_values_details1
                                                    );                                            
                                                $quetion_count++;
                                            }
                                        }
                                        
                                        /*$Status_array = array("status" => "1001", "Survey_id" => $Survey_id, "Result_count" => $Result_count1);
                                        $Question_details = array_merge($Question_details,$Status_array);
                                        echo json_encode($Question_details);*/
                                        
                                        $Status_array = array("status" => "1001", "Survey_id" => $Survey_id, "Result_count" => $Result_count1, "Question_details" => $Question_details, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 18)  //***Insert Survey Response
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Current_balance = $member_details['Current_balance'];
                            $api_error_date = date("Y-m-d H:i:s");
                            $Request_data = json_encode($_REQUEST);
                            
                            if($member_details == NULL)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2003", "status_message" => "Membership ID not found"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active"))."')";
                                    $api_error_result = mysqli_query($conn, $api_error_sql);
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($_REQUEST['Survey_id'] == "" || $_REQUEST['Survey_id'] == NULL)
                                    {
                                        $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"))."')";
                                        $api_error_result = mysqli_query($conn, $api_error_sql);
                                        echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                                    }
                                    else
                                    {
                                        $mv_create_user_id = $member_details['Enrollment_id'];
                                        $mv_create_date = date("Y-m-d H:i:s");
                                        $Company_id = $Company_id;
                                        $enroll_id = $member_details['Enrollment_id'];
                                        $user_id = $member_details['Enrollment_id'];
                                        $survey_id = $_REQUEST['Survey_id'];
                                        $total_count = $_REQUEST['total_count'];
                                        
                                        /*---------------------------------Survey Points--------------------------*/
                                        $result712 = lslDB::getInstance()->get_company_details($Company_id);
                                        $Company_details = mysqli_fetch_array($result712);
                                        $Survey_reward = $Company_details['Survey_reward'];

                                        $Suevey_details = lslDB::getInstance()->get_survey_details($survey_id,$Company_id);
                                        $Suevey = mysqli_fetch_assoc($Suevey_details);
                                        $Survey_points = $Suevey['Survey_points'];
                                        $No_of_questions = $Suevey['No_of_questions'];
                                        $Survey_name = "Survey ".$Suevey['Survey_name'];
                                        /*---------------------------------Survey Points--------------------------*/

                                        /*********************Code for Localhost*********************
                                            $multiple_choice_questionID = $_REQUEST['questionID1'];
                                            $text_questionID = $_REQUEST['questionID2'];

                                            foreach($multiple_choice_questionID as $multiple_choice_questions)
                                            {
                                                $multiple_choice_questionID = explode(",",$multiple_choice_questions);
                                            }

                                            foreach($text_questionID as $text_questions)
                                            {
                                                $text_questionID = explode(",",$text_questions);
                                            }

                                            foreach($multiple_choice_questionID as $multiple_choice_questions)
                                            {
                                                $multiple_choice_response[] = $_REQUEST['ans'.$multiple_choice_questions];
                                            }

                                            foreach($text_questionID as $text_questions)
                                            {
                                                $text_based_response[] = $_REQUEST['text_ans'.$text_questions];
                                            }

                                            $multiple_choice_response_count = count(array_filter($multiple_choice_response));
                                            $text_based_response_count = count(array_filter($text_based_response));
                                            $total_response_count = $multiple_choice_response_count + $text_based_response_count;
                                        /*********************Code for Localhost*********************/
                                        
                                        /*$test_array[] = array("Question_id" => '78', "Response" => '62'); 
                                        $test_array[] = array("Question_id" => '79', "Response" => '41'); 
                                        $test_array[] = array("Question_id" => '80', "Response" => '50'); 
                                        $test_array[] = array("Question_id" => '81', "Response" => 'zfd'); 
                                        $test_array[] = array("Question_id" => '82', "Response" => 'sdfsdf'); 
                                        $test_array = json_encode($test_array);
                                        $json_array3 = $test_array;
                                        $json_array3 = json_decode($json_array3);*/
                                        
                                        $Survey_response = json_decode($_REQUEST['Survey_response'],true);    
                                        //$json_array3 = json_decode($Survey_response);
                                        
                                          //echo "---json_encode Survey_response is-----".$Survey_response[0]."----<br>";
                                          
                                        //print_r($Survey_response);
                                        //$Response_Count  = substr_count($Survey_response[0],"Response");
										$Response_Count  = count($Survey_response);
                                        
										//echo "<br>".$Response_Count."...<br>";
                                       // $json_array3 = array_count_values($Survey_response);
                                        
                                        //   echo "---count values  array is---------<br>";
                                          
                                     //   print_r($json_array3);
                                        
                                       // $json_array33[] = json_decode($Survey_response,true);
                                        
                                       //  echo "---json_decode json_array33 is---------<br>";
                                          
                                      //  print_r($json_array33);
                                        
                                       // $Response_Count  = count($Survey_response);
                                        
                                       
                                    //    echo "<br><br>survey_id----------".$survey_id."<br>";
                                    //    echo "json_array3----------<br><pre>";
                                     //   var_dump($json_array3);                                        
                                     //   echo "Response_Count----------".$Response_Count."<br>";
                                       // echo "No_of_questions----------".$No_of_questions."<br>";die;
                                        
                                        
                                        if($No_of_questions != $Response_Count)
                                        //if($total_count != $total_response_count)   //***code for localhost
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2021", "status_message" => "Please Answer All Questions"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2021", "status_message" => "Please Answer All Questions"));
                                        }
                                        else
                                        {
                                            /*********************New Code***********************/
                                                /*foreach($multiple_choice_questionID as $multiple_choice_questions)
                                                {
                                                    $response2 = $_REQUEST['ans'.$multiple_choice_questions];
                                                    $questionid = $multiple_choice_questions;                                            
                                                    $json_array[] = array($questionid => $response2);
                                                }

                                                foreach($text_questionID as $text_questions)
                                                {
                                                    $questionid1 = $text_questions;
                                                    $response1 = $_REQUEST['text_ans'.$text_questions];
                                                    $json_array[] = array($questionid1 => $response1);
                                                }
                                                
                                                $json_array2 = json_encode($json_array);                                                
                                                $json_array3 = json_decode($json_array2);*/
                                                
                                                foreach($json_array3 as $json)
                                                //{
                                                    //foreach($json_array3 as $key => $value)
                                                    {
                                                        if(is_numeric($json->Response))
                                                        {
                                                            //$sql = "SELECT Choice_id FROM lsl_multiple_choice_values WHERE Value_id =".$value;
                                                            $sql = "SELECT Choice_id FROM lsl_multiple_choice_values WHERE Value_id =".$json->Response;
                                                            $result1 = mysqli_query($conn,$sql);
                                                            $Choice_id_details = mysqli_fetch_array($result1);
                                                            $Choice_id = $Choice_id_details['Choice_id'];
                                                            /*$response1 = '';    $response2 = $value;*/
                                                            $response1 = '';    $response2 = $json->Response;
                                                        }
                                                        else
                                                        {
                                                            /*$Choice_id = '';    $response2 = '';    $response1 = $value;*/
                                                            $Choice_id = '';    $response2 = '';    $response1 = $json->Response;
                                                        }
                                                        //$response_master = lslDB::getInstance()->insert_response($mv_create_user_id,$Company_id,$survey_id,$key,$response1,$response2,$Choice_id,$mv_create_user_id,$mv_create_date,$mv_create_user_id,$mv_create_date);
                                                        $response_master = lslDB::getInstance()->insert_response($mv_create_user_id,$Company_id,$survey_id,$json->Question_id,$response1,$response2,$Choice_id,$mv_create_user_id,$mv_create_date,$mv_create_user_id,$mv_create_date);
                                                    }
                                                //}
                                            /*********************New Code***********************/
                                          //  die;
                                            /*foreach($multiple_choice_questionID as $multiple_choice_questions)
                                            {
                                                $response2 = $_REQUEST['ans'.$multiple_choice_questions];
                                                $questionid = $multiple_choice_questions;
                                                $sql = "SELECT Choice_id FROM lsl_multiple_choice_values WHERE Value_id =".$response2;
                                                $result1 = mysqli_query($conn,$sql);                                                
                                                
                                                while($row1 = mysqli_fetch_array($result1))
                                                {
                                                    $response_master = lslDB::getInstance()->insert_response($mv_create_user_id,$Company_id,$survey_id,$questionid,$response1,$response2,$row1['Choice_id'],$mv_create_user_id,$mv_create_date,$mv_create_user_id,$mv_create_date);
                                                }
                                            }
                                            
                                            foreach($text_questionID as $text_questions)
                                            {
                                                $questionid1 = $text_questions;
                                                $response1 = $_REQUEST['text_ans'.$text_questions];
                                                $response2 = '';    $choice_id = '';
                                                $response_master = lslDB::getInstance()->insert_response($mv_create_user_id,$Company_id,$survey_id,$questionid1,$response1,$response2,$choice_id,$mv_create_user_id,$mv_create_date,$mv_create_user_id,$mv_create_date);
                                            }*/
                                            
                                            //$update_survey_send = lslDB::getInstance()->update_survey_send($mv_create_user_id,$Company_id,$survey_id);
                                            
                                            if($Survey_reward == 1 && $Survey_points > 0)
                                            {
                                                /*---------------------------------Insert Transaction Of Survey Points--------------------------*/
                                                $Transaction_type_id = '29';
                                                $sql4 = "INSERT INTO lsl_transaction
                                                                (Transaction_type_id,Company_id,Member1_enroll_id,Membership1_id,Transaction_date,Bonus_points,Remarks,Create_user_id,Create_date)
                                                                VALUES('".$Transaction_type_id."','".$Company_id."','".$mv_create_user_id."','".$Membership_id."','".$mv_create_date."','".$Survey_points."','".$Survey_name."','".$mv_create_user_id."','".$mv_create_date."')";
                                                $result4 = mysqli_query($conn,$sql4);
                                                /*---------------------------------Insert Transaction Of Survey Points--------------------------*/
                                                
                                                /*---------------------------------Update Customer Balance--------------------------*/
                                                $New_Current_balance = $Current_balance + $Survey_points;
                                                $sql3 = "UPDATE lsl_enrollment_master SET Current_balance='".$New_Current_balance."'
                                                                WHERE Enrollment_id='".$mv_create_user_id."' ";
                                                $result3 = mysqli_query($conn,$sql3);
                                                /*---------------------------------Update Customer Balance--------------------------*/
                                                
                                                /*---------------------------------Send Survey Bonus Notification--------------------------*/
                                                $Template_type_id = 82;     $Email_Type = 529;  //****Survey Bonus**
                                                $survey_bonus = lslDB::getInstance()->send_survey_bonus_template($mv_create_user_id,$Company_id,$survey_id,$Survey_points,$Email_Type,$Template_type_id);
                                                /*---------------------------------Send Survey Bonus Notification--------------------------*/
                                            }
                                            
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "1001", "status_message" => "Success"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"))."')";
                            $api_error_result = mysqli_query($conn, $api_error_sql);
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Survey********************************/
                    
                    /************************************Promo Code********************************/
                    if($API_flag == 19)  //***Insert and Apply Promo Code
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Promo_code1 = trim(string_decrypt($_REQUEST['Promo_code'], $key, $iv));
                            $Promo_code = preg_replace("/[^(\x20-\x7f)]*/s", "", $Promo_code1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Communication_flag = $member_details['Communication_flag'];
                            $Communication_type = $member_details['Communication_type'];
                            $Current_balance = $member_details['Current_balance'];
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Promo_code == "")
                                    {
                                        echo json_encode(array("status" => "2022", "status_message" => "Kindly Enter Promo Code"));
                                    }
                                    else
                                    {
                                        $todays = date("Y-m-d");
                                        $mv_create_user_id = $member_details['Enrollment_id'];
                                        $mv_create_date = $todays;                                        
                                        $Company_id = $Company_id;
                                        
                                        /**********************************************Check For 3 Invalid Promo Codes****************************************/
                                        $SQL22 = "SELECT COUNT(Enrollment_id) FROM lsl_promo_invalid_data WHERE Enrollment_id='".$mv_create_user_id."' AND Create_date >= '".$todays."' ";
                                        $RESULT22 = mysqli_fetch_array(mysqli_query($conn,$SQL22));
                                        
                                        if($RESULT22['COUNT(Enrollment_id)'] >= 3)
                                        {
                                            echo json_encode(array("status" => "2024", "status_message" => "Invalid Promo Code limit reached"));
                                        }
                                        /**********************************************Check For 3 Invalid Promo Codes****************************************/
                                        else if($RESULT22['COUNT(Enrollment_id)'] == 0)
                                        {
                                            $SQL33 = "DELETE FROM lsl_promo_invalid_data WHERE Enrollment_id='".$mv_create_user_id."' ";
                                            $result23= mysqli_query($conn,$SQL33);
                                            
                                            $check_promo_code = lslDB::getInstance()->check_promo_code($Company_id,$Promo_code);
                                            $count = mysqli_num_rows($check_promo_code );
                                            $rec = mysqli_fetch_array($check_promo_code);

                                            $sql = "SELECT To_date FROM lsl_campaign_master WHERE Campaign_id='".$rec['Campaign_id']."' ";
                                            $check_promo_validity = mysqli_fetch_array(mysqli_query($conn,$sql));

                                            if($count > 0 && ($todays <= $check_promo_validity['To_date']) )
                                            {
                                                /************************Update Current Balance of Member************************/
                                                    $avail_bal = $Current_balance + $rec["Points"];
                                                    $update_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$mv_create_user_id,$avail_bal);
                                                /**********************************************************************************/

                                                /**************************Insert transaction********************************/
                                                    $Transaction_type_id="13"; //Promo Code {lsl_transaction_type_master}
                                                    $insert_promo_code = lslDB::getInstance()->insert_promo_code_transaction($Transaction_type_id,$Company_id,$mv_create_user_id,$Membership_id,$mv_create_date,$rec["Points"],$mv_create_user_id,$mv_create_date);
                                                /**************************Insert transaction Ends********************************/

                                                /**************************Insert transaction Child********************************/
                                                    $sql45 = "SELECT * FROM lsl_campaign_master WHERE Campaign_id='".$rec['Campaign_id']."' ";
                                                    $result45 = mysqli_query($conn,$sql45);
                                                    while($row45 = mysqli_fetch_array($result45))
                                                    {
                                                        $Campaign_type = $row45['Campaign_type'];
                                                        $Campaign_sub_type = $row45['Campaign_sub_type'];
                                                        $Sweepstake_id = $row45['Sweepstake_id'];
                                                        $Sweepstake_ticket_limit = $row45['Sweepstake_ticket_limit'];
                                                    }

                                                    $myquery52 = "Insert into lsl_transaction_child(Enrollment_id,Transaction_id,Campaign_id,Campaign_type,Campaign_sub_type,Reward_points,Company_id,Date)
                                                                  values('".$mv_create_user_id."','".$insert_promo_code."','".$rec['Campaign_id']."','".$Campaign_type."','".$Campaign_sub_type."','".$rec["Points"]."','".$Company_id."','".$todays."')";
                                                    $run_query = mysqli_query($conn,$myquery52);
                                                /**************************Insert transaction Child********************************/

                                                /************************Update Promo Campaign ************************/
                                                    $update_promo_campaign = lslDB::getInstance()->update_promo_campaign($Company_id,$Promo_code);
                                                /************************Update Promo Campaign ************************/

                                                /****************************************Sweepstake Link To Promo************************************/
                                                    $cmp_sweepstake_validation = lslDB::getInstance()->cmp_sweepstake_validation($rec['Campaign_id'],$Sweepstake_id,$Company_id,$mv_create_user_id,$todays,$Sweepstake_ticket_limit,$mv_create_user_id,$mv_create_date);
                                                /****************************************Sweepstake Link To Promo************************************/

                                                /******Promo Code Email Notification********/
                                                    if($Communication_flag == 1)
                                                    {
                                                        if($Communication_type == 1 || $Communication_type == 3)
                                                        {
                                                            $Transaction_date=date("Y-m-d");    $Template_type_id = 34;     $Email_type = 188;	
                                                            $promo_code_template = lslDB::getInstance()->send_promo_code_template($mv_create_user_id,$Promo_code,$rec["Points"],$avail_bal,$Company_id,$Email_type,$Template_type_id,$Transaction_date);
                                                        }

                                                        /*********************Send SMS******************/
                                                        if($Communication_type == 2 || $Communication_type == 3)
                                                        {
                                                            $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                            $company_detail=mysqli_fetch_array($get_company_details);
                                                            $Promo_code_sms = $company_detail['Promo_code_sms'];				
                                                            $SMS_Type = 188;
                                                            $Template_smstype_id = 34;
                                                            if($Promo_code_sms == 1)
                                                            {
                                                                $transferpoints_to_smstemplate = lslDB::getInstance()->send_promo_code_smstemplate($mv_create_user_id,$Promo_code,$rec["Points"],$avail_bal,$Company_id,$SMS_Type,$Template_smstype_id,$Transaction_date); 
                                                            }
                                                        }
                                                        /*********************Send SMS Ends*************/
                                                    }
                                                /******Promo Code Email Notification********/

                                                echo json_encode(array("status" => "1001","Promo_points" => $rec["Points"], "status_message" => "Success"));
                                            }
                                            else
                                            {
                                                /**********************************************Check For 3 Invalid Promo Code****************************************/
                                                $SQL22 = "INSERT INTO lsl_promo_invalid_data(Company_id,Enrollment_id,Create_date) VALUES('".$Company_id."','".$mv_create_user_id."','".$mv_create_date."')";
                                                $RESULT22 = mysqli_query($conn,$SQL22);
                                                /**********************************************Check For 3 Invalid Promo Code****************************************/

                                                echo json_encode(array("status" => "2023", "status_message" => "Invalid Promo Code"));
                                            }
                                        }
                                        else
                                        {
                                            $check_promo_code = lslDB::getInstance()->check_promo_code($Company_id,$Promo_code);
                                            $count = mysqli_num_rows($check_promo_code );
                                            $rec = mysqli_fetch_array($check_promo_code);

                                            $sql = "SELECT To_date FROM lsl_campaign_master WHERE Campaign_id='".$rec['Campaign_id']."' ";
                                            $check_promo_validity = mysqli_fetch_array(mysqli_query($conn,$sql));

                                            if($count > 0 && ($todays <= $check_promo_validity['To_date']) )
                                            {
                                                /************************Update Current Balance of Member************************/
                                                    $avail_bal = $Current_balance + $rec["Points"];
                                                    $update_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$mv_create_user_id,$avail_bal);
                                                /**********************************************************************************/

                                                /**************************Insert transaction********************************/
                                                    $Transaction_type_id="13"; //Promo Code {lsl_transaction_type_master}
                                                    $insert_promo_code = lslDB::getInstance()->insert_promo_code_transaction($Transaction_type_id,$Company_id,$mv_create_user_id,$Membership_id,$mv_create_date,$rec["Points"],$mv_create_user_id,$mv_create_date);
                                                /**************************Insert transaction Ends********************************/

                                                /**************************Insert transaction Child********************************/
                                                    $sql45 = "SELECT * FROM lsl_campaign_master WHERE Campaign_id='".$rec['Campaign_id']."' ";
                                                    $result45 = mysqli_query($conn,$sql45);
                                                    while($row45 = mysqli_fetch_array($result45))
                                                    {
                                                        $Campaign_type = $row45['Campaign_type'];
                                                        $Campaign_sub_type = $row45['Campaign_sub_type'];
                                                        $Sweepstake_id = $row45['Sweepstake_id'];
                                                        $Sweepstake_ticket_limit = $row45['Sweepstake_ticket_limit'];
                                                    }

                                                    $myquery52 = "Insert into lsl_transaction_child(Enrollment_id,Transaction_id,Campaign_id,Campaign_type,Campaign_sub_type,Reward_points,Company_id,Date)
                                                                  values('".$mv_create_user_id."','".$insert_promo_code."','".$rec['Campaign_id']."','".$Campaign_type."','".$Campaign_sub_type."','".$rec["Points"]."','".$Company_id."','".$todays."')";
                                                    $run_query = mysqli_query($conn,$myquery52);
                                                /**************************Insert transaction Child********************************/

                                                /************************Update Promo Campaign ************************/
                                                    $update_promo_campaign = lslDB::getInstance()->update_promo_campaign($Company_id,$Promo_code);
                                                /************************Update Promo Campaign ************************/

                                                /****************************************Sweepstake Link To Promo************************************/
                                                    $cmp_sweepstake_validation = lslDB::getInstance()->cmp_sweepstake_validation($rec['Campaign_id'],$Sweepstake_id,$Company_id,$mv_create_user_id,$todays,$Sweepstake_ticket_limit,$mv_create_user_id,$mv_create_date);
                                                /****************************************Sweepstake Link To Promo************************************/

                                                /******Promo Code Email Notification********/
                                                    if($Communication_flag == 1)
                                                    {
                                                        if($Communication_type == 1 || $Communication_type == 3)
                                                        {
                                                            $Transaction_date=date("Y-m-d");    $Template_type_id = 34;     $Email_type = 188;	
                                                            $promo_code_template = lslDB::getInstance()->send_promo_code_template($mv_create_user_id,$Promo_code,$rec["Points"],$avail_bal,$Company_id,$Email_type,$Template_type_id,$Transaction_date);
                                                        }

                                                        /*********************Send SMS******************/
                                                        if($Communication_type == 2 || $Communication_type == 3)
                                                        {
                                                            $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                                                            $company_detail=mysqli_fetch_array($get_company_details);
                                                            $Promo_code_sms = $company_detail['Promo_code_sms'];				
                                                            $SMS_Type = 188;
                                                            $Template_smstype_id = 34;
                                                            if($Promo_code_sms == 1)
                                                            {
                                                                $transferpoints_to_smstemplate = lslDB::getInstance()->send_promo_code_smstemplate($mv_create_user_id,$Promo_code,$rec["Points"],$avail_bal,$Company_id,$SMS_Type,$Template_smstype_id,$Transaction_date); 
                                                            }
                                                        }
                                                        /*********************Send SMS Ends*************/
                                                    }
                                                /******Promo Code Email Notification********/

                                                echo json_encode(array("status" => "1001","Promo_points" => $rec["Points"], "status_message" => "Success"));
                                            }
                                            else
                                            {
                                                /**********************************************Check For 3 Invalid Promo Code****************************************/
                                                $SQL22 = "INSERT INTO lsl_promo_invalid_data(Company_id,Enrollment_id,Create_date) VALUES('".$Company_id."','".$mv_create_user_id."','".$mv_create_date."')";
                                                $RESULT22 = mysqli_query($conn,$SQL22);
                                                /**********************************************Check For 3 Invalid Promo Code****************************************/

                                                echo json_encode(array("status" => "2028", "status_message" => "Promo Code Already Used"));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Promo Code********************************/
                    
                    /************************************Customer Catalogue********************************/
                    if($API_flag == 20)  //***Fetch all Catalogue items
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access = 1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                            
                            $Cart_count = 0;
                            
                            /*$sql58 = "SELECT DISTINCT Temp_cart_id,Company_id,Enrollment_id,Item_code,Redemption_method,Branch FROM lsl_temp_cart "
                                    . "WHERE Company_id=".$Company_id." "
                                    . "AND Enrollment_id=".$Enrollment_id."";
                            $cart_result = mysqli_query($conn,$sql58);*/
                                    
                            $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                            $cart_quantity = mysqli_num_rows($cart_result);
                            $lv_Total_points = 0;
                            $Cart_count = $cart_quantity;
                            
							foreach($cart_result as $cart)
                            {
								$sqlcheck = "SELECT DISTINCT Delivery_method,Company_merchandize_item_code,Merchandise_item_description,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address  FROM lsl_company_merchandise_catalogue ,lsl_partner_master WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
								AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."' AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                $result99 = mysqli_query($conn,$sqlcheck);
                                
                                $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                          WHERE Company_merchandize_item_code = '".$mv_row99['Item_code']."'
                                          AND Company_id IN ('".$Company_id."',1)
                                          AND Active_flag='1'
                                          AND Delivery_method IN ('".$mv_row99['Redemption_method']."','3')";
                                $Item_check = mysqli_num_rows(mysqli_query($conn,$sql88));
                                
                                if($Item_check > 0)
                                {
                                    while($mv_row22 = mysqli_fetch_array($result99))
                                    {
                                        $count22 = "SELECT * FROM lsl_temp_cart WHERE  
                                                    lsl_temp_cart.Company_id=".$Company_id." AND lsl_temp_cart.Enrollment_id=".$Enrollment_id." AND Item_code='".$mv_row22["Company_merchandize_item_code"]."' AND Branch='".$mv_row99["Branch"]."' AND Redemption_method='".$mv_row99["Redemption_method"]."' ";
                                        $result22 = mysqli_query($conn,$count22);

                                        $quantity = mysqli_num_rows($result22);
                                        $Total_Redeemable_points = $quantity * $mv_row22["Billing_price_in_points"];
                                        $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                    }
                                }
                            }
                            $Total_Redeem_points_incart = $lv_Total_points;
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                                {
                                    echo json_encode(array("status" => "2027", "status_message" => "Insufficient Points limit for the day / Check your Daily Limit"));
                                }
                                else
                                {
                                    $Start_limit = trim($_REQUEST['Start_limit']);
                                    $End_limit = trim($_REQUEST['End_limit']);
                                    $LIMIT = "";
                                    
                                    if($Start_limit == "" && $Start_limit == NULL && $End_limit == "" && $End_limit == NULL)
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( $Start_limit != "" && $End_limit == "" )
                                    {
                                        $LIMIT = "";
                                    }
                                    else if( ($Start_limit == "" || $Start_limit == NULL) && $End_limit != "" )
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit > $End_limit)
                                    {
                                        $LIMIT = "LIMIT 0,".$End_limit." ";
                                    }
                                    else if($Start_limit != "" && $End_limit != "")
                                    {
                                        $LIMIT = "LIMIT ".$Start_limit.",".$End_limit." ";
                                    }
                                    
                                    /************************New Sorting****************************/
                                        $Sort_by = trim($_REQUEST['Sort_by']);
                                        $Delivery_method = trim($_REQUEST['Delivery_method']);
                                        $CategoryId = trim($_REQUEST['CategoryId']);
                                        $SORTING = "";      $DELIVERY_METHOD = "";      $CATEGORY_WHERE = "";

                                        if($Sort_by == "" || $Sort_by == NULL)
                                        {
                                            $SORTING = "";
                                        }
                                        else
                                        {
                                            if($Sort_by == 1)
                                            {
                                                $SORTING = "ORDER BY Billing_price_in_points ASC";
                                            }
                                            else if($Sort_by == 2)
                                            {
                                                $SORTING = "ORDER BY Billing_price_in_points DESC";
                                            }
                                            else
                                            {
                                                $SORTING = "";
                                            }
                                        }

                                        if($Delivery_method == "" || $Delivery_method == NULL)
                                        {
                                            $DELIVERY_METHOD = "";
                                        }
                                        else
                                        {
                                            if($Delivery_method == 1)
                                            {
                                                $DELIVERY_METHOD = "AND Delivery_method=1";
                                            }
                                            else if($Delivery_method == 2)
                                            {
                                                $DELIVERY_METHOD = "AND Delivery_method=2";
                                            }
                                            else if($Delivery_method == 3)
                                            {
                                                $DELIVERY_METHOD = "AND Delivery_method=3";
                                            }
                                            else
                                            {
                                                $DELIVERY_METHOD = "";
                                            }
                                        }

                                        if($CategoryId == "" || $CategoryId == NULL)
                                        {
                                            $CATEGORY_WHERE = "";
                                        }
                                        else
                                        {
                                            $CATEGORY_WHERE = "AND Merchandize_category_id='".$CategoryId."' ";
                                        }
                                    /************************New Sorting****************************/
                                    
                                    $todays = date('Y-m-d');                                    
                                    $query1 = "SELECT * FROM lsl_company_merchandise_catalogue "
                                                . "WHERE Active_flag='1' "
                                                . "AND Approved_flag='1' "
                                                . "AND Company_id=".$Company_id."  "
                                                . "AND Valid_from <= '".$todays."' "
                                                . "AND Valid_till >= '".$todays."' "
                                                . "AND Loyalty_program_id='".$member_details['Loyalty_programme_id']."' "
                                                . " ".$DELIVERY_METHOD." "
                                                . " ".$CATEGORY_WHERE." "
                                                . " ".$SORTING." "
                                                . " ".$LIMIT." ";
                                    
                                    $result1 = mysqli_query($conn,$query1);
                                    $Result_count1 = mysqli_num_rows($result1);
                                    
                                    if($Result_count1 > 0)
                                    {
                                        while($Catalogue = mysqli_fetch_array($result1))
                                        {
                                            if(($todays >= $Catalogue['Valid_from']) && ($todays <= $Catalogue['Valid_till']))
                                            {
                                                $Branch_details = array();
                                            
                                                if($Catalogue['Delivery_method'] == '1' || $Catalogue['Delivery_method'] == '3')
                                                {
                                                    $sql = "SELECT B.Branch_code,B.Branch_name FROM lsl_merchandize_item_child as MI,lsl_branch_master as B
                                                            WHERE MI.Partner_id=B.Partner_id
                                                            AND MI.Merchandize_item_code = '".$Catalogue["Merchandize_item_code"]."'
                                                            AND B.Company_id IN ('".$Company_id."',1)
                                                            GROUP BY B.Branch_code";
                                                    $result2 = mysqli_query($conn,$sql);
                                                    
                                                    while($row3 = mysqli_fetch_array($result2))
                                                    {
                                                        $Branch_details[] = array
                                                                ( 
                                                                    "Branch_code" => $row3['Branch_code'],
                                                                    "Branch_name" => $row3['Branch_name']
                                                                );                                           
                                                    }
                                                }
                                                
                                                if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
                                                {
                                                    $Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
                                                }
                                                else
                                                {
                                                    //$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
                                                    $Item_image = $Catalogue['Item_image'];
                                                }
                                            
                                                $Catalogue_details[] = array
                                                    (
                                                        "Company_merchandise_item_id" => $Catalogue['Company_merchandise_item_id'],
                                                        "Item_image" => $Item_image,
                                                        "Billing_price_in_points" => $Catalogue['Billing_price_in_points'],
                                                        "Delivery_method" => $Catalogue['Delivery_method'],
                                                        "Merchandize_item_code" => $Catalogue['Merchandize_item_code'],
                                                        "Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
                                                        //"Merchandise_item_description" => mysqli_real_escape_string($conn,$Catalogue['Merchandise_item_description']),
                                                        "Merchandise_item_description" => htmlspecialchars($Catalogue['Merchandise_item_description'],ENT_SUBSTITUTE),
                                                        "Branch_details" => $Branch_details
                                                    );
                                            }
                                            //break;
                                        }
                                        
                                        $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                  WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                  AND (CM.Delivery_method = TC.Redemption_method
                                                       OR CM.Delivery_method = 3)
                                                  AND CM.Company_id IN ('".$Company_id."',1)
                                                  AND CM.Active_flag='1'
                                                  AND TC.Enrollment_id='".$Enrollment_id."' ";
                                        $Cart_count = mysqli_num_rows(mysqli_query($conn,$sql87));
                                        
                                        /*$sql87 = "SELECT Temp_cart_id FROM lsl_temp_cart "
                                                . "WHERE Company_id=".$Company_id." "
                                                . "AND Enrollment_id=".$Enrollment_id."";
                                        $cart_result = mysqli_query($conn,$sql87);
                                        $Cart_quantity87 = mysqli_num_rows($cart_result);
                                        $Cart_count = $Cart_quantity87;*/
                                        
                                        /*$Status_array = array("status" => "1001","Current_balance" => $Current_balance,"Total_Redeem_points_incart" => $Total_Redeem_points_incart,"Total_items_incart"=>$Cart_count);
                                        $Catalogue_details = array_merge($Catalogue_details,$Status_array);
                                        echo json_encode($Catalogue_details);*/
                                        
                                        $Status_array = array("status" => "1001","Current_balance" => $Current_balance,"Total_Redeem_points_incart" => $Total_Redeem_points_incart,"Total_items_incart"=>$Cart_count, "Catalogue_details" => $Catalogue_details, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 21)     //**Insert Item into cart
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Country_id = $member_details['Country_id'];
                            $State_id = $member_details['State_id'];
                            
                            $Redemption_method = trim($_REQUEST['Redemption_method']);
                            $Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                            $Branch = trim($_REQUEST['Branch']);
                            
                            $Weight_error_flag = array();
                            $Weight_array = array();
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access=1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                            
                            $Cart_count = 0;
                            
                            /*-------------------------------Get maximum weight----------------------------*/
                                $Weight_query = "SELECT MAX(Weight_end_range) as Max_weight_range FROM lsl_weight_master WHERE Weight_unit_id=5";
                                $Weight_details = mysqli_fetch_assoc(mysqli_query($conn,$Weight_query));
                                $Max_weight_range = $Weight_details['Max_weight_range'];
                            /*-------------------------------Get maximum weight----------------------------*/
                            
                            /*$sql58 = "SELECT DISTINCT Temp_cart_id,Company_id,Enrollment_id,Item_code,Redemption_method,Branch FROM lsl_temp_cart "
                                    . "WHERE Company_id=".$Company_id." "
                                    . "AND Enrollment_id=".$Enrollment_id."";
                            $cart_result = mysqli_query($conn,$sql58);*/
                            
                            $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                            $cart_quantity = mysqli_num_rows($cart_result);
                            $lv_Total_points = 0;
                            $Cart_count = $cart_quantity;
                            
                            while($mv_row99 = mysqli_fetch_array($cart_result))
                            {
                                $sqlcheck = "SELECT DISTINCT Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                $result99 = mysqli_query($conn,$sqlcheck);
                                
                                $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                          WHERE Company_merchandize_item_code = '".$mv_row99['Item_code']."'
                                          AND Company_id IN ('".$Company_id."',1)
                                          AND Active_flag='1'
                                          AND Delivery_method IN ('".$mv_row99['Redemption_method']."','3')";
                                $Item_check = mysqli_num_rows(mysqli_query($conn,$sql88));   
                                
                                if($Item_check > 0)
                                {
                                    while($mv_row22 = mysqli_fetch_array($result99))
                                    {
                                        /**************Count Quantity**************/
                                            $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$mv_row22["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                            $quantity = mysqli_num_rows($count_quantity);
                                        /****************************************/
                                            
                                        if( ($Company_merchandize_item_code == $mv_row99['Item_code']) && ($mv_row99["Redemption_method"] == $Redemption_method) && ($mv_row99["Branch"] == $Branch) )
                                        {
                                            $quantity = $quantity + 1;
                                        }
                                        
                                        $lv_weight = $mv_row22["Weight"] * $quantity;
                                        $lv_Weight_unit_id = $mv_row22["Weight_unit_id"];
                                        $lv_Partner_id = $mv_row22["Partner_id"];
                                        $lv_Partner_Country_id = $mv_row22["Country_id"];
                                        $lv_Partner_State_id = $mv_row22["State_id"];
                                        $Redemption_method2 = $mv_row99["Redemption_method"];
                                        $Branch2 = $mv_row99["Branch"];
                                        
                                        if($Redemption_method2 == 2)
                                        {
                                            /**************Conversion Rate for Gram to KG****************/
                                                if($lv_Weight_unit_id == '6')
                                                {
                                                        $lv_weight = ($lv_weight / 1000);
                                                        $lv_Weight_unit_id = '5';
                                                }
                                            /**************Conversion Rate for Gram to KG****************/

                                            /**************Conversion Rate for Pound to KG****************/
                                                if($lv_Weight_unit_id == '7')
                                                {
                                                        $lv_weight = ($lv_weight * 0.45359);
                                                        $lv_Weight_unit_id = '5';
                                                }
                                            /**************Conversion Rate for Pound to KG****************/
                                                
                                            $Item_weight = $lv_weight;
                                            
                                            /**************Retriving Weight ID *******/
                                                $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                    WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                   '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                $mv_row89 = mysqli_fetch_array($result89);
                                            /**************Retriving Weight ID *******/
                                                
                                            if($Item_weight < $Max_weight_range)
                                            {
                                                /*******************Combine same state weight************************/
                                                    if($lv_weight != 0)
                                                    {
                                                        $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                                        $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                                        $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$mv_row22["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                        if( !array_key_exists($Min_shippin_key,$Weight_array) )
                                                        {										
                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
                                                        }
                                                        else
                                                        {
                                                            $New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
                                                        }
                                                    }
                                                /*******************Combine same state weight************************/
                                                    
                                                $Weight_error_flag[] = 0;
                                            }
                                            else
                                            {
                                                $Weight_error_flag[] = -1;
                                            }
                                        }
                                        else
                                        {
                                            $Weight_error_flag[] = 0;
                                        }
                
                                        $count22 = "SELECT * FROM lsl_temp_cart WHERE  
                                                    lsl_temp_cart.Company_id=".$Company_id." AND lsl_temp_cart.Enrollment_id=".$Enrollment_id." AND Item_code='".$mv_row22["Company_merchandize_item_code"]."' AND Branch='".$mv_row99["Branch"]."' AND Redemption_method='".$mv_row99["Redemption_method"]."' ";
                                        $result22 = mysqli_query($conn,$count22);

                                        $quantity = mysqli_num_rows($result22);
                                        $Total_Redeemable_points = $quantity * $mv_row22["Billing_price_in_points"];
                                        $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                    }
                                    
                                    $Billing_price_in_points = $mv_row22["Billing_price_in_points"];
                                }                                
                            }
                            
                            $ItemSQL = "SELECT Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                        WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                        AND Company_id IN ('".$Company_id."',1)
                                        AND Active_flag='1' ";
                            $ItemDetails = mysqli_fetch_array(mysqli_query($conn,$ItemSQL));
                            $ItemBillingPrice = $ItemDetails["Billing_price_in_points"];
                            
                            if($Redemption_method == 2)
                            {
                                $sqlcheck = "SELECT DISTINCT Item_image,Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$Company_merchandize_item_code."'
                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                $result99 = mysqli_query($conn,$sqlcheck);
                                while($Catalogue = mysqli_fetch_array($result99))
                                {
                                    $quantity = 1;
                                    $lv_weight = $Catalogue["Weight"] * $quantity;
                                    $lv_Weight_unit_id = $Catalogue["Weight_unit_id"];
                                    $lv_Partner_id = $Catalogue["Partner_id"];
                                    $lv_Partner_Country_id = $Catalogue["Country_id"];
                                    $lv_Partner_State_id = $Catalogue["State_id"];

                                    /**************Conversion Rate for Gram to KG****************/
                                        if($lv_Weight_unit_id == '6')
                                        {
                                                $lv_weight = ($lv_weight / 1000);
                                                $lv_Weight_unit_id = '5';
                                        }
                                    /**************Conversion Rate for Gram to KG****************/

                                    /**************Conversion Rate for Pound to KG****************/
                                        if($lv_Weight_unit_id == '7')
                                        {
                                                $lv_weight = ($lv_weight * 0.45359);
                                                $lv_Weight_unit_id = '5';
                                        }
                                    /**************Conversion Rate for Pound to KG****************/

                                    $Item_weight = $lv_weight;

                                    /**************Retriving Weight ID *******/
                                        $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                            WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                           '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                        $result89 = mysqli_query($conn,$lv_get_weight_id);
                                        $mv_row89 = mysqli_fetch_array($result89);
                                    /**************Retriving Weight ID *******/

                                    /*******************Combine same state weight************************/
                                        if($lv_weight != 0)
                                        {
                                            $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                            $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                            $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                            if( !array_key_exists($Min_shippin_key,$Weight_array) )
                                            {										
                                                $Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
                                            }
                                            else
                                            {
                                                $New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
                                                $Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
                                            }
                                        }
                                    /*******************Combine same state weight************************/
                                }

                                /***********************Calculate Combined weight shipping Cost************************/
                                    foreach($Weight_array as $key => $Weight)
                                    {
                                        $TotalWeight = number_format((float)$Weight['Weight'], 2, '.', '');
                                        if($TotalWeight < $Max_weight_range)
                                        {
                                            $Weight_error_flag[] = 0;
                                        }
                                        else
                                        {
                                            $Weight_error_flag[] = -1;
                                        }
                                    }
                                /***********************Calculate Combined weight shipping Cost************************/    
                            }
                            
                            //$Total_Redeem_points_incart = $lv_Total_points + $Billing_price_in_points;
                            $Total_Redeem_points_incart = $lv_Total_points;                            
                            $new_Total_Redeem_points_incart = $Total_Redeem_points_incart + $ItemBillingPrice;
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else if($new_Total_Redeem_points_incart > $Current_balance)
                            {
                                echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));                                           
                            }
                            else if($Total_Redeem_points_incart > 0 && $Current_balance <= 0)
                            {
                                echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                            }
                            else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                            {
                                echo json_encode(array("status" => "2026", "status_message" => "You have Exceeded your transfer limit for the day"));
                            }
                            else if($Parent_enroll_id > 0 && $Family_redeem_limit_cust < $Billing_price_in_points)
                            {
                                echo json_encode(array("status" => "2027", "status_message" => "Insufficient Points limit for the day / Check your Daily Limit"));                                           
                            }
                            else if($Total_Redeem_points_incart > $Current_balance)
                            {
                                echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));                                           
                            }
                            else if(in_array("-1", $Weight_error_flag))
                            {
                                echo json_encode(array("status" => "2087", "status_message" => "This item could not be added as you have exceeded the maximum weight"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    /*------------------------Item Details-----------------*/
                                        $sql = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                                WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                                AND Company_id IN ('".$Company_id."',1)
                                                AND Active_flag='1'
                                                AND Delivery_method IN ('".$Redemption_method."','3')";
                                        $result2 = mysqli_query($conn,$sql);
                                        $Item_details = mysqli_fetch_array($result2);
                                        $Item_valid_count = mysqli_num_rows($result2);
                                        
                                        $sql3 = "SELECT B.Branch_code FROM lsl_merchandize_item_child as MI,lsl_branch_master as B
                                                WHERE MI.Partner_id=B.Partner_id
                                                AND MI.Merchandize_item_code = '".$Company_merchandize_item_code."'
                                                AND B.Company_id IN ('".$Company_id."',1) ";
                                        $result3 = mysqli_query($conn,$sql3);
                                        $Branch_valid_count = mysqli_num_rows($result3);
                                    /*------------------------Item Details-----------------*/
                                    
                                    if($Redemption_method == 1 && $Branch == "")
                                    {
                                        echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
                                    }
                                    else if($Redemption_method == 1 && $Branch_valid_count == 0)
                                    {
                                        echo json_encode(array("status" => "2035", "status_message" => "Item cannot be deleted"));
                                    }
                                    else
                                    {
                                        if($Item_valid_count > 0)
                                        {
                                            $insert_cart = lslDB::getInstance()->temp_cart($Company_id,$member_details['Enrollment_id'],$Company_merchandize_item_code,$Redemption_method,$Branch);                                     
                                            
                                            $Total_Redeem_points_incart = $Total_Redeem_points_incart + $Item_details['Billing_price_in_points'];
                                            //$Cart_count = $Cart_count + 1;
                                            
                                            /*$sql87 = "SELECT Temp_cart_id FROM lsl_temp_cart "
                                                    . "WHERE Company_id=".$Company_id." "
                                                    . "AND Enrollment_id=".$Enrollment_id."";
                                            $cart_result = mysqli_query($conn,$sql87);
                                            $Cart_quantity87 = mysqli_num_rows($cart_result);*/
                                            
                                            $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                      WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                      AND (CM.Delivery_method = TC.Redemption_method
                                                           OR CM.Delivery_method = 3)
                                                      AND CM.Company_id IN ('".$Company_id."',1)
                                                      AND CM.Active_flag='1'
                                                      AND TC.Enrollment_id='".$Enrollment_id."' ";
                                            $Cart_quantity87 = mysqli_num_rows(mysqli_query($conn,$sql87));
                                            
                                            /*$sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                      WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                      AND TC.Company_id='".$Company_id."'
                                                      AND CM.Active_flag='1'
                                                      AND TC.Enrollment_id='".$Enrollment_id."' ";
                                            $Cart_quantity87 = mysqli_num_rows(mysqli_query($conn,$sql87));
                                            
                                            echo "SQL87------".$sql87."<br>";
                                            echo "Cart_quantity87------".$Cart_quantity87."<br>";die;*/
                                            
                                            echo json_encode(array("status" => "1001","Total_Redeem_points_incart" => $Total_Redeem_points_incart,"Total_items_incart"=>$Cart_quantity87, "status_message" => "Success"));
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
                                        }
                                    }                                    
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 22)     //**Catalogue Checkout
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Country_id = $member_details['Country_id'];
                            $State_id = $member_details['State_id'];
                            $City_id = $member_details['City_id'];
                            $Current_address = $member_details['Current_address'];
                            $Current_balance = $member_details['Current_balance'];
                            $Blocked_points = $member_details['Blocked_points'];
                            $Available_current_balance = $Current_balance - $Blocked_points;
                            
                            $company_details_result = lslDB::getInstance()->get_company_details($Company_id);
                            $company_details = mysqli_fetch_array($company_details_result);
                            $Cust_pin_validation = $company_details['Cust_pin_validation'];
                            $Cust_redeem_pin_validation = $company_details['Cust_redeem_pin_validation'];
                            
                            $Country_query = "SELECT Country_name FROM lsl_country_currency_master WHERE Country_id='".$Country_id."' ";
                            $Country_details = mysqli_fetch_assoc(mysqli_query($conn,$Country_query));
                            $Country_name = $Country_details['Country_name'];
                            
                            $State_query = "SELECT State_name FROM lsl_state_master WHERE State_id='".$State_id."' ";
                            $State_details = mysqli_fetch_assoc(mysqli_query($conn,$State_query));
                            $State_name = $State_details['State_name'];
                            
                            $City_query = "SELECT City_name FROM lsl_city_master WHERE City_id='".$City_id."' ";
                            $City_details = mysqli_fetch_assoc(mysqli_query($conn,$City_query));
                            $City_name = $City_details['City_name'];
                            
                            $lv_query291 = "SELECT Points_value_definition FROM lsl_loyalty_program_master "
                                         . "WHERE Loyalty_program_id=".$member_details['Loyalty_programme_id']." AND User_apply_to='1'";
                            $lv_result291 = mysqli_query($conn,$lv_query291);
                            $lv_row291 = mysqli_fetch_assoc($lv_result291);
                            $lv_Points_value_definition = $lv_row291["Points_value_definition"];
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                                    
                                    /*$sql58 = "SELECT DISTINCT Temp_cart_id,Company_id,Enrollment_id,Item_code,Redemption_method,Branch FROM lsl_temp_cart "
                                            . "WHERE Company_id=".$Company_id." "
                                            . "AND Enrollment_id=".$Enrollment_id."";
                                    $cart_result = mysqli_query($conn,$sql58);*/
                                    
                                    $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                              WHERE CM.Company_merchandize_item_code = TC.Item_code
                                              AND (CM.Delivery_method = TC.Redemption_method
                                                   OR CM.Delivery_method = 3)
                                              AND CM.Company_id IN ('".$Company_id."',1)
                                              AND CM.Active_flag='1'
                                              AND TC.Enrollment_id='".$Enrollment_id."' ";
                                    $Cart_quantity = mysqli_num_rows(mysqli_query($conn,$sql87));
                                    
                                    //$Cart_quantity = mysqli_num_rows($cart_result);
                                    $lv_Total_points = 0;
                                    $lv_total_shopping_points = 0;
                                    $Redemption_method123 = array();
                                    $item_array = array();
                                    $Remark_item_array = array();
                                    $DeliveryItem = array();

                                    if($Cart_quantity > 0)
                                    {
                                        while($mv_row99 = mysqli_fetch_array($cart_result))
                                        {
                                            $sqlcheck = "SELECT DISTINCT Item_image,Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                         FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                         WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                         AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                         AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                                         AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                            $result99 = mysqli_query($conn,$sqlcheck);
                                            
                                            $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                                      WHERE Company_merchandize_item_code = '".$mv_row99['Item_code']."'
                                                      AND Company_id IN ('".$Company_id."',1)
                                                      AND Active_flag='1'
                                                      AND Delivery_method IN ('".$mv_row99['Redemption_method']."','3')";
                                            $Item_check = mysqli_num_rows(mysqli_query($conn,$sql88));

                                            if($Item_check > 0)
                                            {
                                                while($Catalogue = mysqli_fetch_array($result99))
                                                {
                                                    /**************Count Quantity**************/
                                                        $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$Catalogue["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                                        $quantity = mysqli_num_rows($count_quantity);
                                                    /****************************************/

                                                    $lv_weight = $Catalogue["Weight"] * $quantity;
                                                    $lv_Weight_unit_id = $Catalogue["Weight_unit_id"];
                                                    $lv_Partner_id = $Catalogue["Partner_id"];
                                                    $lv_Partner_Country_id = $Catalogue["Country_id"];
                                                    $lv_Partner_State_id = $Catalogue["State_id"];
                                                    $Partner_contact_person_name = $Catalogue["Partner_contact_person_name"];
                                                    $Partner_address = $Catalogue["Partner_address"];                                            

                                                    $Redemption_method = $mv_row99["Redemption_method"];
                                                    array_push($Redemption_method123,$Redemption_method);
                                                    $Branch = $mv_row99["Branch"];

                                                    if($Redemption_method == 1)
                                                    {
                                                        $lv_converted_shipping_points = 0;
                                                        $RedemptionMethod = "Redeemed in Person";

                                                        $sql123 = "SELECT lsl_branch_master.Branch_name,lsl_city_master.City_name FROM lsl_branch_master,lsl_city_master 
                                                                   WHERE lsl_branch_master.City_id=lsl_city_master.City_id
                                                                   AND lsl_branch_master.Branch_code='".$Branch."' ";
                                                        $result123 = mysqli_query($conn,$sql123);
                                                        while($rows123 = mysqli_fetch_array($result123))
                                                        {
                                                            $Partner_location = $rows123['Branch_name'].", ".$rows123['City_name'];
                                                        }

                                                        $Total_Redeemable_points = "";
                                                        $Total_Redeemable_points = $quantity * $Catalogue["Billing_price_in_points"];
                                                        $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;

                                                        if($Catalogue["Enable_remark"] == 1)
                                                        {
                                                            $Remark_lable = $Catalogue["Remark_lable"];
                                                            array_push($Remark_item_array,$Catalogue["Enable_remark"]);
                                                        }
                                                        else
                                                        {
                                                            $Remark_lable = '';
                                                        }

                                                        if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
                                                        {
                                                            $Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
                                                        }
                                                        else
                                                        {
                                                            //$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
                                                            $Item_image = $Catalogue['Item_image'];
                                                        }

                                                        $Cart_details[] = array
                                                                (
                                                                    "Company_merchandize_item_code" => $Catalogue['Company_merchandize_item_code'],
                                                                    "Item_image" => $Item_image,
                                                                    "Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
                                                                    "Quantity" => $quantity,
                                                                    "RedemptionMethod" => $RedemptionMethod,
                                                                    "Delivery_Method" => $Redemption_method,
                                                                    "Partner_location" => $Partner_location,
                                                                    "Branch" => $Branch,
                                                                    "Billing_price_in_points" => $Catalogue["Billing_price_in_points"],
                                                                    "Total_Redeemable_points" => $Total_Redeemable_points,
                                                                    "Shipping_points" => $lv_converted_shipping_points,
                                                                    "Partner_address" => $Partner_address,
                                                                    "Partner_id" => $lv_Partner_id,
                                                                    "Remark_label" => $Remark_lable,
                                                                    "Enable_remark" => $Catalogue["Enable_remark"],
                                                                    "Remark" => $mv_row99["Remark"],
                                                                    "Partner_contact_person_name" => $Partner_contact_person_name
                                                                );
                                                                //"Temp_cart_id" => $mv_row99["Temp_cart_id"]
                                                    }
                                                    else
                                                    {
                                                        /**************Conversion Rate for Gram to KG****************/
                                                        if($lv_Weight_unit_id == '6')
                                                        {
                                                            $lv_weight = ($lv_weight / 1000);
                                                            $lv_Weight_unit_id = '5';
                                                        }
                                                        /**************Conversion Rate for Gram to KG****************/

                                                        /**************Conversion Rate for Pound to KG****************/
                                                        if($lv_Weight_unit_id == '7')
                                                        {
                                                            $lv_weight = ($lv_weight * 0.45359);
                                                            $lv_Weight_unit_id = '5';
                                                        }
                                                        /**************Conversion Rate for Pound to KG****************/

                                                        /**************Retriving Weight ID *******/
                                                        $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                             WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                            '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                        $result33 = mysqli_query($conn,$lv_get_weight_id);

                                                        $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                        $mv_row89 = mysqli_fetch_array($result89);	
                                                        
                                                        /*******************Combine same state weight************************/
                                                            if($lv_weight != 0)
                                                            {
                                                                    $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                                                    $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                                                    $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                                    if( !array_key_exists($Min_shippin_key,$Weight_array) )
                                                                    {										
                                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
                                                                    }
                                                                    else
                                                                    {
                                                                            $New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
                                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
                                                                    }
                                                            }
                                                        /*******************Combine same state weight************************/
                                                                
                                                        $calculate_min_shipping_points = lslDB::getInstance()->calculate_min_shipping_points($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                        while($mv_row33 = mysqli_fetch_array($result33))
                                                        {
                                                            if($lv_weight == 0)
                                                            {
                                                                $lv_weight_range_price = 0;
                                                            }
                                                            else
                                                            {
                                                                $lv_weight_range_price = $calculate_min_shipping_points;
                                                            }

                                                            $lv_converted_shipping_points = ($lv_weight_range_price * $lv_Points_value_definition);	
                                                            $lv_converted_shipping_points = round($lv_converted_shipping_points);											
                                                            $lv_total_shopping_points = $lv_converted_shipping_points + $lv_total_shopping_points;

                                                            $RedemptionMethod = "To be Delivered";
                                                            $Partner_location = " - ";

                                                            $Total_Redeemable_points = "";
                                                            $Total_Redeemable_points = $quantity * $Catalogue["Billing_price_in_points"];
                                                            $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;

                                                            array_push($DeliveryItem,$RedemptionMethod);
                                                        }

                                                        if($Catalogue["Enable_remark"] == 1)
                                                        {
                                                            $Remark_lable = $Catalogue["Remark_lable"];
                                                            array_push($Remark_item_array,$Catalogue["Enable_remark"]);
                                                        }
                                                        else
                                                        {
                                                            $Remark_lable = '';
                                                        }

                                                        if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
                                                        {
                                                            $Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
                                                        }
                                                        else
                                                        {
                                                            //$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
                                                            $Item_image = $Catalogue['Item_image'];
                                                        }

                                                        $Cart_details[] = array
                                                                (
                                                                    "Company_merchandize_item_code" => $Catalogue['Company_merchandize_item_code'],
                                                                    "Item_image" => $Item_image,
                                                                    "Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
                                                                    "Quantity" => $quantity,
                                                                    "RedemptionMethod" => $RedemptionMethod,
                                                                    "Delivery_Method" => $Redemption_method,
                                                                    "Partner_location" => $Partner_location,
                                                                    "Branch" => $Branch,
                                                                    "Billing_price_in_points" => $Catalogue["Billing_price_in_points"],
                                                                    "Total_Redeemable_points" => $Total_Redeemable_points,
                                                                    "Shipping_points" => $lv_converted_shipping_points,
                                                                    "Partner_address" => $Partner_address,
                                                                    "Partner_id" => $lv_Partner_id,
                                                                    "Remark_label" => $Remark_lable,
                                                                    "Enable_remark" => $Catalogue["Enable_remark"],
                                                                    "Remark" => $mv_row99["Remark"],
                                                                    "Partner_contact_person_name" => $Partner_contact_person_name
                                                                );
                                                    }

                                                    array_unshift($item_array,$Catalogue["Merchandize_item_name"]);

                                                }
                                                
                                                    /***********************Calculate Combined weight shipping Cost************************/
                                                        $lv_total_shopping_points77 = 0;
                                                        $lv_Weight_unit_id89 = '5';

                                                        foreach($Weight_array as $key => $Weight)
                                                        {
                                                                $TotalWeight = number_format((float)$Weight['Weight'], 2, '.', '');
                                                                $lv_get_weight_id89 ="select Weight_id from lsl_weight_master where 
                                                                                                          Weight_unit_id=".$lv_Weight_unit_id89." AND 
                                                                                                          '".$TotalWeight."' between Weight_start_range AND Weight_end_range";
                                                                $result898 = mysqli_query($conn,$lv_get_weight_id89);
                                                                $mv_row898 = mysqli_fetch_array($result898);

                                                                $state_sql = "SELECT Country_id FROM lsl_state_master WHERE State_id = ".$key;
                                                                $state_result = mysqli_fetch_array(mysqli_query($conn,$state_sql));

                                                                $lv_get_shopping_price = "select MIN(Weight_range_price) as Weight_range_price from lsl_delivery_price_master
                                                                                                                  WHERE Country_from=".$state_result['Country_id']." AND 
                                                                                                                  State_from=".$key." AND 
                                                                                                                  Country_to=".$Country_id." AND 
                                                                                                                  State_to=".$State_id." AND 
                                                                                                                  Weight_id=".$mv_row898["Weight_id"]."";
                                                                $result44 = mysqli_query($conn,$lv_get_shopping_price);
                                                                $mv_row44 = mysqli_fetch_array($result44);

                                                                $Shipping_cost = round($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                $lv_total_shopping_points77 = $Shipping_cost + $lv_total_shopping_points77;
                                                        }
                                                    /***********************Calculate Combined weight shipping Cost************************/
                                            }
                                        }

                                        $Merchandize_item_array = implode("*",$item_array);

                                        //$Grand_Total_Points = $lv_total_shopping_points + $lv_Total_points;
                                        $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points;
                                        $Status_array = array
                                                ("Total_points" => $lv_Total_points,
                                                 //"Total_shipping_points" => $lv_total_shopping_points,
                                                 "Total_shipping_points" => $lv_total_shopping_points77,
                                                 "Grand_Total_Points" => $Grand_Total_Points,
                                                 "Cart_quantity" => $Cart_quantity,
                                                 "Current_address" => $Current_address,
                                                 "Country_name" => $Country_name,
                                                 "State_name" => $State_name,
                                                 "City_name" => $City_name,
                                                 "Country_id" => $Country_id,
                                                 "State_id" => $State_id,
                                                 "City_id" => $City_id,
                                                 "Remark_item_count" => count($Remark_item_array),
                                                 "Delivery_item_count" => count($DeliveryItem),
                                                 "Current_balance" => $Available_current_balance,
                                                 "Cust_pin_validation" => $Cust_pin_validation,
                                                 "Cust_redeem_pin_validation" => $Cust_redeem_pin_validation,
                                                 "Merchandize_item_array" => $Merchandize_item_array
                                                );
                                        //$Cart_array = array_reverse($Cart_details);
                                        //$Cart_details = array_merge($Cart_array,$Status_array);
                                        //echo json_encode($Cart_details);
                                        
                                        $Cart_array = array("status" => "1001", "Cart_details" => $Cart_details, "Status_array" => $Status_array, "status_message" => "Success");
                                        echo json_encode($Cart_array);                                        
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 31)     //**Update Item Quantity
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                            $Delivery_Method = trim($_REQUEST['Delivery_Method']);
                            $Branch = trim($_REQUEST['Branch']);
                            $Quantity = trim($_REQUEST['Quantity']);
                            $Weight_error_flag = array();   $Weight_array = array();    $Weight_error_flag2 = array();
                            
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Country_id = $member_details['Country_id'];
                            $State_id = $member_details['State_id'];
                            $Available_current_balance = $Current_balance - $Blocked_points;
                            
                            $lv_query291 = "SELECT Points_value_definition FROM lsl_loyalty_program_master "
                                         . "WHERE Loyalty_program_id=".$member_details['Loyalty_programme_id']." AND User_apply_to='1'";
                            $lv_result291 = mysqli_query($conn,$lv_query291);
                            $lv_row291 = mysqli_fetch_assoc($lv_result291);
                            $lv_Points_value_definition = $lv_row291["Points_value_definition"];
                            
                            if($Parent_enroll_id > 0)
                            {
                                $lv_result292 = lslDB::getInstance()->get_user_details($Parent_enroll_id,$Company_id);
                                $lv_row292 =mysqli_fetch_assoc($lv_result292);
                                
                                $Current_balance = $lv_row292['Current_balance'] - $lv_row292['Blocked_points'];
                                $Curr_balance = $lv_row292['Current_balance'];
                                $Blocked_points = $member_details['Blocked_points'];
                                $Family_memb_enroll_id = $member_details['Enrollment_id'];
                                $Family_redeem_limit_cust = $member_details['Family_redeem_limit'];
                            }
                            else
                            {
                                $Blocked_points = $member_details['Blocked_points'];
                                $Curr_balance = $member_details['Current_balance'];
                                $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                                $Family_memb_enroll_id = 0;
                            }
                            
                            /******************************************Calculate Family Days Available Limit**************************************/
                                $todays_date = date("Y-m-d");	
                                $check_count_tras_family_memb = lslDB::getInstance()->check_count_tras_family_memb($Company_id,$Family_memb_enroll_id,$todays_date);	
                                $Family_member_access=1;	
                                $rows12 = mysqli_fetch_array($check_count_tras_family_memb);
                                
                                $family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];	
                                $family_mem_total_tranfer_points = $rows12["sum(Transfer_points)"];
                                
                                if ($Parent_enroll_id > 0)
                                {
                                    $Total_available_points_family_mem = $Family_redeem_limit_cust - ( $family_mem_total_redeem_points + $family_mem_total_tranfer_points + $Blocked_points);
                                }
                                else
                                {
                                    $Total_available_points_family_mem = 1;
                                }
                            /******************************************Calculate Family Days Available Limit**************************************/
                                                        
                            /*-------------------------------Get maximum weight----------------------------*/
                                $Weight_query = "SELECT MAX(Weight_end_range) as Max_weight_range FROM lsl_weight_master WHERE Weight_unit_id=5";
                                $Weight_details = mysqli_fetch_assoc(mysqli_query($conn,$Weight_query));
                                $Max_weight_range = $Weight_details['Max_weight_range'];
                            /*-------------------------------Get maximum weight----------------------------*/
                                
                            /*-------------------------------Item Details----------------------------*/
                            $ItemSQL = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                        WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                        AND Company_id IN ('".$Company_id."',1)
                                        AND Active_flag='1' ";
                            $ItemDetails = mysqli_fetch_array(mysqli_query($conn,$ItemSQL));
                            $ItemBillingPrice = $ItemDetails["Billing_price_in_points"];
                            /*-------------------------------Item Details----------------------------*/
    
                            $Cart_count = 0;                                    
                            $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                            $cart_quantity = mysqli_num_rows($cart_result);
                            $lv_Total_points = 0;
                            $Cart_count = $cart_quantity;
                            
                            while($mv_row99 = mysqli_fetch_array($cart_result))
                            {
                                $sqlcheck = "SELECT DISTINCT Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                $result99 = mysqli_query($conn,$sqlcheck);
                                
                                $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                          WHERE Company_merchandize_item_code = '".$mv_row99['Item_code']."'
                                          AND Company_id IN ('".$Company_id."',1)
                                          AND Active_flag='1'
                                          AND Delivery_method IN ('".$mv_row99['Redemption_method']."','3')";
                                $Item_check = mysqli_num_rows(mysqli_query($conn,$sql88));
                                
                                if($Item_check > 0)
                                {
                                    while($mv_row22 = mysqli_fetch_array($result99))
                                    {
                                        $count22 = "SELECT * FROM lsl_temp_cart WHERE  
                                                    lsl_temp_cart.Company_id=".$Company_id." AND lsl_temp_cart.Enrollment_id=".$Enrollment_id." AND Item_code='".$mv_row22["Company_merchandize_item_code"]."'";
                                        $result22 = mysqli_query($conn,$count22);

                                        $quantity = mysqli_num_rows($result22);
                                        $Total_Redeemable_points = $quantity * $mv_row22["Billing_price_in_points"];
                                        $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                        $Billing_price_in_points = $mv_row22["Billing_price_in_points"];
                                    }
                                }
                            }                            
                            //$Total_Redeem_points_incart = $lv_Total_points + $Billing_price_in_points + $Item_details['Billing_price_in_points'];
                            $Total_Redeem_points_incart = $lv_Total_points + $ItemBillingPrice;
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else if($Total_Redeem_points_incart > 0 && $Current_balance <= 0)
                            {
                                echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                            }
                            else if($Parent_enroll_id > 0 && $Total_available_points_family_mem <= 0)
                            {
                                echo json_encode(array("status" => "2026", "status_message" => "You have Exceeded your transfer limit for the day"));
                            }
                            else if($Parent_enroll_id > 0 && $Family_redeem_limit_cust < $Item_details['Billing_price_in_points'])
                            {
                                echo json_encode(array("status" => "2027", "status_message" => "Insufficient Points limit for the day / Check your Daily Limit"));                                           
                            }
                            else if($Total_Redeem_points_incart > $Current_balance)
                            {
                                echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));                                           
                            }
                            else if($Quantity == "")
                            {
                                echo json_encode(array("status" => "2036", "status_message" => "Please Check item quantity"));
                            }
                            else if(!is_numeric($Quantity))
                            {
                                echo json_encode(array("status" => "2036", "status_message" => "Please Check item quantity"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    /****************Calculate Details of Cart**************/
                                        $sql87 = "SELECT TC.Item_code,TC.Branch,TC.Redemption_method FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                  WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                  AND (CM.Delivery_method = TC.Redemption_method
                                                       OR CM.Delivery_method = 3)
                                                  AND CM.Company_id IN ('".$Company_id."',1)
                                                  AND CM.Active_flag='1'
                                                  AND TC.Enrollment_id='".$Enrollment_id."' ";
                                        $cart_result2 = mysqli_query($conn,$sql87);
                                        $Cart_quantity = mysqli_num_rows($cart_result2);                                    
                                        $lv_Total_points = 0;
                                        $lv_total_shopping_points = 0;

                                        while($mv_row99 = mysqli_fetch_array($cart_result2))
                                        {
                                            $sqlcheck = "SELECT DISTINCT Item_image,Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                        FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                        WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                        AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                        AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                                        AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                            $result99 = mysqli_query($conn,$sqlcheck);
                                            
                                            while($Catalogue = mysqli_fetch_array($result99))
                                            {
                                                /**************Count Quantity**************/
                                                    $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$Catalogue["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                                    $quantity = mysqli_num_rows($count_quantity);
                                                /****************************************/
                                                    
                                                if( ($Company_merchandize_item_code == $mv_row99['Item_code']) && ($mv_row99["Redemption_method"] == $Delivery_Method) && ($mv_row99["Branch"] == $Branch) )
                                                {
                                                    $quantity = $Quantity;
                                                }

                                                $lv_weight = $Catalogue["Weight"] * $quantity;
                                                $lv_Weight_unit_id = $Catalogue["Weight_unit_id"];
                                                $Redemption_method = $mv_row99["Redemption_method"];
                                                $lv_Partner_id = $Catalogue["Partner_id"];

                                                if($Delivery_Method == 2)
                                                {
                                                    /**************Conversion Rate for Gram to KG****************/
                                                    if($lv_Weight_unit_id == '6')
                                                    {
                                                        $lv_weight = ($lv_weight / 1000);
                                                        $lv_Weight_unit_id = '5';
                                                    }
                                                    /**************Conversion Rate for Gram to KG****************/

                                                    /**************Conversion Rate for Pound to KG****************/
                                                    if($lv_Weight_unit_id == '7')
                                                    {
                                                        $lv_weight = ($lv_weight * 0.45359);
                                                        $lv_Weight_unit_id = '5';
                                                    }
                                                    /**************Conversion Rate for Pound to KG****************/
                                                    
                                                    $Item_weight = $lv_weight;

                                                    /**************Retriving Weight ID *******/
                                                    $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                         WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                        '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                    $result33 = mysqli_query($conn,$lv_get_weight_id);

                                                    $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                    $mv_row89 = mysqli_fetch_array($result89);

                                                    if($Item_weight < $Max_weight_range)
                                                    {
                                                        /*******************Combine same state weight************************/
                                                            if($lv_weight != 0)
                                                            {
                                                                    $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                                                    $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                                                    $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                                    if( !array_key_exists($Min_shippin_key,$Weight_array) )
                                                                    {										
                                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
                                                                    }
                                                                    else
                                                                    {
                                                                            $New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
                                                                            $Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
                                                                    }
                                                            }
                                                        /*******************Combine same state weight************************/
                                                            
                                                        $Weight_error_flag[] = 0;
                                                    }
                                                    else
                                                    {
                                                        $Weight_error_flag[] = -1;
                                                    }
                                                }
                                                
                                                $Total_Redeemable_points = "";
                                                $Total_Redeemable_points = $quantity * $Catalogue["Billing_price_in_points"];
                                                $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                            }

                                            if($Delivery_Method == 2)
                                            {
                                                /***********************Calculate Combined weight shipping Cost************************/
                                                    $lv_total_shopping_points778 = 0;
                                                    $lv_Weight_unit_id89 = '5';
                                                    $lv_total_shopping_cost8 = 0;

                                                    foreach($Weight_array as $key => $Weight8)
                                                    {
                                                            $TotalWeight8 = number_format((float)$Weight8['Weight'], 2, '.', '');
                                                            if($TotalWeight8 < $Max_weight_range)
                                                            {
                                                                $lv_get_weight_id89 ="select Weight_id from lsl_weight_master where 
                                                                                        Weight_unit_id=".$lv_Weight_unit_id89." AND 
                                                                                        '".$TotalWeight8."' between Weight_start_range AND Weight_end_range";
                                                                $result898 = mysqli_query($conn,$lv_get_weight_id89);
                                                                $mv_row898 = mysqli_fetch_array($result898);

                                                                $state_sql = "SELECT Country_id FROM lsl_state_master WHERE State_id = ".$key;
                                                                $state_result = mysqli_fetch_array(mysqli_query($conn,$state_sql));

                                                                $lv_get_shopping_price = "select MIN(Weight_range_price) as Weight_range_price from lsl_delivery_price_master
                                                                                            WHERE Country_from=".$state_result['Country_id']." AND 
                                                                                            State_from=".$key." AND 
                                                                                            Country_to=".$Country_id." AND 
                                                                                            State_to=".$State_id." AND 
                                                                                            Weight_id=".$mv_row898["Weight_id"]."";
                                                                $result44 = mysqli_query($conn,$lv_get_shopping_price);
                                                                $mv_row44 = mysqli_fetch_array($result44);

                                                                //$Shipping_cost8 = round($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                //$lv_total_shopping_points778 = $Shipping_cost8 + $lv_total_shopping_points778;

                                                                $lv_total_shopping_cost8 = $lv_total_shopping_cost8 + $mv_row44['Weight_range_price'];
                                                                $Shipping_cost8 = ($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                $Shipping_cost8 = round( $Shipping_cost8 + 0.499 );
                                                                $lv_total_shopping_points778 = $Shipping_cost8 + $lv_total_shopping_points778;

                                                                $Weight_error_flag[] = 0;
                                                            }
                                                            else
                                                            {
                                                                $Weight_error_flag[] = -1;
                                                            }
                                                    }
                                                /***********************Calculate Combined weight shipping Cost************************/
                                            }
                                        }
                                        $Grand_Total_Points8 = $lv_total_shopping_points778 + $lv_Total_points;
                                    /****************Calculate Details of Cart**************/
                                                                            
                                    $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                              WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                              AND Company_id IN ('".$Company_id."',1)
                                              AND Active_flag='1'
                                              AND Delivery_method IN ('".$Delivery_Method."','3')";
                                    //echo "sql88---------".$sql88;die;
                                    $Item_details = mysqli_query($conn,$sql88);
                                    $Item_check = mysqli_num_rows($Item_details);
                                    
                                    if(in_array("-1", $Weight_error_flag))
                                    {
                                        $CartSql = "SELECT Item_code FROM lsl_temp_cart "
                                                    . "WHERE Company_id=".$Company_id." "
                                                    . "AND Enrollment_id=".$Enrollment_id." "
                                                    . "AND Item_code='".$Company_merchandize_item_code."' "
                                                    . "AND Redemption_method='".$Delivery_Method."' "
                                                    . "AND Branch='".$Branch."' ";
                                        $CartResult = mysqli_query($conn, $CartSql);
                                        $ItemCount = mysqli_num_rows($CartResult);
                                        
                                        echo json_encode(array("status" => "2087", "cart_quantity" => $ItemCount, "status_message" => "This item could not be added as you have exceeded the maximum weight"));die;
                                    }
                                    else if($Item_check > 0)
                                    {
                                        $delete_cart = lslDB::getInstance()->delete_cart($Company_id,$Enrollment_id,$Company_merchandize_item_code,$Delivery_Method,$Branch);

                                        for($i=1;$i<=$Quantity;$i++)
                                        {
                                            $insert_cart = lslDB::getInstance()->temp_cart($Company_id,$Enrollment_id,$Company_merchandize_item_code,$Delivery_Method,$Branch);
                                        }

                                        /*$sql87 = "SELECT Temp_cart_id FROM lsl_temp_cart "
                                                . "WHERE Company_id=".$Company_id." "
                                                . "AND Enrollment_id=".$Enrollment_id."";
                                        $cart_result = mysqli_query($conn,$sql87);
                                        $Cart_quantity87 = mysqli_num_rows($cart_result);*/
                                        
                                        $sql87 = "SELECT TC.Item_code,TC.Redemption_method,TC.Branch FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                  WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                  AND (CM.Delivery_method = TC.Redemption_method
                                                       OR CM.Delivery_method = 3)
                                                  AND CM.Company_id IN ('".$Company_id."',1)
                                                  AND CM.Active_flag='1'
                                                  AND TC.Enrollment_id='".$Enrollment_id."' ";
                                        $Cart_quantity87 = mysqli_num_rows(mysqli_query($conn,$sql87));

                                        $New_Total_Redeemable_points = $Billing_price_in_points * $Quantity;
                                        
                                        /*--------------------------Calculating Totals-----------------------*/
                                            $cart_result23 = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                                            $lv_Total_points2 = 0;
                                            $lv_total_shopping_points = 0;
                            
                                            while($mv_row992 = mysqli_fetch_array($cart_result23))
                                            {
                                                $sqlcheck2 = "SELECT DISTINCT Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row992['Item_code']."'
                                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                                $result992 = mysqli_query($conn,$sqlcheck2);
                                                
                                                $sql882 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                                          WHERE Company_merchandize_item_code = '".$mv_row992['Item_code']."'
                                                          AND Company_id IN ('".$Company_id."',1)
                                                          AND Active_flag='1'
                                                          AND Delivery_method IN ('".$mv_row992['Redemption_method']."','3')";
                                                $Item_check2 = mysqli_num_rows(mysqli_query($conn,$sql882));
                                                
                                                if($Item_check2 > 0)
                                                {
                                                    while($Catalogue2 = mysqli_fetch_array($result992))
                                                    {
                                                        /**************Count Quantity**************/
                                                            $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$Catalogue2["Company_merchandize_item_code"],$mv_row992["Branch"],$mv_row992["Redemption_method"]);
                                                            $quantity2 = mysqli_num_rows($count_quantity);
                                                        /****************************************/
                                                            
                                                        if( ($Company_merchandize_item_code == $mv_row992['Item_code']) && ($mv_row992["Redemption_method"] == $Delivery_Method) && ($mv_row992["Branch"] == $Branch) )
                                                        {
                                                            $quantity2 = $Quantity;
                                                        }

                                                        $lv_weight = $Catalogue2["Weight"] * $quantity2;
                                                        $lv_Weight_unit_id = $Catalogue2["Weight_unit_id"];
                                                        $Redemption_method = $mv_row992["Redemption_method"];
                                                        $lv_Partner_id = $Catalogue2["Partner_id"];
                                                        $lv_Partner_Country_id = $Catalogue2["Country_id"];
                                                        $lv_Partner_State_id = $Catalogue2["State_id"];

                                                        if($Redemption_method == 1)
                                                        {
                                                            $lv_converted_shipping_points = 0;
                                                            $Total_Redeemable_points2 = "";
                                                            $Total_Redeemable_points2 = $quantity2 * $Catalogue2["Billing_price_in_points"];
                                                            $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                                        }
                                                        else
                                                        {
                                                            /**************Conversion Rate for Gram to KG****************/
                                                            if($lv_Weight_unit_id == '6')
                                                            {
                                                                $lv_weight = ($lv_weight / 1000);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Gram to KG****************/

                                                            /**************Conversion Rate for Pound to KG****************/
                                                            if($lv_Weight_unit_id == '7')
                                                            {
                                                                $lv_weight = ($lv_weight * 0.45359);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Pound to KG****************/
                                                            
                                                            $Item_weight2 = $lv_weight;

                                                            /**************Retriving Weight ID *******/
                                                            $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                                 WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                                '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                            $result33 = mysqli_query($conn,$lv_get_weight_id);
                                                             /**************Retriving Weight ID *******/

                                                            $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                            $mv_row89 = mysqli_fetch_array($result89);	
                                                            
                                                            if($Item_weight2 < $Max_weight_range)
                                                            {
                                                                /*******************Combine same state weight************************/
                                                                    if($lv_weight != 0)
                                                                    {
                                                                            $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                                                            $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                                                            $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue2["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                                            if( !array_key_exists($Min_shippin_key,$Weight_array5) )
                                                                            {										
                                                                                    $Weight_array5[$Min_shippin_key] = array("Weight" => $lv_weight);
                                                                            }
                                                                            else
                                                                            {
                                                                                    $New_weight = $Weight_array5[$Min_shippin_key]['Weight'] + $lv_weight;
                                                                                    $Weight_array5[$Min_shippin_key] = array("Weight" => $New_weight);
                                                                            }
                                                                    }
                                                                /*******************Combine same state weight************************/
                                                                    
                                                                $Weight_error_flag2[] = 0;
                                                            }
                                                            else
                                                            {
                                                                $Weight_error_flag2[] = -1;
                                                            }
                                                                
                                                            $calculate_min_shipping_points = lslDB::getInstance()->calculate_min_shipping_points($lv_Partner_id,$Catalogue2["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                            while($mv_row33 = mysqli_fetch_array($result33))
                                                            {
                                                                if($lv_weight == 0)
                                                                {
                                                                    $lv_weight_range_price = 0;
                                                                }
                                                                else
                                                                {
                                                                    $lv_weight_range_price = $calculate_min_shipping_points;
                                                                }

                                                                $lv_converted_shipping_points = ($lv_weight_range_price * $lv_Points_value_definition);	
                                                                $lv_converted_shipping_points = round($lv_converted_shipping_points);											
                                                                $lv_total_shopping_points = $lv_converted_shipping_points + $lv_total_shopping_points;

                                                                $Total_Redeemable_points2 = "";
                                                                $Total_Redeemable_points2 = $quantity2 * $Catalogue2["Billing_price_in_points"];
                                                                $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                                            }
                                                        }
                                                    }
                                                    
                                                    /***********************Calculate Combined weight shipping Cost************************/
                                                        $lv_total_shopping_points77 = 0;
                                                        $lv_Weight_unit_id89 = '5';
                                                        
                                                        foreach($Weight_array5 as $key => $Weight)
                                                        {
                                                                $TotalWeight = number_format((float)$Weight['Weight'], 2, '.', '');
                                                                
                                                                if($TotalWeight < $Max_weight_range)
                                                                {
                                                                    $lv_get_weight_id89 ="select Weight_id from lsl_weight_master where 
                                                                                                              Weight_unit_id=".$lv_Weight_unit_id89." AND 
                                                                                                              '".$TotalWeight."' between Weight_start_range AND Weight_end_range";
                                                                    $result898 = mysqli_query($conn,$lv_get_weight_id89);
                                                                    $mv_row898 = mysqli_fetch_array($result898);

                                                                    $state_sql = "SELECT Country_id FROM lsl_state_master WHERE State_id = ".$key;
                                                                    $state_result = mysqli_fetch_array(mysqli_query($conn,$state_sql));

                                                                    $lv_get_shopping_price = "select MIN(Weight_range_price) as Weight_range_price from lsl_delivery_price_master
                                                                                                                      WHERE Country_from=".$state_result['Country_id']." AND 
                                                                                                                      State_from=".$key." AND 
                                                                                                                      Country_to=".$Country_id." AND 
                                                                                                                      State_to=".$State_id." AND 
                                                                                                                      Weight_id=".$mv_row898["Weight_id"]."";
                                                                    $result44 = mysqli_query($conn,$lv_get_shopping_price);
                                                                    $mv_row44 = mysqli_fetch_array($result44);

                                                                    $Shipping_cost = round($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                    $lv_total_shopping_points77 = $Shipping_cost + $lv_total_shopping_points77;
                                                                    
                                                                    $Weight_error_flag2[] = 0;
                                                                }
                                                                else
                                                                {
                                                                    $Weight_error_flag2[] = -1;
                                                                }
                                                        }
                                                    /***********************Calculate Combined weight shipping Cost************************/
                                                
                                                }
                                            }
                                            
                                        if(in_array("-1", $Weight_error_flag2))
                                        {
                                            $CartSql = "SELECT Item_code FROM lsl_temp_cart "
                                                        . "WHERE Company_id=".$Company_id." "
                                                        . "AND Enrollment_id=".$Enrollment_id." "
                                                        . "AND Item_code='".$Company_merchandize_item_code."' "
                                                        . "AND Redemption_method='".$Delivery_Method."' "
                                                        . "AND Branch='".$Branch."' ";
                                            $CartResult = mysqli_query($conn, $CartSql);
                                            $ItemCount = mysqli_num_rows($CartResult);
                                            
                                            echo json_encode(array("status" => "2087", "cart_quantity" => $ItemCount, "status_message" => "This item could not be added as you have exceeded the maximum weight"));
                                        }
                                        else
                                        {
                                            //$Grand_Total_Points = $lv_total_shopping_points + $lv_Total_points2;
                                            $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points2;
                                            /*--------------------------Calculating Totals-----------------------*/

                                            //echo json_encode(array("status" => "1001", 'Total_Redeemable_points' => $Total_Redeemable_points2, "Cart_quantity" => $Cart_quantity87, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points, "Grand_Total_Points" => $Grand_Total_Points, "Item_shipping_cost" => $lv_converted_shipping_points));
                                            echo json_encode(array("status" => "1001", 'Total_Redeemable_points' => $Total_Redeemable_points2, "Cart_quantity" => $Cart_quantity87, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points77, "Grand_Total_Points" => $Grand_Total_Points, "Item_shipping_cost" => $lv_converted_shipping_points, "status_message" => "Success"));
                                        }
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2034", "Total_points" => $lv_Total_points, "Total_shipping_points" => $lv_total_shopping_points778, "Grand_Total_Points" => $Grand_Total_Points8, "status_message" => "Please check the items in cart"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 32)     //**Update Item Remark
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                            $Delivery_Method = trim($_REQUEST['Delivery_Method']);
                            $Branch = trim($_REQUEST['Branch']);
                            $Remark = trim($_REQUEST['Remark']);
                            
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Parent_enroll_id = $member_details['Parent_enroll_id'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Country_id = $member_details['Country_id'];
                            $State_id = $member_details['State_id'];
                            $Available_current_balance = $Current_balance - $Blocked_points;                          
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else if($Remark == "" || $Remark == NULL)
                            {
                                echo json_encode(array("status" => "2040", "status_message" => "Remark Field is empty"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    /*if($Delivery_Method == 1)
                                    {
                                        $sql88 = "SELECT * FROM lsl_temp_cart "
                                                . "WHERE Item_code='".$Company_merchandize_item_code."' "
                                                . "AND Redemption_method='".$Delivery_Method."' "
                                                . "AND Branch='".$Branch."' "
                                                . "AND Enrollment_id='".$Enrollment_id."' ";
                                    }
                                    else
                                    {
                                        $sql88 = "SELECT * FROM lsl_temp_cart "
                                                . "WHERE Item_code='".$Company_merchandize_item_code."' "
                                                . "AND Redemption_method='".$Delivery_Method."' "
                                                . "AND Branch='' "
                                                . "AND Enrollment_id='".$Enrollment_id."' ";
                                    }*/
                                    
                                    $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                              WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                              AND Company_id IN ('".$Company_id."',1)
                                              AND Active_flag='1'
                                              AND Delivery_method IN ('".$Delivery_Method."','3')";
                                    
                                    $Item_details = mysqli_query($conn,$sql88);
                                    $Item_check = mysqli_num_rows($Item_details);
                                    
                                    if($Item_check > 0)
                                    {
                                        $Update_sql = "UPDATE lsl_temp_cart SET Remark='".$Remark."' "
                                                    . "WHERE Item_code='".$Company_merchandize_item_code."' "
                                                    . "AND Redemption_method='".$Delivery_Method."' ";
                                        $Update_remark = mysqli_query($conn,$Update_sql);
                                        
                                        echo json_encode(array("status" => "1001", "Remark" => $Remark, "status_message" => "Success"));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 23)     //********Delete Item From Cart***
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Country_id = $member_details['Country_id'];
                            $State_id = $member_details['State_id'];
                            $Available_current_balance = $Current_balance - $Blocked_points;
                            
                            $lv_query291 = "SELECT Points_value_definition FROM lsl_loyalty_program_master "
                                         . "WHERE Loyalty_program_id=".$member_details['Loyalty_programme_id']." AND User_apply_to='1'";
                            $lv_result291 = mysqli_query($conn,$lv_query291);
                            $lv_row291 = mysqli_fetch_assoc($lv_result291);
                            $lv_Points_value_definition = $lv_row291["Points_value_definition"];
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                                    $Delivery_Method = trim($_REQUEST['Redemption_method']);
                                    $Branch = trim($_REQUEST['Branch']);
                                    
                                    /*if($Delivery_Method == 1)
                                    {
                                        $sql88 = "SELECT * FROM lsl_temp_cart "
                                                . "WHERE Item_code='".$Company_merchandize_item_code."' "
                                                . "AND Redemption_method='".$Delivery_Method."' "
                                                . "AND Branch='".$Branch."' ";
                                    }
                                    else
                                    {
                                        $sql88 = "SELECT * FROM lsl_temp_cart "
                                                . "WHERE Item_code='".$Company_merchandize_item_code."' "
                                                . "AND Redemption_method='".$Delivery_Method."' "
                                                . "AND Branch='' ";
                                    }*/
                                    
                                    $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                              WHERE Company_merchandize_item_code = '".$Company_merchandize_item_code."'
                                              AND Company_id IN ('".$Company_id."',1)
                                              AND Active_flag='1'
                                              AND Delivery_method IN ('".$Delivery_Method."','3')";
                                    
                                    $Item_details = mysqli_query($conn,$sql88);
                                    $Item_check = mysqli_num_rows($Item_details);
                                    
                                    if($Item_check > 0)
                                    {
                                        $delete_cart = lslDB::getInstance()->delete_cart($Company_id,$Enrollment_id,$Company_merchandize_item_code,$Delivery_Method,$Branch);

                                        /*$sql87 = "SELECT Temp_cart_id FROM lsl_temp_cart "
                                                . "WHERE Company_id=".$Company_id." "
                                                . "AND Enrollment_id=".$Enrollment_id."";
                                        $cart_result = mysqli_query($conn,$sql87);
                                        $Cart_quantity87 = mysqli_num_rows($cart_result);*/
                                        
                                        $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                                  WHERE CM.Company_merchandize_item_code = TC.Item_code
                                                  AND (CM.Delivery_method = TC.Redemption_method
                                                       OR CM.Delivery_method = 3)
                                                  AND CM.Company_id IN ('".$Company_id."',1)
                                                  AND CM.Active_flag='1'
                                                  AND TC.Enrollment_id='".$Enrollment_id."' ";
                                        $Cart_quantity87 = mysqli_num_rows(mysqli_query($conn,$sql87));
                                        
                                        /*--------------------------Calculating Totals-----------------------*/
                                            $cart_result23 = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                                            $lv_Total_points2 = 0;
                                            $lv_total_shopping_points = 0;
                            
                                            while($mv_row992 = mysqli_fetch_array($cart_result23))
                                            {
                                                $sqlcheck2 = "SELECT DISTINCT Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row992['Item_code']."'
                                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                                $result992 = mysqli_query($conn,$sqlcheck2);
                                                
                                                $sql882 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                                          WHERE Company_merchandize_item_code = '".$mv_row992['Item_code']."'
                                                          AND Company_id IN ('".$Company_id."',1)
                                                          AND Active_flag='1'
                                                          AND Delivery_method IN ('".$mv_row992['Redemption_method']."','3')";
                                                $Item_check2 = mysqli_num_rows(mysqli_query($conn,$sql882));
                                                
                                                if($Item_check2 > 0)
                                                {
                                                    while($Catalogue2 = mysqli_fetch_array($result992))
                                                    {
                                                        /**************Count Quantity**************/
                                                            $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$Catalogue2["Company_merchandize_item_code"],$mv_row992["Branch"],$mv_row992["Redemption_method"]);
                                                            $quantity2 = mysqli_num_rows($count_quantity);
                                                        /****************************************/

                                                        $lv_weight = $Catalogue2["Weight"] * $quantity2;
                                                        $lv_Weight_unit_id = $Catalogue2["Weight_unit_id"];
                                                        $Redemption_method = $mv_row992["Redemption_method"];
                                                        $lv_Partner_id = $Catalogue2["Partner_id"];
                                                        $lv_Partner_Country_id = $Catalogue2["Country_id"];
                                                        $lv_Partner_State_id = $Catalogue2["State_id"];

                                                        if($Redemption_method == 1)
                                                        {
                                                            $Total_Redeemable_points2 = "";
                                                            $Total_Redeemable_points2 = $quantity2 * $Catalogue2["Billing_price_in_points"];
                                                            $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                                        }
                                                        else
                                                        {
                                                            /**************Conversion Rate for Gram to KG****************/
                                                            if($lv_Weight_unit_id == '6')
                                                            {
                                                                $lv_weight = ($lv_weight / 1000);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Gram to KG****************/

                                                            /**************Conversion Rate for Pound to KG****************/
                                                            if($lv_Weight_unit_id == '7')
                                                            {
                                                                $lv_weight = ($lv_weight * 0.45359);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Pound to KG****************/

                                                            /**************Retriving Weight ID *******/
                                                            $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                                 WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                                '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                            $result33 = mysqli_query($conn,$lv_get_weight_id);
                                                             /**************Retriving Weight ID *******/

                                                            $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                            $mv_row89 = mysqli_fetch_array($result89);		
                                                            
                                                            /*******************Combine same state weight************************/
															if($lv_weight != 0)
															{
																$get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
																$PartnerDetails89 = mysqli_fetch_array($get_partner_details89);
																
																$Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue2["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);
																
																if( !array_key_exists($Min_shippin_key,$Weight_array) )
																{										
																	$Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
																}
																else
																{
																	$New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
																	$Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
																}
															}
                                                            /*******************Combine same state weight************************/
                                                                
                                                            $calculate_min_shipping_points = lslDB::getInstance()->calculate_min_shipping_points($lv_Partner_id,$Catalogue2["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                            while($mv_row33 = mysqli_fetch_array($result33))
                                                            {
                                                                if($lv_weight == 0)
                                                                {
                                                                    $lv_weight_range_price = 0;
                                                                }
                                                                else
                                                                {
                                                                    $lv_weight_range_price = $calculate_min_shipping_points;
                                                                }

                                                                $lv_converted_shipping_points = ($lv_weight_range_price * $lv_Points_value_definition);	
                                                                $lv_converted_shipping_points = round($lv_converted_shipping_points);											
                                                                $lv_total_shopping_points = $lv_converted_shipping_points + $lv_total_shopping_points;

                                                                $Total_Redeemable_points2 = "";
                                                                $Total_Redeemable_points2 = $quantity2 * $Catalogue2["Billing_price_in_points"];
                                                                $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                                            }
                                                        }
                                                    }
                                                    
                                                    /***********************Calculate Combined weight shipping Cost************************/
                                                        $lv_total_shopping_points77 = 0;
                                                        $lv_Weight_unit_id89 = '5';

                                                        foreach($Weight_array as $key => $Weight)
                                                        {
                                                                $TotalWeight = number_format((float)$Weight['Weight'], 2, '.', '');
                                                                $lv_get_weight_id89 ="select Weight_id from lsl_weight_master where 
                                                                                                          Weight_unit_id=".$lv_Weight_unit_id89." AND 
                                                                                                          '".$TotalWeight."' between Weight_start_range AND Weight_end_range";
                                                                $result898 = mysqli_query($conn,$lv_get_weight_id89);
                                                                $mv_row898 = mysqli_fetch_array($result898);

                                                                $state_sql = "SELECT Country_id FROM lsl_state_master WHERE State_id = ".$key;
                                                                $state_result = mysqli_fetch_array(mysqli_query($conn,$state_sql));

                                                                $lv_get_shopping_price = "select MIN(Weight_range_price) as Weight_range_price from lsl_delivery_price_master
                                                                                                                  WHERE Country_from=".$state_result['Country_id']." AND 
                                                                                                                  State_from=".$key." AND 
                                                                                                                  Country_to=".$Country_id." AND 
                                                                                                                  State_to=".$State_id." AND 
                                                                                                                  Weight_id=".$mv_row898["Weight_id"]."";
                                                                $result44 = mysqli_query($conn,$lv_get_shopping_price);
                                                                $mv_row44 = mysqli_fetch_array($result44);

                                                                $Shipping_cost = round($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                $lv_total_shopping_points77 = $Shipping_cost + $lv_total_shopping_points77;
                                                        }
                                                    /***********************Calculate Combined weight shipping Cost************************/

                                                }
                                            }
                                            //$Grand_Total_Points = $lv_total_shopping_points + $lv_Total_points2;
                                            $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points2;
                                        /*--------------------------Calculating Totals-----------------------*/

                                        //echo json_encode(array("status" => "1001", "Cart_quantity" => $Cart_quantity87, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points, "Grand_Total_Points" => $Grand_Total_Points));
                                        echo json_encode(array("status" => "1001", "Cart_quantity" => $Cart_quantity87, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points77, "Grand_Total_Points" => $Grand_Total_Points, "status_message" => "Success"));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2035", "status_message" => "Item cannot be deleted"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    
                    if($API_flag == 24)  //***Insert Redeemed Item
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Current_balance = $member_details['Current_balance'];
                            $Blocked_points = $member_details['Blocked_points'];
                            $Communication_flag = $member_details['Communication_flag'];
                            $Communication_type = $member_details['Communication_type'];
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Available_current_balance = $Current_balance - $Blocked_points;
                            $City_id = $member_details['City_id'];
                            $Current_address = $member_details['Current_address'];
                            $ShippingAddress = "";
                            $Membership_id_encry = string_encrypt($Membership_id, $key, $iv);
                            $api_error_date = date("Y-m-d H:i:s");
                            $Request_data = json_encode($_REQUEST);
                            
                            $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                            $Company_details = mysqli_fetch_array($Company_result);
                            $Order_no_series = $Company_details['Order_no_series'];
                            $Evoucher_expiry_period = $Company_details['Evoucher_expiry_period'];
                            $Cust_redeem_pin_validation = $Company_details['Cust_redeem_pin_validation'];
                            $Cust_pin_validation = $Company_details['Cust_pin_validation'];
                            $Pin_no_applicable = $Company_details['Pin_no_applicable'];
                            $Company_username = $Company_details['Company_username'];
                            $Company_password2 = $Company_details['Company_password'];
                            $Company_password2 = string_encrypt($Company_password2, $key, $iv);
                            
                            $lv_query291 = "SELECT Points_value_definition FROM lsl_loyalty_program_master "
                                         . "WHERE Loyalty_program_id=".$member_details['Loyalty_programme_id']." AND User_apply_to='1'";
                            $lv_result291 = mysqli_query($conn,$lv_query291);
                            $lv_row291 = mysqli_fetch_assoc($lv_result291);
                            $lv_Points_value_definition = $lv_row291["Points_value_definition"];
                            
                            $Member_pin1 = trim(string_decrypt($_REQUEST['Member_pin'], $key, $iv));
                            $pin_no = preg_replace("/[^(\x20-\x7f)]*/s", "", $Member_pin1);
                            
                            $Remark_array = json_decode($_REQUEST['Remark_array'], true);
							//echo "<------------Remark array----------------->";
							//print_r($Remark_array);
							//echo "<br>";
                            //$Remark_array = $_REQUEST['Remark_array'];
                              //echo "recived encoded array is---"; print_r($_REQUEST['Remark_array']); echo "<br>";   
                              
                               // echo "recived json_decode array is---"; print_r($Remark_array); echo "<br>"; 
                              //die;  
                            $cart_sql87 = "SELECT DISTINCT TC.Company_id,TC.Enrollment_id,TC.Item_code,TC.Redemption_method,TC.Branch,TC.Remark FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                           WHERE CM.Company_merchandize_item_code = TC.Item_code
                                           AND (CM.Delivery_method = TC.Redemption_method
                                                OR CM.Delivery_method = 3)
                                           AND TC.Company_id IN ('".$Company_id."',1)
                                           AND CM.Active_flag='1'
                                           AND TC.Enrollment_id='".$Enrollment_id."' ";
                            $cart_result55 = mysqli_query($conn,$cart_sql87);
                            //$cart_result55 = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                            while($mv_row992 = mysqli_fetch_array($cart_result55))
                            {
                                $Delivery[] = $mv_row992["Redemption_method"];
                            }
                            
                            /*-------------------------------Shipping Details----------------------------*/
                            if(in_array("2", $Delivery))
                            {                            
                                //$Shipping_address = $_REQUEST["ShippingAddress"];
                                $Shipping_address = mysqli_real_escape_string($conn,$_REQUEST["ShippingAddress"]);
                                $countryid2 = $_REQUEST['ShippingCountry'];
                                $stateid2 = $_REQUEST['ShippingState'];
                                $cityid2 = $_REQUEST['ShippingCity'];

                                $Country_query = "SELECT Country_name FROM lsl_country_currency_master WHERE Country_id='".$countryid2."' ";
                                $Country_check = mysqli_num_rows(mysqli_query($conn,$Country_query));
                                $Country_details = mysqli_fetch_assoc(mysqli_query($conn,$Country_query));
                                $Country_name = $Country_details['Country_name'];

                                $State_query = "SELECT State_name FROM lsl_state_master WHERE State_id='".$stateid2."' AND Country_id='".$countryid2."' ";
                                $State_check = mysqli_num_rows(mysqli_query($conn,$State_query));
                                $State_details = mysqli_fetch_assoc(mysqli_query($conn,$State_query));
                                $State_name = $State_details['State_name'];

                                $City_query = "SELECT City_name FROM lsl_city_master WHERE City_id='".$cityid2."' AND State_id='".$stateid2."' ";
                                $City_check = mysqli_num_rows(mysqli_query($conn,$City_query));
                                $City_details = mysqli_fetch_assoc(mysqli_query($conn,$City_query));
                                $City_name = $City_details['City_name'];

                                $ShippingAddress .= $Shipping_address.", ".$City_name.", ".$State_name.", ".$Country_name;
                                $Country_id = $countryid2;
                                $State_id = $stateid2;
                            }
                            else
                            {
                                $Country_id34 = $member_details['Country_id'];
                                $State_id34 = $member_details['State_id'];
                                $City_id34 = $member_details['City_id'];
                                
                                $Shipping_address = $Current_address;
                                $countryid2 = $Country_id34;
                                $stateid2 = $State_id34;
                                $cityid2 = $City_id34;
                                
                                $Country_check = 1;
                                $State_check = 1;
                                $City_check = 1;
                                
                                $Country_id = $countryid2;
                                $State_id = $stateid2;
                            }
                            /*-------------------------------Shipping Details----------------------------*/
                            
                            /*-------------------------------Get maximum weight----------------------------*/
                                $Weight_query = "SELECT MAX(Weight_end_range) as Max_weight_range FROM lsl_weight_master WHERE Weight_unit_id=5";
                                $Weight_details = mysqli_fetch_assoc(mysqli_query($conn,$Weight_query));
                                $Max_weight_range = $Weight_details['Max_weight_range'];
                            /*-------------------------------Get maximum weight----------------------------*/
							
							/*-------------------------------Check for Duplicate order no----------------------------*/
                                $Orderno_query = "SELECT Order_no FROM lsl_transaction WHERE Company_id='".$Company_id."' AND  Order_no='".$Order_no_series."' ";
                                $Orderno_details = mysqli_query($conn,$Orderno_query);
                                $Order_no_check = mysqli_num_rows($Orderno_details);
                            /*-------------------------------Check for Duplicate order no----------------------------*/
                            
                            if($Order_no_check > 0)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "3011", "status_message" => "Invalid Order no."))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "3011", "status_message" => "Invalid Order no."));die;
                            }
                            else if($member_details == NULL)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2003", "status_message" => "Membership ID not found"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));die;
                            }
                            else if( in_array("2", $Delivery) && ( $_REQUEST["ShippingAddress"] == "" && $_REQUEST['ShippingCountry'] == "" && $_REQUEST['ShippingState'] == "" && $_REQUEST['ShippingCity'] == "" ) )
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2085", "status_message" => "Shipping Details are blank"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2085", "status_message" => "Shipping Details are blank"));die;
                            }
                            else if( in_array("2", $Delivery) && $Shipping_address == "" )
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "3010", "status_message" => "Shipping Address is Blank"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "3010", "status_message" => "Shipping Address is Blank"));die;
                            }
                            else if($countryid2 == "" || $countryid2 == NULL || $Country_check == 0)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2043", "status_message" => "Kindly select Country"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2043", "status_message" => "Kindly select Country"));die;
                            }
                            else if($stateid2 == "" || $stateid2 == NULL || $State_check == 0)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2044", "status_message" => "Kindly Select State"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2044", "status_message" => "Kindly Select State"));die;
                            }
                            else if($cityid2 == "" || $cityid2 == NULL || $City_check == 0)
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2045", "status_message" => "Kindly Select City"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2045", "status_message" => "Kindly Select City"));die;
                            }
                            /*else if( ($Cust_pin_validation == 1) && ($Cust_redeem_pin_validation == 1) && ($pin_no == "") )
                            {
                                echo json_encode(array("status" => "2025"));
                            }
                            else if( ($Cust_pin_validation == 1) && ($Cust_redeem_pin_validation == 1) && ($pin_no != $member_details['Pin']) )
                            {
                                echo json_encode(array("status" => "2025"));
                            }*/
                            else
                            {

                                if($member_details['Active_flag'] == 0)
                                {
                                    $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2004", "status_message" => "Membership Disabled / Inactive"))."')";
                                    $api_error_result = mysqli_query($conn, $api_error_sql);
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership Disabled / Inactive"));die;
                                }
                                else
                                {
                                    $Transaction_type_code = "2";
                                    $lv_e_voucher_status=141;
                                    $Source = "API";
                                    $Order_status = 146;
                                    $Transaction_date = date("Y-m-d");
                                    $Member_pin = $pin_no;
                                    
                                    $Item_code = array();   $quantity12 = array();    $Billing_price_in_points = array();   $Partner_location12 = array();
                                    $Total_Redeemable_points12 = array();     $Redemption_method12 = array();   $Partner_id = array();
                                    $Partner_branch = array();   $shipping_points = array();    $Voucher_array = array();   $Info_remark = array(); $Invalid_items = array();
                                    $Invalid_weight_items = array();    $Weight_error_flag = array();
                                    
                                    $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                                    
                                    $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                              WHERE CM.Company_merchandize_item_code = TC.Item_code
                                              AND (CM.Delivery_method = TC.Redemption_method
                                                   OR CM.Delivery_method = 3)
                                              AND CM.Company_id IN ('".$Company_id."',1)
                                              AND CM.Active_flag='1'
                                              AND TC.Enrollment_id='".$Enrollment_id."' ";
                                    $Cart_quantity = mysqli_num_rows(mysqli_query($conn,$sql87));
                                    //$Cart_quantity = mysqli_num_rows($cart_result);
                                    $ItemValidity = 0;
                                    $Remark_item_array = array();
                                    $Merchandize_item_name_array = array();
                                    
                                    if($Cart_quantity > 0)
                                    {
                                        while($mv_row99 = mysqli_fetch_array($cart_result))
                                        {
                                            $sql88 = "SELECT Merchandize_item_code,Delivery_method,Billing_price_in_points FROM lsl_company_merchandise_catalogue
                                                      WHERE Company_merchandize_item_code = '".$mv_row99['Item_code']."'
                                                      AND Company_id IN ('".$Company_id."',1)
                                                      AND Active_flag='1'
                                                      AND Delivery_method IN ('".$mv_row99['Redemption_method']."','3')";
                                            $Item_check = mysqli_num_rows(mysqli_query($conn,$sql88));
                                            
                                            if($Item_check > 0)
                                            {
                                                $sqlcheck = "SELECT DISTINCT Item_image,Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                             FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                             WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                             AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                             AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                                             AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                                $result99 = mysqli_query($conn,$sqlcheck);
                                                $Item_valid = mysqli_num_rows($result99);

                                                if($Item_valid == 0)
                                                {
                                                    $ItemValidity = "-1";
                                                    break;                                                
                                                }
                                                else
                                                {
                                                    while($Catalogue = mysqli_fetch_array($result99))
                                                    {
                                                        /**************Count Quantity**************/
                                                        $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$Catalogue["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                                        $quantity = mysqli_num_rows($count_quantity);
                                                        /****************************************/

                                                        $lv_weight = $Catalogue["Weight"] * $quantity;
                                                        $lv_Weight_unit_id = $Catalogue["Weight_unit_id"];
                                                        $lv_Partner_id = $Catalogue["Partner_id"];
                                                        $lv_Partner_Country_id = $Catalogue["Country_id"];
                                                        $lv_Partner_State_id = $Catalogue["State_id"];
                                                        $Partner_contact_person_name = $Catalogue["Partner_contact_person_name"];
                                                        $Partner_address = $Catalogue["Partner_address"];
                                                        $Redemption_method = $mv_row99["Redemption_method"];
                                                        $Branch = $mv_row99["Branch"];

                                                        if($Redemption_method == 1)
                                                        {
                                                            $lv_converted_shipping_points = 0;

                                                            $sql123 = "SELECT lsl_branch_master.Branch_name,lsl_city_master.City_name FROM lsl_branch_master,lsl_city_master 
                                                                       WHERE lsl_branch_master.City_id=lsl_city_master.City_id
                                                                       AND lsl_branch_master.Branch_code='".$Branch."' ";
                                                            $result123 = mysqli_query($conn,$sql123);
                                                            while($rows123 = mysqli_fetch_array($result123))
                                                            {
                                                                $Partner_location = $rows123['Branch_name'].", ".$rows123['City_name'];
                                                                $Partner_location12[] = $Partner_location;
                                                            }

                                                            $Total_Redeemable_points = "";
                                                            $Total_Redeemable_points = $quantity * $Catalogue["Billing_price_in_points"];
                                                            $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                                            $Redeem_amount_value = $Total_Redeemable_points * $lv_Points_value_definition;

				
                                                            if($Catalogue["Enable_remark"] == 1)
                                                            {
                                                                //$Remark_lable = $Catalogue["Remark_lable"];
                                                                //$Remark = $mv_row99['Remark'];
                                                                //$RemarkS = $Remark_array;
                                                                						                                             
																foreach($Remark_array as $RemarkS)
                                                                {
                                                                 
																 //if ($RemarkS['Redemption_method'] == 1){   
																	if( ($RemarkS['itemcode'] == $Catalogue["Company_merchandize_item_code"]) && ($RemarkS['redeem_method'] == $mv_row99['Redemption_method']) && ($RemarkS['branch'] == $mv_row99["Branch"]) )
                                                                    {
                                                                        $Remark = $RemarkS['remark_value'];
                                                                        $Remark_lable = $Catalogue["Remark_lable"];
                                                                    }
																 //}
                                                                } // close for each
																

                                                                if($Remark != "" || $Remark != NULL)
                                                                {
                                                                    $Final_remark = $Remark_lable." : ".$Remark;
                                                                    $Info_remark[] = $Final_remark;
											
                                                                }
                                                            }// close if enable remark = 1
                                                            else
                                                            {
                                                                $Info_remark[] = "";
                                                            }
																
															
															array_push($Remark_item_array,$Catalogue["Enable_remark"]);
                                                            $Voucher_no = getRandomString();
   
													    }
                                                        else
                                                        {
                                                            /**************Conversion Rate for Gram to KG****************/
                                                            if($lv_Weight_unit_id == '6')
                                                            {
                                                                $lv_weight = ($lv_weight / 1000);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Gram to KG****************/

                                                            /**************Conversion Rate for Pound to KG****************/
                                                            if($lv_Weight_unit_id == '7')
                                                            {
                                                                $lv_weight = ($lv_weight * 0.45359);
                                                                $lv_Weight_unit_id = '5';
                                                            }
                                                            /**************Conversion Rate for Pound to KG****************/
                                                            
                                                            $Item_weight = $lv_weight;

                                                            /**************Retriving Weight ID *******/
                                                            $lv_get_weight_id = "SELECT Weight_id FROM lsl_weight_master 
                                                                                 WHERE  Weight_unit_id=".$lv_Weight_unit_id." AND 
                                                                                '".$lv_weight."' BETWEEN Weight_start_range AND Weight_end_range";
                                                            $result33 = mysqli_query($conn,$lv_get_weight_id);

                                                            $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                            $mv_row89 = mysqli_fetch_array($result89);		
                                                            
                                                            if($Item_weight < $Max_weight_range)
                                                            {
                                                                /*******************Combine same state weight************************/
                                                                if($lv_weight != 0)
                                                                {
                                                                        $get_partner_details89 = lslDB::getInstance()->get_partner_details($lv_Partner_id,$Company_id);
                                                                        $PartnerDetails89 = mysqli_fetch_array($get_partner_details89);

                                                                        $Min_shippin_key = lslDB::getInstance()->calculate_min_shipping_points2($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                                        if( !array_key_exists($Min_shippin_key,$Weight_array) )
                                                                        {										
                                                                                $Weight_array[$Min_shippin_key] = array("Weight" => $lv_weight);
                                                                        }
                                                                        else
                                                                        {
                                                                                $New_weight = $Weight_array[$Min_shippin_key]['Weight'] + $lv_weight;
                                                                                $Weight_array[$Min_shippin_key] = array("Weight" => $New_weight);
                                                                        }
                                                                }
                                                                /*******************Combine same state weight************************/
                                                                
                                                                /*******************select partner branch************************/
                                                                    $Shipping_cost99 = array();
                                                                    $mv_sql99 = "SELECT Branch_code FROM lsl_merchandize_item_child 
                                                                                 WHERE Partner_id='".$lv_Partner_id."' 
                                                                                 AND Merchandize_item_code='".$Catalogue["Company_merchandize_item_code"]."' ";
                                                                    $result99 = mysqli_query($conn,$mv_sql99);
                                                                    while($rows99 = mysqli_fetch_array($result99))
                                                                    {
                                                                        $branch_details99 = lslDB::getInstance()->get_partner_branch_details($rows99['Branch_code'],$lv_Partner_id);
                                                                        while($rows1199 = mysqli_fetch_array($branch_details99))
                                                                        {
                                                                            $lv_get_shopping_price99 = "SELECT MIN(Weight_range_price) as Weight_range_price FROM lsl_delivery_price_master
                                                                                                        WHERE Country_from=".$rows1199['Country_id']." AND 
                                                                                                        State_from=".$rows1199['State_id']." AND 
                                                                                                        Country_to=".$Country_id." AND 
                                                                                                        State_to=".$State_id." AND 
                                                                                                        Weight_id=".$mv_row89["Weight_id"]."";
                                                                            $result4499 = mysqli_query($conn,$lv_get_shopping_price99);
                                                                            while($mv_row4499 = mysqli_fetch_array($result4499))
                                                                            {
                                                                                $Shipping_cost99[$rows99['Branch_code']] = $mv_row4499['Weight_range_price'];
                                                                            }
                                                                        }
                                                                    }

                                                                    $Min_shipping_points99 = min($Shipping_cost99);
                                                                    $Branch = array_search($Min_shipping_points99, $Shipping_cost99);
                                                                /*******************select partner branch************************/
                                                            }
                                                            else
                                                            {
                                                                $Invalid_weight_items[] = array(
                                                                                            "Item_code" => $mv_row99["Item_code"],
                                                                                            "Redemption_method" => $mv_row99["Redemption_method"],
                                                                                            "Branch" => $mv_row99["Branch"],
                                                                                            "Item_weight" => $Item_weight
                                                                                        );
                                                                $Branch = "";
                                                            }
                                                            
                                                            $calculate_min_shipping_points = lslDB::getInstance()->calculate_min_shipping_points($lv_Partner_id,$Catalogue["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);

                                                            while($mv_row33 = mysqli_fetch_array($result33))
                                                            {
                                                                if($lv_weight == 0)
                                                                {
                                                                    $lv_weight_range_price = 0;
                                                                }
                                                                else
                                                                {
                                                                    $lv_weight_range_price = $calculate_min_shipping_points;
                                                                }

                                                                $lv_converted_shipping_points = ($lv_weight_range_price * $lv_Points_value_definition);	
                                                                $lv_converted_shipping_points = round($lv_converted_shipping_points);											
                                                                $lv_total_shopping_points = $lv_converted_shipping_points + $lv_total_shopping_points;
                                                                $Partner_location = " - ";
                                                                $Partner_location12[] = $Partner_location;
                                                                $Total_Redeemable_points = "";
                                                                $Total_Redeemable_points = $quantity * $Catalogue["Billing_price_in_points"];
                                                                $lv_Total_points = $lv_Total_points + $Total_Redeemable_points;
                                                                $Redeem_amount_value = $Total_Redeemable_points * $lv_Points_value_definition;
                                                            }

                                                            if($Catalogue["Enable_remark"] == 1)
                                                            {
                                                                      //echo "<br>";
												  // echo $Catalogue["Company_merchandize_item_code"];
												  // echo "<br>";
												   //echo $mv_row99['Redemption_method'];
												   //echo "<br>";
												   //echo $mv_row99["Branch"];
												   //echo "<br>";
																
																//$Remark_lable = $Catalogue["Remark_lable"];
                                                                //$Remark = $mv_row99['Remark'];
                                                                //$RemarkS = $Remark_array;
																
                                                                foreach($Remark_array as $RemarkS)
                                                                {
																																	 //echo "<br>";
												  // echo "Remarks:".$RemarkS['itemcode'];
												   //echo "<br>";
                                                                 // if ($RemarkS['Redemption_method'] == 2){
																	if( ($RemarkS['itemcode'] == $Catalogue["Company_merchandize_item_code"]) && ($RemarkS['redeem_method'] == $mv_row99['Redemption_method']) && ($RemarkS['branch'] == $mv_row99["Branch"]) )
                                                                    {
                                                                        $Remark = $RemarkS['remark_value'];
                                                                        $Remark_lable = $Catalogue["Remark_lable"];
																		

                                                                    }
																  //}
                                                                
											} // close for each
                                                                if($Remark != "" || $Remark != NULL)
                                                                {
                                                                    $Final_remark = $Remark_lable." : ".$Remark;
                                                                    $Info_remark[] = $Final_remark;
                                                                }
                                                            }// close if enable remark = 1
                                                            else
                                                            {
                                                                $Info_remark[] = "";
                                                            }
                                                            	
															
															
															array_push($Remark_item_array,$Catalogue["Enable_remark"]);
                                                            $Voucher_no = getRandomString1();
                                                        }

                                                        $Item_code[] = $mv_row99['Item_code'];
                                                        $quantity12[] = $quantity;
                                                        $Billing_price_in_points[] = $Catalogue["Billing_price_in_points"];
                                                        $Total_Redeemable_points12[] = $Total_Redeemable_points;
                                                        array_push($Redemption_method12, $Redemption_method);
                                                        array_push($Merchandize_item_name_array, $Catalogue["Merchandize_item_name"]);
                                                        $Partner_id[] = $lv_Partner_id;
                                                        $Partner_branch[] = $Branch;
                                                        $shipping_points[] = $lv_converted_shipping_points;
                                                        $Voucher_array[] = $Voucher_no;
                                                        $Redeem_amt_value_array[] = $Redeem_amount_value;
                                                    }
                                                    
                                                        /***********************Calculate Combined weight shipping Cost************************/
                                                            $lv_total_shopping_points77 = 0;
                                                            $lv_total_shopping_cost = 0;
                                                            $lv_Weight_unit_id89 = '5';

                                                            foreach($Weight_array as $key => $Weight)
                                                            {
                                                                    $TotalWeight = number_format((float)$Weight['Weight'], 2, '.', '');
                                                                    
                                                                    if($TotalWeight < $Max_weight_range)
                                                                    {
                                                                        $lv_get_weight_id89 ="select Weight_id from lsl_weight_master where 
                                                                                                                  Weight_unit_id=".$lv_Weight_unit_id89." AND 
                                                                                                                  '".$TotalWeight."' between Weight_start_range AND Weight_end_range";
                                                                        $result898 = mysqli_query($conn,$lv_get_weight_id89);
                                                                        $mv_row898 = mysqli_fetch_array($result898);

                                                                        $state_sql = "SELECT Country_id FROM lsl_state_master WHERE State_id = ".$key;
                                                                        $state_result = mysqli_fetch_array(mysqli_query($conn,$state_sql));

                                                                        $lv_get_shopping_price = "select MIN(Weight_range_price) as Weight_range_price from lsl_delivery_price_master
                                                                                                                          WHERE Country_from=".$state_result['Country_id']." AND 
                                                                                                                          State_from=".$key." AND 
                                                                                                                          Country_to=".$Country_id." AND 
                                                                                                                          State_to=".$State_id." AND 
                                                                                                                          Weight_id=".$mv_row898["Weight_id"]."";
                                                                        $result44 = mysqli_query($conn,$lv_get_shopping_price);
                                                                        $mv_row44 = mysqli_fetch_array($result44);

                                                                        $lv_total_shopping_cost = $lv_total_shopping_cost + $mv_row44['Weight_range_price'];
                                                                        $Shipping_cost = ($mv_row44['Weight_range_price'] * $lv_Points_value_definition);
                                                                        $Shipping_cost = round( $Shipping_cost + 0.499 );
                                                                        $lv_total_shopping_points77 = $Shipping_cost + $lv_total_shopping_points77;
                                                                    }
                                                                    else
                                                                    {
                                                                        $Invalid_weight_state[] = array(
                                                                                                        "State_id" => $key,
                                                                                                        "Total_weight" => $TotalWeight
                                                                                                );
                                                                    }
                                                            }
                                                            
                                                            if(count($Invalid_weight_state) > 0)
                                                            {
                                                                $Total_shipping_value = 0;
                                                            }
                                                            else
                                                            {                                                                
																$Total_shipping_value = ( $lv_total_shopping_points77 * $lv_Points_value_definition);
                                                            }
                                                        /***********************Calculate Combined weight shipping Cost************************/
                                                }
                                            }
                                            else
                                            {
                                                $Invalid_items[] = array(
                                                        "Item_code" => $mv_row99["Item_code"],
                                                        "Redemption_method" => $mv_row99["Redemption_method"],
                                                        "Branch" => $mv_row99["Branch"]
                                                );
                                            }
                                        }
                                        //var_dump(count($Invalid_items));die;
                                        
                                        //$Grand_Total_Points = $lv_total_shopping_points + $lv_Total_points;
                                        $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points;
                                        $Total_points = $lv_Total_points;
                                        //$Total_shipping_points = $lv_total_shopping_points;         
                                        $Total_shipping_points = $lv_total_shopping_points77;
                                        $Merchandize_item_array = implode("*",$Merchandize_item_name_array);
                                                 
                                        if(count($Invalid_items) > 0)
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2059", "status_message" => "There are Invalid items in the Cart"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2059", "Invalid_items" => $Invalid_items, "Total_points" => $Total_points, "Total_shipping_points" => $Total_shipping_points, "Grand_Total_Points" => $Grand_Total_Points, "status_message" => "There are Invalid items in the Cart"));die;
                                        }
                                        else if($ItemValidity == "-1")
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2037", "status_message" => "An item is not in stock"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2037", "status_message" => "An item is not in stock"));die;
                                        }
                                        else if($Grand_Total_Points > $Available_current_balance)
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));die;
                                        }
                                        else if(count($Remark_item_array) != count($Info_remark))
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2038", "status_message" => "Please fill all the Remark fields"))."')";
											//echo "<br>";
											//print_r($Remark_item_array);
											//echo "<br>";
											//print_r($Info_remark);
											//echo "<br>";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2038", "status_message" => "Please fill all the Remark fields"));die;
                                        }
                                        else if(count($Invalid_weight_items) > 0)
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2087", "status_message" => "This item could not be added as you have exceeded the maximum weight"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2087", "Invalid_weight_items" => $Invalid_weight_items, "status_message" => "This item could not be added as you have exceeded the maximum weight"));die;
                                        }
                                        else if(count($Invalid_weight_state) > 0)
                                        {
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2087", "status_message" => "This item could not be added as you have exceeded the maximum weight"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "2087", "Invalid_weight_items" => $Invalid_weight_items, "status_message" => "This item could not be added as you have exceeded the maximum weight"));die;
                                        }
                                        else
                                        {
                                            /* $Full_name = $_POST['Full_name'];
                                            $Phone_no = $_POST['Phone_no'];
                                            $Email_id = $_POST['Email_id']; */
											
											$InsertError = array();
											$Full_name = mysqli_real_escape_string($conn,$_POST["Full_name"]);
                                            $Phone_no = mysqli_real_escape_string($conn,$_POST["Phone_no"]);
                                            $Email_id = mysqli_real_escape_string($conn,$_POST["Email_id"]);
                                            $contactdetails = "Full Name: ".$Full_name."\nMobile: ".$Phone_no."\nEmail: ".$Email_id."\n";
                                            
                                            for($i=0;$i<count($Item_code);$i++)
                                            {
												$item_sql = "SELECT Billing_price,Cost_payable_to_partner,Merchandize_item_name,Merchandize_category_id FROM lsl_company_merchandise_catalogue
															 WHERE Company_id=".$Company_id." 
															 AND Merchandize_item_code='".$Item_code[$i]."' ";
                                                $Item_details = mysqli_fetch_array(mysqli_query($conn,$item_sql));
                                                $Item_Billing_price = $Item_details["Billing_price"] * $quantity12[$i];
                                                $Item_Cost_payable_to_partner = $Item_details["Cost_payable_to_partner"] * $quantity12[$i];
												
                                                $insert_redeem_transaction = lslDB::getInstance()->insert_redeem_transaction($Transaction_type_code,$Company_id,$Enrollment_id,$Membership_id,$Transaction_date,$Item_code[$i],$quantity12[$i],$Billing_price_in_points[$i],$Total_Redeemable_points12[$i],$Member_pin,$Source,$Redemption_method12[$i],$Redemption_method12[$i],$lv_e_voucher_status,$Order_status,$Voucher_array[$i],$Order_no_series,$Enrollment_id,$Transaction_date,$Partner_id[$i],$Partner_branch[$i],$shipping_points[$i],$ShippingAddress,$Info_remark[$i],$Item_Billing_price,$Item_Cost_payable_to_partner,$Total_shipping_points,$contactdetails,$stateid2,$lv_total_shopping_cost,$Total_shipping_value,$Redeem_amt_value_array[$i]);
												
												if($insert_redeem_transaction > 0)
                                                {
                                                    $InsertError[] = $insert_redeem_transaction;
                                                }
                                                else
                                                {
                                                    foreach($InsertError as $Trans_error)
                                                    {
                                                        $Deletesql = "DELETE FROM lsl_transaction "
                                                                   . "WHERE Transaction_id='".$Trans_error."' "
                                                                   . "AND Company_id='".$Company_id."' "
                                                                   . "AND Member1_enroll_id='".$Enrollment_id."' "
                                                                   . "AND Membership1_id='".$Membership_id."'"
                                                                   . "AND Transaction_type_id=2";
                                                        $result = mysqli_query($conn,$Deletesql);
                                                    }

                                                    echo json_encode(array("status" => "3014", "status_message" => "Error Redeming Item."));exit();
                                                }
											}
											
											for($i=0;$i<count($Item_code);$i++)
											{
                                                /****************************Insert Contact Detail and Remark in lsl_redeemption_contactdetails table********************************/
                                                $item_sql2 = "SELECT Billing_price,Cost_payable_to_partner,Merchandize_item_name,Merchandize_category_id FROM lsl_company_merchandise_catalogue
															 WHERE Company_id=".$Company_id." 
															 AND Merchandize_item_code='".$Item_code[$i]."' ";
                                                $Item_details2 = mysqli_fetch_array(mysqli_query($conn,$item_sql2));
                                                $ItemName = $Item_details2["Merchandize_item_name"];
                                                $Category_id = $Item_details2["Merchandize_category_id"];
												
												$array_explode = explode(" : ", $Info_remark[$i]);
                                                $Remark_details = $array_explode[1];
                                                $Redeem_points_value = $Billing_price_in_points[$i] * $lv_Points_value_definition;
                                                
                                                /* $redeemption_contactdetails_sql = "INSERT INTO lsl_redeemption_contactdetails(Transaction_id,Company_id,Membership_id,Full_name,Phone_no,Email_id,Remark,Transaction_date,Item_name,Quantity,Redeem_points,Redeem_points_value,Total_redeem_points,Redeem_amount_value,Merchandize_Partner_id,Merchandize_category_id,Voucher_no,Item_code,Merchandize_Partner_branch,Status_flag)"
                                                                                . "VALUES('".$insert_redeem_transaction."','".$Company_id."','".$Membership_id."','".$Full_name."','".$Phone_no."','".$Email_id."','".$Remark_details."','".$Transaction_date."','".$ItemName."','".$quantity12[$i]."','".$Billing_price_in_points[$i]."','".$Redeem_points_value."','".$Total_Redeemable_points12[$i]."','".$Redeem_amt_value_array[$i]."','".$Partner_id[$i]."','".$Category_id."','".$Voucher_array[$i]."','".$Item_code[$i]."','".$Partner_branch[$i]."','0')"; */
																				
												$redeemption_contactdetails_sql = "INSERT INTO lsl_redeemption_contactdetails(Transaction_id,Company_id,Membership_id,Full_name,Phone_no,Email_id,Remark,Transaction_date,Item_name,Quantity,Redeem_points,Redeem_points_value,Total_redeem_points,Redeem_amount_value,Merchandize_Partner_id,Merchandize_category_id,Voucher_no,Item_code,Merchandize_Partner_branch,Status_flag)"
                                                                                . "VALUES('".$InsertError[$i]."','".$Company_id."','".$Membership_id."','".$Full_name."','".$Phone_no."','".$Email_id."','".$Remark_details."','".$Transaction_date."','".$ItemName."','".$quantity12[$i]."','".$Billing_price_in_points[$i]."','".$Redeem_points_value."','".$Total_Redeemable_points12[$i]."','".$Redeem_amt_value_array[$i]."','".$Partner_id[$i]."','".$Category_id."','".$Voucher_array[$i]."','".$Item_code[$i]."','".$Partner_branch[$i]."','0')";
                                                $redeemption_contactdetails_result = mysqli_query($conn,$redeemption_contactdetails_sql);
                                                /****************************Insert Contact Detail and Remark in lsl_redeemption_contactdetails table********************************/
                                        
                                                if($Redemption_method12[$i] == 1)
                                                {
                                                    $delete_cart = lslDB::getInstance()->delete_cart($Company_id,$Enrollment_id,$Item_code[$i],$Redemption_method12[$i],$Partner_branch[$i]);
                                                }
                                                else
                                                {
                                                    $delete_cart = lslDB::getInstance()->delete_cart($Company_id,$Enrollment_id,$Item_code[$i],$Redemption_method12[$i],"");
                                                }
                                        
                                                //$delete_cart = lslDB::getInstance()->delete_cart($Company_id,$Enrollment_id,$Item_code[$i],$Redemption_method12[$i],$Partner_branch[$i]);
                                                
                                                $ProgramName = "API Catalogue Redemption";
                                                if($Redemption_method12[$i] == 2)
                                                {
                                                    $delivery_voucher = $Voucher_array[$i];
                                                    $Delivery_redeem_points = $Billing_price_in_points[$i] + $shipping_points[$i];

                                                    // $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($Company_id,$Enrollment_id,$Delivery_redeem_points,$insert_redeem_transaction,$delivery_voucher,$Enrollment_id,$Transaction_date,$ProgramName);
                                                    $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($Company_id,$Enrollment_id,$Delivery_redeem_points,$InsertError[$i],$delivery_voucher,$Enrollment_id,$Transaction_date,$ProgramName);
                                                }
                                                else
                                                {
                                                    // $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($Company_id,$Enrollment_id,$Total_Redeemable_points12[$i],$insert_redeem_transaction,$Voucher_array[$i],$Enrollment_id,$Transaction_date,$ProgramName);
                                                    $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($Company_id,$Enrollment_id,$Total_Redeemable_points12[$i],$InsertError[$i],$Voucher_array[$i],$Enrollment_id,$Transaction_date,$ProgramName);
                                                }
                                            }
                                            
                                            foreach($Redemption_method12 as $redeem_method)
                                            {
                                                if($redeem_method == 1)
                                                {
                                                        $Delivery_mathod1 = 1;
                                                }
                                                else
                                                {
                                                        $Delivery_mathod2 = 2;
                                                }
                                            }
                                            
                                            /************************Update Order No. series in Company Master************************/
                                            $Order_no_series++;
                                            $update_company_master = lslDB::getInstance()->update_company_Order_no_series($Company_id,$Order_no_series);
                                            /******************************************************************************************/

                                            $avail_bal = $Current_balance;
                                            $avail_bal = $avail_bal - $Grand_Total_Points;
                                            $update_member_balance = lslDB::getInstance()->update_member_balance($Company_id,$Enrollment_id,$avail_bal);

                                            if($Delivery_mathod1 == 1)
                                            {
                                                $Template_type_id = 12;     $Email_Type = 14;   $SMS_Type = 14;  //****Redeemption E-voucher**
                                            }
                                            if($Delivery_mathod2 == 2)
                                            {
                                                $Template_type_id = 13;     $Email_Type = 14;   $SMS_Type = 14;  //****Redeemption E-voucher**
                                            }

                                            if($Communication_flag == 1)
                                            {
                                                if($Communication_type == 1 || $Communication_type == 3)
                                                {
                                                    $redeemption_template = lslDB::getInstance()->send_redeemption_template($Company_id,$Enrollment_id,"",$Merchandize_item_array,$Order_no_series,$Transaction_date,$quantity12,$Billing_price_in_points,$Redemption_method12,$Voucher_array,$avail_bal,$Blocked_points,$Total_points,$Total_shipping_points,$Grand_Total_Points,$Partner_branch,$Partner_location12,$Redemption_method12,$Redemption_method12,$Evoucher_expiry_period,$Email_Type,$Template_type_id,$ShippingAddress,$Info_remark);
                                                }

                                                if($Communication_type == 2 || $Communication_type == 3)
                                                {
                                                    $redeemption_sms_template = lslDB::getInstance()->send_redeemption_template_sms($Company_id,$Enrollment_id,$Order_no_series,$Partner_branch,$Partner_location12,$SMS_Type,$Template_type_id);
                                                }
                                            }
                                            
                                            $new_member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                                            $new_member_details = mysqli_fetch_array($new_member_details_result);
                                            $New_Current_balance = $new_member_details['Current_balance'];
                                                                                       
                                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "1001", "status_message" => "Success"))."')";
                                            $api_error_result = mysqli_query($conn, $api_error_sql);
                                            echo json_encode(array("status" => "1001", "Shipping_Address" => $ShippingAddress, "Current_balance" => $New_Current_balance, "status_message" => "Success"));die;
                                                
                                            //echo json_encode($response);
                                        }
                                    }
                                    else
                                    {
                                        $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2012", "status_message" => "No Data Found"))."')";
                                        $api_error_result = mysqli_query($conn, $api_error_sql);
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));die;
                                    }
                                }
                            }
                        }
                        else
                        {
                            $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"))."')";
                            $api_error_result = mysqli_query($conn, $api_error_sql);
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                    }
                    
                    if($API_flag == 28)     //**Calculate Shipping Cost
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Enrollment_id = $member_details['Enrollment_id'];
                            $Current_balance = $member_details['Current_balance'] - $member_details['Blocked_points'];
                            
                            $lv_query291 = "SELECT Points_value_definition FROM lsl_loyalty_program_master "
                                         . "WHERE Loyalty_program_id=".$member_details['Loyalty_programme_id']." AND User_apply_to='1'";
                            $lv_result291 = mysqli_query($conn,$lv_query291);
                            $lv_row291 = mysqli_fetch_assoc($lv_result291);
                            $Points_value_definition = $lv_row291["Points_value_definition"];
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Country_id = trim($_REQUEST['Country_id']);
                                    $State_id = trim($_REQUEST['State_id']);
                                    
                                    $cart_result = lslDB::getInstance()->get_cart($Company_id,$Enrollment_id);
                                    $lv_Total_points2 = 0;
                                    $lv_total_shopping_points = 0;
                                    
                                    while($mv_row99 = mysqli_fetch_array($cart_result))
                                    {
                                        $sqlcheck = "SELECT DISTINCT Enable_remark,Remark_lable,Delivery_method,Company_merchandize_item_code,Merchandize_item_name,Billing_price_in_points,Weight,Weight_unit_id,lsl_company_merchandise_catalogue.Partner_id,lsl_partner_master.Country_id,lsl_partner_master.State_id,lsl_partner_master.Partner_contact_person_name,lsl_partner_master.Partner_address 
                                                     FROM lsl_company_merchandise_catalogue ,lsl_partner_master 
                                                     WHERE lsl_partner_master.Partner_id=lsl_company_merchandise_catalogue.Partner_id 
                                                     AND lsl_company_merchandise_catalogue.Company_id=".$Company_id." 
                                                     AND lsl_company_merchandise_catalogue.Company_merchandize_item_code='".$mv_row99['Item_code']."'
                                                     AND lsl_company_merchandise_catalogue.Active_flag='1' ";
                                        $result99 = mysqli_query($conn,$sqlcheck);
                                        
                                        while($mv_row22 = mysqli_fetch_array($result99))
                                        {
                                            /**************Count Quantity**************/
                                                $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$En