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
        <div class="span12 col-xs-12 col-sm-6 col-md-8">
          
          <!-- widget -->
          <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
            <?php if (isset($message)){echo '<p>error message : ' . $message . '</p>';} ?>
            <?php if (validation_errors()){echo '<p>error message : ' . validation_errors() . '</p>';} ?>
            
            <?php echo form_open('admin/user/admin_save', 'class="form-horizontal"'); ?>    
             
            
                 
  <div class="row-form">
    <label for="inputName" class="span2 col-sm-2 control-label">Name</label>
    <div class="span6 col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="Name" name="nama">
    </div>
  </div>  
  
  <div class="row-form">
    <label for="inputNipp" class="span2 col-sm-2 control-label">NIPP</label>
    <div class="span6 col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="NIPP" name="nipp">
    </div>
  </div>        
  
  <div class="row-form">
    <label for="inputHandphone" class="span2 col-sm-2 control-label">Handphone</label>
    <div class="span6 col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="Handphone" name="hp">
    </div>
  </div>        
  
  <div class="row-form">
    <label for="inputEmail" class="span2 col-sm-2 control-label">Email</label>
    <div class="span6 col-sm-6">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputPassword" class="span2 col-sm-2 control-label">Password</label>
    <div class="span6 col-sm-6">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputStation" class="span2 col-sm-2 control-label">Company</label>
    <div class="span6 col-sm-6">
    	<select name="company" id="company" class="form-control">
            <option value="00">select company</option>
            <?php foreach ( $company as $item ) : ?>
                <option value="<?php echo $item->vc_id ?>"><?php echo strtoupper( $item->vc_name ) ?></option>
            <?php endforeach ?>
        </select>
      
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputUnit" class="span2 col-sm-2 control-label">Directorate</label>
    <div class="span6 col-sm-6">
      <select  name="directorate" id="directorate" class="form-control">
            <option value="00">select directorate</option>
        </select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputStation" class="span2 col-sm-2 control-label">Station</label>
    <div class="span6 col-sm-6">
    	<select  name="station" id="station" class="form-control">
            <option value="00">select station</option>
        </select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputUnit" class="span2 col-sm-2 control-label">Unit</label>
    <div class="span6 col-sm-6">
      <select  name="unit" id="unit" class="form-control">
            <option value="00">select unit</option>
        </select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputSubUnit" class="span2 col-sm-2 control-label">Sub Unit</label>
    <div class="span6 col-sm-6">
      <select name="sub_unit" id="subunit"  class="form-control">
            <option value="00">select sub unit</option>
        </select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputTeam" class="span2 col-sm-2 control-label">Team</label>
    <div class="span6 col-sm-6">
      <select name="team" id="team" class="form-control">
        <option value="00">select team</option>
    </select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputTeam" class="span2 col-sm-2 control-label">Function</label>
    <div class="span6 col-sm-6">
      <select name="pangkat" id="pangkat" class="form-control">
	  <option value="00">select pangkat</option>
            <?php foreach ($pangkat as $item) : ?>
                <option value="<?php echo $item->vf_level ?>"><?php echo strtoupper( $item->vf_name ) ?></option>
            <?php endforeach ?>
			
	</select>
    </div>
  </div>
  
  <div class="row-form">
    <label for="inputJabatan" class="span2 col-sm-2 control-label">Jabatan</label>
    <div class="span6 col-sm-6">
      <input type="jabatan" class="form-control" id="inputEmail3" placeholder="Jabatan" name="jabatan">
    </div>
  </div>
			
	   </table>
 
            <?php echo form_submit('update','SAVE', 'class="btn btn-primary"'); ?>
            	
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
					
						$.get( '<?php echo base_url() ?>user/ajax_station/select_subunit/' + $_unit.val(), function(data){
						$_subunit.html( data ? data : '<option value="01">NON</option>' );
					
							$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $_subunit.val(), function(data){
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
					
						$.get( '<?php echo base_url() ?>user/ajax_station/select_subunit/' + $_unit.val(), function(data){
						$_subunit.html( data ? data : '<option value="01">NON</option>' );
					
							$.get( '<?php echo base_url() ?>user/ajax_station/select_team/' + $_subunit.val(), function(data){
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