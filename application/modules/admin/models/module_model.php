<?php
	class Module_model extends CI_Model
	{
	
	/**
	 * PT Gapura Angkasa
	 * Module : Admin
	 * Sub Module : Module_model
	 *
	 * models : module_model
	 *
	 * url : http://{_base_url_}/application/modules/admin/models/module_model.php
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
	
	function get_all_module()
    {
       	$this->db->order_by('vm_name', 'ASC');
		$query = $this->db->get('var_module');
		return $query->result();
	}
	
	
	/*function check_sub_module()
	{
		$query = $this->db->get_where('var_module', array('vm_name' => 'user', 'vm_sub_module' => 'login', 'vm_active' => 'y'), 1, 0);
		if($query->num_rows() > 0 ){return TRUE;}else{return FALSE;}	
	}*/
	
	function check_module_sub_module($vm_name, $vm_sub_module)
	{
		$query = $this->db->get_where('var_module', array('vm_name' => $vm_name, 'vm_sub_module' => $vm_sub_module));
		if($query->num_rows() > 0 ){return TRUE;}else{return FALSE;}
	}
	
	function save_module($data)
	{
		$this->db->insert('var_module',$data);
		return $this->db->insert_id();
	}
	
	function edit_module($mod_name)
	{
		$query = $this->db->get_where('var_module',array('vm_name'=>$mod_name));
		return $query->result();
	}
	
	function publish_module($mod_id)
	{	
		$data = array(
			 'vm_active' => 'y',
		);
		
		$this->db->where('vm_id', $mod_id);
		$this->db->update('var_module', $data);
		
	}
	
	function undo_publish_module($mod_id)
	{
		$data = array(
              'vm_active' => 'n',
		);
		$this->db->where('vm_id', $mod_id);
		$this->db->update('var_module', $data);
	}
	
	function show_module($mod_id)
	{	
		$data = array(
			 'vm_hide' => 'n',
		);
		
		$this->db->where('vm_id', $mod_id);
		$this->db->update('var_module', $data);
		
	}
	
	function hide_module($mod_id)
	{
		$data = array(
              'vm_hide' => 'y',
		);
		$this->db->where('vm_id', $mod_id);
		$this->db->update('var_module', $data);
	}
}

/* End of file module_model.php */
/* Location: ./application/modules/admin/models/module_model.php */
?>