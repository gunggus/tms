<?php
class Task_model extends CI_Model
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
			$sch_finish = mdate("%Y-%m-%d %H:%i:%s", (strtotime($sch_finish) + ( 60 * $row->tm_duration)));
			
			$data = array(
				'task_master_id' => $row->tm_id,
				'task_status' => 'open',
				'task_name' => $row->tm_task,
				'task_category' => $row->tm_category,
				'task_point' => $row->tm_point,
				'task_sch_start' => $row->tm_run_time,
				'task_sch_finish' => $sch_finish,
				'task_sch_duration' => $row->tm_duration,
				'task_description' => $row->tm_description, 
				'task_created' => $ui_id, 
				'task_created_by' => $ui_nama, 
				'task_created_on' => date("Y-m-d H:i:s"), 
				'task_update_by' => $ui_nama, 
				'task_update_on' => date("Y-m-d H:i:s"), 
			);
			$this->db->insert("task",$data);
			$task_id = $this->db->insert_id();
		
			$data = array(
				'tsh_task_id' => $task_id, 
				'tsh_status' => "open", 
				'tsh_update_by' => $ui_nama, 
				'tsh_update_on' => date("Y-m-d H:i:s"), 
			);
			$this->db->insert("task_status_history",$data);
			
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
	
	# task list
	public function get_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					$where
					ORDER BY task_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# closed task list
	public function get_closed_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'yes'
					$where
					ORDER BY task_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	
	# task master list
	public function get_master_task($nipp,$master_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($master_id > 0){$where.= " AND tm_id = $master_id";}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task_master 
					JOIN task_access ON tac_category = tm_category
					WHERE tac_nipp = '$nipp'
					$where
					ORDER BY tm_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}

	# task message list
	public function get_task_message($nipp,$task_message_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($task_message_id > 0){$where.= " AND task_message_id = $task_message_id";}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task_message 
					JOIN task_access ON tac_category = tmg_category
					WHERE (tac_nipp = '$nipp'  OR  tmg_category = 'other')
					$where
					ORDER BY tmg_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# get task category
	public function get_task_category()
	{
		$query = "	SELECT * FROM task_category
					ORDER BY tc_category ASC
				";
		$query = $this->db->query($query);
		return $query->result();
	}

	# get task master category
	public function get_task_master_category($master_id)
	{
		$query = "	SELECT * FROM task_master WHERE tm_id = $master_id ";
		$query = $this->db->query($query);
		if($query->num_rows() > 0){ $row = $query->row(); return $row->tm_category; }
	}
	
	# get task history
	public function get_task_history($task_id)
	{
		$query = "	SELECT * FROM task_status_history 
					JOIN task ON tsh_task_id = task_id
					WHERE tsh_task_id = '$task_id' ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# get performance task
	public function get_performance_task($nama,$start,$end,$limit,$offset)
	{
		$where = "";
		if($nama != "ALL"){$where.=" AND task_taken_by LIKE '$nama' ";}
		if($start != "ALL"){$where.=" AND task_taken_on >= '$start' ";}
		if($end != "ALL"){$where.=" AND task_taken_on <= '$end' ";}
		if($where != ""){$where = " WHERE  ".substr($where,4);}
		$query = "	SELECT * FROM task 
					$where
					ORDER BY task_id DESC
					LIMIT $offset,$limit	
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# count performance task
	public function count_performance_task($nama,$start,$end)
	{
		$where = "";
		if($nama != "ALL"){$where.=" AND task_taken_by LIKE '$nama' ";}
		if($start != "ALL"){$where.=" AND task_taken_by >= '$start' ";}
		if($end != "ALL"){$where.=" AND task_taken_by <= '$end' ";}
		if($where != ""){$where = " WHERE  ".substr($where,4);}
		$query = "	SELECT * FROM task 
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	# count task
	public function count_task($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	# closed task
	public function count_closed_task($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'yes'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	# count master task
	public function count_master_task($nipp,$master_id)
	{
		$where = "";
		if($master_id > 0){$where.= " AND tm_id = $master_id";}
		$query = " 	SELECT * FROM task_master 
					JOIN task_access ON tac_category = tm_category
					WHERE tac_nipp = '$nipp'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	# count task message
	public function count_task_message($nipp,$task_message_id)
	{
		$where = "";
		if($task_message_id > 0){$where.= " AND task_message_id = $task_message_id";}
		$query = " 	SELECT * FROM task_message 
					JOIN task_access ON tac_category = tmg_category
					WHERE (tac_nipp = '$nipp'  OR  tmg_category = 'other')
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	# search
	public function get_task_search($nipp)
	{
		$where = "";
		if($this->input->post("task_name") != ""){$where .= " AND task_name = '%". $this->input->post('task_name') ."%' ";}
		if($this->input->post("task_category") != ""){$where .= " AND task_category = '". $this->input->post('task_category') ."' ";}
		if($this->input->post("task_status") != ""){$where .= " AND task_status = '". $this->input->post('task_status') ."' ";}
		if($this->input->post("task_closed") != ""){$where .= " AND task_closed = '". $this->input->post('task_closed') ."' ";}
		if($this->input->post("task_point") != ""){$where .= " AND task_point = ". $this->input->post('task_point') ." ";}
		if($this->input->post("task_sch_duration_1") != ""){$where .= " AND task_sch_duration >= ". $this->input->post('task_sch_duration_1') ." ";}
		if($this->input->post("task_sch_duration_2") != ""){$where .= " AND task_sch_duration <= ". $this->input->post('task_sch_duration_2') ." ";}
		if($this->input->post("task_act_duration_1") != ""){$where .= " AND task_act_duration >= ". $this->input->post('task_act_duration_1') ." ";}
		if($this->input->post("task_act_duration_2") != ""){$where .= " AND task_act_duration <= ". $this->input->post('task_act_duration_2') ." ";}
		# start
		if($this->input->post("task_sch_start_date_1") != ""){
			$sch_start_date_1 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_sch_start_date_1")." ".$this->input->post("task_sch_start_time_1"))));
			$where .= " AND task_sch_start >= '".$sch_start_date_1."' ";
		}
		if($this->input->post("task_sch_start_date_2") != ""){
			$sch_start_date_2 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_sch_start_date_2")." ".$this->input->post("task_sch_start_time_2"))));
			$where .= " AND task_sch_start <= '".$sch_start_date_2."' ";
		}
		if($this->input->post("task_act_start_date_1") != ""){
			$act_start_date_1 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_act_start_date_1")." ".$this->input->post("task_act_start_time_1"))));
			$where = " AND task_act_start >= '".$act_start_date_1."' ";
		}
		if($this->input->post("task_act_start_date_2") != ""){
			$act_start_date_2 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_act_start_date_2")." ".$this->input->post("task_act_start_time_2"))));
			$where = " AND task_act_start <= '".$act_start_date_2."' ";
		}
		# finish
		if($this->input->post("task_sch_finish_date_1") != ""){
			$sch_finish_date_1 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_sch_finish_date_1")." ".$this->input->post("task_sch_finish_time_1"))));
			$where = " AND task_sch_finish >= '".$sch_finish_date_1."' ";
		}
		if($this->input->post("task_sch_finish_date_2") != ""){
			$sch_finish_date_2 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_sch_finish_date_2")." ".$this->input->post("task_sch_finish_time_2"))));
			$where = " AND task_sch_finish <= '".$sch_finish_date_2."' ";
		}
		if($this->input->post("task_act_finish_date_1") != ""){
			$act_finish_date_1 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_act_finish_date_1")." ".$this->input->post("task_act_finish_time_1"))));
			$where = " AND task_act_finish >= '".$act_finish_date_1."' ";
		}
		if($this->input->post("task_act_finish_date_2") != ""){
			$act_finish_date_2 = mdate("%Y-%m-%d %H:%i:%s",(strtotime($this->input->post("task_act_finish_date_2")." ".$this->input->post("task_act_finish_time_2"))));
			$where = " AND task_act_finish <= '".$act_finish_date_2."' ";
		}
		
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					$where
					ORDER BY task_id DESC 
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	function get_user()
	{
		$query = " SELECT * FROM user_identity ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# insert data
	public function save_data($tabel,$data)
	{
		$this->db->insert($tabel,$data);
		return $this->db->insert_id();
	}
	
	# update data
	public function update_data($tabel,$data,$where)
	{
		$this->db->where($where);
		$this->db->update($tabel,$data);
	}
}