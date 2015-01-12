<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {

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
			$this->task_model->generate_task();
		else:
			redirect('user/pin_login'); 	
		endif;	
    }

	function index()
	{
		redirect("task/setting/category_access");
	}
	# category access
	function category_access()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		
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
		
		$nipp = $this->uri->segment(4,'ALL');
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url()."task/setting/category_access/$nipp/"; 
		$config['total_rows'] = $this->task_model->count_category_access($nipp); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_category_access($nipp,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		$data['list_user'] = $this->task_model->get_user();
		
		# sidebar nav 
		$data['menu_setting'] = 'class="current"' ;
		$data['view_category_access'] = 'class="current"' ;
		
		# call views		
		$this->load->view('category_access', $data);
	}
	# search category access
	public function search_category_access()
	{
		$nipp = $this->input->post('nipp');
		if( $nipp == ""){$nipp = "ALL";}
		redirect("task/setting/category_access/$nipp");
	}
	# add category_access
	public function save_category_access()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$data = array(
				"tac_nipp"	=>	$this->input->post('nipp'),
				"tac_category" =>  $this->input->post('category'),
				"tac_update_by"	=>	$ui_nama,
				"tac_update_on"	=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			);
		$this->task_model->save_data("task_access",$data);
	}
	# delete category access 
	public function delete_category_access()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$where = array(
				'tac_id' => $this->input->post('tac_id'),
			);
		$this->task_model->delete_data("task_access",$where);
	}
	
	
	
}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */