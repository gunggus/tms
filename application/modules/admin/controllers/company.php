<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Company
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/company.php
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
		
		function index()
		{
			# redirect to station list
			redirect('admin/company/manage');
		}
		
		function manage()
		{
			# prepare data
			$table = 'var_company';
			$id_field = 'vc_id';
			
			# call models
			$data['records'] = $this->user_level->manage_company($table, $id_field);
			
			# call views
			$this->load->view('company/tabel_company',$data);
		}
		
		function add()
		{
			# call views
			$this->load->view('company/form_company');
		}
				
		function save()
		{
			# prepare data
			$table = 'var_company';
			$code_field = 'vc_code';
			$name_field = 'vc_name';
			
			
			# get data from form
			$code = $this->input->post('com_code');
			$name = $this->input->post('com_name');
			
			$this->form_validation->set_rules('com_code', 'com_code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('com_name', 'com_name', 'trim|required|min_length[3]|xss_clean');
			
			# check duplicate stn code
			$check_dup = $this->user_level->check_dup_company($table, $code_field, $code);
			
			if($this->form_validation->run() == FALSE OR $check_dup <> NULL)
			{
				# duplicate found, force re-input
				$data['message'] = 'duplicate data found : ' . strtoupper($code);
				$this->load->view('company/form_company', $data);
			}
			else
			{
				# duplicate not found, continue save
				$data = array(
				'vc_code'   => $code,
				'vc_name'  => $name,
				);
				
				# call model to save data
				$this->user_level->save($table, $data);
				
				# redirect to station list
				redirect('admin/company', 'refresh');
			}
		}
		
		function edit()
		{
			# prepare data
			$table = 'var_company';
			$id_field = 'vc_id';
			
			# get stn code from uri
			$id = $this->uri->segment(4, '');
			
			# anticipate uri error
			if($id == ''){redirect('messages/error/url_modified');}
			
			# call models
			$data['query'] = $this->user_level->edit($table, $id_field, $id);
			
			# call views
			$this->load->view('company/edit_company',$data);
		}
		
		function update()
    	{
			# prepare data
			$table = 'var_company';
			$id_field = 'vc_id';
			$name_field = 'vc_name';
			
			$id = $this->input->post('id');
			$name  = $this->input->post('name');
			
			$data = array(
				$name_field  => $name,
			);
			
			# call model to save data
			$this->user_level->update($table, $id_field, $id, $data);
				
			redirect('admin/company/', 'refresh');
		}
		
		
		function delete()
		{
			# prepare data
			$table = 'var_company';
			$id_field = 'vc_id';
			
			# get stn code from uri
			$id = $this->uri->segment(4, '');
			
			# anticipate uri error
			if($id == ''){redirect('messages/error/url_modified');}
			
			# call models
			$this->user_level->delete($table, $id_field, $id);
			
			# redirect to station table
			redirect('admin/company/', 'refresh');
		}
		
	}

/* End of file company.php */
/* Location: ./application/modules/admin/controllers/company.php */	
?>