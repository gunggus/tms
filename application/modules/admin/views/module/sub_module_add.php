<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Module</h1>
        </div>
		
	<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title">
			  <?php echo anchor($this->uri->segment(1, '') . '/' . $this->uri->segment(2, ''), $this->uri->segment(1, ''), 'title="Manage Unit"');?> 
              <i class="fa fa-angle-double-right"></i> 
              <?php echo $this->uri->segment(2, ''); ?> 
          </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-8">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> add module</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            		<?php if (isset($message)){echo '<p class="text-warning">message : ' . $message . '</p>';} ?>
            		<?php if (validation_errors()){echo '<p>message : ' . validation_errors() . '</p>';} ?>
            	
            		<?php echo form_open('admin/module/save'); ?>
                    
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-4 control-label">Module Name</label>
    				<div class="col-sm-4">
                	<?php echo form_input('mod_name', $mod_name, 'class="form-control" '); ?>
                	</div>
              	</div>
                </div>
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-4 control-label">Sub Module</label>
    				<div class="col-sm-4">
                    <?php $module = directory_map(APPPATH . '/modules/' . $mod_name . '/controllers/', 1); ?>
                    <select name="mod_sub" class="form-control">
					<?php 
					foreach($module as $item){?>
                    	<?php if($item == 'index.html' || $item == 'ajax_station.php' || $item == 'password_login.php' ){continue;} else { ?>
                        <option value="<?php echo preg_replace('/\.php$/', '', $item) ; ?>"><?php echo preg_replace('/\.php$/', '', $item) ; ?></option>
                    	<?php } }; ?>
                    </select>
					
                	</div>
              	</div>
                </div>
                

               
                
                
                
                
				
			
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-4 control-label">Active</label>
    				<div class="col-sm-4">
                	<?php echo form_checkbox('mod_active', 'y', TRUE); ?>
                	</div>
              	</div>
                </div>
				
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-4 control-label">Hide From Menu</label>
    				<div class="col-sm-4">
                	<?php echo form_checkbox('mod_hide', 'n', FALSE); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-4 control-label"></label>
    				<div class="col-sm-4">
                	<?php echo form_submit('submit', 'save', 'class="form-control btn btn-primary pull-right"'); ?>
                	</div>
              	</div>
                </div>
                
                <?php echo form_close(); ?>
            
            </div>
      	  </div>
       	</div>
      </div> 
    </div>
	
<?php include($this->config->item('footer')); ?>
