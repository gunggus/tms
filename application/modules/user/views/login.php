<?php include('wp-content/themes/dbm-bth/modules/wms/template/header.php'); ?>

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
            
            <?php echo form_open('user/login/do_login'); ?>    
                
                <fieldset>
                    <div class="form-group no-margin">
                        <label for="email">Email</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            <input type="email" placeholder="Your Email" class="form-control input-lg" id="email" name="email">
                        </div>

                    </div>

                    
                </fieldset>
               
               <button class="btn btn-warning pull-right" type="submit">Request Pin <i class="m-icon-swapright m-icon-white"></i></button> 
               
               <p>click <?php echo anchor('', 'here'); ?> to login using password</p> 
               
               
                
                   
                	          
				
            
            <? echo form_close(); ?>
            
            </div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

<?php include('wp-content/themes/dbm-bth/modules/wms/html/footer.php'); ?>
 