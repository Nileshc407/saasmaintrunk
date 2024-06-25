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
														
														$Description = "Delivery for Order no. ".$p_row1['Order_no'];
														
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
														
														$Description = "Delivery for Order no. ".$p_row1['Order_no'];
														
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
                            
                            /*-------------------------------Delivery Details----------------------------*/
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
                            /*-------------------------------Delivery Details----------------------------*/
                            
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
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "2085", "status_message" => "Delivery Details are blank"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "2085", "status_message" => "Delivery Details are blank"));die;
                            }
                            else if( in_array("2", $Delivery) && $Shipping_address == "" )
                            {
                                $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$api_error_date."','".$Request_data."','".json_encode(array("status" => "3010", "status_message" => "Delivery Address is Blank"))."')";
                                $api_error_result = mysqli_query($conn, $api_error_sql);
                                echo json_encode(array("status" => "3010", "status_message" => "Delivery Address is Blank"));die;
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
                    
                    if($API_flag == 28)     //**Calculate Delivery Cost
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
                                                $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$mv_row22["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                                $quantity2 = mysqli_num_rows($count_quantity);
                                            /****************************************/
                                                        
                                            $Redemption_method = $mv_row99["Redemption_method"];
                                            
                                            if($Redemption_method == 1)
                                            {
                                                $Total_Redeemable_points2 = "";
                                                $Total_Redeemable_points2 = $quantity2 * $mv_row22["Billing_price_in_points"];
                                                $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                            }
                                            else
                                            {
                                                /**************Count Quantity**************/
                                                    $count_quantity = lslDB::getInstance()->count_cart_items($Company_id,$Enrollment_id,$mv_row22["Company_merchandize_item_code"],$mv_row99["Branch"],$mv_row99["Redemption_method"]);
                                                    $quantity = mysqli_num_rows($count_quantity);
                                                /****************************************/
                                                
                                                $lv_weight = $mv_row22["Weight"] * $quantity;
                                                $lv_Weight_unit_id = $mv_row22["Weight_unit_id"];
                                                $lv_Partner_id = $mv_row22["Partner_id"];
                                                
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
                                                $result89 = mysqli_query($conn,$lv_get_weight_id);
                                                $mv_row89 = mysqli_fetch_array($result89);	
                                                
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
                                                                
                                                $calculate_min_shipping_points = lslDB::getInstance()->calculate_min_shipping_points($lv_Partner_id,$mv_row22["Company_merchandize_item_code"],$Company_id,$mv_row89["Weight_id"],$Country_id,$State_id);
                                                
                                                if($lv_weight == 0)
                                                {
                                                    $lv_weight_range_price = 0;
                                                }
                                                else
                                                {
                                                    $lv_weight_range_price = $calculate_min_shipping_points;
                                                }
                                                
                                                $lv_converted_shipping_points = ($lv_weight_range_price * $Points_value_definition);
                                                $lv_converted_shipping_points = round($lv_converted_shipping_points);
                                                $lv_total_shopping_points = $lv_converted_shipping_points + $lv_total_shopping_points;
                                                
                                                $Total_Redeemable_points2 = "";
                                                $Total_Redeemable_points2 = $quantity2 * $mv_row22["Billing_price_in_points"];
                                                $lv_Total_points2 = $lv_Total_points2 + $Total_Redeemable_points2;
                                            
                                                $Shipping_array[] = array(
                                                        "Item_code" => $mv_row99['Item_code'],
                                                        "Delivery_method" => "2",
                                                        "shipping_points" => $lv_converted_shipping_points
                                                );
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
                                                    
                                                    $Shipping_cost = round($mv_row44['Weight_range_price'] * $Points_value_definition);
                                                    $lv_total_shopping_points77 = $Shipping_cost + $lv_total_shopping_points77;
                                            }
                                        /***********************Calculate Combined weight shipping Cost************************/
                                    }
                                    
                                    //$Grand_Total_Points = $lv_total_shopping_points + $lv_Total_points2;
                                    $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points2;
                                    
                                    if($Grand_Total_Points > $Current_balance)
                                    {
                                        echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                                    }
                                    else
                                    {
                                        //$Status_array = array("status" => "1001", "Current_balance" => $Current_balance, "Shipping_details" => $Shipping_array, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points, "Grand_Total_Points" => $Grand_Total_Points);
                                        $Status_array = array("status" => "1001", "Current_balance" => $Current_balance, "Shipping_details" => $Shipping_array, "Total_points" => $lv_Total_points2, "Total_shipping_points" => $lv_total_shopping_points77, "Grand_Total_Points" => $Grand_Total_Points, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }                                    
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Customer Catalogue********************************/
                    
                    /************************************Fetch Catalogue Country********************************/
                    if($API_flag == 25)
                    {
                        $query1 = "SELECT Country_id,Country_name FROM lsl_country_currency_master";
                        $Country_result = mysqli_query($conn,$query1);
                        $Country_count = mysqli_num_rows($Country_result);
                        
                        if($Country_count > 0)
                        {
                            while($Country = mysqli_fetch_array($Country_result))
                            {
                                $Country_details[] = array(
                                                    "Country_id" => $Country['Country_id'],
                                                    "Country_name" => $Country['Country_name']
                                                );
                            }

                            /*$Status_array = array("status" => "1001");
                            $Country_details = array_merge($Country_details,$Status_array);
                            echo json_encode($Country_details);*/
                            
                            $Status_array = array("status" => "1001", "Country_details" => $Country_details, "status_message" => "Success");
                            echo json_encode($Status_array);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                        }
                    }
                    /************************************Fetch Country********************************/
                    
                    /************************************Fetch Catalogue State********************************/
                    if($API_flag == 26)
                    {
                        $Country_id = trim($_REQUEST['Country_id']);
                        
                        $query1 = "SELECT State_id,State_name FROM lsl_state_master WHERE Country_id='".$Country_id."' ";
                        $State_result = mysqli_query($conn,$query1);
                        $State_count = mysqli_num_rows($State_result);
                        
                        if($State_count > 0)
                        {
                            while($State = mysqli_fetch_array($State_result))
                            {
                                $State_details[] = array(
                                                    "State_id" => $State['State_id'],
                                                    "State_name" => $State['State_name']
                                                );
                            }

                            /*$Status_array = array("status" => "1001");
                            $State_details = array_merge($State_details,$Status_array);
                            echo json_encode($State_details);*/
                            
                                $Status_array = array("status" => "1001", "State_details" => $State_details, "status_message" => "Success");
                            echo json_encode($Status_array);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                        }
                    }
                    /************************************Fetch State********************************/
                    
                    /************************************Fetch Catalogue City********************************/
                    if($API_flag == 27)
                    {
                        $State_id = trim($_REQUEST['State_id']);
                        
                        $query1 = "SELECT City_id,City_name FROM lsl_city_master WHERE State_id='".$State_id."' ";
                        $City_result = mysqli_query($conn,$query1);
                        $City_count = mysqli_num_rows($City_result);
                        
                        if($City_count > 0)
                        {
                            while($City = mysqli_fetch_array($City_result))
                            {
                                $City_details[] = array(
                                                    "City_id" => $City['City_id'],
                                                    "City_name" => $City['City_name']
                                                );
                            }

                            /*$Status_array = array("status" => "1001");
                            $City_details = array_merge($City_details,$Status_array);
                            echo json_encode($City_details);*/
                            
                            $Status_array = array("status" => "1001", "City_details" => $City_details, "status_message" => "Success");
                            echo json_encode($Status_array);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                        }
                    }
                    /************************************Fetch City********************************/
                    
                    /************************************Notification API********************************/
                    if($API_flag == 33)  //***change a notification from unread to read
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => ""));
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            //$Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $User_notification_id = trim($_REQUEST['User_notification_id']);
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
                                else if($User_notification_id == "0" || $User_notification_id == "" || $User_notification_id == NULL)
                                {
                                    echo json_encode(array("status" => "2041", "status_message" => "Notification ID is Empty"));
                                }
                                else
                                {
                                    $query1 = "UPDATE lsl_user_notification_master SET Note_open='1' WHERE User_notification_id=".$User_notification_id;
                                    $update_notification_status = mysqli_query($conn,$query1);
                                    
                                    $query1 = "SELECT * FROM lsl_user_notification_master
                                               WHERE Company_id=".$Company_id."
                                               AND User_email_id='".$member_details['User_email_id']."'
                                               AND Membership_id='".$member_details['Membership_id']."'
                                               AND Disable_flag='0'
                                               AND Note_open='0' ";
                                    $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));
                                    
                                    echo json_encode(array("status" => "1001", "Total_unread_notifications" => $Total_unread_notifications, "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    
                    if($API_flag == 34)  //***return the total numer of unread notifications
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            //$Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
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
                                    $query1 = "SELECT * FROM lsl_user_notification_master
                                               WHERE Company_id=".$Company_id."
                                               AND User_email_id='".$member_details['User_email_id']."'
                                               AND Membership_id='".$member_details['Membership_id']."'
                                               AND Disable_flag='0'
                                               AND Note_open='0' ";
                                    $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));
                                    
                                    echo json_encode(array("status" => "1001", "Total_unread_notifications" => $Total_unread_notifications, "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Notification API********************************/
                    
                    /************************************Change Member Pin********************************/
                    if($API_flag == 35)  //***change pin
                    {
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                        else if($_REQUEST['Current_pin'] == "" || $_REQUEST['New_pin'] == "")
                        {
                            echo json_encode(array("status" => "2047", "status_message" => "PIN Field is empty"));die;
                        }
                        else
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $Current_pin = trim(string_decrypt($_REQUEST['Current_pin'], $key, $iv));
                            $Current_pin = preg_replace("/[^(\x20-\x7f)]*/s", "", $Current_pin);
                            
                            $New_pin = trim(string_decrypt($_REQUEST['New_pin'], $key, $iv));
                            $New_pin = preg_replace("/[^(\x20-\x7f)]*/s", "", $New_pin);
                            
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Communication_flag   = $member_details['Communication_flag'];
                            $Communication_type   = $member_details['Communication_type'];
                            
                            //echo "Pin-------------".$member_details['Pin']."<br>";
                            //echo "Current Pin-------------".$Current_pin."<br>";
                            
                            $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                            $Company_details = mysqli_fetch_array($Company_result);
                            
                            $Middleware_flag = 0;

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
                                else if($member_details['Pin'] != $Current_pin)
                                {
                                    echo json_encode(array("status" => "2046", "status_message" => "Your Pin Does not Match"));die;
                                }
                                else
                                {
                                    $changepin = lslDB::getInstance()->changepin($member_details['User_email_id'],$Current_pin,$New_pin,$member_details['Enrollment_id']);
                                    
                                    $sql ="UPDATE lsl_enrollment_master SET Pin='".$New_pin."' WHERE Membership_id='".$Membership_id."' AND Enrollment_id='".$member_details['Enrollment_id']."' AND Company_id='$Company_id' ";
                                    //$result = mysqli_query($conn,$sql);
                                    
                                    if($Communication_flag == 1 && ($Communication_type == 1 || $Communication_type == 2 || $Communication_type == 3) )
                                    {
                                        if($Communication_type == 1 || $Communication_type == 3)
                                        {
                                            $Middleware_flag = 1;
                                            $Template_type_id = 24;     $Email_Type = 23;
                                            $customer_info_template = lslDB::getInstance()->send_customer_info_template($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$New_pin,$Email_Type,$Template_type_id);
                                        }                                        
                                        if( $Company_details['Pin_password_sms'] == 1 && ($Communication_type == 2 || $Communication_type == 3) )
                                        {
                                            $Middleware_flag = 0;
                                            $Template_smstype_id = 27;  $SMS_Type = 23; 
                                            $customer_info_smstemplate = lslDB::getInstance()->callcenter_sendinfo_customer_smstemplate($member_details['Enrollment_id'],$Company_id,$member_details['Enrollment_id'],$New_pin,$SMS_Type,$Template_smstype_id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    /************************************Change Member Pin********************************/
                    
                    /************************************Fetch Benefit Partners********************************/
                    if($API_flag == 36)
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
                                    
                                    $lv_query33 = "SELECT * FROM lsl_partner_master,lsl_partner_category,lsl_city_master,lsl_state_master
                                                   WHERE lsl_partner_master.Partner_category_id=lsl_partner_category.Partner_category_id 
                                                   AND lsl_partner_master.City_id=lsl_city_master.City_id
                                                   AND lsl_partner_master.State_id=lsl_state_master.State_id
                                                   AND lsl_partner_master.Active_flag='1' 
                                                   AND lsl_partner_master.Company_id IN (".$Company_id.",1) 
                                                   AND lsl_partner_master.Partner_type IN (2,3)
                                                   GROUP BY lsl_partner_master.Partner_name
                                                   ORDER BY lsl_partner_master.Partner_id
                                                   ".$LIMIT." ";
                                    
                                    $lv_result33 = mysqli_query($conn,$lv_query33);
                                    while($lv_row33 = mysqli_fetch_assoc($lv_result33))
                                    {
                                        if($lv_row33["Partner_logo"] == "")
                                        {
                                            $Partner_logo = "https://demo.perxclm2.com/images/no_image.jpeg";
                                        }
                                        else
                                        {
                                            $Partner_logo = "https://demo.perxclm2.com/".$lv_row33["Partner_logo"];
                                        }
                                        
                                        $lv_query303 = "SELECT cmp.Benefit_description,cmp.Campaign_sub_type,ps.Partner_subcategory_name
                                                        FROM lsl_campaign_master as cmp, lsl_partner_master as partner,lsl_partner_subcategory as ps
                                                        WHERE cmp.Active_flag='1' 
                                                        AND cmp.Benefit_partner_id=partner.Partner_id 
                                                        AND (   cmp.Partner_subcategory_id = ps.Partner_subcategory_id
                                                            OR cmp.Upgrade_privilege = ps.Partner_subcategory_id    )
                                                        AND cmp.Company_id=".$Company_id." AND partner.Partner_id='".$lv_row33["Partner_id"]."'";
                                        $lv_result303 = mysqli_query($conn,$lv_query303);
                                        while ($lv_row303 = mysqli_fetch_assoc($lv_result303))
                                        {
                                            if($lv_row303['Campaign_sub_type'] == 122)
                                            {
                                                $Benefit_description = $lv_row303["Benefit_description"]." To ".$lv_row303["Partner_subcategory_name"];
                                            }
                                            else
                                            {
                                                $Benefit_description = $lv_row303["Benefit_description"]." On ".$lv_row303["Partner_subcategory_name"];
                                            }
                                            $Benefit_details[] = array( "Benefit_description" => $Benefit_description );
                                        }
                                        
                                        $Benefit_partner_details[] = array(
                                                    "Partner_name" => $lv_row33["Partner_name"],
                                                    "Partner_logo" => $Partner_logo,
                                                    "Partner_address" => $lv_row33["Partner_address"],
                                                    "Partner_contact_person_phno" => $lv_row33["Partner_contact_person_phno"],
                                                    "Partner_contact_person_email" => $lv_row33["Partner_contact_person_email"],
                                                    "Partner_category_name" => $lv_row33["Partner_category_name"],
                                                    "State_name" => $lv_row33["State_name"],
                                                    "City_name" => $lv_row33["City_name"],
                                                    "Partner_website" => $lv_row33["Partner_website"],
                                                    "Benefit_details" => $Benefit_details
                                        );
                                    }
                                    
                                    echo json_encode(array("status" => "1001", "Benefit_partner_details" => $Benefit_partner_details, "status_message" => "Success"));
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Fetch Benefit Partners********************************/
                    
                    /************************************Enrollment********************************/
                    if($API_flag == 29)
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else if($_REQUEST['Membership_ID'] != "")
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);
                            
                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE User_email_id='".$Username."' "
                                    . "AND Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id IN (1,'".$Company_id."') ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2058", "status_message" => "Logged in user is In-active or disabled"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_ID'], $key, $iv));
                                    $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                                    
                                    $First_name = trim($_REQUEST['First_name']);
                                    $Last_name = trim($_REQUEST['Last_name']);
                                    $Email_ID = trim($_REQUEST['Email_ID']);
                                    $Phone_NO = trim($_REQUEST['Phone_No']);
                                    $Communication_flag = trim($_REQUEST['Communication_flag']);
                                    $Referee_id1 = trim(string_decrypt($_REQUEST['Referee_id'], $key, $iv));
                                    $Referee_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Referee_id1);
                                    $Membership_id_length = strlen($Membership_id);
                                    $Enroll_date = date("Y-m-d");
                                    
                                    if($Communication_flag == 1)
                                    {
                                        if($_REQUEST['Communication_type'] == "" || $_REQUEST['Communication_type'] == 0)
                                        {
                                            $Communication_type = 1;
                                        }
                                        else
                                        {
                                            $Communication_type = trim($_REQUEST['Communication_type']);
                                        }
                                    }
                                    else
                                    {
                                        $Communication_type = 0;
                                    }

                                    /*-------------------Company Details-------------------*/
                                        $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                                        $Company_details = mysqli_fetch_array($Company_result);
                                        $user_pin_applicable = $Company_details['Pin_no_applicable'];
                                        $Joining_bonus_flag = $Company_details['Joining_bonus'];
                                        $Member_expiry = $Company_details['Member_expiry'];
                                        $company_communication = $Company_details['Evoucher_source'];
                                        $Membership_generation = $Company_details['Membership_generation'];
                                        $Total_membership_cards = $Company_details['Total_membership_cards'];
                                        $Membership_card_length = $Company_details['Membership_card_length'];
                                        $Country_id = $Company_details['Country_id'];
                                        $Region_id = $Company_details['Region_id'];
                                        $Zone_id = $Company_details['Zone_id'];
                                        $State_id = $Company_details['State_id'];
                                        $City_id = $Company_details['City_id'];
                                        $Timezone = $Company_details['Timezone'];
                                        $company_balance = $Company_details['Current_balance'];
                                        $Domain = $Company_details['Domain'];
                                        $Company_communication = $Company_details['Evoucher_source'];
                                        $Enrollment_sms = $Company_details['Enrollment_sms'];
                                        $Referred_by = $Company_details['Referred_by'];

                                        if($Joining_bonus_flag == 1)
                                        {
                                            $Joining_bonus_points = $Company_details['Joining_bonus_points'];
                                        }
                                    /*-------------------Company Details-------------------*/

                                    /*-------------------Fetch Lowest Tier-------------------*/
                                        $query8 = "SELECT MIN(Tier_level_id) FROM lsl_tier_master "
                                                . "WHERE Company_id=".$Company_id." "
                                                . "AND Active_flag=1";
                                        $res82 = mysqli_query($conn,$query8);
                                        while($row8 = mysqli_fetch_array($res82))
                                        {
                                            $lowest_tier = $row8['MIN(Tier_level_id)'];
                                        }

                                        $query7 =  "SELECT * FROM lsl_tier_master "
                                                 . "WHERE Company_id=".$Company_id." "
                                                 . "AND Active_flag=1 "
                                                 . "AND Tier_level_id='".$lowest_tier."' ";
                                        $res7 = mysqli_query($conn,$query7);
                                        while($row7 = mysqli_fetch_array($res7))
                                        {
                                            $Tier_id = $row7['Tier_id'];
                                        }
                                    /*-------------------Fetch Lowest Tier-------------------*/

                                    /*-------------------Fetch Loyalty Program-------------------*/
                                        $query1 = "SELECT * FROM lsl_loyalty_program_master "
                                                . "WHERE Company_id=".$Company_id." "
                                                . "AND Active_flag=1 "
                                                . "AND User_apply_to=1 ORDER BY Loyalty_program_id ASC LIMIT 1";
                                        $res1 = mysqli_query($conn,$query1);

                                        while($row1 = mysqli_fetch_array($res1))
                                        {
                                            $Cust_Loyalty_programme_id = $row1['Loyalty_program_id'];
                                        }
                                    /*-------------------Fetch Loyalty Program-------------------*/

                                    /*-------------------Membership ID Check-------------------*/
                                        if($Membership_generation == 1)
                                        {
                                            $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master WHERE Membership_id='".$Membership_id."' 
                                                          AND Company_id=".$Company_id;
                                            $lv_results1 = mysqli_query($conn,$lv_query1);
                                            $Membership_check = mysqli_num_rows($lv_results1);
                                        }

                                        /*if($Membership_generation == 3)
                                        {
                                            $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master "
                                                       . "WHERE Membership_id='".$Membership_id."' "
                                                       . "AND First_name='' AND Last_name='' "
                                                       . "User_email_id='' AND Company_id='".$Company_id."' ";                                
                                            $lv_results1 = mysqli_query($conn,$lv_query1);
                                            $Membership_check = mysqli_num_rows($lv_results1);
                                        }*/
                                        
                                        if($Membership_generation == 3)
                                        {
                                            $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master "
                                                        . "WHERE Membership_id='".$Membership_id."' "
                                                        . "AND First_name<>'' AND Last_name<>'' "
                                                        . "AND User_email_id<>'' AND Company_id='".$Company_id."' ";                                
                                            $lv_results1 = mysqli_query($conn,$lv_query1);                                                
                                            $Membership_check23 = mysqli_num_rows($lv_results1);
                                            
                                            $lv_query19 = "SELECT Membership_id,Enrollment_id FROM lsl_enrollment_master "
                                                        . "WHERE Membership_id='".$Membership_id."' "
                                                        . "AND First_name='' AND Last_name='' "
                                                        . "AND User_email_id='' AND Company_id='".$Company_id."' ";                                
                                            $lv_results19 = mysqli_query($conn,$lv_query19);
                                            $Pregenerated_member_details = mysqli_fetch_array($lv_results19);
                                            $Valid_Membershipid = mysqli_num_rows($lv_results19);
                                        }
                                    /*-------------------Membership ID Check-------------------*/

                                    /*-------------------Get Total Membership ID Enrolled Count -------------------*/
                                        if($Membership_generation == 1 || $Membership_generation == 2 || $Membership_generation == 3)
                                        {
                                            $wquery = "SELECT COUNT(*) FROM lsl_enrollment_master "
                                                    . "WHERE Company_id='".$Company_id."' 
                                                      AND (Membership_id <> 0 OR Membership_id <> '' OR Membership_id <> 'NULL') 
                                                      AND First_name='' AND Last_name='' AND User_email_id='' AND User_type_id=1";			   
                                            $wresult = mysqli_query($conn,$wquery);		
                                            while($wrows = mysqli_fetch_array($wresult))
                                            {
                                                $assigned_membership_cards = $wrows['count(*)'];
                                            }
                                        }
                                    /*-------------------Get Total Membership ID Enrolled Count -------------------*/

                                    /*-------------------Pin,Password,Membership_validity,Password_expiry_date-------------------*/
                                        if($user_pin_applicable == 1)
                                        {
                                            $Pin = getRandomString2();
                                        }
                                        else
                                        {
                                            $Pin = "";
                                        }

                                        if($Phone_NO != "")
                                        {
                                            $Password = $Phone_NO;
                                        }
                                        else
                                        {
                                            $Password = getRandomString3();
                                        }

                                        if($Member_expiry != '0')
                                        {
                                            $Membership_validity = date("Y-m-d",strtotime("+$Member_expiry year"));
                                        }
                                        else
                                        {
                                            $Membership_validity = "0000-00-00";
                                        }

                                        $Password_expiry_date = "";
                                     /*-------------------Pin,Password,Membership_validity,Password_expiry_date-------------------*/

                                    if( ($Membership_generation == 1 || $Membership_generation == 3) && ($_REQUEST['Membership_ID'] == "" || $Membership_id == "" || $Membership_id == NULL) )
                                    {
                                        echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                                    }
                                    else if( $Membership_generation == 1 && ($Membership_check > 0 || $Membership_check != NULL || $Membership_check != 0) )
                                    {
                                        echo json_encode(array("status" => "2029", "status_message" => "Membership ID Already Exist"));
                                    }
                                    else if( $Membership_generation == 3 && $Membership_check23 != 0)
                                    {
                                        echo json_encode(array("status" => "2029", "status_message" => "Membership ID Already Exist"));
                                    }
                                    else if( $Membership_generation == 3 && ($Valid_Membershipid != 0 || $Valid_Membershipid != NULL)) 
                                    {
                                        echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                                    }
                                    /*else if( $Communication_flag == 1 && ($Communication_type == "" || $Communication_type == NULL) )
                                    {
                                        echo json_encode(array("status" => "2048"));
                                    }*/
                                    else
                                    {
                                        if( ($Membership_generation == 1) && ($Membership_id_length != $Membership_card_length) )
                                        {
                                            echo json_encode(array("status" => "2031", "status_message" => "Check Membership ID Character Length "));
                                        }
                                        else if($assigned_membership_cards >= $Total_membership_cards)
                                        {
                                            echo json_encode(array("status" => "2033", "status_message" => "Membership Card Limit Exceeded"));
                                        }
                                        else
                                        {
                                            if($Email_ID != "")
                                            {
                                                $lv_query = "SELECT * FROM lsl_enrollment_master "
                                                            . "WHERE User_email_id='".$Email_ID."' "
                                                            . "AND Company_id='$Company_id' "
                                                            . "AND User_type_id ='1'";
                                                $lv_result = mysqli_query($conn,$lv_query);
                                                $Email_check = mysqli_num_rows($lv_result);
                                                if($Email_check > 0)
                                                {
                                                    echo json_encode(array("status" => "2030", "status_message" => "Email ID Already Exist"));die;
                                                    //$Email_id12 = getRandomString3();
                                                    //$Email_id = $Email_id12."@".$Domain;
                                                }
                                                else
                                                {
                                                    $Email_id = $Email_ID;
                                                }
                                            }
                                            else
                                            {
                                                $Email_id12 = getRandomString3();
                                                $Email_id = $Email_id12."@".$Domain;
                                            }

                                            if($Phone_NO != "")
                                            {
                                                $query708 = lslDB::getInstance()->get_country_details($Country_id);			
                                                while($row807 = mysqli_fetch_array($query708))
                                                {
                                                    $dial_code = $row807['Dial_code'];
                                                }
                                                $Phno = ltrim($Phone_NO, '0');
                                                $new_Phno = $dial_code.$Phno;

                                                $lv_query2 = "SELECT * FROM lsl_enrollment_master "
                                                            . "WHERE Phone_no='".$new_Phno."' "
                                                            . "AND Company_id='$Company_id' "
                                                            . "AND User_type_id ='1'";
                                                $lv_result2 = mysqli_query($conn,$lv_query2);
                                                $Phoneno_check = mysqli_num_rows($lv_result2);
                                                if($Phoneno_check > 0)
                                                {
                                                    echo json_encode(array("status" => "2032", "status_message" => "Phone No Already Exist"));die;
                                                }
                                                else
                                                {
                                                    $Phoneno = $Phone_NO;
                                                }
                                            }

                                            //************** Issue points to referee by Refferal Campaign ********************/                                            
                                                if($Referred_by == 1 && $_REQUEST['Referee_id'] != "" && $_REQUEST['Referee_id'] != NULL)
                                                {
                                                    $Referee_flag = 0;                                                    
                                                    $Referee_details_result = lslDB::getInstance()->get_member_details($Referee_id,$Company_id);
                                                    $Referee_details = mysqli_fetch_array($Referee_details_result);
                                                    
                                                    if($Referee_details == NULL)
                                                    {
                                                        echo json_encode(array("status" => "2060", "status_message" => "Unable to Find Referee Membership ID"));die;
                                                    }
                                                    else
                                                    {
                                                        if($Referee_details['Active_flag'] == 0)
                                                        {
                                                            echo json_encode(array("status" => "2061", "status_message" => "Referee Membership Disabled / Inactive"));die;
                                                        }
                                                        else
                                                        {
                                                            $todays = date("Y-m-d");
                                                            $myquery1 = "SELECT * FROM lsl_campaign_master 
                                                                         WHERE Campaign_type =32 
                                                                         AND Campaign_sub_type=124 
                                                                         AND Active_flag='1' 
                                                                         AND Company_id='".$Company_id."'
                                                                         AND To_date >= '".$todays."' ";
                                                            $myquery1_exe = mysqli_query($conn,$myquery1);
                                                            while($myres1 = mysqli_fetch_array($myquery1_exe))
                                                            {
                                                                if(($todays >= $myres1['From_date']) && ($todays <= $myres1['To_date']))
                                                                {					
                                                                    $CampaignID[] = $myres1['Campaign_id'];							
                                                                }	
                                                            }

                                                            foreach($CampaignID as $cmp_id)
                                                            {
                                                                $Referee_id_info = lslDB::getInstance()->get_member_details($Referee_id,$Company_id);

                                                                if($Referee_id_info != NULL)
                                                                {
                                                                    while($res1 = mysqli_fetch_array($Referee_id_info))
                                                                    {
                                                                        $user_email_id = $res1['User_email_id'];
                                                                        $Lprogramme_id = $res1['Loyalty_programme_id'];			
                                                                        $user_pin = $res1['Pin']; 	
                                                                        $branch_code = $res1['Branch_code'];
                                                                        $lv_member_balance = $res1['Current_balance'];
                                                                        $lv_purchase_amount = $res1['Total_purchase_amount'];
                                                                        $lv_bonus_points = $res1['Total_bonus_points'];
                                                                        $lv_redeem_points = $res1['Total_redeem_points'];
                                                                        $lv_gained_points = $res1['Total_gained_points'];
                                                                        $lv_First_name = $res1['First_name'];
                                                                        $lv_Last_name = $res1['Last_name'];					
                                                                        $Refree_enroll_id = $res1['Enrollment_id'];					
                                                                    }

                                                                    $cmp_info = lslDB::getInstance()->get_campaign_details($cmp_id);
                                                                    while($cmp_res = mysqli_fetch_array($cmp_info))
                                                                    {
                                                                        $Loyalty_programme_id = $cmp_res['Loyalty_programme_id'];
                                                                        $cmp_points = $cmp_res['Reward_points'];
                                                                        if($Loyalty_programme_id == $Lprogramme_id)
                                                                        {
                                                                            $Member_balance = $lv_member_balance + $cmp_points;	
                                                                            $total_referee_gained_points = $lv_gained_points + $cmp_points;	
                                                                            $update_memberbal =  lslDB::getInstance()->update_member_balance_details($Refree_enroll_id,$Member_balance,$lv_redeem_points,$lv_purchase_amount,$total_referee_gained_points,$Company_id);

                                                                            $get_loyalty_program =  lslDB::getInstance()->get_loyalty_program_details($Loyalty_programme_id,$Company_id);
                                                                            while($rw_lpname = mysqli_fetch_array($get_loyalty_program))
                                                                            {
                                                                                $Loyalty_program_name = $rw_lpname['Loyalty_program_name'];
                                                                            }	

                                                                            if($cmp_points > 0)
                                                                            {
                                                                                $Template_type_id = 55;     $Email_Type = 348;
                                                                                $send_referee_email =  lslDB::getInstance()->send_referee_email_template($Company_id,$Refree_enroll_id,$cmp_id,$cmp_points,$Loyalty_programme_id,$lv_First_name,$lv_Last_name,$user_email_id,$Fname,$Lname,$Member_balance,$Email_Type,$Template_type_id);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $Referee_flag = 1;
                                                        }
                                                    }
                                                }
                                                else if($Referred_by == 0 && $_REQUEST['Referee_id'] != "" && $_REQUEST['Referee_id'] != NULL)
                                                {
                                                    echo json_encode(array("status" => "2062", "status_message" => "Refereree flag is not set for company"));die;
                                                }
                                            //************** Issue points to referee by Refferal Campaign ********************/
                                            
                                            if($Membership_generation == 3)
                                            {
                                                $query708 = lslDB::getInstance()->get_country_details($Country_id);			
                                                while($row807 = mysqli_fetch_array($query708))
                                                {
                                                    $dial_code = $row807['Dial_code'];
                                                }
                                                $Phno = ltrim($Phone_NO, '0');
                                                $new_Phno = $dial_code.$Phno;

                                                $Update_enroll_query = "UPDATE lsl_enrollment_master SET Partner_id='0',Branch_code='',User_group_id='',User_type_id='1',First_name='".$First_name."',Middle_name='',Last_name='".$Last_name."',"
                                                                     . "Phone_no='".$new_Phno."',User_email_id='".$Email_id."',Communication_email_id='',Password='".$Password."',Qualification='',Current_address='".$Address."',"
                                                                     . "Country_id='".$Country_id."',Region_id='".$Region_id."',Zone_id='".$Zone_id."',State_id='".$State_id."',City_id='".$City_id."',Zipcode='',Timezone_entry='".$Timezone."',
                                                                        Wedding_annversary_date='',Date_of_birth='',Sex='',Pin='".$Pin."',Active_flag='1',Referee_flag='".$Referee_flag."',Referee_id='".$Refree_enroll_id."',Tier_id='".$Tier_id."',
                                                                        Employee_flag='',Employee_id='',Parent_enroll_id='0',Account_number='',Membership_id='".$Membership_id."',Membership_validity='".$Membership_validity."',Password_expiry_date='".$Password_expiry_date."',
                                                                        Familly_flag='0',Family_redeem_limit='0',Loyalty_programme_id='".$Cust_Loyalty_programme_id."',Communication_flag='".$Communication_flag."',
                                                                        Communication_type='".$Communication_type."',Source='0',Update_user_id='0',Update_date='".$Enroll_date."'
                                                                        ,Photograph='',Enroll_date='".$Enroll_date."',Current_balance='".$Joining_bonus_points."',Total_bonus_points='".$Joining_bonus_points."' "
                                                                      . "WHERE Company_id=".$Company_id." AND Enrollment_id=".$Pregenerated_member_details['Enrollment_id'];
                                                $Update_enroll_result = mysqli_query($conn,$Update_enroll_query);

                                                $User_enrollment = $Pregenerated_member_details['Enrollment_id'];

                                                /*****************Send Email****************/
                                                    if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                    {
                                                        $Template_type_id = 1;  $Email_Type = 9;
                                                        $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                    }

                                                    if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                    {
                                                        $SMS_Type = 9;  $Template_smstype_id = 1;
                                                        if($Enrollment_sms == 1)
                                                        {
                                                            $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                        }
                                                    }
                                                /*****************Send Email End****************/

                                                /*********** Joining Bonus Entry in Transaction tbl ***************/
                                                    if( $Joining_bonus_flag == 1)
                                                    {
                                                        $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;

                                                        $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                        $company_balance12 = $company_balance - $Joining_bonus_points;
                                                        $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                    }	
                                                //*********** Joining Bonus Entry in Transaction tbl ***************

                                                echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
                                                
                                                
                                                /*$lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master "
                                                            . "WHERE Membership_id='".$Membership_id."' "
                                                            . "AND First_name<>'' AND Last_name<>'' "
                                                            . "AND User_email_id<>'' AND Company_id='".$Company_id."' ";                                
                                                $lv_results1 = mysqli_query($conn,$lv_query1);                                                
                                                $Membership_check23 = mysqli_num_rows($lv_results1);
                                                
                                                if($Membership_check23 == 0)
                                                {
                                                    $lv_query19 = "SELECT Membership_id,Enrollment_id FROM lsl_enrollment_master "
                                                                . "WHERE Membership_id='".$Membership_id."' "
                                                                . "AND First_name='' AND Last_name='' "
                                                                . "AND User_email_id='' AND Company_id='".$Company_id."' ";                                
                                                    $lv_results19 = mysqli_query($conn,$lv_query19);
                                                    $Pregenerated_member_details = mysqli_fetch_array($lv_results19);
                                                    $Valid_Membershipid = mysqli_num_rows($lv_results19);
                                                                                                    
                                                    if($Valid_Membershipid == 0 || $Valid_Membershipid == NULL)
                                                    {
                                                        echo json_encode(array("status" => "2003"));die;
                                                    }
                                                    else
                                                    {
                                                        $query708 = lslDB::getInstance()->get_country_details($Country_id);			
                                                        while($row807 = mysqli_fetch_array($query708))
                                                        {
                                                            $dial_code = $row807['Dial_code'];
                                                        }
                                                        $Phno = ltrim($Phone_NO, '0');
                                                        $new_Phno = $dial_code.$Phno;
                                                        
                                                        /*$mv_toenrollid124 = lslDB::getInstance()->update_user_enrollment($Pregenerated_member_details['Enrollment_id'],$Company_id,'0','','','1',$First_name,'',$Last_name,
                                                                        $new_Phno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                                        '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'0','0',$Cust_Loyalty_programme_id,
                                                                        $Communication_flag,$Communication_type,'0','0',$Enroll_date,'');

                                                        $mv_toenrollid124 = lslDB::getInstance()->update_user_enrollment($Pregenerated_member_details['Enrollment_id'],$Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                                        $new_Phno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                                        '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'0','0',$Cust_Loyalty_programme_id,
                                                                        $Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);*
                                                        
                                                        $Update_enroll_query = "UPDATE lsl_enrollment_master SET Partner_id='0',Branch_code='',User_group_id='',User_type_id='1',First_name='".$First_name."',Middle_name='',Last_name='".$Last_name."',"
                                                                             . "Phone_no='".$new_Phno."',User_email_id='".$Email_id."',Communication_email_id='',Password='".$Password."',Qualification='',Current_address='".$Address."',"
                                                                             . "Country_id='".$Country_id."',Region_id='".$Region_id."',Zone_id='".$Zone_id."',State_id='".$State_id."',City_id='".$City_id."',Zipcode='',Timezone_entry='".$Timezone."',
                                                                                Wedding_annversary_date='',Date_of_birth='',Sex='',Pin='".$Pin."',Active_flag='1',Referee_flag='".$Referee_flag."',Referee_id='".$Refree_enroll_id."',Tier_id='".$Tier_id."',
                                                                                Employee_flag='',Employee_id='',Parent_enroll_id='0',Account_number='',Membership_id='".$Membership_id."',Membership_validity='".$Membership_validity."',Password_expiry_date='".$Password_expiry_date."',
                                                                                Familly_flag='0',Family_redeem_limit='0',Loyalty_programme_id='".$Cust_Loyalty_programme_id."',Communication_flag='".$Communication_flag."',
                                                                                Communication_type='".$Communication_type."',Source='0',Update_user_id='0',Update_date='".$Enroll_date."'
                                                                                ,Photograph='',Enroll_date='".$Enroll_date."',Current_balance='".$Joining_bonus_points."',Total_bonus_points='".$Joining_bonus_points."' "
                                                                              . "WHERE Company_id=".$Company_id." AND Enrollment_id=".$Pregenerated_member_details['Enrollment_id'];
                                                        $Update_enroll_result = mysqli_query($conn,$Update_enroll_query);
                                                        
                                                        $mv_toenrollid12 = $Pregenerated_member_details['Enrollment_id'];

                                                        /*****************Send Email****************
                                                            if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                            {
                                                                $Template_type_id = 1;  $Email_Type = 9;
                                                                $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                            }

                                                            if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                            {
                                                                $SMS_Type = 9;  $Template_smstype_id = 1;
                                                                if($Enrollment_sms == 1)
                                                                {
                                                                    $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                                }
                                                            }
                                                        /*****************Send Email End****************/

                                                        /*********** Joining Bonus Entry in Transaction tbl ***************
                                                            if( $Joining_bonus_flag == 1)
                                                            {
                                                                $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;

                                                                $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                                $company_balance12 = $company_balance - $Joining_bonus_points;
                                                                $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                            }	
                                                        //*********** Joining Bonus Entry in Transaction tbl ***************

                                                        echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv)));die;
                                                    }
                                                }
                                                else
                                                {
                                                    echo json_encode(array("status" => "2029"));
                                                }*/
                                            }
                                            
                                            if($Membership_generation == 1)
                                            {
                                                $User_enrollment = lslDB::getInstance()->insert_user_enrollment($Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                        $Phoneno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                        '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'0','0',$Cust_Loyalty_programme_id,
                                                        $Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);  

                                                /*****************Send Email****************/
                                                    if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                    {
                                                        $Template_type_id = 1;  $Email_Type = 9;
                                                        $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                    }

                                                    if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                    {
                                                        $SMS_Type = 9;  $Template_smstype_id = 1;
                                                        if($Enrollment_sms == 1)
                                                        {
                                                            $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                        }
                                                    }
                                                /*****************Send Email End****************/

                                                //*********** Joining Bonus Entry in Transaction tbl ***************
                                                    if( $Joining_bonus_flag == 1)
                                                    {
                                                        $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;

                                                        $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                        $company_balance12 = $company_balance - $Joining_bonus_points;
                                                        $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                    }		
                                                //*********** Joining Bonus Entry in Transaction tbl ***************

                                                echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
                                            }

                                            if($Membership_generation == 2)
                                            {
                                                $vquery = "SELECT Membership_id FROM lsl_automated_membershipid "
                                                        . "WHERE Utilized='0' "
                                                        . "AND Company_id='".$Company_id."' "
                                                        . "LIMIT 2";
                                                $run_vquery = mysqli_query($conn,$vquery);
                                                $res_vquery = mysqli_fetch_array($run_vquery);
                                                //$Auto_member_check = mysqli_num_rows($run_vquery);
                                                $Membership_id = $res_vquery['Membership_id'];
                                                
                                                $User_enrollment = lslDB::getInstance()->insert_user_enrollment($Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                        $Phoneno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                        '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'0','0',$Cust_Loyalty_programme_id,
                                                        $Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);  

                                                $update_membershipid = lslDB::getInstance()->update_auto_membershipid($Company_id,$Membership_id);
                                                
                                                /*****************Send Email****************/
                                                    if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                    {
                                                        $Template_type_id = 1;  $Email_Type = 9;
                                                        $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                    }

                                                    if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                    {
                                                        $SMS_Type = 9;  $Template_smstype_id = 1;
                                                        if($Enrollment_sms == 1)
                                                        {
                                                            $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                        }
                                                    }
                                                /*****************Send Email End****************/

                                                //*********** Joining Bonus Entry in Transaction tbl ***************
                                                    if( $Joining_bonus_flag == 1)
                                                    {
                                                        $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;

                                                        $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                        $company_balance12 = $company_balance - $Joining_bonus_points;
                                                        $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                    }		
                                                //*********** Joining Bonus Entry in Transaction tbl ***************

                                                echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
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
                    
                    if($API_flag == 30)     //***Check / Validate Referee Membership ID
                    {
                        if($_REQUEST['Referee_MembershipId'] != "")
                        {
                            //$Membership_id1 = trim(string_decrypt($_REQUEST['Referee_MembershipId'], $key, $iv));
                            //$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            
                            $Membership_id = trim($_REQUEST['Referee_MembershipId']);
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
                                    $Membership_details = array(
                                                            "status" => "1001",
                                                            "First_name" => $member_details['First_name'],
                                                            "Last_name" => $member_details['Last_name'],
                                                            "Phone_no" => $member_details['Phone_no'],
                                                            "status_message" => "Success"
                                                        );
                                    echo json_encode($Membership_details);
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Enrollment********************************/
                    
                    /************************************Family Member Enrollment********************************/
                    if($API_flag == 45)
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else if($_REQUEST['Parent_memberid'] == "")
                        {
                            echo json_encode(array("status" => "2050", "status_message" => "Parent Membership Id is empty"));
                        }
                        else if($_REQUEST['Family_Membership_ID'] != "")
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);
                            
                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE User_email_id='".$Username."' "
                                    . "AND Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2058", "status_message" => "Logged in user is In-active or disabled"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $Membership_id1 = trim(string_decrypt($_REQUEST['Family_Membership_ID'], $key, $iv));
                                    $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                                    $Parent_memberid = trim($_REQUEST['Parent_memberid']);
                                    //$Membership_id = trim($_REQUEST['Family_Membership_ID']);
                                    $First_name = trim($_REQUEST['Family_First_name']);
                                    $Last_name = trim($_REQUEST['Family_Last_name']);
                                    $Email_ID = trim($_REQUEST['Family_Email_ID']);
                                    $Phone_NO = trim($_REQUEST['Family_Phone_NO']);
                                    $Family_Communication_flag = trim($_REQUEST['Family_Communication_flag']);
                                    $Family_Redemption_limit = trim($_REQUEST['Family_Redemption_limit']);
                                    $Membership_id_length = strlen($Membership_id);
                                    $Enroll_date = date("Y-m-d");
                                    
                                    $$Parent_member_result = lslDB::getInstance()->get_member_details($Parent_memberid,$Company_id);
                                    $Parent_member_details = mysqli_fetch_array($$Parent_member_result);
                                    
                                    if($Family_Communication_flag == 1)
                                    {
                                        if($_REQUEST['Family_Communication_type'] == "" || $_REQUEST['Family_Communication_type'] == 0)
                                        {
                                            $Communication_type = 1;
                                        }
                                        else
                                        {
                                            $Communication_type = trim($_REQUEST['Family_Communication_type']);
                                        }
                                    }
                                    else
                                    {
                                        $Communication_type = 0;
                                    }
                                    
                                    /*-----------------Family Member Enrollment Count-----------------------*/
                                        $dpQuery = "SELECT Enrollment_id FROM lsl_enrollment_master "
                                                 . "WHERE Parent_enroll_id='".$Parent_member_details['Enrollment_id']."' "
                                                 . "AND Company_id='".$Company_id."' ";
                                        $dpres = mysqli_query($conn,$dpQuery);
                                        $dprow = mysqli_num_rows($dpres);

                                        $queryEE = "SELECT * FROM lsl_website_enrollment "
                                                 . "WHERE Parent_email_id='".$Parent_member_details['User_email_id']."' "
                                                 . "AND Company_id='".$Company_id."' "
                                                 . "AND Flag='0'";
                                        $dpresEE = mysqli_query($conn,$queryEE);
                                        $dprowEE = mysqli_num_rows($dpresEE);
                                        
                                        $dprowTD = $dprow + $dprowEE;
                                    /*-----------------Family Member Enrollment Count-----------------------*/

                                    if($Parent_member_details == NULL)
                                    {
                                        echo json_encode(array("status" => "2051", "status_message" => "Parent Membership ID Not Found"));
                                    }
                                    else if($dprowTD > 3)
                                    {
                                        echo json_encode(array("status" => "2052", "status_message" => "Family Member Enrollment Has Been Exceeded"));
                                    }
                                    else if(!is_numeric($Family_Redemption_limit))
                                    {
                                        echo json_encode(array("status" => "2053", "status_message" => "Invalid Redemption Limit"));
                                    }
                                    else
                                    {
                                        /*-------------------Company Details-------------------*/
                                            $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                                            $Company_details = mysqli_fetch_array($Company_result);
                                            $user_pin_applicable = $Company_details['Pin_no_applicable'];
                                            $Joining_bonus_flag = $Company_details['Joining_bonus'];
                                            $Member_expiry = $Company_details['Member_expiry'];
                                            $company_communication = $Company_details['Evoucher_source'];
                                            $Membership_generation = $Company_details['Membership_generation'];
                                            $Total_membership_cards = $Company_details['Total_membership_cards'];
                                            $Membership_card_length = $Company_details['Membership_card_length'];
                                            $Country_id = $Company_details['Country_id'];
                                            $Region_id = $Company_details['Region_id'];
                                            $Zone_id = $Company_details['Zone_id'];
                                            $State_id = $Company_details['State_id'];
                                            $City_id = $Company_details['City_id'];
                                            $Timezone = $Company_details['Timezone'];
                                            $company_balance = $Company_details['Current_balance'];
                                            $Domain = $Company_details['Domain'];
                                            $Company_communication = $Company_details['Evoucher_source'];
                                            $Enrollment_sms = $Company_details['Enrollment_sms'];
                                            $Referred_by = $Company_details['Referred_by'];

                                            if($Joining_bonus_flag == 1)
                                            {
                                                $Joining_bonus_points = $Company_details['Joining_bonus_points'];
                                            }
                                        /*-------------------Company Details-------------------*/

                                        /*-------------------Fetch Lowest Tier-------------------*/
                                            $query8 = "SELECT MIN(Tier_level_id) FROM lsl_tier_master "
                                                    . "WHERE Company_id=".$Company_id." "
                                                    . "AND Active_flag=1";
                                            $res82 = mysqli_query($conn,$query8);
                                            while($row8 = mysqli_fetch_array($res82))
                                            {
                                                $lowest_tier = $row8['MIN(Tier_level_id)'];
                                            }

                                            $query7 =  "SELECT * FROM lsl_tier_master "
                                                     . "WHERE Company_id=".$Company_id." "
                                                     . "AND Active_flag=1 "
                                                     . "AND Tier_level_id='".$lowest_tier."' ";
                                            $res7 = mysqli_query($conn,$query7);
                                            while($row7 = mysqli_fetch_array($res7))
                                            {
                                                $Tier_id = $row7['Tier_id'];
                                            }
                                        /*-------------------Fetch Lowest Tier-------------------*/

                                        /*-------------------Fetch Loyalty Program-------------------*/
                                            $query1 = "SELECT * FROM lsl_loyalty_program_master "
                                                    . "WHERE Company_id=".$Company_id." "
                                                    . "AND Active_flag=1 "
                                                    . "AND User_apply_to=1 ORDER BY Loyalty_program_id ASC LIMIT 1";
                                            $res1 = mysqli_query($conn,$query1);

                                            while($row1 = mysqli_fetch_array($res1))
                                            {
                                                $Cust_Loyalty_programme_id = $row1['Loyalty_program_id'];
                                            }
                                        /*-------------------Fetch Loyalty Program-------------------*/

                                        /*-------------------Membership ID Check-------------------*/
                                            if($Membership_generation == 1)
                                            {
                                                $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master WHERE Membership_id='".$Membership_id."' 
                                                              AND Company_id=".$Company_id;
                                                $lv_results1 = mysqli_query($conn,$lv_query1);
                                                $Membership_check = mysqli_num_rows($lv_results1);
                                            }

                                            /*if($Membership_generation == 3)
                                            {
                                                $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master "
                                                           . "WHERE Membership_id='".$Membership_id."' "
                                                           . "AND First_name='' AND Last_name='' "
                                                           . "User_email_id='' AND Company_id='".$Company_id."' ";                                
                                                $lv_results1 = mysqli_query($conn,$lv_query1);
                                                $Membership_check = mysqli_num_rows($lv_results1);
                                            }*/
                                            
                                            if($Membership_generation == 3)
                                            {
                                                $lv_query1 = "SELECT Membership_id FROM lsl_enrollment_master "
                                                            . "WHERE Membership_id='".$Membership_id."' "
                                                            . "AND First_name<>'' AND Last_name<>'' "
                                                            . "AND User_email_id<>'' AND Company_id='".$Company_id."' ";                                
                                                $lv_results1 = mysqli_query($conn,$lv_query1);                                                
                                                $Membership_check23 = mysqli_num_rows($lv_results1);

                                                $lv_query19 = "SELECT Membership_id,Enrollment_id FROM lsl_enrollment_master "
                                                            . "WHERE Membership_id='".$Membership_id."' "
                                                            . "AND First_name='' AND Last_name='' "
                                                            . "AND User_email_id='' AND Company_id='".$Company_id."' ";                                
                                                $lv_results19 = mysqli_query($conn,$lv_query19);
                                                $Pregenerated_member_details = mysqli_fetch_array($lv_results19);
                                                $Valid_Membershipid = mysqli_num_rows($lv_results19);
                                            }
                                        /*-------------------Membership ID Check-------------------*/

                                        /*-------------------Get Total Membership ID Enrolled Count -------------------*/
                                            if($Membership_generation == 1 || $Membership_generation == 2 || $Membership_generation == 3)
                                            {
                                                $wquery = "SELECT COUNT(*) FROM lsl_enrollment_master "
                                                        . "WHERE Company_id='".$Company_id."' 
                                                          AND (Membership_id <> 0 OR Membership_id <> '' OR Membership_id <> 'NULL') 
                                                          AND First_name='' AND Last_name='' AND User_email_id='' AND User_type_id=1";			   
                                                $wresult = mysqli_query($conn,$wquery);		
                                                while($wrows = mysqli_fetch_array($wresult))
                                                {
                                                    $assigned_membership_cards = $wrows['count(*)'];
                                                }
                                            }
                                        /*-------------------Get Total Membership ID Enrolled Count -------------------*/

                                        /*-------------------Pin,Password,Membership_validity,Password_expiry_date-------------------*/
                                            if($user_pin_applicable == 1)
                                            {
                                                $Pin = getRandomString2();
                                            }
                                            else
                                            {
                                                $Pin = "";
                                            }

                                            if($Phone_NO != "")
                                            {
                                                $Password = $Phone_NO;
                                            }
                                            else
                                            {
                                                $Password = getRandomString3();
                                            }

                                            if($Member_expiry != '0')
                                            {
                                                $Membership_validity = date("Y-m-d",strtotime("+$Member_expiry year"));
                                            }
                                            else
                                            {
                                                $Membership_validity = "0000-00-00";
                                            }

                                            $Password_expiry_date = "";
                                         /*-------------------Pin,Password,Membership_validity,Password_expiry_date-------------------*/

                                        /*if( ($Membership_generation == 1 || $Membership_generation == 2) || $Membership_check > 0)
                                        {
                                            echo json_encode(array("status" => "2029"));
                                        }
                                        else if( $Membership_generation == 3 && $Membership_check23 != 0)
                                        {
                                            echo json_encode(array("status" => "2029"));
                                        }
                                        else if( $Membership_generation == 3 && ($Valid_Membershipid != 0 || $Valid_Membershipid != NULL)) 
                                        {
                                            echo json_encode(array("status" => "2003"));
                                        }
                                        else if($_REQUEST['Family_Membership_ID'] == "")
                                        {
                                            echo json_encode(array("status" => "2006"));
                                        }*/
                                        
                                        if( ($Membership_generation == 1 || $Membership_generation == 3) && ($_REQUEST['Family_Membership_ID'] == "" || $Membership_id == "" || $Membership_id == NULL) )
                                        {
                                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                                        }
                                        else if( ($Membership_generation == 1) || $Membership_check > 0)
                                        {
                                            echo json_encode(array("status" => "2029", "status_message" => "Membership ID Already Exist"));
                                        }
                                        else if( $Membership_generation == 3 && $Membership_check23 != 0)
                                        {
                                            echo json_encode(array("status" => "2029", "status_message" => "Membership ID Already Exist"));
                                        }
                                        else if( $Membership_generation == 3 && ($Valid_Membershipid != 0 || $Valid_Membershipid != NULL)) 
                                        {
                                            echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                                        }
                                        /*else if($Communication_type == "" || $Communication_type == NULL)
                                        {
                                            echo json_encode(array("status" => "2048"));
                                        }*/
                                        else
                                        {
                                            if( ($Membership_generation == 1) && ($Membership_id_length != $Membership_card_length) )
                                            {
                                                echo json_encode(array("status" => "2031", "status_message" => "Check Membership ID Character Length "));
                                            }
                                            else if($assigned_membership_cards >= $Total_membership_cards)
                                            {
                                                echo json_encode(array("status" => "2033", "status_message" => "Membership Card Limit Exceeded"));
                                            }
                                            else
                                            {
                                                if($Email_ID != "")
                                                {
                                                    $lv_query = "SELECT * FROM lsl_enrollment_master "
                                                                . "WHERE User_email_id='".$Email_ID."' "
                                                                . "AND Company_id='$Company_id' "
                                                                . "AND User_type_id ='1'";
                                                    $lv_result = mysqli_query($conn,$lv_query);
                                                    $Email_check = mysqli_num_rows($lv_result);
                                                    if($Email_check > 0)
                                                    {
                                                        echo json_encode(array("status" => "2030", "status_message" => "Email ID Already Exist"));die;
                                                        //$Email_id12 = getRandomString3();
                                                        //$Email_id = $Email_id12."@".$Domain;
                                                    }
                                                    else
                                                    {
                                                        $Email_id = $Email_ID;
                                                    }
                                                }
                                                else
                                                {
                                                    $Email_id12 = getRandomString3();
                                                    $Email_id = $Email_id12."@".$Domain;
                                                }

                                                if($Phone_NO != "")
                                                {
                                                    $query708 = lslDB::getInstance()->get_country_details($Country_id);			
                                                    while($row807 = mysqli_fetch_array($query708))
                                                    {
                                                        $dial_code = $row807['Dial_code'];
                                                    }
                                                    $Phno = ltrim($Phone_NO, '0');
                                                    $new_Phno = $dial_code.$Phno;

                                                    $lv_query2 = "SELECT * FROM lsl_enrollment_master "
                                                                . "WHERE Phone_no='".$new_Phno."' "
                                                                . "AND Company_id='$Company_id' "
                                                                . "AND User_type_id ='1'";
                                                    $lv_result2 = mysqli_query($conn,$lv_query2);
                                                    $Phoneno_check = mysqli_num_rows($lv_result2);
                                                    if($Phoneno_check > 0)
                                                    {
                                                        echo json_encode(array("status" => "2032", "status_message" => "Phone No Already Exist"));die;
                                                        //$Phoneno = "";
                                                    }
                                                    else
                                                    {
                                                        $Phoneno = $Phone_NO;
                                                    }
                                                }
                                                
                                                if($Membership_generation == 3)
                                                {
                                                    $query708 = lslDB::getInstance()->get_country_details($Country_id);			
                                                    while($row807 = mysqli_fetch_array($query708))
                                                    {
                                                        $dial_code = $row807['Dial_code'];
                                                    }
                                                    $Phno = ltrim($Phone_NO, '0');
                                                    $new_Phno = $dial_code.$Phno;
                                                    
                                                    $Update_enroll_query = "UPDATE lsl_enrollment_master SET Partner_id='0',Branch_code='',User_group_id='',User_type_id='1',First_name='".$First_name."',Middle_name='',Last_name='".$Last_name."',"
                                                                         . "Phone_no='".$new_Phno."',User_email_id='".$Email_id."',Communication_email_id='',Password='".$Password."',Qualification='',Current_address='".$Address."',"
                                                                         . "Country_id='".$Country_id."',Region_id='".$Region_id."',Zone_id='".$Zone_id."',State_id='".$State_id."',City_id='".$City_id."',Zipcode='',Timezone_entry='".$Timezone."',
                                                                            Wedding_annversary_date='',Date_of_birth='',Sex='',Pin='".$Pin."',Active_flag='1',Referee_flag='".$Referee_flag."',Referee_id='".$Refree_enroll_id."',Tier_id='".$Tier_id."',
                                                                            Employee_flag='',Employee_id='',Parent_enroll_id='".$Parent_member_details['Enrollment_id']."',Account_number='',Membership_id='".$Membership_id."',Membership_validity='".$Membership_validity."',Password_expiry_date='".$Password_expiry_date."',
                                                                            Familly_flag='1',Family_redeem_limit='".$Family_Redemption_limit."',Loyalty_programme_id='".$Cust_Loyalty_programme_id."',Communication_flag='".$Communication_flag."',
                                                                            Communication_type='".$Communication_type."',Source='0',Update_user_id='0',Update_date='".$Enroll_date."'
                                                                            ,Photograph='',Enroll_date='".$Enroll_date."',Current_balance='".$Joining_bonus_points."',Total_bonus_points='".$Joining_bonus_points."' "
                                                                          . "WHERE Company_id=".$Company_id." AND Enrollment_id=".$Pregenerated_member_details['Enrollment_id'];
                                                    $Update_enroll_result = mysqli_query($conn,$Update_enroll_query);

                                                    $User_enrollment = $Pregenerated_member_details['Enrollment_id'];

                                                    /*****************Send Email****************/
                                                        if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                        {
                                                            $Template_type_id = 1;  $Email_Type = 9;
                                                            $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                        }

                                                        if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                        {
                                                            $SMS_Type = 9;  $Template_smstype_id = 1;
                                                            if($Enrollment_sms == 1)
                                                            {
                                                                $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                            }
                                                        }
                                                    /*****************Send Email End****************/

                                                    //*********** Joining Bonus Entry in Transaction tbl ***************
                                                        if( $Joining_bonus_flag == 1)
                                                        {
                                                            $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;
                                                            $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                            $company_balance12 = $company_balance - $Joining_bonus_points;
                                                            $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                        
                                                            $Parent_Member_redeem12 = $Parent_member_details['Total_redeem_points'];
                                                            $Parent_Member_purchase12 = $Parent_member_details['Total_purchase_amount'];
                                                            $Parent_Member_loyalty_points12 = $Parent_member_details['Total_gained_points'];
                                                            $Parent_Member_balance12 = $Parent_member_details['Current_balance'] + $Joining_bonus_points;
                                                            
                                                            $update_memberbal =  lslDB::getInstance()->update_member_balance_details($Parent_member_details['Enrollment_id'],$Parent_Member_balance12,$Parent_Member_redeem12,$Parent_Member_purchase12,$Parent_Member_loyalty_points12,$Company_id);
                                                        }		
                                                    //*********** Joining Bonus Entry in Transaction tbl ***************

                                                    echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
                                                }

                                                if($Membership_generation == 1)
                                                {
                                                    $User_enrollment = lslDB::getInstance()->insert_user_enrollment($Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                            $Phoneno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                            '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','',$Parent_member_details['Enrollment_id'],'',$Membership_id,$Membership_validity,$Password_expiry_date,'1',$Family_Redemption_limit,$Cust_Loyalty_programme_id,
                                                            $Family_Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);  
                                                    
                                                    /*****************Send Email****************/
                                                        if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                        {
                                                            $Template_type_id = 1;  $Email_Type = 9;
                                                            $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                        }

                                                        if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                        {
                                                            $SMS_Type = 9;  $Template_smstype_id = 1;
                                                            if($Enrollment_sms == 1)
                                                            {
                                                                $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                            }
                                                        }
                                                    /*****************Send Email End****************/

                                                    //*********** Joining Bonus Entry in Transaction tbl ***************
                                                        if( $Joining_bonus_flag == 1)
                                                        {
                                                            $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;
                                                            $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                            $company_balance12 = $company_balance - $Joining_bonus_points;
                                                            $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                        
                                                            $Parent_Member_redeem12 = $Parent_member_details['Total_redeem_points'];
                                                            $Parent_Member_purchase12 = $Parent_member_details['Total_purchase_amount'];
                                                            $Parent_Member_loyalty_points12 = $Parent_member_details['Total_gained_points'];
                                                            $Parent_Member_balance12 = $Parent_member_details['Current_balance'] + $Joining_bonus_points;
                                                            
                                                            $update_memberbal =  lslDB::getInstance()->update_member_balance_details($Parent_member_details['Enrollment_id'],$Parent_Member_balance12,$Parent_Member_redeem12,$Parent_Member_purchase12,$Parent_Member_loyalty_points12,$Company_id);
                                                        }		
                                                    //*********** Joining Bonus Entry in Transaction tbl ***************

                                                    echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
                                                }
                                                
                                                if($Membership_generation == 2)
                                                {
                                                    $vquery = "SELECT Membership_id FROM lsl_automated_membershipid "
                                                            . "WHERE Utilized='0' "
                                                            . "AND Company_id='".$Company_id."' "
                                                            . "LIMIT 2";
                                                    $run_vquery = mysqli_query($conn,$vquery);
                                                    $res_vquery = mysqli_fetch_array($run_vquery);
                                                    //$Auto_member_check = mysqli_num_rows($run_vquery);
                                                    $Membership_id = $res_vquery['Membership_id'];

                                                    $User_enrollment = lslDB::getInstance()->insert_user_enrollment($Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                            $Phoneno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                            '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'0','0',$Cust_Loyalty_programme_id,
                                                            $Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);  

                                                    $update_membershipid = lslDB::getInstance()->update_auto_membershipid($Company_id,$Membership_id);

                                                    /*****************Send Email****************/
                                                        if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                        {
                                                            $Template_type_id = 1;  $Email_Type = 9;
                                                            $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                        }

                                                        if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                        {
                                                            $SMS_Type = 9;  $Template_smstype_id = 1;
                                                            if($Enrollment_sms == 1)
                                                            {
                                                                $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                            }
                                                        }
                                                    /*****************Send Email End****************/

                                                    //*********** Joining Bonus Entry in Transaction tbl ***************
                                                        if( $Joining_bonus_flag == 1)
                                                        {
                                                            $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;

                                                            $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                            $company_balance12 = $company_balance - $Joining_bonus_points;
                                                            $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                        }		
                                                    //*********** Joining Bonus Entry in Transaction tbl ***************

                                                    echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv), "status_message" => "Success"));die;
                                                }

                                                /*if($Membership_generation == 2)
                                                {
                                                    $vquery = "SELECT Membership_id FROM lsl_automated_membershipid "
                                                            . "WHERE Utilized='0' "
                                                            . "AND Company_id='".$Company_id."' "
                                                            . "AND Membership_id='".$Membership_id."'";
                                                    $run_vquery = mysqli_query($conn,$vquery);
                                                    $Auto_member_check = mysqli_num_rows($run_vquery);

                                                    if($Auto_member_check == 0)
                                                    {
                                                        $User_enrollment = lslDB::getInstance()->insert_user_enrollment($Company_id,'0','','','','1',$First_name,'',$Last_name,
                                                                $Phoneno,$Email_id,'',$Password,$Profession,$Address,$Country_id,$Region_id,$Zone_id,$State_id,$City_id,'',$Timezone,'',
                                                                '','',$Pin,'1',$Referee_flag,$Refree_enroll_id,$Tier_id,'','','0','',$Membership_id,$Membership_validity,$Password_expiry_date,'1',$Family_Redemption_limit,$Cust_Loyalty_programme_id,
                                                                $Family_Communication_flag,$Communication_type,'0','0',$Enroll_date,$Enroll_date,'',$Joining_bonus_points);  

                                                        /*****************Send Email****************
                                                            if( $Email_ID != "" && ($Company_communication == 1 || $Company_communication == 3) && ($Communication_type == 1 || $Communication_type == 3) )
                                                            {
                                                                $Template_type_id = 1;  $Email_Type = 9;
                                                                $enrollment_template = lslDB::getInstance()->send_enrollment_template($Company_id,$User_enrollment,$Email_Type,$Template_type_id,'1');
                                                            }

                                                            if( $Phone_NO != "" && ($Company_communication == 2 || $Company_communication == 3) && ($Communication_type == 2 || $Communication_type == 3) )
                                                            {
                                                                $SMS_Type = 9;  $Template_smstype_id = 1;
                                                                if($Enrollment_sms == 1)
                                                                {
                                                                    $enrollment_smstemplate = lslDB::getInstance()->send_customer_enrollment_smstemplate($Company_id,$User_enrollment,$SMS_Type,$Template_smstype_id,'1'); 
                                                                }
                                                            }
                                                        /*****************Send Email End****************/

                                                        /*********** Joining Bonus Entry in Transaction tbl ***************
                                                            if( $Joining_bonus_flag == 1)
                                                            {
                                                                $TransType = 22; $loguser_email_id = ""; $BranchPin = 0; $BillNo = 0; $Remark = ""; $BranchCode = 0;
                                                                $insert_transaction = lslDB::getInstance()->insert_credit_debit_transaction($TransType,'','',$Company_id,$User_enrollment,$Membership_id,$User_enrollment,$loguser_email_id,$Enroll_date,$BranchPin,$Joining_bonus_points,$BranchCode,$BillNo,$Remark,$User_enrollment,$Enroll_date);

                                                                $company_balance12 = $company_balance - $Joining_bonus_points;
                                                                $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance12);
                                                            
                                                                $Parent_Member_redeem12 = $Parent_member_details['Total_redeem_points'];
                                                                $Parent_Member_purchase12 = $Parent_member_details['Total_purchase_amount'];
                                                                $Parent_Member_loyalty_points12 = $Parent_member_details['Total_gained_points'];
                                                                $Parent_Member_balance12 = $Parent_member_details['Current_balance'] + $Joining_bonus_points;

                                                                $update_memberbal =  lslDB::getInstance()->update_member_balance_details($Parent_member_details['Enrollment_id'],$Parent_Member_balance12,$Parent_Member_redeem12,$Parent_Member_purchase12,$Parent_Member_loyalty_points12,$Company_id);
                                                            }		
                                                        //*********** Joining Bonus Entry in Transaction tbl ***************

                                                        echo json_encode(array("status" => "1001", "Password" => string_encrypt($Password, $key, $iv), "Pin" => string_encrypt($Pin, $key, $iv), "Membership_id" => string_encrypt($Membership_id, $key, $iv)));die;
                                                    }
                                                    else
                                                    {
                                                        echo json_encode(array("status" => "2029"));die;
                                                    }
                                                }*/

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
                    /************************************Family Member Enrollment********************************/
                    
                    /************************************Retrieve All Enrollments********************************/
                    if($API_flag == 37)  //***Retrieve All Enrollments
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE User_email_id='".$Username."' "
                                    . "AND Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);

                            $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                            $Company_details = mysqli_fetch_array($Company_result);

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
                                    $From_date1 = trim($_REQUEST['From_date']);
                                    $Till_date1 = trim($_REQUEST['Till_date']);
                                    
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

                                    if($From_date1 != "" && $Till_date1 != "")
                                    {
                                        $From_date1 = str_replace('/', '-', $From_date1);
                                        $Till_date1 = str_replace('/', '-', $Till_date1);
                                        //$From_date = date("Y-m-d h:i:s", strtotime($From_date1));
                                        $From_date = date("Y-m-d", strtotime($From_date1));
                                        $Till_date = date("Y-m-d", strtotime($Till_date1));

                                        $query2 = "SELECT * FROM lsl_enrollment_master "
                                                . "WHERE Enroll_date BETWEEN '".$From_date."' AND '".$Till_date."' "
                                                . "AND (Company_id='".$Company_id."' OR Child_company_id='".$Company_id."') "
                                                . "AND User_type_id='1' "
                                                . "AND Active_flag='1' "
                                                . "Order BY Enrollment_id ASC ".$LIMIT." ";
                                    }
                                    else
                                    {
                                        $query2 = "SELECT * FROM lsl_enrollment_master "
                                                . "WHERE (Company_id='".$Company_id."' OR Child_company_id='".$Company_id."') "
                                                . "AND User_type_id='1' "
                                                . "AND Active_flag='1' "
                                                . "Order BY Enrollment_id ASC ".$LIMIT." ";
                                    }
                                    
                                    $lv_result2 = mysqli_query($conn,$query2);
                                    $Enrollment_count = mysqli_num_rows($lv_result2);
                                    
                                    if($Enrollment_count > 0)
                                    {
                                        while($rows2 = mysqli_fetch_array($lv_result2))
                                        {
                                            $tier_details_result = lslDB::getInstance()->get_tier($rows2['Tier_id']);
                                            $tier_details = mysqli_fetch_array($tier_details_result);
                                            
                                            if($rows2["Parent_enroll_id"] > 0)
                                            {
                                                $Parent_enroll_result = lslDB::getInstance()->get_user_details($rows2["Parent_enroll_id"],$Company_id);
                                                $Parent_enroll_details = mysqli_fetch_array($Parent_enroll_result);
                                                $Parent_membershipid = $Parent_enroll_details["Membership_id"];
                                            }
                                            else
                                            {
                                                $Parent_membershipid = 0;
                                            }
                                            
                                            $Enrollment_details[] = array(
                                                    "Enroll_date" => date("F j, Y",strtotime($rows2["Enroll_date"])),
                                                    "Membership_id" => $rows2["Membership_id"],
                                                    "First_name" => $rows2["First_name"],
                                                    "Last_name" => $rows2["Last_name"],
                                                    "Current_address" => $rows2["Current_address"],
                                                    "Phone_no" => $rows2["Phone_no"],
                                                    "User_email_id" => $rows2["User_email_id"],
                                                    "Current_balance" => $rows2["Current_balance"],
                                                    "Tier_name" => $tier_details["Tier_name"],
                                                    "Parent_membershipid" => $Parent_membershipid
                                            );
                                        }
                                        
                                        $Status_array = array("status" => "1001", "Enrollment_details" => $Enrollment_details, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }   
                                }
                            }
                        }
                    }
                    /************************************Retrieve All Enrollments********************************/
                    
                    /************************************System User Identification********************************/
                    if($API_flag == 38)  //***login and return System User details
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);
                            
                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);
                            
                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                    . "AND lsl_enrollment_master.Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
									

                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => ""));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Username or Password is Incorrect"));
                                }
                                else
                                {
                                    $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                                    $Company_details = mysqli_fetch_array($Company_result);
                                    
                                    $query2 = "SELECT User_type_name FROM lsl_user_type_master "
                                            . "WHERE User_type_id='".$member_details['User_type_id']."' ";
                                    $User_type = mysqli_fetch_array(mysqli_query($conn,$query2));
                                    $User_type_name = $User_type['User_type_name'];
                                    
                                    if($member_details['User_type_id'] == 6)
                                    {
                                        $query3 = "SELECT Branch_code,Branch_name FROM lsl_branch_master "
                                                . "WHERE Branch_code='".$member_details['Branch_code']."' "
                                                . "AND Active_flag=1 "
                                                . "AND Partner_id=0";
                                    }
                                    else if($member_details['User_type_id'] == 4 || $member_details['User_type_id'] == 5)
                                    {
                                        $query3 = "SELECT Branch_code,Branch_name FROM lsl_branch_master "
                                                . "WHERE Active_flag=1 "
                                                . "AND Partner_id=0 "
                                                . "AND Company_id='".$Company_id."' ";
                                    }
                                    else if($member_details['User_type_id'] == 8)
                                    {
                                        $query3 = "SELECT Branch_code,Branch_name FROM lsl_branch_master "
                                                . "WHERE Active_flag=1 "
                                                . "AND Partner_id<>0 "
                                                . "AND Company_id='".$Company_id."' ";
                                    }
                                    else if($member_details['User_type_id'] == 9)
                                    {
                                        $query3 = "SELECT Branch_code,Branch_name FROM lsl_branch_master "
                                                . "WHERE Active_flag=1 "
                                                . "AND Partner_id=0 "
                                                . "AND Company_id='".$Company_id."' ";
                                    }
                                    //echo $query3;
                                    
                                    $Branch_result = mysqli_query($conn,$query3);
                                    while($rows3 = mysqli_fetch_array($Branch_result))
                                    {
                                        $Branch_details[$rows3['Branch_code']] = $rows3['Branch_name'];
                                    }
                                
                                    $member_details = array(
                                                            "status" => "1001",
                                                            "First_name" => trim(string_encrypt($member_details['First_name'], $key, $iv)),
                                                            "Last_name" => trim(string_encrypt($member_details['Last_name'], $key, $iv)),
                                                            "Company_name" => $Company_details['Company_name'],
                                                            "Company_logo" => "https://demo.perxclm2.com/".$Company_details['Company_logo'],
                                                            "User_type" => trim(string_encrypt($User_type_name, $key, $iv)),
                                                            "Creation_date" => $member_details['Enroll_date'],
                                                            "Branch_details" => $Branch_details,
                                                            "status_message" => "Success"
                                                        );
                                }
                                echo json_encode($member_details);
                            }
                        }
                    }
                    /************************************System User Identification********************************/
                    
                    /************************************Change System User Pin********************************/
                    if($API_flag == 39)  //***change System user pin
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);
                            
                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);
                            
                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE User_email_id='".$Username."' "
                                    . "AND Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            $Company_result = lslDB::getInstance()->get_company_details($Company_id);
                            $Company_details = mysqli_fetch_array($Company_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => ""));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID not found"));
                                }
                                else
                                {
                                    $Pin = getRandomString4();
                                    $New_pin = validatePIN($Pin,$Company_id);
                                    
                                    $query2 = "UPDATE lsl_enrollment_master SET Pin='".$New_pin."' "
                                            . "WHERE User_email_id='".$Username."' "
                                            . "AND Password ='".$Password."' "
                                            . "AND User_type_id <> 1 "
                                            . "AND Company_id='".$Company_id."' "
                                            . "AND Enrollment_id='".$member_details['Enrollment_id']."' ";
                                    $Update_pin = mysqli_query($conn,$query2);
                                    
                                    $html = "<div class='EmailTemplate' style='padding: 10px;font-size: 12px;font-family: Roboto,sans-serif;background: none repeat scroll 0 0 #38FFCA;width: 80%;color: #BF29FF;'>";
                                    $html .= "<p>";
                                    $html .= "Dear <strong>".$member_details['First_name']." ".$member_details['Last_name']."</strong>, <br /><br />";
                                    $html .= "Your Pin is changed. Your new Pin is -&nbsp;<strong>".$New_pin."</strong>.";
                                    $html .= "<br /><br />Please login&nbsp;<strong>".$Company_details['Website']."</strong> to check your details.";
                                    $html .= "</p>";
                                    $html .= "</div>";

                                    $from_header1 = "MIME-Version: 1.0\r\n";
                                    $from_header1 .= "From: " . strip_tags($Company_details['Company_person_Email']) . "\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";
                                    $to = $member_details['Communication_email_id'];
                                    $subject = "About your Pin change.";
                                    mail($to,$subject,$html,$from_header1);
                                    
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Change System User Pin********************************/
                    
                    /************************************Change System User Password********************************/
                    if($API_flag == 44)  //***change System User password
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Current_pass'] == "" || $_REQUEST['New_pass'] == "")
                        {
                            echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);
                            
                            $Old_password = trim(string_decrypt($_REQUEST['Current_pass'], $key, $iv));
                            $Old_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Old_password);
                            
                            $New_password = trim(string_decrypt($_REQUEST['New_pass'], $key, $iv));
                            $New_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $New_password);

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);

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
                                    echo json_encode(array("status" => "2011", "status_message" => "Remark Field is empty"));
                                }
                                else
                                {
                                    $changepassword = lslDB::getInstance()->changepassword($member_details['User_email_id'],$Old_password,$New_password,'0');
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Change System User Password********************************/
                    
                    /************************************Customer LBS Polling********************************/
                    if($API_flag == 46)
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            //$Cust_lat = "18.5178452";//trim($_REQUEST['Latitude']);
                            //$Cust_long = "73.8800779";//trim($_REQUEST['Longitude']);
                            
                            $Cust_lat = trim($_REQUEST['Latitude']);
                            $Cust_long = trim($_REQUEST['Longitude']);
                            $entry_date = date("Y-m-d");
                            
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Cust_email = $member_details['User_email_id'];                            
                            $Customer_enroll_id = $member_details["Enrollment_id"];
                            $Customer_Lp_id = $member_details["Loyalty_programme_id"];
                            $member_tier_id = $member_details["Tier_id"];
                            $Child_company_id = $member_details["Child_company_id"];
                            $Cust_Phone_no = $member_details["Phone_no"];
                            $Cust_Communication_flag = $member_details["Communication_flag"];
                            
                            $get_company_details = lslDB::getInstance()->get_company_details($Company_id);
                            $company_detail = mysqli_fetch_array($get_company_details);
                            $LBS_flag = $company_detail['LBS_flag'];
                            $LBS_Distance = $company_detail['LBS_range'];
                            $LBS_notice_period = $company_detail['LBS_notice_period'];
                            
                            $branch_array = array();    $branch_array22 = array();  $Custom_communication_array = array();  $flag3 = 0;
                            
                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else if($LBS_flag != 1)
                            {
                                echo json_encode(array("status" => "2054", "status_message" => "LBS is not set by Company"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $me = 0;
                                    $query8 = "SELECT Branch_id,Partner_id,Latitude,Longitude,Address,Branch_code,Branch_name FROM lsl_branch_master 
                                               WHERE Company_id=".$Company_id."
                                               AND Active_flag=1";
                                    $res8 = mysqli_query($conn,$query8);
                                    $branch_count = mysqli_num_rows($res8);
                                    
                                    while($row8 = mysqli_fetch_array($res8))
                                    {
                                        $me++;
                                        $Branch_id = $row8["Branch_id"];
                                        $Branch_lat = $row8["Latitude"];
                                        $Branch_long = $row8["Longitude"];
                                        $Branch_Current_address = $row8["Address"];
                                        $Branch_code = $row8['Branch_code'];
                                        $Branch_name = $row8['Branch_name'];
                                        $Partner_id = $row8['Partner_id'];
                                        
                                        if($Partner_id == 0){ $set_flag = '0'; }else{ $set_flag = '-1'; }
                                        
                                        $theta = ($Branch_long - $Cust_long);
                                        $dist = sin(deg2rad($Branch_lat)) * sin(deg2rad($Cust_lat)) +  cos(deg2rad($Branch_lat)) * cos(deg2rad($Cust_lat)) * cos(deg2rad($theta));
                                        $dist = acos($dist);
                                        $dist = rad2deg($dist);
                                        $miles = $dist * 60 * 1.1515;
                                        $Distance_diff = round(($miles * 1.609344),2);
                                        
                                        if($Distance_diff <= $LBS_Distance)
                                        {
                                            /****************** send custom email communication notification start ************************/
                                            $lv_query20 = "SELECT CC.*,CB.LBS_branch FROM lsl_custom_communication as CC,lsl_custom_communication_lbs_branch as CB WHERE CC.Company_id='".$Company_id."'
                                                           AND CC.Custom_communication_id = CB.Custom_communication_id
                                                           AND CC.LBS_linked='1' AND CB.LBS_branch in ('$set_flag','$Branch_id')
                                                           AND CC.Loyalty_program_id = '".$Customer_Lp_id."'
                                                           AND CC.LBS_from_date <= '".$entry_date."' 
                                                           AND CC.LBS_till_date >= '".$entry_date."' ";
                                            $lv_result20 = mysqli_query($conn,$lv_query20);
                                            while($rec0=mysqli_fetch_array($lv_result20))
                                            {
                                                $Custom_communication_id = $rec0['Custom_communication_id'];
						$Loyalty_program_id = $rec0['Loyalty_program_id'];
						$LBS_linked = $rec0['LBS_linked'];
						$LBS_from_date = $rec0['LBS_from_date'];
						$LBS_till_date = $rec0['LBS_till_date'];
                                                
                                                $dp_query = "SELECT * FROM lsl_custom_communication_child "
                                                          . "WHERE Custom_communication_id='$Custom_communication_id'";
                                                $dp_result = mysqli_query($conn,$dp_query);
                                                
                                                if(mysqli_num_rows($dp_result) == 0)
						{
                                                    $dp_User_email_id[] = $Cust_email;
						}
						while($dp_rows = mysqli_fetch_array($dp_result))
						{
                                                    $dp_User_email_id[] = $dp_rows["User_email_id"];	
                                                    $dp_Tier_id = $dp_rows["Tier_id"];
                                                    $dp_Segment_code = $dp_rows["Segment_code"];
                                                    $dp_When_to_send = $dp_rows["When_to_send"];
                                                    $dp_Action_date = $dp_rows["Action_date"];
						}
                                                
                                                $lv_query123="SELECT Loyalty_program_name FROM lsl_loyalty_program_master 
                                                              WHERE Loyalty_program_id=".$Loyalty_program_id."";
						$lv_result123 = mysqli_query($conn,$lv_query123);
						$rec_loyalty = mysqli_fetch_array($lv_result123);
                                                
                                                if( ($entry_date >= $LBS_from_date) && ($entry_date <= $LBS_till_date) && in_array($Cust_email,$dp_User_email_id) )
                                                {
                                                    $lv_query211 = "SELECT N.User_notification_id FROM lsl_user_notification_master as N,lsl_user_notification_child as NC  
                                                                    WHERE N.User_notification_id = NC.User_notification_id
                                                                    AND N.Company_id='".$Company_id."' 
                                                                    AND NC.Branch_id = '".$Branch_id."'
                                                                    AND N.User_email_id='".$Cust_email."' 
                                                                    AND N.Creation_date='".$entry_date."' 
                                                                    AND NC.LBS_notification_id = '".$Custom_communication_id."' ";
                                                    $lv_result211 = mysqli_query($conn,$lv_query211);
                                                    $count_Duplication21 = mysqli_num_rows($lv_result211);
                                                    
                                                    if($count_Duplication21==0)
                                                    {	
                                                        $Custom_communication_array[] = $Custom_communication_id;
                                                        $branch_array[] = $Branch_code;
                                                        $Loyalty_programs[] = $Loyalty_program_id;
                                                    }
                                                    else
                                                    {
                                                        $Already_Branches[] = $Branch_code;
                                                        $Already_Loyalty_program[] = $Loyalty_program_id;
                                                    }
                                                }
                                                unset($dp_User_email_id);
                                            }
                                            /****************** send custom email communication notification start ************************/
                                            
                                            /****************** send custom sms communication notification start ************************/
                                            $lv_query21 = "SELECT CC.*,CB.LBS_branch FROM lsl_custom_communication_sms as CC,lsl_custom_communication_lbs_branch as CB WHERE CC.Company_id='".$Company_id."'
                                                           AND CC.Sms_custom_communication_id = CB.Custom_communication_id
                                                           AND CC.LBS_linked='1' AND CB.LBS_branch in ('$set_flag','$Branch_id')
                                                           AND CC.Loyalty_program_id = '".$Customer_Lp_id."'
                                                           AND CC.LBS_from_date <= '".$entry_date."' 
                                                           AND CC.LBS_till_date >= '".$entry_date."' ";
                                            $lv_result21 = mysqli_query($conn,$lv_query21);
                                            while($rec21 = mysqli_fetch_array($lv_result21))
                                            {
                                                $Sms_custom_communication_id = $rec21['Sms_custom_communication_id'];
						$Loyalty_program_id = $rec21['Loyalty_program_id'];
						$LBS_linked = $rec21['LBS_linked'];
						$LBS_from_date = $rec21['LBS_from_date'];
						$LBS_till_date = $rec21['LBS_till_date'];
                                                
                                                $dp_query12 = "SELECT * FROM lsl_custom_communication_sms_child "
                                                            . "WHERE Sms_custom_communication_id='$Sms_custom_communication_id'";
                                                $dp_result12 = mysqli_query($conn,$dp_query12);
                                                
                                                if(mysqli_num_rows($dp_result12) == 0)
						{
                                                    $dp_Phone_no[] = $Cust_Phone_no;
						}
						while($dp_rows12 = mysqli_fetch_array($dp_result12))
						{
                                                    $dp_Phone_no[] = $dp_rows12["Phone_no"];	
                                                    $dp_Tier_id = $dp_rows12["Tier_id"];
                                                    $dp_Segment_code = $dp_rows12["Segment_code"];
                                                    $dp_When_to_send = $dp_rows12["When_to_send"];
                                                    $dp_Action_date = $dp_rows12["Action_date"];
						}
                                                
                                                $lv_query123="SELECT Loyalty_program_name FROM lsl_loyalty_program_master 
                                                              WHERE Loyalty_program_id=".$Loyalty_program_id."";
						$lv_result123 = mysqli_query($conn,$lv_query123);
						$rec_loyalty=mysqli_fetch_array($lv_result123);
                                                
                                                if( ($entry_date >= $LBS_from_date) && ($entry_date <= $LBS_till_date) && in_array($Cust_Phone_no,$dp_Phone_no) )
                                                {
                                                    $lv_query211 = "SELECT N.User_notification_id FROM lsl_user_notification_master as N,lsl_user_notification_child as NC  
                                                                    WHERE N.User_notification_id = NC.User_notification_id
                                                                    AND N.Company_id='".$Company_id."' 
                                                                    AND NC.Branch_id = '".$Branch_id."'
                                                                    AND N.User_email_id='".$Cust_email."' 
                                                                    AND N.Creation_date='".$entry_date."' 
                                                                    AND N.Disable_flag= '1'
                                                                    AND NC.LBS_notification_id = '".$Sms_custom_communication_id."' ";
                                                    $lv_result211 = mysqli_query($conn,$lv_query211);
                                                    $count_Duplication23 = mysqli_num_rows($lv_result211);
                                                    
                                                    if($count_Duplication23 == 0  )
                                                    {	
                                                        $SMS_custom_communication_array[] = $Sms_custom_communication_id;
                                                        $SMS_branch_array[] = $Branch_code;
                                                        $Loyalty_programs[] = $Loyalty_program_id;
                                                    }
                                                    else
                                                    {
                                                        $Already_Branches[] = $Branch_code;
                                                        $Already_Loyalty_program[] = $Loyalty_program_id;
                                                    }
                                                }
                                                unset($dp_Phone_no);
                                            }
                                            /****************** send custom sms communication notification start ************************/
                                            
                                            if($Partner_id == 0)
                                            {
                                                if($Partner_id == 0)
                                                {
                                                    $Branch_code = $Branch_code;
                                                    $Branch_id = $Branch_id;
                                                }
                                                else
                                                {
                                                    $Branch_code = '0';
                                                    $Branch_id = '';
                                                }
                                                
                                                /****************** send regular campaign email start************************/
                                                $myquery1 = "SELECT Campaign_id,Loyalty_programme_id,Tier_flag,Tier_id,From_date,To_date 
                                                             FROM lsl_campaign_master as cmp 
                                                             WHERE cmp.Company_id='".$Company_id."'
                                                             AND cmp.Campaign_type='29'
                                                             AND cmp.LBS_linked='1'
                                                             AND cmp.Loyalty_programme_id='".$Customer_Lp_id."'
                                                             AND cmp.Active_flag='1'
                                                             AND cmp.To_date >= '".$entry_date."' ";						
						$Template_type_id = 64;
						$Email_Type = 21;
						$cmp_array = array();
						$flag  = 0;
                                                
                                                $myquery1_exe = mysqli_query($conn,$myquery1);
                                                while($myres1 = mysqli_fetch_array($myquery1_exe))
                                                {
                                                    $date = new DateTime($myres1['From_date']);
                                                    $date->sub(new DateInterval('P'.$LBS_notice_period.'D'));
                                                    $notice_period = $date->format('Y-m-d');
                                                    
                                                    if($entry_date >= $notice_period)
                                                    {
                                                        $campaignID = $myres1['Campaign_id'];	
                                                        $Loyalty_programmeID = $myres1['Loyalty_programme_id'];	
                                                        $cmp_Tier_flag  = $myres1['Tier_flag'];
                                                        $cmp_Tier_id = $myres1['Tier_id'];
                                                        
                                                        $lv_query221 = "SELECT N.User_notification_id 
                                                                        FROM lsl_user_notification_master as N,lsl_user_notification_child as NC  
                                                                        WHERE N.User_notification_id = NC.User_notification_id
                                                                        AND N.Company_id='".$Company_id."' 
                                                                        AND NC.Branch_id IN (0,'".$Branch_id."')
                                                                        AND N.User_email_id='".$Cust_email."' 
                                                                        AND N.Creation_date='".$entry_date."' 
                                                                        AND NC.LBS_notification_id = '".$campaignID."' ";
                                                        $lv_result221 = mysqli_query($conn,$lv_query221);
                                                        $count_Duplication=mysqli_num_rows($lv_result221);
                                                        
                                                        if($count_Duplication == 0)
                                                        {
                                                            if($cmp_Tier_flag == 1) //********* member tier validation ********
                                                            {
                                                                if($cmp_Tier_id == $member_tier_id)
                                                                {
                                                                    $cmp_array[] = $campaignID;
                                                                    $branch_array[] = $Branch_code;
                                                                    $Loyalty_programs[] = $Loyalty_programmeID;
                                                                    $flag  = 1;
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $cmp_array[] = $campaignID;
                                                                $branch_array[] = $Branch_code;
                                                                $Loyalty_programs[] = $Loyalty_programmeID;
                                                                $flag  = 1;
                                                            }		
                                                        }
                                                        else
                                                        {
                                                            $Already_Branches[] = $Branch_code;
                                                            $Already_Loyalty_program[] = $Loyalty_programmeID;
                                                        }
                                                    }
                                                }
                                                /****************** send regular campaign email start************************/
                                                
                                                /****************** send periodic campaign email start ************************/
                                                $myquery12 = "SELECT Campaign_id,Loyalty_programme_id,Tier_flag,Tier_id,From_date,To_date
                                                              FROM lsl_campaign_master as cmp
                                                              WHERE cmp.Company_id='".$Company_id."'
                                                              AND cmp.Campaign_type='30'
                                                              AND cmp.LBS_linked='1'
                                                              AND cmp.Loyalty_programme_id='".$Customer_Lp_id."'
                                                              AND cmp.Active_flag='1' 
                                                              AND cmp.To_date >= '".$entry_date."' ";
						$myquery1_exe2 = mysqli_query($conn,$myquery12);
                                                while($myres12 = mysqli_fetch_array($myquery1_exe2))
                                                {
                                                    $date = new DateTime($myres12['From_date']);
                                                    $date->sub(new DateInterval('P'.$LBS_notice_period.'D'));
                                                    $notice_period = $date->format('Y-m-d');
                                                    if($entry_date >= $notice_period)
                                                    {
                                                        $campaignID12 = $myres12['Campaign_id'];	
                                                        $Loyalty_programmeID12 = $myres12['Loyalty_programme_id'];	
                                                        $cmp_Tier_flag12  = $myres12['Tier_flag'];
                                                        $cmp_Tier_id12 = $myres12['Tier_id'];
                                                        
                                                        $lv_query231 = "SELECT N.User_notification_id 
                                                                        FROM lsl_user_notification_master as N,lsl_user_notification_child as NC  
                                                                        WHERE N.User_notification_id = NC.User_notification_id
                                                                        AND N.Company_id='".$Company_id."' 
                                                                        AND NC.Branch_id IN (0,'".$Branch_id."')
                                                                        AND N.User_email_id='".$Cust_email."' 
                                                                        AND N.Creation_date='".$entry_date."' 
                                                                        AND NC.LBS_notification_id = '".$campaignID12."' ";
                                                        $lv_result231 = mysqli_query($conn,$lv_query231);
                                                        $count_Duplication12=mysqli_num_rows($lv_result231);
                                                        
                                                        if($count_Duplication12 == 0)
                                                        {
                                                            if($cmp_Tier_flag12 == 1) //********* member tier validation ********
                                                            {
                                                                if($cmp_Tier_id12 == $member_tier_id)
                                                                {
                                                                    $cmp_array[] = $campaignID12;
                                                                    $branch_array[] = $Branch_code;
                                                                    $Loyalty_programs[] = $Loyalty_programmeID12;
                                                                    $flag  = 1;
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $cmp_array[] = $campaignID12;
                                                                $branch_array[] = $Branch_code;
                                                                $Loyalty_programs[] = $Loyalty_programmeID12;
                                                                $flag  = 1;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $Already_Branches[] = $Branch_code;
                                                            $Already_Loyalty_program[] = $Loyalty_programmeID12;
                                                        }
                                                    }
                                                }
                                                /****************** send periodic campaign email start ************************/
                                            }
                                        }
                                    }
                                        
                                    $query81 = "SELECT Branch_id,Partner_id,Latitude,Longitude,Address,Branch_code,Branch_name 
                                                FROM lsl_branch_master 
                                                WHERE Company_id=".$Company_id." 
                                                AND Partner_id <> '0'
                                                AND Active_flag=1";
                                    $res81 = mysqli_query($conn,$query81);
                                    $branch_count22 = mysqli_num_rows($res81);
                                    $me22 = 0;
                                    
                                    while($row81 = mysqli_fetch_array($res81))
                                    {
                                        $me22++;
                                        $Branch_id21=$row81["Branch_id"];
                                        $Branch_lat21=$row81["Latitude"];
                                        $Branch_long21=$row81["Longitude"];
                                        $Branch_Current_address21=$row81["Address"];
                                        $Branch_code21 = $row81['Branch_code'];
                                        $Branch_name21 = $row81['Branch_name'];
                                        $Partner_id = $row81['Partner_id'];
                                        
                                        $theta21 = ($Branch_long21 - $Cust_long);
                                        $dist21 = sin(deg2rad($Branch_lat21)) * sin(deg2rad($Cust_lat)) +  cos(deg2rad($Branch_lat21)) * cos(deg2rad($Cust_lat)) * cos(deg2rad($theta21));
                                        $dist21 = acos($dist21);
                                        $dist21 = rad2deg($dist21);
                                        $miles21 = $dist21 * 60 * 1.1515;
                                        $Distance_diff21=round(($miles21 * 1.609344),2);
                                        
                                        if($Distance_diff21 <= $LBS_Distance)
                                        {
                                            $cmp_array2 = array();
                                            $flag2  = 0;
                                            
                                            /****************** Benefit campaign email start ************************/
                                            $myquery13 = "SELECT Campaign_id,Loyalty_programme_id,Tier_flag,Tier_id,From_date,To_date 
                                                          FROM lsl_campaign_master as cmp
                                                          WHERE cmp.Company_id='".$Company_id."'
                                                          AND cmp.Campaign_type='31' 
                                                          AND cmp.LBS_linked='1' 
                                                          AND Benefit_partner_id = '".$Partner_id."' 
                                                          AND cmp.Loyalty_programme_id='".$Customer_Lp_id."' 
                                                          AND cmp.Active_flag='1' 
                                                          AND cmp.To_date >= '".$entry_date."' ";					
                                            $myquery1_exe3 = mysqli_query($conn,$myquery13);
                                            
                                            while($myres12 = mysqli_fetch_array($myquery1_exe3))
                                            {
                                                $date = new DateTime($myres12['From_date']);
						$date->sub(new DateInterval('P'.$LBS_notice_period.'D'));
						$notice_period = $date->format('Y-m-d');
                                                
                                                if($entry_date >= $notice_period)
                                                {
                                                    $campaignID13 = $myres12['Campaign_id'];	
                                                    $Loyalty_programmeID12 = $myres12['Loyalty_programme_id'];	
                                                    $cmp_Tier_flag12  = $myres12['Tier_flag'];
                                                    $cmp_Tier_id12 = $myres12['Tier_id'];
                                                    
                                                    $lv_query241 = "SELECT N.User_notification_id FROM lsl_user_notification_master as N,lsl_user_notification_child as NC  
                                                                    WHERE N.User_notification_id = NC.User_notification_id
                                                                    AND N.Company_id='".$Company_id."'
                                                                    AND NC.Branch_id IN ('-1','".$Branch_id21."')		
                                                                    AND N.User_email_id='".$Cust_email."' 
                                                                    AND N.Creation_date='".$entry_date."' 
                                                                    AND NC.LBS_notification_id = '".$campaignID13."' ";
                                                    $lv_result241 = mysqli_query($conn,$lv_query241);
                                                    $count_Duplication14=mysqli_num_rows($lv_result241);
                                                    
                                                    if($count_Duplication14 == 0)
                                                    {
                                                        if($cmp_Tier_flag12 == 1) //********* member tier validation ********
                                                        {
                                                            if($cmp_Tier_id12 == $member_tier_id)
                                                            {
                                                                $cmp_array2[] = $campaignID13;
                                                                $branch_array22[] = $Branch_code21;
                                                                $Loyalty_programs[] = $Loyalty_programmeID12;
                                                                $flag2  = 1;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $cmp_array2[] = $campaignID13;
                                                            $branch_array22[] = $Branch_code21;
                                                            $Loyalty_programs[] = $Loyalty_programmeID12;
                                                            $flag2  = 1;
                                                        }									
                                                    }
                                                    else
                                                    {
                                                        $Already_Branches[] = $Branch_code21;
                                                        $Already_Loyalty_program[] = $Loyalty_programmeID12;
                                                    }
                                                }
                                            }
                                            /****************** Benefit campaign email start ************************/
                                        }
                                    }
                                    
                                    $Already_Branches = array_unique($Already_Branches);
                                    $Already_Loyalty_program = array_unique($Already_Loyalty_program);
                                    
                                    if(count($Already_Branches) > 0)
                                    {
                                        foreach($Already_Branches as $Branch)
                                        {
                                            $query83 = "SELECT Address,Branch_name FROM lsl_branch_master 
                                                       WHERE Company_id=".$Company_id."
                                                       AND Branch_code='".$Branch."'
                                                       AND Active_flag=1";
                                            $res83 = mysqli_query($conn,$query83);
                                            $Branch_result83 = mysqli_fetch_array($res83);
                                            $New_branch_details[] = array(
                                                "Branch_name" => $Branch_result83['Branch_name'],
                                                "Branch_Address" => $Branch_result83['Address']
                                            );
                                        }

                                        foreach($Already_Loyalty_program as $LoyaltyId)
                                        {
                                            $lv_query1234 = "SELECT Loyalty_program_name FROM lsl_loyalty_program_master 
                                                             WHERE Loyalty_program_id=".$LoyaltyId."";
                                            $lv_result1234 = mysqli_query($conn,$lv_query1234);
                                            $rec_loyalty1234 = mysqli_fetch_array($lv_result1234);
                                            $New_Loyalty_details[] = array(
                                                "Loyalty_program_name" => $rec_loyalty1234['Loyalty_program_name']
                                            );
                                        }
                                    }
                                    
                                    //var_dump($branch_array);die;
                                    
                                    if( (count($branch_array) == 0) && (count($branch_array22) == 0) ) 
                                    {
                                        echo json_encode(array("status" => "2055", "Branch_details" => $New_branch_details, "Loyalty_program_details" => $New_Loyalty_details, "status_message" => "There is no Campaign or Communication LBS found."));
                                    }
                                    else if( (count($Already_Branches) > 0) || (count($Already_Loyalty_program) > 0) ) 
                                    {
                                        echo json_encode(array("status" => "2063", "Branch_details" => $New_branch_details, "Loyalty_program_details" => $New_Loyalty_details, "status_message" => "Invalid transaction flag"));
                                    }
                                    else
                                    {
                                        /*----------------------------Send Custom Communication Notification-----------------------------*/
                                            if($me == $branch_count)
                                            {
                                                if ($branch_array!= NULL)
                                                {
                                                    $Insert_notification = lslDB::getInstance()->send_LBS_notification_to_user($Customer_enroll_id,$Company_id,$Custom_communication_array,$rec_loyalty['Loyalty_program_name'],$branch_array);

                                                    if($flag == 1)
                                                    {
                                                        $campaign_template = lslDB::getInstance()->send_LBS_campaign_details($Customer_enroll_id,$Company_id,$cmp_array,$entry_date,$Email_Type,$Template_type_id,$branch_array);
                                                    }

                                                    $sms_custom_communication_template = lslDB::getInstance()->send_LBS_sms_notification_to_user($Customer_enroll_id,$Company_id,$SMS_custom_communication_array,$rec_loyalty["Loyalty_program_name"],$SMS_branch_array);
                                                }
                                            }
                                        /*----------------------------Send Custom Communication Notification----------------------*/
                                            
                                        if($flag2 == 1 && $me22 == $branch_count22)
                                        {
                                            if ($branch_array22!= NULL)
                                            {
                                                $campaign_template = lslDB::getInstance()->send_LBS_campaign_details($Customer_enroll_id,$Company_id,$cmp_array2,$entry_date,$Email_Type,$Template_type_id,$branch_array22);
                                            }
                                        }
                                        
                                        $query1="SELECT * FROM lsl_user_notification_master
                                                 WHERE Company_id=".$Company_id."
                                                 AND User_email_id='".$member_details['User_email_id']."'
                                                 AND Membership_id='".$member_details['Membership_id']."'
                                                 AND Disable_flag='0'
                                                 AND Note_open='0' ";
                                        $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));
                                        
                                        /*------------------------------------------------------------------------*/
                                            $New_branch_array = array_merge($branch_array, $branch_array22);
                                            $New_branch_array = array_unique($New_branch_array);
                                            
                                            if(count($New_branch_array) > 0)
                                            {
                                                foreach($New_branch_array as $Branch12)
                                                {
                                                    $query87 = "SELECT Address,Branch_name FROM lsl_branch_master 
                                                               WHERE Company_id=".$Company_id."
                                                               AND Branch_code='".$Branch12."'
                                                               AND Active_flag=1";
                                                    $res87 = mysqli_query($conn,$query87);
                                                    $Branch_result87 = mysqli_fetch_array($res87);
                                                    $BranchDetails[] = array(
                                                        "Branch_name" => $Branch_result87['Branch_name'],
                                                        "Branch_Address" => $Branch_result87['Address']
                                                    );
                                                }
                                            }
                                            else
                                            {
                                                $BranchDetails = "";
                                            }
                                            
                                            $Loyalty_programs = array_unique($Loyalty_programs);
                                            if(count($New_branch_array) > 0)
                                            {
                                                foreach($Loyalty_programs as $LP)
                                                {
                                                    $lv_query56 = "SELECT Loyalty_program_name FROM lsl_loyalty_program_master 
                                                                     WHERE Loyalty_program_id=".$LP."";
                                                    $lv_result56 = mysqli_query($conn,$lv_query56);
                                                    $rec_loyalty56 = mysqli_fetch_array($lv_result56);
                                                    $Loyalty_program_details[] = array(
                                                        "Loyalty_program_name" => $rec_loyalty56['Loyalty_program_name']
                                                    );
                                                }
                                            }
                                            else
                                            {
                                                $Loyalty_program_details = "";
                                            }
                                        /*------------------------------------------------------------------------*/

                                        echo json_encode(array("status" => "1001", "Total_unread_notifications" => $Total_unread_notifications, "Branch_details" => $BranchDetails, "Loyalty_program_details" => $Loyalty_program_details, "status_message" => "Success"));
                                    }
                                    
                                    /*if( ($branch_count > 0) || ($branch_count22 > 0) )
                                    {                                        
                                        $query1="SELECT * FROM lsl_user_notification_master
                                                 WHERE Company_id=".$Company_id."
                                                 AND User_email_id='".$member_details['User_email_id']."'
                                                 AND Membership_id='".$member_details['Membership_id']."'
                                                 AND Disable_flag='0'
                                                 AND Note_open='0' ";
                                        $Total_unread_notifications = mysqli_num_rows(mysqli_query($conn,$query1));

                                        echo json_encode(array("status" => "1001", "Total_unread_notifications" => $Total_unread_notifications));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2055"));
                                    }*/
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Customer LBS Polling********************************/
                    
                    /************************************Share Notification********************************/
                    if($API_flag == 47)
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $member_details = mysqli_fetch_array($member_details_result);
                            $Enrollment_id = $member_details['Enrollment_id'];
                            
                            $myquery23 = lslDB::getInstance()->get_company_details($Company_id);
                            $Company_details = mysqli_fetch_array($myquery23);
                            
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
                                else if($_REQUEST['User_notification_id'] == "")
                                {
                                    echo json_encode(array("status" => "2056", "status_message" => "Notification ID id empty"));
                                }
                                else if($_REQUEST['Social_icon_flag'] == "")
                                {
                                    echo json_encode(array("status" => "2057", "status_message" => "Social Icon flag is blank"));
                                }
                                else
                                {
                                    $Title = $_REQUEST['Title'];
                                    $Content = $_REQUEST['Content'];
                                    $Image_path = $_REQUEST['Image_path'];
                                    $Social_icon_flag = $_REQUEST['Social_icon_flag'];
                                    $User_notification_id = $_REQUEST['User_notification_id'];
                                    $Flag = $_REQUEST['Flag'];
                                    $Invite_flag = $_REQUEST['Invite_flag'];
                                    $Update_date = date("Y-m-d");
                                    
                                    if($Social_icon_flag == 1)
                                    {
                                        $Social_share_points = $Company_details['Facebook_share_points'];
                                        $Social_media = "Facebook";
                                    }
                                    if($Social_icon_flag == 2)
                                    {
                                        $Social_share_points = $Company_details['Twitter_share_points'];
                                        $Social_media = "Twitter";
                                    }
                                    if($Social_icon_flag == 3)
                                    {
                                        $Social_share_points = $Company_details['Linkedin_share_points'];
                                        $Social_media = "Linkedin";
                                    }
                                    if($Social_icon_flag == 4)
                                    {
                                        $Social_share_points = $Company_details['Google_share_points'];
                                        $Social_media = "Google Plus";
                                    }
                                    
                                    if($Company_details['Share_type'] == 1 || $Company_details['Share_type'] == 0)
                                    {
                                        $count_sql1 = "SELECT COUNT(*) FROM lsl_share_notification_details "
                                                    . "WHERE Enrollment_id='".$Enrollment_id."' "
                                                    . "AND Company_id='".$Company_id."' "
                                                    . "AND Social_media='".$Social_icon_flag."' ";
                                        $count_result1 = mysqli_fetch_array(mysqli_query($conn,$count_sql1));	
                                        $Share_count =  $count_result1['COUNT(*)'];
                                        
                                        /*---------------------------------For Share Once--------------------------*/
                                            $count_sql3 = "SELECT COUNT(*) FROM lsl_share_notification_details "
                                                        . "WHERE Enrollment_id='".$Enrollment_id."' "
                                                        . "AND Company_id='".$Company_id."' "
                                                        . "AND User_notification_id='".$User_notification_id."' "
                                                        . "AND Social_media='".$Social_icon_flag."' ";
                                            $count_result3 = mysqli_fetch_array(mysqli_query($conn,$count_sql3));	
                                            $Share_count3 =  $count_result3['COUNT(*)'];
                                        /*---------------------------------For Share Once--------------------------*/
                                            
                                        if($Company_details['Share_type'] == 1 && $Share_count3 != 1)
                                        {
                                            /*---------------------------------Insert Share Count 1 for First Share--------------------------*/
                                                $Share_count = '1';
                                                $sql2 = "INSERT INTO lsl_share_notification_details(Enrollment_id,Company_id,Share_count,Social_media,User_notification_id,Update_user_id,Update_date)
                                                         VALUES('".$Enrollment_id."','".$Company_id."','".$Share_count."','".$Social_icon_flag."','".$User_notification_id."','".$Enrollment_id."','".$Update_date."')";
                                                $result2 = mysqli_query($conn,$sql2);
                                            /*---------------------------------Insert Share Count 1 for First Share--------------------------*/
                                                
                                            /*---------------------------------Update Customer Balance--------------------------*/
                                                $Current_balance = $member_details['Current_balance'];
                                                $New_Current_balance = $Current_balance + $Social_share_points;
                                                $sql3 = "UPDATE lsl_enrollment_master SET Current_balance='".$New_Current_balance."'
                                                         WHERE Enrollment_id='".$Enrollment_id."' ";
                                                $result3 = mysqli_query($conn,$sql3);
                                            /*---------------------------------Update Customer Balance--------------------------*/
                                                
                                            /*---------------------------------Insert Transaction Of Share Points--------------------------*/
                                                $Transaction_type_id = '27';
                                                $sql4 = "INSERT INTO lsl_transaction(Transaction_type_id,Company_id,Member1_enroll_id,Membership1_id,Transaction_date,Bonus_points,Remarks,Create_user_id,Create_date)
                                                         VALUES('".$Transaction_type_id."','".$Company_id."','".$Enrollment_id."','".$member_details['Membership_id']."','".$Update_date."','".$Social_share_points."','".$Social_media."','".$Enrollment_id."','".$Update_date."')";
                                                $result4 = mysqli_query($conn,$sql4);
                                            /*---------------------------------Insert Transaction Of Share Points--------------------------*/
                                                
                                            $Template_type_id = 81;
                                            $Email_Type = 521;  //****Share Bonus**
                                            $share_bonus = lslDB::getInstance()->send_share_bonus_template($Enrollment_id,$Company_id,$Social_media,$Social_share_points,$Email_Type,$Template_type_id);
                                        }
                                        
                                        if($Company_details['Share_type'] == 0 && ($Share_count != $Company_details['Share_limit']) )
                                        {
                                            $count_sql2 = "SELECT COUNT(*) FROM lsl_share_notification_details "
                                                        . "WHERE Enrollment_id='".$Enrollment_id."' "
                                                        . "AND Company_id='".$Company_id."' "
                                                        . "AND Social_media='".$Social_icon_flag."' "
                                                        . "AND User_notification_id='".$User_notification_id."' ";
                                            $count_result2 = mysqli_fetch_array(mysqli_query($conn,$count_sql2));	
                                            $Share_count2 =  $count_result2['COUNT(*)'];
                                            
                                            if($Share_count2 == 0)
                                            {
                                                /*---------------------------------Insert Share Count 1 for First Share--------------------------*/
                                                    $Share_count = '1';
                                                    $sql2 = "INSERT INTO lsl_share_notification_details(Enrollment_id,Company_id,Share_count,Social_media,User_notification_id,Update_user_id,Update_date)
                                                             VALUES('".$Enrollment_id."','".$Company_id."','".$Share_count."','".$Social_icon_flag."','".$User_notification_id."','".$Enrollment_id."','".$Update_date."')";
                                                    $result2 = mysqli_query($conn,$sql2);
                                                /*---------------------------------Insert Share Count 1 for First Share--------------------------*/
                                                    
                                                /*---------------------------------Update Customer Balance--------------------------*/
                                                    $Current_balance = $member_details['Current_balance'];
                                                    $New_Current_balance = $Current_balance + $Social_share_points;
                                                    $sql3 = "UPDATE lsl_enrollment_master SET Current_balance='".$New_Current_balance."'
                                                             WHERE Enrollment_id='".$Enrollment_id."' ";
                                                    $result3 = mysqli_query($conn,$sql3);
                                                /*---------------------------------Update Customer Balance--------------------------*/
                                                    
                                                /*---------------------------------Insert Transaction Of Share Points--------------------------*/
                                                    $Transaction_type_id = '27';
                                                    $sql4 = "INSERT INTO lsl_transaction(Transaction_type_id,Company_id,Member1_enroll_id,Membership1_id,Transaction_date,Bonus_points,Remarks,Create_user_id,Create_date)
                                                             VALUES('".$Transaction_type_id."','".$Company_id."','".$Enrollment_id."','".$member_details['Membership_id']."','".$Update_date."','".$Social_share_points."','".$Social_media."','".$Enrollment_id."','".$Update_date."')";
                                                    $result4 = mysqli_query($conn,$sql4);
                                                /*---------------------------------Insert Transaction Of Share Points--------------------------*/
                                                    
                                                $Template_type_id = 81;
                                                $Email_Type = 521;  //****Share Bonus**
                                                $share_bonus = lslDB::getInstance()->send_share_bonus_template($Enrollment_id,$Company_id,$Social_media,$Social_share_points,$Email_Type,$Template_type_id);
                                            }
                                        }
                                        
                                        echo json_encode(array("status" => "1001", "Enrollment_id" => $Enrollment_id, "Company_id" => $Company_id, "User_notification_id" => $User_notification_id, "status_message" => "Success"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Share Notification********************************/
                    
                    /************************************Retrieve All notifications without Description********************************/
                    if($API_flag == 48)
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
                                                ORDER BY lsl_user_notification_master.User_notification_id DESC ".$LIMIT." ";
                                    $lv_result2 = mysqli_query($conn,$query2);
                                    while($rows2 = mysqli_fetch_array($lv_result2))
                                    {                                        
                                        $Notification_details[] = array(
                                            "User_notification_id" => $rows2["User_notification_id"],
                                            "Read_status" => $rows2["Note_open"],
                                            "Creation_date" => date("F j, Y",strtotime($rows2["Creation_date"])),
                                            "Transaction_type_name" => $rows2["Transaction_type_name"],
                                            "Reference_no" => $rows2["Reference_no"]
                                        );
                                    }
                                    
                                    $Status_array = array("status" => "1001", "Notification_details" => $Notification_details, "status_message" => "Success");
                                    echo json_encode($Status_array);
                                }
                            }
                        }
                    }
                    /************************************Retrieve All notifications without Description********************************/
                    
                    /************************************Convert cash amount to points value********************************/
                    if($API_flag == 40) 
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                    . "AND lsl_enrollment_master.Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);
                            
                            $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $Cust_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            $Customer_details = mysqli_fetch_array($Cust_details_result);

                            if($Customer_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
                            }
                            else if($Customer_details == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Customer_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2058", "status_message" => "Logged in user is In-active or disabled"));
                                }
                                else
                                {
                                    if($Customer_details['Active_flag'] == 0)
                                    {
                                        echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                    }
                                    else if($_REQUEST['Amount_to_convert'] != "")
                                    {
                                        $Amount_to_convert = trim(string_decrypt($_REQUEST['Amount_to_convert'], $key, $iv));
                                        $Transaction_Amount_to_convert = preg_replace("/[^(\x20-\x7f)]*/s", "", $Amount_to_convert);

                                        if(is_numeric($Transaction_Amount_to_convert))
                                        {
                                            $lv_query291 = "SELECT Points_value_definition,Loyalty_program_name FROM lsl_loyalty_program_master "
                                                         . "WHERE Loyalty_program_id=".$Customer_details['Loyalty_programme_id']." "
                                                         . "AND User_apply_to='1' AND Company_id=".$Company_id;
                                            $lv_result291 = mysqli_query($conn,$lv_query291);
                                            $lv_count_result291 = mysqli_num_rows($lv_result291);

                                            if($lv_count_result291 > 0)
                                            {
                                                $lv_row291 = mysqli_fetch_array($lv_result291);
                                                $lv_Points_value_definition = $lv_row291["Points_value_definition"];
                                                $lv_Loyalty_program_name = $lv_row291["Loyalty_program_name"];

                                                $converted_points = round($Transaction_Amount_to_convert * $lv_Points_value_definition);

                                                $return_details = array(
                                                    "status" => "1001",
                                                    "Loyalty_program" => $lv_Loyalty_program_name,
                                                    "Transaction_Amount" => $_REQUEST['Amount_to_convert'],
                                                    //"Points" => string_encrypt($converted_points,$key, $iv),
                                                    "status_message" => "Success",
                                                    "Points" => $converted_points
                                                );

                                                echo json_encode($return_details);
                                            }
                                            else
                                            {
                                                echo json_encode(array("status" => "2049", "status_message" => " Loyalty Program ID Not Found")); //Invalid Loyalty Program id
                                            }
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                                        }
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                                    }
                                }
                            }
                        }
                    }
                    /************************************Convert cash amount to points value********************************/
                    
                    /*************************Transaction Report *************************/				
                    if($API_flag == 41) 
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => ""));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                    . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                    . "AND lsl_enrollment_master.Password ='".$Password."' "
                                    . "AND User_type_id <> 1 "
                                    . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
                            $member_details = mysqli_fetch_array($member_details_result);

                            if($member_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Kindly Enter Username or Password"));
                            }
                            else
                            {
                                if($member_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active"));
                                }
                                else
                                {
                                    $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                                    $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                                    $Transaction_flag = trim($_REQUEST['Transaction_flag']);
                            
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
                                    
                                    if($Transaction_flag == 3)
                                    {
                                        $Transaction_type = "1";
                                    }
                                    else if($Transaction_flag == 2)
                                    {
                                        $Transaction_type = "3,13,22,27,28,29";
                                    }
                                    else if($Transaction_flag == 1)
                                    {
                                        $Transaction_type = "1,2";
                                    }
                                    
                                    if( ($_REQUEST['Membership_id'] != "" || $_REQUEST['Membership_id'] != NULL) && $Transaction_flag != "")
                                    {
                                        $lv_trans_details = "SELECT E.First_name,E.Middle_name,E.Last_name,E.Membership_id,E.Phone_no,E.User_email_id,T.Benefit_description,T.Transaction_date,T.Bonus_points,T.Transaction_type_id,T.Item_code,T.Quantity,T.Shipping_points,T.Bill_no,T.Voucher_no,T.Branch_code,T.Transaction_amount,T.Redeem_points,T.Bonus_points,T.Loyalty_points,T.Transfer_points,T.Remarks,T.Transaction_type_id
                                                            FROM lsl_enrollment_master as E,lsl_transaction as T
                                                            WHERE T.Membership1_id=E.Membership_id
                                                            AND E.Membership_id='".$Membership_id."'
                                                            AND E.User_type_id='1'
                                                            AND T.Transaction_status='0'
                                                            AND T.Transaction_type_id in (".$Transaction_type.")
                                                            AND (E.Company_id in 	
                                                                     ( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
                                                                       OR (E.Company_id = ".$Company_id."
                                                                     )
                                                                 ) 
                                                            ORDER BY Transaction_date DESC ".$LIMIT." ";
                                    }
                                    else if($_REQUEST['Membership_id'] != "" || $_REQUEST['Membership_id'] != NULL)
                                    {
                                        $lv_trans_details = "SELECT E.First_name,E.Middle_name,E.Last_name,E.Membership_id,E.Phone_no,E.User_email_id,T.Benefit_description,T.Transaction_date,T.Bonus_points,T.Transaction_type_id,T.Item_code,T.Quantity,T.Shipping_points,T.Bill_no,T.Voucher_no,T.Branch_code,T.Transaction_amount,T.Redeem_points,T.Bonus_points,T.Loyalty_points,T.Transfer_points,T.Remarks,T.Transaction_type_id
                                                            FROM lsl_enrollment_master as E,lsl_transaction as T
                                                            WHERE T.Membership1_id=E.Membership_id
                                                            AND E.Membership_id='".$Membership_id."'
                                                            AND E.User_type_id='1'
                                                            AND T.Transaction_status='0'
                                                            AND (E.Company_id in 	
                                                                     ( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
                                                                       OR (E.Company_id = ".$Company_id."
                                                                     )
                                                                 ) 
                                                            ORDER BY Transaction_date DESC ".$LIMIT." ";
                                        
                                        /*$lv_trans_details = "SELECT E.First_name,E.Middle_name,E.Last_name,E.Membership_id,E.Phone_no,E.User_email_id,T.Transaction_date,T.Transaction_amount,T.Quantity,T.Item_code,T.Branch_user_id,T.Bill_no,T.Branch_code,T.Remarks,T.Redeem_points
                                                             FROM lsl_enrollment_master as E,lsl_transaction as T
                                                             WHERE T.Membership1_id=E.Membership_id
                                                             AND E.Company_id=".$Company_id." 
                                                             AND E.Membership_id='".$Membership_id."'
                                                             AND E.User_type_id='1'
                                                             AND T.Transaction_status='0' 
                                                             AND (T.Product_group_code != '' OR T.Product_brand_code != '' OR T.Item_code !=  '' )
                                                             ".$LIMIT." ";*/
                                    }
                                    else if($Transaction_flag != "")
                                    {
                                        $lv_trans_details = "SELECT E.First_name,E.Middle_name,E.Last_name,E.Membership_id,E.Phone_no,E.User_email_id,T.Benefit_description,T.Transaction_date,T.Bonus_points,T.Transaction_type_id,T.Item_code,T.Quantity,T.Shipping_points,T.Bill_no,T.Voucher_no,T.Branch_code,T.Transaction_amount,T.Redeem_points,T.Bonus_points,T.Loyalty_points,T.Transfer_points,T.Remarks,T.Transaction_type_id
                                                            FROM lsl_enrollment_master as E,lsl_transaction as T
                                                            WHERE T.Membership1_id=E.Membership_id
                                                            AND E.User_type_id='1'
                                                            AND T.Transaction_status='0'
                                                            AND T.Transaction_type_id in (".$Transaction_type.")
                                                            AND (E.Company_id in 	
                                                                     ( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
                                                                       OR (E.Company_id = ".$Company_id."
                                                                     )
                                                                 ) 
                                                            ORDER BY Transaction_date DESC ".$LIMIT." ";
                                    }
                                    else
                                    {
                                        $lv_trans_details = "SELECT E.First_name,E.Middle_name,E.Last_name,E.Membership_id,E.Phone_no,E.User_email_id,T.Benefit_description,T.Transaction_date,T.Bonus_points,T.Transaction_type_id,T.Item_code,T.Quantity,T.Shipping_points,T.Bill_no,T.Voucher_no,T.Branch_code,T.Transaction_amount,T.Redeem_points,T.Bonus_points,T.Loyalty_points,T.Transfer_points,T.Remarks,T.Transaction_type_id
                                                            FROM lsl_enrollment_master as E,lsl_transaction as T
                                                            WHERE T.Membership1_id=E.Membership_id
                                                            AND E.User_type_id='1'
                                                            AND T.Transaction_status='0'
                                                            AND (E.Company_id in 	
                                                                     ( SELECT Company_id FROM lsl_company_master WHERE Parent_company_id = ".$Company_id." and Active_flag=1) 
                                                                       OR (E.Company_id = ".$Company_id."
                                                                     )
                                                                 ) 
                                                            ORDER BY Transaction_date DESC ".$LIMIT." ";
                                    }
                                    //echo $lv_trans_details;
                                    $lv_result = mysqli_query($conn,$lv_trans_details);	
                                    $Transaction_count = mysqli_num_rows($lv_result);
                                    
                                    if($Transaction_count > 0)
                                    {
                                        while($rows198 = mysqli_fetch_array($lv_result))
                                        {
                                            $lv_get_item_name = "SELECT * FROM lsl_branch_pos_inventory_master "
                                                              . "WHERE Item_code='".$rows198["Item_code"]."' "
                                                              . "AND Company_id=".$Company_id."";
                                            $lv_result2 = mysqli_query($conn,$lv_get_item_name);
                                            $rec_item=mysqli_fetch_array($lv_result2);
                                            $Item_name=$rec_item["Item_name"];
                                            if($Item_name == "" || $Item_name == null){$Item_name = ' - ';}

                                            $lv_get_branch_user_name = "SELECT * FROM lsl_enrollment_master "
                                                                     . "WHERE Enrollment_id=".$rows198["Branch_user_id"]."";
                                            $lv_result2 = mysqli_query($conn,$lv_get_branch_user_name);
                                            $rec_branch=mysqli_fetch_array($lv_result2);
                                            if($rec_branch != NULL)
                                            {
                                                $Branch_user_name = $rec_branch['First_name']." ".$rec_branch['Middle_name']." ".$rec_branch['Last_name'];
                                            }
                                            else
                                            {
                                                $Branch_user_name = ' - ';
                                            }

                                            $lv_get_branch_name = "SELECT Branch_name FROM lsl_branch_master "
                                                                . "WHERE Branch_code='".$rows198["Branch_code"]."' "
                                                                . "AND Company_id=".$Company_id." ";
                                            $lv_result2222 = mysqli_query($conn,$lv_get_branch_name);
                                            $rec_branch_name=mysqli_fetch_array($lv_result2222);
                                            if($rec_branch_name != NULL)
                                            {
                                                $Branch_name = $rec_branch_name['Branch_name'];
                                            }
                                            else
                                            {
                                                $Branch_name = ' - ';
                                            }

                                            if( $rows198['Transaction_type_id'] == 2 && ($rows198['Bill_no'] == "" || $rows198['Bill_no'] == NULL) )
                                            {
                                                $Bill_no = $rows198['Voucher_no'];
                                            }
                                            else if($rows198['Transaction_type_id'] == 1)
                                            {
                                                $Bill_no = $rows198['Bill_no'];
                                            }
                                            else
                                            {
                                                $Bill_no = " - ";
                                            }

                                            if($rows198['Remarks'] == "" || $rows198['Remarks'] == NULL)
                                            {
                                                $Remark = " - ";
                                            }
                                            else
                                            {
                                                $Remark = $rows198['Remarks'];
                                            }
											
											if($rows198["Transaction_type_id"] == 8)
											{
												$Expired_points = $rows198['Transaction_amount'];
												$TransactionAmt = 0;
											}
											else
											{
												$Expired_points = 0;
												$TransactionAmt = $rows198['Transaction_amount'];
											}
												
											$lv_get_tran_type = "SELECT Transaction_type_name FROM lsl_transaction_type_master "
                                                                . "WHERE Transaction_type_id='".$rows198["Transaction_type_id"]."' ";
                                            $lv_result122 = mysqli_query($conn,$lv_get_tran_type);
                                            $rec_trn_type14 = mysqli_fetch_array($lv_result122);
                                            if($rec_trn_type14 != NULL)
                                            {
                                                $Transaction_type_name = $rec_trn_type14['Transaction_type_name'];
                                            }
											
					
                                            $tr_details2[] = array
                                                    (
														"Transaction_type_id" => $rows198["Transaction_type_id"],
														"Transaction_type_name" => $Transaction_type_name,
                                                        "Transaction_date" => date("Y-m-d",strtotime($rows198['Transaction_date'])),
                                                        "Member_name" => $rows198['First_name']." ".$rows198['Middle_name']." ".$rows198['Last_name'],
                                                        "Membership_id" => $rows198['Membership_id'],
                                                        "Branch_name" => $Branch_name,
                                                        "Branch_user_name" => $Branch_user_name,
                                                        "Bill_no" => $Bill_no,
                                                        "Transaction_amount" => $TransactionAmt,
                                                        "Expired_points" => $Expired_points,
                                                        "Item_name" => $Item_name,
                                                        "Quantity" => $rows198['Quantity'],
                                                        "Redeem_points" => $rows198['Redeem_points'],
                                                        "Loyalty_points" => $rows198['Loyalty_points'],
                                                        "Bonus_points" => $rows198['Bonus_points'],
                                                        /*"Balance_to_pay" => $rows198['Balance_to_pay'],
                                                        "Redeem_amount" => $rows198['Redeem_amount'],
                                                        "Loyalty_points" => $rows198['Loyalty_points'],*/
                                                        "Remarks" => $Remark
                                                    );
                                        }

                                        $return_details2 = array("status" => "1001", "Transactions" => $tr_details2, "status_message" => "Success");
                                        echo json_encode($return_details2);		
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                    }
                    /*************************Transaction Report *************************/	
                    
                    /************************* Products details *************************/				
                    if($API_flag == 42) 
                    {
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                            . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                            . "AND lsl_enrollment_master.Password ='".$Password."' "
                                            . "AND User_type_id <> 1 "
                                            . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
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
                                    //$Branch_code = trim(string_decrypt($_REQUEST['Branch_code'], $key, $iv));
                                    //$Branch_code = preg_replace("/[^(\x20-\x7f)]*/s", "", $Branch_code);
                                    $Branch_code = trim($_REQUEST['Branch_code']);
                                    
                                    $Start_limit = trim($_REQUEST['Start_limit']);
                                    $End_limit = trim($_REQUEST['End_limit']);
                                    $Item_type = trim($_REQUEST['Item_type']);
									
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
                                    
                                    //$myquery = "Select * from lsl_branch_pos_inventory_master where Company_id=".$Company_id." GROUP BY Item_code ".$LIMIT." ";
                                    
                                    if($_REQUEST['Branch_code'] == "" || $_REQUEST['Branch_code'] == NULL)
                                    {
										if($Item_type == 0 || $Item_type == "" || $Item_type == NULL) //**** all items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 1) //**** all gift items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Gift_flag='1' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 2) //**** all spend items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND b.Points_award_item_flag='1' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 3) //**** all redeem items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND b.Points_award_item_flag='2' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 4) //**** pos purchase items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND b.Points_award_item_flag='0' AND a.Gift_flag='0' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
                                    }
                                    else
                                    {
										if($Item_type == 0 || $Item_type == "" || $Item_type == NULL)
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Branch_code='".$Branch_code."' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 1) //**** all gift items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Branch_code='".$Branch_code."' AND a.Gift_flag='1' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 2) //**** all spend items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Branch_code='".$Branch_code."' AND b.Points_award_item_flag='1' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 3) //**** all redeem items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Branch_code='".$Branch_code."' AND b.Points_award_item_flag='2' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
										else if($Item_type == 4) //**** all pos purchase items
										{
											$myquery = "Select a.*,b.Points_award_item_flag from lsl_branch_pos_inventory_master as a,lsl_pos_inventory_master as b where a.Item_code=b.Item_code AND a.Company_id=".$Company_id." AND a.Branch_code='".$Branch_code."' AND b.Points_award_item_flag='0' AND a.Gift_flag='0' AND a.Active_flag=1 ".$LIMIT." ";  //GROUP BY Item_code
										}
                                    }
                                    
                                    $myresult = mysqli_query($conn,$myquery);
                                    if(mysqli_num_rows($myresult)>0)
                                    {
                                        while($myrow = mysqli_fetch_array($myresult))
                                        {
                                            $Item_price = $myrow['Item_price'];
                                            $Item_vat = $myrow['Item_vat'];
                                            $vatprice = ($Item_price/100) * $Item_vat;
                                            $total_cost = $Item_price + $vatprice;
                                            
                                            $query85 = "SELECT Branch_name FROM lsl_branch_master WHERE Branch_code='".$myrow['Branch_code']."' AND Company_id=".$Company_id;
                                            $res85 = mysqli_query($conn,$query85);
                                            $BranchDetails = mysqli_fetch_array($res85);
                                            
                                            /*$myquery12 = "SELECT Branch_code,Current_balance,Threshold_balance,Item_vat FROM lsl_branch_pos_inventory_master "
                                                     . "WHERE Company_id=".$Company_id." "
                                                     . "AND Item_code='".$myrow['Item_code']."' ";
                                            $myresult12 = mysqli_query($conn,$myquery12);
                                            while($myrow12 = mysqli_fetch_array($myresult12))
                                            {
                                                $Branch_details[] = array(
                                                    "Branch_code" => $myrow12['Branch_code'],
                                                    "Stock_quantity" => intval($myrow12['Current_balance']),
                                                    "Item_Threshold_bal" => $myrow12['Threshold_balance'],
                                                    "Item_vat" => $myrow12['Item_vat']
                                                );
                                            }
                                            
                                            $tr_details3[] = array
                                                    (
                                                        "item_code" => $myrow['Item_code'],
                                                        "Item_name" => $myrow['Item_name'],
                                                        "Item_price" => $myrow['Item_price'],
                                                        "Branch_details" => $Branch_details,
                                                        "total_cost" => $total_cost
                                                    );*/
												
												if($myrow['Gift_flag'] == 1)
												{
													$Item_Remark = "Gift Card Item";
												}
												else if($myrow['Points_award_item_flag'] == 1)
												{
													$Item_Remark = "Spend For Loyalty";
												}
												else if($myrow['Points_award_item_flag'] == 2)
												{
													$Item_Remark = "Points Redemption";
												}
												else
												{
													$Item_Remark = "";
												}
												
												
                                            $tr_details3[] = array
                                                    (
                                                        "Item_code" => $myrow['Item_code'],
                                                        "Item_name" => $myrow['Item_name'],
                                                        "Item_price" => $myrow['Item_price'],
                                                        "Item_vat" => $myrow['Item_vat'],
                                                        "Branch_code" => $myrow['Branch_code'],
                                                        "Branch_name" => $BranchDetails['Branch_name'],
                                                        "Stock_quantity" => intval($myrow['Current_balance']),
                                                        "Item_Threshold_bal" => $myrow['Threshold_balance'],
                                                        "total_cost" => $total_cost,
                                                        "Item_type" => $Item_Remark
                                                    );
                                        }

                                        $return_details3 = array
                                                (
                                                    "status" => "1001",
                                                    "status_message" => "Success",
                                                    "Products" => $tr_details3
                                                );

                                        echo json_encode($return_details3);
										exit;
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
										exit;
                                    }
                                }
                            }
                        }
                    }	
                    /************************* Products details *************************/
                    
                    /************************************Fetch Payment Methods********************************/
                    if($API_flag == 49)
                    {
                        $query1 = "SELECT Payment_type_id,Payment_type_name FROM lsl_payment_type_master";
                        $Payment_type_result = mysqli_query($conn,$query1);
                        $Payment_type_count = mysqli_num_rows($Payment_type_result);
                        
                        if($Payment_type_count > 0)
                        {
                            while($Payment_type = mysqli_fetch_array($Payment_type_result))
                            {
                                $Payment_type_details[] = array(
                                                    "Payment_type_id" => $Payment_type['Payment_type_id'],
                                                    "Payment_type_name" => $Payment_type['Payment_type_name']
                                                );
                            }
                            
                            $Status_array = array("status" => "1001", "Payment_type_details" => $Payment_type_details, "status_message" => "Success");
                            echo json_encode($Status_array);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                        }
                    }
                    /************************************Fetch Payment Methods********************************/
                    
            /************************* POS Transactions Start *************************/	
                   
				 if($API_flag == 43) 
                    {
                        $items_ID = array();
                        $items_name = array();
                        $item_qty = array();
                        $item_price = array();
                        $item_vat = array();
                        $Bal_to_pay = 0;
                        $grand_total = 0;
                        $RedeemAmt = 0;
						$RedeemPoints = 0;
                        $Membership_ID = 0;
                        $todays=date("Y-m-d");
                        $campaignID = array();

                        $source = "API";
                        $bonus_points = 0;
				
                        $loyalty_points = 0;
                        $cmp_prod_code = array();
                        $cmp_trn_code = array();
                        $cmp_trn_channel_code = array();

                        $BankName = "";
						$Remark = $_REQUEST['Remark'];
                        
                        $EmployeeID = 0;
                        
                        $myquery23 = lslDB::getInstance()->get_company_details($Company_id);
                        $Company_details = mysqli_fetch_array($myquery23);
                        
                        $Discount_applicable = $Company_details['Discount_applicable'];
                        $TransDiscount = $Company_details['Discount'];
                        $Discount_from_date = $Company_details['Discount_from_date'];
                        $Discount_to_date = $Company_details['Discount_to_date'];
                        $lv_Parent_company_id = $Company_details['Parent_company_id'];
                        $Cust_pin_validation12 = $Company_details['Cust_pin_validation'];
                        $Branch_user_pin_validation12 = $Company_details['Branch_user_pin_validation'];
                        $redemptionratio = $Company_details['Points_value_definition'];
                        $Solution_type = $Company_details['Solution_type'];
                        $company_current_balance = $Company_details['Current_balance'];
                        $Company_Threshold_amount = $Company_details['Threshold_amount'];
                        $Credit_transaction_sms = $Company_details['Pos_transaction_sms'];

                        if($Solution_type == 3)
                        {	
                            $member_company_id = $lv_Parent_company_id;
                        }
                        else
                        {
                            $member_company_id = $Company_id;
                        }

                        $mv_date=date("Y-m-d");
                        $timezone = new DateTimeZone($Company_details["Timezone"]);
                        $date = new DateTime();
                        $date->setTimezone($timezone );
                        $lv_time=$date->format('H:i:s');
                        $mv_datetime = $mv_date.' '.$lv_time;
                        $mv_create_date = $mv_datetime;
						$trans_date = $mv_datetime;
						
                        if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
                            $Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
                            $Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

                            $Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
                            $Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

                            $Branch_code = trim(string_decrypt($_REQUEST['Branch_code'], $key, $iv));
                            $branchecode = preg_replace("/[^(\x20-\x7f)]*/s", "", $Branch_code);

                            if($branchecode == "")
                            {
                                echo json_encode(array("status" => "2071", "status_message" => "Invalid Branch Code"));
                                exit;
                            }

                            $query1 = "SELECT * FROM lsl_enrollment_master "
                                            . "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
                                            . "AND lsl_enrollment_master.Password ='".$Password."' "
                                            . "AND User_type_id <> 1 "
                                            . "AND Company_id='".$Company_id."' ";
                            $member_details_result = mysqli_query($conn,$query1);
							
					//echo 	$query1;	
                            $user_details = mysqli_fetch_array($member_details_result);

                            $login_enroll_id = $user_details['Enrollment_id'];	
                            $user_email_id = $user_details['User_email_id'];
                            $loguserid = $user_details['User_type_id'];			
                            $user_pin = $user_details['Pin']; 	
                            $User_type_id = $user_details['User_type_id'];
                            $mv_create_user_id = $login_enroll_id;
					
                            if($User_type_id == 6)
                            {
                                $branchecode = $user_details['Branch_code'];
                            }

                            if($user_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
                            }
                            else
                            {
                                if($user_details['Active_flag'] == 0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($_REQUEST['Transaction_flag'] == "" || $_REQUEST['Transaction_flag'] > 4)
                                    {
                                        echo json_encode(array("status" => "2063", "status_message" => "Invalid transaction flag"));
                                        exit;
                                    }
                                    else
                                    {
                                        //*************** company transaction type code *******************
                                            $channelj = "Select * from lsl_company_transaction_type_master where Company_id=$Company_id order by Transaction_type_id limit 1";
                                            $exe_queryj = mysqli_query($conn,$channelj);
                                            while($exe_resj = mysqli_fetch_array($exe_queryj))
                                            {
                                                $CompTransaction_type = $exe_resj['Transaction_type_code'];
                                            }
							
                                        //********** transaction channel of company *************
                                            $channel = "Select * from lsl_company_transaction_channel_master where Company_id=$Company_id order by Transaction_channel_id limit 1";
                                            $exe_query = mysqli_query($conn,$channel);
                                            while($exe_res = mysqli_fetch_array($exe_query))
                                            {
                                                $transaction_channel = $exe_res['Comp_trans_channel_code'];
                                            }
		
                                        //**** Branch details ****
                                            $branch_info = lslDB::getInstance()->get_branch_details($branchecode,$Company_id);
                                            while($res2 = mysqli_fetch_array($branch_info))
                                            {
                                                $Branch_name =$res2['Branch_name'];
                                                $Branch_City_id = $res2['City_id'];			
                                                $Branch_Address = $res2['Address']; 	
                                                $Pos_series_no = $res2['Pos_series_no'];
                                            }

                                            $branch_info12 = mysqli_num_rows($branch_info);								
                                            if($branch_info12 == 0 || $branch_info12 == NULL)
                                            {
                                                echo json_encode(array("status" => "2071", "status_message" => "Invalid Branch Code"));
                                                exit;
                                            }
					
                                        //echo "real Bill No. -->" .$Pos_series_no."<br>";
                                        $BillNo = $Pos_series_no; 
							
                                        /*---------------------------Check for Duplicate BillNo No-------------------------*/                    
                                            $query89 = "SELECT Transaction_id FROM lsl_transaction "
                                                            . "WHERE Bill_no='".$BillNo."' "
                                                            . "AND Company_id='".$Company_id."' "
                                                            . "AND Branch_code='".$branchecode."' "
                                                            . "AND Transaction_type_id=1";
                                           $Bill_no_no_check = mysqli_num_rows(mysqli_query($conn,$query89));
									   
                                            if($Bill_no_no_check > 0)
                                            {
                                                //echo "yes bill no exist"; die;
                                                echo json_encode(array("status" => "2067", "status_message" => "Bill Number already exist"));
                                            }
                                            
                                        /*---------------------------Check for Duplicate BillNo No-------------------------*/							  
                                            //echo "Branch_user_pin_validation12 is ----".$Branch_user_pin_validation12."<br>";
                                            if($Branch_user_pin_validation12 == 1)
                                            {
                                                $BranchUser_Pin = trim(string_decrypt($_REQUEST['BranchUser_Pin'], $key, $iv));
                                                $BranchPin = preg_replace("/[^(\x20-\x7f)]*/s", "", $BranchUser_Pin);
                                                //echo "BranchUser_Pin is ----".$BranchPin."<br>";
                                                //echo "user_details pin is ----".$user_details['Pin']."<br>";

                                                if($BranchPin != $user_details['Pin'] )
                                                {
                                                    echo json_encode(array("status" => "2065", "status_message" => "Invalid Cashier Pin"));
                                                    exit;
                                                }
                                            }
								
                                        $todayis = date("Y-m-d");	
                                        $CompDiscount = 0;
								
                   // echo "Discount_applicable is ----".$Discount_applicable."<br>";

                                        $flag_h = $_REQUEST['Transaction_flag'];	
                                        $PaymentBy = $_REQUEST['PaymentBy'];
										
										if($PaymentBy == "")
										{
											$PaymentBy = 1;
										}
										
										$querypp = "select Payment_type_id ,Payment_type_name from lsl_payment_type_master where Payment_type_id='".$PaymentBy."' ";
										$resultp = mysqli_query($conn,$querypp);
				
										while ($rowp = mysqli_fetch_assoc($resultp))
										{
											$Payment_type_name = $rowp['Payment_type_name'];
										}
								
										

                                        if($flag_h == 3)
                                        {
                                            $insertFlag = 1;
                                        }
                                        else
                                        {
                                            $insertFlag = 0;
                                        }
								
                                        if($_REQUEST['Voucher_cheque_no'] != "")
                                        {
                                            if($PaymentBy == 6 || $PaymentBy == 7)
                                            {
                                                $voucher_cheque_no = trim(string_decrypt($_REQUEST['Voucher_cheque_no'], $key, $iv));
                                                $Voucher = preg_replace("/[^(\x20-\x7f)]*/s", "", $voucher_cheque_no);
                                                $Cheque  = 0;
                                            }
                                            else 
                                            {
                                                $voucher_cheque_no = trim(string_decrypt($_REQUEST['Voucher_cheque_no'], $key, $iv));
                                                $Cheque = preg_replace("/[^(\x20-\x7f)]*/s", "", $voucher_cheque_no);
                                                $Voucher = 0;
                                            }
                                        }
                                        else
                                        {
                                            $Cheque = 0;
                                            $Voucher = 0;
                                        }
								
                                        if($_REQUEST['Transaction_flag'] == 1 || $_REQUEST['Transaction_flag'] == 3) //loyalty transaction or points award
                                        {
                                            $Transaction_type = 1;

                                            if($_REQUEST['Membership_id'] == "")
                                            {
                                                echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                                                exit;
                                            }
                                            else
                                            {
                                                $Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                                                $Membership_ID = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);

                                                $queryg1 ="SELECT * FROM lsl_enrollment_master "
                                                                . "WHERE Company_id='".$member_company_id."'"
                                                                . "AND Active_flag='1'"
                                                                . "AND Membership_id='".$Membership_ID."' ";
               // echo "<br>---lv_member queryg1--".$queryg1 ."---<br>";											
                                                $res6 = mysqli_fetch_array(mysqli_query($conn, $queryg1));
										
                                                if($res6 == NULL)
                                                {
                                                    echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                                                    exit;
                                                }
                                                else
                                                {
                                                    if($res6['Active_flag'] == "0")
                                                    {
                                                            echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                                            exit;
                                                    }
                                                    else
                                                    {
                                                        $lv_member_name = $res6['First_name']." ".$res6['Last_name'];
                                                        //echo "<br>---lv_member_name--".$lv_member_name ."---<br>";										
                                                        $lv_member_pin = $res6['Pin'];
                                                        $lv_member_enrollid = $res6['Enrollment_id'];
                                                        $lv_member_balance = $res6['Current_balance'];
                                                        $lv_purchase_amount = $res6['Total_purchase_amount'];
                                                        $lv_bonus_points = $res6['Total_bonus_points'];
                                                        $lv_redeem_points = $res6['Total_redeem_points'];
                                                        $lv_gained_points = $res6['Total_gained_points'];
                                                        $lv_parent_enrollid = $res6['Parent_enroll_id'];
														$Family_redeem_limit    = $res6['Family_redeem_limit'];
                                                        $lv_Familly_flag = $res6['Familly_flag'];
                                                        $member_tier_id = $res6['Tier_id'];
                                                        $member_lp_id = $res6['Loyalty_programme_id'];
                                                        $lv_member_Account_no = $res6['Account_number'];
                                                        $lv_countryid  = $res6['Country_id'];
                                                        $Communication_flag  = $res6['Communication_flag'];
                                                        $Member_Blocked_points  = $res6['Blocked_points'];
                                                        $CurrBal = $lv_member_balance - $Member_Blocked_points;
                                                        $MemberPin = $lv_member_pin;
															
														
														 if($Cust_pin_validation12 == 1)
														{
															$cust_Pin = trim(string_decrypt($_REQUEST['MemberPin'], $key, $iv));
															$MemberPin = preg_replace("/[^(\x20-\x7f)]*/s", "", $cust_Pin);

															if($MemberPin != $lv_member_pin )
															{
																echo json_encode(array("status" => "2025", "status_message" => "Incorrect PIN"));
																exit;
															}
														}
											
                                                        if($lv_countryid == 1)
                                                        {
                                                            $exchange_rate = 1;
                                                        }
                                                        else
                                                        {
                                                            $country_info = lslDB::getInstance()->get_Country($lv_countryid);
                                                            while($res12 = mysqli_fetch_array($country_info))
                                                            {
                                                                $exchange_rate = $res12['Exchange_rate'];
                                                            }
                                                        }
														
														$query15 = mysqli_query($conn,"select Points_value_definition from lsl_loyalty_program_master where Loyalty_program_id=$member_lp_id AND Company_id=".$member_company_id);
														
														while($row15 = mysqli_fetch_array($query15))
														{
															$redemptionratio = $row15['Points_value_definition'];
														}
			
                                                    }
											
                                                    if( $flag_h < 3 && $_REQUEST['Redeem_points'] != "")
                                                    {
                                                        $Redeem_points = trim(string_decrypt($_REQUEST['Redeem_points'], $key, $iv));
                                                        $RedeemPoints = preg_replace("/[^(\x20-\x7f)]*/s", "", $Redeem_points);
                               // echo "<br>---Redeem_points--".$RedeemPoints ."---<br>";										
                                                        $RedeemAmt = round($RedeemPoints/$redemptionratio);
                                //echo "<br>---RedeemAmt--".$RedeemAmt ."---<br>";
                                                    }
                                                }
                                            }
                                        }								
								
                                        $total_amt = 0;
                                        $total_vat = 0;
                                        $grand_total = 0;
									
                                       /* if($_REQUEST['item_1'] != "")
                                        {
                                            $item_1 = $_REQUEST['item_1'];
                                            $quantity_1 = $_REQUEST['quantity_1'];
                                            $Product_details1["Item_code"] = $item_1;
                                            $Product_details1["Quantity"] = $quantity_1;
                                            $Product_details1["Total_price"] = $_REQUEST['price_1'];
                                            $Product_details[0] = $Product_details1;
                                        }

                                        if($_REQUEST['item_2'] != "")
                                        {
                                            $item_2 = $_REQUEST['item_2'];
                                            $quantity_2 = $_REQUEST['quantity_2'];
                                            $Product_details2["Item_code"] = $item_2;
                                            $Product_details2["Quantity"] = $quantity_2;
                                            $Product_details2["Total_price"] = $_REQUEST['price_2'];
                                            $Product_details[1] = $Product_details2;
                                        }			
									*/
									
						//********* gift card purchase *****************************/
                                            if($_REQUEST["GiftCardPurchase_Flag"] == 1)
                                            {
                                                if($_REQUEST['Transaction_flag'] == 2)
                                                {
                                                    $lv_member_enrollid = 0;
                                                }
												
												
                                                $GiftCardArray = $_REQUEST['Purchase_GiftCardArray'];

                                                if($_REQUEST['Purchase_GiftCardArray'] == "" || $_REQUEST['Purchase_GiftCardArray'] == NULL)
                                                {
                                                    echo json_encode(array("status" => "2074", "status_message" => "Please Enter Gift Card No"));
                                                    exit;
                                                }
											}
							//********* gift card purchase *****************************/
									
								$Product_details = $_REQUEST['Product_details'];
			//print_r($Product_details);		
									if(empty($Product_details))
									{
										echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
										exit;
									}
									
									if($PaymentBy == 9 && count($Product_details) < 2)
									{
										echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
										exit;
									}
									
                                        $loopC = 0;
										
									$purchase_item_details = array();
									$prd_array = array();
									$GiftCardItems = array();
									
                                        foreach($Product_details as $item_info)
                                        {
                                            $product_id = $item_info["Item_code"];
                                            $items_ID[] = $item_info["Item_code"];
											$prd_array['itemcode'] = $item_info["Item_code"];
											
                                            if($flag_h == 3 && ($_REQUEST["GiftCardPurchase_Flag"] == 0 || $_REQUEST["GiftCardPurchase_Flag"] == "")) //***** points award transaction**
                                            {
                                                $product_qty = 1;
                                                $item_qty[] = 1;
                                            }
                                            else
                                            {
                                                $product_qty = $item_info["Quantity"];
                                                $item_qty[] = $item_info["Quantity"];
												
												if($product_qty == "")
												{
													$product_qty = 1;
													$item_qty[] = 1;
												}
                                            }
											
											$prd_array['quantity'] = $product_qty;
											
                                            $myquery88 = "Select A.*,B.Points_award_item_flag,B.Gift_flag as GiftItem from lsl_branch_pos_inventory_master as A,lsl_pos_inventory_master as B where A.Item_code = B.Item_code AND A.Company_id = B.Company_id AND A.Item_code='".$product_id."' AND A.Branch_code='".$branchecode."' AND A.Company_id=".$Company_id;
			 //echo "<br>---myquery88--".$myquery88."---<br>";
                                            $myresult88 = mysqli_query($conn,$myquery88);
                                            if(mysqli_num_rows($myresult88)>0)
                                            {
                                                while($myrow = mysqli_fetch_array($myresult88))
                                                {
                                                    $item_code = $myrow['Item_code'];
                                                    $Item_name = $myrow['Item_name'];
                                                    $Item_price = $myrow['Item_price'];
                                                    $Item_vat = $myrow['Item_vat'];
                                                    $Item_Current_balance = intval($myrow['Current_balance']);
                                                    $Item_Threshold_bal = $myrow['Threshold_balance'];
                                                    $Gift_flag = $myrow['GiftItem'];
                                                    $Points_award_item_flag = $myrow['Points_award_item_flag'];
                                                }
												
												 if($_REQUEST["GiftCardPurchase_Flag"] == 1 && $Gift_flag == 1)
												{
													$GiftCardItems[] = $item_code;
												}
							//echo "<br>---Points_award_item_flag--".$Points_award_item_flag."---<br>";
												if($PaymentBy == 8)
												{
													$Item_vat = 0;
												}
												
												$prd_array['Item_name'] =  $Item_name;
												$prd_array['Rate'] =  $Item_price;
												
                                                if($flag_h == 3) //***** points award transaction**
                                                {
													//$prd_array['price'] = $item_info['Total_price'];
													$product_price = $item_info['Total_price'];
													
													if($Gift_flag == 0 && ($product_price == "" || $product_price <= 0))
													{
														echo json_encode(array("status" => "2073", "status_message" => "Please Enter Item Price"));
														exit;
													}
													
													if($Points_award_item_flag != 2 && $PaymentBy == 8)
													{
														echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
														exit;
													}
													
                                                    if($Points_award_item_flag == 2 && ($PaymentBy == 8 || $PaymentBy == 9))
                                                    {
                                                        $RedeemAmt = $item_info['Total_price'];
                                                        $vatprice = ($RedeemAmt/100) * $Item_vat;
                                                        $RedeemPoints = round($vatprice + $RedeemAmt);
														
				/****************************Chcek Tier Redemption Level*********************************/
														$Redeem_ERROR_FLAG = 0;
														
														if($lv_parent_enrollid > 0)
														{

															$todays_date11 = date("Y-m-d");
															$check_count_tras_family_memb=lslDB::getInstance()->check_count_trasaction_family_memb($Company_id,$lv_member_enrollid,$todays_date11);
															
															$Family_member_access=1;
															
															$rows12=mysqli_fetch_array($check_count_tras_family_memb);
															
															$family_mem_total_redeem_points = $rows12["sum(Redeem_amount)"];
															$family_mem_total_Transfer_points = $rows12["sum(Transfer_points)"];
															
															//echo "the parent Blocked_points-->".$row['Blocked_points']."--<br>";
															//echo "the family_mem_total_redeem_points-->".$family_mem_total_redeem_points."--<br>";
															
															$Total_available_points_family_mem = $Family_redeem_limit - ( $family_mem_total_redeem_points + $family_mem_total_Transfer_points + $Member_Blocked_points);
														
															//echo "the Total_available_points_family_mem-->".$Total_available_points_family_mem."--<br>";
															
															$Redeem_ERROR_FLAG = 1;
																			
														}
														else
														{
															$lv_get_tier = lslDB::getInstance()->get_tier($member_tier_id);
															$rec_tier=mysqli_fetch_array($lv_get_tier);

															$Redeemption_level=$rec_tier["Redeemption_level"];
															$Minimum_points_balance=$rec_tier["Minimum_points_balance"];
															$Minimum_points_balance_redeem = $rec_tier["Minimum_points_balance_redeem"];
															$Tier_name=$rec_tier["Tier_name"];

															$get_last_redeem_trans="SELECT COUNT(*) AS num FROM lsl_transaction where Company_id=".$Company_id." AND  Membership1_id='".$Membership_ID."' AND Transaction_type_id='1' AND Redeem_points > '0'";
															$result225=mysqli_query($conn,$get_last_redeem_trans);
															$rec_trans=mysqli_fetch_array($result225);
															$First_time_redeem=$rec_trans["num"];
					
															$Total_available_points_family_mem = 0;
															
															if($member_tier_id > 0 && $First_time_redeem==0 && $Redeemption_level == 1)
															{
																if($Minimum_points_balance > $CurrBal)
																{
																	$Total_available_points_family_mem = '-1';
																}
																else
																{
																	$Total_available_points_family_mem = $Minimum_points_balance_redeem;
																}
																
															}
															
															if($Total_available_points_family_mem > 0)
															{
																$Redeem_ERROR_FLAG = 2;
															}
															

														}	
															
														if($Total_available_points_family_mem < 0)
														{		
															echo json_encode(array("status" => "2075", "status_message" => "Your Current Balance is lower than your tier minimum balance"));
															exit;
															
															/*
															echo "Sorry ! This being your first time redemption, You will Not be able to Redeem as your Current Balance is less than Minimum required for your Tier!";
															*/

														}
														else if($Redeem_ERROR_FLAG == 1 && ($RedeemPoints <= $Total_available_points_family_mem ) )
														{
															echo json_encode(array("status" => "2076", "status_message" => "You have exceeded your daily Redemption Limit or Parent Current Balance"));
															exit;
															/*
															echo "Redeemed Points have exceeded your Redemption Limit per Day OR Parent Current Balance !!";
															*/	
														}
														else if($Redeem_ERROR_FLAG == 2 && ($RedeemPoints <= $Total_available_points_family_mem ) )
														{
															echo json_encode(array("status" => "2077", "status_message" => "Your Current Balance is lower than your tier minimum balance"));
															exit;
															/*
															echo "Sorry ! This being your first time redemption, You will Not be able to Redeem as your Redeemable Points is more than "+redeemLimit +" Minimum required for your Tier!";
															*/	
														}
					/****************************Chcek Tier Redemption Level*********************************/	
					
                                                    }
													
													
													
                                                }
										
                                                if($Item_Current_balance >= $product_qty)
                                                {
                                                    $price = $Item_price * $product_qty;
													
													
                                                    if($flag_h == 3 && $item_info['Total_price'] > 0 )
                                                    {
                                                        $price = $item_info['Total_price'];
                                                    }

                                                    $discount_val  = ($price/100) * $CompDiscount;
                                                    $discount_amt = $price - $discount_val;
                                                    $vatprice = ($discount_amt/100) * $Item_vat;

                                                    $items_name[] = $Item_name;
                                                    $item_price[] = $price;
                                                    $item_vat[] = $vatprice;
                                                    $gift_flag[] = $Gift_flag;

                                                    $total_amt = $total_amt + $price;
                                                    $total_vat = $total_vat + $vatprice;
													
													$prd_array['price'] = $price;
													
                                                    if($Item_Threshold_bal >= $Item_Current_balance)
                                                    {
                                                        //echo "<br>Exceded item Threshold level. send mail<br>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo json_encode(array("status" => "2037", "status_message" => "An item is not in stock"));
                                                    exit;
                                                    //echo	"<div id='div_$i'> Only ".$Item_Current_balance." Units of ".$Item_name." available in stock.</div>";
                                                }
                                            }
                                            else
                                            {
                                                echo json_encode(array("status" => "2064", "status_message" => "Item is not available"));
                                                exit;
                                            }
									
                                            
											
											$purchase_item_details[] = $prd_array;
											
											if($flag_h == 3 && $PaymentBy != 9 && $loopC >= 0)
											{
												break;
											}
											
											$loopC++;
                                        }
										
										 if($_REQUEST["GiftCardPurchase_Flag"] == 1)
										{
											if($GiftCardItems == "" || $GiftCardItems == NULL || empty($GiftCardItems))
											{
												echo json_encode(array("status" => "2070", "status_message" => "Transaction Successfully Done"));
                                                    exit;
											}
										}
												
                                        $grand_total = $total_amt + $total_vat;

										$discountamt = 0;
										$discountget = 0;
										
                                        if($Discount_applicable == 1)
                                        {
                                            if($todayis >= $Discount_from_date && $todayis <=$Discount_to_date )
                                            {
                                                $CompDiscount = $TransDiscount;
                                                $discountget = ($total_amt/100)*$CompDiscount;
                                                $discountamt = round($total_amt) - round($discountget);
                                                $grand_total = $discountamt + $total_vat;
                                            }
                                        }
										
										$total_paybal = $grand_total;
										
				/********************* Redeem points validation ****************/
				
										if($CurrBal < $RedeemPoints)
										{
											echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                                            exit;
										}

				/********************* Redeem points validation ****************/
                                        if($RedeemAmt > $grand_total)
                                        {
                                            echo json_encode(array("status" => "2066", "status_message" => "Please Check Redeem Amount"));
                                            exit;
                                        }
										
                                        $Bal_to_pay = $grand_total - $RedeemAmt;									
                                        $GiftCardFlag = $_REQUEST['GiftCardRedeemFlag'];
                                        
										$GiftCardID = 0;
										$GiftRedeem = 0;
										$GiftRemainBalance = 0;
										
                                        if($GiftCardFlag == 1)
                                        {									
                                            if($_REQUEST['GiftCard_no'] == "")
                                            {
                                                    echo json_encode(array("status" => "2074", "status_message" => "Please Enter Gift Card No"));
                                                    exit;
                                            }
                                            
                                            $GiftCard_no = trim(string_decrypt($_REQUEST['GiftCard_no'], $key, $iv));
                                            $GiftCardID = preg_replace("/[^(\x20-\x7f)]*/s", "", $GiftCard_no);									
									
                                            $GiftCardRedeem_amt = trim(string_decrypt($_REQUEST['GiftCardRedeem_amt'], $key, $iv));
                                            $GiftRedeem = preg_replace("/[^(\x20-\x7f)]*/s", "", $GiftCardRedeem_amt);									
            //echo "the GiftCardID id --".$GiftCardID."<br>";
            //echo "the GiftRedeem id --".$GiftRedeem."<br>";
		
                                            $gift_query14 = "Select Gift_card_balance from lsl_gift_card_tbl where Gift_card_number='$GiftCardID' and Company_id='$Company_id'";
			//echo "the gift_query14 id --".$gift_query14."<br>";
                                            $gift_query73 = mysqli_query($conn,$gift_query14);
                                            while($gift_res73 = mysqli_fetch_array($gift_query73))
                                            {
                                                $Gift_card_currbalance = $gift_res73['Gift_card_balance'];
                                            }
									
           // echo "the Gift_card_currbalance id --".$Gift_card_currbalance."<br>";
		
                                            if($Gift_card_currbalance < $GiftRedeem)
                                            {
                                                echo json_encode(array("status" => "2069", "status_message" => "Invalid Gift Card Or No Balance In Gift Card"));
                                                exit;
                                            }

                                            if($Bal_to_pay < $GiftRedeem)
                                            {
                                                echo json_encode(array("status" => "2066", "status_message" => "Please Check Redeem Amount"));
                                                exit;
                                            }

                                            $GiftBalToPay = $Bal_to_pay - $GiftRedeem;
											
                                            $Bal_to_pay = $GiftBalToPay;
                                        }
									
                                        $BalToPay = $Bal_to_pay;
										 
										$Amount_collected = $_REQUEST['Amount_collected'];
										$Return_amount = 0;
										
										if($Amount_collected == 0 && ($PaymentBy == 1 || $PaymentBy == 9) )
										{
											 echo json_encode(array("status" => "2084", "status_message" => "Transaction Failed, Invalid Amount Collected from Customer!"));
                                             exit;
										}
										
										if($Amount_collected >= $BalToPay)
										{
											$Return_amount = $Amount_collected - $BalToPay;
										}
										else if($Amount_collected > 0 )
										{
											 echo json_encode(array("status" => "2084", "status_message" => "Transaction Failed, Invalid Amount Collected from Customer!"));
                                             exit;
										}
									
										
              // echo "<br>---BalToPay--".$BalToPay ."---<br>";							
                                        $step2 = 1;
															
            //********* gift card purchase *****************************/
                                            if($_REQUEST["GiftCardPurchase_Flag"] == 1)
                                            {
												$lv_query72 = "DELETE FROM lsl_gift_card_tbl WHERE where Active_flag='0' and Purchase_amt='0' and Company_id=$Company_id";
                                                $lv_results71 = mysqli_query($conn,$lv_query72);
												
                                               
                                                foreach($GiftCardArray as $lv_giftcardId)
                                                {
                                                    $lv_query2 = "SELECT Id FROM lsl_gift_card_tbl WHERE Gift_card_number='".$lv_giftcardId."' and Company_id=".$Company_id;
                                                    $lv_results1 = mysqli_query($conn,$lv_query2);

                                                    if(mysqli_num_rows(@$lv_results1)>0) // not available
                                                    {
                                                        echo json_encode(array("status" => "2072", "status_message" => "Gift Card Already Exist"));
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $lv_query1 = "Insert into lsl_gift_card_tbl(Gift_card_number,Company_id,Active_flag,Login_enroll_id,Member_enroll_id) values('$lv_giftcardId','$Company_id','0','$login_enroll_id','$lv_member_enrollid')";
                                                        mysqli_query($conn,$lv_query1);
                                                    }
                                                }

                                                $gift_query77 = mysqli_query($conn,"Select * from lsl_gift_card_tbl where Active_flag='0' and Gift_card_balance='0' and Company_id=$Company_id");

                                                while($drip = mysqli_fetch_array($gift_query77))
                                                {
                                                    $GiftCardNo[] = $drip['Gift_card_number'];
                                                }
                                //echo "<br>----gift card arraay is--<br>"; print_r($GiftCardNo);
                                            }
            //********* gift card purchase *****************************/
		
                                    }
                                }
                            }
                        }
				
                        /**************************** Loyalty Transaction Start *********************************/				
                        if( $step2 == 1 && ($_REQUEST['Transaction_flag'] == 1 || $_REQUEST['Transaction_flag'] == 3) )
                        {
            // echo "--<br>--222222222222---step2--".$step2 ."---<br>";	
                            if( count($items_ID) > 0 && $total_amt > 0 )
                            {
                                $myquery1 = "Select * from lsl_campaign_master as cmp where cmp.Company_id=$Company_id AND
                                        cmp.Campaign_type='29' AND cmp.Loyalty_programme_id = $member_lp_id AND cmp.Active_flag='1' AND cmp.To_date >= '".$todays."' ";

                                $myquery1_exe = mysqli_query($conn,$myquery1);
                                while($myres1 = mysqli_fetch_array($myquery1_exe))
                                {
                                    if(($todays >= $myres1['From_date']) && ($todays <= $myres1['To_date']))
                                    {					
                                            $campaignID[] = $myres1['Campaign_id'];		
                                    }	
                                }
                                //print_r($campaignID)."<br>"; //die;
                                $allow_transaction = 0;
                                $total_loyalty_points = 0;
						
                                foreach($campaignID as $cmp_id)
                                {							
                                    $campagin_loyalty_points = 0;
							
                                    $cmp_info = lslDB::getInstance()->get_campaign_details($cmp_id);
                                    while($cmp_res = mysqli_fetch_array($cmp_info))
                                    {
                                        $Loyalty_programme_id = $cmp_res['Loyalty_programme_id'];
										$cmp_Branch_code = $cmp_res['Branch_code'];
                                        $cmp_name = $cmp_res['Campaign_name'];
                                        $cmp_type = $cmp_res['Campaign_type'];
                                        $cmp_sub_type = $cmp_res['Campaign_sub_type'];
                                        $cmp_Tier_flag  = $cmp_res['Tier_flag'];
                                        $cmp_Tier_id = $cmp_res['Tier_id'];
                                        $cmp_Sweepstake_flag = $cmp_res['Sweepstake_flag'];
                                        $Sweepstake_id = $cmp_res['Sweepstake_id'];
                                        $Sweepstake_ticket_limit = $cmp_res['Sweepstake_ticket_limit'];
                                        $Reward_once_flag = $cmp_res['Reward_once_flag'];
                                        $Transaction_amt_flag = $cmp_res['Transaction_amt_flag'];
                                        $cmp_Reward_flag  = $cmp_res['Reward_flag'];
                                        $Reward_fix_amt_flag  = $cmp_res['Reward_fix_amt_flag'];
                                        $customer_budget = $cmp_res['Max_reward_budget_cust'];
										
										$Recuring_Shedule = $cmp_res['Recuring_campaign_flag']; //echo "Recurring Schedule---->".$Recuring_Shedule."<br>";
										$cmp_start_date = $cmp_res['From_date']; //echo "Campaign ID---->".$cmp_id."<br>";
										$cmp_end_date = $cmp_res['To_date'];
                                    }
							
              // echo "--------------********-------the running campaign is-----".$cmp_name ."<br>";
									
									
										
	//********* branch and schedule change for bonus campaign ************************

										if($cmp_sub_type == 113 && ($cmp_Branch_code != $branchecode && $cmp_Branch_code != '0'))
										{
											//echo "---continue transaction -----4 <br><br>";
											//$member_lp_id = "";
											$allow_transaction = 0;
											
											continue;
										}
									
										if($Recuring_Shedule > 0 && $cmp_sub_type == 113 && ($cmp_Branch_code == $branchecode || $cmp_Branch_code == '0'))
										{
											$lv_timezonequery="select Timezone from lsl_company_master where Company_id=".$Company_id."";
											$mv_result_timezonequery = mysqli_query($conn,$lv_timezonequery);			
											$mv_row_timezonequery=mysqli_fetch_assoc($mv_result_timezonequery);
											$mv_date=date("Y-m-d");
											$timezone = new DateTimeZone($mv_row_timezonequery["Timezone"]);
											$date = new DateTime();
											$date->setTimezone($timezone );
											$time=$date->format('H:i:s');
											$mv_datetime = $mv_date.' '.$time;
											
											//echo "curr time is----> ".$time."<br>";
											
											//echo "SSSSSSSSS--the running periodic campaign is--".$cmp_name."---SSSSSSSSSSS<br>";
											
											$periodic_shedule_check = 0;
											$cmp_month_array = array();
											$cmp_week_array = array();
											$cmp_day_array = array();
											$cmp_day_array_val = array();
											
											$myquery57 = "Select * from lsl_campaign_schedule where Campaign_id=".$cmp_id;
											$run_myquery57 = mysqli_query($conn,$myquery57);
											//$run_myquery57 = $this->query($myquery57);
											
											while($row_myquery57 = mysqli_fetch_array($run_myquery57))
											{
												$cmp_month_array[] = $row_myquery57['Jan'];
												$cmp_month_array[] = $row_myquery57['Feb'];
												$cmp_month_array[] = $row_myquery57['Mar'];
												$cmp_month_array[] = $row_myquery57['Apr'];
												$cmp_month_array[] = $row_myquery57['May'];
												$cmp_month_array[] = $row_myquery57['Jun'];
												$cmp_month_array[] = $row_myquery57['Jul'];
												$cmp_month_array[] = $row_myquery57['Aug'];
												$cmp_month_array[] = $row_myquery57['Sep'];
												$cmp_month_array[] = $row_myquery57['Oct'];
												$cmp_month_array[] = $row_myquery57['Nov'];
												$cmp_month_array[] = $row_myquery57['Dece'];
												
												$cmp_week_array[] = $row_myquery57['First_week'];
												$cmp_week_array[] = $row_myquery57['Second_week'];
												$cmp_week_array[] = $row_myquery57['Third_week'];
												$cmp_week_array[] = $row_myquery57['Fourth_week'];
												$cmp_week_array[] = $row_myquery57['Fifth_week'];
												
												$cmp_day_array_val[] = $row_myquery57['Mon'];
												$cmp_day_array_val[] = $row_myquery57['Tue'];
												$cmp_day_array_val[] = $row_myquery57['Wed'];
												$cmp_day_array_val[] = $row_myquery57['Thu'];
												$cmp_day_array_val[] = $row_myquery57['Fri'];
												$cmp_day_array_val[] = $row_myquery57['Sat'];
												$cmp_day_array_val[] = $row_myquery57['Sun'];
												
												$cmp_start_time = $row_myquery57['Start_time'];
												$cmp_end_time = $row_myquery57['End_time'];
												
												if($row_myquery57['Mon'] == 1)
												{
													$cmp_day_array[] = "Mon";
												}
												if ($row_myquery57['Tue'] == 1)
												{
													$cmp_day_array[] = "Tue";
												}
												if ($row_myquery57['Wed'] == 1)
												{
													$cmp_day_array[] = "Wed";
												}
												if ($row_myquery57['Thu'] == 1)
												{
													$cmp_day_array[] = "Thu";
												}
												if ($row_myquery57['Fri'] == 1)
												{
													$cmp_day_array[] = "Fri";
												}
												if ($row_myquery57['Sat'] == 1)
												{
													$cmp_day_array[] = "Sat";
												}
												if ($row_myquery57['Sun'] == 1)
												{
													$cmp_day_array[] = "Sun";
												}

											}
										
											$todays = date("Y-m-d");		//echo "date is---->".$todays."<br>";
											$todays_month = date("m");		//echo "month in number----> ".$todays_month."<br>";
											$todays_month_char = date("M");		//echo "month in char----> ".$todays_month_char."<br>";
											$todays_day = date("D");		//echo "day is----> ".$todays_day."<br>";
											$todays_numeric_day = date("d");	//	echo "day number is----> ".$todays_numeric_day."<br>";
											$todays_year = date("Y");		//echo "year is----> ".$todays_year."<br>";
											$month_last_week = weeks($todays_month,$year); //echo "month_last_week is----> ".$month_last_week."<br>";
											$periodic_shedule_check = 0;
											
												$date = date("Y-m-d");
												// parse about any English textual datetime description into a Unix timestamp
												$ts = strtotime($date);
												
												$year = date('o', $ts);
												$week = date('W', $ts);
												
													$ts = strtotime($year.'W'.$week.'7');
													$last_dayof_week = date("d", $ts);
													//echo "<br>the last day of week----".$last_dayof_week."<br>";
															
												if($last_dayof_week <=	7)
												{
													$todays_week = 1;
												}
												else if($last_dayof_week > 7 && $last_dayof_week <= 14)
												{
													$todays_week = 2;
												}
												else if($last_dayof_week > 14 && $last_dayof_week <= 21)
												{
													$todays_week = 3;
												}
												else if($last_dayof_week > 21 && $last_dayof_week <= 28)
												{
													$todays_week = 4;
												}
												else
												{
													$todays_week = 5;
												}
												
											////echo "month array ----"; print_r($cmp_month_array)."---rrr---";
											//echo "find the year--".$year. " and the current week kkkk---".$todays_week."<br>";

											if(in_array(1,$cmp_month_array))  //****** if month is set
											{
												for($l=0;$l<12;$l++)
												{
													if($cmp_month_array[$l] == 1)
													{
														$k = $l+1;
														$lv_months[] = $k;
													}
												}
												//print_r($lv_months)."---rrr---";
												//echo "the current month is--".$todays_month."<br>";
												if(in_array($todays_month,$lv_months))
												{
													if(count($lv_months) == 1)
													{
													//$lv_start_date = $year."-".$week."-1";
													$lv_start_date = $cmp_start_date;
													$lv_recuring = 1;
													}
													else if(count($lv_months) > 1 )
													{
														//$lv_start_date = $year."-".$todays_month."-1";
														
														$cmp_query10 = "Select * from lsl_campaign_validity where Campaign_id=$cmp_id and Company_id=".$Company_id;
														$exec_query10 = mysqli_query($conn,$cmp_query10);
														while($row10 = mysqli_fetch_array($exec_query10))
														{
															$lv_start_date = $row10['From_date'];
															$lv_recuring = $row10['Recuring_count'] + 1;
														}
													
													}
													////echo "the lv_start_date is--".$lv_start_date."<br>";
													if($todays_month_char == "Jan")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($todays_month_char == "Feb")
													{
														$lv_end_date = $year."-".$todays_month."-28";
													}
													if($todays_month_char == "Mar")
													{
														$lv_end_date = $year."-".$todays_month."-30";
													}
													if($todays_month_char == "Apr")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($todays_month_char == "May")
													{
														$lv_end_date = $year."-".$todays_month."-30";
													}
													if($todays_month_char == "Jun")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($todays_month_char == "Jul")
													{
														$lv_end_date = $year."-".$todays_month."-30";
													}
													if($todays_month_char == "Aug")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($todays_month_char == "Sep")
													{
														$lv_end_date = $year."-".$todays_month."-30";
													}
													if($todays_month_char == "Oct")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($todays_month_char == "Nov")
													{
														$lv_end_date = $year."-".$todays_month."-30";
													}
													if($todays_month_char == "Dece")
													{
														$lv_end_date = $year."-".$todays_month."-31";
													}
													if($cmp_end_date < $lv_end_date)
													{
														$lv_end_date = $cmp_end_date;
													}
													$periodic_shedule_check = 1;
													
													echo "the lv_end_date is when the scedule is monthly--".$lv_end_date."<br>";
												}
												else
												{
													$periodic_shedule_check = 0;
												}
												
												echo "Periodic Schedule Check at end of month----> ".$periodic_shedule_check."<br>";
											}

											if(in_array(1,$cmp_week_array)) //****** if week is set
											{
												for($l=0;$l<5;$l++)
												{
													if($cmp_week_array[$l] == 1)
													{
														$lv_month_week[] = $l+1;
													}
												}
												//echo "the  week criteria----"; print_r($lv_month_week);
												//echo "the  todays week is----".$todays_week;
												
												if(in_array($todays_week,$lv_month_week))
												{
													$date = date("Y-m-d");
													$ts = strtotime($date);
										
													$year = date('o', $ts);
													$week = date('W', $ts);
													// print week for the current date
													$ts = strtotime($year.'W'.$week.'1');
													
													$first_dayof_week = date("d", $ts);
													////echo "<br>the first day of week".$first_dayof_week."<br>";
													$ts = strtotime($year.'W'.$week.'7');
													$last_dayof_week = date("d", $ts);
													////echo "<br>the last day of week".$last_dayof_week."<br>";
													
											
													//$lv_start_date = $year."-".$week."-".$first_dayof_week;
													$lv_start_date = $cmp_start_date;
													$lv_end_date = $year."-".$todays_month."-".$last_dayof_week;
													//$lv_end_date = $year."-".$todays_month."-30";
													
													if(count($lv_month_week) == 1)
													{
													//$lv_start_date = $year."-".$week."-1";
													$lv_start_date = $cmp_start_date;
													$lv_recuring = 1;
													}
													else if(count($lv_month_week) > 1)
													{
														//$lv_start_date = $year."-".$week."-".$first_dayof_week;
														$cmp_query10 = "Select * from lsl_campaign_validity where Campaign_id=$cmp_id and Company_id=".$Company_id;
														$exec_query10 = mysqli_query($conn,$cmp_query10);
														while($row10 = mysqli_fetch_array($exec_query10))
														{
															$lv_start_date = $row10['From_date'];
															$lv_recuring = $row10['Recuring_count'] + 1;
														}
													
													}
													
													if($cmp_end_date < $lv_end_date)
													{
														$lv_end_date = $cmp_end_date;
													}
													$periodic_shedule_check = 1;
													echo "the lv_end_date is when the scedule is Weekly--".$lv_end_date."<br>";
												} 
												else if($todays_week == $month_last_week)
												{
													echo "in weekly criteria month_last_week is----> ".$month_last_week."<br>";
													
														$date = date("Y-m-d");
													$ts = strtotime($date);
										
													$year = date('o', $ts);
													$week = date('W', $ts);
													// print week for the current date
													$ts = strtotime($year.'W'.$week.'1');
													
													$first_dayof_week = date("d", $ts);
													////echo "<br>the first day of week".$first_dayof_week."<br>";
													$ts = strtotime($year.'W'.$week.'7');
													$last_dayof_week = date("d", $ts);
													////echo "<br>the last day of week".$last_dayof_week."<br>";
													
											
													//$lv_start_date = $year."-".$week."-".$first_dayof_week;
													$lv_start_date = $cmp_start_date;
													$lv_end_date = $year."-".$todays_month."-".$last_dayof_week;
													//$lv_end_date = $year."-".$todays_month."-30";
													
													if(count($lv_month_week) == 1)
													{
													//$lv_start_date = $year."-".$week."-1";
													$lv_start_date = $cmp_start_date;
													$lv_recuring = 1;
													}
													else if(count($lv_month_week) > 1)
													{
														//$lv_start_date = $year."-".$week."-".$first_dayof_week;
														$cmp_query10 = "Select * from lsl_campaign_validity where Campaign_id=$cmp_id and Company_id=".$Company_id;
														$exec_query10 = mysqli_query($conn,$cmp_query10);
														while($row10 = mysqli_fetch_array($exec_query10))
														{
															$lv_start_date = $row10['From_date'];
															$lv_recuring = $row10['Recuring_count'] + 1;
														}
													
													}
													
													if($cmp_end_date < $lv_end_date)
													{
														$lv_end_date = $cmp_end_date;
													}
													$periodic_shedule_check = 1;
													echo "the lv_end_date is when the scedule is Weekly--".$lv_end_date."<br>";
												}	
												else
												{
													$periodic_shedule_check = 0;
												}
											}	
											
											$time_of_trans_check = 1;
											
											if(in_array(1,$cmp_day_array_val)) //****** if day is set
											{
												if(in_array($todays_day,$cmp_day_array))
												{
													/*echo "------****---cmp_start_time is ".$cmp_start_time."<br>";
													echo "------****---cmp_end_time is ".$cmp_end_time."<br>";
													echo "------****---time is ".$time."<br>";
													*/
												
													$periodic_shedule_check = 1;
															////echo "periodic_shedule_check-----".$periodic_shedule_check."<br>";
													
														$date = date("Y-m-d");
														$ts = strtotime($date);
											
														$year = date('o', $ts);
														$week = date('W', $ts);
														// print week for the current date
														$ts = strtotime($year.'W'.$week.'1');
														
														$first_dayof_week = date("d", $ts);
														////echo "<br>the first day of week".$first_dayof_week."<br>";
														$ts = strtotime($year.'W'.$week.'7');
														$last_dayof_week = date("d", $ts);
														////echo "<br>the last day of week".$last_dayof_week."<br>";
														
												
														//$lv_start_date = $year."-".$week."-".$first_dayof_week;
														//$lv_start_date = $cmp_start_date;
														$lv_end_date = date("Y-m-d");
														//$lv_end_date = "2014-11-30";
														
														if($cmp_end_date < $lv_end_date)
														{
															$lv_end_date = $cmp_end_date;
														}
													if(count($cmp_day_array) == 1)
													{
													//$lv_start_date = $year."-".$week."-1";
													$lv_start_date = $cmp_start_date;
													$lv_recuring = 1;
													}
													else if(count($cmp_day_array) > 1)
													{
														$cmp_query10 = "Select * from lsl_campaign_validity where Campaign_id=$cmp_id and Company_id=".$Company_id;
														$exec_query10 = mysqli_query($conn,$cmp_query10);
														while($row10 = mysqli_fetch_array($exec_query10))
														{
															$lv_start_date = $row10['From_date'];
															$lv_recuring = $row10['Recuring_count'] + 1;
														}
														
													}
													
												}
												else
												{	
													$periodic_shedule_check = 0;
												}
												$time_of_trans_check = 0;
												$time_of_trans = date('H:i:s',strtotime($trans_date));

													if($cmp_start_time == "00:00:00" || $cmp_end_time == "00:00:00")
													{
														$time_of_trans_check = 1;	
													}
													else if($time_of_trans >= $cmp_start_time && $time_of_trans <= $cmp_end_time)
													{
														$time_of_trans_check = 1;	
													}
												
													
												//	echo "tttttttttt--ttt---time_of_trans_check-----".$time_of_trans_check."<br>";
													
											}
										

											
											$lv_start_date = date("Y-m-d",strtotime($lv_start_date));
											$lv_end_date = date("Y-m-d",strtotime($lv_end_date));
											$lv_end_date1 = date("Y-m-d",strtotime($lv_end_date. '+1 days'));
											$today_date = date("Y-m-d");

												if($periodic_shedule_check == 0 || $time_of_trans_check == 0)
												{
													//echo "---continue transaction -----5 <br><br>";
													//$member_lp_id = "";
													$allow_transaction = 0;
													continue;
												}
										
										}
					
					
	//********* branch and schedule change for bonus campaign ************************				
					
                                    if($Loyalty_programme_id == $member_lp_id)
                                    {
                                        //echo "------the cmp_Tier_id is-----".$cmp_Tier_id ."--<br>";
                                        //echo "----- member_tier_id is-----".$member_tier_id ."<br>";
							
                                        $allow_transaction = lslDB::getInstance()->cmp_basic_transaction_validation($cmp_id,$CompTransaction_type,$transaction_channel);
								
                                        if($cmp_Tier_flag == 1 && $allow_transaction == 1) //********* member tier validation ********
                                        {
                                            if($cmp_Tier_id == $member_tier_id)
                                            {
                                                $allow_transaction = 1;
                                            }
                                            else
                                            {
                                                $allow_transaction = 0;
                                            }
                                        }

                                        if($Reward_once_flag == 1 && $allow_transaction == 1)   //************ Reward once flag check ************
                                        {
                                            $allow_transaction =lslDB::getInstance()->cmp_reward_once_validation($cmp_id,$Company_id,$lv_member_enrollid);
                                        }
                                    }
							
                                    //echo "<br>after lp test allow transaction ----".$allow_transaction ."--<br>";
							
                                    if($allow_transaction == 1)		 
                                    {
										$total_member_points = 0;
										
									 if($cmp_sub_type == 112)  //***** check fixed budget **********
										{
											$myquery51 ="Select sum(Reward_points) from lsl_transaction_child where Campaign_id='".$cmp_id."' AND Enrollment_id='".$lv_member_enrollid."' AND Company_id=".$Company_id;
			//echo "<br>customer budget query query-----".$myquery51."<br>";
												$myres51 = mysqli_query($conn,$myquery51);
												
												while($myrow51 = mysqli_fetch_array($myres51))
												{
													$total_member_points = $myrow51['sum(Reward_points)'];
												}
												
				//echo "<br>customer total_member_points-----".$total_member_points."<br>";	
										}
										
                                        $i = 0;
                                        $Item_loyalty_points = array();
									
                                        foreach($items_ID as $itemCode)
                                        {
                                            $itemCode =  $items_ID[$i];
                                            $itemQty =  $item_qty[$i];

                                            if($flag_h == 3)
                                            {
                                                if(isset($items_ID[0]))
                                                {
                                                    $ItemTransaction_amount = $BalToPay;
                                                }
                                                else
                                                {
                                                    $ItemTransaction_amount = 0;
                                                }
                                            }
                                            else
                                            {
                                                //$ItemTransaction_amount = $item_price[$i];
                                                $Item_Amount = $item_price[$i];
                                                $percentA = ($Item_Amount * 100)/$total_amt;
                                                $ItemTransaction_amount = ($BalToPay / 100)* $percentA;                                            }

                                                //echo "rrrrrrr ItemTransaction_amount ----".$ItemTransaction_amount ."<br>";
                                                $allow_product_transaction = lslDB::getInstance()->cmp_basic_product_validation($cmp_id,$itemCode);
										
                //echo "allow product_transaction ----".$allow_product_transaction ."<br>";
                                                $lv_transaction_points = 0;
                                                $lv_fixedamt_points = 0;
                                                $loyalty_points = 0;
                                                
                                                if($allow_product_transaction == 1)
                                                {
												
									 //echo "---lv_transaction amt cmp_id--".$cmp_id." -- <br>";
									 //echo "---lv_itemCode--".$itemCode." -- <br>";
									 //echo "---ItemTransaction_amount--".$ItemTransaction_amount." -- <br>";
									 //echo "---exchange_rate--".$exchange_rate." -- <br>";
									 
                                                    if($Transaction_amt_flag == 1) //************ get loyalty points on transaction amount ************
                                                    {
                                                        $lv_transaction_points = lslDB::getInstance()->cmp_transactionamt_criteria($cmp_id,$itemCode,$ItemTransaction_amount,$Company_id,$exchange_rate);
                                                    }
										
                                  // echo "lv_transaction amt points--".$lv_transaction_points." -- <br>";
										//exit;
                                                    if($Reward_fix_amt_flag == 1) //************ get loyalty points on fixed amount ************
                                                    {
                                                        $lv_fixedamt_points = lslDB::getInstance()->cmp_fixedamt_criteria($cmp_id,$itemCode,$ItemTransaction_amount,$Company_id,$exchange_rate);
                                                    }

                                                    //$loyalty_points = $lv_fixedamt_points;
                                                    $loyalty_points = $lv_fixedamt_points + $lv_transaction_points;
                                                    $lv_fixedbudget_points = 0;

                                                    if($cmp_sub_type == 112)  //***** check fixed budget **********
                                                    {
						
                                                        ////echo "*//*/** cmp_sub_type on----".$cmp_sub_type;
                                                        $lv_fixedbudget_points = lslDB::getInstance()->cmp_fixedbudget_criteria($cmp_id,$lv_member_enrollid,$Company_id);		
                                                    }

                                                    if($lv_fixedbudget_points == 0)
                                                    {
                                                        $loyalty_points = $loyalty_points;
                                                    }
                                                    else if($lv_fixedbudget_points == 1)
                                                    {
                                                       $calculate_points = intval($loyalty_points + $total_member_points);
													$calculate_points_new = intval($customer_budget-$total_member_points);
													
								//	echo "<br> customer_budget--loyalty_points---".$loyalty_points."<br>";
								//	echo "<br> calculate_points-----".$calculate_points."<br>";			
								//	echo "<br> customer_budget-----".$customer_budget."<br>";
								
														if($loyalty_points >= $calculate_points_new)
														{
															$loyalty_points = $calculate_points_new;
														}
														else
														{
															$loyalty_points = $loyalty_points;
														}
                                                    }
                                                    else if($lv_fixedbudget_points == 2)
                                                    {	
                                                        $loyalty_points = 0;
                                                    }	
										
                                                    if($loyalty_points > 0 && $cmp_Sweepstake_flag == 1)  //**** sweepstake entry **
                                                    {
                                                        $allow_sweep_ticket = lslDB::getInstance()->cmp_sweepstake_validation($cmp_id,$Sweepstake_id,$Company_id,$lv_member_enrollid,$todays,$Sweepstake_ticket_limit,$mv_create_user_id,$mv_create_date);
                                                    }
								
                                                    if($cmp_sub_type == 114)  // ***** cash back campaign ****
                                                    {
                                                        $item_info = lslDB::getInstance()->get_branch_item_details($itemCode,$branchecode,$Company_id);
                                                        while($res3 = mysqli_fetch_array($item_info))
                                                        {
                                                            $Item_branch_code =$res3['Branch_code'];
                                                            $Item_name = $res3['Item_name'];			
                                                            $Item_group_code = $res3['Product_group_code']; 	
                                                            $Item_brand_code = $res3['Product_brand_code'];
                                                            $Item_priceB = $res3['Item_price'];
                                                        }
												
                                                        $Product_cost = $ItemTransaction_amount;
                                                        
                                                        if($lv_transaction_points > 0)
                                                        {
                                                            $myquery50 = "Insert into lsl_cashback_transaction(Campaign_id,Campaign_name,Customer_name,Membership_id,Account_no,Enrollment_id,
                                                                                Transaction_amount,Cashback_amount,Company_id,Branch_code,Transaction_date)
                                                                                values('".$cmp_id."','".$cmp_name."','".$lv_member_name."','".$Membership_ID."','".$lv_member_Account_no."',
                                                                                                '".$lv_member_enrollid."','".$Product_cost."','".$lv_transaction_points."','".$Company_id."','".$branchecode."','".$trans_date."') ";

                                                            //echo "<br>the insert into lsl_cashback_transaction query----".$myquery50."---<br>";	
                                                            $run_query50 = mysqli_query($conn,$myquery50);
                                                            $loyalty_points = 0;
                                                        }
                                                    }
                                                }
									
                                           // echo "member rrrrrrr---->>>---cmp id--->".$cmp_id."---loyalty_points on item---->".$itemCode." ----itemQty-->".$itemQty."-->".$loyalty_points ."----<br>";
                                            $campagin_loyalty_points = $campagin_loyalty_points + $loyalty_points;
                                           

                                            $i++;
                                            $sku_lv_points_keys = array_keys($sku_lv_points);

                                            if(in_array($itemCode,$sku_lv_points_keys))
                                            {
                                                $sku_lv_points[$itemCode] = $sku_lv_points[$itemCode] + $loyalty_points;
                                            }
                                            else
                                            {
                                                $sku_lv_points[$itemCode] = $loyalty_points;
                                            }
											
											$total_member_points = $total_member_points + $loyalty_points;
                                        }
								
                                        if($campagin_loyalty_points > 0)
                                        {
                                            $myquery52 = "Insert into lsl_transaction_child(Enrollment_id,Transaction_id,Campaign_id,Campaign_type,Campaign_sub_type,Reward_points,Company_id,Date)
                                                            values('".$lv_member_enrollid."','0','".$cmp_id."','".$cmp_type."','".$cmp_sub_type."','".$campagin_loyalty_points."','".$Company_id."','".$todays."')";
                                            $run_query = mysqli_query($conn,$myquery52);
                                        }
									
                                        $total_loyalty_points = round($total_loyalty_points + $campagin_loyalty_points);
                                    }
                                }
						
                                $i = 0;
                                $sp = 0;
                                for($i = 0;$i <= count($items_ID); $i++)
                                {
                                    $itemCode =  $items_ID[$i];
                                    $itemQty =  $item_qty[$i];
                                    $itemPrice = $item_price[$i];
                                    $itemVat = $item_vat[$i];
                                    $lv_points = $sku_lv_points[$itemCode];

                                    if($itemCode != "" && $itemQty > 0)
                                    {
                                        //**** Item details ****
                                        $item_info = lslDB::getInstance()->get_branch_item_details($itemCode,$branchecode,$Company_id);
                                        while($res3 = mysqli_fetch_array($item_info))
                                        {
                                            $Item_branch_code =$res3['Branch_code'];
                                            $Item_name = $res3['Item_name'];			
                                            $Item_group_code = $res3['Product_group_code']; 	
                                            $Item_brand_code = $res3['Product_brand_code'];
                                            $Item_priceB = $res3['Item_price'];
                                            $Item_vatB = $res3['Item_vat'];
                                            $Item_current_bal = $res3['Current_balance'];
                                            $Item_threshold_balance = $res3['Threshold_balance'];
                                            $Gift_flag = $res3['Gift_flag'];
                                        }
								
                  //echo "Item_group_code is---".$Item_group_code."<br>";
										//echo "Item_current_bal is---".$Item_current_bal."<br>";
                                        //echo "itemQty is---".$itemQty."<br>";
              // echo "Item lv_points is---".$lv_points."<br>"; 	
			
                                        $transaction_done = 0;								
                                        $mdquery = "Select a.Points_award_item_flag from lsl_pos_inventory_master as a,lsl_branch_pos_inventory_master as b where a.Company_id = b.Company_id and a.Item_code = b.Item_code and b.Item_code='".$itemCode."' and b.Company_id=$Company_id";
					$mdres = mysqli_query($conn,$mdquery);
								
                                        while($mdrow = mysqli_fetch_array($mdres))
                                        {
                                            $Points_award_item_flag = $mdrow['Points_award_item_flag'];
                                        }
                                        //echo "trtrtrPoints_award_item_flag is---".$Points_award_item_flag."<br>";
								
                                        if($Points_award_item_flag == 2)
                                        {
                                            $Item_vatB = 0;
                                        }
								
                                        if($Item_current_bal >= $itemQty)
                                        {
                                            $TransactionAmt = floatval($itemPrice) + floatval($itemVat);
									
                                            if($Gift_flag == 1)
                                            {	
                                                if(count($GiftCardNo) >= $itemQty)
                                                {
                                                    $itemQty12 = 1;
                                                    $disc_amt = ($Item_priceB/100) * $discount;
                                                    $TransactionVat = ($Item_priceB/100) * $Item_vatB;
                                                    $TransactionAmt = ($TransactionVat + $Item_priceB ) - $disc_amt;

                                                    for($x=0;$x < $itemQty; $x++)
                                                    {
                                                        $gift_query = mysqli_query($conn,"Update lsl_gift_card_tbl set Gift_card_balance='".$Item_priceB."',Purchase_amt='".$TransactionAmt."',Member_enroll_id='".$lv_member_enrollid."',Active_flag='1',Bill_no='".$BillNo."' where Active_flag='0' and Gift_card_number='".$GiftCardNo[$x]."' and Company_id=".$Company_id);

                                                        $insert_transaction_id = lslDB::getInstance()->insert_loyalty_transaction_details($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$lv_member_enrollid,$Membership_ID,
                                                                $login_enroll_id,$user_email_id,$trans_date,$GiftCardNo[$x],$GiftRedeem,$BranchPin,$Item_group_code,$Item_brand_code,$itemCode,$itemQty12,$Item_vatB,$TransactionAmt,$Item_priceB,
                                                                $RedeemPoints,$RedeemAmt,$bonus_points,$lv_points,$TransactionAmt,$PaymentBy,$branchecode,$BillNo,$source,$Voucher,$Cheque,$BankName,$Remark,$EmployeeID,$MemberPin,$mv_create_user_id,$mv_create_date);

                                                        $sp++;
                                                    }
                                                    $transaction_done = 1;
                                                }
                                                else
                                                {
                                                    $transaction_done = 0;
                                                    echo json_encode(array("status" => "2078", "status_message" => "Check the number of gift cards"));
                                                    exit;
                                                }
                                            }
                                            else if($Gift_flag == 0)
                                            {
                                                $insert_transaction_id = lslDB::getInstance()->insert_loyalty_transaction_details($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$lv_member_enrollid,$Membership_ID,
                                                            $login_enroll_id,$user_email_id,$trans_date,$GiftCardID,$GiftRedeem,$BranchPin,$Item_group_code,$Item_brand_code,$itemCode,$itemQty,$Item_vatB,$TransactionAmt,$Item_priceB,
                                                            $RedeemPoints,$RedeemAmt,$bonus_points,$lv_points,$TransactionAmt,$PaymentBy,$branchecode,$BillNo,$source,$Voucher,$Cheque,$BankName,$Remark,$EmployeeID,$MemberPin,$mv_create_user_id,$mv_create_date);

                                                $transaction_done = 1;
                                            }
									
                                            $item_balance = $Item_current_bal - $itemQty;

                                            $update_item = lslDB::getInstance()->update_item_quantity($itemCode,$Item_branch_code,$Company_id,$item_balance);

                                            if($item_balance <= $Item_threshold_balance) //**** check threshold balance and send notification*******
                                            {
                                                $sendNotification1 = lslDB::getInstance()->send_threshold_mail($Company_id,$login_enroll_id,$item_balance,$itemCode,$branchecode);
                                            }
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2064", "status_message" => "Item is not available"));
                                            exit;
                                        }								
                                    }
                                }
						
                                if($transaction_done == 1)
                                {				
                                    $insert_transactionID = lslDB::getInstance()->insert_loyalty_transaction_summery($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$lv_member_enrollid,$Membership_ID,$login_enroll_id,$user_email_id,$trans_date,$GiftCardID,$GiftRedeem,$BranchPin,$grand_total,$RedeemPoints,$RedeemAmt,$bonus_points,$total_loyalty_points,$BalToPay,$PaymentBy,$branchecode,$BillNo,$source,$Voucher,$Cheque,$BankName,$Remark,$EmployeeID,$MemberPin,$discountget,$discountamt,$mv_create_user_id,$mv_create_date,$insertFlag);
							
                                    if($lv_parent_enrollid > 0) //***** update family parent balance*****
                                    {
                                        $parent_info = lslDB::getInstance()->get_user_details($lv_parent_enrollid,$member_company_id);
                                        while($res6 = mysqli_fetch_array($parent_info))
                                        {
                                            $user_email_id =$res6['User_email_id'];
                                            $loguserid = $res6['User_type_id'];			
                                            $user_pin = $res6['Pin']; 	
                                            //$branchecode = $res6['Branch_code'];
                                            $mv_member_balance = $res6['Current_balance'];
                                            $mv_purchase_amount = $res6['Total_purchase_amount'];
                                            $mv_bonus_points = $res6['Total_bonus_points'];
                                            $mv_redeem_points = $res6['Total_redeem_points'];
                                            $mv_gained_points = $res6['Total_gained_points'];
                                        }		
                                        $Parent_Member_balance = $mv_member_balance - $RedeemPoints;
                                        $Parent_Member_redeem = $mv_redeem_points;
                                        $Parent_Member_purchase = $mv_purchase_amount;
                                        $Parent_Member_loyalty_points = $mv_gained_points;
                                        $Parent_Member_balance = $Parent_Member_balance + $total_loyalty_points;

                                        $update_memberbal =  lslDB::getInstance()->update_member_balance_details($lv_parent_enrollid,$Parent_Member_balance,$Parent_Member_redeem,$Parent_Member_purchase,$Parent_Member_loyalty_points,$member_company_id);
                                    }

                                    $Member_balance = $lv_member_balance - $RedeemPoints;
                                    $Member_redeem = $lv_redeem_points + $RedeemPoints;
                                    $Member_purchase = $lv_purchase_amount + $grand_total;
                                    $Member_loyalty_points = $lv_gained_points + $total_loyalty_points;
                                    $Member_balance = $Member_balance + $total_loyalty_points;
								
                                    $update_memberbal =  lslDB::getInstance()->update_member_balance_details($lv_member_enrollid,$Member_balance,$Member_redeem,$Member_purchase,$Member_loyalty_points,$member_company_id);
							
                                    $company_balance = $company_current_balance - $total_loyalty_points;
							
                                    $update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance);
							
                                    if($Solution_type == 3)
                                    {
                                        if($Parent_company_id != 0 && ($company_current_balance <= $Company_Threshold_amount) )
                                        {
                                            $Template_type_id = 49;
                                            $Email_type = 294;	

                                            $SQL223 = "SELECT Enrollment_id FROM lsl_enrollment_master 
                                                              WHERE Company_id='".$Parent_company_id."'
                                                              AND Child_company_id='".$Company_id."' 
                                                              AND User_type_id='4' ";
                                            $RESULT223 = mysqli_query($conn,$SQL223);
                                            while($rows223 = mysqli_fetch_array($RESULT223))
                                            {
                                                $sendNotif = lslDB::getInstance()->send_coalition_points_threshold_template($rows223['Enrollment_id'],$Company_id,$Parent_company_id,$company_current_balance,$Company_Threshold_amount,$Email_type,$Template_type_id);
                                            }
                                        }
                                    }
							
                                    if($GiftCardFlag == 1)
                                    {
                                        $GiftRemainBalance =	$Gift_card_currbalance - $GiftRedeem;
                                        $update_gift_bal = lslDB::getInstance()->update_giftcard_details($GiftCardID,$Company_id,$GiftRemainBalance);
                                    }
								
                                    $myquery55 = "Update lsl_transaction_child set Transaction_id='".$insert_transactionID."' where Transaction_id='0' AND Enrollment_id='".$lv_member_enrollid."' and Date='".$todays."' and Company_id=".$Company_id;
                                    $update_child = mysqli_query($conn,$myquery55);
								
                                    $New_Pos_series_no = $BillNo. "-E";
                                    //echo "employee Pos_series_no No. -->" .$New_Pos_series_no."<br>";
						
                                    /*********************Redeem By FIFO LOGIC ******************/		
                                        if($RedeemPoints > 0)
                                        {
                                            $ProgramName = "Loyalty Transaction";
                                            $Fifo_Transactions = lslDB::getInstance()->get_fifo_transactions($member_company_id,$lv_member_enrollid,$RedeemPoints,$insert_transactionID,$BillNo,$mv_create_user_id,$mv_create_date,$ProgramName);
                                        }
                                    /**********************Redeem By FIFO LOGIC ******************/
				
						
                                    //$mailsend = lslDB::getInstance()->send_transaction_mail($Company_id,$login_enroll_id,$GiftCardID,$Transaction_type);
						
                                    /****************Send Email****************/
                                        if($Communication_flag == 1)
                                        {
                                            $Template_type_id = 10;
                                            $Email_Type = 13;  //****Transaction**
                                            $transaction_email_template = lslDB::getInstance()->send_transaction_loyalty_email_template($lv_member_enrollid,$Company_id,$login_enroll_id,$BillNo,$trans_date,$insert_transactionID,$Email_Type,$Template_type_id,$insertFlag);

                                            if($Credit_transaction_sms == 1)
                                            {
                                                $SMS_Type = 13;  //****Transaction**
                                                $transaction_email_template = lslDB::getInstance()->send_transaction_loyalty_sms_template($lv_member_enrollid,$Company_id,$login_enroll_id,$BillNo,$trans_date,$insert_transactionID,$SMS_Type,$Template_type_id);
                                            }
                                        }
                                    /****************Send Email End****************/
						
                                    //**** **********************--log entry--***************************** *****
                                        $lv_user_detail = lslDB::getInstance()->get_user_details($mv_create_user_id,$Company_id);
                                        while($lsl_rows1=mysqli_fetch_array($lv_user_detail))
                                        {
                                            $lv_fname=$lsl_rows1['First_name'];
                                            $lv_mname=$lsl_rows1['Middle_name'];
                                            $lv_lname=$lsl_rows1['Last_name'];
                                            $lv_enrollid = $lsl_rows1['Enrollment_id'];
                                            $lv_userid = $lsl_rows1['User_type_id'];
                                            $lv_emailid = $lsl_rows1['User_email_id'];
                                            $lv_fullname = $lv_fname." ".$lv_mname." ".$lv_lname;
                                        }
						
                                        $mv_opration = 1; 							
                                        if($insertFlag ==1)
                                        {
                                            $mv_TranType = "Points Award Transaction";
                                            $mv_Tranfrom = "Points Award Transaction";
                                        }
                                        else
                                        {
                                            $mv_TranType = $filename;
                                            $mv_Tranfrom = $filename;
                                        }
							
                                        $mv_opval = $grand_total;
							
                                        $InsertLOG=lslDB::getInstance()->getLOG($Company_id,$mv_create_user_id,$lv_emailid,$lv_fullname,$mv_create_date,$mv_TranType,$mv_Tranfrom,$lv_userid,$mv_opration,$lv_member_name,$lv_member_enrollid,$mv_opval);
                                    //**** --log entry-- *****
						
                                    $recipt_billno = $BillNo;			
                                    $str_pos = 0;	
                                    $str_pos12 = strripos($BillNo,"-");
								
                                    if($str_pos12 > 0)
                                    {
                                        $str_pos = $str_pos12 + 1;
                                    }

                                    $str_pos13 = strripos($BillNo,"/");

                                    if($str_pos13 > 0)
                                    {
                                        $str_pos = $str_pos13 + 1;
                                    }

                                    if(is_numeric($BillNo))
                                    {
                                        $New_Pos_series_no47 = $BillNo + 1;
                                    }
                                    else if($str_pos == 0)
                                    {
                                        $BillNo++;
                                        $New_Pos_series_no47 = $BillNo;
                                    }
                                    else 
                                    {
                                        $BillNo45 = substr($BillNo,$str_pos);
                                        $realSting = substr($BillNo,0,$str_pos);
                                        $BillNo12 = $BillNo45 + 1;
                                        $New_Pos_series_no47 = $realSting."".$BillNo12;
                                    }
                                    //echo "next Pos_series_no No.rrrr -->" .$Pos_series_no12."<br>";				
									
                                    $update_bill = lslDB::getInstance()->update_branch_details($branchecode,$Company_id,$New_Pos_series_no47);
							
									$transaction_output = array();
									
									$transaction_output["status"] = '1001';	
									$transaction_output["Membership_ID"] = $Membership_ID;
									$transaction_output["BillNo"] = $BillNo;									
									$transaction_output["Branch_name"] = $Branch_name;
									$transaction_output["Branch_Address"] = $Branch_Address;
									$transaction_output["Transaction_date"] = $trans_date;
									$transaction_output["Total_amount"] = $total_amt;
									$transaction_output["Total_vat"] = $total_vat;
									$transaction_output["Grand_total"] = $grand_total;
									$transaction_output["Total_balance_paid"] = $BalToPay;
									$transaction_output["Loyalty_points"] = $total_loyalty_points;
									$transaction_output["Amount_collected"] = $Amount_collected;
									$transaction_output["Return_amount"] = $Return_amount;
									$transaction_output["Payment_by"] = $Payment_type_name;
									
									$transaction_output["Discounted_amount"] = $discountget;
									$transaction_output["Total_paybal"] = $discountamt;

									$transaction_output["Redeem_points"] = $RedeemPoints;
									$transaction_output["Redeem_amount"] = $RedeemAmt;
									$transaction_output["Current_balance"] = $Member_balance;
									$transaction_output["Blocked_points"] = $Member_Blocked_points;
									
									
									$transaction_output["GiftCardNo"] = $GiftCardID;
									$transaction_output["Gift_redeem"] = $GiftRedeem;
									$transaction_output["GiftCard_Balance"] = $GiftRemainBalance;		
									
								
									$transaction_output["Remarks"] = $Remark;
									$transaction_output["Purchase_item_details"] = $purchase_item_details;								
									$transaction_output["status_message"] = "Success";								
		
									echo json_encode($transaction_output);

						
                                }
                                else
                                {
                                    echo json_encode(array("status" => "2068", "status_message" => "Transaction Failed"));
                                    exit;
                                }
                            }
                        }
                        /**************************** Loyalty Transaction End *********************************/

                        /**************************** Transaction Without Loyalty  *********************************/	
                        if( $step2 == 1 && $_REQUEST['Transaction_flag'] == 2 )
                        {
                            //echo "<br>*** Transaction Without Loyalty  ***** <br>";	
                            $Transaction_type = 9;
					
                            if( count($items_ID) > 0 && $total_amt > 0 && $CompTransaction_type != "")
                            {
								$i = 0;
                                $sp = 0;
                                for($i = 0;$i <= count($items_ID); $i++)
                                {
                                    $itemCode =  $items_ID[$i];
                                    $itemQty =  $item_qty[$i];
                                    $itemPrice = $item_price[$i];
                                    $itemVat = $item_vat[$i];
								
                                    if($itemCode != "" && $itemQty > 0)
                                    {								
                                        /**** Item details ****/
                                        $item_info = lslDB::getInstance()->get_branch_item_details($itemCode,$branchecode,$Company_id);
                                        while($res3 = mysqli_fetch_array($item_info))
                                        {
                                            $Item_branch_code =$res3['Branch_code'];
                                            $Item_name = $res3['Item_name'];			
                                            $Item_group_code = $res3['Product_group_code']; 	
                                            $Item_brand_code = $res3['Product_brand_code'];
                                            $Item_priceB = $res3['Item_price'];
                                            $Item_vatB = $res3['Item_vat'];
                                            $Item_current_bal = $res3['Current_balance'];
                                            $Item_threshold_balance = $res3['Threshold_balance'];
                                            $Gift_flag = $res3['Gift_flag'];
                                        }
						
                                        $transaction_done = 0;
                                        if($Item_current_bal >= $itemQty)
                                        {	
                                            $TransactionAmt = floatval($itemPrice) + floatval($itemVat);									
                                            if($Gift_flag == 1)
                                            {
                                                if(count($GiftCardNo) >= $itemQty)
                                                {
                                                    $itemQty12 = 1;
                                                    $disc_amt = ($Item_priceB/100) * $discount;
                                                    $TransactionVat = ($Item_priceB/100) * $Item_vatB;
                                                    $TransactionAmt = ($TransactionVat + $Item_priceB) - $disc_amt;

                                                    for($x=0;$x < $itemQty; $x++)
                                                    {
                                                        $insertGift = lslDB::getInstance()->update_giftcard($Company_id,$GiftCardNo[$sp],$Item_priceB,$TransactionAmt,$BillNo);
                                                        $insert_transaction = lslDB::getInstance()->insert_pos_transaction_details($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$login_enroll_id,$user_email_id,
                                                        $trans_date,$GiftCardNo[$sp],$BranchPin,$Item_group_code,$Item_brand_code,$itemCode,$itemQty12,$Item_vatB,$TransactionAmt,$Item_priceB,$PaymentBy,
                                                        $branchecode,$BillNo,$VoucherNo,$Cheque,$BankName,$Remark,$EmployeeID,$mv_create_user_id,$mv_create_date);

                                                        $sp++;
                                                    }

                                                    $transaction_done = 1;
                                                }
                                                else
                                                {
                                                    $transaction_done = 0;
                                                    echo json_encode(array("status" => "2068", "status_message" => "Transaction Failed"));
                                                    exit;
                                                }
                                            }
                                            else if($Gift_flag == 0)
                                            {
                                                $insert_transaction = lslDB::getInstance()->insert_pos_transaction_details($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$login_enroll_id,$user_email_id,
                                                            $trans_date,$GiftCardID,$BranchPin,$Item_group_code,$Item_brand_code,$itemCode,$itemQty,$Item_vatB,$TransactionAmt,$Item_priceB,$PaymentBy,
                                                            $branchecode,$BillNo,$VoucherNo,$Cheque,$BankName,$Remark,$EmployeeID,$mv_create_user_id,$mv_create_date);

                                                $transaction_done = 1;
                                            }
								
                                            if($GiftCardFlag == 1)
                                            {			
                                                $GiftRemainBalance =	$Gift_card_currbalance - $GiftRedeem;
                                                $update_gift_bal = lslDB::getInstance()->update_giftcard_details($GiftCardID,$Company_id,$GiftRemainBalance);
                                            }
						
                                            $item_balance = $Item_current_bal - $itemQty;							
                                            $update_item = lslDB::getInstance()->update_item_quantity($itemCode,$Item_branch_code,$Company_id,$item_balance);
								//die;
                                            if($item_balance == $Item_threshold_balance) //**** check threshold balance and send notification*******/
                                            {
                                                $sendNotification1 = lslDB::getInstance()->send_threshold_mail($Company_id,$login_enroll_id,$item_balance,$itemCode,$branchecode);
                                            }			
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2064", "status_message" => "Item is not available"));
                                            exit;
                                        }
                                    }
                                }
							
                                if($transaction_done == 1)
                                {
                                    $insert_final_transaction = lslDB::getInstance()->insert_pos_transaction_summery($Company_id,$Transaction_type,$CompTransaction_type,$transaction_channel,$login_enroll_id,$user_email_id,
                                                                $GiftRedeem,$BalToPay,$grand_total,$trans_date,$GiftCardID,$BranchPin,$PaymentBy,$branchecode,$BillNo,$VoucherNo,$Cheque,$BankName,$Remark,$EmployeeID,$discountget,$discountamt,$mv_create_user_id,$mv_create_date);
                                }
								
                                $receipt_billno = $BillNo;								
                                $str_pos12 = strripos($BillNo,"-");
                                $str_pos = 0;
							
                                if($str_pos12 > 0)
                                {
                                    $str_pos = $str_pos12 + 1;
                                }							
                                $str_pos13 = strripos($BillNo,"/");
							
                                if($str_pos13 > 0)
                                {
                                    $str_pos = $str_pos13 + 1;
                                }
				
                                if(is_numeric($BillNo))
                                {
                                    $Pos_series_no = $BillNo + 1;
                                }
                                else if($str_pos == 0)
                                {
                                    $BillNo++;
                                    $Pos_series_no = $BillNo;
                                }
                                else
                                {
                                    $BillNo45 = substr($BillNo,$str_pos);
                                    $BillNo10 = $BillNo45 + 1;
                                    $realSting = substr($BillNo,0,$str_pos);
                                    $Pos_series_no = $realSting."".$BillNo10;
                                }
							
				$update_bill = lslDB::getInstance()->update_branch_details($branchecode,$Company_id,$Pos_series_no);
				
                                /****************Send Email****************/
                                    $Template_type_id = 36;
                                    $Email_Type = 215;  //****Transaction**
                                    /* $transaction_email_template = lslDB::getInstance()->send_transaction_noloyalty_email_template($login_enroll_id,$Company_id,$login_enroll_id,$BillNo,$trans_date,$insert_transaction,$Email_Type,$Template_type_id); */
                                /****************Send Email End****************/
					
                                /*********************************************--log entry--***************************************** *****/
                                    $lv_user_detail = lslDB::getInstance()->get_user_details($mv_create_user_id,$Company_id);
                                    while($lsl_rows1=mysqli_fetch_array($lv_user_detail))
                                    {
                                        $lv_fname=$lsl_rows1['First_name'];
                                        $lv_mname=$lsl_rows1['Middle_name'];
                                        $lv_lname=$lsl_rows1['Last_name'];
                                        $lv_enrollid = $lsl_rows1['Enrollment_id'];
                                        $lv_userid = $lsl_rows1['User_type_id'];
                                        $lv_emailid = $lsl_rows1['User_email_id'];
                                        $lv_fullname = $lv_fname." ".$lv_mname." ".$lv_lname;
                                    }
							
                                    $mv_opration = 1; 								
                                    $mv_TranType = $filename;
                                    $mv_Tranfrom = $filename;								
                                    $mv_opval = $grand_total;

                                    $InsertLOG=lslDB::getInstance()->getLOG($Company_id,$mv_create_user_id,$lv_emailid,$lv_fullname,$mv_create_date,$mv_TranType,$mv_Tranfrom,$lv_userid,$mv_opration,$lv_member_name,$lv_member_enrollid,$mv_opval);
                                /**** --log entry-- *****/	

								$transaction_output = array();
									
									$transaction_output["status"] = '1001';	
									$transaction_output["Membership_ID"] = $Membership_ID;
									$transaction_output["BillNo"] = $BillNo;									
									$transaction_output["Branch_name"] = $Branch_name;
									$transaction_output["Branch_Address"] = $Branch_Address;
									$transaction_output["Transaction_date"] = $trans_date;
									$transaction_output["Total_amount"] = $total_amt;
									$transaction_output["Total_vat"] = $total_vat;
									$transaction_output["Grand_total"] = $grand_total;
									$transaction_output["Total_balance_paid"] = $BalToPay;
									
									$transaction_output["Amount_collected"] = $Amount_collected;
									$transaction_output["Return_amount"] = $Return_amount;
									$transaction_output["Payment_by"] = $Payment_type_name;
									
									$transaction_output["Discounted_amount"] = $discountget;
									$transaction_output["Total_paybal"] = $discountamt;

									$transaction_output["GiftCardNo"] = $GiftCardID;
									$transaction_output["Gift_redeem"] = $GiftRedeem;
									$transaction_output["GiftCard_Balance"] = $GiftRemainBalance;		
									$transaction_output["Remarks"] = $Remark;
									$transaction_output["Purchase_item_details"] = $purchase_item_details;								
									$transaction_output["status_message"] = "Success";								
		
									echo json_encode($transaction_output);

                                exit;
                            }
                        }
                        /**************************** Transaction Without Loyalty END *********************************/	
                    	
                    }	
            /************************* POS Transactions End *************************/

			/********************* Gift Card Validation **************************/
   
				if($API_flag == 50) 
                {
		//echo "the API_flag id --50---<br>";
					
					if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
					{
						echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
					}
					else
					{
						$Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
						$Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

						$Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
						$Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

						$query1 = "SELECT * FROM lsl_enrollment_master "
										. "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
										. "AND lsl_enrollment_master.Password ='".$Password."' "
										. "AND User_type_id <> 1 "
										. "AND Company_id='".$Company_id."' ";
						$member_details_result = mysqli_query($conn,$query1);
						$member_details = mysqli_fetch_array($member_details_result);

						if($member_details == NULL)
						{
							echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
							exit;
						}
						else
						{
							if($member_details['Active_flag'] == 0)
							{
								echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
							}
							else
							{
								if($_REQUEST['GiftCard_no'] == "")
								{
									echo json_encode(array("status" => "2074", "status_message" => "Please Enter Gift Card No"));
									exit;
								}
								
								$GiftCard_no = trim(string_decrypt($_REQUEST['GiftCard_no'], $key, $iv));
								$GiftCardID = preg_replace("/[^(\x20-\x7f)]*/s", "", $GiftCard_no);																	
			//echo "the GiftCardID id --".$GiftCardID."<br>";

								$gift_query14 = "Select Gift_card_balance from lsl_gift_card_tbl where Gift_card_number='$GiftCardID' and Company_id='$Company_id'";
					//echo "the gift_query14 id --".$gift_query14."<br>";
								$gift_query73 = mysqli_query($conn,$gift_query14);
								while($gift_res73 = mysqli_fetch_array($gift_query73))
								{
									$Gift_card_currbalance = $gift_res73['Gift_card_balance'];
								}
											
								if(mysqli_num_rows($gift_query73)>0)
								{
									

										$return_details3 = array
										(
											"status" => "1001",
											"Gift_card" => $GiftCardID,
                                                                                        "status_message" => "Success",
											"Gift_card_balance" => $Gift_card_currbalance
										);

									echo json_encode($return_details3);
								}
								else
								{
									echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									exit;
								}
							}
						}
					}
				}
				
		/********************* Gift Card Validation **************************/	
		
		/********************* Flat FIle Loyalty Transaction ***********************/
				if($API_flag == 51) 
                {
					if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
					{
						echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
						exit;
					}
					else
					{
						$Username = trim(string_decrypt($_REQUEST['Username'], $key, $iv));
						$Username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Username);

						$Password = trim(string_decrypt($_REQUEST['Password'], $key, $iv));
						$Password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Password);

						$query1 = "SELECT * FROM lsl_enrollment_master "
										. "WHERE lsl_enrollment_master.User_email_id='".$Username."' "
										. "AND lsl_enrollment_master.Password ='".$Password."' "
										. "AND User_type_id <> 1 "
										. "AND Company_id='".$Company_id."' ";
						$member_details_result = mysqli_query($conn,$query1);
						$member_details = mysqli_fetch_array($member_details_result);
					
						if($member_details == NULL)
						{
							echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
							exit;
						}
						else
						{
							if($member_details['Active_flag'] == 0)
							{
								echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
							}
							else
							{
								$get_error = array();
								$get_error_row = array();
								$Source = "FlatFile";
								$mv_create_user_id = $member_details['Enrollment_id'];
								$loggin_user_type = $member_details['User_type_id'];
								$user_email_id = $member_details['User_email_id'];
								
								$myquery23 = lslDB::getInstance()->get_company_details($Company_id);
								$Company_details = mysqli_fetch_array($myquery23);
								
								$Discount_applicable = $Company_details['Discount_applicable'];
								$TransDiscount = $Company_details['Discount'];
								$Discount_from_date = $Company_details['Discount_from_date'];
								$Discount_to_date = $Company_details['Discount_to_date'];
								$lv_Parent_company_id = $Company_details['Parent_company_id'];
								$Cust_pin_validation12 = $Company_details['Cust_pin_validation'];
								$Branch_user_pin_validation12 = $Company_details['Branch_user_pin_validation'];
								$redemptionratio = $Company_details['Points_value_definition'];
								$Solution_type = $Company_details['Solution_type'];
								$company_current_balance = $Company_details['Current_balance'];
								$Company_Threshold_amount = $Company_details['Threshold_amount'];
								$Credit_transaction_sms = $Company_details['Pos_transaction_sms'];
								$Company_type =  $Company_details['Company_type'];
								
								if($Solution_type == 3 && $lv_Parent_company_id > 0)
								{	
									$Company_id = $lv_Parent_company_id;
								}
								else
								{
									$Company_id = $Company_id;
								}
								
									$Branch_code = trim(string_decrypt($_REQUEST['Branch_code'], $key, $iv));
									$branchecode = preg_replace("/[^(\x20-\x7f)]*/s", "", $Branch_code);

									if($_REQUEST['Branch_code'] == "")
									{
										echo json_encode(array("status" => "2071", "status_message" => ""));
										exit;
									}
									
									$branch_info = lslDB::getInstance()->get_branch_details($branchecode,$Company_id);
									while($res2 = mysqli_fetch_array($branch_info))
									{
										$Branch_name =$res2['Branch_name'];
										$Branch_City_id = $res2['City_id'];			
										$Branch_Address = $res2['Address']; 	
										$Pos_series_no = $res2['Pos_series_no'];
									}
									
									if($Branch_user_pin_validation12 == 1)
									{
										$BranchUser_Pin = trim(string_decrypt($_REQUEST['BranchUser_Pin'], $key, $iv));
										$BranchPin = preg_replace("/[^(\x20-\x7f)]*/s", "", $BranchUser_Pin);
										//echo "BranchUser_Pin is ----".$BranchPin."<br>";
										//echo "user_details pin is ----".$user_details['Pin']."<br>";

										if($BranchPin != $member_details['Pin'] )
										{
											echo json_encode(array("status" => "2065", "status_message" => "Invalid Cashier Pin"));
											exit;
										}
									}
									
								$mv_date=date("Y-m-d");
								$timezone = new DateTimeZone($Company_details["Timezone"]);
								$date = new DateTime();
								$date->setTimezone($timezone );
								$lv_time=$date->format('H:i:s');
								$mv_datetime = $mv_date.' '.$lv_time;
								$mv_create_date = $mv_datetime;
								$trans_date = $mv_datetime;
								
								$todayis = date("Y-m-d");	//echo "todayis is ----".$todayis."<br>";
		
								if($todayis >= $Discount_from_date && $todayis <=$Discount_to_date )
								{
									$CompDiscount = $TransDiscount;
								}
								else if($Discount_applicable == 0)
								{
									$CompDiscount = 0;
								}
								
								
								$Transaction_flag = $_REQUEST['Transaction_flag'];
								
								 if($_REQUEST['Transaction_flag'] == "" || $_REQUEST['Transaction_flag'] < 4)
								{
									echo json_encode(array("status" => "2063", "status_message" => "Invalid transaction flag"));
									exit;
								}
									
								if($Transaction_flag == 5) //**** flat file processing
								{
									$Data_mapping = $_REQUEST['Data_mapping_file_name'];
									$start_date11 = $_REQUEST['Upload_transaction_date'];
									$from_date = date("Y-m-d",strtotime($start_date11));
									
									$db_query = "select *  From lsl_flat_transaction_map  where Company_id=".$Company_id." AND File_name = '".$Data_mapping."'";
	
	//	echo " the datamapping query  is --> ".$db_query."<br>";
									
									$query2 =mysqli_query($conn,$db_query);
										
										
										$rec=mysqli_fetch_array($query2);
										
										$trans_date = $rec["Column_no_trans_date"] - 1;		//echo " the Column_no_trans_date  is --> ".$trans_date."<br>";
										$trans_type_code = $rec["Column_no_trans_type_code"] - 1; // echo " the trans_type_code  is --> ".$trans_type_code."<br>";
										$trans_channel_code = $rec["Column_no_trans_channel_code"] - 1;  //echo " the trans_channel_code  is --> ".$trans_channel_code."<br>";
										$product_code=$rec["Column_no_product_code"] - 1;		//echo " the Column_no_sku_code  is --> ".$product_code."<br>";
										$trans_amount=$rec["Column_no_trans_amount"] - 1;		//echo " the trans_amount  is --> ".$trans_amount."<br>";	
										$membership_id =$rec["Column_no_membership_id"] - 1;	//echo " the membership_id Column_no is --> ".$membership_id."<br>";
										$branch_code =$rec["Column_no_branch_code"] - 1;	//echo " the branch_code Column_no is --> ".$branch_code."<br>";
										$quantity=$rec["Column_no_quantity"] - 1;			//echo " the quantity  is --> ".$quantity."<br>";
										$account_no=$rec["Column_no_account_no"] - 1;	//echo " the Column_no_account_no  is --> ".$account_no."<br>";
										$date_format = $rec["Column_date_format"] ;	 // echo " the date_format  is --> ".$date_format."<br>";
										$col_header_rows=$rec["No_header_rows"] - 1;    //echo " the Column_no_account_no  is --> ".$col_header_rows."<br>";
										$BillNumber = $rec["Column_no_bill_no"] - 1; //echo " the BillNumber  is --> ".$BillNumber."<br>";	
									
										if($rec["Column_no_field1"] == 0)
										{
											$col_Field_1_name = "";
										}
										else if($rec["Column_no_field1"] > 0)
										{
											$col_Field_1_name = $rec["Column_no_field1"] - 1;
										}
									//echo "Column_no_field1 is set ==  ".$col_Field_1_name." -----<br>";		
									
									///die;
										if($rec["Column_no_field2"] == "" || $rec["Column_no_field2"] == 0)
										{
											$col_Field_2_name = "";
										}
										else
										{
											$col_Field_2_name=$rec["Column_no_field2"] - 1;
										}
										
										if($rec["Column_no_field3"] == "" || $rec["Column_no_field3"] == 0)
										{
											$col_Field_3_name = "";
										}
										else
										{
											$col_Field_3_name=$rec["Column_no_field3"] - 1;
										}
										
										if($rec["Column_no_field4"] == "" || $rec["Column_no_field4"] == 0)
										{
											$col_Field_4_name = "";
										}
										else
										{
											$col_Field_4_name=$rec["Column_no_field4"] - 1;
										}
										
										if($rec["Column_no_field5"] == "" || $rec["Column_no_field5"] == 0)
										{
											$col_Field_5_name = "";
										}
										else
										{
											$col_Field_5_name=$rec["Column_no_field5"] - 1;
										}
										
									$temp = $Company_id.'lsl_flatfile_transaction_temp';

									$result_detail = mysqli_query($conn,"DROP TABLE $temp");	
								

								$temp_query = "CREATE TABLE  $temp( Transaction_date  varchar(20),
																	Company_transaction_Type 	varchar(25),
																	Transaction_channel_code 	varchar(25),
																	Item_code 	varchar(25),
																	Transaction_amount 	decimal(25,2),
																	Membership_id 	varchar(16),
																	Branch_code 	varchar(25),
																	Quantity 	int(11),
																	Account_no 	decimal(25,0),
																	Bill_no varchar(20),
																	Field_name_1 varchar(25),
																	Field_name_2 varchar(25),
																	Field_name_3 varchar(25),
																	Field_name_4 varchar(25),
																	Field_name_5 varchar(25))";
										
									//echo "the temp query ---->".$temp_query."----<br><br>";	
									 mysqli_query($conn,$temp_query);	
									 
			//echo "the start_date11 query ---->".$start_date11."----<br><br>";						
								
									if($start_date11 != "")
									{
										$col_header_rows = 1;
										$filepath = stripslashes($_FILES['csv']['name']);
										$extension = getExtension($filepath);
										$extension = strtolower($extension);
										$filenameis = $_FILES["csv"]["name"]; 
										
										$UploadFlag12 = 0;
			//echo "the file u send is--".$_FILES['csv']['name'];
										if(substr_count($filenameis,$from_date) > 0)
										{
											if( $extension == "csv" && $_FILES["csv"]["size"] > 0) 
											{
												$filenameis = $_FILES["csv"]["name"]; 
												$file = $_FILES["csv"]["tmp_name"];
												$handle = fopen($file,"r");						
												$filepath = realpath($_FILES["csv"]["tmp_name"]);
												
												for ($lines = 1; $data = fgetcsv($handle,1000,",",'"'); $lines++)
												{	
												
								
													if ($lines == $col_header_rows) continue;
													if ($data[0]) 
													{
														$MembershipId = addslashes($data[$membership_id]);
														
														if($MembershipId == "")
														{
														$get_error[] = "Membership ID of Member is missing";
														$get_error_row[] =  $lines -1;
														}
														
														if($data[$product_code] == "")
														{
														$get_error[] = "product_code is missing";
														$get_error_row[] =  $lines -1;
														}
														if($data[$trans_type_code] == "")
														{
														$get_error[] = "trans type code is missing";
														$get_error_row[] =  $lines -1;
														}
														
														if($data[$trans_channel_code] == "")
														{
														$get_error[] = "transaction channel code is missing";
														$get_error_row[] =  $lines -1;
														}
			//echo "the BillNumber is--".$data[$BillNumber]."--<br>";
														if($data[$BillNumber] == "")
														{
														$get_error[] = "Bill number or Transaction refrence number is missing";
														$get_error_row[] =  $lines -1;
														}
														
														//echo " the account_no  is --> ".$account_no."<br>";
														
														/* if($data[$account_no] == "")
														{								
															$get_error[] = "account_no is missing";
															$get_error_row[] =  $lines -1;
														} */							
														if($data[$branch_code] == "")
														{								
															$get_error[] = "branch_code is missing";
															$get_error_row[] =  $lines -1;
														}
															
														if($data[$trans_amount] == "")
														{
														$get_error[] = "transaction amount is missing";
														$get_error_row[] =  $lines -1;
														}
															
													$MemberArray = array();
										
														$lv_query355 = "SELECT Membership_id,Item_code,Bill_no FROM $temp where Bill_no='".$data[$BillNumber]."'";

														$lv_result355 = mysqli_query($conn,$lv_query355);
														while($rows355 = mysqli_fetch_array($lv_result355))
														{
															$MemberArray[] = $rows355['Membership_id'];

														}
														
														if(count($MemberArray) > 0 && $MembershipId != "")
														{
															
														
															if(!in_array($MembershipId,$MemberArray))
															{
																//echo "$lines---DELETE excxel member--".$MembershipId."----for bill no ---".$data[$BillNumber]."---<br>";
																		
																		$get_error[] = "Bill no. ".$data[$BillNumber]." already used";
																		$get_error_row[] =  $lines -1;
																		
																$MembershipId = "";	
																$data[$BillNumber]	= "";
															}
														}
														
														unset($MemberArray);
									
														$validate_query = "Select * from $temp where Item_code='".$data[$product_code]."' AND Membership_id='".$data[$membership_id]."' AND Bill_no='".$data[$BillNumber]."'";
														
														$validResult = mysqli_query($conn,$validate_query );
														$countRecords = mysqli_num_rows($validResult);
														
														if($countRecords > 0)
														{
															$get_error[] = "Duplicate transaction entry";
															$get_error_row[] =  $lines -1;
															
															continue;
														}
														
														$validate_transaction = mysqli_query($conn,"Select Transaction_id from lsl_transaction where 
														Company_id='$Company_id' AND Item_code='".$data[$product_code]."' AND Branch_code='".$data[$branch_code]."' AND Membership1_id ='".$data[$membership_id]."' AND Bill_no='".$data[$BillNumber]."'");
																		
														$transactionCount = mysqli_num_rows($validate_transaction);
														
														if($transactionCount > 0)
														{
															$get_error[] = "Duplicate transaction entry";
															$get_error_row[] =  $lines -1;
															
															continue;
														}
														
														
		/*---------------------------Check for Duplicate Order No-------------------------*/                    
															$query89 = "SELECT Transaction_id FROM lsl_transaction "
																	 . "WHERE Bill_no='".$data[$BillNumber]."' "
																	 . "AND Company_id='".$Company_id."' "
																	  . "AND Branch_code='".$data[$branch_code]."' "
																	 . "AND Transaction_type_id=1";
																	 
				//echo "the query89 is--".$query89."--<br>";
														
															$Bill_no_no_check = mysqli_num_rows(mysqli_query($conn,$query89));
														   
														   if($Bill_no_no_check > 0)
															{
																$get_error[] = "Duplicate Bill Number";
																$get_error_row[] =  $lines -1;
															
																continue;
															}
                /*---------------------------Check for Duplicate Order No-------------------------*/
          
		  
														if($data[$trans_date] != "" && $data[$product_code] != "" && $data[$membership_id] !="" && $data[$trans_amount] != "" && $data[$BillNumber] !="")
														{
															$MembershipId = addslashes($data[$membership_id]);
				//echo " file  Membership Id----". $MembershipId."<br>";
															
														$lv_query = "SELECT count(Membership_id) FROM  lsl_enrollment_master WHERE Membership_id='".$MembershipId."' AND Company_id='".$Company_id."'";
																$lv_result = mysqli_query($conn,$lv_query);
															if($rows12=mysqli_fetch_array($lv_result))
															{												
																$query_membewrship_id=$rows12['count(Membership_id)'];
															}
																///echo " Available Membership Id----". $query_membewrship_id."<br>";
															if($query_membewrship_id > 0 )
															{
																$transDate = addslashes($data[$trans_date]);

				//echo "--the trans date 2 --".$transDate."--<br>";

																$insertQuery = "INSERT INTO $temp (Transaction_date,Company_transaction_Type,Transaction_channel_code,Item_code,Transaction_amount,Membership_id,
																			Branch_code,Quantity,Account_no,Bill_no,Field_name_1,Field_name_2,Field_name_3,Field_name_4,Field_name_5) VALUES
																	(
																	'".$transDate."',
																	'".addslashes($data[$trans_type_code])."',
																	 '".addslashes($data[$trans_channel_code])."',
																	'".addslashes($data[$product_code])."',
																	  '".addslashes($data[$trans_amount])."',
																	  '".$MembershipId."',
																	'".addslashes($data[$branch_code])."',
																	  '".addslashes($data[$quantity])."',
																	  '".addslashes($data[$account_no])."',
																	  '".addslashes($data[$BillNumber])."',
																	  '".addslashes($data[$col_Field_1_name])."',
																	  '".addslashes($data[$col_Field_2_name])."',
																	  '".addslashes($data[$col_Field_3_name])."',
																	  '".addslashes($data[$col_Field_4_name])."',
																	  '".addslashes($data[$col_Field_5_name])."' 
																	)";
																	
							//echo "the insert query is -->".$insertQuery."<br><br>";
																	
																	mysqli_query($conn,$insertQuery);
																
															}
														}   //print_r($get_error);
													}
												}					
												$UploadFlag12 = 1;
											}
											else if( $extension == "xlsx" || $extension == "xls" && $_FILES["csv"]["size"] > 0) 
											{
												
												$file = $_FILES["csv"]["tmp_name"];
												 
												$firstStr = substr($date_format,0,1);
												 
												$data = new Spreadsheet_Excel_Reader();
												$data->read($file);

												$MembershipId11 = $membership_id + 1;
												$transDate11 = $trans_date + 1;
												$trans_type_code11 = $trans_type_code + 1;
												$trans_channel_code11 = $trans_channel_code + 1;
												$product_code11 = $product_code + 1;
												$trans_amount11 = $trans_amount + 1;
												$branch_code11 = $branch_code + 1;
												$quantity11 = $quantity + 1;
												$account_no11 = $account_no + 1;
												$BillNumber11 = $BillNumber + 1;
												
												if($col_Field_1_name=="" || $col_Field_1_name==0)
												{
													$col_Field_1_name =0;
												}
												else
												{
													$col_Field_1_name = $col_Field_1_name +1;
												}
												
												if($col_Field_2_name=="" || $col_Field_2_name==0)
												{
													$col_Field_2_name =0;
												}
												else
												{
													$col_Field_2_name = $col_Field_2_name +1;
												}
												
												if($col_Field_3_name=="" || $col_Field_3_name==0)
												{
													$col_Field_3_name =0;
												}
												else
												{
													$col_Field_3_name = $col_Field_3_name +1;
												}
												
												if($col_Field_4_name=="" || $col_Field_4_name==0)
												{
													$col_Field_4_name =0;
												}
												else
												{
													$col_Field_4_name = $col_Field_4_name +1;
												}
												
												if($col_Field_5_name=="" || $col_Field_5_name==0)
												{
													$col_Field_5_name =0;
												}
												else
												{
													$col_Field_5_name = $col_Field_5_name +1;
												}
												
												
												//echo "Trans Date after increment transDate11---".$transDate11."--<br>";
												
													for($x = 2; $x <= count($data->sheets[0]["cells"]); $x++)
													{		
														//echo "Inside FOreach --->".$x."<br>";
														$transDate121 = $data->sheets[0]["cells"][$x][$transDate11];
														$MembershipId12 = $data->sheets[0]["cells"][$x][$MembershipId11];
														$trans_type_code12 = $data->sheets[0]["cells"][$x][$trans_type_code11];
														$trans_channel_code12 = $data->sheets[0]["cells"][$x][$trans_channel_code11];
														$product_code12 = $data->sheets[0]["cells"][$x][$product_code11];
														$trans_amount12 = $data->sheets[0]["cells"][$x][$trans_amount11];
														$branch_code12 = $data->sheets[0]["cells"][$x][$branch_code11];
														$quantity12 = $data->sheets[0]["cells"][$x][$quantity11];
														$account_no12 = $data->sheets[0]["cells"][$x][$account_no11];
														$BillNumber12 = $data->sheets[0]["cells"][$x][$BillNumber11];
														$col_Field_1_name12 = $data->sheets[0]["cells"][$x][$col_Field_1_name];
														$col_Field_2_name12 = $data->sheets[0]["cells"][$x][$col_Field_2_name];
														$col_Field_3_name12 = $data->sheets[0]["cells"][$x][$col_Field_3_name];
														$col_Field_4_name12 = $data->sheets[0]["cells"][$x][$col_Field_4_name];
														$col_Field_5_name12 = $data->sheets[0]["cells"][$x][$col_Field_5_name];
														
														$transDate12=str_replace('/','-',$transDate121);
	
														if($MembershipId12 == "")
														{
														$get_error[] = "Membership ID of Member is missing";
														$get_error_row[] =  $x;
														}
														
														if($product_code12 == "")
														{
														$get_error[] = "product_code is missing";
														$get_error_row[] =  $x;
														}
														
														//if($data[$trans_type_code] == "")
														if($trans_type_code12 == "")
														{
														$get_error[] = "trans type code is missing";
														$get_error_row[] =  $x;
														}
														
														//if($data[$trans_channel_code] == "")
														if($trans_channel_code12 == "")
														{
														$get_error[] = "transaction channel code is missing";
														$get_error_row[] =  $x;
														}
														
														if($BillNumber12 == "")
														{
														$get_error[] = "Bill number or Transaction refrence number is missing";
														$get_error_row[] =  $x;
														}
														
														$MemberArray = array();
														
														
														$lv_query355 = "SELECT Membership_id,Item_code,Bill_no FROM $temp where Bill_no='".$BillNumber12."'";

														$lv_result355 = mysqli_query($conn,$lv_query355);
														while($rows355 = mysqli_fetch_array($lv_result355))
														{
															$MemberArray[] = $rows355['Membership_id'];

														}
														
														if(count($MemberArray) > 0 && $MembershipId12 != "")
														{
															
														
															if(!in_array($MembershipId12,$MemberArray))
															{
																		
																$get_error[] = "Bill no. ".$BillNumber12." already used";
																$get_error_row[] =  $x;
																		
																$MembershipId12 = "";	
																$BillNumber12	= "";
															}
														}
														
														unset($MemberArray);
														//echo " the account_no  is --> ".$account_no."<br>";
														
													
														if($account_no == "")
														{
															$get_error[] = "account_no is missing";
															$get_error_row[] =  $x;
														}
														
														
														if($trans_amount12 == "")
														{
														$get_error[] = "transaction amount is missing";
														$get_error_row[] =  $x;
														}
														
					/*---------------------------Check for Duplicate Order No-------------------------*/                    
															$query89 = "SELECT Transaction_id FROM lsl_transaction "
																	 . "WHERE Bill_no='".$BillNumber12."' "
																	 . "AND Company_id='".$Company_id."' "
																	  . "AND Branch_code='".$branch_code12."' "
																	 . "AND Transaction_type_id=1";
															$Bill_no_no_check = mysqli_num_rows(mysqli_query($conn,$query89));
														   
														   if($Bill_no_no_check > 0)
															{
																$get_error[] = "Bill no. ".$BillNumber12." already used";
																$get_error_row[] =  $x;
																		
																$MembershipId12 = "";	
																$BillNumber12	= "";
															}
                /*---------------------------Check for Duplicate Order No-------------------------*/
				
														$validate_query = "Select * from $temp where Item_code='".$product_code12."' AND Membership_id='".$MembershipId12."' AND Bill_no='".$BillNumber12."'";
														
														//echo "--validate_query--".$validate_query."--<br>";
														$validResult = mysqli_query($conn,$validate_query );
														$countRecords = mysqli_num_rows($validResult);
													//	echo "--countRecords--".$countRecords."--<br>";
														if($countRecords > 0)
														{
															$get_error[] = "Duplicate transaction entry";
															$get_error_row[] =  $x;
															$MembershipId12 = "";
															$product_code12 = "";
															//die;
														}
														
														$validate_transaction = mysqli_query($conn,"Select Transaction_id from lsl_transaction where 
														Company_id='$Company_id' AND Item_code='".$product_code12."' AND Branch_code='".$branch_code12."' AND Membership1_id ='".$MembershipId12."' AND Bill_no='".$BillNumber12."'");
																		
														$transactionCount = mysqli_num_rows($validate_transaction);
														
														if($transactionCount > 0)
														{
															$get_error[] = "Duplicate transaction entry";
															$get_error_row[] =  $lines -1;
															
															continue;
														}
														
														//echo " Bfore While Loop". $MembershipId."<br>";
														
														if($transDate12 != "" && $product_code12 != "" && $MembershipId12 !="" && $trans_amount12 != "" && $BillNumber12 != "")
														{
															//echo " file  Membership Id". $MembershipId."<br>";
														$lv_query = "SELECT count(Membership_id) FROM  lsl_enrollment_master WHERE Membership_id='".$MembershipId12."' AND Company_id='".$Company_id."'";
																$lv_result = mysqli_query($conn,$lv_query);
															if($rows12=mysqli_fetch_array($lv_result))
															{												
																$query_membewrship_id=$rows12['count(Membership_id)'];
															}
																//echo " Available Membership Id". $query_membewrship_id."<br>";
															if($query_membewrship_id > 0 )
															{
																
																$insertQuery = "INSERT INTO $temp (Transaction_date,Company_transaction_Type,Transaction_channel_code,Item_code,Transaction_amount,Membership_id,Branch_code,Quantity,Account_no,Bill_no,Field_name_1,Field_name_2,Field_name_3,Field_name_4,Field_name_5) VALUES
																	(
																	'".$transDate12."',
																	'".addslashes($trans_type_code12)."',
																	 '".addslashes($trans_channel_code12)."',
																	'".addslashes($product_code12)."',
																	  '".addslashes($trans_amount12)."',
																	  '".$MembershipId12."',
																	'".addslashes($branch_code12)."',
																	  '".addslashes($quantity12)."',
																	  '".addslashes($account_no12)."',
																	  '".addslashes($BillNumber12)."',
																	  '".addslashes($col_Field_1_name12)."',
																	  '".addslashes($col_Field_2_name12)."',
																	  '".addslashes($col_Field_3_name12)."',
																	  '".addslashes($col_Field_4_name12)."',
																	  '".addslashes($col_Field_5_name12)."' 
																	)";
																	
																//echo "the insert query is -->".$insertQuery."<br><br>";
																	
																	mysqli_query($conn,$insertQuery);									
															}
														}
													}
													
													$UploadFlag12 = 1;
													
													//echo "aaaaaaa UploadFlag12---".$UploadFlag12."---<br>";
											}

											if($UploadFlag12 == 0)
											{
											$UploadFlag12 = 0;
											
											mysqli_query($conn,"
														INSERT INTO lsl_file_upload_status(Company_id,File_name,File_path,Upload_status,Error_status,Date)
														VALUES
														(
														'".$Company_id."',
														'".addslashes($filenameis)."',
														'".addslashes($filepath)."',
														'0',
														'0',
														'".$mv_create_date."'
														)");
														
												$errorCode = 2081;		
											}

											$error_status = count($get_error);
											
											if($UploadFlag12 == 1)
											{
												mysqli_query($conn,"
													INSERT INTO lsl_file_upload_status(Company_id,File_name,File_path,Upload_status,Error_status,Date)
													VALUES
													(
													'".$Company_id."',
													'".addslashes($filenameis)."',
													'".addslashes($filepath)."',
													'1',
													'".$error_status."',
													'".$mv_create_date."'
													)");
																
													$mv_inserted_id =  mysqli_insert_id($conn);	
													
												for($pk = 0; $pk < $error_status; $pk++)
												{
													if($get_error[$pk] != "")
													{
														//echo " 2---get_error_row--no ---".$get_error_row[$pk]."---<br>";
														
														mysqli_query($conn,"
														INSERT INTO   lsl_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in,Error_row_no)
														VALUES
														(
														'".$Company_id."',
														'".addslashes($filenameis)."',
														'".addslashes($filepath)."',
														'".$mv_inserted_id."',
														'".$mv_create_date."',
														'".$get_error[$pk]."',
														'".$get_error_row[$pk]."')");
													}
												}
											}	
					
										}
										else
										{
											$errorCode = 2080;
										}
									}
									else
									{
										$errorCode = 2079;
									}
									
										if($errorCode > 0)
										{
										
										/*******************************************Get Company Admins Of Company*************************************/
										$Template_type_id = 11;
										$Email_Type = 13;  //****Transaction Flat File Error*****
										$Company_Admins = array();
										$LSL_Admins = array();
										$LSL_Company_Admins = array();
										
											$result173=lslDB::getInstance()->get_company_details($Company_id);
											while($rows173=mysqli_fetch_array($result173)) 
											{
												$Solution_type=$rows173['Solution_type'];
											}
											if($Solution_type == 3)
											{
												$sql22 = "SELECT Enrollment_id FROM lsl_enrollment_master WHERE Company_id='".$Company_id."' AND User_type_id='9' ";
											}
											else
											{
												$sql22 = "SELECT Enrollment_id FROM lsl_enrollment_master WHERE Company_id='".$Company_id."' AND User_type_id='4' ";
											}
											$result22 = mysqli_query($conn,$sql22);
											while($row22 = mysqli_fetch_array($result22))
											{
												$Company_Admins[] = $row22['Enrollment_id'];
												// $transaction_email_template = lslDB::getInstance()->send_flat_file_error_email_template($Company_Admins,$Company_id,$filenameis,$filepath,$Email_Type,$Template_type_id);
											}
											$sql44 = "SELECT Enrollment_id FROM lsl_enrollment_master WHERE User_type_id='2' ";
											$result44 = mysqli_query($conn,$sql44);
											while($row44 = mysqli_fetch_array($result44))
											{
												$LSL_Admins[] = $row44['Enrollment_id'];
											}				
											//$LSL_Company_Admins = array_merge($Company_Admins,$LSL_Admins);
											
											foreach($LSL_Admins as $admins)
											{
												$transaction_email_template = lslDB::getInstance()->send_flat_file_error_email_template($admins,$Company_id,$filenameis,$filepath,$Email_Type,$Template_type_id);
											}
											
										/*******************************************Get Company Admins Of Company*************************************/
										
										echo json_encode(array("status" => $errorCode, "status_message" => ""));
										exit;
										}
									
									
									$temp=$Company_id.'lsl_flatfile_transaction_temp';
									
									$MemberArray12 = array();
		
									$lv_query355 = "SELECT Membership_id,Item_code,Bill_no FROM $temp";
									$lv_result355 = mysqli_query($conn,$lv_query355);
									while($rows355 = mysqli_fetch_array($lv_result355))
									{
										if(!in_array($rows355['Bill_no'],$MemberArray12))
										{
											$MemberIDIS = $rows355['Membership_id'];
											$MemberArray12[$MemberIDIS] = $rows355['Bill_no'];
										//$BillArray[] = $rows355['Bill_no'];
										}
										else
										{
											$MemberID55 = $rows355['Membership_id'];
											
											$key = array_search($rows355['Bill_no'],$MemberArray12); 
											
											if($MemberID55 != $key)
											{
												//echo "DELETE member from temp table--".$MemberID55."----for bill no ---".$rows355['Bill_no']."---<br>";
												
												$lv_query31 = "DELETE FROM $temp where Bill_no='".$rows355['Bill_no']."' and Membership_id='".$MemberID55."' ";

												$delete_temp = mysqli_query($conn,$lv_query31);
											}
										}
									}

									$str18 = "cheque"; 
									
									for($di=1;$di<=5;$di++)		//******* for cheque ******
									{
										$str19 = "Field_".$di."_name";
									
										$str20 = strtolower($rec["$str19"]);
										//$str17 = $rec25["Field_1_name"];
										//echo "the bill no is---str20--->".$str20."<--str20-<br>";
										if(substr_count($str20,$str18) > 0)
										{
											$G2 = $di;
										}
									}
									
									$str21 = "bank name"; 
									
									for($di=1;$di<=5;$di++)		//******* for cheque ******
									{
										$str22 = "Field_".$di."_name";
									
										$str23 = strtolower($rec["$str22"]);
										
										//echo "the bill no is---str23--->".$str23."<--str23-<br>";
										if(substr_count($str23,$str21) > 0)
										{
											$G3 = $di;
										}
									}
										///echo "the bank name is---G3--->".$G3."<--G3-<br>";	
									
									$str24 = "remarks";
									$str27 = "remark";
									
									for($di=1;$di<=5;$di++)		//******* for cheque ******
									{
										$str26 = "Field_".$di."_name";
									
										$str25 = strtolower($rec["$str26"]);
										
										if(substr_count($str25,$str24) > 0 || substr_count($str25,$str27) > 0)
										{
											$G5 = $di;
										}
									}

									$lv_query31 = "SELECT * FROM $temp ";
		

									//echo "the temp query is-->>--".	$lv_query31."-->>-<br>";
									$lv_result31 = mysqli_query($conn,$lv_query31);
									while($rows31=mysqli_fetch_array($lv_result31))
									{	
										$temp_trans_date = $rows31['Transaction_date'];
										$Field_val_1_array[] = $rows31['Field_name_1'];
										$Field_val_2_array[] = $rows31['Field_name_2'];
										$Field_val_3_array[] = $rows31['Field_name_3'];
										$Field_val_4_array[] = $rows31['Field_name_4'];
										$Field_val_5_array[] = $rows31['Field_name_5'];
										
										if($date_format == "dd-mm-yyyy")
										{
											$date23 = str_replace("/","-",$temp_trans_date);
											
											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($date23));
										}
										
										if($date_format == "m/d/yyyy")
										{
											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($temp_trans_date));
										}
			
										if($date_format == "dd-mm-yyyy")
										{
											$date23 = str_replace("/","-",$temp_trans_date);
											
											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($date23));
										}
										
										if($date_format == "mm-dd-yyyy")
										{
											$date12 = str_replace("-","/",$temp_trans_date);

											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($date12));
										}
										
										if($date_format == "dd/mm/yyyy")
										{
											$date22 = str_replace("/","-",$temp_trans_date);

											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($date22));
										}
										
										if($date_format == "mm/dd/yyyy")
										{
											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($temp_trans_date));
										}
										
										if($date_format == "dd-m-yyyy" || $date_format == "d-m-Y")
										{
											$trans_date_array[] = date("Y-m-d h:i:s", strtotime($temp_trans_date));
										}
										
										$Company_transaction_Type_array[] = $rows31['Company_transaction_Type'];
										
										$Transaction_channel_code_array[] = $rows31['Transaction_channel_code'];
										
										$itemCode_array[] = $rows31['Item_code'];
										$Transaction_amount_array[] = $rows31['Transaction_amount'];
										
										$Membership_id_array[] = $rows31['Membership_id']; 	//echo " --mm-- the transaction of membership ID --mmm-->".$Membership_id."<--<br>";
										$branch_code_array[] = $rows31['Branch_code'];
										$itemQty = $rows31['Quantity'];
										
										if($itemQty == "" || $itemQty == 0)
										{
											$itemQty_array[] = 1;
										}
										else
										{
											$itemQty_array[] = $itemQty;
										}
										
										$Account_no_array[] = $rows31['Account_no'];
										
										$BillNo_array[] = $rows31['Bill_no'];
										$Cheque = $rows31['Field_name_'.$G2];
										$BankName_array[] = $rows31['Field_name_'.$G3];
										$Remark_array[] = $rows31['Field_name_'.$G5];
										
										if($Cheque == 0 || $Cheque == "")
										{
											$Cheque_array[] = 0;		
										}
										else
										{
											$Cheque_array[] = $Cheque;
										}
									}
									
									
									//echo "<br>items array<br><br>";
									
									//print_r($itemCode_array);
									
									//echo "---<br><br>";
								}
								
								$insertFlag = 0;
								
								if($Transaction_flag == 4) //**** Single Bank or Telco Transaction**
								{
									$error_status = 0;
				//echo "---transaction flag is--4<br>";
									$insertFlag = 1;
									
									$mv_date=date("Y-m-d");
									$timezone = new DateTimeZone($Company_details["Timezone"]);
									$date = new DateTime();
									$date->setTimezone($timezone );
									$lv_time=$date->format('H:i:s');
									$mv_datetime = $mv_date.' '.$lv_time;
									$mv_create_date = $mv_datetime;
									$trans_date = $mv_datetime;
						
									$Remark = $_REQUEST['Remark'];

									if($_REQUEST['Membership_id'] == "")
									{
										echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
										exit;
									}
									else
									{
										//$Account_No = trim(string_decrypt($_REQUEST['Account_No'], $key, $iv));
										//$Account_No = preg_replace("/[^(\x20-\x7f)]*/s", "", $Account_No);
										
										$Bill_number = $_REQUEST['Bill_no'];
										
										if($_REQUEST['Bill_no'] == "")
										{
											echo json_encode(array("status" => "2085", "status_message" => "Delivery Details are blank"));
											exit;
										}
									
										$Branch_code = trim(string_decrypt($_REQUEST['Branch_code'], $key, $iv));
										$branchecode = preg_replace("/[^(\x20-\x7f)]*/s", "", $Branch_code);

										if($branchecode == "")
										{
											echo json_encode(array("status" => "2071", "status_message" => "Invalid Branch Code"));
											exit;
										}
							
			/*---------------------------Check for Duplicate Order No-------------------------*/                  
											$query89 = "SELECT Transaction_id FROM lsl_transaction "
													 . "WHERE Bill_no='".$Bill_number."' "
													 . "AND Company_id='".$Company_id."' "
													  . "AND Branch_code='".$branchecode."' "
													 . "AND Transaction_type_id=1";
											$Bill_no_no_check = mysqli_num_rows(mysqli_query($conn,$query89));
										   
										   if($Bill_no_no_check > 0)
											{
												echo json_encode(array("status" => "2067", "status_message" => "Bill Number already exist"));
												exit;
											}
             /*   ---------------------------Check for Duplicate Order No-------------------------*/
				
										
										$Membership_id = trim(string_decrypt($_REQUEST['Membership_id'], $key, $iv));
										$Membership_ID = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
										
										$queryg1 ="SELECT * FROM lsl_enrollment_master "
														. "WHERE Company_id='".$Company_id."'"
														. "AND Active_flag='1'"
														. "AND Membership_id='".$Membership_ID."' ";
										//echo "<br>---lv_member queryg1--".$queryg1 ."---<br>";											
										$res6 = mysqli_fetch_array(mysqli_query($conn, $queryg1));
								
										if($res6 == NULL)
										{
											echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
											exit;
										}
										else
										{
											if($res6['Active_flag'] == "0")
											{
													echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
													exit;
											}
											else
											{
												$lv_member_name = $res6['First_name']." ".$res6['Last_name'];							
												$lv_member_pin = $res6['Pin'];
												$lv_member_enrollid = $res6['Enrollment_id'];
												$lv_member_balance = $res6['Current_balance'];
												$lv_purchase_amount = $res6['Total_purchase_amount'];
												$lv_bonus_points = $res6['Total_bonus_points'];
												$lv_redeem_points = $res6['Total_redeem_points'];
												$lv_gained_points = $res6['Total_gained_points'];
												$lv_parent_enrollid = $res6['Parent_enroll_id'];
												$Family_redeem_limit    = $res6['Family_redeem_limit'];
												$lv_Familly_flag = $res6['Familly_flag'];
												$member_tier_id = $res6['Tier_id'];
												$member_lp_id = $res6['Loyalty_programme_id'];
												$lv_member_Account_no = $res6['Account_number'];
												$lv_countryid  = $res6['Country_id'];
												$Communication_flag  = $res6['Communication_flag'];
												$Member_Blocked_points  = $res6['Blocked_points'];
												$CurrBal = $lv_member_balance - $Member_Blocked_points;
												$MemberPin = $lv_member_pin;
												
												$query15 = mysqli_query($conn,"select Points_value_definition from lsl_loyalty_program_master where Loyalty_program_id=$member_lp_id AND Company_id=".$Company_id);
												
												while($row15 = mysqli_fetch_array($query15))
												{
													$redemptionratio = $row15['Points_value_definition'];
												}
												
												$Company_transaction_Type = $_REQUEST['Company_transaction_Type'];
			
												if( $Company_transaction_Type=='0'  || $Company_transaction_Type=="")
												{
													//*************** company transaction type code *******************
													$channelj = "Select * from lsl_company_transaction_type_master where Company_id=$Company_id order by Transaction_type_id limit 1";
													$exe_queryj = mysqli_query($conn,$channelj);
													while($exe_resj = mysqli_fetch_array($exe_queryj))
													{
														$CompTransaction_type = $exe_resj['Transaction_type_code'];
													}
												
												}
												else
												{
													$CompTransaction_type = $Company_transaction_Type;
												}
												
												
												
												$Transaction_channel_code = $_REQUEST['Transaction_channel_code'];
												
												if($Transaction_channel_code == '0' || $Transaction_channel_code == "")
												{
													$channelj = "Select * from lsl_company_transaction_channel_master where Company_id=$Company_id AND Comp_trans_channel_name like '%Not Applicable%' Or Comp_trans_channel_name like '%NotApplicable%' ";
														//echo "Channel --> ".$channelj."-->>-<br>";
														$exe_queryj = mysqli_query($conn,$channelj);
														while($exe_resj = mysqli_fetch_array($exe_queryj))
														{
															$transaction_channel = $exe_resj['Comp_trans_channel_code'];
														}
											
												}
												else
												{
													$transaction_channel = $Transaction_channel_code;
												}
												
											/*	
												if($_REQUEST['item_1'] != "")
												{
													$item_1 = $_REQUEST['item_1'];
													$quantity_1 = $_REQUEST['quantity_1'];
													$Product_details1["Item_code"] = $item_1;
													$Product_details1["Quantity"] = $quantity_1;
													$Product_details1["Total_price"] = $_REQUEST['price_1'];
													$Product_details[0] = $Product_details1;
												}

												if($_REQUEST['item_2'] != "")
												{
													$item_2 = $_REQUEST['item_2'];
													$quantity_2 = $_REQUEST['quantity_2'];
													$Product_details2["Item_code"] = $item_2;
													$Product_details2["Quantity"] = $quantity_2;
													$Product_details2["Total_price"] = $_REQUEST['price_2'];
													$Product_details[1] = $Product_details2;
												}			
											*/	
											$Product_details = $_REQUEST['Product_details'];
											//print_r($Product_details);		
												if(empty($Product_details))
												{
													echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
													exit;
												}
												$loopC = 0;
													
												
												
												foreach($Product_details as $item_info)
												{
													$Remark_array[] = $Remark;
													$itemCode_array[] = $item_info["Item_code"];	
													$Transaction_amount_array[] = $item_info["Total_price"];	
													$Account_no_array[] = $lv_member_Account_no;
													
													$trans_date_array[] = $trans_date;
													$Company_transaction_Type_array[]= $CompTransaction_type;
													$Transaction_channel_code_array[] = $transaction_channel;
													$Membership_id_array[] = $Membership_ID;
													$branch_code_array[] = $branchecode;
													$BillNo_array[] = $Bill_number;
													$itemQty = $item_info["Quantity"];
													
													if($itemQty == "" || $itemQty == 0)
													{
														$itemQty_array[] = 1;
													}
													else
													{
														$itemQty_array[] = $itemQty;
													}
													
													$Field_val_1_array[] = "";
													$Field_val_2_array[] = "";
													$Field_val_3_array[] = "";
													$Field_val_4_array[] = "";
													$Field_val_5_array[] = "";
														
												}
	
											}

										}
									}
								}
									
									$cmp_prod_code = array();
									$cmp_trn_code = array();
									$cmp_trn_channel_code = array();
									$Transaction_type = 1;
									$todays=date("Y-m-d");
									$campaignID = array();
									$RedeemPoints = 0;		//echo "the RedeemPoints Is --".$RedeemPoints."<br>";
									$RedeemAmt =0;		//echo "the RedeemAmt is- --".$RedeemAmt."<br>";
									
									$EmployeeID = 0;
									$total_amt = 0;		//echo "the total_amt id --".$total_amt."<br>";
									$total_vat = 0;		 //echo "the total_vat id --".$total_vat."<br>";
									$grand_total = 0;		//echo "the grand_total id --".$grand_total."<br>";
									$GiftCardFlag = 0;		 //echo "the GiftCardFlag id --".$GiftCardFlag."<br>";
									$GiftCardID = 0;		// echo "the GiftCardID id --".$GiftCardID."<br>";
									$GiftCardBal = 0;		// echo "the GiftCardBal id --".$GiftCardBal."<br>";
									$GiftRedeem = 0;		 //echo "the GiftRedeem id --".$GiftRedeem."<br>";
									$GiftBalToPay = 0;		// echo "the GiftBalToPay id --".$GiftBalToPay."<br>";
									$PaymentBy = 1;		 //echo "the PaymentBy id --".$PaymentBy."<br>";
									$VoucherNo = 0;
									
									$MemberPin = 0;		// echo "the MemberPin id --".$MemberPin."<br>";
									$MemberBalance = 0;		// echo "the MemberBalance id --".$MemberBalance."<br>";
									$Remark = "";		// echo "the Remark  --".$Remark."<br>";	
									
								$login_enroll_id = $mv_create_user_id;
									$source = "APIFlatFile";
									$bonus_points = 0;
									
									$kp = 0;
									$loyalty_points = 0;
									
									$purchase_item_details = array();
									$prd_array = array();
												
									$allow_transaction = 0;
									$total_loyalty_points = 0;
									$campagin_loyalty_points = 0;
									
									$myquery1 = "Select * from lsl_campaign_master where Company_id=$Company_id AND Campaign_type='29' AND
													Active_flag='1' AND To_date >= '".$todays."' ";
										
										//echo "select campaign query----".$myquery1."<br>";
										
										$myquery1_exe = mysqli_query($conn,$myquery1);
										while($myres1 = mysqli_fetch_array($myquery1_exe))
										{
											if(($todays >= $myres1['From_date']) && ($todays <= $myres1['To_date']))
											{					
												$campaignID[] = $myres1['Campaign_id'];							
											}	
										}
		
									foreach($itemCode_array as $itemCode)
									{
											
										$BalToPay = $Transaction_amount_array[$kp];	
										$BillNo = $BillNo_array[$kp];
										$Remark = $Remark_array[$kp];
										
										
										/*if($BillNo_array[$kp] > 0)
										{
											$BillNo = $BillNo_array[$kp];
										}
										else
										{
											$BillNo = $Pos_series_no;
										}*/
									//	echo "<br>item code---".$itemCode_array[$kp]."--<br>";
									//	echo "<br>Transaction_amount e---".$Transaction_amount_array[$kp]."--<br>";
									/*	echo "<br>Account_no---".$Account_no_array[$kp]."--<br>";	
										echo "<br>trans_date---".$trans_date_array[$kp]."--<br>";	
										echo "<br>Company_transaction_Type---".$Company_transaction_Type_array[$kp]."--<br>";	
										echo "<br>Transaction_channel_code---".$Transaction_channel_code_array[$kp]."--<br>";	
										echo "<br>Membership_id---".$Membership_id_array[$kp]."--<br>";	
										echo "<br>branch_code---".$branch_code_array[$kp]."--<br>";	
										echo "<br>itemQty---".$itemQty_array[$kp]."--<br>";	
										*/

										$queryg81 ="SELECT * FROM lsl_enrollment_master "
														. "WHERE Company_id='".$Company_id."'"
														. "AND Active_flag='1'"
														. "AND Membership_id='".$Membership_id_array[$kp]."' ";
										//echo "<br>---lv_member queryg1--".$queryg1 ."---<br>";											
										$res68 = mysqli_fetch_array(mysqli_query($conn, $queryg81));
								
											if($res68 == NULL)
											{
												echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
												exit;
											}
											else
											{
												$Membership_ID =  $res68['Membership_id'];
												$lv_member_name = $res68['First_name']." ".$res68['Last_name'];
												//echo "<br>---lv_member_name--".$lv_member_name ."---<br>";										
												$lv_member_pin = $res68['Pin'];
												$lv_member_enrollid = $res68['Enrollment_id'];
												$lv_member_balance = $res68['Current_balance'];
												$lv_purchase_amount = $res68['Total_purchase_amount'];
												$lv_bonus_points = $res68['Total_bonus_points'];
												$lv_redeem_points = $res68['Total_redeem_points'];
												$lv_gained_points = $res68['Total_gained_points'];
												$lv_parent_enrollid = $res68['Parent_enroll_id'];
												$Family_redeem_limit    = $res68['Family_redeem_limit'];
												$lv_Familly_flag = $res68['Familly_flag'];
												$member_tier_id = $res68['Tier_id'];
												$member_lp_id = $res68['Loyalty_programme_id'];
												$lv_member_Account_no = $res68['Account_number'];
												$lv_countryid  = $res68['Country_id'];
												$Communication_flag  = $res68['Communication_flag'];
												$Member_Blocked_points  = $res68['Blocked_points'];
												$CurrBal = $lv_member_balance - $Member_Blocked_points;
												$MemberPin = $lv_member_pin;
												
												//echo "<br>---lv_countryid--".$lv_countryid ."---<br>";	
												
												if($lv_countryid == 1)
												{
													$exchange_rate = 1;
												}
												else
												{
													$country_info = lslDB::getInstance()->get_Country($lv_countryid);
													while($res12 = mysqli_fetch_array($country_info))
													{
														$exchange_rate = $res12['Exchange_rate'];
													}
												}
												
											}
											
											
										$item_info = lslDB::getInstance()->get_branch_item_details($itemCode,$branch_code_array[$kp],$Company_id);
											while($res3 = mysqli_fetch_array($item_info))
											{
												$Item_branch_code =$res3['Branch_code'];
												$Item_name = $res3['Item_name'];			
												$Item_group_code = $res3['Product_group_code']; 	
												$Item_brand_code = $res3['Product_brand_code'];
												$Item_priceB = $res3['Item_price'];
												$Item_vatB = $res3['Item_vat'];
												$Item_current_bal = $res3['Current_balance'];
												$Item_threshold_balance = $res3['Threshold_balance'];
						
											}
										
													$prd_array['itemcode'] = $itemCode;
													$prd_array['quantity'] = $itemQty_array[$kp];
													$prd_array['Item_name'] =  $Item_name;
													$prd_array['Rate'] = $Transaction_amount_array[$kp];
														
												
													
										foreach($campaignID as $cmp_id)
										{
											$loyalty_points = 0;
											$campagin_loyalty_points = 0;
							//echo "--------------********-------the running campaign is-----".$cmp_id ."<br>";

											$cmp_info = lslDB::getInstance()->get_campaign_details($cmp_id);
											while($cmp_res = mysqli_fetch_array($cmp_info))
											{
												$Loyalty_programme_id = $cmp_res['Loyalty_programme_id'];
												$cmp_name = $cmp_res['Campaign_name'];
												$cmp_type = $cmp_res['Campaign_type'];
												$cmp_sub_type = $cmp_res['Campaign_sub_type'];
												$cmp_Tier_flag  = $cmp_res['Tier_flag'];
												$cmp_Tier_id = $cmp_res['Tier_id'];
												$cmp_Sweepstake_flag = $cmp_res['Sweepstake_flag'];
												$Sweepstake_id = $cmp_res['Sweepstake_id'];
												$Sweepstake_ticket_limit = $cmp_res['Sweepstake_ticket_limit'];
												$Reward_once_flag = $cmp_res['Reward_once_flag'];
												$Transaction_amt_flag = $cmp_res['Transaction_amt_flag'];
												$cmp_Reward_flag  = $cmp_res['Reward_flag'];
												$Reward_fix_amt_flag  = $cmp_res['Reward_fix_amt_flag'];
												$customer_budget = $cmp_res['Max_reward_budget_cust'];
											}	

											if($Loyalty_programme_id == $member_lp_id)  //*********** Loyalty program validation *********
											{
												//echo "---***---the Loyalty_programme_id  is---rrrrrr--".$Loyalty_programme_id ."<br>"; 
												$allow_transaction = lslDB::getInstance()->cmp_basic_transaction_validation($cmp_id,$Company_transaction_Type_array[$kp],$Transaction_channel_code_array[$kp]);
												//die;
												if($cmp_Tier_flag == 1 && $allow_transaction == 1) //********* member tier validation ********
												{
													if($cmp_Tier_id == $member_tier_id)
													{
														$allow_transaction = 1;
													}
													else
													{
														$allow_transaction = 0;
													}
												}
												//continue;
								//echo "---***---Tier the allow_transaction  is---tttt--".$allow_transaction ."<br>"; 
												//echo "Reward Once Flag  ----".$Reward_once_flag ."<br>";
												
												if($Reward_once_flag == 1 && $allow_transaction == 1)   //************ Reward once flag check ************
												{
													$allow_transaction =lslDB::getInstance()->cmp_reward_once_validation($cmp_id,$Company_id,$lv_member_enrollid);
												}
												//echo "Reward Once  ----".$allow_transaction ."<br>";
												//echo "allow cmp_Sweepstake_flag ----".$cmp_Sweepstake_flag ."<br>";
												
													if($allow_transaction == 1)		 
													{

														$allow_product_transaction = lslDB::getInstance()->cmp_basic_product_validation($cmp_id,$itemCode);
														
														//echo "allow product_transaction ----".$allow_product_transaction ."<br>";
														$lv_transaction_points = 0;
														$lv_fixedamt_points = 0;
														$loyalty_points = 0;
														
														if($allow_product_transaction == 1)
														{
															if($Transaction_amt_flag == 1) //************ get loyalty points on transaction amount ************
															{
															$lv_transaction_points = lslDB::getInstance()->cmp_transactionamt_criteria($cmp_id,$itemCode,$Transaction_amount_array[$kp],$Company_id,$exchange_rate);
															}
															
										//echo "---exchange_rate--> " .$exchange_rate."<br>";
										//echo "Transaction Amount Points --> " .$lv_transaction_points."<br>";
															//$loyalty_points = $lv_transaction_points;
														
															if($Reward_fix_amt_flag == 1) //************ get loyalty points on fixed amount ************
															{
															$lv_fixedamt_points = lslDB::getInstance()->cmp_fixedamt_criteria($cmp_id,$itemCode,$Transaction_amount_array[$kp],$Company_id,$exchange_rate);
															}
										//echo "lv_fixedamt_points--> " .$lv_fixedamt_points."<br>";	

											//exit;die;										
															//$loyalty_points = $lv_fixedamt_points;
															
															$loyalty_points = $lv_fixedamt_points + $lv_transaction_points;
															
															$lv_fixedbudget_points = 0;
															
															if($cmp_sub_type == 112)  //***** check fixed budget **********
															{
																$myquery51 ="Select sum(Reward_points) from lsl_transaction_child where Campaign_id='".$cmp_id."' AND Enrollment_id='".$lv_member_enrollid."' AND Company_id=".$Company_id;
						//echo "<br>customer budget query query-----".$myquery51."<br>";
																$myres51 = mysqli_query($conn,$myquery51);
																
																while($myrow51 = mysqli_fetch_array($myres51))
																{
																	$total_member_points = $myrow51['sum(Reward_points)'];
																}
															
						//echo "<br>customer total_member_points-----".$total_member_points."<br>";	
						
																//echo "*//*/** cmp_sub_type on----".$cmp_sub_type;
															$lv_fixedbudget_points = lslDB::getInstance()->cmp_fixedbudget_criteria($cmp_id,$lv_member_enrollid,$Company_id);		
															}
															
															if($lv_fixedbudget_points == 0)
															{
																$loyalty_points = $loyalty_points;
															}
															else if($lv_fixedbudget_points == 1)
															{
																if($customer_budget > 0)
																{
																	$calculate_points = intval($loyalty_points + $total_member_points);
																	$calculate_points_new = intval($customer_budget-$total_member_points);
																	
												//	echo "<br> customer_budget--loyalty_points---".$loyalty_points."<br>";
												//	echo "<br> calculate_points-----".$calculate_points."<br>";			
												//	echo "<br> customer_budget-----".$customer_budget."<br>";
												
																		if($loyalty_points >= $calculate_points_new)
																		{
																			$loyalty_points = $calculate_points_new;
																		}
																		else
																		{
																			$loyalty_points = $loyalty_points;
																		}
																}
																else
																{
																	$loyalty_points = $loyalty_points;
																}
															}
															else if($lv_fixedbudget_points == 2)
															{	
																$loyalty_points = 0;
															}
															
															if($loyalty_points > 0 && $cmp_Sweepstake_flag == 1)  //**** sweepstake entry ****
															{
																$allow_sweep_ticket = lslDB::getInstance()->cmp_sweepstake_validation($cmp_id,$Sweepstake_id,$Company_id,$lv_member_enrollid,$todays,$Sweepstake_ticket_limit,$mv_create_user_id,$mv_create_date);
															}
														
															if($cmp_sub_type == 114)  // ***** cash back campaign ****
															{
																$Product_cost = $Transaction_amount_array[$kp];
										
															$myquery50 = "Insert into lsl_cashback_transaction(Campaign_id,Campaign_name,Customer_name,Membership_id,Account_no,Enrollment_id,
																			Transaction_amount,Cashback_amount,Company_id,Branch_code,Transaction_date)
																			values('".$cmp_id."','".$cmp_name."','".$lv_member_name."','".$Membership_ID."','".$Account_no_array[$kp]."',
																					'".$lv_member_enrollid."','".$Product_cost."','".$lv_transaction_points."','".$Company_id."','".$branch_code_array[$kp]."','".$trans_date_array[$kp]."') ";
																			
																//echo "<br>the insert into cash back query----".$myquery50."<br>";	
																	$run_query50 = mysqli_query($conn,$myquery50);
																$lv_transaction_points = 0;	
															}
														}

										//echo "loyalty_points on Campaign----".$cmp_name." ---Item Code----".$itemCode." ----itemQty--".$itemQty."--Points Gained ---".$loyalty_points ."<br>";
															
													}
												
											}
											if($loyalty_points > 0)
											{
												$myquery52 = "Insert into lsl_transaction_child(Enrollment_id,Transaction_id,Campaign_id,Campaign_type,Campaign_sub_type,Reward_points,Company_id,Date)
																	values('".$lv_member_enrollid."','0','".$cmp_id."','".$cmp_type."','".$cmp_sub_type."','".$loyalty_points."','".$Company_id."','".$trans_date_array[$kp]."')";
															
												//echo "<br>the insert into child query----".$myquery52."<br>";	
													$run_query = mysqli_query($conn,$myquery52);
											}
											
										//echo " Loyalty Points Gained ----".$loyalty_points."<br>";
										
										$campagin_loyalty_points = $campagin_loyalty_points + $loyalty_points;
										
										//echo " campagin_loyalty_points  in this transaction----".$campagin_loyalty_points ."<br>"; 
										
										}
											
											$prd_array['Loyalty_points'] = $campagin_loyalty_points;
														
											$purchase_item_details[] = $prd_array;
													
										if($itemCode != "")
										{
											if($Company_type != "Bank" ) //**** if not bank ********
											{
												$item_info12 = lslDB::getInstance()->get_pos_item_details($itemCode,$Company_id);
											$item_check12 = mysqli_num_rows($item_info12);

												while($res32 = mysqli_fetch_array($item_info12))
												{
													$Item_name = $res32['Item_name'];			
													$Item_group_code = $res32['Product_group_code']; 	
													$Item_brand_code = $res32['Product_brand_code'];
													$Item_priceB = $res32['Item_price'];
													$Item_vatB = $res32['Item_vat'];
												}
											}
												
												if($PaymentBy == 8)
												{
													$Item_vatB = 0;
												}
												
												$itemPrice = $Item_priceB * $itemQty_array[$kp];
												$itemVat = ($itemPrice/100) * $Item_vatB;
												
												
												//echo "Item_group_code is---".$Item_group_code."<br>";
												//echo "Item_current_bal is---".$Item_current_bal."<br>";
												//echo "itemQty is---".$itemQty_array[$kp]."<br>";
												//echo "BalToPay by member is---".$BalToPay."<br>";
											//echo "campagin_loyalty_points by member is---".$campagin_loyalty_points."<br>"; 					
												//echo "item_check by item_check oooooo----xxxxxx---------is---".$item_check."<br>"; 
												
											//if($item_check > 0)
											
												$TransactionAmt = $Transaction_amount_array[$kp];
													//Points_award_flag
												$insert_transactionID = lslDB::getInstance()->insert_flatfile_transaction_details($Company_id,$Transaction_type,$Company_transaction_Type_array[$kp],$Transaction_channel_code_array[$kp],$lv_member_enrollid,$Membership_ID,
															$login_enroll_id,$user_email_id,$trans_date_array[$kp],$GiftCardID,$GiftRedeem,$BranchPin,$Item_group_code,$Item_brand_code,$itemCode,$itemQty_array[$kp],$Item_vatB,$TransactionAmt,$Item_priceB,
															$RedeemPoints,$RedeemAmt,$bonus_points,$campagin_loyalty_points,$BalToPay,$PaymentBy,$branch_code_array[$kp],$BillNo,$source,$Cheque,$BankName,$Remark,$EmployeeID,$MemberPin,$mv_create_user_id,
																$mv_create_date,$Field_val_1_array[$kp],$Field_val_2_array[$kp],$Field_val_3_array[$kp],$Field_val_4_array[$kp],$Field_val_5_array[$kp]);
										
												
												if($campagin_loyalty_points > 0)
												{
													$Transaction_Date = date("Y-m-d",strtotime($trans_date_array[$kp]));
													
												$myquery55 = "Update lsl_transaction_child set Transaction_id='".$insert_transactionID."' where Transaction_id='0' AND Enrollment_id='".$lv_member_enrollid."' and Date='".$Transaction_Date."' and Company_id=".$Company_id;
									//echo "<br>the update transaction child tbl end query-----".$myquery55."<br>";	
														$update_child = mysqli_query($conn,$myquery55);
												}
												
												$item_balance = $Item_current_bal - $itemQty_array[$kp];
												
												if($Company_type != "Bank" ) //**** if not bank ********
												{
													$update_item = lslDB::getInstance()->update_item_quantity($itemCode,$Item_branch_code,$Company_id,$item_balance);
														
													if($item_balance == $Item_threshold_balance) //**** check threshold balance and send notification*******
													{
														$sendNotification1 = lslDB::getInstance()->send_threshold_mail($Company_id,$login_enroll_id,$item_balance,$itemCode,$branch_code_array[$kp]);
													} 
												}	
												
												if($Discount_applicable == 1)
												{
												
													 $discountval = ($TransactionAmt/100) * $CompDiscount;
													
													 $discountamt = $TransactionAmt - $discountval;
													
													$itemVat = ($TransactionAmt/100) * $Item_vatB;
													
													$grand_total =  $itemVat + $discountamt;
													$BalToPay = $grand_total;
												}
														
												if(!in_array($BillNo,$LastBillNo) )//$LastBillNo != $BillNo)
												{
													$Sumry_transacion_id = lslDB::getInstance()->insert_loyalty_transaction_summery($Company_id,$Transaction_type,$Company_transaction_Type_array[$kp],$Transaction_channel_code_array[$kp],$lv_member_enrollid,$Membership_ID,
																					$login_enroll_id,$user_email_id,$trans_date_array[$kp],$GiftCardID,$GiftRedeem,$BranchPin,$TransactionAmt,$RedeemPoints,$RedeemAmt,
																					$bonus_points,$campagin_loyalty_points,$BalToPay,$PaymentBy,$branch_code_array[$kp],$BillNo,$source,"",$Cheque,$BankName,$Remark,$EmployeeID,$MemberPin,$discountval,$discountamt,$mv_create_user_id,$mv_create_date,$insertFlag); 
														
													$LastBillNo[$d++] = $BillNo;
													$LastMembership_id[$p++] = $Membership_ID;	
													$TransactionKey[$BillNo] = $Sumry_transacion_id;
													$Last_grand_total[$BillNo] = $TransactionAmt;
													$Last_loyalty_points[$BillNo] = $campagin_loyalty_points;				
													$Last_BalToPay[$BillNo] = $BalToPay;	

													$recipt_Last_grand_total12 = $TransactionAmt;
													$recipt_Last_loyalty_points12 = $campagin_loyalty_points;
													$recipt_Last_BalToPay12	= $BalToPay;
													$recipt_Last_loyalty_points	= $campagin_loyalty_points;
												}
												else if((in_array($BillNo,$LastBillNo)) && (in_array($Membership_ID,$LastMembership_id)))
												{
													$Update_transacion_id = $TransactionKey[$BillNo];
														//echo "inside update funt";
													$Last_grand_total12 = $Last_grand_total[$BillNo] + $TransactionAmt;
													$Last_loyalty_points12 = $Last_loyalty_points[$BillNo] + $campagin_loyalty_points;
													$Last_BalToPay12 = $Last_BalToPay[$BillNo] + $BalToPay;

													$Update_transactionID45 = lslDB::getInstance()->update_loyalty_transaction_summery($Update_transacion_id,$Company_id,$Last_grand_total12,$Last_loyalty_points12,$Last_BalToPay12);
													
													$recipt_Last_grand_total12 = $Last_grand_total12;
													$recipt_Last_loyalty_points12 = $Last_loyalty_points12;
													$recipt_Last_BalToPay12	= $Last_BalToPay12;
													$recipt_Last_loyalty_points	= $Last_loyalty_points12;
												}
												

												
													//$LastBillNo = $BillNo;
													//$LastMembership_id = $Membership_ID;
													
												if($lv_parent_enrollid > 0) //***** update family parent balance*****
												{

													$parent_info = lslDB::getInstance()->get_user_details($lv_parent_enrollid,$Company_id);
													while($res6 = mysqli_fetch_array($parent_info))
													{
														$user_email_id =$res6['User_email_id'];
														$loguserid = $res6['User_type_id'];			
														$user_pin = $res6['Pin']; 	
														$branch_code = $res6['Branch_code'];
														$mv_member_balance = $res6['Current_balance'];
														$mv_purchase_amount = $res6['Total_purchase_amount'];
														$mv_bonus_points = $res6['Total_bonus_points'];
														$mv_redeem_points = $res6['Total_redeem_points'];
														$mv_gained_points = $res6['Total_gained_points'];
													}		
													$Parent_Member_balance = $mv_member_balance - $RedeemPoints;
													$Parent_Member_redeem = $mv_redeem_points + $RedeemPoints;
													$Parent_Member_purchase = $mv_purchase_amount + $BalToPay;
													$Parent_Member_loyalty_points = $mv_gained_points + $campagin_loyalty_points;
													$Parent_Member_balance = $Parent_Member_balance + $campagin_loyalty_points;
													
													$update_memberbal =  lslDB::getInstance()->update_member_balance_details($lv_parent_enrollid,$Parent_Member_balance,$Parent_Member_redeem,$Parent_Member_purchase,$Parent_Member_loyalty_points,$Company_id);
												}

													$Member_balance = $lv_member_balance - $RedeemPoints;
													$Member_redeem = $lv_redeem_points + $RedeemPoints;
													$Member_purchase = $lv_purchase_amount + $BalToPay;
													$Member_loyalty_points = $lv_gained_points + $campagin_loyalty_points;
													$Member_balance = $Member_balance + $campagin_loyalty_points;
													
													//echo "the Member Balance  --".$Member_balance."<br>";
											//echo "the Parent_company_id --".$Parent_company_id."<br>";
												$update_memberbal =  lslDB::getInstance()->update_member_balance_details($lv_member_enrollid,$Member_balance,$Member_redeem,$Member_purchase,$Member_loyalty_points,$Company_id);
												
												$company_balance = $company_current_balance - $campagin_loyalty_points;
												$company_current_balance = $company_balance;
											
												$update_compbal =  lslDB::getInstance()->update_company_balance($Company_id,$company_balance);
												
												/* if($company_balance < 1000)
												{
													$getAdmin = mysqli_query($conn,"Select * from lsl_enrollment_master where Company_id=$Company_id and User_type_id in (4,9)");
													while($rowAdmin = mysqli_fetch_array($getAdmin))
													{
														$useremail = $rowAdmin['User_email_id'];
														
														$sendNotif = lslDB::getInstance()->send_company_balance_threshold_mail($Company_id,$company_balance,$useremail);
													}
												} */
												  
												if($Solution_type == 3)
												{
													if($Parent_company_id != 0 && ($company_current_balance <= $Company_Threshold_amount) )
													{
														$Template_type_id = 49;
														$Email_type = 294;	
														
														$SQL223 = "SELECT Enrollment_id FROM lsl_enrollment_master 
																  WHERE Company_id='".$Parent_company_id."'
																  AND Child_company_id='".$Company_id."' 
																  AND User_type_id='4' ";
														$RESULT223 = mysqli_query($conn,$SQL223);
														while($rows223 = mysqli_fetch_array($RESULT223))
														{
															$sendNotif = lslDB::getInstance()->send_coalition_points_threshold_template($rows223['Enrollment_id'],$Company_id,$Parent_company_id,$company_current_balance,$Company_Threshold_amount,$Email_type,$Template_type_id);
														}
													}
												}
												
												/* if($GiftCardFlag == 1)  //***** update gift card balance ********************
												{
													$balance =	$GiftCardBal - $GiftRedeem;

												$update_gift_bal = lslDB::getInstance()->update_giftcard_details($GiftCardID,$Company_id,$balance);
												}
													 */	

											$UPDATE_BillNo = $BillNo + 1;
											$update_bill = lslDB::getInstance()->update_branch_details($branch_code_array[$kp],$Company_id,$UPDATE_BillNo);
											
											//echo "Communication_flag---".$Communication_flag."<br>";
										//	echo "campagin_loyalty_points---".$campagin_loyalty_points."<br>";
												/****************Send Email****************/
												if($Communication_flag == 1)
												{
													$Template_type_id = 10;
													$Email_Type = 13;  //****Transaction**
													
													$template = lslDB::getInstance()->fetch_email_template_details($Company_id,$Email_Type,$Template_type_id);
													$template_details = mysqli_fetch_assoc($template);
													
													//var_dump($template_details);
													
													if($template_details != NULL)
													{
														//echo "Type of COmpany is -->".$Company_type;
														
														if($Company_type == "Bank" )
														{
															
															//echo "Type of COmpany is Bank -->".$Company_type;
															$transaction_email_template = lslDB::getInstance()->send_Banktransaction_loyalty_email_template($lv_member_enrollid,$Company_id,$login_enroll_id,$BillNo,$trans_date_array[$kp],$insert_transactionID,$Email_Type,$Template_type_id);
														}
														else 
														{
															$insertFlag = 0;
															
															$transaction_email_template = lslDB::getInstance()->send_transaction_loyalty_email_template($lv_member_enrollid,$Company_id,$login_enroll_id,$BillNo,$trans_date_array[$kp],$insert_transactionID,$Email_Type,$Template_type_id,$insertFlag);
														}
													}
													
													// die;
													
													if($Credit_transaction_sms == 1)
													{
													$SMS_Type = 13;  //****Transaction**
													$transaction_email_template = lslDB::getInstance()->send_transaction_loyalty_sms_template($lv_member_enrollid,$Company_id,$login_enroll_id,$BillNo,$trans_date_array[$kp],$insert_transactionID,$SMS_Type,$Template_type_id);
													}
												}
												/****************Send Email End****************/
											
											//$mailsend = lslDB::getInstance()->send_transaction_mail($Company_id,$login_enroll_id,$GiftCardID,$Transaction_type);
											
											//**** *****************************************--log entry--***************************************** *****
													$lv_user_detail = lslDB::getInstance()->get_user_details($mv_create_user_id,$loguser_company_id);
													while($lsl_rows1=mysqli_fetch_array($lv_user_detail))
													{
														$lv_fname=$lsl_rows1['First_name'];
														$lv_mname=$lsl_rows1['Middle_name'];
														$lv_lname=$lsl_rows1['Last_name'];
														$lv_enrollid = $lsl_rows1['Enrollment_id'];
														$lv_userid = $lsl_rows1['User_type_id'];
														$lv_emailid = $lsl_rows1['User_email_id'];
														
														$lv_fullname = $lv_fname." ".$lv_mname." ".$lv_lname;
													}
											
												$mv_opration = 1; 
												
												$mv_TranType = "Flat File Transaction";
												$mv_Tranfrom = "Flat File Transaction By API";
												
												$mv_opval = $grand_total;
												
											$InsertLOG=lslDB::getInstance()->getLOG($Company_id,$mv_create_user_id,$lv_emailid,$lv_fullname,$mv_create_date,$mv_TranType,$mv_Tranfrom,$lv_userid,$mv_opration,$lv_member_name,$lv_member_enrollid,$mv_opval);
											//**** --log entry-- *****
											
										}
										$kp++;		
									}
									
									if($Transaction_flag == 5)
									{
										$drop_temp = "DROP table $temp";
										mysqli_query($conn,$drop_temp);
									}
									
									$querypp = "select Payment_type_id ,Payment_type_name from lsl_payment_type_master where Payment_type_id='".$PaymentBy."' ";
										$resultp = mysqli_query($conn,$querypp);
				
										while ($rowp = mysqli_fetch_assoc($resultp))
										{
											$Payment_type_name = $rowp['Payment_type_name'];
										}
										
									if($Transaction_flag == 4)
									{
										$transaction_output = array();											
													
											$transaction_output["status"] = '1001';	
											$transaction_output["Membership_ID"] = $Membership_ID;
											$transaction_output["BillNo"] = $BillNo;									
											$transaction_output["Branch_name"] = $Branch_name;
											$transaction_output["Branch_Address"] = $Branch_Address;
											$transaction_output["Transaction_date"] = $trans_date;
											$transaction_output["Total_amount"] = $recipt_Last_grand_total12;
											$transaction_output["Total_vat"] = 0;
											$transaction_output["Grand_total"] = $recipt_Last_grand_total12;
											$transaction_output["Total_balance_paid"] = $recipt_Last_BalToPay12;
											
											$transaction_output["Payment_by"] = $Payment_type_name;
											$transaction_output["Total_loyalty_points"] = $recipt_Last_loyalty_points;
													
											$transaction_output["Remarks"] = $Remark;
											$transaction_output["Purchase_item_details"] = $purchase_item_details;								
											$transaction_output["status_message"] = "Success";								
				
											echo json_encode($transaction_output);
											exit; 
										
									}
									
									if($error_status > 0)
									{
										 echo json_encode(array("status" => "2082", "status_message" => "Transaction Flat File Successfully Uploaded, However some Errors found. 
Please check the Error details on File Upload Status Report !"));
										 exit;
									}
									else
									{
										echo json_encode(array("status" => "1001", "status_message" => "Success"));
										
										exit;
									}

							}
						}
					}
				}
		/********************* Flat FIle Loyalty Transaction ***********************/
                                
                /************************************Verify CashierPin********************************/
                if($API_flag == 52)  //***check System user pin
                {
                    if($_REQUEST['Username'] == "" || $_REQUEST['Password'] == "")
                    {
                        echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
						exit;
                    }
                    else
                    {
                        $Username = trim(string_decrypt($_REQUEST['Username'],$key, $iv));
                        $Username = preg_replace("/[^(\x20-\x7f)]*/s", "",$Username);

                        $Password = trim(string_decrypt($_REQUEST['Password'],$key, $iv));
                        $Password = preg_replace("/[^(\x20-\x7f)]*/s", "",$Password);
						
						 $BranchUser_Pin = trim(string_decrypt($_REQUEST['BranchUser_Pin'],$key, $iv));
                        $BranchUser_Pin = preg_replace("/[^(\x20-\x7f)]*/s", "",$BranchUser_Pin);

                        $query1 = "SELECT * FROM lsl_enrollment_master "
                                . "WHERE User_email_id='".$Username."' "
                                . "AND Password ='".$Password."' "
                                . "AND User_type_id <> 1 "
                                . "AND Company_id='".$Company_id."' ";
                        $member_details_result = mysqli_query($conn,$query1);
                        $member_details =mysqli_fetch_array($member_details_result);

                        if($member_details == NULL)
                        {
                            echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
							exit;
                        }
                        else
                        {
                            if($member_details['Active_flag'] == 0)
                            {
                                echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								exit;
                            }
                            else
                            {
                                if ($member_details['Pin']  == $BranchUser_Pin)
                                {                              
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
									exit;
                                }
                                else 
                                {
                                    echo json_encode(array("status" => "2065", "status_message" => "Invalid Cashier Pin"));
									exit;
                                }
                            }
                        }
                    }
                }
                /************************************Verify Cashier Pin********************************/
                
                /************************************Fetch Catalogue Categories********************************/
                    if($API_flag == 53)
                    {
                        $query1 = "SELECT DISTINCT CM.Merchandize_category_id,MC.Merchandize_category_name FROM lsl_company_merchandise_catalogue as CM,lsl_merchandize_category as MC "
                                . "WHERE CM.Merchandize_category_id=MC.Merchandize_category_id AND CM.Company_id='".$Company_id."' AND CM.Active_flag=1 AND CM.Approved_flag = 1 ";
                        $Catlogue_result = mysqli_query($conn,$query1);
                        $Catglogue_count = mysqli_num_rows($Catlogue_result);
                        
                        if($Catglogue_count > 0)
                        {
                            while($Catlogue = mysqli_fetch_array($Catlogue_result))
                            {
                                $Category_details[] = array(
                                                    "Merchandize_category_id" => $Catlogue['Merchandize_category_id'],
                                                    "Merchandize_category_name" => $Catlogue['Merchandize_category_name']
                                                );
                            }
                            
                            $Status_array = array("status" => "1001", "Category_category_details" => $Category_details, "status_message" => "Success");
                            echo json_encode($Status_array);
                        }
                        else
                        {
                            echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                        }
                    }
                    /************************************Fetch Categories********************************/
		
            }
            else
            {
                echo json_encode(array("status" => "2002", "status_message" => "Wrong Company Password"));
				exit;
            }
    }
    else
    {
            echo json_encode(array("status" => "2001", "status_message" => "Wrong Company Username"));
			exit;
    }
}



