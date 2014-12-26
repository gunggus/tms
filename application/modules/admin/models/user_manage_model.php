<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_manage_model extends CI_Model
{

	/**
	 * PT Gapura Angkasa
	 * Module : Admin
	 * Sub Module : Usee_manage_model
	 *
	 * models : user_manage_model
	 *
	 * url : http://{_base_url_}/application/modules/admin/models/user_manage_model.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */
	 
	# get all user
	function get_all_user()
	{
		$query = $this->db->get('user_identity');
		return $query->result();
	}
	
	function get_all_active()
	{
		$this->db->where('ui_approval', 'y');
		$query = $this->db->get('user_identity');
		return $query->result();
	}
	
	function get_all_suspend()
	{
		$this->db->where('ui_approval', 'n');
		$query = $this->db->get('user_identity');
		return $query->result();
	}

	function activated_user($ui_id)
	{	
		$data = array(
			 'ui_approval' => 'y',
		);
		
		$this->db->where('ui_id', $ui_id);
		$this->db->update('user_identity', $data);
	}
	
	function suspended_user($ui_id)
	{	
		$data = array(
			 'ui_approval' => 'n',
		);
		
		$this->db->where('ui_id', $ui_id);
		$this->db->update('user_identity', $data);
	}
	
	function update_user($ui_id, $data)
	{
		$this->db->where('ui_id',$ui_id);
		$this->db->update('user_identity', $data);
	}
	
	function edit_user($ui_id)
	{
		$query = $this->db->get_where('user_identity',array('ui_id'=>$ui_id));
		return $query->result();
	}
	
	function delete_user($ui_id)
	{
		$this->db->delete('user_identity', array('ui_id' => $ui_id)); 
	}
	
	function get_station() 
	{
		 $this->db->order_by('vs_id', 'ASC');
		 return $this->db->get( 'var_station' )->result();
	}
	
	function get_unit($station)
	{
		$result = $this->db->where('vu_vs_id', $station)->get('var_unit')->result();
		return $result ? $result : false;	
	}
	
	function get_subunit($unit) 
	{
		$result = $this->db->where( 'vsu_vu_id', $unit )->get( 'var_sub_unit' )->result();
		return $result ? $result : false;
	}
	
	function get_team($subunit) 
	{
		$result = $this->db->where( 'vt_vsu_id', $subunit )->get( 'var_team' )->result();
		return $result ? $result : false;
	}
	
	function get_function() 
	{
		 $this->db->order_by('vf_level', 'DESC');
		 return $this->db->get( 'var_function' )->result();
		 
	}
	
	function get_station_level($station) 
	{
		$result = $this->db->where( 'vs_code', $station )->get( 'var_station' )->result();
		return $result ? $result : false;
	}
	
	function get_unit_level($unit) 
	{
		$result = $this->db->where( 'vu_code', $unit )->get( 'var_unit' )->result();
		return $result ? $result : false;
	}
#---------------------------------	
	
}
	
	/* End of file user_manage_model.php */
	/* Location: ./application/modules/admin/models/user_manage_model.php */

?>