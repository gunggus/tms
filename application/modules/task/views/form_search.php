<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Form Search</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> FORM SEARCH</h4>
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
                    
                  	<?php echo form_open('task/manage/search', 'class="form-horizontal"'); ?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Task Name" name="task_name" >
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                        <div class="span4 col-sm-4">
							<?php 
							$var_category[""]=""; 
							foreach($list_cat as $lc){
								$vc = $lc->tc_category;
								$var_category[$vc] = $vc;
							}
							echo form_dropdown("task_category",$var_category);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Status </label>
                        <div class="span4 col-sm-4">
							<?php 
							$var_status = array(
								""			=>  "",
								"open"		=>	"open",
								"reopen"	=>	"reopen",
								"taken"		=>	"taken",
								"complete"	=>	"complete",
							);	
							echo form_dropdown("task_status",$var_status);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Closed </label>
                        <div class="span4 col-sm-4">
							<?php 
							$var_closed = array(
								""		=>	"",
								"no"	=>	"no",
								"yes"	=>	"yes",
							);	
							echo form_dropdown("task_closed",$var_closed);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_point",''); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Scheduled Start On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_start_date_1",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_start_time_1",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
						<div class="span1 col-sm-2">
							s/d
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_start_date_2",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_start_time_2",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
					</div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Scheduled Finish On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_finish_date_1",""," id='inputFinish' class='mask_date' "); ?>
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_finish_time_1",""," id='inputFinish' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
						<div class="span1 col-sm-2">
							s/d
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_finish_date_2",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_finish_time_2",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
					</div>  
					
					
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Actual Start On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_input("task_act_start_date_1",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_start_time_1",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
						<div class="span1 col-sm-2">
							s/d
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_start_date_2",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_start_time_2",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
					</div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Actual Finish On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_input("task_act_finish_date_1",""," id='inputFinish' class='mask_date' "); ?>
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_finish_time_1",""," id='inputFinish' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
						<div class="span1 col-sm-2">
							s/d
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_finish_date_2",""," id='inputStart' class='mask_date' "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_finish_time_2",""," id='inputStart' class='mask_time' placeholder='hh:mm:ss' "); ?>
						</div>
					</div>  
					
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Scheduled Duration  </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("task_sch_duration_1",""," id='inputDuration' class='form-control' placeholder='Project Duration in minutes' "); ?>
						</div>
						<div class="span1 col-sm-1">
							minutes
						</div>
						<div class="span1 col-sm-1">
						s/d
						</div>
						<div class="span1 col-sm-1">
                          <?php echo form_input("task_sch_duration_2",""," id='inputDuration' class='form-control' placeholder='Project Duration in minutes' "); ?>
						</div>
						<div class="span1 col-sm-1">
							minutes
						</div>
					</div>  
					<div class="row-form">
                    	<label for="inputDuration" class="span2 col-sm-2 control-label"> Actual Duration  </label>
                        <div class="span1 col-sm-1">
						  <?php echo form_input("task_act_duration_1",""," id='inputDuration' class='form-control' placeholder='Project Duration in minutes' "); ?>
						</div>
						<div class="span1 col-sm-1">
							minutes
						</div>
						<div class="span1 col-sm-1">
						s/d	
						</div>
						<div class="span1 col-sm-1">
						  <?php echo form_input("task_act_duration_2",""," id='inputDuration' class='form-control' placeholder='Project Duration in minutes' "); ?>
						</div>
						<div class="span1 col-sm-1">
							minutes
						</div>
					</div>  
					<!--
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span6 col-sm-6">
                          <?php // echo form_textarea("task_description",$row->task_description,"class='form-control' readonly"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Report  </label>
                        <div class="span6 col-sm-6">
                          <?php // echo form_textarea("task_report",$row->task_report,"class='form-control'"); ?>
						</div>
                    </div>
					-->	
					<div class="row-form">
                        <div class="span7 col-sm-offset-4 col-sm-7">			
                            <button class="btn btn-primary pull-right" type="submit">Search</button> 
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