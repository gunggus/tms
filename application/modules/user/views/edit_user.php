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
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> edit user</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">

			<?php echo form_open('admin/user/update'); ?>
        	
            <?php echo form_hidden ('company','02');?>
			<?php echo form_hidden ('directorate','04');?>
            
        <table class="table table-bordered">
            
            <?php 
				foreach($query as $items) : 
					$ui_id		 = $items->ui_id;
					$ui_nama	 = $this->encrypt->decode($items->ui_nama);
					$ui_nipp 	 = $items->ui_nipp;
					$ui_hp 		 = $this->encrypt->decode($items->ui_hp);
					$ui_email    = $items->ui_email;
					
				endforeach; 
			?>
            
               
			<?php echo form_hidden('ui_id', $ui_id); ?>
            
			<tr>
				<td>Nama</td>
               
				<td><?php echo form_input('ui_nama', $ui_nama,'class="form-group"'); ?></td>
			</tr>
			
			<tr>
				<td>NIP</td>
               
				<td><?php echo form_input('ui_nipp', $ui_nipp,'class="form-group"'); ?></td>
			</tr>
			<tr>
				<td>HandPhone</td>
               
				<td><?php echo form_input('ui_hp', $ui_hp,'class="form-group"'); ?></td>
			</tr>
			<tr>
				<td>Email</td>
               
				<td><?php echo form_input('ui_email', $ui_email,'class="form-group"'); ?></td>
			</tr>

		   <tr>
		   <td>Station</td>
				<td>
				<select name="station" id="station" class="form-control">
					<option value="none">select station</option>
					<?php foreach ( $station as $item ) : ?>
						<option value="<?php echo $item->vs_id ?>"><?php echo ucfirst( $item->vs_name ) ?></option>
					<?php endforeach ?>
				</select>
				</td>
			</tr>
			
		   <tr>
		   <td>unit</td>
				<td>
				<select  name="unit" id="unit" class="form-control">
            <option value="none">select unit</option>
        </select>
				</td>
			</tr>
			
			<tr>
		   <td>Sub Unit</td>
				<td>
				<select  name="sub_unit" id="subunit" class="form-control">
				<option value="none">select sub unit</option>
				</select>
				</td>
			</tr>
			
			<tr>
		   <td>Team</td>
				<td>
				<select  name="team" id="team" class="form-control">
				<option value="none">select team</option>
				</select>
				</td>
			</tr>
			
			<tr>
		   <td>Function</td>
				<td>
				<select name="pangkat" id="pangkat" class="form-control">
        <option value="03">Direktur</option>
		<option value="04">Satuan Pengawas Internal</option>
		<option value="05">Vice President</option>
		<option value="06">General Manager</option>
		<option value="07">Deputy General Manager</option>
		<option value="08">Senior Manager</option>
		<option value="09">Manager</option>
		<option value="10">Assistant Manager</option>
		<option value="11">Supervisor</option>
		<option value="12">Staff</option>
		<option value="13">Staff Ahli</option>
        <option value="14">Pelaksana Tugas</option>
        <option value="15">Pelaksana Harian</option>
        <option value="16">On Job Training</option>
        <option value="17">Praktek Kerja Lapangan</option>
    </select>
				</td>
			</tr>
			
			<tr>
		   <td>Jabatan</td>
				<td>
				<input type="jabatan" class="form-control" id="inputEmail3" placeholder="Jabatan" name="jabatan">
				</td>
			</tr>
			
	   </table>
 
            <?php echo form_submit('update','UPDATE', 'class="btn btn-primary"'); ?>
            	
    		<?php echo form_close(); ?>
       
		
			</div>
      	  </div>
       	</div>
      </div> 
	</div>	

       
<?php include($this->config->item('footer')); ?>

	  <script type="text/javascript">
	
	$(document).ready(function(){
	
		/* pengaturan id select dropdown */
		$_station	= $('select#station');
		$_unit 		= $('select#unit');
		$_subunit	= $('select#subunit');
		$_team		= $('select#team');
		
		/* select dengan id station on change */
		$_station.change(function(){
		
			$this = $(this);
			
			/* 	ambil konten ke '/ajax_station/select_unit/' + id station
				Contoh: '/ajax_station/select_unit/04'
			*/
			$.get( '<?php echo base_url() ?>admin/ajax_station/select_unit/' + $this.val(), function(data){
				
				/* replace konten select unit dengan data dari server, jika data tidak kosong */				
				$_unit.html( data ? data : '<option value="01">NON</option>' );
				
				/** menyesuaikan data subunit, untuk menghindari kesalahan data **/
				
				/* 	ambil konten ke '/ajax_station/select_subunit/' + id unit
					Contoh: '/ajax_station/select_subunit/04'
				*/
				$.get( '<?php echo base_url() ?>admin/ajax_station/select_subunit/' + $_unit.val(), function(data){
			
					/* replace select subunit dengan data dari server, jika tidak kosong */
					$_subunit.html( data ? data : '<option value="01">NON</option>' );
					
					
					$.get( '<?php echo base_url() ?>admin/ajax_station/select_team/' + $this.val(), function(data){
			
					// replace select subunit dengan data dari server, jika tidak kosong
					$_team.html( data ? data : '<option value="01">NON</option>' );
				
					});
				
				});
			
			});
			
		});
		
		/* select unit on change */
		$_unit.change(function(){
		
			$this = $(this);

			/* 	ambil konten ke '/ajax_station/select_subunit/' + id unit
				Contoh: '/ajax_station/select_subunit/04'
			*/
			$.get( '<?php echo base_url() ?>admin/ajax_station/select_subunit/' + $this.val(), function(data){
			
				/* replace select subunit dengan data dari server, jika tidak kosong */
				$_subunit.html( data ? data : '<option value="01">NON</option>' );
				
				
				$.get( '<?php echo base_url() ?>admin/ajax_station/select_team/' + $this.val(), function(data){
			
				// replace select subunit dengan data dari server, jika tidak kosong
				$_team.html( data ? data : '<option value="01">NON</option>' );
				
				});
				
				
			});
			
		});
		
		 
		
		// select unit on change
		$_subunit.change(function(){
		
			$this = $(this);

			// 	ambil konten ke '/ajax_station/select_subunit/' + id unit
			//	Contoh: '/ajax_station/select_subunit/04'
			
			$.get( '<?php echo base_url() ?>admin/ajax_station/select_team/' + $this.val(), function(data){
			
				// replace select subunit dengan data dari server, jika tidak kosong
				$_team.html( data ? data : '<option value="01">NON</option>' );
				
			});
			
		});
		
		
		return false;
	
	});
	
</script>