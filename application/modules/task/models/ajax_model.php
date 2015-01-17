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




}
/* End of file user_model.php */
/* Location: ./application/modules/user/models/user_model.php */