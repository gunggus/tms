<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Unit
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/unit.php
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
			redirect('admin/unit/manage');
		}
		
		function manage()
		{
			# prepare data
			$table = 'var_unit';
			$id_field = 'vu_id';
			$relation_id_field = 'vu_vs_id';
			
			$parent_table = 'var_station';
			$parent_id_field = 'vs_id';
			
			# get id from uri
			
			$parent_id = $this->uri->segment(4, '');
			$data['parent_id'] = $parent_id;
			
			# anticipate uri error
			if($parent_id == ''){redirect('messages/error/url_modified');}
			
			# call models
			$data['records'] = $this->user_level->manage($table, $id_field, $relation_id_field, $parent_table, $parent_id_field, $parent_id);
			
			# call views
			$this->load->view('unit/tabel_unit',$data);
		}
		
		function add()
		{
			# get id from uri
			$data['parent_id'] = $this->uri->segment(4, '');
			
			# anticipate uri error
			if($data['parent_id'] == ''){redirect('messages/error/url_modified');}
			
			# call views
			$this->load->view('unit/form_unit', $data);
		}
				
		function save()
		{
			# prepare data
			$table = 'var_unit';
			$code_field = 'vu_code';
			$name_field = 'vu_name';
			$parent_id_field = 'vu_vs_id';
			
			# get data from form
			$parent_id = $this->input->post('parent_id');
			$code = $this->input->post('code');
			$name = $this->input->post('name');
			
			$this->form_validation->set_rules('code', 'code', 'trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|xss_clean');
			
			# check duplicate stn code
			$check_dup = $this->user_level->check_dup($table, $code_field, $code, $parent_id_field, $parent_id);
			
			if($this->form_validation->run() == FALSE OR $check_dup <> NULL)
			{
				$data['parent_id'] = $parent_id;
				
				# duplicate found, force re-input
				$data['message'] = 'duplicate data found : ' . strtoupper($code);
				$this->load->view('unit/form_unit', $data);
			}
			else
			{
				# duplicate not found, continue save
				$data = array(
				$parent_id_field => $parent_id,
				$code_field   => $code,
				$name_field  => $name,
				);
				
				# call model to save data
				$this->user_level->save($table, $data);
				
				# redirect to station list
				redirect('admin/unit/manage/' . $parent_id, 'refresh');
			}
		}
		
		function edit()
		{
			# prepare data
			$table = 'var_unit';
			$id_field = 'vu_id';
			
			# get id from uri
			$id = $this->uri->segment(4, '');
			
			# anticipate uri error
			if($id == ''){redirect('messages/error/url_modified');}
			
			# call models
			$data['query'] = $this->user_level->edit($table, $id_field, $id);
			
			# call views
			$this->load->view('unit/edit_unit',$data);
		}
		
		function update()
    	{
			# prepare data
			$table = 'var_unit';
			$id_field = 'vu_id';
			$name_field = 'vu_name';
			
			$id = $this->input->post('id');
			$parent_id = $this->input->post('parent_id');
			$name  = $this->input->post('name');
			
			$data = array(
				$name_field  => $name,
			);
			
			# call model to save data
			$this->user_level->update($table, $id_field, $id, $data);
				
			redirect('admin/unit/manage/' . $parent_id, 'refresh');
		}
		
		
		function delete()
		{
			# prepare data
			$table = 'var_unit';
			$id_field = 'vu_id';
			
			# get unit code from uri
			$id = $this->uri->segment(4, '');
			$parent_id = $this->uri->segment(5, '');
			
			# anticipate uri error
			if($id == ''){redirect('admin/unit/');}
			if($parent_id == ''){redirect('admin/unit/');}
			
			# call models
			$this->user_level->delete($table, $id_field, $id);
			
			# redirect to station table
			redirect('admin/unit/manage/' . $parent_id, 'refresh');
		}
		
	}

/* End of file unit.php */
/* Location: ./application/modules/admin/controllers/unit.php */	
?>