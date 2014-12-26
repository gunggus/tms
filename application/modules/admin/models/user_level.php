<?php
	class User_level extends CI_Model
	{
	
		/**
	 * PT Gapura Angkasa
	 * Module : Admin
	 * Sub Module : User_level
	 *
	 * models : user_level
	 *
	 * url : http://{_base_url_}/application/modules/admin/models/user_level.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */
	 
	function __construct(){
	
		parent::__construct();
		
			$this->load->database();
	}
	
	# company -----------------------------------------------
	function manage_company($table, $id_field)
	{
		$this->db->order_by($id_field, 'ASC');
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function manage($table, $id_field, $relation_id_field, $parent_table, $parent_id_field, $parent_id)
	{
		$this->db->where($parent_id_field, $parent_id);
		$this->db->join($parent_table, '' . $table . '.' . $relation_id_field . ' = ' . $parent_table . '.' . $parent_id_field . '');
		
		$this->db->order_by($id_field, 'ASC');
		$query = $this->db->get($table);
		return $query->result();
		
	}
	
	function check_dup_company($table, $code_field, $code)
	{
		$query = $this->db->get_where($table,array($code_field=>$code));
		return $query->result();
	}
	
	function check_dup($table, $code_field, $code, $relation_id_field, $parent_id)
	{
		$query = $this->db->get_where($table,array($code_field=>$code, $relation_id_field=>$parent_id));
		return $query->result();
	}
	
	function save($table, $data)
	{
		$this->db->insert($table,$data);
		
		$id = $this->db->insert_id();
		
		if($table == 'var_company')
		{
			$query = $this->db->get_where('var_directorate',array('vd_vc_id'=>$id));
			if($query->num_rows() < 1)
			{
				$this->db->insert('var_directorate',array('vd_vc_id'=>$id, 'vd_code' => 'non', 'vd_name' => 'non'));
				$this->db->insert('var_station',array('vs_vd_id'=>$id, 'vs_code' => 'non', 'vs_name' => 'non'));
				$this->db->insert('var_unit',array('vu_vs_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_sub_unit',array('vsu_vu_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_team',array('vt_vsu_id'=>$id, 'vt_code' => 'non', 'vt_name' => 'non'));
			}
		}
		elseif($table == 'var_directorate')
		{
			$query = $this->db->get_where('var_station',array('vs_vd_id'=>$id));
			if($query->num_rows() < 1)
			{
				$this->db->insert('var_station',array('vs_vd_id'=>$id, 'vs_code' => 'non', 'vs_name' => 'non'));
				$this->db->insert('var_unit',array('vu_vs_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_sub_unit',array('vsu_vu_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_team',array('vt_vsu_id'=>$id, 'vt_code' => 'non', 'vt_name' => 'non'));
			}
		}
		elseif($table == 'var_station')
		{
			$query = $this->db->get_where('var_unit',array('vu_vs_id'=>$id));
			if($query->num_rows() < 1)
			{
				$this->db->insert('var_unit',array('vu_vs_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_sub_unit',array('vsu_vu_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_team',array('vt_vsu_id'=>$id, 'vt_code' => 'non', 'vt_name' => 'non'));
			}
		}
		elseif($table == 'var_unit')
		{
			$query = $this->db->get_where('var_sub_unit',array('vsu_vu_id'=>$id));
			if($query->num_rows() < 1)
			{
				$this->db->insert('var_sub_unit',array('vsu_vu_id'=>$id, 'vsu_code' => 'non', 'vsu_name' => 'non'));
				$this->db->insert('var_team',array('vt_vsu_id'=>$id, 'vt_code' => 'non', 'vt_name' => 'non'));
			}
		}
		elseif($table == 'var_sub_unit')
		{
			$query = $this->db->get_where('var_team',array('vt_vsu_id'=>$id));
			if($query->num_rows() < 1)
			{
				$this->db->insert('var_team',array('vt_vsu_id'=>$id, 'vt_code' => 'non', 'vt_name' => 'non'));
			}
		}
	}
	
	function edit($table, $id_field, $id)
	{
		$query = $this->db->get_where($table,array($id_field=>$id));
		return $query->result();
	}
	
	function update($table, $id_field, $id, $data)
	{
		$this->db->where($id_field, $id);
		$this->db->update($table,$data);
	}
	
	function delete($table, $id_field, $id)
	{
		$this->db->delete($table, array($id_field=>$id));
    }
	#---------------------------------------------------------
	#							STATION					     -
	#---------------------------------------------------------
	
	function manage_station()
    {
       	$this->db->order_by('vs_level', 'ASC');
		$query = $this->db->get('var_station');
		return $query->result();
	}
			
	function check_dup_stn_code($stn_code)
	{
		$query = $this->db->get_where('var_station',array('vs_code'=>$stn_code));
		return $query->result();
	}
	
	function get_stn_level()
	{
		$this->db->order_by('vs_level', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('var_station');
		
		if($query->num_rows > 0)
		{
			foreach($query->result() as $items):
				$level = $items->vs_level;
			endforeach;
				
			$get_level = $level + 1;
			if($get_level  < 10){ $get_level  = 0 . $get_level ;}
					
			return $get_level;
		}
		else
		{
			$get_level = '02';
			return $get_level;
		}
	}
	
	function save_station($data)
	{
		$query =$this->db->insert('var_station',$data);
	}
	
	function edit_station($stn_code)
	{
		$query = $this->db->get_where('var_station',array('vs_code'=>$stn_code));
		return $query->result();
	}
	
	function update_station($stn_code, $data)
	{
		$this->db->where('vs_code',$stn_code);
		$this->db->update('var_station',$data);
	}
			
	function delete_station($stn_code)
	{
		$this->db->delete('var_station', array('vs_id'=>$stn_code));
    }
		
	#---------------------------------------------------------
	#						 UNIT						     -
	#---------------------------------------------------------
	
	function manage_unit()
    {
       	$this->db->order_by('vu_level', 'ASC');
		$query = $this->db->get('var_unit');
		return $query->result();
	}
	
	function check_dup_unit_code($unit_code)
	{
		$query = $this->db->get_where('var_unit',array('vu_code'=>$unit_code));
		return $query->result();
	}
	
	function get_unit_level()
	{
		$this->db->order_by('vu_level', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('var_unit');
		
		if($query->num_rows > 0)
		{
			foreach($query->result() as $items):
				$level = $items->vu_level;
			endforeach;
				
			$get_level = $level + 1;
			if($get_level  < 10){ $get_level  = 0 . $get_level ;}
					
			return $get_level;
		}
		else
		{
			$get_level = '02';
			return $get_level;
		}
	}
	
	function save_unit($data)
	{
		$query =$this->db->insert('var_unit',$data);
	}
	
	function edit_unit($unit_code)
	{
		$query = $this->db->get_where('var_unit',array('vu_code'=>$unit_code));
		return $query->result();
	}
	
	function update_unit($unit_code, $data)
	{
		$this->db->where('vu_code',$unit_code);
		$this->db->update('var_unit',$data);
	}
			
	function delete_unit($unit_code)
	{
		$this->db->delete('var_unit', array('vu_code'=>$unit_code));
    }
		
	#---------------------------------------------------------
	#							SUB UNIT				     -
	#---------------------------------------------------------
	#input data dari form sub unit	
	function manage_sub_unit()
    {
       	$this->db->order_by('vsu_level', 'ASC');
		$query = $this->db->get('var_sub_unit');
		return $query->result();
	}
	
	function check_dup_sub_unit_code($sub_unit_code)
	{
		$query = $this->db->get_where('var_sub_unit',array('vsu_code'=>$sub_unit_code));
		return $query->result();
	}
	
	function get_sub_unit_level()
	{
		$this->db->order_by('vsu_level', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('var_sub_unit');
		
		if($query->num_rows > 0)
		{
			foreach($query->result() as $items):
				$level = $items->vsu_level;
			endforeach;
				
			$get_level = $level + 1;
			if($get_level  < 10){ $get_level  = 0 . $get_level ;}
					
			return $get_level;
		}
		else
		{
			$get_level = '02';
			return $get_level;
		}
	}
	
	function save_sub_unit($data)
	{
		$query =$this->db->insert('var_sub_unit',$data);
	}
	
	function edit_sub_unit($sub_unit_code)
	{
		$query = $this->db->get_where('var_sub_unit',array('vsu_code'=>$sub_unit_code));
		return $query->result();
	}
	
	function update_sub_unit($sub_unit_code, $data)
	{
		$this->db->where('vsu_code',$sub_unit_code);
		$this->db->update('var_sub_unit',$data);
	}
			
	function delete_sub_unit($sub_unit_code)
	{
		$this->db->delete('var_sub_unit', array('vsu_code'=>$sub_unit_code));
    }
			
	#---------------------------------------------------------
	#							TEAM					     -
	#---------------------------------------------------------	
	#input data dari form team	
	function manage_team()
    {
       	$this->db->order_by('vt_level', 'ASC');
		$query = $this->db->get('var_team');
		return $query->result();
	}
	
	
	function check_dup_team_code($team_code)
	{
		$query = $this->db->get_where('var_team',array('vt_code'=>$team_code));
		return $query->result();
	}
	
	function get_team_level()
	{
		$this->db->order_by('vt_level', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('var_team');
		
		if($query->num_rows > 0)
		{
			foreach($query->result() as $items):
				$level = $items->vt_level;
			endforeach;
				
			$get_level = $level + 1;
			if($get_level  < 10){ $get_level  = 0 . $get_level ;}
					
			return $get_level;
		}
		else
		{
			$get_level = '02';
			return $get_level;
		}
	}
	
	function save_team($data)
	{
		$query =$this->db->insert('var_team',$data);
	}
	
	function edit_team($team_code)
	{
		$query = $this->db->get_where('var_team',array('vt_code'=>$team_code));
		return $query->result();
	}
	
	function update_team($tean_code, $data)
	{
		$this->db->where('vt_code',$team_code);
		$this->db->update('var_team',$data);
	}
			
	function delete_team($team_code)
	{
		$this->db->delete('var_team', array('vt_code'=>$team_code));
    }
			
	#---------------------------------------------------------
	#							FUNGSI				     -
	#---------------------------------------------------------
	
	function get_all_fungsi()
    {
       	$this->db->order_by('vf_level', 'ASC');
		$query = $this->db->get('var_function');
		return $query->result();
	}
			
	function check_dup_vf_code($vf_code)
	{
		$query = $this->db->get_where('var_function',array('vf_code'=>$vf_code));
		return $query->result();
	}
	
	function get_vf_level()
	{
		$this->db->order_by('vf_level', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('var_function');
		
		if($query->num_rows > 0)
		{
			foreach($query->result() as $items):
				$level = $items->vf_level;
			endforeach;
				
			$get_level = $level + 1;
			if($get_level  < 10){ $get_level  = 0 . $get_level ;}
					
			return $get_level;
		}
		else
		{
			$get_level = '02';
			
			return $get_level;
		}
	}
	
	function save_fungsi($data)
	{
		$query =$this->db->insert('var_function',$data);
	}
	
	function edit_fungsi($vf_code)
	{
		$query = $this->db->get_where('var_function',array('vf_code'=>$vf_code));
		return $query->result();
	}
	
	function update_fungsi($vf_code,$vf_level, $data)
	{
		$this->db->where('vf_code',$vf_code);
		
		$this->db->update('var_function',$data);
	}
			
	function delete_fungsi($vf_code)
	{
		$this->db->delete('var_function', array('vf_code'=>$vf_code));
    }
		
			
	#---------------------------------------------------------
	#							POSITION				     -
	#---------------------------------------------------------		
	#input data dari form function	
	function add_position($data)
		{
			$query =$this->db->insert('var_position',$data);
		}
	function position_tabel()
    		{
				#memanggil nilai dari tabel 'var_position'
       			$query = $this->db->get('var_position');
				return $query->result();
			}

	function delete_position($id)
			{
        		#menghapus nilai berdasarkan id
				$this->db->delete('var_position', array('vp_code'=>$id));
    		}
		
	function edit_position($id)
			{
				$query = $this->db->get_where('var_position',array('vp_code'=>$id));
				return $query->row_array();
			}
	}
	
	/* End of file user_level.php */
	/* Location: ./application/modules/admin/models/user_level.php */
	
?>