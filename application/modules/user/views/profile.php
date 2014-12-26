<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>User Profile</h1>
        </div>
		
	  <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('user/profile', 'USER', 'title="User Profile"');?> <i class="fa fa-angle-double-right"></i> PROFILE </h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-12">
          
            
            <?php if($this->session->userdata('logged_in')) { ?>
        <?php if(isset($message) OR validation_errors() ){ ?><div id="dialog-message" title="Message"><p><?php echo $message . validation_errors(); ?></p></div><?php } ?>
            
           <table class="table table-bordered">
           		<tr>
                	<td>nama</td>
                    <td colspan="2"><?php echo strtoupper($ui_nama); ?></td>
                </tr>
                <tr>
                	<td>nipp</td>
                    <td colspan="2"><?php echo $ui_nipp; ?></td>
					<!--<td><?php echo anchor('ems/pekerja/get_pegawai/'.$ui_nipp,'Detail', 'class="btn btn-default"');?></td>-->
                </tr>
                <tr>
                	<td>email</td>
                    <td colspan="2"><?php echo $ui_email; ?></td>
                </tr>
                <tr>
                	<td>handphone</td>
                    <td colspan="2"><?php echo $ui_hp; ?></td>
                </tr>
                <tr>
                	<td>level</td>
                    <td colspan="2"><?php echo $ui_level; ?></td>
                </tr>
                <tr>
                	<td>password</td>
                    <td colspan="2"><?php echo anchor('user/edit/change_password', 'change password', 'class="btn btn-danger"'); ?></td>
                </tr>
                <tr>
                	<td>station</td>
                    <td colspan="2"><?php echo strtoupper($station_name); ?></td>
                </tr>
                <tr>
                	<td>unit</td>
                    <td colspan="2"><?php echo strtoupper($unit_name); ?></td>
                </tr>
                <tr>
                	<td>sub unit</td>
                    <td colspan="2"><?php echo strtoupper($sub_unit_name); ?></td>
                </tr>
                <tr>
                	<td>team</td>
                    <td colspan="2"><?php echo strtoupper($team_name); ?></td>
                </tr>
                <tr>
                	<td>pangkat</td>
                    <td colspan="2"><?php echo strtoupper($pangkat_name); ?></td>
                </tr>
                <tr>
                	<td>jabatan</td>
                    <td colspan="2"><?php echo strtoupper($ui_jabatan); ?></td>
                </tr>
           
           </table>
            
            <?php } ?>
            
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->
	</div>
<?php include($this->config->item('footer')); ?>