<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	 /**
	 * PT Dharma Bandar Mandala
	 * Module : User 
	 * Sub Module : login
	 *
	 * login controller
	 *
	 * url : http://whobth.dbmcargo.com/modules/user/controllers/login.php
	 * developer : studio kami mandiri
	 * phone : 0361 853 2400
	 * email : support@studiokami.com
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
		if ($this->session->userdata('logged_in'))
		{ 
			# access roles
			$module = 'user';
			$sub_module = 'login';
			$allow_access = 50; # guest= 0 user=10 management=20 operator=30 supervisor=40 admin=50 
			
			$ui_nipp = $this->session->userdata['logged_in']['ui_nipp'];$ui_login = $this->session->userdata['logged_in']['ui_login'];
			chmod(FCPATH . 'wp-uploads/data/temp/' . $module . '-' . $sub_module .'.tmp', 0777);
			$content = file_get_contents(FCPATH . 'wp-uploads/data/temp/' . $module . '-' . $sub_module .'.tmp');
			$content = str_getcsv($content, ';');foreach($content as $items):$roles = explode(':', $items);$vm_id = $roles[0];
			$vm_active = $this->encrypt->decode($roles[1]);$vm_hide = $this->encrypt->decode($roles[2]);endforeach;
			echo "$vm_active - $vm_hide";
			//if($vm_active == 'n'){redirect('messages/error/module_inactive');}
			//if($vm_hide == 'y'){redirect('messages/error/module_inactive');}
			chmod(FCPATH . 'wp-uploads/data/temp/' . $module . '-' . $sub_module .'.tmp', 0600);
			chmod(FCPATH . 'wp-uploads/data/bak/' . $ui_login . '.bak', 0777);$content = file_get_contents(FCPATH . 'wp-uploads/data/bak/' . $ui_login . '.bak');
			$content = str_getcsv($this->encrypt->decode($content), ';');
			foreach($content as $key):if(substr($key,0,2) == $vm_id){$access_roles = substr($key,3,2);
			if($access_roles < $allow_access){redirect('messages/error/not_authorized');}}
			endforeach;
			# access roles
		}
		
		
    }
# constuction ------------------------------	

# index ------------------------------------	 
	public function index()
	{
		redirect('user/login/pin', 'refresh');
	}
# index ------------------------------------	

# pin login ---------------------------------
	 
	public function pin()
	{
		# if module active redirect to pin_login
		$this->load->view('pin_login');
	}
# pin login ---------------------------------

# do pin login ------------------------------
	public function pin_do_login()
	{
		# get email data from form		
		$email = $this->input->post('email');
		$email_encrypt = $email;	
		
		#validate data
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		

		if ($this->form_validation->run() == FALSE)
		{
			# validation fail do re-login
			$data['message'] = 'invalid email';
			$this->load->view('pin_login', $data);
		}
		else
		{
			# check email on local database 
			$result = $this->user_model->check_reg_email($email_encrypt);
			
			if($result)
			{
					# if email found on database
					foreach($result as $row):
						 $id = $row->ui_id;
						 $nama = $this->encrypt->decode($row->ui_nama); 
						 $nipp = $row->ui_nipp; 
						 $hp_encrypt = $this->encrypt->decode($row->ui_hp); 
						 $email = $email; 
						 $password = $row->ui_password; 
						 $level = $row->ui_level; 
						 $jabatan = $row->ui_jabatan; 
						 $registration_on = $row->ui_registration_on; 
						 $verification = $row->ui_verification; 
						 $ver_date = $row->ui_ver_date;
						 $approval = $row->ui_approval;
						 $approval_by = $row->ui_approval_by;
						 $approval_on = $row->ui_approval_on;
			 		endforeach;
					
					# email check
					chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0777);
					$email_db = file_get_contents(FCPATH . 'wp-uploads/data/log/' . $id . '.dat');
					if($this->encrypt->decode($email_db) <> $email){ redirect('message/error/db_error'); }
					chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0600);
					
					
					# if user exist then check user approval by admin
					if($approval == 'n')
					{
						# if user exist but no approve yet, call admin
						$data['message'] = 'Your profile not approved yet, please contact admin';
						$this->load->view('pin_login', $data);
					}
					else
					{
						# send view
						$data['email'] = $email;
						
						#
						# call models to delete previous verification duplicate data
						$this->user_model->del_dup_prev_ver_data($email_encrypt);
						
						# call models to delete unverify duplicate user data on user identity table
						$this->user_model->del_dup_prev_user_unver_data($email);
						
						# create random pin
						$this->load->helper('pin');
						$pin = get_pin(); 
						$email_link = $email . '+' . $pin ;
						$pin_encypt = $this->encrypt->sha1($pin, $this->config->item('encryption_key'));
						
						# encrypt email link to send via email
						$email_link = urlencode(base64_encode($email_link));
						
						# set request date & expired date
						$request = mdate("%Y-%m-%d %H:%i:%s", time());
						$expired = mdate("%Y-%m-%d %H:%i:%s", time()+3600);
						
						# set verification type
						$type = 'login';
						
						# call models to save verification data
						$this->user_model->save_verification($email_encrypt, $hp_encrypt, $type, $pin_encypt, $email_link, $request, $expired);
						
						# send pin and link via email
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						
						# send pin and link via smtp
						/*$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'ssl://smtp.googlemail.com';
						$config['smtp_port'] = 465;
						$config['smtp_user'] = 'xxx@xxxxxx.co.id';
						$config['smtp_pass'] = 'xxxx';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");*/
						# send pin and link via smtp
						
						$this->email->from('xxxxxxxxxxxx', 'Admin WHO CGK');
						$this->email->to($email); 
						$this->email->subject('PT GAPURA ANGKASA Login System');
						$this->email->message('
						
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Untitled Document</title>
						</head>
						
						<body>
						<p>Anda telah melakukan registrasi pin untuk melakukan login pada aplikasi</p>
						<p>Silahkan melakukan verifikasi dengan menggunakan pin berikut pada halaman verifikasi</p>
						<p>PIN : ' . $pin . '</p>
						<p>atau</p>
						<p>klik link dibawah ini</p>
						<p>LINK : {unwrap}' . anchor("user/verification/" . $email_link, 'user/verification/' . $email_link) . '{/unwrap}</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>Terima kasih</p>
						<p>&nbsp;</p>
						<p>SIGAP Team</p>
						<p>&nbsp;</p>
						</body>
						</html>
						
						');
						$this->email->send();
			
						# send data email through flash data
						$this->session->set_flashdata('email', $email);
						$this->session->set_flashdata('pin', $pin);
						
						# call views
						redirect('user/verification/pin');
						
					}
					
			}
			else
			{
				# send mesg to view
				$data['message']='silahkan melakukan registrasi';
				
				# not register user redirect to register page
				redirect('messages/error/not_registered');
			}
		}
	}
