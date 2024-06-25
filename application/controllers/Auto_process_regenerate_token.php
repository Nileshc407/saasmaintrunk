<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* PHPMailer Include files */
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	include APPPATH . 'third_party/vendor/autoload.php';
/* PHPMailer Include files */
error_reporting(0);
class Auto_process_regenerate_token extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();				
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('user_agent');
		$this->load->library('Send_notification');
	} 
	public function index()
	{
		if ($this->agent->is_browser())
		{
				$agent = $this->agent->browser().' '.$this->agent->version();
				echo $agent;
				die;
		}
		
		// echo "<pre>";
		$todays = date("Y-m-d H:i:s");
		// $todays ='2022-07-15 23:23:59';
		// echo "todays ------".$todays."<br>";
		
		// $token_result['error'];
		
		
		$token_result['error']="valid_request";
		$error="";
		$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details();
		// print_r($thirdparty_details);
		// echo"<br>";
		
		// $id=$thirdparty_details->id;
		// $update_date=$thirdparty_details->update_date;
		
		
		// echo "id ------".$thirdparty_details->id."<br>";
		// echo "grant_type ------".$thirdparty_details->grant_type."<br>";
		// echo "refresh_token ------".$thirdparty_details->refresh_token."<br>";
		// echo "client_id ------".$thirdparty_details->client_id."<br>";
		// echo "client_secret ------".$thirdparty_details->client_secret."<br>";
		// echo "token ------".$thirdparty_details->token."<br>";
		// echo "token_generate_url ------".$thirdparty_details->token_generate_url."<br>";
		// echo "username ------".$thirdparty_details->username."<br>";
		// echo "update_date------".$update_date."<br>";
		
		
		foreach($thirdparty_details as $tdetails){
				
			// echo "type ------".$tdetails['type']."<br>";
			
			 if($tdetails['type'] ==1 ) { //Staging Enviornment
			
			
				// echo "---Staging Enviornment--<br><br>";
			
				$postArray=array(
				
					"grant_type"=>$tdetails['grant_type'],
					"refresh_token"=>$tdetails['refresh_token'],
					"client_id"=>$tdetails['client_id'],
					"client_secret"=>$tdetails['client_secret']
				);			
				// echo 'Authorization: Bearer '.$tdetails['token'].'<br>';
				// print_r($postArray);			
				$postArray=json_encode($postArray,true);
				 // print_r($postArray);			
				// die;
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $tdetails['token_generate_url'].'/'.$tdetails['username'],
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>$postArray,
				  CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.$tdetails['token'].'',
					'Content-Type: application/json'
				  ),
				));

				$response = curl_exec($curl);
				curl_close($curl);
				// echo $response;
				
				$token_result=json_decode($response, true);
				// print_r($token_result);
				if($token_result['error']){
					$error=$token_result['error'];
				} else {
					$error='';
				}
				
				$Staging_access_token=$token_result['access_token'];
				$Staging_expires_in=$token_result['expires_in'];
				$Staging_refresh_token=$token_result['refresh_token'];
				
				// echo "error ------".$error."---<br><br>";
				// echo "Staging_access_token ------".$Staging_access_token."---<br><br>";
				// echo "Staging_expires_in ------".$Staging_expires_in."---<br><br>";
				// echo "Staging_refresh_token ------".$Staging_refresh_token."---<br><br>";
				
				if($error == ''){
					
					if( !empty($Staging_access_token) && !empty($Staging_expires_in) && !empty($Staging_refresh_token)){
						
						// echo "error ------".$error."---<br><br>";
						
						$updateData=array(
							'refresh_token'=>$Staging_refresh_token,
							'token'=>$Staging_access_token,
							'update_date'=>date('Y-m-d H:i:s')
						);
						
						$thirdparty_details_update = $this->Igain_model->update_thirdparty_details($tdetails['id'],$tdetails['type'],$updateData);
						
						// echo "----thirdparty_details_update----".var_dump($thirdparty_details_update);
						// echo "----last_query --thirdparty_details_update----".$this->db->last_query();
						// echo $thirdparty_details_update;
					}
				} else {
					echo $error;
				}	
			} 
			if($tdetails['type'] == 2 ) {  //Production Enviornment
				
				// echo "---Production Enviornment--<br><br>";
				
				
				/* echo "id ------".$tdetails['id']."<br>";
				echo "grant_type ------".$tdetails['grant_type']."<br>";
				echo "refresh_token ------".$tdetails['refresh_token']."<br>";
				echo "client_id ------".$tdetails['client_id']."<br>";
				echo "client_secret ------".$tdetails['client_secret']."<br>";
				echo "token ------".$tdetails['token']."<br>";
				echo "token_generate_url ------".$tdetails['token_generate_url']."<br>";
				echo "username ------".$tdetails['username']."<br>";
				echo "update_date------".$tdetails['update_date']."<br>"; */
				
				
				
				$postArray=array(
				
					"grant_type"=>$tdetails['grant_type'],
					"refresh_token"=>$tdetails['refresh_token'],
					"client_id"=>$tdetails['client_id'],
					"client_secret"=>$tdetails['client_secret']
				);			
				
				// print_r($postArray);			
				$postArray=json_encode($postArray,true);
				// print_r($postArray);			
				// die;
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $tdetails['token_generate_url'].'/'.$tdetails['username'],
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>$postArray,
				  CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.$tdetails['token'].'',
					'Content-Type: application/json'
				  ),
				));

				$response = curl_exec($curl);
				curl_close($curl);
				// echo $response;
				
				$token_result=json_decode($response, true);
				//print_r($token_result);
				if($token_result['error']){
					$error=$token_result['error'];
				} else {
					$error='';
				}
				
				$Production_access_token=$token_result['access_token'];
				$Production_expires_in=$token_result['expires_in'];
				$Production_refresh_token=$token_result['refresh_token'];
				
				// echo "error ------".$error."---<br><br>";
				// echo "Production_access_token ------".$Production_access_token."---<br><br>";
				// echo "Production_expires_in ------".$Production_expires_in."---<br><br>";
				// echo "Production_refresh_token ------".$Production_refresh_token."---<br><br>";
				
				if($error == ''){
					
					if( !empty($Production_access_token) && !empty($Production_expires_in) && !empty($Production_refresh_token)){
						
						// echo "error ------".$error."---<br><br>";
						
						$updateData=array(
							'refresh_token'=>$Production_refresh_token,
							'token'=>$Production_access_token,
							'update_date'=>date('Y-m-d H:i:s')
						);
						
						$thirdparty_details_update1 = $this->Igain_model->update_thirdparty_details($tdetails['id'],$tdetails['type'],$updateData);
						// echo "----thirdparty_details_update1----".var_dump($thirdparty_details_update1);
						// echo "---last_query --thirdparty_details_update1----".$this->db->last_query();
						// echo $thirdparty_details_update1;
						
					}
					
				} else {
					
					echo $error;
				}
				
			}		
		}	
		
		// Send mail about regenerate token and refresh token
		if($thirdparty_details_update || $thirdparty_details_update1){
			
			/* echo "<br><br>----thirdparty_details_update----".$thirdparty_details_update;
			echo "<br><br>----thirdparty_details_update1----".$thirdparty_details_update1;
			
			
			echo "<br><br>----@@@@@@@---Staging-----@@@@@@@----<br><br>";
			
			echo "<br><br>---Staging_access_token ------".$Staging_access_token."---";
			echo "<br><br>---Staging_expires_in ------".$Staging_expires_in."---";
			echo "<br><br>---Staging_refresh_token ------".$Staging_refresh_token."---";
			
			echo "<br><br>----@@@@@@@---Production-----@@@@@@@----<br><br>";
			
			echo "Production_access_token ------".$Production_access_token."---<br><br>";
			echo "Production_expires_in ------".$Production_expires_in."---<br><br>";
			echo "Production_refresh_token ------".$Production_refresh_token."---<br><br>"; */
			
				$Email_content = array(
					'Notification_type' => 'Xoxoday regenerated access and refresh token!!!',
					'Staging_refresh_token' => $Staging_refresh_token,
					'Staging_access_token' => $Staging_access_token,
					'Production_refresh_token' => $Production_refresh_token,
					'Production_access_token' => $Production_access_token,
					'User_email_id' => 'rakesh@miraclecartes.com',
					'Customer_name' => 'Rakesh Jadhav',
					'Template_type' => 'Regenerated_tokens'
				);
		
		
			$Notification=$this->send_notification->send_Notification_email(0,$Email_content,'1','1');	
		}	
	}
}	
?>