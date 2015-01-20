<?php
class Ajax_model extends CI_Model
{

# constructor ------------------------------------------------------------------------------	
	function __construct()
	{
        parent::__construct();
    }
# constructor ------------------------------------------------------------------------------


# get all category
	function get_category_task($unit)
	{
		$result = $this->db->where('tc_unit', $unit)->get('task_category')->result();
		return $result ? $result : false;	
	}
# get all category

# get task access
	function get_task_access($category)
	{
		$query = " SELECT * FROM task_access JOIN user_identity ON tac_nipp = ui_nipp WHERE tac_category = '$category' ";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result ? $result : false;	
	}
# get task access



}
/* End of file user_model.php */
/* Location: ./application/modules/user/models/user_model.php */