<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_station extends CI_Controller {
	
	/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Ajax_station
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/ajax_station.php
		 * developer : pandhawa digital
		 * phone : 0361 853 2400
		 * email : pandhawa.digital@gmail.com
		 *
		 * warning !!!
		 * please do not copy, edit, or distribute this script without developer permission.
		 *
		 */
	
	function __construct()
	{
        parent::__construct();
		$this->load->model( 'user_model' );
    }
	
	function select_directorate ( $company )
	{
		$directorate = $this->user_model->get_directorate( $company );
		
		if ( $directorate ) foreach ( $directorate as $directorate_items ) {
			echo '<option value="'.$directorate_items->vd_id.'">'.strtoupper( $directorate_items->vd_name ).'</option>';
		}
	}
	
	function select_station ( $directorate )
	{
		$station = $this->user_model->get_station( $directorate );
		
		if ( $station ) foreach ( $station as $station_items ) {
			echo '<option value="'.$station_items->vs_id.'">'.strtoupper( $station_items->vs_name ).'</option>';
		}
	}
	
	
	function select_unit ( $station )
	{
		$units = $this->user_model->get_unit( $station );
		
		if ( $units ) foreach ( $units as $unit ) {
			echo '<option value="'.$unit->vu_id.'">'.strtoupper( $unit->vu_name ).'</option>';
		}
	}
	
	function select_subunit ( $unit )
	{
		$subunits = $this->user_model->get_subunit( $unit );
		
		if ( $subunits ) foreach ( $subunits as $subunit ) {
			echo '<option value="'.$subunit->vsu_id.'">'.strtoupper( $subunit->vsu_name ).'</option>';
		}
	}
	
	function select_team ( $subunit )
	{
		$teams = $this->user_model->get_team( $subunit );
		
		if ( $teams ) foreach ( $teams as $team ) {
			echo '<option value="'.$team->vt_id.'">'.strtoupper( $team->vt_name ).'</option>';
		}
	}

	
}

/* End of file ajax_station.php */