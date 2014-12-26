<?php include($this->config->item('header')); ?>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-title">PIN Login</h3>
        </div>
      </div>
      <!-- row -->
      
      
      
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
            
            <!-- wigget content -->
            <div class="widget-content">
            
            <?php if (isset($message)) { ?><p><?php echo '<p>error message : ' . $message . '</p>';?></p><?php } ?>
            <?php if (validation_errors()) { ?><p><?php echo '<p class="text-warning">error message : ' . validation_errors() . '</p>';?></p><?php } ?>
            
            <?php echo form_open('user/pin_login/pin_do_login'); ?>    
                
                <fieldset>
                    <div class="form-group no-margin">

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            <input type="email" placeholder="Your Email" class="form-control input-lg" id="email" name="email">
                        </div>

                    </div>

                    
                </fieldset>
               
               <button class="btn btn-primary pull-right" type="submit">Request Pin <i class="m-icon-swapright m-icon-white"></i></button> 
               
               <p><?php echo anchor('user/password_login/', 'change to password login', 'class="btn btn-warning"'); ?></p> 
               
               
                
                   
                	          
				
            
            <? echo form_close(); ?>
            
            </div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

<?php include($this->config->item('footer')); ?>
 