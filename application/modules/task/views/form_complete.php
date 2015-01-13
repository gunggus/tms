<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Form Complete</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> FORM COMPLETE</h4>
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
                    
                  	<?php echo form_open('task/action/do_complete', 'class="form-horizontal"'); 
					echo  form_hidden("task_id",$task_id);
					foreach($result as $row){
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Task Name" name="task_name" value="<?php echo $row->task_name; ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                        <div class="span4 col-sm-4">
						  <input type="text" class="form-control" placeholder="Task Category" name="task_category" value="<?php echo $row->task_category; ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_point",$row->task_point,"class='form-control' readonly "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Scheduled Start On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_hidden("task_sch_start",$row->task_sch_start," id='inputStart' "); ?>
                          <?php echo form_input("task_sch_start_date",$row->task_sch_start," id='inputStart' class='mask_date' readonly "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_start_time",substr($row->task_sch_start,11)," id='inputStart' readonly "); ?>
						</div>
						<label for="inputStart" class="span2 col-sm-2 control-label"> Actual Start On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_hidden("task_act_start",$row->task_act_start," id='inputStart' "); ?>
                          <?php echo form_input("task_act_start_date",$row->task_act_start," id='inputStart' class='mask_date' readonly "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_start_time",substr($row->task_act_start,11)," id='inputStart' readonly "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Scheduled Finish On </label>
                        <div class="span1 col-sm-2">
                          <?php echo form_hidden("task_sch_finish",$row->task_sch_finish," id='inputFinish' readonly "); ?>
                          <?php echo form_input("task_sch_finish_date",$row->task_sch_finish," id='inputFinish' class='mask_date' readonly "); ?>
						</div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_sch_finish_time",$row->task_sch_finish," id='inputFinish' readonly "); ?>
						</div>
						<label for="inputStart" class="span2 col-sm-2 control-label"> Actual Finish On </label>
                        <div class="span1 col-sm-2">
						  <?php $task_act_finish = mdate("%Y-%m-%d %H:%i:%s",time()); ?>
						  <?php echo form_hidden("task_act_finish",$task_act_finish," id='inputStart' "); ?>
                          <?php echo form_input("task_act_finish_date",$task_act_finish," id='inputStart' class='mask_date' readonly "); ?>
                        </div>
						<div class="span1 col-sm-2">
                          <?php echo form_input("task_act_finish_time",substr($task_act_finish,11)," id='inputStart' readonly "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Scheduled Duration  </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("task_sch_duration",$row->task_sch_duration," id='inputDuration' class='form-control' placeholder='Project Duration in hours' readonly "); ?>
						</div>
						<div class="span1 col-sm-1">
							hours
						</div>
						<label for="inputDuration" class="span2 col-sm-2 control-label"> Actual Duration  </label>
                        <div class="span1 col-sm-1">
						  <?php $task_act_duration = round(((time() - strtotime($row->task_act_start))/3600),0) ;?>	
                          <?php echo form_input("task_act_duration",$task_act_duration," id='inputDuration' class='form-control' placeholder='Project Duration in hours' readonly "); ?>
						</div>
						<div class="span1 col-sm-1">
							hours
						</div>
					</div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span6 col-sm-6">
                          <?php echo form_textarea("task_description",$row->task_description,"class='form-control' readonly"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Report  </label>
                        <div class="span6 col-sm-6">
                          <?php echo form_textarea("task_report",$row->task_report,"class='form-control'"); ?>
						</div>
                    </div>  	
					<div class="row-form">
                        <div class="span8 col-sm-offset-4 col-sm-8">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </div>            
                                            
				<?php 
				}
				echo form_close(); 
				?>                    
                    
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