# do pin login ------------------------------





# password login ---------------------------------	 
	public function password()
	{
		# check module active
		$module = 'user';
		$sub_module = 'password_login';
		$active = $this->user_model->check_sub_module($module, $sub_module);
		if($active == FALSE){redirect('messages/error/module_inactive');}
		
		# call view
		$this->load->view('password_login');
	}
# password login ---------------------------------

# do password login ------------------------
	public function do_password_login()
	{
		# get email data from form		
		$email = $this->input->post('email');
		$email_encrypt = $email;	
		
		$password = $this->input->post('password');
		$password_encrypt = $this->encrypt->sha1($password, $this->config->item('encryption_key'));	
		
		#validate data
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		

		if ($this->form_validation->run() == FALSE)
		{
			# validation fail do re-login
			$data['message'] = 'invalid email';
			$this->load->view('password_login', $data);
		}
		else
		{
			# check email on local database 
			$result = $this->user_model->check_reg_email($email_encrypt);
			
			if($result)
			{
				# call models to save verification data
				$result = $this->user_model->do_pass_verification($email_encrypt, $password_encrypt);
					
				# check pin to verify
				if($result)
				   {
					 # if pin sucess prepare session
					 $sess_array = array();
					 foreach($result as $row)
					 {
						$file = now() . substr($row->ui_nipp, -3);
					   $sess_array = array(
					   	 'ui_id' => $row->ui_id,
						 'ui_nama' => $this->encrypt->decode($row->ui_nama, $this->config->item('encryption_key')), 
						 'ui_nipp' => $row->ui_nipp, 
						 'ui_hp' => $this->encrypt->decode($row->ui_hp, $this->config->item('encryption_key')), 
						 'ui_email' => $email, #sh 
						 'ui_level' => $row->ui_level,
						 'ui_jabatan' => $row->ui_jabatan,
						 'ui_verification' => $row->ui_verification, 
						 'ui_ver_date' => $row->ui_ver_date,
						 'ui_registration_on' => $row->ui_registration_on,
						 'ui_approval' => $row->ui_approval,
						 'ui_approval_by' => $row->ui_approval_by,
						 'ui_approval_on' => $row->ui_approval_on,
					   	 'ui_login' => $file,
						);
					   # get access roles
					   $bak = glob(FCPATH . 'wp-uploads/data/bak/*' . substr($row->ui_nipp, -3) . '.bak');foreach($bak as $del):unlink($del);endforeach;
					   $ui_nipp = $row->ui_nipp;$content='';$access_roles = $this->user_model->get_access_roles($ui_nipp);
					   foreach($access_roles as $items):$content .= $items->ua_vm_id . ':' . $items->ua_roles . ';' ;endforeach;
					   write_file(FCPATH . 'wp-uploads/data/bak/' . $file . '.bak', $this->encrypt->encode($content));
					   chmod(FCPATH . 'wp-uploads/data/bak/' . $file . '.bak', 0600);
			
					
						$ui_id = $row->ui_id;
						
					    # db check
						chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0777);
						$email_db = file_get_contents(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat');
						if($this->encrypt->decode($email_db) <> $email){ redirect('message/error/db_error'); }
						chmod(FCPATH . 'wp-uploads/data/log/' . $ui_id . '.dat', 0600);
						
					   # set session for auto login
					   $this->session->set_userdata('logged_in', $sess_array);
					
					}
					 # redirect to dashboard after logged in
					redirect('user/profile/');
					
				   }
				   else
				   {
					 # verification pin fail, force to try again
					 # call view
					$data['email'] = $this->session->flashdata('email');
					$data['pin'] = $this->session->flashdata('pin');
					$this->load->view('password_login');
					 
				   }
			}
			else
			{
				# email not found, push to register
				# send mesg to view
				$data['message']='silahkan melakukan registrasi';
				
				# not register user redirect to register page
				redirect('messages/error/not_registered');
			}
		}
	}
# do password login ------------------------
	
}
/* End of file login.php */
/* Location: ./application/modules/user/controllers/login.php */