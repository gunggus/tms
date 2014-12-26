<?php
class User_model extends CI_Model
{

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : pin login, password login
	 *
	 * models : user_model
	 *
	 * url : http://{_base_url_}/modules/user/models/user_model.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
	 */

	
# constructor ------------------------------------------------------------------------------	
	function __construct()
	{
        parent::__construct();
    }
# constructor ------------------------------------------------------------------------------

# save data on user identity table -------------------------------------
	function save_user($nama_encrypt, $hp_encrypt, $nipp_encrypt, $email_encrypt, $emergency_password, $level_code, $jabatan)
	{
		$data = array(
		'ui_nama' => $nama_encrypt,
		'ui_hp' => $hp_encrypt,
		'ui_nipp' => $nipp_encrypt,
		'ui_email' => $email_encrypt,
		'ui_password' => $emergency_password,
		'ui_level' => $level_code,
		'ui_jabatan' => $jabatan,
		'ui_verification' => 'y',
		'ui_ver_date' => '0000-00-00 00:00:00',
		'ui_approval' => 'y',
		'ui_approval_by' => '',
		'ui_approval_on' => '0000-00-00 00:00:00',
		);
		
		$this->db->insert('user_identity', $data);
		
		return $this->db->insert_id();
	}
# save data on user identity table -------------------------------------

# save data on user verification table ---------------------------------
	function save_verification($email, $hp_encrypt, $type, $pin_encypt, $email_link, $request, $expired)
	{
		$data = array(
		'uv_email' => $email,
		'uv_hp' => $hp_encrypt,
		'uv_type' => $type,
		'uv_pin' => $pin_encypt,
		'uv_link' => $email_link,
		'uv_date' => $request,
		'uv_expired' => $expired,
		);
		
		$this->db->insert('user_verification', $data);
	}
# save data on user verification table ---------------------------------

# do pin verification --------------------------------------------------
	function do_verification($email, $pin)
 	{
	   $this->db->select('uv_email, uv_pin, uv_link');
	   $this->db->from('user_verification');
	   $this->db->where('uv_email',$email);
	   $this->db->where('uv_pin', $pin);
	   $this->db-> limit(1);
	
	   $query = $this->db->get();

	   if($query->num_rows() == 1)
	   {
		 # update verification field on user identity table
		 $data = array(
               'ui_verification' => 'y',
               'ui_ver_date' => date("Y-m-d H:i:s"),
            );
		 $this->db->where('ui_email', $email);
		 $this->db->update('user_identity', $data);
		 
		 # remove verification data on verification table
		 $this->db->delete('user_verification', array('uv_email' => $email)); 
		 
		 # autologin verified user
		 $this -> db -> select('*');
	     $this -> db -> from('user_identity');
	     $this -> db -> where('ui_email', $email);
		 $this -> db -> where('ui_verification', 'y');
	     $this -> db -> where('ui_verification  !=', '0000-00-00 00:00:00');
	     $this -> db -> limit(1);
	     $query = $this -> db -> get();
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	   
 	}
# do pin verification --------------------------------------------------

# do pass verification ---------------------------------------------------
	function do_pass_verification($email_encrypt, $password_encrypt)
 	{
	   /*$this->db->select('ui_email, ui_password');
	   $this->db->from('user_identity');*/
	   $this->db->where('ui_email',$email_encrypt);
	   $this->db->where('ui_password', $password_encrypt);
	   $this->db-> limit(1);
	
	   $query = $this->db->get('user_identity');
	   return $query->result();
		
	    /*if($query->num_rows() > 0)
	   {
		 # autologin verified user
		$this -> db -> select('*');
	     $this -> db -> from('user_identity');
	     $this -> db -> where('ui_email', $email_encrypt);
		 $this -> db -> where('ui_verification', 'y');
		 $this -> db -> where('ui_approval', 'y');
	     $this -> db -> where('ui_verification  !=', '0000-00-00 00:00:00');
	     $this -> db -> limit(1);
	     $query = $this -> db -> get();
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }*/
	   
 	}
# do pass verification ---------------------------------------------------

# check user on user indetity table ------------------------------------
	function check_reg_email($email)
	{
		$query = $this->db->get_where('user_identity', array('ui_email' => $email), 1, 0);
		return $query->result();		
	}
# check user on user indetity table ------------------------------------

# check dup email on user indetity table -------------------------------
	function check_dup_email($email_encrypt)
	{
		$query = $this->db->get_where('user_identity', array('ui_email' => $email_encrypt), 1, 0);
		
		if($query->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
# check dup email on user indetity table -------------------------------

# check dup nipp on user indetity table --------------------------------
	function check_dup_nipp($nipp_encrypt)
	{
		
		$query = $this->db->get_where('user_identity', array('ui_nipp' => $nipp_encrypt), 1, 0);
		
		if ($query->num_rows() > 0)
    	{
        	#return $query->result();
			return TRUE;
    	}
		else
		{
			return FALSE;
		}
		
	}
# check dup nipp on user indetity table --------------------------------

# del previous data on verification table ------------------------------	
	function del_dup_prev_ver_data($nipp_encrypt)
	{
		$this->db->delete('user_verification', array('uv_email' => $nipp_encrypt)); 
	}
# del previous data on verification table ------------------------------		

# del expired data on verification table ------------------------------	
	function del_dup_prev_exp_data()
	{
		$this->db->delete('user_verification', array('uv_expired <' => date("Y-m-d H:i:s"))); 
	}
# del expired data on verification table ------------------------------			

# del previous unverify data on user identity table -------------------		
	function del_dup_prev_user_unver_data($nipp_encrypt)
	{
		$this->db->delete('user_identity', array('ui_email' => $nipp_encrypt, 'ui_verification' => 'n')); 
	}
# del previous unverify data on user identity table -------------------


# update password by user ---------------------------------------------
	function update_password($email_encrypt, $password_encrypt)
	{
		$this->db->where('ui_email', $email_encrypt);
		$this->db->update('user_identity', array('ui_password' => $password_encrypt));
	}
# update password by user ---------------------------------------------

# get all stn available -----------------------------------------------
	function get_company() 
	{
		 $this->db->order_by('vc_id', 'ASC');
		 return $this->db->get( 'var_company' )->result();
	}
# get all stn available -----------------------------------------------

# get all stn available -----------------------------------------------
	function get_directorate($company) 
	{
		 $result = $this->db->where('vd_vc_id', $company)->get('var_directorate')->result();
		 return $result ? $result : false;
	}
# get all stn available -----------------------------------------------

# get all stn available -----------------------------------------------
	function get_station($directorate) 
	{
		 $result = $this->db->where('vs_vd_id', $directorate)->get('var_station')->result();
		 return $result ? $result : false;
	}
# get all stn available -----------------------------------------------

# get unit  available -------------------------------------------------		
	function get_unit($station)
	{
		$result = $this->db->where('vu_vs_id', $station)->get('var_unit')->result();
		return $result ? $result : false;	
	}
# get unit  available -------------------------------------------------		

# get all sub unit available ------------------------------------------		
	function get_subunit($unit) 
	{
		$result = $this->db->where( 'vsu_vu_id', $unit )->get( 'var_sub_unit' )->result();
		return $result ? $result : false;
	}
# get all sub unit available ------------------------------------------

# get all team available ---------------------------------------------- 		
	function get_team($subunit) 
	{
		$result = $this->db->where( 'vt_vsu_id', $subunit )->get( 'var_team' )->result();
		return $result ? $result : false;
	}
# get all team available ---------------------------------------------- 

# get all function available ------------------------------------------
	function get_function() 
	{
		 $this->db->order_by('vf_level', 'DESC');
		 return $this->db->get( 'var_function' )->result();
		 
	}
# get all function available ------------------------------------------

# get stn level -------------------------------------------------------
	function get_station_level($station) 
	{
		$result = $this->db->where( 'vs_code', $station )->get( 'var_station' )->result();
		return $result ? $result : false;
	}
# get stn level -------------------------------------------------------

# get unit level ------------------------------------------------------
	function get_unit_level($unit) 
	{
		$result = $this->db->where( 'vu_code', $unit )->get( 'var_unit' )->result();
		return $result ? $result : false;
	}
# get unit level ------------------------------------------------------
	
# get sub unit level --------------------------------------------------
	function get_sub_unit_level($sub_unit) 
	{
		$result = $this->db->where( 'vsu_code', $sub_unit )->get( 'var_sub_unit' )->result();
		return $result ? $result : false;
	}
# get sub unit level --------------------------------------------------

# get team level ------------------------------------------------------
	function get_team_level($team) 
	{
		$result = $this->db->where( 'vt_code', $team )->get( 'var_team' )->result();
		return $result ? $result : false;
	}
# get team level ------------------------------------------------------

function get_company_data($company) 
	{
		$result = $this->db->where( 'vc_id', $company )->get( 'var_company' )->result();
		return $result ? $result : false;
	}

function get_directorate_data($directorate) 
	{
		$result = $this->db->where( 'vd_id', $directorate )->get( 'var_directorate' )->result();
		return $result ? $result : false;
	}

# get stn data based on code ------------------------------------------
	function get_station_data($station) 
	{
		$result = $this->db->where( 'vs_id', $station )->get( 'var_station' )->result();
		return $result ? $result : false;
	}
# get stn data based on code ------------------------------------------

# get unit data based on code -----------------------------------------
	function get_unit_data($unit, $station_code) 
	{
		 $this -> db -> select('*');
	     $this -> db -> from('var_unit');
	     $this -> db -> where('vu_id', $unit);
		 #$this -> db -> where('vu_vs_id', $station_code);
	     $query = $this -> db -> get();
		 return $query->result();
	}
# get unit data based on code -----------------------------------------
	
# get sub unit data based on code -------------------------------------
	function get_sub_unit_data($sub_unit, $unit_code) 
	{
		 $this -> db -> select('*');
	     $this -> db -> from('var_sub_unit');
	     $this -> db -> where('vsu_id', $sub_unit);
		 #$this -> db -> where('vsu_vu_id', $unit_code);
	     $query = $this -> db -> get();
		 return $query->result();
	}
# get sub unit data based on code -------------------------------------

# get team data based on code -----------------------------------------
	function get_team_data($team, $sub_unit_code) 
	{
		$this -> db -> select('*');
	     $this -> db -> from('var_team');
	     $this -> db -> where('vt_id', $team);
		 #$this -> db -> where('vt_vsu_id', $sub_unit_code);
	     $query = $this -> db -> get();
		 return $query->result();
	}
# get team data based on code -----------------------------------------

# get function data based on code -------------------------------------
	function get_pangkat_data($pangkat) 
	{
		$this -> db -> select('*');
	     $this -> db -> from('var_function');
	     $this -> db -> where('vf_level', $pangkat);
	     $query = $this -> db -> get();
		 return $query->result();
	}
# get function data based on code -------------------------------------

# get access roles ----------------------------------------------------
	function get_access_roles($ui_nipp)
	{
		$this->db->where('ua_nipp', $ui_nipp);
		$this->db->where('ua_end', '0000-00-00 00:00:00');
		$this->db->or_where('ua_end >', date("Y-m-d H:i:s")); 
		$query = $this->db->get('user_access');
		return $query->result();
	}
# get access roles ----------------------------------------------------
	
	function search($keyword)
    {
        $this->db->like('ui_email',$keyword);
		$this->db->or_like('ui_nama' , $keyword);
		$this->db->or_like('ui_nipp',$keyword);
		$this->db->or_like('ui_jabatan',$keyword);
		
        $query  =  $this->db->get('user_identity');
        return $query->result();
    }
}

