<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Task History</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">TASK HISTORY</i> </h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
          <div class="block">
            <div class="head purple">
                <div class="icon"><span class="ico-location"></span></div>
                <h2>Task History</h2>     
                <ul class="buttons">
                    <li><a href="#" onClick="source('table_hover'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                </ul>                                                          
            </div>  
            <!-- wigget content -->
            <div class="data-fluid">
								
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
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
								<td>On</td>
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
								<td><?php echo strtoupper($row->tsh_status);?></td>
								<td><?php echo strtoupper($row->tsh_update_by);?></td>
								<td><?php echo strtoupper($row->tsh_update_on);?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
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