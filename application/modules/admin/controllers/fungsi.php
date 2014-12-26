<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fungsi extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Fungsi
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/fungsi.php
		 * developer : pandhawa digital
		 * phone : 0361 853 2400
		 * email : pandhawa.digital@gmail.com
		 *
		 * warning !!!
		 * please do not copy, edit, or distribute this script without developer permission.
		 *
		 */
		
# construction ----------------------
		function __construct()
    		{
				parent::__construct();
				
				# load model, library and helper
				$this->load->model('user_level','', TRUE);
				
				# restrict all function access after log in
				
				if ($this->session->userdata('logged_in'))
				{ 
					# check module active
					if($this->module_management->module_active('module_active') == FALSE){redirect('messages/error/module_inactive');}
					
					# kick guest user
					if($this->user_access->level('user_access')==0){redirect('messages/error/not_authorized');}
				}
			
				else
				{
					# redirect to login if not
					redirect('user/pin_login');
				}	
				
			}
# construction ----------------------

# index  ----------------------------	
		function index()
		{
			# redirect to station list
			redirect('admin/fungsi/manage');
		}
# index  ----------------------------	

# manage  --------------------------		
		function manage()
		{
			# call models
			$data['records'] = $this->user_level->get_all_fungsi();
			
			# call views
			$this->load->view('fungsi/tabel_fungsi',$data);
		}
# manage  --------------------------	

	
		function add()
		{
			# call views
			$this->load->view('fungsi/form_fungsi');
		}
				
		function save()
		{
			# get data from form
			$vf_code = $this->input->post('vf_code');
			$vf_name = $this->input->post('vf_name');
			$vf_level = $this->input->post('vf_level');
			
			# check duplicate stn code
			$check_dup = $this->user_level->check_dup_vf_code($vf_code);
			
			if($check_dup <> NULL)
			{
				# duplicate found, force re-input
				$data['message'] = 'error, Function duplicate : ' . $vf_code;
				$this->load->view('fungsi/form_fungsi', $data);
			}
			else
			{
				# duplicate not found, continue save
				
				# get last level
				$vf_level = $this->user_level->get_vf_level();
				
				# prepare data
				$data = array(
				'vf_code'   => $vf_code,
				'vf_name'  	=> $vf_name,
				'vf_level'  => $vf_level
				);
				
				# call model to save data
				$this->user_level->save_fungsi($data);
				
				# redirect to station list
				redirect('admin/fungsi', 'refresh');
			}
		}
		
		function edit()
		{
			# get stn code from uri
			$vf_code = $this->uri->segment(4, 'error');
			
			# anticipate uri error
			if($vf_code == 'error'){redirect('admin/fungsi/');}
			
			# call models
			$data['query'] = $this->user_level->edit_fungsi($vf_code);
			
			# call views
			$this->load->view('fungsi/edit_fungsi',$data);
		}
		
		function update()
    	{
			$vf_code 	= $this->input->post('vf_code');
			$vf_level  	= $this->input->post('vf_level');
			$vf_name  	= $this->input->post('vf_name');
			
			$data = array(
				'vf_name'  => $vf_name,
			);
			
			# call model to save data
			$this->user_level->update_fungsi($vf_code,$vf_level, $data);
				
			redirect('admin/fungsi/', 'refresh');
		}
		
		
		function delete()
		{
			# get stn code from uri
			$vf_code = $this->uri->segment(4, 'error');
			
			# anticipate uri error
			if($vf_code == 'error'){redirect('admin/fungsi/');}
			
			# call models
			$this->user_level->delete_fungsi($vf_code);
			
			# redirect to station table
			redirect('admin/fungsi/');
		}
		
	}

/* End of file fungsi.php */
/* Location: ./application/modules/admin/controllers/fungsi.php */	
?>