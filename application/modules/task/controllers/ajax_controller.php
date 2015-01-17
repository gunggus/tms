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
	
	
	
}

/* End of file ajax_station.php */
/* Location: ./application/controllers/ajax_station.php */
