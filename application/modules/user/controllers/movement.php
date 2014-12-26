<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : User Profile
	 *
	 * profile controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/profile.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */
	
	
# constuction ------------------------------	
	 function __construct()
	{
        parent::__construct();
		
		# load model, library and helper
		$this->load->model('user_model','', TRUE);
		
		# restrict all function access after log in
		/*if (!$this->session->userdata('logged_in'))
		{ 
			# redirect to login if not
			redirect('user/pin_login');
		}*/
		
    }
# constuction ------------------------------	

# index ------------------------------------	 
	public function index()
	{
		 $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
		 $server = '{imap.googlemail.com:993/imap/ssl/novalidate-cert}INBOX'; 
		 $username = 'sigap@gapura.co.id';
		 $password = 'gapura2013';
		 
		 # connect to inbox
		 $inbox = imap_open($server,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
		 
		 # get total email in inbox
		 $no = imap_num_msg($inbox); #echo $no;
		
		 for($i = 1; $i <= $no; $i++)
		 {
			 # extract header
			 $header_extract = imap_headerinfo($inbox,$i);
			 
			 # check subjec format
			 $text_count = substr_count($header_extract->subject, '/');
			 
			 # subject must contain 5 delimeter
			 if($text_count = 5)
			 {
				 # get structure
			 	 $structure = imap_fetchstructure($inbox, $i);
			 
				 # extract subject
				 $header_subject = explode("/",strtolower($header_extract->subject));
				 
				 # if subject contains mvt
				 if($header_subject[0] == 'mvt')
				 {
					 
					 if($header_subject[1] == 'dep') # if subject contain mvt dep
					 {
						# get mesg
						$data =  $this->mvt_qg_dep($inbox, $structure, $i);
						
						#print_r($data);
						
						# get flight dsd_id
						
						# insert into db
						
						# delete email
						imap_delete($inbox, $i);
					 }
					 elseif($header_subject[1] == 'arr') # if subject contain mvt arr
					 {
						# get msg
						$data =  $this->mvt_qg_arr($inbox, $structure, $i);
						
						#print_r($data);
						
						# get dsa_id
						
						# insert into db
						
						# delete email
						imap_delete($inbox, $i);
					 }
				 }
			 }
			 
			 
		 }
		
			
			
		imap_close($inbox);
	}
# index ------------------------------------	

	

	function mvt_qg_arr($inbox, $structure, $i)
	{
		# reading message
		if($structure->encoding == 0)
		{
			if($structure->type == 0){$text = strtolower(imap_body($inbox, $i));}
			elseif($structure->parts[0]->encoding == 0){$text = strtolower(imap_body($inbox, $i));}
			elseif($structure->parts[0]->encoding == 03){$text = trim(strtolower(imap_base64(imap_fetchbody($inbox, $i, 1))));}
			else{$text = strtolower(imap_body($inbox, $i));}
		}
		elseif($structure->encoding == 1){$text = strtolower(imap_8bit(imap_body($inbox, $i)));}
		elseif($structure->encoding == 2){$text = strtolower(imap_binary(imap_body($inbox, $i)));}
		elseif($structure->encoding == 3){$text = strtolower(imap_base64(imap_body($inbox, $i)));} 
		elseif($structure->encoding == 4){$text = strtolower(imap_qprint(imap_body($inbox, $i)));}	
		
		# finding mvt msg			 
		if($structure->encoding == 0)
		{
			if($structure->type == 0){$text = $this->getBetween($text,'mvt','mvt');$text = explode("\r\n",$text);} # send from blackberry
			elseif($structure->parts[0]->encoding == 3){$text = $this->getBetween($text,'mvt','mvt');$text = preg_replace("/\s+/", '+', $text);
			$text = explode("+",$text);}# send from android
			else{$text = $this->getBetween($text,'mvt','mvt');$text = explode("\r\n",$text);}# send from browser
		}
		else
		{
			$text = $this->getBetween($text,'mvt','mvt');$text = str_replace("</div>", "", $text);$text = str_replace(" ", "", $text);
			$text = explode("<div>",$text);# send from blackberry
		}
					
					
		# line 1
		$message = explode(".", $text[1]);
		
		$flight_details = explode("/", $message[0]);
		$data['flt_no'] = $flight_details[0];
		$data['flt_date'] = $flight_details[1];
		
		
		# line 2
		$message = explode("/", $text[2]);
		$data['keyword'] = $message[0];
		$data['touch_down'] = $message[1];
		$data['block_on'] = $message[2];
		
		# return data
		return $data;

	}

	function mvt_qg_dep($inbox, $structure, $i)
	{
		print_r($structure);
		# reading message
		if($structure->encoding == 0)
		{
			if($structure->type == 0){$text = strtolower(imap_body($inbox, $i));}
			elseif($structure->parts[0]->encoding == 0){$text = strtolower(imap_body($inbox, $i));}
			elseif($structure->parts[0]->encoding == 03){$text = trim(strtolower(imap_base64(imap_fetchbody($inbox, $i, 1))));}
			else{$text = strtolower(imap_body($inbox, $i));}
		}
		elseif($structure->encoding == 1){$text = strtolower(imap_8bit(imap_body($inbox, $i)));}
		elseif($structure->encoding == 2){$text = strtolower(imap_binary(imap_body($inbox, $i)));}
		elseif($structure->encoding == 3){$text = strtolower(imap_base64(imap_body($inbox, $i)));} 
		elseif($structure->encoding == 4){$text = strtolower(imap_qprint(imap_body($inbox, $i)));}	
		
		# finding mvt msg			 
		if($structure->encoding == 0)
		{
			if($structure->type == 0){$text = $this->getBetween($text,'mvt','mvt');$text = explode("\r\n",$text);} # send from blackberry
			elseif($structure->parts[0]->encoding == 3){$text = $this->getBetween($text,'mvt','mvt');$text = preg_replace("/\s+/", '+', $text);
			$text = explode("+",$text);}# send from android
			else{$text = $this->getBetween($text,'mvt','mvt');$text = explode("\r\n",$text);}# send from browser
		}
		else
		{
			$text = $this->getBetween($text,'mvt','mvt');$text = str_replace("</div>", "", $text);$text = str_replace(" ", "", $text);
			$text = explode("<div>",$text);# send from blackberry
		}
					
					
		# line 1
		$message = explode(".", $text[1]);
		
		$flight_details = explode("/", $message[0]);
		$data['flt_no'] = $flight_details[0];
		$data['flt_date'] = $flight_details[1];
		
		
		# line 2
		$message = explode("/", $text[2]);
		$data['keyword'] = $message[0];
		$data['touch_down'] = $message[1];
		$data['block_on'] = $message[2];
		
		$data['type'] = $structure->type;
		
		# return data
		return $data;
	}
	
	function getBetween($content,$start,$end){
		$r = explode($start, $content);
		if (isset($r[1])){
			$r = explode($end, $r[1]);
			return $r[0];
		}
	}
	
}

/* End of file profile.php */
/* Location: ./application/modules/user/controllers/profile.php */