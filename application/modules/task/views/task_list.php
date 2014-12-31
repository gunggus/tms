<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Task</h1>
        	<?php echo "<div align='right'>".anchor("task/action/add/","<input type='button' value='add new task' >")."</div>"; ?>
		</div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">TASK LIST</i> </h4>
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
                <h2>Task List</h2>     
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
								<td>Action </td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							?>
							<tr <?php if(($row->task_sch_finish < $current) AND ( $row->task_status != "completed" OR $row->task_status != "closed")){echo "background='#FF0000'";} ?>>
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
									echo " &nbsp; &nbsp;";	
									echo "<div class='span8'>";
									echo anchor("task/manage/history/".$row->task_id,"<input type='button' value='history' >","target='_blank'");
									echo "</div>";
									echo " &nbsp; &nbsp;";	
									echo "<div class='span8'>";
									echo anchor("task/action/add/child/".$row->task_id."/".$row->task_master_id,"<input type='button' value='child' >");
									echo "</div>";
									if($row->task_closed == "no"){
										if($row->task_status == "open" OR $row->task_status == "reopen")
										{ 
											echo " &nbsp; &nbsp;";	
											echo "<div class='span8'>";
											echo form_open("task/action/take"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","take");echo form_close();
											echo "</div>";
										}
										echo " &nbsp; &nbsp;";	
										echo "<div class='span8'>";
										echo form_open("task/action/closed"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","close");echo form_close();
										echo "</div>";
									}else{
										echo " &nbsp; &nbsp;";	
										echo "<div class='span8'>";
										echo form_open("task/action/reopen"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","reopen");echo form_close();
										echo "</div>";
									}
									
									echo "</div>";
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="10"> <?php echo $this->pagination->create_links();?> </td>
							</tr>
						</tfoot>						
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