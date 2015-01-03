<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

	public function __construct()
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
	
	public function index()
	{
		redirect('tms/task/manage', 'REFRESH');
	}
	
	public function add()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		$data['master_id'] = $this->input->post('master_id');
		$data['parent_id'] = $this->input->post('parent_id');
		$data['task_id'] = $this->uri->segment(5, 0);
		$data['main_field'] = $this->uri->segment(4, "task");
		
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
		if($data['master_id'] > 0){$data['cat'] = $this->task_model->get_task_master_category($data["master_id"]);}
		else{$data['cat'] = "";}
		if($data['main_field'] == "master"){$this->load->view("add_task_master",$data);}
		elseif($data['main_field'] == "child"){
				$limit = 0;
				$offset = 0;
				$data['parent_id'] = $this->uri->segment(5,0);
				$data['parent_task'] = $this->task_model->get_task($ui_nipp,0,0,$data['parent_id'],$limit,$offset);
				$data['result'] = $this->task_model->get_task($ui_nipp,0,$data['parent_id'],0,$limit,$offset);
				$this->load->view("add_task_child",$data);
		}
		else{$this->load->view("add_task",$data);}
	}
	
	public function save_master_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
	
		$tm_start_time = mdate("%Y-%m-%d %H:%i:%s",(strtotime( $this->input->post('tm_start_time') )  +  ( 3600 * $this->input->post('tm_start_hour') ) + (60 * $this->input->post('tm_start_minute')) + $this->input->post('tm_start_second')));
		$data = array(
			'tm_task' => $this->input->post('tm_task'),
			'tm_point' => $this->input->post('tm_point'),
			'tm_year' => $this->input->post('tm_year'),
			'tm_month' => $this->input->post('tm_month'),
			'tm_day' => $this->input->post('tm_day'),
			'tm_hour' => $this->input->post('tm_hour'),
			'tm_start_time' => $tm_start_time,
			'tm_run_time' => $tm_start_time,
			'tm_duration' => $this->input->post('tm_duration'),
			'tm_category' => $this->input->post('tm_category'),
			'tm_description' => $this->input->post('tm_description'), 
			'tm_created_by' => $ui_nama, 
			'tm_created_on' => date("Y-m-d H:i:s"), 
 			'tm_update_by' => $ui_nama, 
			'tm_update_on' => date("Y-m-d H:i:s"), 
 		);
		$task_id = $this->task_model->save_data("task_master",$data);
		redirect('task/manage/master','refresh');
	}
	public function save_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_master_id' => $this->input->post('task_master_id'),
			'task_status' => 'open',
			'task_name' => $this->input->post('task_name'),
			'task_category' => $this->input->post('task_category'),
			'task_point' => $this->input->post('task_point'),
			'task_sch_start' => $this->input->post('task_sch_start'),
			'task_sch_finish' => $this->input->post('task_sch_finish'),
			'task_sch_duration' => $this->input->post('task_sch_duration'),
			'task_description' => $this->input->post('task_description'), 
			'task_created' => $ui_id, 
			'task_created_by' => $ui_nama, 
			'task_created_on' => date("Y-m-d H:i:s"), 
 			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		$task_id = $this->task_model->save_data("task",$data);
		
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "open", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	public function save_child_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_master_id' => $this->input->post('task_master_id'),
			'task_parent_id' => $this->input->post('task_parent_id'),
			'task_status' => 'open',
			'task_name' => $this->input->post('task_name'),
			'task_category' => $this->input->post('task_category'),
			'task_point' => $this->input->post('task_point'),
			'task_sch_start' => $this->input->post('task_sch_start'),
			'task_sch_finish' => $this->input->post('task_sch_finish'),
			'task_sch_duration' => $this->input->post('task_sch_duration'),
			'task_description' => $this->input->post('task_description'), 
			'task_created' => $ui_id, 
			'task_created_by' => $ui_nama, 
			'task_created_on' => date("Y-m-d H:i:s"), 
 			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		$task_id = $this->task_model->save_data("task",$data);
		
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "open", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		
		$update = array( "task_is_child"	=>	"no",	);
		$where = array(	'task_id' => $this->input->post('task_parent_id'),);
		$this->task_model->update_data("task",$update,$where);
		
		redirect('task/manage/','refresh');
	}
	function take()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_status' => "taken", 
			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
			'task_taken' => $ui_id, 
			'task_taken_by' => $ui_nama, 
			'task_taken_on' => date("Y-m-d H:i:s"), 
			'task_act_start' => date("Y-m-d H:i:s"), 
 		);
		$where = array(
			'task_id'	=>	$task_id, 
		);
		$this->task_model->update_data("task",$data,$where);
		
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "take", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	public function closed()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		# close task
		$data = array("task_closed" => "yes", "task_update" => $ui_id, "task_update_by" => $ui_nama, "task_update_on" => mdate("%Y-%m-%d %H:%i:%s", time()));
		$where = array("task_id" => $task_id,);
		$this->task_model->update_data("task",$data,$where);
		
		# add status task
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "closed", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	
	public function reopen()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		# close task
		$data = array("task_status" => "reopen","task_closed" => "no", "task_update" => $ui_id, "task_update_by" => $ui_nama, "task_update_on" => mdate("%Y-%m-%d %H:%i:%s", time()));
		$where = array("task_id" => $task_id,);
		$this->task_model->update_data("task",$data,$where);
		
		# add status task
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "reopen", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	function complete()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$data['task_id'] = $this->input->post("task_id");
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data['result'] = $this->task_model->get_task($ui_nipp,0,0,$data['task_id'],0,0);
		$this->load->view("form_complete",$data);
	}
	public function do_complete()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_status' => 'complete',
			'task_act_finish' => mdate("%Y-%m-%d %H:%i:%s",time()),
			'task_act_duration' => round(((time() - strtotime($this->input->post('task_act_start')))/60),0),
			'task_report' => $this->input->post('task_report'), 
			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		$where = array(
			'task_id' => $this->input->post('task_id'),
		);
		$this->task_model->update_data("task",$data,$where);
		
		$data = array(
			'tsh_task_id' => $this->input->post('task_id'), 
			'tsh_status' => "complete", 
			'tsh_report'	=> $this->input->post('task_report'),	
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	function enable_master()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$tm_id = $this->input->post('tm_id');

		# disable master task
		$data = array("tm_active" => "yes","tm_update_by" => $ui_nama, "tm_update_on" => mdate("%Y-%m-%d %H:%i:%s", time()));
		$where = array("tm_id" => $tm_id,);
		$this->task_model->update_data("task_master",$data,$where);
		redirect("task/manage/master");
	}
	function disable_master()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$tm_id = $this->input->post('tm_id');

		# disable master task
		$data = array("tm_active" => "no","tm_update_by" => $ui_nama, "tm_update_on" => mdate("%Y-%m-%d %H:%i:%s", time()));
		$where = array("tm_id" => $tm_id,);
		$this->task_model->update_data("task_master",$data,$where);
	
		redirect("task/manage/master");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */