<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	/**
	 * Manage Controller
	 *
	 */
	
	
	function __construct()
	{
        parent::__construct();
		$this->load->model('performance_model', '', TRUE);
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
		redirect("performance/manage/performance");
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
		$config['total_rows'] = $this->performance_model->count_performance_task($nama,$start,$end); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 7; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		#data preparing
		$data['result'] = $this->performance_model->get_performance_task($nama,$start,$end,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page'] = $page;
		$data['list_user'] = $this->performance_model->get_user();
		
		# sidebar nav 
		$data['menu_performance'] = 'class="current"' ;
		$data['view_manage_performance'] = 'class="current"' ;
		
		# call views		
		$this->load->view('performance_list', $data);
	}
	
	public function chart()
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

		$user = $this->input->post('user');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		if($user == ""){$nipp = "ALL";$user="ALL";}
		else{
			$varuser = explode(';',$user);
			$nipp = $varuser[0];
			$user = $varuser[1];
		}
		if($start == ""){$start = "ALL";}
		if($end == ""){$end = "ALL";}
		
		# data preparing
		$data['result'] = $this->performance_model->get_chart_performance($nipp,$start,$end);
		$data['list_user'] = $this->performance_model->get_user();
		$data['target'] = $this->performance_model->get_target($nipp);
		
		$data['user'] = $user;
		
		# sidebar nav 
		$data['menu_performance'] = 'class="current"' ;
		$data['view_manage_performance'] = 'class="current"' ;
		
		# call views		
		$this->load->view('performance_chart', $data);
	}
		
}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */