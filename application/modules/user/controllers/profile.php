<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : User Profile
	 *
	 * profile controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/profile.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */
	
	
# constuction ------------------------------	
	 function __construct()
	{
        parent::__construct();
		
		# load model, library and helper
		$this->load->model('user_model','', TRUE);
		
		# restrict all function access after log in
		if (!$this->session->userdata('logged_in'))
		{ 
			# redirect to login if not
			redirect('user/pin_login');
		}
		
    }
# constuction ------------------------------	

# index ------------------------------------	 
	public function index()
	{
		# get level data from session
		#$data['profile'] = $this->session->userdata('logged_in');
		$data['ui_nama'] =  $this->session->userdata['logged_in']['ui_nama'];
		$data['ui_nipp'] =  $this->session->userdata['logged_in']['ui_nipp'];
		$data['ui_email'] =  $this->session->userdata['logged_in']['ui_email'];
		$data['ui_hp'] =  $this->session->userdata['logged_in']['ui_hp'];
		$data['ui_level'] =  $this->session->userdata['logged_in']['ui_level'];
		$data['ui_jabatan'] = $this->session->userdata['logged_in']['ui_jabatan'];
		
		$company = substr ($this->session->userdata['logged_in']['ui_level'], 0, 2);
		$company = $this->user_model->get_company_data($company);
		
		$directorate = substr ($this->session->userdata['logged_in']['ui_level'], 2, 2);
		$directorate = $this->user_model->get_directorate_data($directorate);
		
		# extract stn lvl code and find other stn record on db
		$station = substr ($this->session->userdata['logged_in']['ui_level'], 4, 2);
		$station = $this->user_model->get_station_data($station);
		
		if($station <> NULL)
		{
			foreach($station as $items):
			$station_code = $items->vs_code;
			$station_name = $items->vs_name;
			endforeach;
		}
		else
		{
			$station_code = '01';
			$station_name = 'non';
		}
		$data['station_code'] = $station_code;
		$data['station_name'] = $station_name;

		
		# extract unit lvl code and find other unit record on db
		$unit = substr ($this->session->userdata['logged_in']['ui_level'], 6, 2);
		$unit = $this->user_model->get_unit_data($unit, $station_code);
		
		if($unit <> NULL)
		{
			foreach($unit as $items):
				$unit_code = $items->vu_code;
				$unit_name = $items->vu_name;
			endforeach;
		}
		else
		{
			$unit_code = '01';
			$unit_name = 'non';
		}
		$data['unit_code'] = $unit_code;
		$data['unit_name'] = $unit_name;
		
		# extract sub unit lvl code and find other sub unit record on db
		$sub_unit = substr ($this->session->userdata['logged_in']['ui_level'], 8, 2);
		$sub_unit = $this->user_model->get_sub_unit_data($sub_unit, $unit_code);
		if($sub_unit <> NULL)
		{
			foreach($sub_unit as $items):
				$sub_unit_code = $items->vsu_code;
				$sub_unit_name = $items->vsu_name;
			endforeach;
		}
		else
		{
			$sub_unit_code = '01';
			$sub_unit_name = 'non';
		}
		$data['sub_unit_code'] = $sub_unit_code;
		$data['sub_unit_name'] = $sub_unit_name;
		
		# extract team lvl code and find other team record on db
		$team = substr ($this->session->userdata['logged_in']['ui_level'], 10, 2);
		$team = $this->user_model->get_team_data($team, $sub_unit_code);
		if($team <> NULL)
		{
			foreach($team as $items):
				$team_code = $items->vt_code;
				$team_name = $items->vt_name;
			endforeach;
		}
		else
		{
			$team_code = '01';
			$team_name = 'non';
		}
		$data['team_code'] = $team_code;
		$data['team_name'] = $team_name;
		
		# extract pangkat lvl code and find other pangkat record on db
		$pangkat = substr ($this->session->userdata['logged_in']['ui_level'], 12, 2);
		$pangkat = $this->user_model->get_pangkat_data($pangkat);
		if($pangkat <> NULL)
		{
			foreach($pangkat as $items):
				$pangkat_code = $items->vf_code;
				$pangkat_name = $items->vf_name;
			endforeach;
		}
		else
		{
			$pangkat_code = '01';
			$pangkat_name = 'non';
		}
		$data['pangkat_code'] = $pangkat_code;
		$data['pangkat_name'] = $pangkat_name;
		
		
		
		$this->load->view('profile', $data);
	}
# index ------------------------------------	


	
}

/* End of file profile.php */
/* Location: ./application/modules/user/controllers/profile.php */