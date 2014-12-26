<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_pribadi extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : Data Pribadi
	 *
	 * profile controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/data_pribadi.php
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
		# grab data pribadi from ems
		$this->rest->initialize(array(
			'server' => 'http://ems.gapura.co.id/index.php/api/pekerja_data_pribadi/',
			'http_user' => 'malammingguandistudio',
			'http_pass' => 'vORtOOVlg5vGaEv',
			'http_auth' => 'digest'
		));
		
		
		$session_data = $this->session->userdata('logged_in');
		if($session_data['ui_nipp'])
		{ 
			$nipp = $session_data['ui_nipp'];
			$data['pribadi'] = $this->rest->get('pribadi', array('nipp' => $nipp), 'json');
			$data['alamat'] = $this->rest->get('alamat', array('nipp' => $nipp), 'json');
			$data['pasangan'] = $this->rest->get('pasangan', array('nipp' => $nipp), 'json');
			$data['anak'] = $this->rest->get('anak', array('nipp' => $nipp), 'json');
			$data['orangtua'] = $this->rest->get('orangtua', array('nipp' => $nipp), 'json');
			$data['mertua'] = $this->rest->get('mertua', array('nipp' => $nipp), 'json');
			
			if($data == NULL)
			{
				$data['pribadi_type'] = 'Gangguan jaringan data dengan server EMS';
			}
			else
			{
				$data['pribadi_type'] = 'pribadi';
			}
		}
		else
		{
			$data['pribadi_type'] = 'NIPP tidak ditemukan, silahkan hubungi unit HRD';
		}
		
		# view
		$this->load->view('data_pribadi', $data);
	}
# index ------------------------------------	


	
}

/* End of file data_pribadi.php */
/* Location: ./application/modules/user/controllers/data_pribadi.php */