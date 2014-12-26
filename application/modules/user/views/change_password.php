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
          
			<?php if(isset($message) OR validation_errors() ){ ?>
            <div id="dialog-message" title="Message"><p><?php echo $message . validation_errors(); ?></p></div>
			<?php } ?>
            
            <?php echo form_open('user/edit/update_password', 'class="form-horizontal"'); ?>    
  
              <div class="row-form">
                <label for="inputPassword" class="span4 col-sm-4 control-label">New Password</label> 
                <div class="span6 col-sm-6">
                  <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                </div>
              </div>
              
              <div class="row-form">
                <label for="inputPassword" class="span4 col-sm-4 control-label">Type Again</label>
                <div class="span6 col-sm-6">
                  <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password2">
                </div>
              </div>
  
            <div class="row-form">
                <div class="span9 col-sm-offset-2 col-sm-7">			
                    <button class="btn btn-primary pull-right" type="submit">Change Password</button> 
                </div>
            </div>                    
		
            <?php echo form_close(); ?>
               
          
        </div>
        <!-- col -->
          
      </div>
      <!-- row -->
	</div>

<?php include($this->config->item('footer')); ?>