//***********************Functions***************************
/*function string_encrypt($string, $key)
{
	$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
	$padding = $block - (strlen($string) % $block);
	$string .= str_repeat(chr($padding), $padding);

    $crypted_text = mcrypt_encrypt
					(
						MCRYPT_RIJNDAEL_128, 
						$key, 
						$string, 
						MCRYPT_MODE_ECB
					);
    return base64_encode($crypted_text);
}

function string_decrypt($encrypted_string, $key)
{
    return mcrypt_decrypt
	(
		MCRYPT_RIJNDAEL_128, 
		$key, 
		base64_decode($encrypted_string), 
		MCRYPT_MODE_ECB
	);
}*/

function getExtension($str) 
{
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}

function string_encrypt($string, $key, $iv)
{
    $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $padding = $block - (strlen($string) % $block);
    $string .= str_repeat(chr($padding), $padding);

    $crypted_text = mcrypt_encrypt
                    (
                        MCRYPT_RIJNDAEL_256, 
                        $key, 
                        $string, 
                        MCRYPT_MODE_CBC, $iv
                    );
    return base64_encode($crypted_text);
}
function string_decrypt($encrypted_string, $key, $iv)
{
    return mcrypt_decrypt
            (
                MCRYPT_RIJNDAEL_256, 
                $key, 
                base64_decode($encrypted_string), 
                MCRYPT_MODE_CBC, $iv
            );
}

