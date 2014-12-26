<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * User Controller
	 *
	 */
	
	
	 function __construct()
	{
        parent::__construct();
		
		# load model, library and helper
		$this->load->model('member_model','', TRUE);
		
		
		# restrict all function access after log in
		if ($this->session->userdata('logged_in'))
				{ 
					# check module active
					if($this->module_management->module_active('module_active') == FALSE){redirect('messages/error/module_inactive');}
					
					# kick guest user
					if($this->user_access->level('user_access')==0){redirect('messages/error/not_authorized');}
				}
			
				else
				{
					# redirect to login if not
					redirect('user/password_login');
				}	
    }

	function index()
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
		
		//$data['last_news'] 	= $this->docs_model->get_last_news();
		#pagination config
		$search = "";
		$config['base_url'] = base_url().'ioc/dashboard/index/'; 
		$config['total_rows'] = $this->docs_model->count_document_download($search,$ui_level,$ui_nipp); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		#data preparing
		$data['list_file'] = $this->docs_model->get_document_download($search,$ui_level,$ui_nipp,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page_start'] = $page;
		if(($page + $config['per_page']) < $data['count'] ){$data['page_end'] = $page + $config['per_page'];}
		else{$data['page_end'] = $data['count'];}
		$data['result_chart'] = $this->docs_model->get_all_document_download();
		
		# sidebar nav 
		$data['menu_ioc'] = 'class="current"' ;
		$data['view_ioc_dashboard'] = 'class="current"' ;
		$data['search'] = $search;
		# call views		
		$this->load->view('dashboard', $data);
	}
	
	function search()
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
		
		# content
		//$data['last_news'] 	= $this->docs_model->get_last_news();
		if ($this->input->post('search') == NULL)
		{
			$search = str_replace("%20"," ",$this->uri->segment(4));
		}else{
			$search = $this->input->post('search');
		}
		
		#pagination config
		$config['base_url'] = base_url().'ioc/dashboard/search/'.$search.'/'; 
		$config['total_rows'] = $this->docs_model->count_document_download($search,$ui_level,$ui_nipp); 
		$config['per_page'] = 50; 
		$config['uri_segment'] = 5; 
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		#data preparing
		$data['list_file'] = $this->docs_model->get_document_download($search,$ui_level,$ui_nipp,$config['per_page'],$page);
		$data['count']	= $config['total_rows'];
		$data['page_start'] = $page;
		if(($page + $config['per_page']) < $data['count'] ){$data['page_end'] = $page + $config['per_page'];}
		else{$data['page_end'] = $data['count'];}
		$data['result_chart'] = $this->docs_model->get_all_document_download();
		
		# sidebar nav 
		$data['menu_ioc'] = 'class="current"' ;
		$data['view_ioc_dashboard'] = 'class="current"' ;
		$data['search'] = $search;
		# call views		
		$this->load->view('dashboard', $data);
	}
	
	public function download()
	{
		$df_id = $this->uri->segment(4);
		$data_files = $this->docs_model->get_doc_files_by_id_file($df_id); 
		foreach($data_files as $df){
			$path = $df->df_file_path.$df->df_system_name."-".$df->df_real_name;
			$name = $df->df_real_name;
			$dfd_id = $df->dfd_id;
			$download  = $df->dfd_count + 1;
		}
		if(is_file($path))
		{
			$set = array("dfd_count" => $download);
			$where = array("dfd_id" => $dfd_id);
			$this->docs_model->update_data('docs_file_download',$set,$where);
		
			// for IE
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

			$this->load->helper('file');

			$mime = get_mime_by_extension($path);
			header('Pragma: public');     
			header('Expires: 0');         
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);  
			header('Content-Disposition: attachment; filename="'.basename($name).'"');  
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); 
			header('Connection: close');
			readfile($path); 
			exit();
		}else{
			redirect("messages/error/error_404");
		}
	}
	
	function like()
	{
		$df_id = $this->uri->segment(4);
		$like = $this->uri->segment(5); 
		$data_files = $this->docs_model->get_doc_files_by_id_file($df_id); 
		foreach($data_files as $df){
			if($like == "yes"){
				if(($df->dfd_like + $df->dfd_dislike + 1) > 0){ $rep = floor(10 * ($df->dfd_like + 1) / ($df->dfd_like + $df->dfd_dislike + 1));}else{ $rep = 0;}
				$dfd_like = $df->dfd_like + 1;
				$dfd_dislike = $df->dfd_dislike;
			}else{
				if(($df->dfd_like + $df->dfd_dislike + 1) > 0){ $rep = floor(10 * $df->dfd_like / ($df->dfd_like + $df->dfd_dislike + 1));}else{ $rep = 0;}
				$dfd_like = $df->dfd_like;
				$dfd_dislike = $df->dfd_dislike + 1;
			}
			$where = array( "dfd_id" => $df->dfd_id );  
			$set = array( 	"dfd_like" => $dfd_like,
							"dfd_dislike" => $dfd_dislike,
							"dfd_reputation" => $rep,
						);
		}
		$this->docs_model->update_data("docs_file_download",$set,$where);
		redirect("ioc/dashboard");
	}
	
	function dislike()
	{
		$df_id = $this->uri->segment(4);
		$data_files = $this->docs_model->get_doc_files_by_id_file($df_id); 
		foreach($data_files as $df){
			if(($df->like + $df->dislike + 1) > 0){ $rep = floor($df->like / ($df->like + $df->dislike));}else{ $rep = 0;}
			$where = array( "dfd_id" => $df->dfd_id ); 
			$set = array( 	"dfd_dislike" => ($df->dfd_dislike + 1),
							"dfd_reputation" => $rep,
						);
		}
		$this->docs_model->update_data("docs_file_download",$set,$where);
		redirect("ioc/dashboard");
	}
	
	function details()
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
		  
		# statistic
		$data['query_open'] 		= $this->docs_model->stat_my_open($ui_nipp);
		$data['query_progress'] 	= $this->docs_model->stat_my_progress($ui_nipp);
		$data['query_completed'] 	= $this->docs_model->stat_my_completed($ui_nipp);
		$data['query_closed'] 		= $this->docs_model->stat_my_closed($ui_nipp);
		
		# sidebar nav 
		$data['menu_ioc'] = 'class="current"' ;
		$data['view_ioc_dashboard'] = 'class="current"' ;
		
		# call views		
		$this->load->view('dashboard_details', $data);
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */