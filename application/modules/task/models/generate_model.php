<?php
class Generate_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
    }
	
	public function generate_task()
	{
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$currtime = mdate("%Y-%m-%d %H:%i:%s",time());
		$query = " SELECT * FROM task_master WHERE tm_active = 'yes' AND tm_run_time < '$currtime' ";
		$query = $this->db->query($query);
		$result = $query->result();
		foreach($result as $row){
			$sch_finish = $row->tm_run_time;
			$sch_finish = mdate("%Y-%m-%d %H:%i:%s", (strtotime($sch_finish) + ( 3600 * $row->tm_duration)));
			
			$data = array(
				'task_master_id' => $row->tm_id,
				'task_status' => 'open',
				'task_name' => $row->tm_task,
				'task_unit' => $row->tm_unit,
				'task_category' => $row->tm_category,
				'task_skill' => $row->tm_skill,
				'task_skill_point' => $row->tm_skill_point,
				'task_point' => $row->tm_point,
				'task_sch_start' => $row->tm_run_time,
				'task_sch_finish' => $sch_finish,
				'task_sch_duration' => $row->tm_duration,
				'task_sch_duration_minute' => 60 * $row->tm_duration,
				'task_description' => $row->tm_description, 
				'task_created' => $ui_id, 
				'task_created_by' => $ui_nama, 
				'task_created_on' => date("Y-m-d H:i:s"), 
				'task_update_by' => $ui_nama, 
				'task_update_on' => date("Y-m-d H:i:s"), 
			);
			$this->db->insert("task",$data);
			$task_id = $this->db->insert_id();
		
			/*
			$data = array(
				'tsh_task_id' => $task_id, 
				'tsh_status' => "open", 
				'tsh_update_by' => $ui_nama, 
				'tsh_update_on' => date("Y-m-d H:i:s"), 
			);
			$this->db->insert("task_status_history",$data);
			*/
			
			$data = array(
				'tr_task_id' => $task_id, 
				'tr_progress_status' => "open", 
				'tr_start_on' => date("Y-m-d H:i:s"), 
				'tr_finish_on' => date("Y-m-d H:i:s"), 
				'tr_update_by' => $ui_nama, 
				'tr_update_on' => date("Y-m-d H:i:s"), 
			);
			$this->db->insert("task_report",$data);
			
			# set next run time 
			$run_time = $row->tm_run_time;
			$run_time = mdate("%Y-%m-%d %H:%i:%s", strtotime(mdate("%Y-%m-%d %H:%i:%s", strtotime($run_time)) . " + ". $row->tm_year ."year"));
			$run_time = mdate("%Y-%m-%d %H:%i:%s", strtotime(mdate("%Y-%m-%d %H:%i:%s", strtotime($run_time)) . " + ". $row->tm_month ."month"));
			$run_time = mdate("%Y-%m-%d %H:%i:%s", strtotime(mdate("%Y-%m-%d %H:%i:%s", strtotime($run_time)) . " + ". $row->tm_day ."day"));
			$run_time = mdate("%Y-%m-%d %H:%i:%s", strtotime(mdate("%Y-%m-%d %H:%i:%s", strtotime($run_time)) . " + ". $row->tm_hour ."hour"));
			$update = array("tm_run_time" => $run_time );
			$where  = array("tm_id" => $row->tm_id ); 
			$this->db->where($where);
			$this->db->update("task_master",$update);
				
		}
	}
	
	
}