<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends CI_Controller {

	/**
	 * Manage Controller
	 *
	 */
	
	
	function __construct()
	{
        parent::__construct();
		$this->load->model('detail_model', '', TRUE);
		# user restriction
		if ($this->session->userdata('logged_in')):
			if($this->module_management->module_active('module_active') == FALSE):redirect('messages/error/module_inactive');endif;
			if($this->user_access->level('user_access')==0):redirect('messages/error/not_authorized');endif;
		else:
			redirect('user/pin_login'); 	
		endif;	
	}

	function index()
	{
		redirect("task/manage/task");
	}
	
	function task()
	{
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

		$nama = $this->uri->segment(4, 'ALL');
		$start_date = $this->uri->segment(5, 'ALL');
		$end_date = $this->uri->segment(6, 'ALL');
		
		$task_id = $this->uri->segment(4, 0);
		
		$data['task_id'] = $task_id;
		$data['result'] = $this->detail_model->get_detail_task($task_id);
		$data['discussion'] = $this->detail_model->get_discussion_task($task_id);
		$data['history'] = $this->detail_model->get_history_task($task_id);
		$data['file'] = $this->detail_model->get_file_task($task_id);
		$data['child'] = $this->detail_model->get_child_task($task_id);
		
		$this->load->view('detail_task',$data);
	}
	
	function discussion()
	{
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

		$nama = $this->uri->segment(4, 'ALL');
		$start_date = $this->uri->segment(5, 'ALL');
		$end_date = $this->uri->segment(6, 'ALL');
		
		$task_id = $this->uri->segment(4, 0);
		
		if($this->input->post("file") == ""){$attach = "no";}else{$attach = "yes";}
		$data = array(
			"td_task_id" => $task_id,
			"td_nipp"	=>	$ui_nipp,
			"td_text"	=>	$this->input->post("text"),
			"td_attach" =>  $attach,
			"td_update_by" =>  $ui_nama,
			"td_update_on" =>  mdate("%Y-%m-%d %H:%i:%s",time()),
		);
		$td_id = $this->detail_model->save_data("task_discussion",$data);
		
		# set upload config
		$config['upload_path'] = './wp-uploads/task/file/';
		$config['allowed_types'] = 'pdf|gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pps|ppsx';
		$config['max_size']	= '99999';
		$config['max_width']  = '99999';
		$config['max_height']  = '99999';
	
		# call upload lib
		$this->load->library('upload', $config);
				
		# check is there any file to upload	
		if ($this->upload->do_upload("file"))
		{
			# file to upload = true
			$upload_data = $this->upload->data();
			
			# GET REAL DATA FOR DB
			$tf_td_id = $td_id;
			$tf_task_id = $task_id;
			$tf_file_name = $this->security->sanitize_filename($upload_data['file_name']);
			$tf_file_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $tf_file_name);
			$tf_system_name = date("YmdHis"); 
			$tf_ext			= $upload_data['file_ext'];	  	 	 	 	 	 	
			$tf_size		= $upload_data['file_size'];	 	 	 	 	 	 	
			$tf_update_by	= $ui_nama;
			$tf_update_on	= date("Y-m-d H:i:s");		
			
			# call model
			$datafile = array(
				"tf_td_id" => $tf_td_id ,
				"tf_task_id" => $tf_task_id ,
				"tf_file_name" => $tf_file_name ,
				"tf_system_name" => $tf_system_name , 
				"tf_ext" => $tf_ext	,	  	 	 	 	 	 	
				"tf_size" => $tf_size ,	 	 	 	 	 	 	
				"tf_update_by" => $tf_update_by ,
				"tf_update_on" => $tf_update_on ,		
			);
			$tf_files_id = $this->detail_model->save_data("task_file",$datafile);
			
			# rename file after upload and remove ext
			rename($upload_data['full_path'], $upload_data['file_path'] . $tf_system_name . '-' . $tf_file_name);
		}
		redirect("task/detail/task/$task_id");
	}
	
}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */