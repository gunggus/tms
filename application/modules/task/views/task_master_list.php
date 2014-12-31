<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Master Task</h1>
        	<?php echo "<div align='right'>".anchor("task/action/add/master/","<input type='button' value='add new master task' >")."</div>"; ?>
		</div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">TASK MASTER LIST</i> </h4>
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
                <h2>Master Tasks </h2>     
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
								<td rowspan="2">No</td>
								<td rowspan="2">Task</td>
								<td rowspan="2">Point</td>
								<td colspan="4"><div align="center">Every</div></td>
								<td rowspan="2">Run Time</td>
								<td rowspan="2">Duration</td>
								<td rowspan="2">Category</td>
								<td rowspan="2">Description</td>
								<td rowspan="2">Update By</td>
								<td rowspan="2">Update On</td>
								<td rowspan="2">Action</td>
							</tr>
							<tr>
								<td>Year</td>
								<td>Month</td>
								<td>Day</td>
								<td>Hour</td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							if($row->tm_active == 'no'){$bg=" style=' background-color: #FFCCCC' ";}else{$bg="";} 							
							?>
							<tr>
								<td <?php echo $bg;?>><?php echo $i;?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_task);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_point);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_year);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_month);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_day);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_hour);?></td>
								<td <?php echo $bg;?>><?php if($row->tm_run_time == "0000-00-00 00:00:00"){echo strtoupper($row->tm_start_time);}else{echo strtoupper($row->tm_run_time);} ?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_duration);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_category);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_description);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_update_by);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tm_update_on);?></td>
								<td <?php echo $bg;?>><?php 
									echo "<div class='row'>";
										if($row->tm_active == "no"){
											echo " &nbsp; &nbsp;";	
											echo "<div class='span8'>";
											echo form_open("task/action/enable_master/"); echo form_hidden("tm_id",$row->tm_id);echo form_submit("submit","enable");echo form_close();
											echo "</div>";
										}else{
											echo " &nbsp; &nbsp;";	
											echo "<div class='span8'>";
											echo form_open("task/action/disable_master/"); echo form_hidden("tm_id",$row->tm_id);echo form_submit("submit","disable");echo form_close();
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