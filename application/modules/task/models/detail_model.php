<?php
class Detail_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
    }
	
	public function get_detail_task($task_id)
	{
		$query = " SELECT * FROM task WHERE task_id = $task_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_history_task($task_id)
	{
		$query = " SELECT * FROM task_status_history WHERE tsh_task_id = $task_id ORDER BY tsh_id DESC";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_discussion_task($task_id)
	{
		$query = " SELECT * FROM task_discussion WHERE td_task_id = $task_id ORDER BY td_id DESC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_file_task($task_id)
	{
		$query = " SELECT * FROM task_file WHERE tf_task_id = $task_id ORDER BY tf_id ASC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_child_task($task_id)
	{
		$query = " SELECT * FROM task WHERE task_parent_id = $task_id ORDER BY task_id ASC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function count_status_task($ui_id,$status)
	{
		$where = "";
		if($status == "taken"){$where.="  AND task_status = 'taken'  AND  task_taken = '$ui_id'  ";}
		$query = " SELECT * FROM task WHERE task_closed = 'no' AND task_closed = 'no' $where ";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_related_user_category_by_task_id($task_id)
	{
		$query = " SELECT * FROM task JOIN task_access  ON task_category = tac_category JOIN user_identity ON ui_nipp = tac_nipp WHERE task_id = $task_id ";
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
	
	
	
}