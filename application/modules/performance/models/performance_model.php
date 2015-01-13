<?php
class Performance_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
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
	# get performance task
	public function get_chart_performance($nipp,$start,$end)
	{
		$where = "";
		if($start != "ALL"){$where.=" AND point_date >= '$start' ";}
		if($end != "ALL"){$where.=" AND point_date <= '$end' ";}
		$query = "	SELECT * FROM point
					WHERE point_nipp LIKE '$nipp' 
					$where
					ORDER BY point_date ASC
				";
		$query = $this->db->query($query);
		return $query->result();
	}
	# get target
	public function  get_target($nipp)
	{
		$query = " SELECT * FROM point_target WHERE pt_nipp = '$nipp' ";
		$query = $this->db->query($query);
		$result = $query->result();
		$target = 0;
		foreach($result as $row){$target = $row->pt_min_point;}
		return $target;
	}
	
	function get_user()
	{
		$query = " SELECT * FROM user_identity ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function get_data_point($point_id)
	{
		$query = "SELECT * FROM point WHERE point_id = $point_id";
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