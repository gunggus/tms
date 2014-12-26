<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : User
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/user.php
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
				
				# load model, library and helper
				$this->load->library('module_management');
				$this->load->model('module_model','', TRUE);
				$this->load->model('user_manage_model','', TRUE);
				$this->load->model('user_model','', TRUE);
				
				
				# restrict all function access after log in
				
				if ($this->session->userdata('logged_in'))
				{ 
					# check module active
					if($this->module_management->module_active('module_active') == FALSE){redirect('messages/error/module_inactive');}
					
					# kick guest user
					if($this->user_access->level()==0){redirect('messages/error/not_authorized');}
				}
			
				else
				{
					# redirect to login if not
					redirect('user/pin_login');
				}		

			}
		
		function index()
		{
			# redirect to user list
			redirect('admin/user/manage', 'refresh');
			
		}
		
		function manage()
		{	
			# send access level to view
			$data['access_level'] = $this->user_access->level('user_access');
			
			# title
			$data['title'] = 'all';
			
			# call models display all user
			$data['query'] = $this->user_manage_model->get_all_user();
			
			# call views
			$this->load->view('user/user_list',$data);
		}
		
		function active()
		{
			# title
			$data['title'] = 'active';
			
			# call models display all active user
			$data['query'] = $this->user_manage_model->get_all_active();
			
			# call views
			$this->load->view('user/user_list',$data);
		}
		
		function suspend()
		{
			# title
			$data['title'] = 'suspend';
			
			# call models display all suspend user
			$data['query'] = $this->user_manage_model->get_all_suspend();
			
			# call views
			$this->load->view('user/user_list',$data);
		}
		
		function activated_user()
		{
			$ui_id = $this->uri->segment(4, '0');
			if($ui_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models display all suspend user
			$data['query'] = $this->user_manage_model->activated_user($ui_id);
			
			# redirect to active user
			redirect('admin/user/active');
		}
		
		
		function suspended_user()
		{
			$ui_id = $this->uri->segment(4, 0);
			if($ui_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models display all suspend user
			$data['query'] = $this->user_manage_model->suspended_user($ui_id);
			
			# redirect to active user
			redirect('admin/user/suspend');
		}
		
		
		function edit()
		{
			
			$data['company']  = $this->user_model->get_company();
			$data['pangkat'] = $this->user_model->get_function();
			
			/*$station = $this->input->post('station');
			$result = $this->user_model->get_station_level($station);
			if($result){foreach($result as $items):$station=$items->vs_id;endforeach;}
		
			$unit = $this->input->post('unit');
			$result = $this->user_model->get_unit_level($unit);
			if($result){foreach($result as $items):$unit=$items->vu_id;endforeach;}*/
			
			# get ui_id code from uri
			$ui_id = $this->uri->segment(4, 0);
			if($ui_id == 0){ redirect('message/error/unknown_error'); }
			
			
			# call models
			$data['query'] = $this->user_manage_model->edit_user($ui_id);
			
			# call views
			$this->load->view('admin/user/edit_user',$data);
		}
		
		function update()
    	{
			$company = $this->input->post('company');
			$result = $this->user_model->get_company($company);
			if($result){foreach($result as $items):$company=$items->vc_id;endforeach;}
			
			$directorate = $this->input->post('directorate');
			$result = $this->user_model->get_directorate($directorate);
			if($result){foreach($result as $items):$directorate=$items->vd_id;endforeach;}
		
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
			$level_code = $company . $directorate . $station . $unit . $sub_unit . $team . $pangkat;
			
			$jabatan = $this->input->post('jabatan');
			
			
			$ui_id 			= $this->input->post('ui_id');
			$ui_nama 		= $this->input->post('ui_nama');
			$ui_nipp 		= $this->input->post('ui_nipp');
			$ui_hp 			= $this->input->post('ui_hp');
			$ui_email 		= $this->input->post('ui_email');
			
			
			$data = array(
				'ui_nama' => $this->encrypt->encode($ui_nama),
				'ui_nipp'  => $ui_nipp,
				'ui_hp' 	=> $this->encrypt->encode($ui_hp),
				'ui_email'	 => $ui_email,
				'ui_level' => $level_code
			);
			
			
			# call model to save data
			$this->user_manage_model->update_user($ui_id, $data);
			
			# create user protection
			/*chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0777);
			write_file(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', $this->encrypt->encode($ui_email));
			chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0600);*/
						
			redirect('admin/user/', 'refresh');
		}
		
		function add()
		{
			$data['company']  = $this->user_model->get_company();
			$data['pangkat'] = $this->user_model->get_function();
		
			# call views
			$this->load->view('user/user_add', $data);
		}
		
		
		public function admin_save()
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
		$password = $this->input->post('password');
		$emergency_password = $this->user_access->encrypt_md5($email_encrypt, $password);
		//$emergency_password = $this->encrypt->sha1($password, $this->config->item('encryption_key'));
				
		# do validation rules
		$this->form_validation->set_rules('email', 'email', 'trim|required|min_length[3]|valid_email|xss_clean');
		$this->form_validation->set_rules('hp', 'hp', 'trim|required|min_length[3]|numeric|xss_clean');
		$this->form_validation->set_rules('nipp', 'nipp', 'trim|required|min_length[3]|numeric|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					# if fail force to do registration again
					# get stn available
					$data['station'] = $this->user_model->get_station();
					
					# get function ( fungsi )
					$data['function'] = $this->user_model->get_function();
					
					# call view		
					$this->load->view('user/user_add', $data);	
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
						
						# admin user
						$admin = 'admin';
						
						# call models to save user data
						$ui_id = $this->user_model->save_user($nama_encrypt, $hp_encrypt, $nipp_encrypt, $email_encrypt, $emergency_password, $level_code, $jabatan, $admin);
						
						# create user protection
						write_file(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', $this->encrypt->encode($email));
						chmod(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', 0600);
						
					}
					else
					{
						# dup nipp found or dup email found, push to re input data
						# get stn available
						$data['station'] = $this->user_model->get_station();
						
						# get function ( fungsi )
						$data['function'] = $this->user_model->get_function();
						
						# call view		
						$this->load->view('user/user_add', $data);	
					}
				
				redirect('admin/user/active', 'refresh');	
					
				}
		}
		
		function delete()
		{
			# get ui_id code from uri
			$ui_id = $this->uri->segment(4, 0);
			if($ui_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models
			$this->user_manage_model->delete_user($ui_id);
			
			# delete db check
			@chmod(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp', 0777);
			@unlink(FCPATH . 'wp-uploads/data/tmp/' . $ui_id . '.tmp'); 
			
			# redirect to station table
			redirect('admin/user/active', 'refresh');
		}
		
		function search_keyword()
		{
			$keyword    =   $this->input->post('keyword');
			$data['query']    =   $this->user_model->search($keyword);
			$this->load->view('user/user_list',$data);
		}
		
	}

/* End of file user.php */
/* Location: ./application/modules/admin/controllers/user.php */	
?>