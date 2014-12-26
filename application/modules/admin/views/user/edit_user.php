<?php include($this->config->item('header')); ?>
<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>User</h1>
        </div>
		
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/user', 'USER', 'title="user area"');?> <i class="fa fa-angle-double-right"></i> USER </h4>
        </div>
      </div>
      <!-- row -->
	  
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span6 col-lg-6">
          
          <!-- widget -->
          <div class="block">
          
          	<!-- wigget content -->
            <div class="data-fluid">

			<?php echo form_open('admin/user/update'); ?>
        	
            
            
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
		   <td>company</td>
		   <td>
			    <select name="company" id="company" class="form-control">
					<option value="00">select company</option>
					<?php foreach ( $company as $item ) : ?>
					<option value="<?php echo $item->vc_id ?>"><?php echo strtoupper( $item->vc_name ) ?></option>
					<?php endforeach ?>
				</select>
			</td>
			</tr>
			
			<tr>
		   <td>directorate</td>
				<td>
				<select  name="directorate" id="directorate" class="form-control">
				<option value="00">select directorate</option>
				</select>
				</td>
			</tr>
			
			<tr>
		   <td>Station</td>
				<td>
				<select  name="station" id="station" class="form-control">
				<option value="00">select station</option>
				</select>
				</td>
			</tr>
			
		   <tr>
		   <td>unit</td>
				<td>
				<select  name="unit" id="unit" class="form-control">
				<option value="00">select unit</option>
				</select>
				</td>
			</tr>
			
		   <tr>
		   <td>Sub Unit</td>
				<td>
				<select  name="sub_unit" id="subunit" class="form-control">
				<option value="00">select sub unit</option>
				</select>
				</td>
			</tr>
			
			<tr>
		   <td>Team</td>
				<td>
				<select  name="team" id="team" class="form-control">
				<option value="00">select team</option>
				</select>
				</td>
			</tr>
			
			<tr>
		   <td>Function</td>
				<td>
				<select name="pangkat" id="pangkat" class="form-control">
					<option value="00">select pangkat</option>
					<?php foreach ($pangkat as $item) : ?>
					<option value="<?php echo $item->vf_code ?>"><?php echo strtoupper( $item->vf_name ) ?></option>
					<?php endforeach ?>
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
	  

       
<?php include($this->config->item('footer')); ?>

	  <script type="text/javascript">
	
	$(document).ready(function(){
	
		/* pengaturan id select dropdown */
		$_company	= $('select#company');
		$_directorate	= $('select#directorate');
		$_station	= $('select#station');
		$_unit 		= $('select#unit');
		$_subunit	= $('select#subunit');
		$_team		= $('select#team');
		
		
		/* select dengan id station on change */
		$_company.change(function(){
		
			$this = $(this);
			
			$.get( '<?php echo base_url() ?>user/ajax_station/select_directorate/' + $this.val(), function(data){
			$_directorate.html( data ? data : '<option value="01">NON</option>' );
				
				$.get( '<?php echo base_url() ?>user/ajax_station/select_station/' + $_directorate.val(), function(data){
				$_station.html( data ? data : '<option value="01">NON</option>' );
					
					$.get( '<?php echo base_url() ?>user/ajax_station/select_unit/' + $_station.val(), function(data){
					$_unit.html( data ? data : '<option value="01">NON</option>' );
					
						$.get( '<?php echo base_url() ?>user/ajax_station/select_sub_unit/' + $_unit.val(), function(data){
						$_sub_unit.html( data ? data : '<option value="01">NON</option>' );
					
							$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $_sub_unit.val(), function(data){
							$_team.html( data ? data : '<option value="01">NON</option>' );
				
							});
				
						});
			
					});
			
				});
			
			});
			
		});
		
		
		$_directorate.change(function(){
		$this = $(this);
			
				$.get( '<?php echo base_url() ?>user/ajax_station/select_station/' + $this.val(), function(data){
				$_station.html( data ? data : '<option value="01">NON</option>' );
					
					$.get( '<?php echo base_url() ?>user/ajax_station/select_unit/' + $_station.val(), function(data){
					$_unit.html( data ? data : '<option value="01">NON</option>' );
					
						$.get( '<?php echo base_url() ?>user/ajax_station/select_sub_unit/' + $_unit.val(), function(data){
						$_sub_unit.html( data ? data : '<option value="01">NON</option>' );
					
							$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $_sub_unit.val(), function(data){
							$_team.html( data ? data : '<option value="01">NON</option>' );
				
							});
				
						});
			
					});
			
				});
			
			});
		
		
		$_station.change(function(){
		$this = $(this);
			
			$.get( '<?php echo base_url() ?>user/ajax_station/select_unit/' + $this.val(), function(data){
			$_unit.html( data ? data : '<option value="01">NON</option>' );
				
				$.get( '<?php echo base_url() ?>user/ajax_station/select_subunit/' + $_unit.val(), function(data){
				$_subunit.html( data ? data : '<option value="01">NON</option>' );
					
					
					$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $_subunit.val(), function(data){
					$_team.html( data ? data : '<option value="01">NON</option>' );
				
					});
				
				});
			
			});
			
		});
		
		
		$_unit.change(function(){
		$this = $(this);

			$.get( '<?php echo base_url() ?>user/ajax_station/select_subunit/' + $this.val(), function(data){
			$_subunit.html( data ? data : '<option value="01">NON</option>' );
				
				
				$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $this.val(), function(data){
				$_team.html( data ? data : '<option value="01">NON</option>' );
				
				});
				
				
			});
			
		});
		
		 
		
		$_subunit.change(function(){
		$this = $(this);

			$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $this.val(), function(data){
			$_team.html( data ? data : '<option value="01">NON</option>' );
				
			});
			
		});
		
		
		return false;
	
	});
	
</script>