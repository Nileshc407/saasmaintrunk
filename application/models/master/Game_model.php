<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game_model extends CI_Model
{
	public function games_count()
	{
		return $this->db->count_all("igain_game_master");
	}
	
	public function get_games($compID)
	{
		$this->db->select("Game_id");
		$this->db->from("igain_game_company_master as a");
		$this->db->where(array("a.Company_id" =>$compID, "a.Active_flag" => 1));
        $query11 = $this->db->get();
		
		
        if ($query11->num_rows() > 0)
		{
        	foreach ($query11->result() as $row)
			{
                $data11[] = $row->Game_id;
            }
            
            $company_games = implode($data11,",");
            
            $this->db->select("Game_id,Game_name,Score_based_flag");
			$this->db->from("igain_game_master");
			$this->db->where("Game_id NOT IN (".$company_games.")");
		
			$query12 = $this->db->get();
        }
        else
        {
			$this->db->select("Game_id,Game_name,Score_based_flag");
			$query12 = $this->db->get("igain_game_master");
		}

        if ($query12->num_rows() > 0)
		{
			foreach ($query12->result() as $row12)
			{
                $data123[] = $row12;
            }
            
            return $data123;
            
        }
        
        return false;
	}
	
	public function games_list($limit,$start)
	{
		//$this->db->limit($limit,$start);
        $query = $this->db->get("igain_game_master");

        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}	
	
	public function insert_game()
	{
		$tbl_data['Game_name'] = $this->input->post('game_name');
		$tbl_data['Description'] = $this->input->post('Game_details');        
		$tbl_data['Game_image_flag'] = $this->input->post('Image_based');
		$tbl_data['Time_based_flag'] = $this->input->post('Time_based');
		$tbl_data['Moves_based_flag'] = $this->input->post('Moves_based');
		$tbl_data['Score_based_flag'] = $this->input->post('Score_based');
		
		$this->db->insert('igain_game_master', $tbl_data);	
			
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function check_game_name($gamename)
	 {
		$this->db->from("igain_game_master");
		$this->db->where('Game_name',$gamename);
		
		$opt = $this->db->get();
		
		if($opt->num_rows() > 0)
		{
			return 1;
		}
		
		return 0;
	 }
	 
	public function delete_game($game_id)
	{
		$this->db->where('Game_id',$game_id);
		$this->db->delete("igain_game_master");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	
	public function edit_game($game_id)
	{
		$this->db->from("igain_game_master");
		$this->db->where('Game_id',$game_id);
		
		$opt = $this->db->get();
		
		if ($opt->num_rows() > 0)
		{
        	foreach ($opt->result() as $row)
			{
                $data101[] = $row;
            }
            return $data101;
        }
        return false;

	}
	
	public function update_game()
	{
		$Game_id = $this->input->post('Game_id');
		$tbl1_data['Game_name'] = $this->input->post('game_name');
		$tbl1_data['Description'] = $this->input->post('Game_details');        
		$tbl1_data['Game_image_flag'] = $this->input->post('Image_based');
		$tbl1_data['Time_based_flag'] = $this->input->post('Time_based');
		$tbl1_data['Moves_based_flag'] = $this->input->post('Moves_based');
		$tbl1_data['Score_based_flag'] = $this->input->post('Score_based');
		
		$this->db->where("Game_id",$Game_id);
		$this->db->update('igain_game_master', $tbl1_data);	
			
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function company_games_count($companyID)
	{
		$this->db->where(array("Company_id" =>$companyID, "Active_flag" => 1));
		return $this->db->count_all("igain_game_company_master");
	}
	
	public function company_games_list($limit,$start,$companyID)
	{
		//$this->db->limit($limit,$start);
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
	
	public function insert_company_game($filepath)
	{
		$tblData["Company_id"] = $this->input->post("Company_id");
		$tblData["Game_id"] = $this->input->post("Game_id");
		$tblData["Game_for_fun"] = $this->input->post("Fun");
		$tblData["Link_to_game_campaign"] = $this->input->post("Campaign");
		$tblData["Game_for_competition"] = $this->input->post("Competition");
		$tblData["Active_flag"] = 1;
		
		$tblData["Lives_flag"] = $this->input->post("lives_flag");
			
			$Lives_flag = $this->input->post("lives_flag");
			
			if($Lives_flag == 1)
			{
				$tblData["Initial_game_lives"] = $this->input->post("initial_lives");
				$tblData["Points_value_for_one"] = $this->input->post("points_lives");
			}
			
		$Game_for_competition = $this->input->post("Competition");
			
		if($Game_for_competition == 1)
		{
			
			$tblData["Competition_start_date"] = date("Y-m-d",strtotime($this->input->post("start_date"))); 
			$tblData["Competition_end_date"] =  date("Y-m-d",strtotime($this->input->post("end_date")));
			$tblData["Total_game_winner"] = $this->input->post("Winners");
			$tblData["Competition_winner_award"] = $this->input->post("Winner_award");
		}
		
		$this->db->insert("igain_game_company_master",$tblData);
		
		$Company_game_id = $this->db->insert_id();
		
		$affectRows = $this->db->affected_rows();
		
		if($Game_for_competition == 1)
		{
			$Total_game_winner = $this->input->post("Winners");
			//echo "---Total_game_winner---".$Total_game_winner."--<br>";
			 $points_array = $this->input->post("points");
			 $prizes_array = $this->input->post("prizes");
			 $files_array = $this->input->post("file");
			// print_r($points_array);
			 $m = 1;
			$Competition_winner_award = $this->input->post("Winner_award");
			
			for($k=0;$k < $Total_game_winner; $k++)
			{
				$ChildtblData["Company_game_id"] = $Company_game_id;
				$ChildtblData["Game_id"] = $this->input->post("Game_id");
				$ChildtblData["Company_id"] = $this->input->post("Company_id");
				$ChildtblData["Competition_winner_level"] = $m;
					
				if($Competition_winner_award == 1)
				{
					$ChildtblData["Game_points_prize"] = $points_array[$k] ;
				}
				
				if($Competition_winner_award == 2)
				{
					$ChildtblData["Game_points_prize"] = $prizes_array[$k] ;
					$ChildtblData["Game_prize_image"] = $filepath[$k];
				}
				
				$this->db->insert("igain_game_company_child",$ChildtblData);
				
				$m++;
			}
			
			
		}
		
		if($affectRows > 0)
		{
			return $Company_game_id;
		}
		
		return 0;
	}
	
	public function delete_company_game($game_id)
	{
		$this->db->where('Company_game_id',$game_id);
		$this->db->delete("igain_game_company_child");
		
		$this->db->where('Company_game_id',$game_id);
		$this->db->delete("igain_game_company_master");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
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
	
	public function edit_child_company_game($game_id)
	{
		$this->db->select("b.Game_points_prize,b.Game_prize_image");
		$this->db->from("igain_game_company_child as b");
		$this->db->where('b.Company_game_id',$game_id);
			
		$queryopt2 = $this->db->get();
		
			if ($queryopt2->num_rows() > 0)
			{
				foreach ($queryopt2->result() as $row112)
				{
					$data112[] = $row112;
				}
				return $data112;
			}
		 return false;
	}
	
	public function update_company_game($filepath)
	{
		$CompID = $this->input->post("Company_id");
		$tblData["Company_id"] = $CompID;
		$tblData["Game_id"] = $this->input->post("Game_id");
		$tblData["Game_for_fun"] = $this->input->post("Fun");
		$tblData["Link_to_game_campaign"] = $this->input->post("Campaign");
		$tblData["Game_for_competition"] = $this->input->post("Competition");
		$tblData["Active_flag"] = 1;
		
		$tblData["Lives_flag"] = $this->input->post("lives_flag");
			
			$Lives_flag = $this->input->post("lives_flag");
			
			if($Lives_flag == 1)
			{
				$tblData["Initial_game_lives"] = $this->input->post("initial_lives");
				$tblData["Points_value_for_one"] = $this->input->post("points_lives");
			}
			
		$Game_for_competition = $this->input->post("Competition");
			
		if($Game_for_competition == 1)
		{
			
			$tblData["Competition_start_date"] = date("Y-m-d",strtotime($this->input->post("start_date"))); 
			$tblData["Competition_end_date"] =  date("Y-m-d",strtotime($this->input->post("end_date")));
			$tblData["Total_game_winner"] = $this->input->post("Winners");
			$tblData["Competition_winner_award"] = $this->input->post("Winner_award");
		}
		
		$Company_game_id = $this->input->post("Company_game_id");
		
		$this->db->where(array("Company_game_id" => $Company_game_id, "Company_id" => $CompID));
		$this->db->update("igain_game_company_master",$tblData);
		
		if($Game_for_competition == 1)
		{
			$this->db->where(array("Company_game_id" => $Company_game_id, "Company_id" => $CompID));
			$this->db->delete("igain_game_company_child");
			
			$Total_game_winner = $this->input->post("Winners");
			//echo "---Total_game_winner---".$Total_game_winner."--<br>";
			 $points_array = $this->input->post("points");
			 $prizes_array = $this->input->post("prizes");
			 $files_array = $this->input->post("file");
			// print_r($points_array);
			 $m = 1;
			$Competition_winner_award = $this->input->post("Winner_award");

			for($k=0;$k < $Total_game_winner; $k++)
			{
				$ChildtblData["Company_game_id"] = $Company_game_id;
				$ChildtblData["Game_id"] = $this->input->post("Game_id");
				$ChildtblData["Company_id"] = $this->input->post("Company_id");
				$ChildtblData["Competition_winner_level"] = $m;
					
				if($Competition_winner_award == 1)
				{
					$ChildtblData["Game_points_prize"] = $points_array[$k] ;
				}
				
				if($Competition_winner_award == 2)
				{
					$ChildtblData["Game_points_prize"] = $prizes_array[$k] ;
					
					if(!empty($filepath))
					{
					
						$ChildtblData["Game_prize_image"] = $filepath[$k];
					}

				}
		
				$this->db->insert("igain_game_company_child",$ChildtblData);
				
				$m++;
			}
			
			
		}

		$affectRows = $this->db->affected_rows();
		
		if($affectRows > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function company_configured_games_count($companyID)
	{
		$this->db->where(array("Company_id" =>$companyID));
		return $this->db->count_all("igain_game_company_configuration");
	}
	
	public function company_configured_games_list($limit,$start,$companyID)
	{
		//$this->db->limit($limit,$start);
		$this->db->select("c.*,b.Game_name");
		$this->db->from("igain_game_company_configuration as c");
		$this->db->join("igain_game_company_master as a","c.Company_game_id = a.Company_game_id");
		$this->db->join("igain_game_master as b","c.Game_id = b.Game_id");
		$this->db->order_by("c.Game_configuration_id","DESC");
		$this->db->where(array("c.Company_id" =>$companyID, "a.Active_flag" => 1));
        $query21 = $this->db->get();
		
		
        if ($query21->num_rows() > 0)
		{
        	foreach ($query21->result() as $row21)
			{
                $data21[] = $row21;
            }
            return $data21;
        }

	}	
	
	public function get_company_games($compID)
	{
		$this->db->select("b.*,a.Company_game_id,a.Lives_flag");
		$this->db->from("igain_game_master as b");
		$this->db->join("igain_game_company_master as a","a.Game_id = b.Game_id");
		$this->db->where(array("a.Company_id" =>$compID, "a.Active_flag" => 1));
		
        $query13 = $this->db->get();
		//echo $this->db->last_query();
		
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
     
     public function insert_company_game_configuration($filepath)
     {
		$tblData["Company_id"] = $this->input->post("Company_id");
		$tblData["Game_id"] = $this->input->post("Game_id");
		$tblData["Company_game_id"] = $this->input->post("Company_gameid");
		$tblData["Game_level"] = $this->input->post("game_level");
		
		$hh = $this->input->post("level_time_hour");
		$mm = $this->input->post("level_time_minute");
		$ss = $this->input->post("level_time_second");
		
		$tblData["Time_for_level"] = $hh.":".$mm.":".$ss;
		
		$tblData["Total_moves"] = $this->input->post("game_moves");
		$tblData["Issued_lives"] = $this->input->post("bonus_lives");
		$tblData["Game_matrix"] = $this->input->post("image_matrix");
		$tblData["Game_image"] = $filepath;
		
		$this->db->insert("igain_game_company_configuration",$tblData);
		
		$affectRows = $this->db->affected_rows();
		
		if($affectRows > 0)
		{
			return true;
		}
		
		return false;
	 }
    
	 public function check_game_level($CompId,$GameId,$Comp_Game_id,$GameLevel)
	 {
		 $this->db->select("Game_configuration_id");
		 $this->db->from("igain_game_company_configuration");
		 $this->db->where(array("Game_id"=>$GameId,"Company_game_id"=>$Comp_Game_id, "Game_level" =>$GameLevel, "Company_id" => $CompId ));
		 
		 $query51 = $this->db->get();
		 
		 if($query51->num_rows() > 0)
		 {
			 return $query51->num_rows();
		 }
		 
		 return 0;
	 }
	 
	 public function delete_company_game_configuration($game_config_id)
	{

		$this->db->where('Game_configuration_id',$game_config_id);
		$this->db->delete("igain_game_company_configuration");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function edit_company_game_configuration($companyID,$game_config_id)
	{
		$this->db->select("c.*,b.Game_name");
		$this->db->from("igain_game_company_configuration as c");
		$this->db->join("igain_game_master as b","c.Game_id = b.Game_id");
		$this->db->where(array("c.Company_id" =>$companyID, "c.Game_configuration_id" => $game_config_id));
        $query100 = $this->db->get();
        
        if($query100->num_rows() > 0)
        {
			foreach($query100->result() as $row100)
			{
				$data100[] = $row100;
			}
			
			return $data100;
		}
		
		return false;
	}
	
	public function update_company_game_configuration($filepath)
    {
		$Company_id = $this->input->post("Company_id");
		$tblData["Game_id"] = $this->input->post("Game_id");
		$tblData["Company_game_id"] = $this->input->post("Company_gameid");
		$tblData["Game_level"] = $this->input->post("game_level");
		$Game_configuration_id = $this->input->post("Game_configuration_id");
		
		$hh = $this->input->post("level_time_hour");
		$mm = $this->input->post("level_time_minute");
		$ss = $this->input->post("level_time_second");
		
		$tblData["Time_for_level"] = $hh.":".$mm.":".$ss;
		
		$tblData["Total_moves"] = $this->input->post("game_moves");
		$tblData["Issued_lives"] = $this->input->post("bonus_lives");
		$tblData["Game_matrix"] = $this->input->post("image_matrix");
		
		if($filepath != "")
		{
			$tblData["Game_image"] = $filepath;
		}
		
		$this->db->where(array("Company_id" =>$Company_id, "Game_configuration_id" => $Game_configuration_id));
		$this->db->update("igain_game_company_configuration",$tblData);
		
		$affectRows = $this->db->affected_rows();
		
		if($affectRows > 0)
		{
			return true;
		}
		
		return false;
	 }
     
     
    public function games_campaign_count($companyID)
	{
		$this->db->from("igain_game_campaign");
		$this->db->group_by("Campaign_id");
		$this->db->where(array("Company_id" =>$companyID));
		return $this->db->count_all_results();
	}
	
	public function company_games_campaign_list($limit,$start,$companyID)
	{
		//$this->db->limit($limit,$start);
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
	
	public function get_game_levels($gameId,$companyID)
	{
		$this->db->select("Game_configuration_id,Company_game_id,Game_level");
		$this->db->from("igain_game_company_configuration");
		$this->db->where(array("Company_id" =>$companyID,"Game_id" => $gameId));
		
		$res21 = $this->db->get();
		
		if($res21->num_rows() > 0)
		{
			foreach($res21->result() as $row21)
			{
				$opt[] = $row21;	
			}
			
			return $opt;
		}
		
		return false;
	}
	
	public function insert_company_game_campaign()
	{
		$Company_Id = $this->input->post("Company_id");
		$tblData12["Company_id"] = $this->input->post("Company_id");
		$tblData12["Campaign_name"]  = $this->input->post("cmp_name");

		$tblData12["Start_date"] = date("Y-m-d",strtotime($this->input->post("start_date"))); 
		$tblData12["End_date"] =  date("Y-m-d",strtotime($this->input->post("end_date")));
		
		$game_levels  = $this->input->post("game_levels");
		$level_points  = $this->input->post("level_points");
		
		if(count($game_levels) > 0)
		{
			$this->db->insert("igain_campaign_master",$tblData12);
			
			$CmpID = $this->db->insert_id();
			
			$Game_id  = $this->input->post("Game_id");
			$tblData13["Game_id"]  = $this->input->post("Game_id");
			$tblData13["Company_id"]  = $Company_Id;
			$tblData13["Campaign_id"]  = $CmpID;
			
			
			$this->db->select('Company_game_id');
			$this->db->from('igain_game_company_master');
			$this->db->where(array("Game_id" =>$Game_id ,"Company_id" =>$Company_Id ));
			
			$queryopt11 = $this->db->get();
		
			if ($queryopt11->num_rows() > 0)
			{	
				foreach ($queryopt11->result() as $row11)
				{
					$Company_game_id = $row11->Company_game_id;
				}
			}
			
			$tblData13["Company_game_id"] = $Company_game_id;
			
			for($p = 0; $p < count($game_levels); $p++)
			{
				$tblData13["Game_level"]  = $game_levels[$p];
				$tblData13["Reward_points"]  = $level_points[$p];
				
				$this->db->insert("igain_game_campaign",$tblData13);
			}
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function delete_company_game_campaign($cmpID)
	{
		$this->db->where("Campaign_id",$cmpID);
		$this->db->delete("igain_game_campaign");
		
		$this->db->where("Campaign_id",$cmpID);
		$this->db->delete("igain_campaign_master");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function check_campaign_name($cmp_name,$Companyid)
	{
		$this->db->select("Campaign_id");
		$this->db->from("igain_campaign_master");
		$this->db->where(array("Campaign_name" =>$cmp_name, "Company_id"=>$Companyid ));
		
		$opt10 = $this->db->get();
		
		return $opt10->num_rows();
	}
	
	public function edit_company_campaign($cmpID)
	{
		$this->db->where("Campaign_id",$cmpID);
		$res1 = $this->db->get("igain_campaign_master");
		
		if($res1->num_rows() > 0)
		{
			foreach($res1->result() as $row21)
			{
				$data21[] = $row21;
			}

			return $data21;
		}
		
	}
	
	public function edit_company_game_campaign($cmpID)
	{

		$this->db->where("Campaign_id",$cmpID);
		$res22 = $this->db->get("igain_game_campaign");
		
			if($res22->num_rows() > 0)
		{
			foreach($res22->result() as $row22)
			{
				$data22[] = $row22;
			}

			return $data22;
		}
	}
	
	public function update_company_game_campaign()
	{
		$Campaign_id = $this->input->post("Campaign_id");
		$Company_game_id = $this->input->post("Company_gameid");
		$Company_Id = $this->input->post("Company_id");

		$tblData12["Campaign_name"]  = $this->input->post("cmp_name");

		$tblData12["Start_date"] = date("Y-m-d",strtotime($this->input->post("start_date"))); 
		$tblData12["End_date"] =  date("Y-m-d",strtotime($this->input->post("end_date")));
		
		$game_levels  = $this->input->post("game_levels");
		$level_points  = $this->input->post("level_points");
		
		if(count($game_levels) > 0)
		{
			$this->db->where(array("Campaign_id" => $Campaign_id,"Company_id" => $Company_Id));
			$this->db->update("igain_campaign_master",$tblData12);
			
			$this->db->where(array("Campaign_id" => $Campaign_id,"Company_id" => $Company_Id,"Company_game_id" =>$Company_game_id ));
			$this->db->delete("igain_game_campaign");
			
			$Game_id  = $this->input->post("Game_id");
			$tblData13["Game_id"]  = $this->input->post("Game_id");
			$tblData13["Company_id"]  = $Company_Id;
			$tblData13["Campaign_id"]  = $Campaign_id;
			
			
			$tblData13["Company_game_id"] = $Company_game_id;
			
			for($p = 0; $p < count($game_levels); $p++)
			{
				$tblData13["Game_level"]  = $game_levels[$p];
				$tblData13["Reward_points"]  = $level_points[$p];
				
				$this->db->insert("igain_game_campaign",$tblData13);
			}
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function game_winners_count($Company_id)
	{
		$this->db->from('igain_game_approve_temp');
		$this->db->where(array('Company_id'=>$Company_id,'flag'=>'0'));
		$this->db->group_by(array('Game_id','Points_Prize'));
		$this->db->order_by('Temp_id','asc ');
		
		$winnerIS = $this->db->get();
		
		return $winnerIS->num_rows();
	}
	
	public function get_game_winners($Company_id)
	{
		$todays_date = date("Y-m-d");
		$winner_level = 1;
		$i=0;
		$GameId=0;
			
		$this->db->select_max('Game_score','max_Game_score');
		$this->db->select('Game_level,Total_game_winner,a.Game_id,b.Company_game_id,Enrollment_id,Competition_winner_award');
		$this->db->from('igain_game_level_winner as a');
		$this->db->join('igain_game_company_master as b','a.Game_id=b.Game_id');
		$this->db->where(array('a.Company_id' => $Company_id,'b.Active_flag'=>'1','b.Game_for_competition' =>'1',
		'a.Game_type'=>'3','a.Game_winner_flag'=>'0','b.Competition_end_date < ' =>$todays_date));
		$this->db->group_by(array('a.Game_id','a.Enrollment_id'));
		$this->db->order_by('a.Game_id,max_Game_score', 'DESC');
		
		$game_query = $this->db->get();
		
		//echo $this->db->last_query();
	
		if($game_query->num_rows() > 0)
		{
			foreach($game_query->result() as $game_row22)
			{
				if($GameId != $game_row22->Game_id)
				{
					$winner_level = 1;
				}
				
				
				$Game_highscore = $game_row22->max_Game_score; //echo "---game score--".$Game_highscore."---<br><br>";
				$Game_level = $game_row22->Game_level;
				$Total_game_winner = $game_row22->Total_game_winner;
				$Game_id = $game_row22->Game_id;
				$Company_game_id = $game_row22->Company_game_id;
				$Enrollment_id = $game_row22->Enrollment_id;
				$Competition_winner_award = $game_row22->Competition_winner_award;
				
				$this->db->select('First_name,Middle_name,Last_name,Current_balance');
				$this->db->from('igain_enrollment_master');
				$this->db->where(array('Enrollement_id' => $Enrollment_id,'Company_id' =>$Company_id, 'User_activated' =>'1'));
			
				$member_query = $this->db->get();
		
				foreach($member_query->result() as $member_row)
				{
					$member_name = $member_row->First_name." ".$member_row->Middle_name." ".$member_row->Last_name;
					$Current_balance = $member_row->Current_balance;
				}
				//echo "---member_name --".$member_name."---<br><br>";
				$this->db->select('Game_name');
				$this->db->from('igain_game_master');
				$this->db->where('Game_id',$Game_id);
				$game_query2 = $this->db->get();
		
				foreach($game_query2->result() as $game_row2)
				{
					$Game_name = $game_row2->Game_name;
				}
				
				$this->db->select('Game_points_prize');
				$this->db->from('igain_game_company_child');
				$this->db->where(array('Company_game_id'=>$Company_game_id,'Game_id'=>$Game_id,'Competition_winner_level' =>$winner_level));
				$prize_query = $this->db->get();
		
				foreach($prize_query->result() as $prize_row)
				{
					$Game_points_prize = $prize_row->Game_points_prize;
				}
				
				if($Total_game_winner >= $winner_level)
				{
					$winner_level2 = "Winner ".$winner_level;
					
					$this->db->select('Temp_id');
					$this->db->from('igain_game_approve_temp');
					$this->db->where(array('Company_game_id'=>$Company_game_id,'Game_id'=>$Game_id,
					'Winner_Level'=>$winner_level2,'Company_id'=>$Company_id));
					 
					 $temp_query = $this->db->get();
						//echo "<br>---".$this->db->last_query();
					$numrows1 = $temp_query->num_rows();
					
					//echo "<br>--numrows1---".$numrows1."--<br>";
					
					if($numrows1 == 0)
					{
						$winnerData = array(
						'Company_id' => $Company_id,
						'Enrollment_id' => $Enrollment_id,
						'Winner_Name' => $member_name,
						'Winner_Level' => $winner_level2,
						'Points_Prize' => $Game_points_prize,
						'Company_game_id' => $Company_game_id,
						'Game_id' => $Game_id,
						'Game_Name' => $Game_name,
						'Highest_Score' => $Game_highscore,
						'Award_flag' => $Competition_winner_award,
						'Current_balance' => $Current_balance,

						);
						
						$this->db->insert('igain_game_approve_temp',$winnerData);
					}
					
					$winner_level++;
					$i=$i+1;
				}
				else
				{
					$i = 0;
					$winner_level = 1;
				}
				
				$GameId = $Game_id;
			}
		}
		
		
		$this->db->from('igain_game_approve_temp');
		$this->db->where(array('Company_id'=>$Company_id,'flag'=>'0'));
		$this->db->group_by(array('Enrollment_id'));
		$this->db->order_by('Temp_id','asc ');
		
		$winnerIS = $this->db->get();
		

		if($winnerIS->num_rows() > 0)
		{
			foreach($winnerIS->result() as $rowx)
			{
				$game_winnersis[] = $rowx;
			}
			
			return $game_winnersis;
		}
	}
	
	public function get_approved_game_winners($Company_id)
	{
		$this->db->from('igain_game_approve_temp');
		$this->db->where(array('Company_id'=>$Company_id,'flag'=>'1'));
		$this->db->group_by(array('Enrollment_id'));
		$this->db->order_by('Temp_id','asc ');
		
		$winnerISa = $this->db->get();
		
		if($winnerISa->num_rows() > 0)
		{
			foreach($winnerISa->result() as $rowxa)
			{
				$game_winnersisa[] = $rowxa;
			}
			
			return $game_winnersisa;
		}
	}
	
	public function approved_game_winner_info($Company_id,$temp_id)
	{
		$this->db->from('igain_game_approve_temp');
		$this->db->where(array('Company_id'=>$Company_id,'flag'=>'1','Temp_id' =>$temp_id));
		
		$winnerISb = $this->db->get();
		
		if($winnerISb->num_rows() > 0)
		{
			foreach($winnerISb->result() as $rowxb)
			{
				$game_winnersisb[] = $rowxb;
			}
			
			return $game_winnersisb;
		}
	}
	
	public function set_game_winners($temp_id,$comp_game_id,$Enrollment_id,$Current_bal,$award_flag,$prize,$Company_id)
	{
		$todays_date = date("Y-m-d");
		$this->db->where(array('Temp_id'=>$temp_id,'Company_game_id' => $comp_game_id, 'Enrollment_id' => $Enrollment_id, 'Company_id' =>$Company_id));
		$this->db->update('igain_game_approve_temp',array('flag' => '1'));
		
		$this->db->where(array('Company_game_id' => $comp_game_id, 'Enrollment_id' => $Enrollment_id, 'Company_id' =>$Company_id,'Game_type' => '3'));
		$this->db->update('igain_game_level_winner',array('Game_winner_flag' => 1));
		
		if($award_flag == 1)
		{
			$member_bal = $Current_bal + $prize;
			
			$this->db->where(array('Enrollement_id'=>$Enrollment_id,'Company_id'=>$Company_id));
			$this->db->update('igain_enrollment_master',array('Current_balance' => $member_bal));
			
			$trans_data = array(
			'Company_id' => $Company_id,
			'Trans_type' => '9',
			'Topup_amount' => $prize,
			'Trans_date' => $todays_date,
			'Enrollement_id' => $Enrollment_id,

			);
			
			$this->db->insert('igain_transaction',$trans_data);
		}
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
		
	}
	
}

?>
