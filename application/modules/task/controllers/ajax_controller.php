<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_controller extends CI_Controller {
	
	function __construct()
	{
        parent::__construct();
		$this->load->model( 'ajax_model' );
    }
	
	// unit category point
	function category_task( $unit )
	{
		$category = $this->ajax_model->get_category_task( $unit );
		if ( $category ) foreach ( $category as $cat_items ) {
			echo '<option value="'.$cat_items->tc_category.'|'.$cat_items->tc_skill.'|'.$cat_items->tc_point.'|'.$cat_items->tc_duration.'">'.strtoupper( $cat_items->tc_category ).'</option>';
		}
	}
	
	function task_access( $var_category )
	{
		$var_category=str_replace('%7','|',$var_category);
		$var_category=str_replace('%20',' ',$var_category);
		$varcategory = explode('|',$var_category);
		$category = $varcategory[0];
		$access = $this->ajax_model->get_task_access( $category );
		if ( $access ) foreach ( $access as $access_items ) {
			echo '<option value="'.$access_items->ui_id.'|'.$this->encrypt->decode($access_items->ui_nama).'">'.$this->encrypt->decode($access_items->ui_nama).'</option>';
		}
		
	}
	
	
}

/* End of file ajax_station.php */
/* Location: ./application/controllers/ajax_station.php */
