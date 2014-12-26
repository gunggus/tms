<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {

	/**
	 * PT Dharma Bandar Mandala
	 * Warehouse Management System.
	 * ver 3.0
	 * 
	 * App id : 
	 * App code : wmsi
	 *
	 * log_model model
	 *
	 * url : http://whobth.dbmcargo.com/modules/user/models/log_model.php
	 *
	 * developer : studio kami madiri
	 * phone : 0361 853 2400
	 * email : support@studiokami.com
	 *
	 * copyright by studio kami mandiri
	 * Do not copy, modified, share or sell this script 
	 * without any permission from developer
	 */
	 
	public function system_log($function, $key)
	{
		$year = mdate('%Y', now());
		$create = "CREATE TABLE IF NOT EXISTS `wmsi_system_log_$year` (
			  `id_log` bigint(20) NOT NULL auto_increment,
			  `ls_user` varchar(255) NOT NULL,
			  `ls_function` varchar(255) NOT NULL,
			  `ls_key` varchar(25) default NULL,
			  `ls_update_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
			  PRIMARY KEY  (`id_log`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$query = $this->db->query($create);
		
		
		# get user data
		$user = $this->session->userdata('logged_in');
		$user = $user['ui_nama']; 
			
		$data = array(
				'ls_user' => $user,
				'ls_function' => $function,
				'ls_key' => $key
				);
		
		$this->db->insert('wmsi_system_log_'.$year, $data);
	}
}

/* End of file log_model.php */
/* Location: ./application/modules/user/models/log_model.php */