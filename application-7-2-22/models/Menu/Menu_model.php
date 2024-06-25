<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model 
{
	function create_menu()
    {
		$data['Menu_level'] = $this->input->post('menu_level');
		$data['Menu_name'] = $this->input->post('menu_name');        
		$data['Parent_menu_id'] = $this->input->post('parent_menu_id');
		$data['Menu_href'] = $this->input->post('menu_href');
		
		$data['Active_flag'] = '1';
		if($_REQUEST['License_type'] != NULL)
		{
			foreach($_REQUEST['License_type'] as $License_type)
			{
				$data['License_type'] = $License_type;
				$this->db->insert('igain_menu_master', $data);	
			}
		}
			
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
    }
	
	function get_parent_menu($menu_level)
	{
		$this->db->select("Menu_id,Menu_name");
		$this->db->from('igain_menu_master');
		
		if($menu_level == 1)
		{
			$this->db->where(array('Menu_level' => '0','Active_flag' => '1'));
		}
		else
		{
			$this->db->where(array('Menu_level' => '1','Active_flag' => '1'));
		}
		
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function menu_count()
	{
		return $this->db->count_all("igain_menu_master");
	}
	
	public function menu_list($limit,$start)
	{
		$this->db->limit($limit,$start);
		$this->db->where('Active_flag',1);
		$this->db->order_by('Menu_id','DESC');
        $query = $this->db->get("igain_menu_master");

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
	public function edit_menu($Menu_id)
	{	   
		$this->db->where('Menu_id', $Menu_id);
		$query = $this->db->get("igain_menu_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	
	public function update_menu($post_data,$Menu_id)
	{
		$this->db->where('Menu_id', $Menu_id);
		$this->db->update("igain_menu_master", $post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function delete_menu($Menu_id)
	{
		// $this->db->where("Menu_id",$Menu_id);
		// $this->db->delete("igain_menu_master");
		
		$this->db->where('Menu_id', $Menu_id);
		$this->db->update("igain_menu_master", array('Active_flag' => '0'));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function get_level_0_menu($License_type)
	{
		$this->db->order_by('Menu_id','ASC');
		$this->db->where('Active_flag', 1);
		$this->db->where('Menu_level', '0');
		$this->db->where('License_type', $License_type);
        $query = $this->db->get("igain_menu_master");

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
   
	public function get_level_1_menu($Menu_id)
	{
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Menu_level' => '1','Active_flag' => '1', 'Parent_menu_id' => $Menu_id));
		
        $query = $this->db->get("igain_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function get_level_2_menu($Menu_id)
	{
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Menu_level' => '2','Active_flag' => '1', 'Parent_menu_id' => $Menu_id));
		
        $query = $this->db->get("igain_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	function get_user_types($Loggin_User_id)
	{
		$this->db->select("User_id,User_type");
		$this->db->from('igain_user_type_master');
		
		if($Loggin_User_id == 3)
		{
			$this->db->where_not_in('User_id', array('1','3'));
		}
		else
		{
			$this->db->where_not_in('User_id', array('1','3','4'));
		}
		
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function get_usernames($User_type,$Company_id)
	{
		$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller,Sub_seller_admin,User_id");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id, 'User_id' => $User_type, 'User_activated' => '1'));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function assign_menu($post_data)
    {
		$this->db->insert('igain_menu_assign', $post_data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
    }
	
	function check_menu($Enrollment_id,$Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Enrollment_id' => $Enrollment_id, 'Menu_id' => $Menu_id));
		return $this->db->count_all_results('igain_menu_assign');
	}
	
	public function get_assigned_level_0_menu($Enrollment_id,$Company_id)
	{
		$this->db->select("A.Menu_id,A.Menu_level,A.Parent_id,A.Enrollment_id,A.Company_id");
		$this->db->from('igain_menu_assign as A');
		$this->db->join('igain_company_menu_master as B','A.Menu_id=B.Menu_id AND A.Company_id=B.Company_id','left');
		$this->db->order_by('A.Menu_id','ASC');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Enrollment_id' => $Enrollment_id, 'A.Menu_level' => '0', 'B.Active_flag' => '1'));
        $query = $this->db->get();

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
	
	public function get_assigned_level_1_menu($Enrollment_id,$Company_id,$Menu_id)
	{
		$this->db->select("A.Menu_id,A.Menu_level,A.Parent_id,A.Enrollment_id,A.Company_id");
		$this->db->from('igain_menu_assign as A');
		$this->db->join('igain_company_menu_master as B','A.Menu_id=B.Menu_id AND A.Company_id=B.Company_id','left');
		$this->db->order_by('A.Menu_id','ASC');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Enrollment_id' => $Enrollment_id, 'A.Menu_level' => '1', 'B.Active_flag' => '1', 'A.Parent_id' => $Menu_id));
        $query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function get_assigned_level_2_menu($Enrollment_id,$Company_id,$Menu_id)
	{
		$this->db->select("A.Menu_id,A.Menu_level,A.Parent_id,A.Enrollment_id,A.Company_id");
		$this->db->from('igain_menu_assign as A');
		$this->db->join('igain_company_menu_master as B','A.Menu_id=B.Menu_id AND A.Company_id=B.Company_id','left');
		$this->db->order_by('A.Menu_id','ASC');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Enrollment_id' => $Enrollment_id, 'A.Menu_level' => '2', 'B.Active_flag' => '1', 'A.Parent_id' => $Menu_id));
        $query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function get_level_1_assigned_menus($post_data)
	{
		$this->db->where($post_data);
        $query = $this->db->get("igain_menu_assign");
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	function delete_assigned_menu($post_data)
    {
		$this->db->delete('igain_menu_assign', $post_data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
    }
	
	function fetch_companys()
	{
		$fetch_query = "SELECT Company_id,Company_name,Company_License_type from  igain_company_master where Partner_company_flag=0 AND Activated=1";		
		$run_sql = $this->db->query($fetch_query);
		
		if($run_sql->num_rows() > 0)
		{
			return $run_sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_company_assigned_level_1_menu($Company_id,$Menu_id)
	{
		$this->db->select("Menu_id,Menu_level,Parent_menu_id,Menu_name,Menu_href");
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Company_id' => $Company_id, 'Menu_level' => '1', 'Parent_menu_id' => $Menu_id));
        $query = $this->db->get("igain_company_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function get_company_assigned_level_0_menu($Company_id)
	{
		$this->db->select("Menu_id,Menu_level,Parent_menu_id,Menu_name,Menu_href,Company_id");
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Company_id' => $Company_id, 'Menu_level' => '0', 'Active_flag' => '1'));
        $query = $this->db->get("igain_company_menu_master");
		
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
	
	public function get_company_assigned_level_2_menu($Company_id,$Menu_id)
	{
		$this->db->select("Menu_id,Menu_level,Parent_menu_id,Menu_name,Menu_href");
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Company_id' => $Company_id, 'Menu_level' => '2', 'Parent_menu_id' => $Menu_id));
        $query = $this->db->get("igain_company_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function get_company_menu_details($Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Menu_id' => $Menu_id));
        $query = $this->db->get("igain_company_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
	
	public function check_menu_parent($Menu_id)
	{
		$this->db->where(array('Parent_menu_id' => $Menu_id));
        $query = $this->db->count_all_results('igain_company_menu_master');		
        return $query;
	}
	
	public function check_menu_parent2($Company_id,$Menu_id)
	{
		$this->db->select('Parent_menu_id,Menu_level');
		$this->db->where(array('Menu_id' => $Menu_id, 'Company_id' => $Company_id));
        // $query = $this->db->count_all_results('igain_company_menu_master');		
        return $this->db->get('igain_company_menu_master')->row();
	}
	
	public function check_assigned_menu_parent($Enrollment_id,$Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Enrollment_id' => $Enrollment_id, 'Parent_id' => $Menu_id));
		// $this->db->where(array('Parent_menu_id' => $Menu_id));
        $query = $this->db->count_all_results('igain_menu_assign');		
        return $query;
	}
	
	public function check_assigned_menu_parent2($Enrollment_id,$Company_id,$Menu_id)
	{
		$this->db->select('Parent_id,Menu_level');
		$this->db->where(array('Company_id' => $Company_id, 'Enrollment_id' => $Enrollment_id, 'Menu_id' => $Menu_id));
		return $this->db->get('igain_menu_assign')->row();
	}
	
	public function get_menu_details_from_href($Company_id,$Menu_href)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Menu_href' => $Menu_href));
        $query = $this->db->get("igain_company_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->row();
        }
		else
		{
			return false;
		}
	}
	
	public function delete_company_menus($Company_id)
	{
		$this->db->where(array('Company_id' => $Company_id));
		$this->db->delete('igain_company_menu_master');
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function delete_company_child_menus($Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Parent_menu_id' => $Menu_id));
		$this->db->delete('igain_company_menu_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function check_parent_menu_available($Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Menu_id' => $Menu_id));
        $query = $this->db->count_all_results('igain_company_menu_master');		
        return $query;
	}
		public function Get_Code_decode_master($Code_decode_type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_type_id',$Code_decode_type_id);
		$this->db->order_by('Code_decode_id','DESC');
		$query = $this->db->get();
		
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
      public function Get_Specific_Code_decode_master($Code_decode_id)
	{
		$this->db->select('Code_decode');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_id',$Code_decode_id);
		
		$query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
        	/* foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; */
			return $query->row();
        }
        return false;
   }
   public function delete_company_user_menus($Company_id,$Menu_id)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Menu_id' => $Menu_id));
		$this->db->delete('igain_menu_assign');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		public function get_users_assigned_menus($Enrollment_id,$Company_id)
	{
		$this->db->select("Menu_id");
		$this->db->order_by('Menu_id','ASC');
		$this->db->where(array('Company_id' => $Company_id, 'Enrollment_id' => $Enrollment_id));
        $query = $this->db->get("igain_menu_assign");

        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $data[] = $row->Menu_id;
            }
            return $data;
        }
        return false;
	}
	
	// ************* 10-07-2019 *********************
	
	//****************** sandeep 16-08-2019 ******************************
	function check_menu_name($menuName)
	{
			$this->db->select('Menu_id')
			->from('igain_menu_master')
			->where(array('Menu_name' => $menuName));
			$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	//****************** sandeep 16-08-2019 ******************************
}
?>