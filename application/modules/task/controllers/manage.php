<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	/**
	 * Manage Controller
	 *
	 */
	
	
	function __construct()
	{
        parent::__construct();
		$this->load->model('task_model', '', TRUE);
		
		# user restriction
		if ($this->session->userdata('logged_in')):
			if($this->module_management->module_active('module_active') == FALSE):redirect('messages/error/module_inactive');endif;
			if($this->user_access->level('user_access')==0):redirect('messages/error/not_authorized');endif;
		else:
			redirect('user/pin_login'); 	
		endif;	
    }

	function index()
	{
		redirect("task/manage/task");
	}
	# list task
	function task()
	{
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		  
		$ui_email = $session_data['ui_email'];
		$data['ui_email'] = $ui_email;
		
		$ui_level = $session_data['ui_level'];
		$station = substr($ui_level,4,2);
		$lvl = substr($ui_level,6);  

		$master_id = 0;
		$parent_id = 0;
		$task_id = 0;
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'member/manage/task/'; 
		$config['total_rows'] = $this->task_model->count_task($ui_nipp,$master_id,$parent_id,$task_id); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_task($ui_nipp,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	
}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */