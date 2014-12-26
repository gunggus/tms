<?php include($this->config->item('header')); ?>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-title">Emergency Login</h3>
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
            
            <!--<form method="get" action="http://www.riaxe.com/marketplace/thin-admin/ios7/index.html" class="no-margin">-->
            <?php echo form_open('user/login/do_login'); ?>    
                
                <fieldset>
                    <div class="form-group no-margin">
                        <label for="email">Email</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                            <input type="email" placeholder="Your Email" class="form-control input-lg" id="email">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="icon-lock"></i>
                                </span>
                            <input type="password" placeholder="Your Password" class="form-control input-lg" id="password">
                        </div>

                    </div>
                </fieldset>
               <div class="form-actions">
				
				
				<button class="btn btn-warning pull-right" type="submit">
				Login <i class="m-icon-swapright m-icon-white"></i>
				</button> 
                <div class="forgot"><a href="#" class="forgot">Forgot Username or Password?</a></div>           
			</div>
            
            <? echo form_close(); ?>
           <!-- </form>-->
            
            </div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

<?php include($this->config->item('footer')); ?>
 