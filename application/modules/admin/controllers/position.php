<?php

	class Position extends CI_Controller 
	{
		
	/**
		 * PT Gapura Angkasa
		 * Module : Admin 
		 * Sub Module : Position
		 *
		 * verification controller
		 *
		 * url : http://localhost/github/office/application/modules/admin/controllers/position.php
		 * developer : pandhawa digital
		 * phone : 0361 853 2400
		 * email : pandhawa.digital@gmail.com
		 *
		 * warning !!!
		 * please do not copy, edit, or distribute this script without developer permission.
		 *
		 */
		
		private $data;
			
		function __construct()
    		{
				parent::__construct();
				$this->load->helper( array( 'url','form' ));	
				$this->load->model('user_level');
				
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
					redirect('user/pin_login');
				}	
			}
				
		function add_position()
		{
		
			if ( $this->input->post('submit') ) {
			$data = array(
					
						'vp_code'          	=> $this->input->post('vp_code'),
						'vp_name'    		=> $this->input->post('vp_name'),
						'vp_vt_code'        => $this->input->post('vp_vt_code'),
						'vp_vf_code'        => $this->input->post('vp_vf_code'),
						'vp_level'          => $this->input->post('vp_level')
						);
			$this->user_level->add_position( $data );
			
			}
			$this->load->view('position/form_position');
			#redirect('position/tabel_position');
		}
		
		function tabel_position()
		{
		
			$data['records'] = $this->user_level->position_tabel();
			if ( $this->input->post( 'search' ) ) $data['records'] = $this->user_level->search_position( $this->input->post( 'search' ));		
			#menampilkan tabel station
			$this->load->view('position/tabel_position',$data);	
			
		}
		
		function delete($id)
		{
			#delete data position berdasarkan id
			$this->user_level->delete_position($id);
			#load view tabel_position
			redirect('position/tabel_position');
		}
		
		function edit($id)
		{
			$query = $this->user_level->edit_position($id);
					 $data['fvp_code']    = $query ['vp_code'];
					 $data['fvp_name']    = $query ['vp_name'];
					 $data['fvp_vt_code'] = $query ['vp_vt_code'];
					 $data['fvp_vf_code'] = $query ['vp_vf_code'];
					 $data['fvp_level']   = $query ['vp_level'];
		
			$this->load->view('position/edit_position',$data);
		}
		
		function submit()
    	{
					#menyimpan nilai input di file sementara dan menyimpan ke field database
                    $vp_code               = $this->input->post('vp_code');
					$vp_name               = $this->input->post('vp_name');
					$vp_vt_code            = $this->input->post('vp_vt_code');
					$vp_vf_code            = $this->input->post('vp_vf_code');
					$vp_level              = $this->input->post('vp_level');
					
					$data = array(
					'vp_code'                =>$vp_code,
					'vp_name'                =>$vp_name,
					'vp_vt_code'             =>$vp_vt_code,
					'vp_vf_code'             =>$vp_vf_code,
					'vp_level'               =>$vp_level);
					
					$this->db->where('vp_code',$vp_code);
					$this->db->update('var_position',$data);
					
				 	#script mengarahkan ke tabel_asset
					redirect('position/tabel_position');
		}
		
		
		
	}

/* End of file position.php */
/* Location: ./application/modules/admin/controllers/position.php */	
?>