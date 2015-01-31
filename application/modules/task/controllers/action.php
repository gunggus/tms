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
		$data['list_unit'] = $this->task_model->get_unit();
		$data['list_skill'] = $this->task_model->get_skill_category();
		if($data['master_id'] > 0){$data['cat'] = $this->task_model->get_task_master_category($data["master_id"]);}
		else{$data['cat'] = "";}
		if($data['main_field'] == "master"){
			if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
			$this->load->view("add_task_master",$data);
		}
		elseif($data['main_field'] == "child"){
			if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
			$limit = 0;
			$offset = 0;
			$data['parent_id'] = $this->uri->segment(5,0);
			//$data['parent_task'] = $this->task_model->get_task($ui_nipp,0,0,$data['parent_id'],$limit,$offset);
			//$data['duration'] = $this->task_model->get_duration_parent_task($data['parent_id']);
			$data['parent_task'] = $this->task_model->get_task_by_task_id($data['parent_id']);
			$data['result'] = $this->task_model->get_task($ui_nipp,0,$data['parent_id'],0,$limit,$offset);
			$data['list_user'] = $this->task_model->get_user_list();
			$data['list_category_unit_selected'] = $this->task_model->get_category_unit_by_task_id( $data['parent_id'] );
			$data['list_user_category_unit_selected'] = $this->task_model->get_user_category_unit_by_task_id( $data['parent_id'] );
			$this->load->view("add_task_child",$data);
		}
		elseif($data['main_field'] == "message"){
				$this->load->view("add_task_message",$data);
		}
		elseif($data['main_field'] == "applyment"){
				$this->load->view("add_task_applyment",$data);
		}
		elseif($data['main_field'] == "approve"){
			if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
			$limit = 0;
			$offset = 0;
			$data['task_id'] = $this->input->post('task_id');
			$data['result'] = $this->task_model->get_task($ui_nipp,0,0,$data['task_id'],$limit,$offset);
			$this->load->view("approve_task_applyment",$data);
		}
		elseif($data['main_field'] == "announcement"){
			if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
			$this->load->view("add_announcement",$data);
		}
		else{$this->load->view("add_task",$data);}
	}
	
	public function edit()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;
		$data['main_field'] = $this->uri->segment(4, "task");
		if($data['main_field'] == "point"){
			$data['point_id'] = $this->uri->segment(5, 0);
			$data['result'] = $this->task_model->get_data_point($data['point_id']);
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
		$this->task_model->update_data("point",$update,$where);
		redirect("task/manage/performance");
	}
	
	public function save_master_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<40):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
	
		$varskill = explode(';',$this->input->post('task_skill'));
		$skill = $varskill[0];
		$skillpoint = $varskill[1]; 
		$point = $skillpoint * $this->input->post('tm_duration');
		$tm_start_time = mdate("%Y-%m-%d %H:%i:%s",(strtotime( $this->input->post('tm_start_time') )  +  ( 3600 * $this->input->post('tm_start_hour') ) + (60 * $this->input->post('tm_start_minute')) + $this->input->post('tm_start_second')));
		$data = array(
			'tm_task' => $this->input->post('tm_task'),
			'tm_skill' => $skill,
			'tm_skill_point' => $skillpoint,
			'tm_point' => $point,
			'tm_year' => $this->input->post('tm_year'),
			'tm_month' => $this->input->post('tm_month'),
			'tm_day' => $this->input->post('tm_day'),
			'tm_hour' => $this->input->post('tm_hour'),
			'tm_start_time' => $tm_start_time,
			'tm_run_time' => $tm_start_time,
			'tm_duration' => $this->input->post('tm_duration'),
			'tm_unit' => $this->input->post('tm_unit'),
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
		
		/*
		$varcategory = explode('|',$this->input->post('task_category'));
		$category = $varcategory[0];
		$skill = $varcategory[1];
		$skillpoint = $varcategory[2]; 
		$duration = $varcategory[3]; 
		*/
		if($this->input->post('task_sch_duration') > 0){$duration = $this->input->post('task_sch_duration');}
		//$point = $skillpoint * $duration;
		
		$data = array(
			'task_master_id' => $this->input->post('task_master_id'),
			'task_status' => 'taken',
			'task_name' => $this->input->post('task_name'),
			'task_unit' => $this->input->post('task_unit'),
			//'task_category' => $category,
			//'task_skill' => $skill,
			//'task_skill_point' => $skillpoint,
			//'task_point' => $point,
			'task_sch_start' => $this->input->post('task_sch_start'),
			'task_sch_finish' => $this->input->post('task_sch_finish'),
			'task_sch_duration' => $duration,
			'task_sch_duration_minute' => $duration * 60,
			'task_description' => $this->input->post('task_description'), 
			'task_taken' => $ui_id, 
			'task_taken_by' => $ui_nama, 
			'task_taken_on' => date("Y-m-d H:i:s"), 
 			'task_created' => $ui_id, 
			'task_created_by' => $ui_nama, 
			'task_created_on' => date("Y-m-d H:i:s"), 
 			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		$task_id = $this->task_model->save_data("task",$data);
		
		/*
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "open", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		*/
		
		$data = array(
			'tr_task_id' => $task_id, 
			'tr_assignment_status' => "assigned", 
			'tr_progress_status' => "progress", 
			'tr_start_on' => date("Y-m-d H:i:s"), 
			'tr_finish_on' => date("Y-m-d H:i:s"), 
			'tr_assigned' => $ui_id, 
			'tr_assigned_by' => $ui_nama, 
			'tr_update_by' => $ui_nama, 
			'tr_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_report",$data);
		redirect('task/manage/','refresh');
	}
	# save child task
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
		
		$varcategory = explode('|',$this->input->post('task_category'));
		$category = $varcategory[0];
		$skill = $varcategory[1];
		$skillpoint = $varcategory[2]; 
		$var_duration = $varcategory[3]; 
		
		$var_time = $this->input->post("satuan_waktu");
		$duration_minute = $this->input->post("task_sch_duration") * $var_time;
		$duration = $duration_minute / 60;
		$point = ($skillpoint * $duration_minute) / ($var_duration * 60) ;
		
		$result_child = $this->task_model->get_total_child_target_duration($this->input->post('task_parent_id'));
		$result_task = $this->task_model->get_task_by_task_id($this->input->post('task_parent_id'));
		$total_child_duration = 0;
		$total_task_duration = 0;
		foreach( $result_child as $rc){
			$total_child_duration = $rc->tot_duration_minute;
		}
		foreach( $result_task as $rt){
			$total_task_duration = $rt->task_sch_duration_minute;
		}
		
		# check total duration  
		if( ($total_child_duration + $duration_minute ) > $rt->task_sch_duration_minute){redirect("task/action/add/child/".$this->input->post("task_parent_id")."/duration_over");}
		if( $rt->task_sch_start > $this->input->post('task_sch_start')){redirect("task/action/add/child/".$this->input->post("task_parent_id")."/sch_start_over");}
		if( $rt->task_sch_finish < $this->input->post('task_sch_finish')){redirect("task/action/add/child/".$this->input->post("task_parent_id")."/sch_finish_over");}
		
		$data = array(
			'task_master_id' => $this->input->post('task_master_id'),
			'task_parent_id' => $this->input->post('task_parent_id'),
			'task_name' => $this->input->post('task_name'),
			'task_unit' => $this->input->post('task_unit'),
			'task_category' => $category,
			'task_skill' => $skill,
			'task_skill_point' => $skillpoint,
			'task_point' => $point,
			'task_sch_start' => $this->input->post('task_sch_start'),
			'task_sch_finish' => $this->input->post('task_sch_finish'),
			'task_sch_duration' => $duration,
			'task_sch_duration_minute' => $duration_minute,
			'task_description' => $this->input->post('task_description'), 
			'task_created' => $ui_id, 
			'task_created_by' => $ui_nama, 
			'task_created_on' => date("Y-m-d H:i:s"), 
 			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		if($this->input->post("assign") == ""){ 
			$data["task_status"] = "open";
			$data_rep["tr_assignment_status"] = "open";
		}else{
			$var_assign = explode('|',$this->input->post("assign"));
			$data["task_status"] = "taken";
			$data["task_taken"] = $var_assign[0];
			$data["task_is_assigned"] = 'yes';
			$data["task_taken_by"] = $var_assign[1];
			$data["task_taken_on"] = date("Y-m-d H:i:s");
			$data_rep["tr_assignment_status"] = "assigned";
			$data_rep["tr_assigned"] = $var_assign[0];
			$data_rep["tr_assigned_by"] = $var_assign[1];
		}
		$task_id = $this->task_model->save_data("task",$data);
		$data_rep['tr_task_id'] = $task_id; 
		$data_rep['tr_update_by'] = $ui_nama; 
		$data_rep['tr_update_on'] = date("Y-m-d H:i:s"); 
		
		$this->task_model->save_data("task_report",$data_rep);
		
		$update = array( "task_is_child"	=>	"no",	);
		$where = array(	'task_id' => $this->input->post('task_parent_id'),);
		$this->task_model->update_data("task",$update,$where);
		
		redirect('task/detail/task/'.$this->input->post('task_parent_id'),'refresh');
	}
	# assign task
	public function assign_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$ui_nama = $session_data['ui_nama'];
		$ui_nipp = $session_data['ui_nipp'];
		
		$task_id = $this->input->post("task_id");
		$var_assign = explode('|',$this->input->post("assign"));
		$data["task_status"] = "taken";
		$data["task_taken"] = $var_assign[0];
		$data["task_is_assigned"] = 'yes';
		$data["task_taken_by"] = $var_assign[1];
		$data["task_taken_on"] = date("Y-m-d H:i:s");
		$where = array("task_id"	=>	$task_id);
		
		$data_rep["tr_assignment_status"] = "assigned";
		$data_rep["tr_assigned"] = $var_assign[0];
		$data_rep["tr_assigned_by"] = $var_assign[1];
		$data_rep['tr_update_by'] = $ui_nama; 
		$data_rep['tr_update_on'] = date("Y-m-d H:i:s"); 
		$data_rep['tr_task_id'] = $task_id; 
		
		$this->task_model->update_data("task",$data,$where);
		
		$this->task_model->save_data("task_report",$data_rep);
		
		redirect('task/detail/task/'.$task_id,'refresh');
	}
	
	# approve assign
	public function approve_assign()
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
		
		$task_id = $this->input->post('task_id');
		$result = $this->task_model->get_task_by_task_id($task_id);
		foreach($result as $row){
			if($row->task_sch_start > date("Y-m-d H:i:s")){ $act_start = $row->task_sch_start;}
			else{ $act_start = date("Y-m-d H:i:s"); }
			$update = array(
					"task_act_start" => $act_start,
					"task_is_assigned" => "no",
				);
			$where = array(
					"task_id"	=>	$row->task_id,
				);
			$this->task_model->update_data("task",$update,$where);
			
			# task status
			$data_tsh = array(
					"tsh_task_id"	=>	$row->task_id,
					"tsh_status"	=>	"reject",
					"tsh_user"		=>	$ui_nama,
					"tsh_report"	=>	$this->input->post("report"),
					"tsh_start"		=>	date("Y-m-d H:i:s"),
					"tsh_update_by"		=>	$ui_nama,
					"tsh_update_on"		=>	date("Y-m-d H:i:s"),
				);
			$this->task_model->save_data("task_status_history",$data_tsh);
			
		}
		redirect('task/detail/task/'.$task_id,'refresh');
	}
	# reject assign
	public function reject_assign()
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
		
		$task_id = $this->input->post('task_id');
		$parent_id = 0;
		$result = $this->task_model->get_task_by_task_id($task_id);
		foreach($result as $row){
			$parent_id = $row->task_parent_id;
			$data_task = array(
					"task_status" => "open",
					"task_taken" => "",
					"task_taken_by" => "",
					"task_taken_on" => "0000-00-00 00:00:00",
					"task_is_assigned" => "no",
				);
			$where = array(
					"task_id"	=>	$row->task_id,
				);
			# save reject task
			$this->task_model->update_data("task",$data_task,$where);
			$data_tsh = array(
					"tsh_task_id"	=>	$row->task_id,
					"tsh_status"	=>	"reject",
					"tsh_user"		=>	$ui_nama,
					"tsh_report"	=>	$this->input->post("report"),
					"tsh_start"		=>	date("Y-m-d H:i:s"),
					"tsh_update_by"		=>	$ui_nama,
					"tsh_update_on"		=>	date("Y-m-d H:i:s"),
				);
			$this->task_model->save_data("task_status_history",$data_tsh);
			# save open task
			$data_tsh = array(
					"tsh_task_id"	=>	$row->task_id,
					"tsh_status"	=>	"open",
					"tsh_user"		=>	$ui_nama,
					"tsh_start"		=>	date("Y-m-d H:i:s"),
					"tsh_update_by"		=>	$ui_nama,
					"tsh_update_on"		=>	date("Y-m-d H:i:s"),
				);
			$this->task_model->save_data("task_status_history",$data_tsh);
		}
		redirect('task/detail/task/'.$parent_id,'refresh');
	}
	
	function request_complete()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
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
		
		$assigned = $this->input->post("assigned");
		$assigned_by = $this->input->post("assigned_by");
		
		$update = array( "tr_progress_status" => "request complete",);
		$where = array( "tr_task_id" => $data["task_id"], "tr_assigned" => $assigned, "tr_assigned_by" => $assigned_by);
		$this->task_model->update_data("task_report",$update,$where);
		//$data['result'] = $this->task_model->get_task_by_task_id($data['task_id']);
		//$this->load->view("form_request_complete",$data);
		redirect("task/detail/task/".$this->input->post("task_id"));
	}
	# save request complete
	/*
	public function save_request_complete()
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
		
		$result = $this->task_model->get_task_by_task_id($this->input->post('task_id'));
		foreach($result as $row){
			$duration_minute = (time() - strtotime($row->task_act_start))/60;
			$duration_hour = $duration_minute/60;
			$data = array(
				//"task_status"	=>	"taken",
				"task_request_complete"	=>	"yes",
				"task_act_finish"	=>	date("Y-m-d H:i:s"),
				"task_act_duration"	=>	$duration_hour,
				"task_act_duration_minute"	=>	$duration_minute,
				"task_report"	=>	$row->task_report,
				"task_complete"	=>	$ui_id,
				"task_complete_by"	=>	$ui_nama,
				"task_complete_on"	=>	date("Y-m-d H:i:s"),
				"task_update"	=>	$ui_id,
				"task_update_by"	=>	$ui_nama,
				"task_update_on"	=>	date("Y-m-d H:i:s"),
			);
			$where = array(
				'task_id' => $this->input->post('task_id'),
			);
			$this->task_model->update_data("task",$data,$where);
			
			$data_tsh = array(
				'tsh_task_id' => $this->input->post('task_id'), 
				"tsh_status" => "taken", 
				"tsh_user" => $ui_nama, 
				"tsh_start" => date("Y-m-d H:i:s"), 
				"tsh_end" => date("Y-m-d H:i:s"), 
				'tsh_report'	=> $this->input->post('task_report'),	
				"tsh_request_complete" => "yes", 
				"tsh_update_by"	=>	$ui_nama,
				"tsh_update_on"	=>	date("Y-m-d H:i:s"),
			);
			$this->task_model->save_data("task_status_history",$data_tsh);
		}
		redirect('task/manage/','refresh');
	}
	*/
	# approve request_complete
	public function approve_request_complete()
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
		
		$task_id = $this->input->post("task_id");
		$user_id = $this->input->post('assigned');
		$user_nama = $this->input->post('assigned_by');
		$task_target_duration = $this->input->post("task_target_duration");
		$data = array(
					"task_request_complete" => "no",
					"task_status"		=>	"complete",
					"task_act_finish"	=>	date("Y-m-d H:i:s"),
					"task_act_duration"	=>	$task_target_duration / 60,
					"task_act_duration_minute"	=>	$task_target_duration,
					"task_complete"		=>	$user_id,
					"task_complete_by"	=>	$user_nama,
					"task_complete_on"	=>	date("Y-m-d H:i:s"),
					"task_update"		=>	$ui_id,
					"task_update_by"	=>	$ui_nama,
					"task_update_on"	=>	date("Y-m-d H:i:s"),
				);
		$where = array("task_id" => $task_id);
		$this->task_model->update_data("task",$data,$where);
			
		$data = array(
				"tr_progress_status"	=>	"complete",
				"tr_controlling_status"	=>	"confirm",
				"tr_controlling_by"	=>	$ui_nama,
				"tr_update_by"	=>	$ui_nama,
			);
		$where = array("tr_task_id" => $task_id, 'tr_assigned_by' => $this->input->post('assigned_by'));
		$this->task_model->update_data("task_report",$data,$where);
		
		$point_point = $this->input->post("point");
		$point_reward = $this->input->post("reward");
		$point_penalty = $this->input->post("penalty");
		
		$user_nipp = $this->task_model->get_nipp_by_user_id($user_id);
		$point_abs_id = $this->task_model->get_last_abs_id($user_nipp);
		$datapoint = array(
				"point_task_id"	=>	$this->input->post('task_id'),
				"point_abs_id"	=>	$point_abs_id,
				"point_point"	=>  $point_point,
				"point_penalty"	=>  $point_penalty,
				"point_reward"	=>  $point_reward,
				"point_nipp" 	=>  $ui_nipp,
				"point_username"=>  $user_nama,
				"point_date"	=>  mdate("%Y-%m-%d %H:%i:%s",time()),
				"point_description" => $this->input->post("response"),
				"point_update_by"	=> $ui_nama,
				"point_update_on"	=> mdate("%Y-%m-%d %H:%i:%s",time()),
			);
		$this->task_model->save_data("point",$datapoint);
		
		redirect('task/detail/task/'.$task_id,'refresh');
	}
	
	# reject request_complete
	public function reject_request_complete()
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
		
		$task_id = $this->input->post("task_id");
		$result = $this->task_model->get_task_by_task_id($task_id);
		foreach($result as $row)
		{
			$user_id = $row->task_complete;
			$user_nama = $row->task_complete_by;
			$user_nipp = $this->task_model->get_nipp_by_user_id($user_id);
			
			$data = array(
					"task_request_complete" => "no",
					"task_status"	=>	"taken",
				);
			$where = array("task_id" => $row->task_id);
			$this->task_model->update_data("task",$data,$where);
			
			$data_status = array( 
					"tsh_status" => "taken", 
					"tsh_user" => $user_nama, 
					"tsh_start" => date("Y-m-d H:i:s"), 
					"tsh_end" => date("Y-m-d H:i:s"), 
					"tsh_request_complete" => "no", 
					"tsh_update_by"	=>	$ui_nama,
					"tsh_update_on"	=>	date("Y-m-d H:i:s"),
				);
			$this->task_model->save_data("task_status_history",$data_status);
		}
		redirect('task/detail/task/'.$task_id,'refresh');
	}
	
	# save announcement
	public function save_announcement()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		$data = array(
				"tan_title"	=>	$this->input->post('title'),
				"tan_detail"	=>	$this->input->post('detail'),
			);
		$this->task_model->save_data("task_announcement",$data);
		redirect("task/manage");
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
		
		/*
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "take", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		*/
		$data = array(
			'tr_task_id'		=>	$task_id,
			'tr_assigned_status'=>	"assigned",
			'tr_progress_status'=>	"progress",
			'tr_assigned'		=>	$ui_id,
			'tr_assigned_by'	=>	$ui_nama,
			
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
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
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
			'task_act_duration' => round(((time() - strtotime($this->input->post('task_act_start')))/3600),0),
			'task_report' => $this->input->post('task_report'), 
			'task_complete' => $ui_id, 
			'task_complete_by' => $ui_nama, 
			'task_complete_on' => date("Y-m-d H:i:s"), 
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
		
		$point_point = $this->input->post('task_point');
		$point_penalty = 0;
		$point_reward = 0;
		$point_description = $this->input->post('task_name')." ".$this->input->post('task_report');
		if(mdate("%Y-%m-%d %H:%i:%s",time()) > $this->input->post('task_sch_finish')){
			//$duration = $this->input->post('task_act_duration') - $this->input->post('task_sch_duration');
			//$point_penalty = ($duration / $this->input->post('task_sch_duration')) * $this->input->post('task_point') / 2 ;
		}
		if(($this->input->post('task_act_duration') <= $this->input->post('task_sch_duration')) AND (mdate("%Y-%m-%d %H:%i:%s",time()) < $this->input->post('task_sch_finish')))
		{
			//$duration = $this->input->post('task_sch_duration') - $this->input->post('task_act_duration');
			//$point_reward = ($duration / $this->input->post('task_sch_duration')) * $this->input->post('task_point') / 2  ;
		}
		
		$point_abs_id = $this->task_model->get_last_abs_id($ui_nipp);
		$datapoint = array(
			"point_task_id"	=>	$this->input->post('task_id'),
			"point_abs_id"	=>	$point_abs_id,
			"point_point"	=>  $point_point,
			"point_penalty"	=>  $point_penalty,
			"point_reward"	=>  $point_reward,
			"point_nipp" 	=>  $ui_nipp,
			"point_username"=>  $ui_nama,
			"point_date"	=>  mdate("%Y-%m-%d %H:%i:%s",time()),
			"point_description" => $point_description,
			"point_update_by"	=> $ui_nama,
			"point_update_on"	=> mdate("%Y-%m-%d %H:%i:%s",time()),
		);
		$this->task_model->save_data("point",$datapoint);
		
		
		
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

	public function absensi()
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
		if($this->uri->segment(4,0) == "in"){$this->load->view("absensi_in",$data);}
		else{
			$abs_id = $this->uri->segment(5,0);
			$date = mdate('%Y-%m-%d %H:%i:%s',time());
			$data['result'] = $this->task_model->get_absensi_by_id($abs_id);
			$data['result_task'] = $this->task_model->get_task_by_abs_id($abs_id);
			$data['minpoint'] = $this->task_model->get_target_point($ui_nipp);
			$this->load->view("absensi_out",$data);
		}
	}
		
	public function do_absensi()
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
		
		$this->load->library('user_agent');
		if ($this->agent->is_browser()){ $agent = $this->agent->browser().' '.$this->agent->version();}
		elseif ($this->agent->is_robot()){ $agent = $this->agent->robot();}
		elseif ($this->agent->is_mobile()){	$agent = $this->agent->mobile();}
		else{ $agent = 'Unidentified User Agent'; }
		$agent .= "$agent".$this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

		if($this->uri->segment(4) == 'in'){ 
			$data = array(
				"abs_in"	=>	mdate("%Y-%m-%d %H:%i:%s",time()),
				"abs_shift"	=>	$this->input->post('abs_shift'),
				"abs_nipp"	=>	$ui_nipp,
				"abs_nama"	=>	$ui_nama,
				"abs_hp_std"	=>	$this->input->post('abs_hp_std'),
				"abs_hp_pdw"	=>	$this->input->post('abs_hp_pdw'),
				"abs_ym"	=>	$this->input->post('abs_ym'),
				"abs_skype"	=>	$this->input->post('abs_skype'),
				"abs_listrik"	=>	$this->input->post('abs_listrik'),
				"abs_plan"	=>	$this->input->post('abs_plan'),
				"abs_ip_in"	=>	$_SERVER['REMOTE_ADDR'],
				"abs_agent_in"	=>	$agent,
				"abs_update_by"	=>	$ui_nama,
				"abs_update_on"	=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			);
			$abs_id = $this->task_model->save_data("absensi",$data);
		}else{
			$data = array(
				"abs_out"	=>	mdate("%Y-%m-%d %H:%i:%s",time()),
				"abs_report"	=>	$this->input->post('abs_plan'),
				"abs_ip_out"	=>	$_SERVER['REMOTE_ADDR'],
				"abs_agent_out"	=>	$agent,
				"abs_update_by"	=>	$ui_nama,
				"abs_update_on"	=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			);
			$where = array('abs_id' => $this->input->post('abs_id') );
			$this->task_model->update_data("absensi",$data,$where);
			$abs_id = $this->input->post('abs_id');
		}
		
		# point calculation
		$typeshift = $this->input->post('abs_shift');
		$var_point = $this->task_model->get_var_point();
		foreach($var_point as $vp){
			$abs_point = $vp->abs_point;
			$abs_penalty = $vp->abs_penalty;
			$abs_reward = $vp->abs_reward;
		}
		$resultshift = $this->task_model->get_shift($typeshift);
		foreach($resultshift as $rs){ 
			$in = $rs->shift_start;
			$out = $rs->shift_end; 
			$tol_in = $rs->shift_start_tolerance;
			$tol_out = $rs->shift_end_tolerance;
			$rew_in = $rs->shift_start_reward;
			$rew_out = $rs->shift_end_reward;
		}
		# set penalty & reward
		$point_point = $abs_point;
		$point_penalty = 0;
		$point_reward = 0;
		if($this->uri->segment(4) == 'in'){ 
			if($tol_in < mdate("%H:%i:%s",time())){ $point_penalty = $abs_penalty;}
			if($rew_in > mdate("%H:%i:%s",time())){ $point_reward = $abs_reward;}
			$point_description = "Absen IN ".strtoupper( $this->input->post('abs_shift'))." $ui_nama ".mdate("%Y-%m-%d %H:%i:%s",time());
		}else{ 
			if($out > mdate("%H:%i:%s",time())){$point_penalty = $abs_penalty;}
			if($rew_out < mdate("%H:%i:%s",time())){$point_reward = $abs_reward;}
			//if(($out < mdate("%H:%i:%s",time()))   OR   ($tol_out > mdate("%H:%i:%s",time()))){ $point_penalty = $abs_penalty;}
			//if((substr($out,11) < mdate("%H:%i:%s",time()))   AND   (substr($tol_out,11) > mdate("%H:%i:%s",time()))){ $point_reward = $abs_reward;}
			$point_description = "Absen OUT ".strtoupper( $this->input->post('abs_shift'))." $ui_nama ".mdate("%Y-%m-%d %H:%i:%s",time()); 
		}	
		$datapoint = array(
			"point_abs_id"	=>	$abs_id,
			"point_point"	=>  $point_point,
			"point_penalty"	=>  $point_penalty,
			"point_reward"	=>  $point_reward,
			"point_nipp" 	=>  $ui_nipp,
			"point_username"=>  $ui_nama,
			"point_date"	=>  mdate("%Y-%m-%d %H:%i:%s",time()),
			"point_description" => $point_description,
			"point_update_by"	=> $ui_nama,
			"point_update_on"	=> mdate("%Y-%m-%d %H:%i:%s",time()),
		);
		$this->task_model->save_data("point",$datapoint);
		
		redirect('task/manage/absensi','refresh');
	}
	
	function report()
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
		
		if($this->input->post("rep_start") == ""){redirect("task/detail/task/".$this->input->post('task_id')."/error_rep_start");}
		if(strtotime($this->input->post("rep_finish")) == ""){redirect("task/detail/task/".$this->input->post('task_id')."/error_rep_finish");}
		if(strtotime($this->input->post("rep_finish")) < strtotime($this->input->post("rep_start"))){redirect("task/detail/task/".$this->input->post('task_id')."/error_rep_finish");}
		$duration_minute = (strtotime($this->input->post('rep_finish')) - strtotime($this->input->post('rep_start'))) / 60;
		$data = array(
			"tr_task_id"			=> 	$this->input->post('task_id'),	
			"tr_assignment_status"	=> 	"assigned",	
			"tr_progress_status"	=> 	"progress",	
			"tr_controlling_status"	=> 	"unconfirm",	
			"tr_detail"				=>	$this->input->post("detail"),
			"tr_start_on"			=>	$this->input->post("rep_start"),
			"tr_finish_on"			=>	$this->input->post("rep_finish"),
			"tr_duration"			=>	$duration_minute,
			"tr_assigned"			=>	$ui_id,
			"tr_assigned_by"		=>	$ui_nama,
		);	
		$this->task_model->save_data("task_report",$data);
		redirect("task/detail/task/".$this->input->post('task_id'));
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */