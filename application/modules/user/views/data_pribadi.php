<?php include($this->config->item('header')); ?>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('user/data_pribadi', 'USER', 'title="User Profile"');?> <i class="fa fa-angle-double-right"></i> DATA PRIBADI </h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-12">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-pencil-square-o"></i> data pribadi</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            
            <?php if($pribadi_type == 'pribadi'){ ?>
            
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><?php echo anchor('user/data_pribadi', 'Data Pribadi'); ?></li>
                <li class=""><a data-toggle="tab" href="#tabs-2">Alamat</a></li>
                <li class=""><a data-toggle="tab" href="#tabs-3">Pasangan</a></li>
                <li class=""><a data-toggle="tab" href="#tabs-4">Anak</a></li>
                <li class=""><a data-toggle="tab" href="#tabs-5">Orang Tua</a></li>
                <li class=""><a data-toggle="tab" href="#tabs-6">Mertua</a></li>
             </ul>   
            
            
            <div class="tab-content" id="myTabContent">
                <div id="#home" class="tab-pane fade active in">
                <div class="widget-header">    <h3><i class="fa fa-folder-open-o"></i> Data Pribadi</h3> </div>
            
  
    		<?php
			if($pribadi == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($pribadi as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					echo '<tr>';
					echo '<td>NIPP</td>';
					echo '<td>' . $row->peg_nipp . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->peg_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->peg_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' . mdate("%d-%m-%Y", strtotime($row->peg_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Jenis Kelamin</td>';
					echo '<td>' . $row->peg_jns_kelamin . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Golongan Darah</td>';
					echo '<td>' . $row->peg_gol_darah . '</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>

			</div>
           
    
			<div id="tabs-2" class="tab-pane fade">
  
  			<div class="widget-header">    <h3><i class="fa fa-flag-o"></i> Data Alamat</h3> </div>
                
             <?php
			 if($alamat == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($alamat as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					echo '<tr>';
					echo '<td>Jalan</td>';
					echo '<td>' . $row->p_al_jalan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Kelurahan</td>';
					echo '<td>' . $row->p_al_kelurahan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Kecamatan</td>';
					echo '<td>' . $row->p_al_kecamatan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Kabupaten</td>';
					echo '<td>' . $row->p_al_kabupaten . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Provinsi</td>';
					echo '<td>' . $row->p_al_provinsi . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>No Telp</td>';
					echo '<td>' . $row->p_al_no_telp . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Email</td>';
					echo '<td>' . $row->p_al_email . '</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>

			</div>
            
    
    		<div id="tabs-3" class="tab-pane fade">
  
  			<div class="widget-header">    <h3><i class="fa fa-pencil-square-o"></i> Data Keluarga</h3> </div>
    		<?php
			if($pasangan == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($pasangan as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->p_ps_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->p_ps_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' .  mdate("%d-%m-%Y", strtotime($row->p_ps_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Meninggal *</td>';
					echo '<td>' . $row->p_ps_tgl_meninggal . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Alamat</td>';
					echo '<td>' . $row->p_ps_alamat . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pekerjaan</td>';
					echo '<td>' . $row->p_ps_pekerjaan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Jenis Kelamin</td>';
					echo '<td>' . $row->p_ps_jns_kelamin . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Agama</td>';
					echo '<td>' . $row->p_ps_agama . '</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>
		
  			</div>
    
			
            <div id="tabs-4" class="tab-pane fade">
  			<div class="widget-header">    <h3><i class="fa fa-comments"></i> Data anak</h3> </div>    
    		<?php
			if($anak == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($anak as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->peg_ank_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->peg_ank_tempat_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' .  mdate("%d-%m-%Y", strtotime($row->peg_ank_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pendidikan</td>';
					echo '<td>' . $row->peg_ank_pendidikan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Jenis Kelamin</td>';
					echo '<td>' . $row->peg_ank_jns_kelamin . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Agama</td>';
					echo '<td>' . $row->peg_ank_agama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Status</td>';
					echo '<td>' . $row->peg_ank_status . '</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>
  			</div>
    
    
    		<div id="tabs-5" class="tab-pane fade">
  <div class="widget-header">    <h3><i class="fa fa-bar-chart-o"></i> Data orang tua</h3> </div>
    		<?php
			if($orangtua == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($orangtua as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->p_ay_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->p_ay_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' .  mdate("%d-%m-%Y", strtotime($row->p_ay_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Meninngal</td>';
					echo '<td>' . $row->p_ay_tgl_meninggal . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Alamat</td>';
					echo '<td>' . $row->p_ay_alamat . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pekerjaan</td>';
					echo '<td>' . $row->p_ay_pekerjaan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->p_ibu_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->p_ibu_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' .  mdate("%d-%m-%Y", strtotime($row->p_ibu_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Meninggal</td>';
					echo '<td>' . $row->p_ibu_tgl_meninggal . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Alamat</td>';
					echo '<td>' . $row->p_ibu_alamat . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pekerjaan</td>';
					echo '<td>' . $row->p_ibu_pekerjaan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>
		 	</div>
    
    
    		<div id="tabs-6" class="tab-pane fade">
  			<div class="widget-header">    <h3><i class="fa fa-bar-chart-o"></i> Data mertua</h3> </div>
    		<?php
			if($mertua == NULL)
			{
				echo "<p>EMS Server connection problem, please contact Team SIGAP</p>";
			}
			else
			{
				foreach($mertua as $row) 
				{ 
					echo '<table class="table table-bordered table-striped">';
					
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->p_may_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->p_may_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' .  mdate("%d-%m-%Y", strtotime($row->p_may_tgl_lahir)) . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Meninngal</td>';
					echo '<td>' . $row->p_may_tgl_meninggal . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Alamat</td>';
					echo '<td>' . $row->p_may_alamat . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pekerjaan</td>';
					echo '<td>' . $row->p_may_pekerjaan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Nama</td>';
					echo '<td>' . $row->p_mib_nama . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tempat Lahir</td>';
					echo '<td>' . $row->p_mib_tmpt_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Lahir</td>';
					echo '<td>' . $row->p_mib_tgl_lahir . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Tanggal Meninggal</td>';
					echo '<td>' . $row->p_mib_tgl_meninggal . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Alamat</td>';
					echo '<td>' . $row->p_mib_alamat . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>Pekerjaan</td>';
					echo '<td>' . $row->p_mib_pekerjaan . '</td>';
					echo '</tr>';
					
					echo '<tr>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '</tr>';
					
					echo '</table>';
					
				}
			}
			?>
		
  	</div>
    
    
    </div>
    </div>
  	<?php
  	}
	else
	{
			echo "<p>" . $pribadi_type . "</p>";
	}
	?>
            
            </div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->
<?php include($this->config->item('footer')); ?>