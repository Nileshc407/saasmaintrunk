<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game_model extends CI_Model
{
	public function games_count()
	{
		return $this->db->count_all("igain_game_master");
	}
	
	
	public function company_games_list($limit,$start,$companyID)
	{
		$this->db->limit($limit,$start);
		$this->db->select("a.*,b.Game_name");
		$this->db->from("igain_game_company_master as a");
		$this->db->join("igain_game_master as b","a.Game_id = b.Game_id");
		$this->db->where(array("a.Company_id" =>$companyID, "a.Active_flag" => 1));
        $query = $this->db->get();
		
		
        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }

	}	
	
	
	public function edit_company_game($game_id)
	{
		$this->db->where('Company_game_id',$game_id);
		$queryopt1 = $this->db->get("igain_game_company_master");
		
		if ($queryopt1->num_rows() > 0)
		{	
        	foreach ($queryopt1->result() as $row111)
			{
                $data111[] = $row111;
            }
            return $data111;
        }
        return false;
	}
	
	
	public function get_company_games($compID)
	{
		$this->db->select("b.*,a.Company_game_id,a.Lives_flag");
		$this->db->from("igain_game_master as b");
		$this->db->join("igain_game_company_master as a","a.Game_id = b.Game_id");
		$this->db->where(array("a.Company_id" =>$compID, "a.Active_flag" => 1));
		
        $query13 = $this->db->get();
		
		
        if ($query13->num_rows() > 0)
		{
        	foreach ($query13->result() as $row132)
			{
                $data131[] = $row132;
            }
            
            return $data131;
        }
        
        return false;
     }
    
	
	public function company_games_campaign_list($limit,$start,$companyID)
	{
		$this->db->limit($limit,$start);
		$this->db->select("b.*,c.Game_name");
		$this->db->from("igain_campaign_master as b");
		$this->db->join("igain_game_campaign as a","a.Campaign_id = b.Campaign_id");
		$this->db->join("igain_game_master as c","a.Game_id = c.Game_id");
		$this->db->group_by("a.Campaign_id");
		$this->db->where(array("b.Company_id" =>$companyID));
		
		$res40 = $this->db->get();

		if($res40->num_rows() > 0)
		{
			foreach($res40->result() as $row40)
			{
				$dataRes[] = $row40;
			}
			
			return $dataRes;
		}

	}
	
	public function get_configured_games($companyID)
	{
		$this->db->select("b.Game_id,b.Game_name,c.Link_to_game_campaign");
		$this->db->from("igain_game_master as b");
		$this->db->join("igain_game_company_configuration as a","a.Game_id = b.Game_id");
		$this->db->join("igain_game_company_master as c","c.Game_id = b.Game_id");
		$this->db->group_by("a.Game_id");
		$this->db->where(array("a.Company_id" =>$companyID));
       
        $query23 = $this->db->get();

        if ($query23->num_rows() > 0)
		{
        	foreach ($query23->result() as $row23)
			{
                $data23[] = $row23;
            }
            return $data23;
        }

	}	
	
	public function get_games_byflag($company_ID,$gameFlag)
	{
		$todays = date("Y-m-d");
		
		if($gameFlag == 1)
		{
			$this->db->distinct();
			$this->db->select("c.Company_game_id,b.Game_id,b.Game_name");
			$this->db->from("igain_game_master as b");
			$this->db->join("igain_game_company_master as c","c.Game_id = b.Game_id");
			$this->db->where(array("c.Company_id" =>$company_ID,"c.Game_for_fun" => 1,"c.Active_flag" =>1));
		}
		
		if($gameFlag == 3)
		{
			$this->db->distinct();
			$this->db->select("c.Company_game_id,b.Game_id,b.Game_name");
			$this->db->from("igain_game_master as b");
			$this->db->join("igain_game_company_master as c","c.Game_id = b.Game_id");
			$this->db->where(array("c.Company_id" =>$company_ID,"c.Game_for_competition" => 1,"c.Active_flag" =>1));
		}
		
		if($gameFlag == 2)
		{
			$this->db->distinct();
			$this->db->select("c.Company_game_id,b.Game_id,b.Game_name");
			$this->db->from("igain_game_master as b");
			$this->db->join("igain_game_company_master as c","c.Game_id = b.Game_id");
			$this->db->join("igain_game_campaign as a","c.Company_game_id = a.Company_game_id");
			$this->db->join("igain_campaign_master as d","d.Campaign_id = a.Campaign_id");
			
			$this->db->where(array("c.Company_id" =>$company_ID,"c.Link_to_game_campaign" => 1,"c.Active_flag" =>1,"d.End_date >=" => $todays));
		}
		
		
		
		$query24 = $this->db->get();
		
		//echo $this->db->last_query();
		
        if ($query24->num_rows() > 0)
		{
        	foreach ($query24->result() as $row24)
			{
                $data24[] = $row24;
            }
            return $data24;
        }
        
	}
	
	public function play_game($Companyid,$game_type,$comp_game_id,$Enrollment_id)
	{

		$this->db->select("Game_id,Company_game_id,Game_for_competition,Link_to_game_campaign,Lives_flag,Initial_game_lives");
		$this->db->from("igain_game_company_master");
		$this->db->where(array("Company_game_id" =>$comp_game_id, "Company_id"=> $Companyid));
		
		$query25 = $this->db->get();

        if ($query25->num_rows() > 0)
		{
			foreach($query25->result_array() as $row25)
			{
				$GameID = $row25['Game_id'];
				$livesFlag = $row25['Lives_flag'];
				$Game_for_competition = $row25['Game_for_competition'];
				$Link_to_game_campaign = $row25['Link_to_game_campaign'];
				$Initial_lives = $row25['Initial_game_lives'];
			}
			
			if($livesFlag == 1 && $game_type != 1 && ($Game_for_competition == 1 || $Link_to_game_campaign == 1))
			{
				$this->db->from("igain_game_member_lives");
				$this->db->where(array("Company_id" =>$Companyid,"Company_game_id"=>$comp_game_id,"Game_level"=>1,"Enrollment_id"=>$Enrollment_id));
				
				$num_vals = $this->db->count_all_results();
				
				if($num_vals == 0)
				{
					$insert_data['Enrollment_id'] = $Enrollment_id;
					$insert_data['Company_id'] = $Companyid;
					$insert_data['Game_id'] = $GameID;
					$insert_data['Company_game_id'] = $comp_game_id;
					$insert_data['Game_level'] = 1;
					$insert_data['Lives_for_level'] = $Initial_lives;
					
					$this->db->insert('igain_game_member_lives',$insert_data);
				}
			}
			
			
			
			$game_data["Game_id"] = $GameID;
			$game_data["game_type"] = $game_type;
			$game_data["Company_game_id"] = $comp_game_id;
			
											
		}
		
		$this->db->select('Description');
		$this->db->from('igain_game_master');
		$this->db->where('Game_id',$GameID);
		$master_res = $this->db->get();
		
		if ($master_res->num_rows() > 0)
		{
			foreach($master_res->result_array() as $res01)
			{
				$description = $res01['Description'];
			}
		}
		
		$game_data["Description"] = $description;
		$game_data["Game_for_competition"] = $Game_for_competition;
		
		$this->db->select_max('Game_level');
			$this->db->from('igain_game_company_configuration');
			$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid ));
			
			$res1 = $this->db->get();

			if ($res1->num_rows() > 0)
			{
				$res2 = $res1->result_array();
				$max_level = $res2[0]['Game_level'];
			}
			
			$getRows = 0;
			
			if($game_type == 1)
			{
				$this->db->select_max('Fun_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
					
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Fun_game_iteration'];
					$lv_column = "Fun_game_iteration";
					$getRows = 1;
				}
			}
			
			if($game_type == 2)
			{
				$this->db->select_max('Campaign_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
					
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Campaign_game_iteration'];
					$lv_column = "Campaign_game_iteration";
					$getRows = 1;
				}	
					
			}
			
			if($game_type == 3)
			{
				$this->db->select_max('Competition_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
				
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Competition_game_iteration'];
					$lv_column = "Competition_game_iteration";
					$getRows = 1;
				}	

			}
			
			if($getRows == 1)
			{
				$this->db->select_max('Game_level');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					$lv_column => $lv_GameIteration ,'Game_type'=>$game_type));
				
				$res73 = $this->db->get('igain_game_level_winner');
				
				if ($res73->num_rows() > 0)
				{
					$res74 = $res73->result_array();
					$max_level2 = $res74[0]['Game_level'];
				}
				
				if($max_level2 == $max_level)
				{
					$Game_iteration = $lv_GameIteration + 1;
				}
				else
				{
					$Game_iteration = $lv_GameIteration;
				}
			}
			else
			{
				$Game_iteration = 0;
			}
			$game_data["Game_iteration"] = $Game_iteration;
			
			$this->db->select_max('Game_level');
			$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
			$lv_column => $Game_iteration ,'Game_type'=>$game_type, 'Game_winner_flag' => 0));
				
				$res75 = $this->db->get('igain_game_level_winner');
				
				if ($res75->num_rows() > 0)
				{
					$res76 = $res75->result_array();
					$max_level3 = $res76[0]['Game_level'];
					$CurrentLevel = $max_level3 + 1;
				}
				else
				{
					$CurrentLevel = 1;
				}	
				
				$Highest_score = 0;
				
				$this->db->select_max('Game_score');
			$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,
			 'Game_level'=>$CurrentLevel, 'Game_winner_flag' => 0));
				
				$res77 = $this->db->get('igain_game_level_winner');
				
				if ($res77->num_rows() > 0)
				{
					$res78 = $res77->result_array();
					$Highest_score = $res78[0]['Game_score'];				
				}
				
				if($Highest_score > 0)
				{
					$Highest_score = $Highest_score;
				}
				else
				{
					$Highest_score = 0;
				}
				
				$this->db->select_max('Lives_for_level');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,
			 'Enrollment_id'=>$Enrollment_id));
				
				$res21 = $this->db->get('igain_game_member_lives');
				
				if ($res21->num_rows() > 0)
				{
					$res22 = $res21->result_array();
					$Total_Lives = $res22[0]['Lives_for_level'];				
				}
				$game_data["game_lives"] = $Total_Lives;
				
				$this->db->select('Lives_flag');
				$this->db->from('igain_game_company_master');
				$this->db->where(array('Company_game_id'=> $comp_game_id, 'Active_flag' => 1));
				
				$res23 = $this->db->get();
				
				if ($res23->num_rows() > 0)
				{
					foreach($res23->result_array() as $res24)
					{
						$livesFlag = $res24['Lives_flag'];				
					}
				}
				
				$Flag= 1;
				
				$this->db->select_max('Game_score');
				$this->db->from("igain_game_level_winner");
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid));
				
				$res25 = $this->db->get();
				
				if ($res25->num_rows() > 0)
				{
					foreach($res25->result_array() as $row25)
					{
						$Highest_game_score = $row25['Game_score'];				
					}
				}
				$game_data["Highest_game_score"] = $Highest_game_score;
			
				$this->db->select("Enrollment_id");
				$this->db->from("igain_game_level_winner");
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Game_score'=> $Highest_game_score));
				$res26 = $this->db->get();
				
				if ($res26->num_rows() > 0)
				{
					foreach($res26->result_array() as $row26)
					{
						$max_score_user_enrollID = $row26['Enrollment_id'];				
					}
				}
				
				$game_data["max_score_user_enrollID"] = $max_score_user_enrollID;
				
			$this->db->select("Game_level,Time_for_level,Total_moves,Issued_lives,Game_image,Game_matrix");
			$this->db->from("igain_game_company_configuration");
			$this->db->where(array("Company_game_id"=>$comp_game_id,"Company_id"=>$Companyid,"Game_level"=>$CurrentLevel));
			$res27 = $this->db->get();
				
				if ($res27->num_rows() > 0)
				{
					foreach($res27->result_array() as $row27)
					{
						$Game_level = $row27['Game_level'];				
						$Time_for_level = $row27['Time_for_level'];				
						$Total_moves = $row27['Total_moves'];				
						$Issued_lives = $row27['Issued_lives'];				
						$Game_image = $row27['Game_image'];				
						$Game_matrix = $row27['Game_matrix'];				
					}
				}
			$game_data["Total_moves"] = $Total_moves;
			$game_data["Issued_lives"] = $Issued_lives;
			$game_data["Game_image"] = $Game_image;
			$game_data["Game_matrix"] = $Game_matrix;
			
			$game_time = explode(":",$Time_for_level);

				$game_time_hour = ltrim($game_time[0],"0");
				$game_time_minute = ltrim($game_time[1],"0");
				$game_time_second = ltrim($game_time[2],"0");

				if($game_time_hour == ""){$game_time_hour = 0;}else{$game_time_hour = $game_time_hour * 60 * 60;}
				if($game_time_minute == ""){$game_time_minute = 0;}else{$game_time_minute = $game_time_minute * 60;}
				if($game_time_second == ""){$game_time_second = 0;}else{$game_time_second = $game_time_second;}
				
				$game_level_time = $game_time_hour + $game_time_minute + $game_time_second;
				
			$game_data["Time_for_level"] = $game_level_time;
			
			$game_data["livesFlag"] = $livesFlag;
			
			$game_data["CurrentLevel"] = $CurrentLevel;
			
			$game_data["Game_level"] = $Game_level;
			

			return $game_data;		
	}
	
	public function set_game_data($comp_game_id,$Companyid,$CurrentLevel,$Enrollment_id,$game_type)
	{
		$this->db->select("Game_id,Company_game_id,Game_for_competition,Link_to_game_campaign,Lives_flag,Initial_game_lives");
		$this->db->from("igain_game_company_master");
		$this->db->where(array("Company_game_id" =>$comp_game_id, "Company_id"=> $Companyid));
		
		$query25 = $this->db->get();

        if ($query25->num_rows() > 0)
		{
			foreach($query25->result_array() as $row25)
			{
				$GameID = $row25['Game_id'];
				$livesFlag = $row25['Lives_flag'];
				$Game_for_competition = $row25['Game_for_competition'];
				$Link_to_game_campaign = $row25['Link_to_game_campaign'];
				$Initial_lives = $row25['Initial_game_lives'];
			}
		}
		
		$this->db->select('Description');
		$this->db->from('igain_game_master');
		$this->db->where('Game_id',$GameID);
		$master_res = $this->db->get();
		
		if ($master_res->num_rows() > 0)
		{
			foreach($master_res->result_array() as $res01)
			{
				$description = $res01['Description'];
			}
		}
		
		$game_data["Description"] = $description;
		$game_data["Game_for_competition"] = $Game_for_competition;
		$getRows = 0;
			
			if($game_type == 1)
			{
				$this->db->select_max('Fun_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
					
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Fun_game_iteration'];
					$lv_column = "Fun_game_iteration";
					$getRows = 1;
				}
			}
			
			if($game_type == 2)
			{
				$this->db->select_max('Campaign_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
					
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Campaign_game_iteration'];
					$lv_column = "Campaign_game_iteration";
					$getRows = 1;
				}	
					
			}
			
			if($game_type == 3)
			{
				$this->db->select_max('Competition_game_iteration');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					'Game_id' =>$GameID ,'Game_type'=>$game_type));
				
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$lv_GameIteration = $res72[0]['Competition_game_iteration'];
					$lv_column = "Competition_game_iteration";
					$getRows = 1;
				}	

			}
			
			if($getRows == 1)
			{
				$this->db->select_max('Game_level');
				$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id,
					$lv_column => $lv_GameIteration ,'Game_type'=>$game_type));
				
				$res73 = $this->db->get('igain_game_level_winner');
				
				if ($res73->num_rows() > 0)
				{
					$res74 = $res73->result_array();
					$max_level2 = $res74[0]['Game_level'];
				}
				
				if($max_level2 == $max_level)
				{
					$Game_iteration = $lv_GameIteration + 1;
				}
				else
				{
					$Game_iteration = $lv_GameIteration;
				}
			}
			else
			{
				$Game_iteration = 0;
			}
			$game_data["Game_iteration"] = $Game_iteration;
			

		$this->db->select_max('Lives_for_level');
		$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Enrollment_id'=>$Enrollment_id));
				
				$res21 = $this->db->get('igain_game_member_lives');
				
				if ($res21->num_rows() > 0)
				{
					$res22 = $res21->result_array();
					$Total_Lives = $res22[0]['Lives_for_level'];				
				}
		$game_data["game_lives"] = $Total_Lives;
				
				
		$this->db->select_max('Game_score');
		$this->db->from("igain_game_level_winner");
		$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid));
			
			$res25 = $this->db->get();
			
			if ($res25->num_rows() > 0)
			{
				foreach($res25->result_array() as $row25)
				{
					$Highest_game_score = $row25['Game_score'];				
				}
			}
				$game_data["Highest_game_score"] = $Highest_game_score;
			
		$this->db->select("Enrollment_id");
		$this->db->from("igain_game_level_winner");
		$this->db->where(array('Company_game_id'=>$comp_game_id ,'Company_id' =>$Companyid,'Game_score'=> $Highest_game_score));
		$res26 = $this->db->get();
				
				if ($res26->num_rows() > 0)
				{
					foreach($res26->result_array() as $row26)
					{
						$max_score_user_enrollID = $row26['Enrollment_id'];				
					}
				}
				
				$game_data["max_score_user_enrollID"] = $max_score_user_enrollID;
				
				
		$this->db->select("Game_level,Time_for_level,Total_moves,Issued_lives,Game_image,Game_matrix");
			$this->db->from("igain_game_company_configuration");
			$this->db->where(array("Company_game_id"=>$comp_game_id,"Company_id"=>$Companyid,"Game_level"=>$CurrentLevel));
			$res27 = $this->db->get();
				
				if ($res27->num_rows() > 0)
				{
					foreach($res27->result_array() as $row27)
					{
						$Game_level = $row27['Game_level'];				
						$Time_for_level = $row27['Time_for_level'];				
						$Total_moves = $row27['Total_moves'];				
						$Issued_lives = $row27['Issued_lives'];	
						$Game_image = $row27['Game_image'];				
						$Game_matrix = $row27['Game_matrix'];			
					}
				}
			$game_data["Total_moves"] = $Total_moves;
			$game_data["Issued_lives"] = $Issued_lives;
			$game_data["Game_image"] = $Game_image;
			$game_data["Game_matrix"] = $Game_matrix;
			
			$game_time = explode(":",$Time_for_level);

				$game_time_hour = ltrim($game_time[0],"0");
				$game_time_minute = ltrim($game_time[1],"0");
				$game_time_second = ltrim($game_time[2],"0");

				if($game_time_hour == ""){$game_time_hour = 0;}else{$game_time_hour = $game_time_hour * 60 * 60;}
				if($game_time_minute == ""){$game_time_minute = 0;}else{$game_time_minute = $game_time_minute * 60;}
				if($game_time_second == ""){$game_time_second = 0;}else{$game_time_second = $game_time_second;}
				
				$game_level_time = $game_time_hour + $game_time_minute + $game_time_second;
				
			$game_data["Time_for_level"] = $game_level_time;
	
		return $game_data;
	}
	
	public function level_fail($Company_id,$MemberID,$enrollID,$game_type,$Comp_Game_ID,$GameLevel)
	{
		$todays = date("Y-m-d");
		$campaignID = array();
		
		$this->db->select('Lives_flag,Game_id');
		$this->db->from('igain_game_company_master');
		$this->db->where(array('Company_game_id'=> $Comp_Game_ID, 'Active_flag' => 1));
		
		$res23 = $this->db->get();
		
		if ($res23->num_rows() > 0)
		{
			foreach($res23->result_array() as $res24)
			{
				$livesFlag = $res24['Lives_flag'];				
				$Game_id = $res24['Game_id'];				
			}
		}
		
		if($livesFlag == 1 && ($game_type == 2 || $game_type == 3))
		{
			$GameLevel12 = $GameLevel;
			
			$this->db->select('Child_id,Lives_for_level');
			$this->db->from('igain_game_member_lives');
			$this->db->where(array('Company_game_id' => $Comp_Game_ID, 'Company_id' =>$Company_id, 'Game_level' => $GameLevel12,'Enrollment_id'=>$enrollID ));
			
			$res40 = $this->db->get();
			
			if($res40->num_rows() > 0)
			{
				foreach($res40->result_array() as $row40)
				{
					$Child_id = $row40['Child_id'];
					$exist_lives = $row40['Lives_for_level'];
				}
				
				$game_lives = $exist_lives - 1;
				$data121['Lives_for_level'] = $game_lives;

			}
			else
			{
				$GameLevel12 = $GameLevel - 1;
				
				$this->db->select('Child_id,Lives_for_level');
				$this->db->from('igain_game_member_lives');
				$this->db->where(array('Company_game_id' => $Comp_Game_ID, 'Company_id' =>$Company_id, 'Game_level' => $GameLevel12,'Enrollment_id'=>$enrollID ));
				
				$res401 = $this->db->get();
				
				if($res401->num_rows() > 0)
				{
					foreach($res401->result_array() as $row401)
					{
						$Child_id2 = $row401['Child_id'];
						$exist_lives2 = $row401['Lives_for_level'];
					}
					
					$exist_lives2 = $exist_lives2 - 1;
					$data121['Lives_for_level'] = $exist_lives2;

				}
				
				$game_lives = $exist_lives2;
			}
			
			$exist_lives = $exist_lives - 1;
			
			if($exist_lives < 0)
			{
				$exist_lives = 0;
			}
			
			$this->db->where(array('Company_game_id' => $Comp_Game_ID,'Game_id'=>$Game_id, 'Company_id' =>$Company_id, 'Game_level' => $GameLevel12,'Enrollment_id'=>$enrollID));
			$this->db->update('igain_game_member_lives',$data121);	
		}
		
		//echo $this->db->last_query();
		
		//die;
		$gameArray = $this->set_game_data($Comp_Game_ID,$Company_id,$GameLevel,$enrollID,$game_type);
		
		$game_data2["CurrentLevel"] = $GameLevel;
		$game_data2["Company_game_id"] = $Comp_Game_ID;
		$game_data2["Game_id"] = $Game_id;
		$game_data2["game_type"] = $game_type;
		$game_data2["livesFlag"] = $livesFlag;
		//$game_data2["game_lives"] = $game_lives;
			
		$game_data3 = array_merge($gameArray,$game_data2);
			
		return $game_data3;	
			
	}
	
	public function next_level($Company_id,$MemberID,$enrollID,$game_type,$Comp_Game_ID,$GameLevel,$game_score)
	{
		//echo "--".$Company_id."--".$MemberID."--".$enrollID."--".$game_type."--".$Comp_Game_ID."--".$GameLevel."--".$game_score."--";
		
		$todays=date("Y-m-d");
		$campaignID = array();
		
		$this->db->select('First_name,Last_name,Current_balance,total_purchase,Total_topup_amt,Total_reddems');
		$this->db->where(array('Enrollement_id' =>$enrollID, 'Company_id' =>$Company_id, 'User_activated' => 1 ));
		
		$query01 = $this->db->get('igain_enrollment_master');
		if ($query01->num_rows() > 0)
		{
			foreach($query01->result_array() as $res01)
			{
				$lv_name = $res01['First_name'].' '.$res01['Last_name'];				
				$lv_Current_balance = $res01['Current_balance'];				
				$lv_total_purchase = $res01['total_purchase'];				
				$lv_Total_topup_amt = $res01['Total_topup_amt'];				
				$lv_Total_reddems = $res01['Total_reddems'];				
			}
		}
		
		
		$this->db->select('Lives_flag,Game_id');
		$this->db->from('igain_game_company_master');
		$this->db->where(array('Company_game_id'=> $Comp_Game_ID, 'Active_flag' => 1));
		
		$res23 = $this->db->get();
		
		if ($res23->num_rows() > 0)
		{
			foreach($res23->result_array() as $res24)
			{
				$livesFlag = $res24['Lives_flag'];				
				$Game_id = $res24['Game_id'];				
			}
		}
		
		$this->db->select("Game_id,Company_game_id,Game_for_competition,Link_to_game_campaign,Lives_flag,Initial_game_lives");
		$this->db->from("igain_game_company_master");
		$this->db->where(array("Company_game_id" =>$Comp_Game_ID, "Company_id"=> $Company_id));
		
		$query25 = $this->db->get();

        if ($query25->num_rows() > 0)
		{
			foreach($query25->result_array() as $row25)
			{
				$GameID = $row25['Game_id'];
				$livesFlag = $row25['Lives_flag'];
				$Game_for_competition = $row25['Game_for_competition'];
				$Link_to_game_campaign = $row25['Link_to_game_campaign'];
				$Initial_lives = $row25['Initial_game_lives'];
			}
		}
		
			$this->db->select("Game_level,Time_for_level,Total_moves,Issued_lives");
			$this->db->from("igain_game_company_configuration");
			$this->db->where(array("Company_game_id"=>$Comp_Game_ID,"Company_id"=>$Company_id,"Game_level"=>$GameLevel));
			$res27 = $this->db->get();
				
				if ($res27->num_rows() > 0)
				{
					foreach($res27->result_array() as $row27)
					{		
						$Time_for_level = $row27['Time_for_level'];				
						$Total_moves = $row27['Total_moves'];		
						$Issued_lives = $row27['Issued_lives'];				
					}
				}
				
		$game_time = explode(":",$Time_for_level);

				$game_time_hour = ltrim($game_time[0],"0");
				$game_time_minute = ltrim($game_time[1],"0");
				$game_time_second = ltrim($game_time[2],"0");

				if($game_time_hour == ""){$game_time_hour = 0;}else{$game_time_hour = $game_time_hour * 60 * 60;}
				if($game_time_minute == ""){$game_time_minute = 0;}else{$game_time_minute = $game_time_minute * 60;}
				if($game_time_second == ""){$game_time_second = 0;}else{$game_time_second = $game_time_second;}
				
				$game_level_time = $game_time_hour + $game_time_minute + $game_time_second;
				
				
		if($game_type == 1)
		{
			$Game_for_competition = 0; 
			$Link_to_game_campaign = 0;
			
			$iteration = 1;
			
			$this->db->select_max('Fun_game_iteration');
			$this->db->where(array('Company_game_id'=>$Comp_Game_ID ,'Company_id' =>$Company_id,'Enrollment_id'=>$enrollID,
				'Game_level' =>$GameLevel));
					
				$res71 = $this->db->get('igain_game_level_winner');

				if ($res71->num_rows() > 0)
				{
					$res72 = $res71->result_array();
					$iteration = $iteration + $res72[0]['Fun_game_iteration'];
					
				}
				
			$dataset = array(
			'Company_game_id' => $Comp_Game_ID,
			'Game_id' => $GameID,
			'Fun_game_iteration' => $iteration,
			'Game_level' => $GameLevel,
			'Game_type' => $game_type,
			'Gained_points' => 0,
			'Enrollment_id' => $enrollID,
			'Company_id' => $Company_id,
			'Campaign_id' => 0,
			'Game_score' => 0,
			);	
			
			$this->db->insert('igain_game_level_winner',$dataset);
			
			
			$cmp_msg = "";
		}
		
		
		if($livesFlag == 1 && ($Game_for_competition == 1 || $Link_to_game_campaign == 1))
		{
			
			$this->db->select('Child_id,Lives_for_level');
			$this->db->from('igain_game_member_lives');
			$this->db->where(array('Company_game_id' => $Comp_Game_ID, 'Company_id' =>$Company_id, 'Game_level' => $GameLevel,'Enrollment_id'=>$enrollID ));
			
			$res40 = $this->db->get();
			
			if($res40->num_rows() > 0)
			{
				foreach($res40->result_array() as $row40)
				{
					$Child_id = $row40['Child_id'];
					$exist_lives = $row40['Lives_for_level'];
				}
				
				$exist_lives2 = $exist_lives + $Issued_lives;
				$data121['Lives_for_level'] = $exist_lives2;
				
				$game_lives = $exist_lives2;
				
				$this->db->where(array('Company_game_id' => $Comp_Game_ID,'Game_id'=>$Game_id, 'Company_id' =>$Company_id, 'Game_level' => $GameLevel,'Enrollment_id'=>$enrollID));
				$this->db->update('igain_game_member_lives',$data121);
			}
			else
			{
				$dataset2 = array(
				'Enrollment_id' => $enrollID,
				'Company_id' => $Company_id,
				'Game_id' => $GameID,
				'Company_game_id' => $Comp_Game_ID,
				'Game_level' => $GameLevel,
				'Lives_for_level' => $Issued_lives,
				);
				
				$this->db->insert('igain_game_member_lives',$dataset2);
				
				$game_lives = $Issued_lives;
			}
		}
		
		if($Game_for_competition == 1 || $Link_to_game_campaign == 1)
		{
			$loyalty_points = 0;
			
			$res6 = $this->db->query("Select Campaign_id,Start_date,End_date from igain_campaign_master where Company_id=$Company_id and End_date >= $todays ");
			
			if($res6->num_rows() > 0)
			{
				foreach($res6->result_array() as $row6)
				{
					if($row6['Start_date'] <= $todays && $row6['End_date'] >= $todays)
					{
						$campaignID[] = $row6['Campaign_id'];
					}
				}
			}
			

			if(count($campaignID) > 0 && $game_type == 2)
			{
				$total_loyalty_points = 0;
				$campagin_loyalty_points = 0;
				
				foreach($campaignID as $cmp_id)
				{
					$allow_transaction = 1;
					
					$this->db->select('a.Reward_points,a.Game_level,a.Game_id,b.Campaign_name');
					$this->db->from('igain_game_campaign as a');
					$this->db->join('igain_campaign_master as b','a.Campaign_id = b.Campaign_id');
					$this->db->where(array('a.Campaign_id'=>$cmp_id ,'a.Company_game_id' => $Comp_Game_ID,'a.Company_id' => $Company_id, 'a.Game_level' =>$GameLevel ));
					$res5 = $this->db->get();
					
					if($res5->num_rows() > 0)
					{
						foreach($res5->result_array() as $row5)
						{
							$Campaign_name = $row5['Campaign_name'];
							$Cmp_Game_id = $row5['Game_id'];
							$Cmp_Game_level = $row5['Game_level'];
							$Reward_points = $row5['Reward_points'];
						}
						
						$loyalty_points = $Reward_points;
					}
					
					$campagin_loyalty_points = $campagin_loyalty_points + $loyalty_points;
				}
				
				$iteration = 1;
				
				$this->db->select_max('Campaign_game_iteration');
				$this->db->where(array('Company_game_id'=>$Comp_Game_ID ,'Company_id' =>$Company_id,'Enrollment_id'=>$enrollID,
				'Game_level' =>$GameLevel));
					
				$res710 = $this->db->get('igain_game_level_winner');

				if ($res710->num_rows() > 0)
				{
					$res720 = $res710->result_array();
					$iteration = $iteration + $res720[0]['Campaign_game_iteration'];
					
				}
				
				if($Link_to_game_campaign == 1)
				{
					$dataset2 = array(
					'Company_game_id' => $Comp_Game_ID,
					'Game_id' => $GameID,
					'Campaign_game_iteration' => $iteration,
					'Game_level' => $GameLevel,
					'Game_type' => $game_type,
					'Gained_points' => $campagin_loyalty_points,
					'Enrollment_id' => $enrollID,
					'Company_id' => $Company_id,
					'Campaign_id' => $cmp_id,
					'Game_score' => 0,
					);
				}
				
				if($Game_for_competition == 1)
				{
					$dataset2 = array(
					'Company_game_id' => $Comp_Game_ID,
					'Game_id' => $GameID,
					'Competition_game_iteration' => $iteration,
					'Game_level' => $GameLevel,
					'Game_type' => $game_type,
					'Gained_points' => $campagin_loyalty_points,
					'Enrollment_id' => $enrollID,
					'Company_id' => $Company_id,
					'Campaign_id' => $cmp_id,
					'Game_score' => 0,
					);
				}
					
					
					$this->db->insert('igain_game_level_winner',$dataset2);

					
					if($campagin_loyalty_points > 0)
					{
						$transdata = array(
						'Company_id' => $Company_id,
						'Trans_type' => 8,
						'Topup_amount' => $campagin_loyalty_points,
						'Trans_date' => $todays,
						'Enrollement_id' => $enrollID,
						'Card_id' => $MemberID,
						'Loyalty_id' => $cmp_id,
						
						);
						
						$this->db->insert('igain_transaction',$transdata);
						
						$gv_current_bal = $lv_Current_balance + $campagin_loyalty_points;				
						$gv_topup_amt = $lv_Total_topup_amt + $campagin_loyalty_points;				
						
						$cust_data = array(
							'Current_balance' => $gv_current_bal,
							'Total_topup_amt' => $gv_topup_amt,
						);
						
						$this->db->where(array('Enrollement_id' =>$enrollID, 'Company_id' =>$Company_id ));
						$this->db->update('igain_enrollment_master',$cust_data);
					}
					
					
					$cmp_msg = ",You have got $campagin_loyalty_points points";
				//print_r($ressss);
			}
			else if($game_type == 3)
			{
				$iteration = 1;
				
				$this->db->select_max('Competition_game_iteration');
				$this->db->where(array('Company_game_id'=>$Comp_Game_ID ,'Company_id' =>$Company_id,'Enrollment_id'=>$enrollID,
				'Game_level' =>$GameLevel));
					
				$res710 = $this->db->get('igain_game_level_winner');

				if ($res710->num_rows() > 0)
				{
					$res720 = $res710->result_array();
					$iteration = $iteration + $res720[0]['Competition_game_iteration'];
					
				}
				
				$dataset3 = array(
					'Company_game_id' => $Comp_Game_ID,
					'Game_id' => $GameID,
					'Campaign_game_iteration' => $iteration,
					'Game_level' => $GameLevel,
					'Game_type' => $game_type,
					'Gained_points' => 0,
					'Enrollment_id' => $enrollID,
					'Company_id' => $Company_id,
					'Campaign_id' => 0,
					'Game_score' => $game_score,
					);	
					
					$this->db->insert('igain_game_level_winner',$dataset3);
					
					$cmp_msg = "";
			}
		}
		$old_level = $GameLevel;
		$GameLevel++;
		
			$this->db->select_max('Game_level');
			$this->db->from('igain_game_company_configuration');
			$this->db->where(array('Company_game_id'=>$Comp_Game_ID ,'Company_id' =>$Company_id ));
			
			$res1 = $this->db->get();

			if ($res1->num_rows() > 0)
			{
				$res2 = $res1->result_array();
				$max_level = $res2[0]['Game_level'];
			}
		
			if($GameLevel > $max_level)
			{
				$GameLevel = 1;
				$msg = "Congratulation your all levels completed. $cmp_msg";
			}
			else
			{
				$msg = "Congratulations!!! You have Successfully Completed the Game Level - ".$old_level." $cmp_msg";
			}
		
		$gameArray = $this->set_game_data($Comp_Game_ID,$Company_id,$GameLevel,$enrollID,$game_type);
		
		$game_data2["CurrentLevel"] = $GameLevel;
		$game_data2["Company_game_id"] = $Comp_Game_ID;
		$game_data2["Game_id"] = $Game_id;
		$game_data2["game_type"] = $game_type;
		$game_data2["max_level"] = $max_level;
		$game_data2["livesFlag"] = $livesFlag;
		$game_data2["cmp_msg"] = $msg;
		//$game_data2["game_lives"] = $game_lives;
			

				
			
		$game_data3 = array_merge($gameArray,$game_data2);
			
			return $game_data3;		
	}
	
	
	public function game_competition_details($Company_id,$Company_gameID,$gameID)
	{
		$this->db->select("Game_for_competition,Competition_winner_award,Competition_start_date,Competition_end_date,Total_game_winner,Lives_flag");
		$this->db->from("igain_game_company_master");
		$this->db->where(array('Game_id' => $gameID, 'Company_game_id' => $Company_gameID, 'Company_id' =>$Company_id ));
		
		$result11 = $this->db->get();
		
		if ($result11->num_rows() > 0)
		{
        	foreach ($result11->result() as $row11)
			{
                $myData[] = $row11;
            }
            return $myData;
        }

		return false;
	}
	
	public function game_competition_prizes($Company_id,$Company_gameID,$gameID)
	{
		
		$this->db->select("Game_points_prize,Game_prize_image");
		$this->db->from("igain_game_company_child");
		
		$this->db->where(array('Game_id' => $gameID, 'Company_game_id' => $Company_gameID, 'Company_id' =>$Company_id ));
		$this->db->order_by("Competition_winner_level");
		
		$result11 = $this->db->get();
		
		if ($result11->num_rows() > 0)
		{
        	foreach ($result11->result() as $row11)
			{
                $myData[] = $row11;
            }
            return $myData;
        }
		return false;
	}
	
	public function get_member_all_lives($Company_id,$Comp_Game_ID,$enrollID)
	{
		$this->db->select_sum('Lives_for_level');
		$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$enrollID ));
		
		$resopt = $this->db->get('igain_game_member_lives');
		$resF = $resopt->result();
		
		 return $resF[0]->Lives_for_level;
	}
	
	public function Transfer_lives($Company_id)
	{
		$Membership_id = $this->input->post('Membership_id');
		$Enrollment_id = $this->input->post('Enrollment_id');
		$transfer_lives = $this->input->post('transfer_lives');
		$pin = $this->input->post('input_cust_pin');
		$ToEnrollement_id = $this->input->post('ToEnrollement_id');
		$Comp_Game_ID = $this->input->post('Comp_Game_ID');
		$currentlives = $this->input->post('currentlives');
		
		if($Enrollment_id > 0 && $Comp_Game_ID > 0 && $currentlives >= $transfer_lives)
		{
			$this->db->limit(0,1);
			$this->db->from("igain_game_member_lives");
			$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$ToEnrollement_id ));
			$this->db->order_by("Child_id","DESC");
			
			$toresult = $this->db->get();
			
			if($toresult->num_rows() > 0)
			{
				foreach($toresult->result() as $torow)
				{
					$lv_lives_for_level = $torow->Lives_for_level;
					$Game_level_other = $torow->Game_level;
					$Transfered_lives = $torow->Transfer_lives;
					
				}
				//echo "lv_lives_for_level--".$lv_lives_for_level."--<br>";
				
				$lives_to_transfer = $Transfered_lives + $transfer_lives;
				$new_game_lives = $lv_lives_for_level + $transfer_lives;
				
				$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$ToEnrollement_id,'Game_level'=> $Game_level_other));
				$this->db->update("igain_game_member_lives",array('Lives_for_level' =>$new_game_lives, 'Enrollment_id2' =>$Enrollment_id,'Transfer_lives'=> $lives_to_transfer ));
				
				
				$this->db->limit(0,1);
				$this->db->from("igain_game_member_lives");
				$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$Enrollment_id ));
				$this->db->order_by("Child_id","DESC");
				
				$fromresult = $this->db->get();
				
				if($fromresult->num_rows() > 0)
				{
					foreach($fromresult->result() as $fromrow)
					{
						$pv_lives_for_level = $fromrow->Lives_for_level;
						$pv_Game_level_other = $fromrow->Game_level;					
					}
					
					$pv_new_game_lives = $pv_lives_for_level - $transfer_lives;
					
					$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$Enrollment_id,'Game_level'=> $Game_level_other));
					$this->db->update("igain_game_member_lives",array('Lives_for_level' =>$pv_new_game_lives ));
				
				}
			}
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}

		}
		
		return false;
		
	}
	
	public function Purchase_lives($Company_id,$Company_balance)
	{
		$Membership_id = $this->input->post('membership_id');
		$Enrollment_id = $this->input->post('Enrollment_id');
		$Comp_Game_ID = $this->input->post('Comp_Game_ID');
		$pin = $this->input->post('input_cust_pin');
		$current_balance = $this->input->post('currentbalance');
		$currentlives = $this->input->post('currentlives');
		$purchase_lives = $this->input->post('purchase_lives');
		$bal_pay = $this->input->post('bal_pay');
		
		if($purchase_lives > 0 && $Comp_Game_ID > 0 && $current_balance >= $bal_pay )
		{
		$new_current_bal = $current_balance - $bal_pay;
		
		$new_Company_balance = $Company_balance + $bal_pay;
		
			$this->db->limit(0,1);
			$this->db->select("Game_level,Lives_for_level");
			$this->db->from("igain_game_member_lives");
			$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$Enrollment_id ));
			$this->db->order_by("Game_level","DESC");
			
			$toresult = $this->db->get();
			
			if($toresult->num_rows() > 0)
			{
				foreach($toresult->result() as $torow)
				{
					$MAX_Total_Lives = $torow->Lives_for_level;
					$Game_level_other = $torow->Game_level;	
				}
			}
			$today = date("Y-m-d");
			$new_game_lives = $MAX_Total_Lives + $purchase_lives; 
			
			$this->db->where(array('Company_id' => $Company_id ,'Company_game_id' =>$Comp_Game_ID ,'Enrollment_id' =>$Enrollment_id,'Game_level'=> $Game_level_other));
			$this->db->update("igain_game_member_lives",array('Lives_for_level' =>$new_game_lives ));
			
			$this->db->where(array('Company_id' => $Company_id ,'Enrollement_id' =>$Enrollment_id));
			$this->db->update('igain_enrollment_master',array('Current_balance'=>$new_current_bal));	
			
			$this->db->where(array('Company_id' => $Company_id ));
			$this->db->update('igain_company_master',array('Current_bal'=>$new_Company_balance));
			
			$trans_data = array(
			'Trans_type' =>11,
			'Company_id' => $Company_id,
			'Redeem_points' => $bal_pay,
			'Trans_date' => $today,
			'Enrollement_id' => $Enrollment_id,
			'Card_id' => $Membership_id,
			'Bill_no' => 0
			
			);
			
			$this->db->insert('igain_transaction',$trans_data);
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}

		}
		return false;
	}
}

?>
