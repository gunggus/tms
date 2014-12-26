<?php
	class User_access_model extends CI_Model
	{
	
	/**
	 * PT Gapura Angkasa
	 * Module : Admin
	 * Sub Module : User_access_model
	 *
	 * models : user_access_model
	 *
	 * url : http://{_base_url_}/application/modules/admin/models/user_access_model.php
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
	
	function get_user_access($ui_nipp_encrypt)
    {
		$this->db->where('ua_nipp', $ui_nipp_encrypt);
		$this->db->where('ua_end', '0000-00-00 00:00:00');
		#$this->db->or_where('ua_end >', date("Y-m-d H:i:s")); 
		$query = $this->db->get('user_access');
		return $query->result();
	}
	
	function get_all_module($ui_nipp_encrypt)
    {
		$query = ("
		SELECT * FROM var_module WHERE NOT EXISTS
    	(SELECT * FROM user_access
     	WHERE user_access.ua_nipp = '" . $ui_nipp_encrypt ."' AND user_access.ua_vm_id = var_module.vm_id AND user_access.ua_end = '0000-00-00 00:00:00')
		ORDER BY vm_name, vm_sub_module ASC;
		");
		
		
		$query = $this->db->query($query);
		return $query->result();
	}
	
	function save_access($data)
	{
		$this->db->insert('user_access', $data); 
	}
	
	function get_access_by_id($ua_id)
	{
		$this->db->where('ua_id', $ua_id);
		$query = $this->db->get('user_access');
		return $query->result();
	}
	
	function ending_prev_roles($ua_id)
	{
		$this->db->where('ua_id', $ua_id);
		$this->db->update('user_access', array('ua_end' => date("Y-m-d H:i:s"))); 
	}
	
	
}

/* End of file user_access_model.php */
/* Location: ./application/modules/admin/models/user_access_model.php */

?>