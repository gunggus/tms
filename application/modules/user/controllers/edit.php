<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : User Edit
	 *
	 * profile controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/edit.php
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
		redirect('user/edit/change_password');	
	}
# index ------------------------------------	

	function change_password()
	{
		
		$this->load->view('change_password');
	}
	
	function update_password()
	{
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|xss_clean');
		#$this->form_validation->set_error_delimiters('<p class="text-danger">&nbsp;error message : ', '</p>');
		
		if ($this->form_validation->run() == FALSE OR $password <> $password2)
		{
			$data['message'] = 'Password did not macth';
			$this->load->view('change_password', $data);
		}
		else
		{
			# get level data from session
			$data['ui_nama'] =  $this->session->userdata['logged_in']['ui_nama'];
			$data['ui_nipp'] =  $this->session->userdata['logged_in']['ui_nipp'];
			$data['ui_email'] =  $this->session->userdata['logged_in']['ui_email'];
			$data['ui_hp'] =  $this->session->userdata['logged_in']['ui_hp'];
			$data['ui_level'] =  $this->session->userdata['logged_in']['ui_level'];
			$data['ui_jabatan'] = $this->session->userdata['logged_in']['ui_jabatan'];
			
			# extract stn lvl code and find other stn record on db
			$station = substr ($this->session->userdata['logged_in']['ui_level'], 4, 2);
			$station = $this->user_model->get_station_data($station);
			foreach($station as $items):
				$station_code = $items->vs_code;
				$station_name = $items->vs_name;
			endforeach;
			$data['station_code'] = $station_code;
			$data['station_name'] = $station_name;
			
			# extract unit lvl code and find other unit record on db
			$unit = substr ($this->session->userdata['logged_in']['ui_level'], 6, 2);
			$unit = $this->user_model->get_unit_data($unit, $station_code);
			foreach($unit as $items):
				$unit_code = $items->vu_code;
				$unit_name = $items->vu_name;
			endforeach;
			$data['unit_code'] = $unit_code;
			$data['unit_name'] = $unit_name;
			
			# extract sub unit lvl code and find other sub unit record on db
			$sub_unit = substr ($this->session->userdata['logged_in']['ui_level'], 8, 2);
			$sub_unit = $this->user_model->get_sub_unit_data($sub_unit, $unit_code);
			foreach($sub_unit as $items):
				$sub_unit_code = $items->vsu_code;
				$sub_unit_name = $items->vsu_name;
			endforeach;
			$data['sub_unit_code'] = $sub_unit_code;
			$data['sub_unit_name'] = $sub_unit_name;
			
			# extract team lvl code and find other team record on db
			$team = substr ($this->session->userdata['logged_in']['ui_level'], 10, 2);
			$team = $this->user_model->get_team_data($team, $sub_unit_code);
			foreach($team as $items):
				$team_code = $items->vt_code;
				$team_name = $items->vt_name;
			endforeach;
			$data['team_code'] = $team_code;
			$data['team_name'] = $team_name;
			
			# extract pangkat lvl code and find other pangkat record on db
			$pangkat = substr ($this->session->userdata['logged_in']['ui_level'], 12, 2);
			$pangkat = $this->user_model->get_pangkat_data($pangkat);
			foreach($pangkat as $items):
				$pangkat_code = $items->vf_code;
				$pangkat_name = $items->vf_name;
			endforeach;
			$data['pangkat_code'] = $pangkat_code;
			$data['pangkat_name'] = $pangkat_name;
			
			# email	
			$email = $this->session->userdata['logged_in']['ui_email'];
			$email_encrypt = $email;
						
			# password
			$password_encrypt = $this->user_access->encrypt_md5($email_encrypt, $password);
						
			# call model to update password
			$result = $this->user_model->update_password($email_encrypt, $password_encrypt);
			
			# call Views
			$data['message'] = 'change password success..';
			$this->load->view('profile', $data);
		}
	}
	
}

/* End of file edit.php */
/* Location: ./application/modules/user/controllers/edit.php */