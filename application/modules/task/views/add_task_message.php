<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Task Message</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ADD TASK MESSAGE </h4>
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
                    
                  	<?php echo form_open('task/action/save_task', 'class="form-horizontal"'); 
					echo  form_hidden("task_message_id",$task_message_id);
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Task Name" name="tmg_name">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Organization </label>
                        <div class="span4 col-sm-4">
							<?php 
							$var_org = array("studiokami" => "STUDIOKAMI" , "pandhawa" => "PANDHAWA");
							echo form_dropdown("tmg_org",$var_org);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Type </label>
                        <div class="span4 col-sm-4">
							<?php 
							$var_type = array("ym" => "YM" , "skype" => "SKYPE", "phone"=>"PHONE", "email"=>"EMAIL");
							echo form_dropdown("tmg_type",$var_type);	
							?>
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
							echo form_dropdown("tmg_category",$var_category);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Date </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("tmg_date",""," id='inputStart' class='mask_date'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDescription" class="span2 col-sm-2 control-label"> Description </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("tmg_description",""," id='inputDescription' "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputReport" class="span2 col-sm-2 control-label"> Report </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("tmg_report",""," id='inputReport' "); ?>
						</div>
                    </div>  
					
					
					
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Scheduled Start On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_start",""," id='inputStart' class='mask_date'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Scheduled Finish On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_finish",""," id='inputFinish' class='mask_date'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Duration  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_duration",""," id='inputDuration' class='form-control' placeholder='Project Duration in minutes' "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("task_description","","class='form-control'"); ?>
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