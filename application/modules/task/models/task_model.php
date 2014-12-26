<?php
class Task_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
    }
	
	# task list
	public function get_task($nipp,$master_id,$parent_id,$task_id,$limit,$offset)
	{
		$where = "";
		if($master_id > 0){$where.= " AND task_master_id = $master_id";}
		if($parent_id > 0){$where.= " AND task_parent_id = $parent_id";}
		if($task_id > 0){$where.= " AND task_id = $task_id";}
		$query = " 	SELECT * FROM task 
					JOIN task_access ON tac_category = task_category
					WHERE tac_nipp = '$nipp'
					$where
					LIMIT $offset,$limit
				";
		$query = $this->db->query($query);
		return $query->result();
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
					$where
				";
		$query = $this->db->query($query);
		return $query->num_rows();
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