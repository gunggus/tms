<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_access {

	public function level()
    {
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('encrypt');
		$CI->load->library('session');
		
		
		if($CI->session->userdata['logged_in']['ui_email'] == $CI->config->item('admin_email'))
		{
			$ua_roles = 50;
			return $ua_roles;
		}
		else
		{
			$ua_nipp = $CI->encrypt->sha1($CI->session->userdata['logged_in']['ui_nipp']);
			$ua_module = $CI->uri->segment(1);
			$ua_sub_module = $CI->uri->segment(2);
		
			$CI->db->select('ua_roles');
			$CI->db->where('ua_nipp', $ua_nipp);
			$CI->db->where('ua_module', $ua_module);
			$CI->db->where('ua_sub_module', $ua_sub_module);
			$CI->db->where('ua_end', '0000-00-00 00:00:00');
			$CI->db->or_where('ua_end >', date("Y-m-d H:i:s")); 
			$user_level = $CI->db->get('user_access');
		
			if($user_level->num_rows() == 0)
			{
				$ua_roles = 0;
				return $ua_roles;
			}
			else
			{
				foreach($user_level->result() as $items):$ua_roles = $items->ua_roles;endforeach;
				return $ua_roles;
			}
		}
	}
	
	public function create_email_check($data)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('encrypt');
		$CI->load->library('session');
		
		# create directory if not exist
		$dir = FCPATH . 'wp-uploads/data/tmp/';
		if (!is_dir($dir)){@mkdir($dir);}
		
		$ui_id = $data['ui_id'];
		$ui_email = $data['ui_email'];
		
		write_file(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', $CI->encrypt->encode($ui_email));
		chmod(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', 0600);
			
	}
	
	public function check_email($data)
	{
		$CI =& get_instance();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('encrypt');
		$CI->load->library('session');
		
		$ui_id = $data['ui_id'];
		
		@chmod(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', 0777);
		$email_db = $CI->encrypt->decode(@file_get_contents(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp'));
		@chmod(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', 0600);
		
		return $email_db;
	}
	
	
	
	public function get_all_staff()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . $ui_level . '\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# supervisor found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_access->get_all_supervisor();
		}
	}
	
	public function get_all_supervisor()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 10) . '__11\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# supervisor found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_access->get_all_assistant_manager();
		}
	}
	
	
	public function get_all_assistant_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____10\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# ass manager found
			return $query->result();
		}
		else
		{
			# ass mgr not found, try to get mgr
			return $CI->user_access->get_all_manager();
		}
	}
	
	
	public function get_all_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______09\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_all_general_manager();
		}
	}
	
	public function get_all_general_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________06\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_all_vice_president();
		}
	}
	
	public function get_all_vice_president()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________05\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_all_director();
		}
	}
	
	public function get_all_director()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 2) . '__________03\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# director not found, back to him self
			$query =('
			SELECT * FROM user_identity
			WHERE ui_nipp <> \'' . $ui_nipp . '\'
			');
			
			$query = $CI->db->query($query);
			return $query->result();
		}
	}
	
	public function get_all_company_member()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 2) . '____________\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			$query =('
			SELECT * FROM user_identity
			WHERE ui_nipp <> \'' . $ui_nipp . '\'
			');
			
			$query = $CI->db->query($query);
			return $query->result();
		}
	}
	
	public function get_my_staff()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 12) . '30\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# supervisor found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_access->get_my_supervisor();
		}
	}
	
	public function get_my_supervisor()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 12) . '26\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# supervisor found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_access->get_my_assistant_manager();
		}
	}
	
	
	public function get_my_assistant_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______22\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# ass manager found
			return $query->result();
		}
		else
		{
			# ass mgr not found, try to get mgr
			return $CI->user_access->get_my_manager();
		}
	}
	
	
	public function get_my_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______18\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_my_general_manager();
		}
	}
	
	public function get_my_general_manager()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______12\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_my_vice_president();
		}
	}
	
	public function get_my_vice_president()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________08\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			return $CI->user_access->get_my_director();
		}
	}
	
	public function get_my_director()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________03\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# director not found, back to him self
			$query =('
			SELECT * FROM user_identity
			WHERE ui_nipp <> \'' . $ui_nipp . '\'
			');
			
			$query = $CI->db->query($query);
			return $query->result();
		}
	}
	
	public function get_my_company_member()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$query =('
		SELECT * FROM user_identity
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 2) . '____________\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# manager found
			return $query->result();
		}
		else
		{
			# manager not found, try to get general mgr
			$query =('
			SELECT * FROM user_identity
			WHERE ui_nipp <> \'' . $ui_nipp . '\'
			');
			
			$query = $CI->db->query($query);
			return $query->result();
		}
	}

	
	public function get_upline()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$level = substr($ui_level, -2);
		
		if($level == '30')
		{
			# staff find supervisor
			return $CI->user_access->get_my_supervisor();
		}
		elseif($level == '26')
		{
			# supervisor find assman
			return $CI->user_access->get_my_assistant_manager();
		}
		elseif($level == '22')
		{
			# assman mgr find manager
			return $CI->user_access->get_my_manager();
		}
		elseif($level == '18')
		{
			# manager find general manager
			return $CI->user_access->get_my_general_manager();
		}
		
		elseif($level == '12')
		{
			# general manager find vice president
			return $CI->user_access->get_my_vice_president();
		}
		
		elseif($level == '08')
		{
			# vice president fin direktur
			return $CI->user_access->get_my_director();
		}
		
	}
	
	
	public function get_colleagues()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$level = substr($ui_level, -2);
		
		if($level == '30')
		{
			# staff find staff
			return $CI->user_access->get_all_staff();
		}
		elseif($level == '26')
		{
			# supervisor find supervisor
			return $CI->user_access->get_all_supervisor();
		}
		elseif($level == '22')
		{
			# ass mgr find ass mgr
			return $CI->user_access->get_all_assistant_manager();
		}
		elseif($level == '18')
		{
			# mgr find mgr
			return $CI->user_access->get_all_manager();
		}
		elseif($level == '12')
		{
			# mgr find gen mgr
			return $CI->user_access->get_all_general_manager();
		}
		
	}
	
	
	public function get_downline()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_nipp = $CI->session->userdata['logged_in']['ui_nipp'];
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$level = substr($ui_level, -2);
		
		if ($level == '03')
		{
			#direktur find vice president
			return $CI->user_access->get_my_vice_president();
		}
		
		elseif ($level == '08')
		{
			#vice president find general manager
			return $CI->user_access->get_my_general_manager();
		}
		
		elseif($level == '12')
		{
			# general manager find manager
			return $CI->user_access->get_my_manager();
		}
		
		elseif($level == '18')
		{
			# manager find assistan manager
			return $CI->user_access->get_my_assistant_manager();
		}
		
		elseif($level == '22')
		{
			# assistant manager find supervisor
			return $CI->user_access->get_my_supervisor();
		}
		
		elseif($level == '26')
		{
			# supervisor find staff
			return $CI->user_access->get_my_staff();
		}
		
		elseif($level == '30')
		{
			# staff find staff
			return $CI->user_access->get_my_staff();
		}
		
	}
	
	public function level_decrypt()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ui_level = $CI->session->userdata['logged_in']['ui_level'];
		
		$company = substr ($ui_level, 0, 2);
		$result = $CI->db->where( 'vc_id', $company )->get( 'var_company' )->result();
		foreach($result as $items):$data['company_code'] = $items->vc_code;$data['company_name'] = $items->vc_name;endforeach;
		
		$directorate = substr ($ui_level, 2, 2);
		$result = $CI->db->where( 'vd_id', $directorate )->get( 'var_directorate' )->result();
		foreach($result as $items):$data['directorate_code'] = $items->vd_code;$data['directorate_name'] = $items->vd_name;endforeach;
		
		$station = substr ($ui_level, 4, 2);
		$result = $CI->db->where( 'vs_id', $station )->get( 'var_station' )->result();
		foreach($result as $items):$data['station_code'] = $items->vs_code;$data['station_name'] = $items->vs_name;endforeach;
		
		$unit = substr ($ui_level, 6, 2);
		$result = $CI->db->where( 'vu_id', $unit )->get( 'var_unit' )->result();
		foreach($result as $items):$data['unit_code'] = $items->vu_code;$data['unit_name'] = $items->vu_name;endforeach;
		
		$sub_unit = substr ($ui_level, 8, 2);
		$result = $CI->db->where( 'vsu_id', $sub_unit )->get( 'var_sub_unit' )->result();
		foreach($result as $items):$data['sub_unit_code'] = $items->vsu_code;$data['sub_unit_name'] = $items->vsu_name;endforeach;
		
		$team = substr ($ui_level, 10, 2);
		$result = $CI->db->where( 'vt_id', $team )->get( 'var_team' )->result();
		foreach($result as $items):$data['team_code'] = $items->vt_code;$data['team_name'] = $items->vt_name;endforeach;
		
		$pangkat = substr ($ui_level, 12, 2);
		$result = $CI->db->where( 'vf_level', $pangkat )->get( 'var_function' )->result();
		foreach($result as $items):$data['pangkat_code'] = $items->vf_code;$data['pangkat_name'] = $items->vf_name;endforeach;
		
		return $data;
	}
	
	public function encrypt_md5($email_encrypt, $password)
	{
		$CI =& get_instance();
		
		return hash("haval256,5", $CI->config->item('encryption_key') . $email_encrypt . $password);
	}
	
	public function module_active()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		$ua_module = $CI->uri->segment(1);
		$ua_sub_module = $CI->uri->segment(2);
		
		$CI->db->where('vm_active', 'y');
		$CI->db->where('vm_name', $ua_module);
		$CI->db->where('vm_sub_module', $ua_sub_module);
		$module_active = $CI->db->get('var_module');
		if($module_active->num_rows() > 0 OR $CI->session->userdata['logged_in']['ui_email'] == $CI->config->item('admin_email'))
		{return TRUE;}else{return FALSE;}
	}
	
}

/* End of file Someclass.php */