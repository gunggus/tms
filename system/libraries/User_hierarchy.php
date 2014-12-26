<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_hierarchy {

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

# finding upline --------------------
	
	public function up_to_supervisor()
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
			return $CI->user_hierarchy->up_to_assistant_manager();
		}
	}
	
	public function up_to_assistant_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 10) . '__22\'
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
			return $CI->user_hierarchy->up_to_manager();
		}
		
	}
	
	
	public function up_to_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____18\'
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
			return $CI->user_hierarchy->up_to_general_manager();
		}
	}
	
	
	public function up_to_general_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______12\'
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
			return $CI->user_hierarchy->up_to_director();
		}
	}
	
	public function up_to_director()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________03\'
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
			return $CI->user_hierarchy->up_to_company_member();
		}
	}
	
	
	public function up_to_company_member()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 2) . '____________\'
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
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
	public function up_to_own()
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
		WHERE ui_nipp = \'' . $ui_nipp . '\'
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
			return FALSE;
		}
	}
	
# finding upline --------------------


# finding same level ----------------

	public function staff_to_staff()
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
			return $CI->user_hierarchy->up_to_supervisor();
		}
	}
	
	public function supervisor_to_supervisor()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 10) . '__26\'
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
			return $CI->user_hierarchy->up_to_assistant_manager();
		}
	}
	
	
	public function assistant_manager_to_assistant_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____22\'
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
			return $CI->user_hierarchy->up_to_manager();
		}
	}
	
	
	public function manager_to_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______18\'
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
			return $CI->user_hierarchy->up_to_general_manager();
		}
	}

	public function general_manager_to_general_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________12\'
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
			return $CI->user_hierarchy->up_to_director();
		}
	}

	public function director_to_director()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 2) . '__________03\'
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
			return $CI->user_hierarchy->up_to_own();
		}
	}

# finding same level ----------------	

# finding downline ------------------

	public function director_to_general_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________12\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->director_to_manager();
		}
	}

	public function director_to_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________18\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->director_to_assistant_manager();
		}
	}
	
	public function director_to_assistant_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________22\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->director_to_supervisor();
		}
	}
	
	public function director_to_supervisor()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________26\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->director_to_staff();
		}
	}
	
	public function director_to_staff()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 4) . '________30\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
	public function general_manager_to_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______18\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->general_manager_to_assistant_manager();
		}
	}
	
	public function general_manager_to_assistant_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______22\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->general_manager_to_supervisor();
		}
	}
	
	public function general_manager_to_supervisor()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______26\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->general_manager_to_staff();
		}
	}
	
	public function general_manager_to_staff()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 6) . '______30\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
	public function manager_to_assistant_manager()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____22\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->manager_to_supervisor();
		}
	}
	
	public function manager_to_supervisor()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____26\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->manager_to_staff();
		}
	}
	
	public function manager_to_staff()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 8) . '____30\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
	public function assistant_manager_to_supervisor()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 10) . '__26\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# Supervisor Found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->assistant_manager_to_staff();
		}
	}
	
	public function assistant_manager_to_staff()
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
		WHERE ui_level LIKE \'' . substr($ui_level, 0, 10) . '__30\'
		AND ui_nipp <> \'' . $ui_nipp . '\'
		');
		
		$query = $CI->db->query($query);
		
		if($query->num_rows() > 0)
		{
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
	public function supervisor_to_staff()
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
			# gm found
			return $query->result();
		}
		else
		{
			# no supervisor found, try to get ass mgr
			return $CI->user_hierarchy->up_to_own();
		}
	}
	
# finding downline ------------------

# Get Upline 
	public function get_upline()
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
			return $CI->user_hierarchy->up_to_supervisor();
		}
		elseif($level == '26')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->up_to_assistant_manager();
		}
		elseif($level == '22')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->up_to_manager();
		}
		elseif($level == '18')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->up_to_general_manager();
		}
		elseif($level == '12')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->up_to_director();
		}
		elseif($level == '03')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->up_to_comapny_member();
		}
	}

# get colleagues --------------------
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
			return $CI->user_hierarchy->staff_to_staff();
		}
		elseif($level == '26')
		{
			# supervisor find supervisor
			return $CI->user_hierarchy->supervisor_to_supervisor();
		}
		elseif($level == '22')
		{
			# ass mgr find ass mgr
			return $CI->user_hierarchy->assistant_manager_to_assistant_manager();
		}
		elseif($level == '18')
		{
			# mgr find mgr
			return $CI->user_hierarchy->manager_to_manager();
		}
		elseif($level == '12')
		{
			# mgr find gen mgr
			return $CI->user_hierarchy->general_manager_to_general_manager();
		}
		
	}	

# get colleagues --------------------------

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
			return $CI->user_hierarchy->director_to_general_manager();
		}
		
		elseif ($level == '03')
		{
			#vice president find general manager
			return $CI->user_hierarchy->director_to_manager();
		}
		
		elseif ($level == '03')
		{
			#vice president find general manager
			return $CI->user_hierarchy->director_to_asistant_manager();
		}
		
		elseif ($level == '03')
		{
			#vice president find general manager
			return $CI->user_hierarchy->director_to_supervisor();
		}
		
		elseif ($level == '03')
		{
			#vice president find general manager
			return $CI->user_hierarchy->director_to_staff();
		}
		
		elseif($level == '12')
		{
			# general manager find manager
			return $CI->user_hierarchy->general_manager_to_manager();
		}
		
		elseif($level == '12')
		{
			# general manager find manager
			return $CI->user_hierarchy->general_manager_to_assistant_manager();
		}
		
		elseif($level == '12')
		{
			# general manager find manager
			return $CI->user_hierarchy->general_manager_to_supervisor();
		}
		
		elseif($level == '12')
		{
			# general manager find manager
			return $CI->user_hierarchy->general_manager_to_staff();
		}
		
		elseif($level == '18')
		{
			# manager find assistan manager
			return $CI->user_hierarchy->manager_to_assistant_manager();
		}
		
		elseif($level == '18')
		{
			# manager find assistan manager
			return $CI->user_hierarchy->manager_to_supervisor();
		}
		
		elseif($level == '18')
		{
			# manager find assistan manager
			return $CI->user_hierarchy->manager_to_staff();
		}
		
		elseif($level == '22')
		{
			# assistant manager find supervisor
			return $CI->user_hierarchy->assistant_manager_to_supervisor();
		}
		
		elseif($level == '22')
		{
			# assistant manager find supervisor
			return $CI->user_hierarchy->assistant_manager_to_staff();
		}
		
		elseif($level == '26')
		{
			# supervisor find staff
			return $CI->user_hierarchy->supervisor_to_staff();
		}
			
	}
	
}

/* End of file Someclass.php */