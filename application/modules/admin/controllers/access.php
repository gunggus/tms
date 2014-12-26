<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access extends CI_Controller {
		
		/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Station
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/modules/user/controller/station.php
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
				$this->load->model('user_manage_model','', TRUE);
				$this->load->model('user_access_model','', TRUE);
				$this->load->helper('directory');
				$this->load->library('encrypt');
				
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
			# redirect manage to display all module
			redirect('admin/access/manage/');
		}
		
		function manage()
		{
			# get value for uri
			$ui_nipp = $this->uri->segment(4, '');
			#if($ui_nipp == ''){redirect('message/error/unknown_error');}
			
			# send access level to view
			$data['access_level'] = $this->user_access->level('user_access');
			
			# send to view
			$data['nipp'] = $ui_nipp;
			$ui_nipp_encrypt = $this->encrypt->sha1($ui_nipp);
			
			# call models display all user
			$data['query'] = $this->user_access_model->get_user_access($ui_nipp_encrypt);
			
			# call views
			$this->load->view('access/user_access_list',$data);
		}
		
		function add()
		{
			$ui_nipp = $this->uri->segment(4, 0);
			#if($ui_nipp == 0){redirect('message/error/unknown_error');}
			
			# send to view
			$data['nipp'] = $ui_nipp;
			$ui_nipp_encrypt = $this->encrypt->sha1($ui_nipp);
			
			$data['query'] = $this->user_access_model->get_all_module($ui_nipp_encrypt);
			
			# call views
			$this->load->view('access/user_access_add', $data);
		}
		
		
		
		function save()
    	{
			$ua_nipp = $this->input->post('nipp');
			$ua_nipp_encrypt = $this->encrypt->sha1($this->input->post('nipp'));
			$ua_vm_id = $this->input->post('vm_id');
			$ua_module = $this->input->post('vm_name');
			$ua_sub_module = $this->input->post('vm_sub_module');
			$ua_roles  = $this->input->post($ua_vm_id . '-access');
			$ua_start = date("Y-m-d H:i:s");
			
			$data = array(
				'ua_nipp'  => $ua_nipp_encrypt,
				'ua_vm_id'  => $ua_vm_id,
				'ua_module'  => $ua_module,
				'ua_sub_module'  => $ua_sub_module,
				'ua_roles'  => $ua_roles,
				'ua_start' => $ua_start
			);
			
			# call model to save data
			$this->user_access_model->save_access($data);
				
			redirect('admin/access/manage/' . $ua_nipp, 'refresh');
		}
		
		
		function update()
    	{
			$ua_vm_id = $this->input->post('ua_vm_id');
			$ua_id = $this->input->post('ua_id');
			$ua_nipp = $this->input->post('ua_nipp');
			$ua_nipp_encrypt = $this->encrypt->sha1($ua_nipp);
			$ua_roles = $this->input->post('roles');
			$ua_module = $this->input->post('ua_module');
			$ua_sub_module = $this->input->post('ua_sub_module');
			
			$query = $this->user_access_model->get_access_by_id($ua_id);
			
			foreach($query as $items) :
				$current_roles = $items->ua_roles;
			endforeach;
			
			if($ua_roles <> $current_roles)
			{
				# update previous
				$this->user_access_model->ending_prev_roles($ua_id);
				
				# insert new
				$ua_start = date("Y-m-d H:i:s");
				
				$data = array(
				'ua_nipp'  => $ua_nipp_encrypt,
				'ua_vm_id'  => $ua_vm_id,
				'ua_module'  => $ua_module,
				'ua_sub_module'  => $ua_sub_module,
				'ua_roles'  => $ua_roles,
				'ua_start' => $ua_start
				);
				
				$this->user_access_model->save_access($data);
				
				#redirect('admin/access/manage/' . $ua_nipp, 'refresh');
			}
			
			redirect('admin/access/manage/' . $ua_nipp, 'refresh');
		}
		
		
		
				
	
		
		function edit()
		{
			# get stn code from uri
			$stn_code = $this->uri->segment(4, 'error');
			
			# anticipate uri error
			if($stn_code == 'error'){redirect('admin/station/');}
			
			# call models
			$data['query'] = $this->user_level->edit_station($stn_code);
			
			# call views
			$this->load->view('station/edit_station',$data);
		}
		
		
		
		
		function delete()
		{
			# get stn code from uri
			$stn_code = $this->uri->segment(4, 'error');
			
			# anticipate uri error
			if($stn_code == 'error'){redirect('admin/station/');}
			
			# call models
			$this->user_level->delete_station($stn_code);
			
			# redirect to station table
			redirect('admin/station', 'refresh');
		}
		
	}

/* End of file access.php */
/* Location: ./application/modules/admin/controllers/access.php */
?>