function getRandomString($length = 16) 
{
    $characters = 'A123B56C89';
    $string = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function getRandomString1($length = 10) 
{
    $characters = 'A123B56C89';
    $string = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function getRandomString2($length = 4) 
{
    $characters = '0123456789';
    $string = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function getRandomString3($length = 10) 
{
    $characters = '0123456789abcde';
    $string = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function getRandomString4($length = 4) 
{
    $characters = '0123456789abcde';
    $string = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function check_voucher($Company_id,$Voucher_no)
{
    $sql123 = "SELECT * FROM lsl_transaction "
            . "WHERE Company_id='".$Company_id."' "
            . "AND Voucher_no='".$Voucher_no."' ";
    $result123 = mysqli_query($conn, $sql123);
    return mysqli_num_rows($result123);
}

function validatePIN($pinno,$Company_id) 
{
    include("connect_db.php");    
    $lv_query88 = "SELECT * FROM lsl_enrollment_master WHERE Company_id IN (".$Company_id.",1) and Pin='".$pinno."' ";										
    $lv_result88 = mysqli_query($conn,$lv_query88);
    
    if(mysqli_num_rows($lv_result88) == 0)
    {
        $New_Pin = $pinno;
    }
    else
    {
        do
        {
            $New_Pin = getRandomString4();
        }
        while(mysqli_num_rows($lv_result88) == 0);
    }
    return $New_Pin;
}

function getUrls($string)
{
    $regex = '/https?\:\/\/[^\" ]+/i';
    preg_match_all($regex, $string, $matches);
    return ($matches[0]);
}

function weeks($month, $year)
{
		$firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
	$count_weeks = 1 + ceil(($lastday-7+$firstday)/7);
	return $count_weeks;
} 


/*function insert_api_error($Error_time,$Request,$Response)
{
    $api_error_sql = "INSERT INTO lsl_api_data(Send_time,Request_data,Response_data) VALUES('".$Error_time."','".$Request."','".$Response."')";
    $Result = mysqli_query($conn, $api_error_sql);
}*/
?> 