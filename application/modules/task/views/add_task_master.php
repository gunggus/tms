<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Master Task</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ADD MASTER TASK</h4>
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
                    
                  	<?php echo form_open('task/action/save_master_task', 'class="form-horizontal"'); ?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Task Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Task Name" name="tm_task">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Repeated Every </label>
                        <div class="span4 col-sm-4">
							<div class="row-form">
								<div class="span2" ><input type="text"  name="tm_year"></div>
								<div class="span1" > year</div>
							</div>		
							<div class="row-form">
								<div class="span2" ><input type="text"  name="tm_month"></div>
								<div class="span1" > month</div>
							</div>		
							<div class="row-form">
								<div class="span2" ><input type="text"  name="tm_day"></div>
								<div class="span1" > day</div>
							</div>		
							<div class="row-form">
								<div class="span2" ><input type="text"  name="tm_hour"></div>
								<div class="span1" > hour</div>
							</div>		
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Start Time </label>
                        <div class="span1 col-sm-2">
                          <input type="text" class="mask_date" placeholder="yyyy-mm-dd" name="tm_start_time" value="<?php echo mdate("%Y-%m-%d",time());?>">
                        </div>
						<div class="span4 col-sm-2">
							<input type="text" class="span1" placeholder="hh" name="tm_start_hour" value="<?php echo mdate("%H",time());?>">:
							<input type="text" class="span1" placeholder="mm" name="tm_start_minute" value="<?php echo mdate("%i",time());?>">:
							<input type="text" class="span1" placeholder="ss" name="tm_start_second" value="<?php echo "00";?>">
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                        <div class="span4 col-sm-4">
							<?php 
							foreach($list_cat as $lc){
								$vc = $lc->tc_category;
								$var_category[$vc] = $vc;
							}
							echo form_dropdown("tm_category",$var_category,$cat);	
							?>
						</div>
                    </div> 
					<div class="row-form">
                    	<label for="inputNama" class="span2 col-sm-2 control-label"> Skill </label>
                        <div class="span4 col-sm-4">
							<?php 
							foreach($list_skill as $ls){
								$vs = $ls->skill_level.";".$ls->skill_point;
								$var_skill[$vs] = $ls->skill_level." [".$ls->skill_point."]";
							}
							echo form_dropdown("task_skill",$var_skill);	
							?>
						</div>
					</div>
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("tm_point","","class='form-control'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Duration </label>
                        <div class="span1" ><?php echo form_input("tm_duration",""); ?></div>
						<div class="span1" > hours</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("tm_description","","class='form-control'"); ?>
						</div>
                    </div>  
						
					<div class="row-form">
                        <div class="span6 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
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