<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Task Message</h1>
        	<?php echo "<div align='right'>".anchor("task/action/add/message/","<input type='button' value='add new message task' >")."</div>"; ?>
		</div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">TASK MASSAGE LIST</i> </h4>
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
                <h2>Message Tasks </h2>     
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
								<td>Task</td>
								<td>Type</td>
								<td>Org</td>
								<td>Category</td>
								<td>Date</td>
								<td>Status</td>
								<td>From</td>
								<td>Closed</td>
								<td>Update By</td>
								<td>Update On</td>
								<td rowspan="2">Action</td>
							</tr>
							<tr>
								<td colspan="5">Description</td>
								<td colspan="5">Report</td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							if($row->tmg_closed == 'yes'){$bg=" style=' background-color: #FFCCCC' ";}else{$bg="";} 							
							?>
							<tr>
								<td rowspan="2" <?php echo $bg;?>><?php echo $i;?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_task);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_type);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_org);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_category);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_date);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_status);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_form);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_closed);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_update_by);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_update_on);?></td>
								<td rowspan="2" <?php echo $bg;?>><?php 
									echo "<div class='row'>";
										if($row->tmg_closed == "yes"){
											echo " &nbsp; &nbsp;";	
											echo "<div class='span8'>";
											echo form_open("task/action/enable_task_message/"); echo form_hidden("tm_id",$row->tm_id);echo form_submit("submit","enable");echo form_close();
											echo "</div>";
										}else{
											echo " &nbsp; &nbsp;";	
											echo "<div class='span8'>";
											echo form_open("task/action/disable_task_message/"); echo form_hidden("tm_id",$row->tm_id);echo form_submit("submit","disable");echo form_close();
											echo "</div>";
										}
									echo "</div>";
									?>
								</td>
							</tr>
							<tr>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_description);?></td>
								<td <?php echo $bg;?>><?php echo strtoupper($row->tmg_report);?></td>
							</tr>	
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="12"> <?php echo $this->pagination->create_links();?> </td>
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