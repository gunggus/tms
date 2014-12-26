<?php include($this->config->item('header')); ?>
				
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
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> add company</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            		<?php if(isset($message) OR validation_errors() ){ ?><div id="dialog-message" title="Message"><p><?php echo $message . validation_errors(); ?></p></div><?php } ?>
            	
            		<?php echo form_open('admin/company/save'); ?>
                    
                
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Company Code</label>
    				<div class="col-sm-4">
					<?php echo form_input('com_code', '', 'class="form-control" placeholder="Company Code" '); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Company Name</label>
    				<div class="col-sm-4">
                	<?php echo form_input('com_name', '', 'class="form-control" placeholder="Company Name" '); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label"><?php echo anchor('admin/company/manage/', 'back to company list', 'class="btn btn-primary"'); ?></label>
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
       
<?php include($this->config->item('footer')); ?>
