<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Approve Applyment</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage/applyment', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> Approve Applyment</h4>
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
                    
                  	<?php echo form_open('task/action/approve_applyment', 'class="form-horizontal"'); 
					foreach($result as $row){
					//echo  form_hidden("master_id",$master_id);
					//echo  form_hidden("parent_id",$parent_id);
					echo  form_hidden("task_id",$row->task_id);
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" value='<?php echo $row->task_name; ?>' placeholder="Task Name" name="task_name">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Skill </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" value='<?php echo $row->task_skill; ?>' placeholder="Task Skill" name="task_skill">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Skill Point </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" value='<?php echo $row->task_skill_point; ?>' placeholder="Task Skill Point" name="task_skill_point">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" value='<?php echo $row->task_point; ?>' placeholder="Task Point" name="task_point">
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
							echo form_dropdown("task_category",$var_category,$cat);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Start On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_start",$row->task_sch_start," id='inputStart' class='mask_datetime'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Finish On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_finish",$row->task_sch_finish," id='inputFinish' class='mask_datetime'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Duration  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_duration",$row->task_sch_duration," id='inputDuration' class='form-control' placeholder='Project Duration in hours' "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("task_description",$row->task_description,"class='form-control'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Report  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("task_report",$row->task_report,"class='form-control'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Apply By  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_created_by",$row->task_created_by," id='inputDuration' class='form-control' placeholder='' "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <div class="span6 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Approve</button> 
                        </div>
                    </div>            
                                            
				<?php } echo form_close(); ?>                    
                    
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