<?php
class Task_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
    }
	
	# task list
	public function get_status_task($nipp,$username,$status,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($status == 'taken'){ $where .= " AND task_taken_by = '$username' ";}
		if($status == 'complete'){ $where .= " AND task_complete_by = '$username' ";}
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_status = '$status'
					$where
					ORDER BY task_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# task list
	public function get_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if(($parent_id == 0) AND ($master_id == 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0 AND task_id = '$task_id' ";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
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
	
	# parent task list
	public function get_parent_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if(($parent_id == 0) AND ($master_id == 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0 AND task_id = '$task_id' ";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_parent_id = 0
					$where
					ORDER BY task_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	# task actuating list
	public function get_actuating_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if(($parent_id == 0) AND ($master_id == 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0 AND task_id = '$task_id' ";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
		if($limit > 0){ $limited.=" 	LIMIT $offset,$limit ";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_is_child = 'yes'
					$where
					ORDER BY task_id DESC
					$limited
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function get_task_by_task_id($task_id)
	{
		$query = "  SELECT * FROM task WHERE task_id = $task_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function get_category_unit_by_task_id($task_id)
	{
		$query = "  SELECT * FROM task LEFT JOIN task_category ON task_unit = tc_unit WHERE task_id = $task_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function get_user_category_unit_by_task_id($task_id)
	{
		$query = "  SELECT * FROM task LEFT JOIN task_category ON task_unit = tc_unit LEFT JOIN task_access ON tc_category = tac_category LEFT JOIN user_identity ON ui_nipp = tac_nipp WHERE task_id = $task_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function get_user_list()
	{
		$query = " SELECT * FROM user_identity ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# my task list
	public function get_my_task($nipp,$status,$ui_nama,$limit,$offset)
	{
		$where = "";
		$limited = "";
		if($status == "taken"){$where.=" AND task_status = 'taken'  AND  task_taken_by = '$ui_nama' ";}
		if($limit > 0){ $limited.=" LIMIT $offset,$limit ";}
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
	# get all announcement
	public function get_all_announcement()
	{
		$query = " SELECT * FROM task_announcement ORDER BY tan_id DESC LIMIT 50";
		$query = $this->db->query($query);
		return $query->result();
	}
	# get task announcement
	public function get_announcement($announcement)
	{
		$query = " SELECT * FROM task_announcement WHERE tan_title LIKE '%$announcement%' ORDER BY tan_id DESC LIMIT 50";
		$query = $this->db->query($query);
		return $query->result();
	}
	# task applyment
	public function get_applyment($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
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
					AND task_is_applyment = 'yes'
					AND task_is_approve = 'no'
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
	# get unit
	public function get_unit()
	{
		$query = "	SELECT * FROM var_unit
					ORDER BY vu_name ASC
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# get skill category
	public function get_skill_category()
	{
		$query = "	SELECT * FROM var_skill
					ORDER BY skill_point ASC
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
		if($nama != "ALL"){$where.=" AND point_username LIKE '$nama' ";}
		if($start != "ALL"){$where.=" AND point_date >= '$start' ";}
		if($end != "ALL"){$where.=" AND point_date <= '$end' ";}
		if($where != ""){$where = " WHERE  ".substr($where,4);}
		$query = "	SELECT * FROM point
					LEFT JOIN task ON point_task_id = task_id
					LEFT JOIN absensi ON point_abs_id = abs_id
					$where
					ORDER BY point_id DESC
					LIMIT $offset,$limit	
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	/*
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
	*/
	# count performance task
	public function count_performance_task($nama,$start,$end)
	{
		$where = "";
		if($nama != "ALL"){$where.=" AND point_username LIKE '$nama' ";}
		if($start != "ALL"){$where.=" AND point_date >= '$start' ";}
		if($end != "ALL"){$where.=" AND point_date <= '$end' ";}
		if($where != ""){$where = " WHERE  ".substr($where,4);}
		$query = "	SELECT * FROM point
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	/*
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
	*/
	# count task
	public function count_task($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if(($parent_id = 0) AND ($master_id = 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	# count parent task
	public function count_parent_task($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if(($parent_id = 0) AND ($master_id = 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_parent_id = 0
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	# count task
	public function count_actuating_task($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if(($parent_id = 0) AND ($master_id = 0) AND ($task_id > 0)){
			$where.= " AND task_parent_id = 0";
		}else{
			if($master_id > 0){$where.= " AND task_master_id = $master_id";}
			if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
			if($task_id > 0){$where.= " AND task_id = $task_id";}
		}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_is_child = 'yes'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	# count task
	public function count_applyment($nipp,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		$query = " 	SELECT * FROM task 
					LEFT JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_is_applyment = 'yes'
					AND task_is_approve = 'no'
					AND task_closed = 'no'
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	# count status task
	public function count_status_task($nipp,$username,$status,$master_id,$parent_id,$task_id)
	{
		$where = "";
		if($status == 'taken'){ $where .= " AND task_taken_by = '$username' ";}
		if($status == 'complete'){ $where .= " AND task_update_by = '$username' ";}
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					AND task_closed = 'no'
					AND task_status = '$status'
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
	
	# delete data
	public function delete_data($tabel,$where)
	{
		$this->db->where($where);
		$this->db->delete($tabel);
	}
	
	# get absensi
	public function get_absensi($user,$start_date,$end_date,$limit,$offset)
	{
		$where = "";
		if($user != 'ALL'){ $where .= " AND abs_nama LIKE '$user' ";}
		if($start_date != 'ALL'){ $where .= " AND DATE(abs_in)>='$start_date' ";}
		if($end_date != 'ALL'){ $where .= " AND DATE(abs_in)<='$end_date' ";}
		if($where != ''){$where = " WHERE ".substr($where,4);}
		$query = " 	SELECT * 
					FROM absensi
					$where 
					ORDER BY abs_in DESC
					LIMIT $offset,$limit	
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# count absensi
	public function count_absensi($user,$start_date,$end_date)
	{
		$where = "";
		if($user != 'ALL'){ $where .= " AND abs_nama LIKE '$user' ";}
		if($start_date != 'ALL'){ $where .= " AND DATE(abs_in)>='$start_date' ";}
		if($end_date != 'ALL'){ $where .= " AND DATE(abs_in)<='$end_date' ";}
		if($where != ''){$where = " WHERE ".substr($where,4);}
		$query = " 	SELECT * 
					FROM absensi
					$where 
				";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	public function get_absensi_by_id($abs_id)
	{
		$query = " SELECT * FROM absensi WHERE abs_id = $abs_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_task_by_abs_id($abs_id)
	{
		/*
		$query = " 	SELECT * FROM absensi 
					JOIN task ON (abs_in < task_complete_on  AND  task_complete_on < '$date')	
					JOIN point ON (( task_id = point_task_id )) 
					WHERE abs_id = $abs_id
					AND point_username = abs_nama
					AND task_complete_by = point_username	
				";
		*/
		$query = "  SELECT * FROM point
					LEFT JOIN task ON task_id = point_task_id 
					WHERE point_abs_id = $abs_id
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_minimum_point()
	{
		$query = " SELECT * FROM var_point";
		$query = $this->db->query($query);
		$result = $query->result();
		$minpoint = 0;
		foreach($result as $row){$minpoint = $row->min_point_out;}
		return $minpoint;
	}
	public function get_target_point($nipp)
	{
		$query = " SELECT * FROM point_target WHERE pt_nipp = '$nipp' ";
		$query = $this->db->query($query);
		$result = $query->result();
		$minpoint = 0;
		foreach($result as $row){$minpoint = $row->pt_min_point;}
		return $minpoint;
	}
	public function get_shift($shift)
	{
		$where = "";
		if(($shift != "") AND ($shift != "ALL")){ $where.= " AND shift_title = '$shift'  ";  }
		if($where != ''){$where = " WHERE ".substr($where,4);}
		$query = " SELECT * FROM var_shift $where ";
		$query = $this->db->query($query);
		return $query->result();	
	}
	public function get_var_point()
	{
		$query = " SELECT * FROM var_point ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_category_access($nipp,$limit,$offset)
	{
		$where = "";
		if($nipp != 'ALL'){ $where .= " WHERE ta_nipp = '$nipp' "; }
		$query = " SELECT * FROM task_access LEFT JOIN user_identity ON ta_nipp = ui_nipp $where ORDER BY ta_nipp ASC LIMIT $offset,$limit ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function count_category_access($nipp)
	{
		$where = "";
		if($nipp != 'ALL'){ $where .= " WHERE ta_nipp = '$nipp' "; }
		$query = " SELECT * FROM task_access LEFT JOIN user_identity ON ta_nipp = ui_nipp $where ";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	public function get_data_point($point_id)
	{
		$query = " SELECT * FROM point WHERE point_id = $point_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_last_abs_id($ui_nipp)
	{
		$query = " SELECT * FROM absensi WHERE abs_nipp LIKE '$ui_nipp' ORDER BY abs_id DESC LIMIT 1 ";
		$query = $this->db->query($query);
		$result = $query->result();
		foreach($result as $row){$abs_id =  $row->abs_id;}
		if(isset($abs_id)){ return $abs_id;}else{return 0;}
	}
	public function count_task_status($ui_id,$status)
	{
		$where = "";
		if($status == "open"){$where.=" AND task_created = '$ui_id' AND task_status = 'open' ";}
		if($status == "taken"){$where.=" AND task_taken = '$ui_id' AND task_status = 'taken' ";}
		if($status == "complete"){$where.=" AND task_complete = '$ui_id' AND task_status = 'complete' ";}
		$query = " SELECT * FROM task WHERE task_closed LIKE '%%' $where ORDER BY task_id";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	public function get_nipp_by_user_id($ui_id)
	{
		$query = " SELECT * FROM user_identity WHERE ui_id = $ui_id ";
		$query = $this->db->query($query);
		$result = $query->result();
		foreach($result as $row)
		{
			$nipp = $row->ui_nipp;
		}
		return $nipp;
	}	
	public function get_total_child_target_duration($task_id)
	{
		$query = " SELECT *, SUM(task_sch_duration_minute) as 'tot_duration_minute' FROM  task WHERE task_parent_id = $task_id GROUP BY task_parent_id";
		$query = $this->db->query($query);
		return $query->result();
	}
	
}