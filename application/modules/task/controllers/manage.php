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
			$this->task_model->generate_task();
		else:
			redirect('user/pin_login'); 	
		endif;	
	}

	function index()
	{
		redirect("task/manage/task");
	}
	# list absensi
	function absensi()
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

		$nama = $this->uri->segment(4, 'ALL');
		$start_date = $this->uri->segment(5, 'ALL');
		$end_date = $this->uri->segment(6, 'ALL');
		#pagination config
		$search = "";
		$config['base_url'] = base_url()."task/manage/absensi/$nama/$start_date/$end_date"; 
		$config['total_rows'] = $this->task_model->count_absensi($nama,$start_date,$end_date); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_absensi($nama,$start_date,$end_date,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		$data['list_user'] = $this->task_model->get_user();
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('absensi_list', $data);
	}
	# search absensi
	function absensi_search()
	{
		$nama = $this->input->post('nama');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if($nama == ""){$nama = "ALL";}
		if($start_date == ""){$start_date = 'ALL';}
		if($end_date == ""){$end_date = 'ALL';}
		redirect("task/manage/absensi/$nama/$start_date/$end_date");
	}
	# detail absensi
	function detail_absensi()
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

		$abs_id = $this->uri->segment(4,0);
		$date = $this->uri->segment(5,0);
		
		#data preparing
		$data['result'] = $this->task_model->get_absensi_by_id($abs_id);
		$data['result_task'] = $this->task_model->get_task_by_abs_id($abs_id,$date);
			
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('absensi_detail', $data);
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
		$config['base_url'] = base_url().'task/manage/task/'; 
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
	# list task applyment
	function applyment()
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
		$config['base_url'] = base_url().'task/manage/applyment/'; 
		$config['total_rows'] = $this->task_model->count_applyment($ui_nipp,$master_id,$parent_id,$task_id); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_applyment($ui_nipp,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_applyment_list', $data);
	}
	# list open task
	function open()
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
		$status = 'open';
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'task/manage/open/'; 
		$config['total_rows'] = $this->task_model->count_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$status); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	# list open task
	function taken()
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
		$status = 'taken';
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'task/manage/taken/'; 
		$config['total_rows'] = $this->task_model->count_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$status); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	# list complete task
	function complete()
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
		$status = 'complete';
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'task/manage/complete/'; 
		$config['total_rows'] = $this->task_model->count_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$status); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_status_task($ui_nipp,$ui_nama,$status,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	# closed task
	function closed_task()
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
		$config['base_url'] = base_url().'task/manage/task/'; 
		$config['total_rows'] = $this->task_model->count_closed_task($ui_nipp,$master_id,$parent_id,$task_id); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_closed_task($ui_nipp,$master_id,$parent_id,$task_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	
	function history()
	{
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$task_id = $this->uri->segment(4);
		
		#data preparing
		$data['result'] = $this->task_model->get_task_history($task_id);
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_history'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_history', $data);
	}
	
	function master()
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
		
		$master_id = 0;
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'task/manage/master/'; 
		$config['total_rows'] = $this->task_model->count_master_task($ui_nipp,$master_id); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_master_task($ui_nipp,$master_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_master_task'] = 'class="current"' ;
		$data['view_manage_master_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_master_list', $data);
	}
	
	function form_search()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		
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

		
		# get option data
		$data['list_cat'] = $this->task_model->get_task_category();
		$this->load->view("form_search",$data);
	}
	
	function search()
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

		#data preparing
		$data['result'] = $this->task_model->get_task_search($ui_nipp);
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_list', $data);
	}
	
	function message()
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
		
		$task_message_id = 0;
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'task/manage/task/'; 
		$config['total_rows'] = $this->task_model->count_task_message($ui_nipp,$task_message_id); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_task_message($ui_nipp,$task_message_id,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('task_message_list', $data);
	}
	function performance()
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

		$nama = "ALL";
		$start = "ALL";
		$end = "ALL";
		
		if($this->uri->segment(4) > 0){	$nama = str_replace("%20","_",$this->uri->segment(4, "ALL"));}
		if($this->input->post('user') != ""){$nama = $this->input->post('user');}
		if($this->uri->segment(5) > 0){$start = $this->uri->segment(5, "ALL");}
		if($this->input->post('start_date') != ""){$start = $this->input->post('start_date');}
		if($this->uri->segment(6) > 0){$end = $this->uri->segment(6, "ALL");}
		if($this->input->post('end_date') != ""){$end = $this->input->post('end_date');}
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url()."task/manage/performance/$nama/$start/$end"; 
		$config['total_rows'] = $this->task_model->count_performance_task($nama,$start,$end); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 7; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_performance_task($nama,$start,$end,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		$data['list_user'] = $this->task_model->get_user();
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('performance_list', $data);
	
	}
	
	/*
	function performance()
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

		$nama = "ALL";
		$start = "ALL";
		$end = "ALL";
		
		if($this->uri->segment(4) > 0){	$nama = str_replace("%20","_",$this->uri->segment(4, "ALL"));}
		if($this->input->post('user') != ""){$nama = $this->input->post('user');}
		if($this->uri->segment(5) > 0){$start = $this->uri->segment(5, "ALL");}
		if($this->input->post('start_date') != ""){$start = $this->input->post('start_date');}
		if($this->uri->segment(6) > 0){$end = $this->uri->segment(6, "ALL");}
		if($this->input->post('end_date') != ""){$end = $this->input->post('end_date');}
		
		#pagination config
		$search = "";
		$config['base_url'] = base_url()."task/manage/performance/$nama/$start/$end"; 
		$config['total_rows'] = $this->task_model->count_performance_task($nama,$start,$end); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 7; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		#data preparing
		$data['result'] = $this->task_model->get_performance_task($nama,$start,$end,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		$data['list_user'] = $this->task_model->get_user();
		
		# sidebar nav 
		$data['menu_task'] = 'class="current"' ;
		$data['view_manage_task'] = 'class="current"' ;
		
		# call views		
		$this->load->view('performance_list', $data);
	
	}
	*/
	
	
}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */