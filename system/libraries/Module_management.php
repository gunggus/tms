<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Module_management {
	
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
	
	public function module_main_hide($data)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		if(!isset($CI->session->userdata['logged_in'])){return TRUE;}
		$ua_nipp = $CI->encrypt->sha1($CI->session->userdata['logged_in']['ui_nipp']);
		$ua_module = $data['ua_module'];
			
		/*
		$CI->db->where('ua_nipp', $ua_nipp);
		$CI->db->where('ua_module', $ua_module);
		$module_hide = $CI->db->get('user_access');
		*/
		$time = mdate("%Y-%m-%d %H:%i:%s",time());
		$query = " 	SELECT * FROM user_access
					JOIN var_module ON (vm_name = '$ua_module')
					WHERE ua_nipp = '$ua_nipp'   
					AND ua_module = '$ua_module'
					AND (ua_end = '0000-00-00 00:00:00'  OR  ua_end > '$time')
					AND vm_hide = 'n'
				";
		$module_hide = $CI->db->query($query);
		if($module_hide->num_rows() >= 1 OR $CI->session->userdata('ui_email') == $CI->config->item('admin_email')){return FALSE;}else{return TRUE;}
	}
	
	public function module_sub_hide($data)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->helper('array');
		$CI->load->helper('url');
		$CI->load->library('session');
		
		if(!isset($CI->session->userdata['logged_in'])){return TRUE;}
		$ua_nipp = $CI->encrypt->sha1($CI->session->userdata['logged_in']['ui_nipp']);
		$ua_module = $data['ua_module'];
		$ua_sub_module = $data['ua_sub_module'];
		/*
		$CI->db->where('vm_hide', 'n');
		$CI->db->where('vm_name', $ua_module);
		$CI->db->where('vm_sub_module', $ua_sub_module);
		$module_hide = $CI->db->get('var_module');
		*/
		$time = mdate("%Y-%m-%d %H:%i:%s",time());
		$query = " 	SELECT * FROM user_access
					JOIN var_module ON (vm_name = '$ua_module'   AND vm_sub_module = '$ua_sub_module')
					WHERE ua_nipp = '$ua_nipp'   
					AND ua_module = '$ua_module'
					AND ua_sub_module = '$ua_sub_module'
					AND (ua_end = '0000-00-00 00:00:00'  OR  ua_end > '$time')
					AND vm_hide = 'n'
				";
		$module_hide = $CI->db->query($query);
		#OR $CI->session->userdata('ui_email') == $CI->config->item('admin_email')
		//if($module_hide->num_rows() > 0 ){return FALSE;}else{return TRUE;}
		if($module_hide->num_rows() >= 1 OR $CI->session->userdata('ui_email') == $CI->config->item('admin_email')){return FALSE;}else{return TRUE;}
	}
	
}

/* End of file Someclass.php */