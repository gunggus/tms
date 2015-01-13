<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

	public function __construct()
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
	
	public function index()
	{
		redirect('performance/manage', 'REFRESH');
	}
	
	public function edit()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$data['main_field'] = $this->uri->segment(4, "task");
		if($data['main_field'] == "point"){
			$data['point_id'] = $this->uri->segment(5, 0);
			$data['result'] = $this->performance_model->get_data_point($data['point_id']);
			$this->load->view("edit_point",$data);
		}else{
			redirect("messages/error/error_404");
		}
	}
	public function do_edit_point()
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
		
		$update = array( 
					"point_nipp"	=>  $this->input->post('point_nipp'),
					"point_username"	=>	$this->input->post('point_username'),	
					"point_date"	=>	$this->input->post('point_date'),	
					"point_point"	=>	$this->input->post('point_point'),	
					"point_reward"	=>	$this->input->post('point_reward'),	
					"point_penalty"	=>	$this->input->post('point_penalty'),	
					"point_description"	=>	$this->input->post('point_description'),	
					"point_update_by"	=>	$ui_nama,	
					"point_update_on"	=>	date("Y-m-d H:i:s"),	
				);
		$where = array(	'point_id' => $this->input->post('point_id'),);
		$this->performance_model->update_data("point",$update,$where);
		redirect("performance/manage/performance");
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */