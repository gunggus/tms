<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Absen IN</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ABSEN IN</h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
          <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        			 
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
                    
                  	<?php echo form_open('task/action/do_absensi/in', 'class="form-horizontal"'); 
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> SHIFT </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='pagi'  placeholder="" name="abs_shift"> PAGI
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='siang'  placeholder="" name="abs_shift"> SIANG
                        </div>
                    	<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='malam'  placeholder="" name="abs_shift"> MALAM
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> YM </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='off'  placeholder="" name="abs_ym"> OFF
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='on'  placeholder="" name="abs_ym" checked> ON
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> SKYPE </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='off'  placeholder="" name="abs_skype"> OFF
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='on'  placeholder="" name="abs_skype" checked> ON
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa HP Studio </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_hp_std","","class='form-control'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa HP Pandhawa </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_hp_pdw","","class='form-control'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa Listrik </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_listrik","","class='mask_pulsa'"); ?>
						</div>
                    </div>  
					
					
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Plan  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("abs_plan","","class='form-control'"); ?>
						</div>
                    </div>  
						
					<div class="row-form">
                        <div class="span6 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Send</button> 
                        </div>
                    </div>            
                                            
				<?php echo form_close(); ?>                    
                    
        			<?php } ?>
        
 			</div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

</div>
<?php include($this->config->item('footer')); ?>