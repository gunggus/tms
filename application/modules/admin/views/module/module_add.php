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
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span8">
          
          <!-- widget -->
          <div class="block">
          
          	<!-- wigget content -->
            <div class="data-fluid">
            		<?php if (isset($message)){echo '<p class="text-warning">message : ' . $message . '</p>';} ?>
            		<?php if (validation_errors()){echo '<p>message : ' . validation_errors() . '</p>';} ?>
            	
            		<?php echo form_open('admin/module/add_sub_module'); ?>
                    
				<div class="row-form">
    				<label for="inputName" class="span4 col-sm-4 control-label">Module Name</label>
    				<div class="span4 col-sm-4">
                    <?php $module = directory_map(APPPATH . '/modules/', 1); ?>
                    <select name="mod_name" class="form-control">
					<?php 
					foreach($module as $item){?>
                    	<?php if($item == 'messages'){continue;} else { ?>
                        <option value="<?php echo $item ; ?>"><?php echo $item ; ?></option>
                        <?php } ; ?>
                    <?php }; ?>
                    </select>
					</div>
					<div class="span2 col-sm-2">
                	<?php echo form_submit('submit', 'next', 'class="form-control btn btn-primary pull-right"'); ?>
                	</div>
              	</div>
                
                <?php echo form_close(); ?>
            
            </div>
      	  </div>
       	</div>
      </div> 
    
	</div>   
<?php include($this->config->item('footer')); ?>
