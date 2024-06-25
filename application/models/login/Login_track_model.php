<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_track_model extends CI_Model {   
	
	function check_login_track($Company_id,$email)
    {	
	
		$loginFlag=0;
		$lv_date_time=date('Y-m-d');
		$query = 'SELECT * FROM igain_failed_login WHERE  User_email_id = "'.$email.'" AND  Company_id = "'.$Company_id.'" AND  DATE(Login_date) = "'.$lv_date_time.'" AND Success_flag =1';		
		// $login_sql = $this->db->get();
		$login_sql = $this->db->query($query);
		// echo $this->db->last_query()."---<br>";
		// echo "<br>--check_login_track---".$this->db->last_query()."----<br>";
		 return $login_sql -> num_rows();
				    
    } 
	function validate_user($username)
    {	
		
		$this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Top_up_menu, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Seller_topup_access, E.Current_balance,C.Localization_flag ,C.Localization_logo,C.Company_logo,C.Coalition,E.Photograph,C.Parent_company,C.Allow_membershipid_once,C.Allow_merchant_pin,Membership_redirection_url,Company_License_type,Comp_regdate');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_activated' => '1', 'E.User_email_id' => $username, 'E.User_id !=' => '1'));
		
		$login_sql = $this->db->get();
		// echo "<br>--validate_user---".$this->db->last_query()."----<br>";
		if($login_sql -> num_rows() == 1)
		{
			$login_result = $login_sql->result_array();	
			return  $login_result; //$login_sql->result_array();
		}
		else
		{
			return false;
		}		    
    }
		
	function get_ip_address() 
	{
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) 
		{
			if (array_key_exists($key, $_SERVER) === true) 
			{
				foreach (explode(',', $_SERVER[$key]) as $ip) 
				{
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) 
					{
						return $ip;
					}
				}
			}
		}
	}
	public function Insert_failed_login($CompanyID,$email,$password,$User_id,$starttime,$flag)
	{
		$this->load->library('user_agent');
		// $agent = $this->agent->browser().','.$this->agent->version();
		$agent=array("browser"=>$this->agent->browser(),"version"=>$this->agent->version());
		// echo"<br>---agent---".print_r($agent);
		$ip_address=$this->input->ip_address();
		
		// echo"<br>---ip_address---". $ip_address;
		// $ip = $this->get_ip_address();
		// echo"<br>---ip---". $ip;
		
		// $ip_address="202.65.145.150";
		// echo"<br>---Country---". $this->ip_info("202.65.145.150", "Country"); // India
		// echo"<br>---Country Code---". $this->ip_info("202.65.145.150", "Country Code"); // IN
		// echo"<br>---State---". $this->ip_info("202.65.145.150", "State"); // Andhra Pradesh
		// echo"<br>---City---". $this->ip_info("202.65.145.150", "City"); // Proddatur
		// echo"<br>---Address---". $this->ip_info("202.65.145.150", "Address")."<br>"; // Proddatur, Andhra Pradesh, India
		// echo"<br>---Location---". $this->ip_info("202.65.145.150", "Location"); // Proddatur, Andhra Pradesh, India

		$Location=$this->ip_info($ip_address,"Location"); 
		// print_r($Location); 		
		$Location=json_encode(array("ip_address"=>$ip_address,"Location"=>$Location,"Other"=>$agent));
		// print_r($Location); 		
		// die;		
		// $starttime = date('Y-m-d H:i:s', time());		
		$insert_data=array('Company_id' => $CompanyID,'User_email_id' => $email, 'Password' => $password, 'Login_date' => $starttime, 'User_id' => $User_id,'Source' => $flag,'Success_flag' =>1,'Fail_flag' =>1,'Location' =>$Location);
		$this->db->insert('igain_failed_login', $insert_data);
		// echo "<br>--Insert_failed_login---".$this->db->last_query()."----<br>";
		
		
		
	}
	public function update_failed_login($CompanyID,$email,$User_id)
	{
		
		$lv_date_time=date('Y-m-d');
		$update_data=array('Success_flag' => '0');
		$this->db->where(array('Company_id' => $CompanyID,'User_email_id' => $email,'DATE(Login_date)' => $lv_date_time, 'User_id' => $User_id));
		$this->db->update("igain_failed_login", $update_data);
		// echo "<br>--update_failed_login---".$this->db->last_query()."----<br>";
		
		
		
		
	}
	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}
}
?>
