<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : Registration
	 *
	 * registration controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/registration.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */
	
	
# construction ------------------------------	
	 function __construct()
	{
        parent::__construct();
		
		# load model, library and helper
		$this->load->model('user_model','', TRUE);
		
		# check module active
		/*
		if($this->module_management->module_active() == FALSE){redirect('messages/error/module_inactive');}
		*/
    }
# construction ------------------------------	
	
# index ------------------------------------	 
	public function index()
	{
		
		$data['company']  = $this->user_model->get_company();
		$data['pangkat'] = $this->user_model->get_function();
		
		$this->load->view('registration',$data);
		
	}
# index ------------------------------------	

# register ---------------------------------
	public function save()
	{
		# scenario :
		# get data from register form
		# do data validation
		# do save data to db
		# send pin or url verification via email
		# do inline verification
		
		# get data from register form
		$nama = $this->input->post('nama');
		$nama_encrypt = $this->encrypt->encode($nama);
		
		$nipp = $this->input->post('nipp');
		$nipp_encrypt = $nipp;
		
		$hp = $this->input->post('hp');
		$hp_encrypt = $this->encrypt->encode($hp);
		
		$email = $this->input->post('email');
		$email_encrypt = $email;
		
		$company = $this->input->post('company');
		
		
		$directorate = $this->input->post('directorate');
		
		
		
		$station = $this->input->post('station');
		$result = $this->user_model->get_station_level($station);
		if($result){foreach($result as $items):$station=$items->vs_id;endforeach;}
		
		$unit = $this->input->post('unit');
		$result = $this->user_model->get_unit_level($unit);
		if($result){foreach($result as $items):$unit=$items->vu_id;endforeach;}
		
		$sub_unit = $this->input->post('sub_unit');
		$result = $this->user_model->get_sub_unit_level($sub_unit);
		if($result){foreach($result as $items):$sub_unit=$items->vsu_id;endforeach;}
		
		$team = $this->input->post('team');
		$result = $this->user_model->get_team_level($team);
		if($result){foreach($result as $items):$team=$items->vt_id;endforeach;}
		
		$pangkat = $this->input->post('pangkat');
		$result = $this->user_model->get_pangkat_data($pangkat);
		if($result){foreach($result as $items):$pangkat=$items->vf_level;endforeach;}
		
		
		$level_code = $company . $directorate . $station . $unit . $sub_unit . $team . $pangkat;
		
		$jabatan = $this->input->post('jabatan');
		
		
		# prepare password to run system locale
		$password = trim($this->input->post('password'));
		$emergency_password = $this->user_access->encrypt_md5($email_encrypt, $password);
				
		# do validation rules
		$this->form_validation->set_rules('email', 'email', 'trim|required|min_length[3]|valid_email|xss_clean');
		$this->form_validation->set_rules('hp', 'hp', 'trim|required|min_length[7]|numeric|xss_clean');
		$this->form_validation->set_rules('nipp', 'nipp', 'trim|required|min_length[7]|numeric|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					# if fail force to do registration again
					# get stn available
					$data['station'] = $this->user_model->get_station();
					
					# get function ( fungsi )
					$data['function'] = $this->user_model->get_function();
					 	
					# call view		
					$this->load->view('registration', $data);	
				}
				else
				{
					# checking duplicate value
					$dup_nipp = $this->user_model->check_dup_nipp($nipp_encrypt);
					$dup_email = $this->user_model->check_dup_email($email_encrypt);
					if($dup_nipp == TRUE){$dup_nipp = 1;$data['message']='duplicate nipp found';}else{$dup_nipp = 0;}
					if($dup_email == TRUE){$dup_email = 1;$data['message']='duplicate email found';}else{$dup_email = 0;}
					$dup_check = $dup_nipp + $dup_email;
					
					# if there is no dup email or nipp, continue registration
					if($dup_check < 1)
					{
						# send view
						$data['email'] = $email;
						
						# call models to delete previous verification duplicate data
						$this->user_model->del_dup_prev_ver_data($email_encrypt);
						
						# call models to delete previous verification expired data
						$this->user_model->del_dup_prev_exp_data();
						
						# call models to save user data
						$ui_id = $this->user_model->save_user($nama_encrypt, $hp_encrypt, $nipp_encrypt, $email_encrypt, $emergency_password, $level_code, $jabatan);
						
						# email check
						$this->user_access->create_email_check(array('ui_id' => $ui_id, 'ui_email' => $email));
						
						# create random pin
						$this->load->helper('pin');
						$pin = get_pin(); 
						$email_link = $email . '+' . $pin ;
						$pin_encypt = $this->encrypt->sha1($pin, $this->config->item('encryption_key'));
						
						# encrypt email link to send via email
						$email_link = urlencode(base64_encode($email_link));
						
						# set request date & expired date
						$request = mdate("%Y-%m-%d %H:%i:%s", time());
						$expired = mdate("%Y-%m-%d %H:%i:%s", time()+3600);
						
						# set verification type
						$type = 'register';
						
						# call models to save verification data
						$this->user_model->save_verification($email_encrypt, $hp_encrypt, $type, $pin_encypt, $email_link, $request, $expired);
						
						# send pin and link via email
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						
						# send pin and link via smtp
						/*$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'ssl://smtp.googlemail.com';
						$config['smtp_port'] = 465;
						$config['smtp_user'] = 'xxx@gmail.com';
						$config['smtp_pass'] = 'xxxx';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");*/
						# send pin and link via smtp
						
						
						$this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
						$this->email->to($email); 
						$this->email->subject($this->config->item('company_name'));
						$this->email->message('
						
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>' . $this->config->item('company_name') . '|' . $this->config->item('app_name') . '</title>
						</head>
						
						<body>
						<p>Anda telah melakukan registrasi pada aplikasi ' . $this->config->item('app_name') . '</p>
						<p>Silahkan melakukan verifikasi dengan menggunakan pin berikut pada halaman verifikasi</p>
						<p>PIN : ' . $pin . '</p>
						<p>atau</p>
						<p>klik link dibawah ini</p>
						<p>LINK : {unwrap}' . anchor("user/verification/link/" . $email_link, base_url() . 'user/verification/link/' . $email_link) . '{/unwrap}</p>
						<p>&nbsp;</p>
						<p>Detail data anda :</p>
						<p>NAMA : ' . $nama . '</p>
						<p>NIPP : ' . $nipp . '</p>
						<p>NO HP : ' . $hp . '</p>
						<p>EMAIL : ' . $email . '</p>
						<p>PASSWORD : ' . $emergency_password . '</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>Terima kasih</p>
						<p>&nbsp;</p>
						<p>' . $this->config->item('admin_name') . '</p>
						<p>&nbsp;</p>
						</body>
						</html>
						
						');
						$this->email->send();
			
						# send data email through flash data
						$this->session->set_flashdata('email', $email);
						$this->session->set_flashdata('pin', $pin);
						
						# call views
						redirect('user/verification/pin');
					}
					else
					{
						# dup nipp found or dup email found, push to re input data
						# get stn available
						$data['station'] = $this->user_model->get_station();
						
						# get function ( fungsi )
						$data['function'] = $this->user_model->get_function();
						
						
						# call view		
						$this->load->view('registration', $data);	
					}
					
					
				}
	}
# register ---------------------------------
	
}

/* End of file registration.php */
/* Location: ./application/modules/user/controller/registration.php */