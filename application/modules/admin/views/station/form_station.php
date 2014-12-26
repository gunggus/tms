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
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> add station</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            		<?php if(isset($message) OR validation_errors() ){ ?><div id="dialog-message" title="Message"><p><?php echo $message . validation_errors(); ?></p></div><?php } ?>
            	
            		<?php echo form_open('admin/station/save'); ?>
                    
                    <?php echo form_hidden('parent_id', $parent_id); ?>
                
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Station Code</label>
    				<div class="col-sm-4">
					<?php echo form_input('code', '', 'class="form-control" placeholder="Station Code" '); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Station Name</label>
    				<div class="col-sm-4">
                	<?php echo form_input('name', '', 'class="form-control" placeholder="Station Name" '); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label"><?php echo anchor('admin/station/manage/', 'back to station list', 'class="btn btn-primary"'); ?></label>
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
