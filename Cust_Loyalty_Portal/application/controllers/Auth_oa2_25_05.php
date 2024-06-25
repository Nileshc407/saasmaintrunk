<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_oa2 extends CI_Controller
{
    public function session($provider_name)
    {
        $this->load->library('session');
        $this->load->helper('url_helper');
        $this->load->library('oauth2/OAuth2');
		$this->load->config('oauth2', TRUE);		
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('login/Login_model');

        $provider = $this->oauth2->provider($provider_name, array(
            'id' => $this->config->item($provider_name.'_id', 'oauth2'),
            'secret' => $this->config->item($provider_name.'_secret', 'oauth2'),
        ));
 
		$Company_id12='3';
		$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id12);
		foreach($data["Company_details"] as $cmpdtls)
		{
			$Partner_company_flag=$cmpdtls['Partner_company_flag'];
			$Parent_company=$cmpdtls['Parent_company'];
		}
		$data["Company_partner_cmp"] = $this->Igain_model->Fetch_Company_Details($Parent_company);
        if (! $this->input->get('code'))
        {
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                //$token = $provider->access($_GET['code']);
                $token = $provider->access($this->input->get('code'));

                $user = $provider->get_user_info($token);
				
				$provider_name=$provider_name;
				 $uid=$user['uid'];
				
				if($provider_name=='google')
				{
					 $first_name=$user['first_name'];
				}
				else
				{
					 $first_name1=$user['name'];
					 $first_name=substr($first_name1, 0, strrpos($first_name1, ' '));
				}
				
				 $last_name=$user['last_name'];
				 $email=$user['email'];
					$check_email = $this->Igain_model->Check_EmailID($email,$Company_id12);
					if($check_email == '0')
					{
						$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id12);
						foreach($data["Company_details"] as $CMPDetls)
						{
							$card_decsion=$CMPDetls['card_decsion'];
							$next_card_no=$CMPDetls['next_card_no'];
							$Company_name=$CMPDetls['Company_name'];						
							$Pin_no_applicable=$CMPDetls['Pin_no_applicable'];	
							$Joining_bonus=$CMPDetls['Joining_bonus'];
							$Joining_bonus_points=$CMPDetls['Joining_bonus_points'];
							$Seller_topup_access=$CMPDetls['Seller_topup_access'];
						}
						if($card_decsion == '1')
						{
							/********Joining Bonus*****************/			
							if($Joining_bonus==1)
							{
								$Current_balance=$Joining_bonus_points;
								$Total_topup_amt=$Joining_bonus_points;
							}
							else
							{
								$Current_balance=0;
								$Total_topup_amt=0;
							}
							/******Joining Bonus************/
							
							$card_id=$next_card_no;	
							$Card_id1=$card_id+1;
							$UpdateCardID = $this->Igain_model->UpdateCompanyMembershipID($Card_id1,$Company_id12);	
						}
						else
						{
							$card_id='0';
						}
						if($Pin_no_applicable=='1')
						{
							$pinno = $this->getRandomString();
						}
						else
						{
							$pinno='0';
						}										
						$password = $this->getRandomString();					
						$joined_date=date('Y-m-d');						
						$Enroll_array = array(					
							'First_name' => $first_name,
							'Last_name' => $last_name,
							'User_email_id' => $email,        
							'User_pwd' => $password,       
							'pinno' => $pinno,
							'User_activated' => '1',
							'Company_id' => $Company_id12,
							'User_id' => '1',
							'Card_id' => $card_id,
							'joined_date' => $joined_date,
							'source' => $provider_name
							);						
							$Enrollment_ID = $this->Igain_model->insert_enroll_details($Enroll_array);
							$Email_content = array(
							'Notification_type' => 'Enrollment Details',
							'Template_type' => 'Enroll'
							);
							$this->send_notification->send_Notification_email($Enrollment_ID,$Email_content,'0',$Company_id12);
							
							
							/************************************Joining Bonus**************************************************/
								
								// $company_details = $this->Igain_model->get_company_details($Company_id12);
								

								
								if($card_decsion==1)
								{
								
									$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id12);
									$seller_id=$Super_Seller_details->Enrollement_id;
									$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
									$seller_curbal = $Super_Seller_details->Current_balance;
									$top_db2 = $Super_Seller_details->Topup_Bill_no;
									$len2 = strlen($top_db2);
									$str2 = substr($top_db2,0,5);
									$tp_bill2 = substr($top_db2,5,$len2);						
									$topup_BillNo2 = $tp_bill2 + 1;
									$billno_withyear_ref = $str2.$topup_BillNo2;

								
									// $Card_id=$company_details->next_card_no;
									// $nestcard1=$Card_id+1;
									
									if($Joining_bonus==1)
									{
										$Current_balance=$Joining_bonus_points;
										$Total_topup_amt=$Joining_bonus_points;
									/* }
									else
									{
										$Current_balance=0;
										$Total_topup_amt=0;
									}														
									if($Joining_bonus==1)
									{ */
										$Todays_date = date("Y-m-d");
										$post_Transdata = 
											array
												( 	
													'Trans_type' => '1',
													'Company_id' => $Company_id12,
													'Topup_amount' => $Joining_bonus_points,        
													'Trans_date' => $Todays_date,       
													'Remarks' => 'Joining Bonus',
													'Card_id' => $card_id,
													'Seller_name' =>$Seller_name ,
													'Seller' => $seller_id,
													'Enrollement_id' => $Enrollment_ID,
													'Bill_no' => $tp_bill2,
													'remark2' => 'Super Seller',
													'Loyalty_pts' => '0'
												);					
										
										$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
										$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
										if($Seller_topup_access=='1')
										{										
											$Total_seller_bal = $seller_curbal-$Joining_bonus_points;										
											$result3 = $this->Igain_model->update_seller_balance($seller_id,$Total_seller_bal);
										}
										$Email_content12 = array(
											'Joining_bonus_points' => $Joining_bonus_points,
											'Notification_type' => 'Joining Bonus',
											'Template_type' => 'Joining_Bonus',
											'Todays_date' => $Todays_date
										);									
										$this->send_notification->send_Notification_email($Enrollment_ID,$Email_content12,$seller_id,$Company_id12);
									}
								}
								/******************************Joining Bonus***********************************************/
							
							$this->session->set_flashdata("login_success","Your Login Credentials Sent on Your Email Id Please  Check it !!");						
							// 
					}
					else
					{
						$this->session->set_flashdata("login_success","This User Email Id Already Registered with Us!!");
					}
					// $this->load->view('login/login', $data);	
					redirect('login', 'refresh');


            }
            catch (OAuth2_Exception $e)
            {
                // show_error('That didnt work: '.$e);
				$this->session->set_flashdata("login_success","Invalid Data Provide.!!");
				redirect('login', 'refresh');
            }

        }
    }
	public function getRandomString($length = 4) 
	{
		$characters = '0123456789';
		$string = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		return $string;
	}	
	}

/* End of file auth_oa2.php */
/* Location: ./application/controllers/auth_oa2.php */