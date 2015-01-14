<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Child Task</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ADD CHILD TASK</h4>
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
                    
                  	<?php 
					foreach($parent_task as $row_parent){
					if($row_parent->task_closed == "no"){
					echo form_open('task/action/save_child_task', 'class="form-horizontal"'); 
					echo  form_hidden("task_master_id",$master_id);
					echo  form_hidden("task_parent_id",$parent_id);
					echo  form_hidden("task_point",$row_parent->task_point);
					echo  form_hidden("task_category",$row_parent->task_category);
					echo  form_hidden("task_skill",$row_parent->task_skill);
					echo  form_hidden("task_skill_point",$row_parent->task_skill_point);
					echo  form_hidden("task_point",$row_parent->task_point);
					echo  form_hidden("task_sch_start",$row_parent->task_sch_start);
					echo  form_hidden("task_sch_finish",$row_parent->task_sch_finish);
					
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" value="<?php $row_parent->task_name; ?>" class="form-control" placeholder="Task Name" name="task_name">
                        </div>
						<label for="inputDuration" class="span2 col-sm-2 control-label"> Duration  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_duration",$row_parent->task_sch_duration," id='inputDuration' class='form-control' placeholder='Project Duration in hours' "); ?>
						</div>
                    </div>  
					<!--
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                        <div class="span4 col-sm-4">
							<?php 
							/*
							foreach($list_cat as $lc){
								$vc = $lc->tc_category;
								$var_category[$vc] = $vc;
							}
							echo form_dropdown("task_category",$var_category,$cat);	
							*/
							?>
						</div>
						<label for="inputNama" class="span2 col-sm-2 control-label"> Skill </label>
                        <div class="span4 col-sm-4">
							<?php 
							/* 
							foreach($list_skill as $ls){
								$vs = $ls->skill_level.";".$ls->skill_point;
								$var_skill[$vs] = $ls->skill_level." [".$ls->skill_point."]";
							}
							echo form_dropdown("task_skill",$var_skill);	
							*/
							?>
						</div>
					</div>  
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Scheduled Start On </label>
                        <div class="span4 col-sm-4">
                          <?php //echo form_input("task_sch_start",""," id='inputStart' class='mask_date'"); ?>
						</div>
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Scheduled Finish On </label>
                        <div class="span4 col-sm-4">
                          <?php //echo form_input("task_sch_finish",""," id='inputFinish' class='mask_date'"); ?>
						</div>
                    </div>  
					-->
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("task_description","","class='form-control'"); ?>
						</div>
						<div class="span6 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </div>  
				<?php echo form_close();
					}
					}
				?>                    
                    
        			<?php } ?>
				
				<table cellpadding="0" cellspacing="0" width="100%" class="table table-hover">
                        <thead>
							<tr>
								<td>No</td>
								<td>Category</td>
								<td>Name</td>
								<td>Point</td>
								<td>Start</td>
								<td>Finish</td>
								<td>Duration</td>
								<td>Status</td>
								<td>By</td>
								<td>Action </td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo strtoupper($row->task_category);?></td>
								<td><?php echo strtoupper($row->task_name);?></td>
								<td><?php echo strtoupper($row->task_point);?></td>
								<td><?php echo strtoupper($row->task_sch_start);?></td>
								<td><?php echo strtoupper($row->task_sch_finish);?></td>
								<td><?php echo strtoupper($row->task_sch_duration);?></td>
								<td><?php echo strtoupper($row->task_status);?></td>
								<td><?php echo strtoupper($row->task_update_by);?></td>
								<td><?php 
									echo "<div class='row'>";
									echo "<div class='span8'>";
									echo anchor("task/manage/history/".$row->task_id,"<input type='button' value='history' >","target='_blank'");
									echo "</div>";
									if($row->task_status == "open" OR $row->task_status == "reopen")
									{ 
										echo " &nbsp; &nbsp;";	
										echo "<div class='span8'>";
										echo form_open("task/action/take"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","take");echo form_close();
										echo "</div>";
									}
									echo " &nbsp; &nbsp;";	
									echo "<div class='span8'>";
									echo anchor("task/manage/add/child/".$row->task_id,"<input type='button' value='child' >","target='_blank'");
									echo "</div>";
									echo "</div>";
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				
				
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