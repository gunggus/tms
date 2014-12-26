<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Module
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/module.php
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
				$this->load->model('module_model','', TRUE);
				$this->load->helper('directory');
				$this->load->library('user_access');
				
				# restrict all function access after log in
				if ($this->session->userdata('logged_in'))
				{ 
					# check module active
					if($this->module_management->module_active('module_active') == FALSE){redirect('admin/module/manage');}
					
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
			# redirect manage to display all module
			redirect('admin/module/manage', 'refresh');
		}
		
		function manage()
		{
			# send access level to view
			$data['access_level'] = $this->user_access->level('user_access');
			
			# call models
			$data['query'] = $this->module_model->get_all_module();
			
			# call views
			$this->load->view('module/module_list',$data);
		}
		
		function add()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# call views
			$this->load->view('module/module_add');
		}
		
		function add_sub_module()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get module name from post
			$data['mod_name'] 	= $this->input->post('mod_name');
			
			# call views
			$this->load->view('module/sub_module_add', $data);
		}
		
		function save()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get data from form
			$vm_name 	= $this->input->post('mod_name');
			$vm_sub_module 	= $this->input->post('mod_sub');
			$mod_active = $this->input->post('mod_active');
			$mod_hide 	= $this->input->post('mod_hide');
			
			if($mod_active == TRUE) {$mod_active = 'y';} else {$mod_active = 'n';}
			if($mod_hide == TRUE) {$mod_hide = 'y';} else {$mod_hide = 'n';}
			
			# check prev data on db, if exist do nothing
			$module = $this->module_model->check_module_sub_module($vm_name, $vm_sub_module);	
			
			if($module == FALSE)
			{
				$data = array(
				'vm_name'   		=> $vm_name,
				'vm_sub_module'   	=> $vm_sub_module,
				'vm_active'   		=> $mod_active,
				'vm_hide'   		=> $mod_hide
				);
				
				# call model to save data
				$vm_id = $this->module_model->save_module($data);
			}
			
			# redirect to station list
			redirect('admin/module', 'refresh');
		}
		
		
		function publish_module()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get mod id from uri
			$mod_id = $this->uri->segment(4, '0');
			if($mod_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models
			$this->module_model->publish_module($mod_id);
			
			# redirect to module list
			redirect('admin/module/','refresh');
		}
		
		function undo_publish_module()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get mod id from uri
			$mod_id = $this->uri->segment(4, '0');
			if($mod_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models
			$this->module_model->undo_publish_module($mod_id);
			
			# redirect to module list
			redirect('admin/module/','refresh');
		}
		
		function show_module()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get mod id from uri
			$mod_id = $this->uri->segment(4, '0');
			if($mod_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models
			$this->module_model->show_module($mod_id);
			
			# redirect to module list
			redirect('admin/module/','refresh');
		}
		
		function hide_module()
		{
			# access level
			if($this->user_access->level('user_access')<40){redirect('not_authorized');}
			
			# get mod id from uri
			$mod_id = $this->uri->segment(4, '0');
			if($mod_id == 0){ redirect('message/error/unknown_error'); }
			
			# call models
			$this->module_model->hide_module($mod_id);
			
			# redirect to module list
			redirect('admin/module/','refresh');
		}
		
		
	}

/* End of file module.php */
/* Location: ./application/modules/admin/controllers/module.php */	
?>