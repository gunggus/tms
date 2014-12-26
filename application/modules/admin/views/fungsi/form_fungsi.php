<?php include($this->config->item('header')); ?>
				
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title">
			  <?php echo anchor($this->uri->segment(1, '') . '/' . $this->uri->segment(2, ''), strtoupper($this->uri->segment(1, '')), 'title="Manage Function"');?> 
              <i class="fa fa-angle-double-right"></i> 
              <?php echo strtoupper($this->uri->segment(2, '')); ?> 
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
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> add pangkat</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            		<?php if (isset($message)){echo '<p class="text-warning">message : ' . $message . '</p>';} ?>
            		<?php if (validation_errors()){echo '<p>message : ' . validation_errors() . '</p>';} ?>
            	
            		<?php echo form_open('admin/fungsi/save'); ?>
                    
                
				<div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Fungsi Code</label>
    				<div class="col-sm-4">
					<?php echo form_input('vf_code', '', 'class="form-control" placeholder="Function Code" '); ?>
                	</div>
              	</div>
                </div>
                
                
                <div class="form-group">
                <div class="row">
    				<label for="inputName" class="col-sm-3 control-label">Fungsi Name</label>
    				<div class="col-sm-4">
                	<?php echo form_input('vf_name', '', 'class="form-control" placeholder="Function Name" '); ?>
                	</div>
              	</div>
                </div>
                
                <div class="row">
                <div class="form-group">
    				<label for="inputName" class="col-sm-3 control-label"></label>
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
