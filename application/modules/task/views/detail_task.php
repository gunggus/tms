<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Detail Task</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> DETAIL TASK</h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span4 col-lg-4">
		   <div class="row-fluid">
      
		   <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid"  style="background:#DDFF99;">
        		<div class="head blue">
                    <h2>Detail Task</h2>
					<ul class="buttons">
                        <li><a href="#" onClick="source('table_default'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                    </ul>                              
                </div>                
                <?php 
				$parent_id = 0;
				foreach($result as $row){ 
				$assigned_id = $row->task_taken;
				$assigned_name = $row->task_taken_by;
				$parent_id = $row->task_parent_id;
 				$target_duration_minute = $row->task_sch_duration_minute;
 				$var_point = $row->tc_point;
 				$var_point_duration_minute = 60 * $row->tc_duration;
				?>
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Task </label>
                    <div class="span4 col-sm-4"><?php echo "<b>".strtoupper($row->task_name)."</b>"; ?></div>
					<div class="span4 col-sm-4">
					<?php 
					$current = date("Y-m-d H:i:s");
					/*
					if($row->task_closed == "no"){
						echo " &nbsp;&nbsp;";	
						echo "<div class='span4'>";
						echo form_open("task/action/closed"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit",'close',"class='btn btn-warning'");echo form_close();
						echo "</div>";
						if(($row->task_is_assigned == "yes") AND ($ui_nama == $row->task_taken_by)){
							echo " &nbsp;&nbsp;";	
							echo "<div class='span3' align='right'>";
							echo "<a href='#ModalApprove' role='button' data-toggle='modal' class='btn'>approve</a>";
							echo "</div>";
							echo "<div class='span3' align='right'>";
							echo "<a href='#ModalReject' role='button' data-toggle='modal' class='btn btn-warning'>reject</a>";
							echo "</div>";
						}else{
							if(($row->task_status == "open" OR $row->task_status == "reopen") AND ($row->task_sch_start < $current) AND ($row->task_is_child == 'yes'))
							{ 
								if($stuck_task > 2){
									echo " &nbsp;&nbsp;";	
									echo "<div class='span2' align='right'>";
									echo '<a href="#bModal" role="button" class="btn" data-toggle="modal">take</a>';
									echo '<!-- Bootrstrap modal -->
											<div align="center" id="bModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h3 id="myModalLabel">Warning</h3>
												</div>
												<div class="modal-body">
													<p>You can not take on this task <br/> <b>Please Complete your Previous Task</b> </p>
												</div>
												<div class="modal-footer">
													'.anchor('task/manage/my_task','Go','class="btn btn-warning" aria-hidden="true"').'
													<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
												</div>
											</div>               
										';
									echo "</div>";
								}else{
									echo " &nbsp;&nbsp;";	
									echo "<div class='span2' align='right'>";
									echo form_open("task/action/take"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","take","class='btn'");echo form_close();
									echo "</div>";
								}
							}
							if($row->task_status == "taken" AND $row->task_is_approve == "yes" AND $row->task_taken_by == $ui_nama  )
							{	
								if($row->task_request_complete == "no"){
									echo " &nbsp;&nbsp;";	
									echo "<div class='span3' align='right'>";
									echo form_open("task/action/request_complete"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","request complete","class='btn btn-success'");echo form_close();
									echo "</div>";
								}else{
									if($user_level > 30){
										echo " &nbsp;&nbsp;";	
										echo "<div class='span3' align='right'>";
										echo form_open("task/action/approve_request_complete"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","approve"," title='accept request complete' class='btn btn-success'");echo form_close();
										echo "</div>";
										echo " &nbsp;&nbsp;";	
										echo "<div class='span3' align='right'>";
									//	echo form_open("task/action/reject_request_complete"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","reject"," title='reject request complete' class='btn btn-warning'");echo form_close();
										echo '<a href="#rejectreqModal" role="button" class="btn btn-warning" data-toggle="modal" title="reject request" >reject</a>';
										echo "</div>";
									}
								}
							}
						}
					}else{
							echo " &nbsp;&nbsp;";	
							echo "<div class='span3' align='right'>";
							echo form_open("task/action/reopen"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","reopen","class='btn btn-info'");echo form_close();
							echo "</div>";
					}
					*/
					?>
					</div>
				</div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Status </label>
                    <div class="span4 col-sm-4"><?php echo "<b>".$row->task_status."</b>";if($row->task_closed == 'yes'){ echo "<b>[CLOSED]</b>";}  ?></div>
					<?php
					$current = mdate("%Y-%m-%d %H:%i:%s");
					if(($row->task_status == "open" OR $row->task_status == "reopen") AND ($row->task_sch_start < $current) )
							{ 
								if($stuck_task > 2){
									echo " &nbsp;&nbsp;";	
									echo "<div class='span6' align='right'>";
									echo '<a href="#bModal" role="button" class="btn" data-toggle="modal">take</a>';
									echo '<!-- Bootrstrap modal -->
											<div align="center" id="bModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h3 id="myModalLabel">Warning</h3>
												</div>
												<div class="modal-body">
													<p>You can not take on this task <br/> <b>Please Complete your Previous Task</b> </p>
												</div>
												<div class="modal-footer">
													'.anchor('task/manage/my_task','Go','class="btn btn-warning" aria-hidden="true"').'
													<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>            
												</div>
											</div>               
										';
									echo "</div>";
								}else{
									echo " &nbsp;&nbsp;";	
									echo "<div class='span6' align='right'>";
									echo form_open("task/action/take"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","take","class='btn'");echo form_close();
									echo "</div>";
								}
							}
							
					?>
				</div>
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_category; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Skill </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_skill; ?></div>
                </div>
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Point </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_point; ?></div>
                </div>
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Duration </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_duration." hour(s)  / ".$row->task_sch_duration_minute." minute(s) "; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Schedule </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_start." - ".$row->task_sch_finish; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Actual </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_act_start." - ".$row->task_act_finish; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Desc </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_description; ?></div>
                </div>  
				<!--
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Report </label>
                    <div class="span8 col-sm-8"><?php //echo $row->task_report; ?></div>
                </div> 
				-->
				<?php }	?> 
        	</div>
            <!-- widget content -->
            
            </div>
            <!-- widget -->          
			</div>
			
			
			<!-- Discussion -->
			<div class="row-fluid" style="background:#FAED9B;">
			  <div class="block">
            
				<!-- wigget content -->
				<div class="data-fluid">
					<div class="head blue">
						<h2>Discussion</h2>
						<ul class="buttons">
							<li><a href="#" onClick="source('table_default'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
						</ul>                              
					</div>                
					<div class="data dark npr npb">
						<div class="messages scroll" style="height: 555px; overflow-y: scroll;">	
						<?php 
							foreach($discussion as $dis){ 
							if($dis->td_update_by == $ui_nama){$class = "item blue";}
							else{$class = "item dblue out";}
						?>
							<div class="<?php echo $class; ?>">
								<div class="arrow"></div>
								<div class="text">
								<?php 
									echo $dis->td_text; 
									echo "<br/>";
									if($dis->td_attach == "yes"){echo anchor("task/detail/attachment/".$dis->td_id,"attachment");} 
								?>
								</div>
								<div class="date"><?php echo $dis->td_update_by."  ".$dis->td_update_on; ?></div>
							</div>
						<?php } ?>
						</div>
					</div>    
					<div class="toolbar dark">
						<?php echo form_open_multipart("task/detail/discussion/$task_id");?>
						<div>
							<input type="file" name="file" />                              
						</div>					
						<div class="input-prepend input-append">
							<span class="add-on dblue"><span class="icon-envelope icon-white"></span></span>
							<input class="span9" type="text" name="text" />                              
							<button class="btn dblue" type="submit">Send  <span class="icon-arrow-next icon-white"></span></button>
						</div>
						<?php echo form_close();?>	
					</div>
				</div>
				<!-- widget content -->
				
				</div>
				<!-- widget -->          
			</div>
			<!-- End of  Discussion-->
			
		</div>
		
		<!-- col -->
		<div class="span8 col-lg-8">
        
		<!-- report -->	
		<div class="row-fluid">
          
            <!-- widget -->
            <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Report</h2>
					<div align="right">
						<a href='#ModalReport' role='button' data-toggle='modal' class="btn"><span class="ico-reply-2"> Reporting</span></a>
                    </div>
				</div>                
                <div class="data-fluid" style="width: 100%; overflow-x: scroll;">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th rowspan="2" width="5%">No</th>
                                <th rowspan="2" width="10%">Assigned</th>
                                <th rowspan="2" width="10%">Detail</th>
                                <th rowspan="2" width="10%">Start On</th>
                                <th rowspan="2" width="10%">Finish On</th>
                                <th rowspan="2" width="10%">Duration</th>
                                <th colspan="4" width="10%"><div align="center">Status</div></th>
                            </tr>
							<tr>
								<th>Assignment</th>
								<th>Progress</th>
								<th>Controlling</th>
								<th>Result</th>
							</tr>
                        </thead>
                        <tbody>
							<?php 
							$no = 0;
							$point = 0;
							$reward = 0;
							$penalty = 0;
							$task_report_duration = 0;
							$progress_status = "open";
							foreach($report as $rep){ 
							$no++;
							$task_report_duration = $task_report_duration + $rep->tr_duration; 
							$progress_status = $rep->tr_progress_status;
							?>
						    <tr>
                                <td><?php echo $no; ?></td>
                            	<td><?php echo $rep->tr_assignment_status; ?></td>
								<td><?php echo $rep->tr_progress_status; ?></td>
								<td><?php echo $rep->tr_controlling_status; ?></td>
								<td><?php echo $rep->tr_result_status; ?></td>
							    <td><?php 
									echo $rep->tr_detail."<br/><br/>";
									if($rep->tr_response != ""){ 
										echo "Response:<br/>";
										echo $rep->tr_response;
									}	
									?>
								</td>
                                <td><?php echo mdate("%d-%m-%Y %H:%i:%s",strtotime($rep->tr_start_on)); ?></td>
                                <td><?php echo mdate("%d-%m-%Y %H:%i:%s",strtotime($rep->tr_finish_on)); ?></td>
                                <td><?php echo $rep->tr_duration." min"; ?></td>
                                <td><?php echo $rep->tr_assigned_by; ?></td>
							</tr>
							
							<?php 
							}
							if($target_duration_minute > 0 AND $var_point_duration_minute > 0){ 
								$point = $var_point * ($target_duration_minute / $var_point_duration_minute);
								if($task_report_duration < $target_duration_minute){$reward = (($target_duration_minute - $task_report_duration ) / $var_point_duration_minute) * $var_point;}
								if($task_report_duration > $target_duration_minute){$penalty = (($task_report_duration - $target_duration_minute ) / $var_point_duration_minute) * $var_point;}
							}
							
							?>
						</tbody>
						<tfoot>
							<tr>
							<?php
								if($user_level > 30){
									echo "<td colspan='4'>";	
									echo '<a href="#assignModal" role="button" class="btn btn-warning" data-toggle="modal" title="assign to" ><span class="ico-pencil"> assign</span></a>';
									echo "</td>";
								}	
							?>
								<td colspan="4">
									<div align="right">
										<a href="#requestcompleteModal" role="button" class="btn btn-info" data-toggle="modal" title="request complete" ><span class="ico-files"> request complete</span></a>
									</div>
								</td>
								<td colspan="2">
									<?php 
									if(($user_level > 30) AND ($assigned_name != $ui_nama)){
									if($progress_status == "request complete"){ 
									?>
									<a href="#confirmreportModal" role="button" class="btn" data-toggle="modal" title="confirm" >Confirm Request</a>
									<!-- Bootrstrap modal form request_complete -->
									<div id="confirmreportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Confirm Request</h3>
									</div>        
									<?php 
										echo form_open("task/action/approve_request_complete");
										echo form_hidden("task_id",$task_id);
										echo form_hidden("point",$point);
										echo form_hidden("reward",$reward);
										echo form_hidden("penalty",$penalty);
										echo form_hidden("assigned",$assigned_id);
										echo form_hidden("assigned_by",$assigned_name); 
										echo form_hidden("task_target_duration",$target_duration_minute); 
										echo form_hidden("task_report_duration",$task_report_duration); 
										
									?>
									<div class="row-fluid">
										<div class="block-fluid">
											<div class="row-form"><div class="span2">Current Point</div><div class="span8"><?php echo $point+$reward-$penalty;?></div></div>
											<div class="row-form"><div class="span2">Additional Reward</div><div class="span8"><?php echo form_input("add_reward","","title='additional reward point' placeholder='add reward point' ");?></div></div>										
											<div class="row-form"><div class="span2">Comment</div><div class="span8"><?php echo form_textarea("response");?></div></div>
										</div>
									</div>                   
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary" >Confirm</button> 
									</div>
									<?php echo form_close();?>
									</div>
									<!-- End Of Request Complete Modal -->
									<?php 
									}
									if($progress_status == "complete")
									{
									?>
									<a href="#unconfirmreportModal" role="button" class="btn btn-warning" data-toggle="modal" title="reject" >reject</a>
									<!-- Bootrstrap modal form request_complete -->
									<div id="unconfirmreportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Point Result</h3>
									</div>        
									<?php 
										echo form_open("task/action/request_complete");
										echo form_hidden("task_id",$task_id);
										echo form_hidden("point",$point);
										echo form_hidden("reward",$reward);
										echo form_hidden("penalty",$penalty);
										echo form_hidden("assigned",$assigned_id);
										echo form_hidden("assigned_by",$assigned_name); 
									?>
									<div class="row-fluid">
										<div class="block-fluid">
											<div class="row-form"><div class="span2">Point</div><div class="span8"><?php echo "$point";?></div></div>
											<div class="row-form"><div class="span2">Reward</div><div class="span8"><?php echo "$reward";?></div></div>										
											<div class="row-form"><div class="span2">Penalty</div><div class="span8"><?php echo "$penalty";?></div></div>										
											<div class="row-form"><div class="span2"><b>Total</b></div><div class="span8"><?php $totpoint = $point + $reward - $penalty; echo "<b>".$totpoint."</b>";?></div></div>										
										</div>
									</div>                   
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary" >Send</button> 
									</div>
									<?php echo form_close();?>
									</div>
									<!-- End Of Request Complete Modal -->
									<?php 
										}
									}
									?>
								</td>
							</tr>
								<!-- Bootrstrap modal form assign -->
								<div id="assignModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel">Assign</h3>
								</div>        
								<?php echo form_open("task/action/assign_task/");?>
								<div class="row-fluid">
									<div class="block-fluid">
										<div class="row-form">
											<div class="span4">Assign To:</div>
											<div class="span8">
											<?php
												echo form_hidden("task_id",$task_id);
												$var_assign_selected = $assigned_id."|".$assigned_name;
												$var_ru[""] = "";
												foreach($related_user as $ru){
													$varru = $ru->ui_id."|".$this->encrypt->decode($ru->ui_nama);
													$var_ru[$varru] = $this->encrypt->decode($ru->ui_nama)." [".$ru->ui_nipp."]";
												}
												echo form_dropdown("assign",$var_ru,$var_assign_selected);
											?>
											</div>
										</div>       
									</div>
								</div>                   
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" >Set</button> 
								</div>
								<?php echo form_close();?>
								</div>
								<!-- End of assign modal -->
								
								<!-- Bootrstrap modal form request_complete -->
								<div id="requestcompleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel">Point Result</h3>
								</div>        
								<?php 
									echo form_open("task/action/request_complete");
									echo form_hidden("task_id",$task_id);
									echo form_hidden("point",$point);
									echo form_hidden("reward",$reward);
									echo form_hidden("penalty",$penalty);
									echo form_hidden("assigned",$assigned_id);
									echo form_hidden("assigned_by",$assigned_name); 
								?>
								<div class="row-fluid">
									<div class="block-fluid">
										<div class="row-form"><div class="span2">Point</div><div class="span8"><?php echo "$point";?></div></div>
										<div class="row-form"><div class="span2">Reward</div><div class="span8"><?php echo "$reward";?></div></div>										
										<div class="row-form"><div class="span2">Penalty</div><div class="span8"><?php echo "$penalty";?></div></div>										
										<div class="row-form"><div class="span2"><b>Total</b></div><div class="span8"><?php $totpoint = $point + $reward - $penalty; echo "<b>".$totpoint."</b>";?></div></div>										
									</div>
								</div>                   
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" >Send</button> 
								</div>
								<?php echo form_close();?>
								</div>
								<!-- End Of Request Complete Modal -->
									
						</tfoot>
                    </table>
                </div>                 
        	</div>
            <!-- widget content -->
            
            </div>
            <!-- widget -->          
          
        </div>
        <!-- col -->
        <!-- end of report -->	
        
		<!-- child task -->
		<div class="row-fluid">
		    <!-- widget -->
            <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Child Task</h2>
					<ul class="buttons">
                    <?php if($parent_id > 0){ echo anchor("task/detail/task/$parent_id","<li>GO TO PARENT TASK <div class='icon'><span class='ico-arrow-up'></span></div></li>");} ?>
                    </ul>
				</div>                
                
				<div class="head blue" align='right'>
                	<?php echo anchor("task/action/add/child/$task_id","ADD CHILD"," class='btn btn-default' ");?>	
                </div>
				<div class="data-fluid" style="width: 100%; overflow-x: scroll;">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th width="15%">Task</th>
                                <th width="25%">Detail</th>
                                <th width="10%">Status</th>
                                <th width="10%">Assign</th>
                                <th width="10%">Point</th>
                                <th width="10%">Start </th>
                                <th width="10%">Finish</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
							$no = 0;
							foreach($child as $rc){ 
							$no++;
							?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo anchor("task/detail/task/".$rc->task_id,$rc->task_name);?></td>
								<td><?php echo $rc->task_description;?></td>
								<td><?php echo $rc->task_status;?></td>
								<td><?php echo $rc->task_taken_by;?></td>
								<td><?php echo $rc->task_point;?></td>
								<td><?php echo $rc->task_sch_start;?></td>
								<td><?php echo $rc->task_sch_finish;?></td>
							</tr>
							<?php } ?>
						</tbody>
                    </table>
                </div>                 
        	</div>
            <!-- widget content -->
            
            </div>
            <!-- widget -->          
          
        </div>
        <!-- col -->
        <!-- end of child task -->
			  
		</div>
		
		</div>
        <!-- col -->
		
		<!-- Bootrstrap reporting modal -->
        <div id="ModalReport" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <?php echo form_open("task/action/report/");?>
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Reporting</h3>
            </div>        
            <div class="row-fluid">
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span2">
							<input type="hidden" name="task_id" value="<?php echo $task_id;?>">
							<input type="hidden" name="assigned" value="<?php echo $assigned_id;?>">
							<input type="hidden" name="assigned_by" value="<?php echo $assigned_name;?>">
							<span class="top title">Start On:</span>
                        </div>
						<div class="span10">
						    <input type="text" name="rep_start" class="mask_datetime">
                        </div>
                    </div>
					<div class="row-form">
                        <div class="span2">
							<span class="top title">Finish On:</span>
                        </div>
						<div class="span10">
						    <input type="text" name="rep_finish" class="mask_datetime">
                        </div>
                    </div>
					<div class="row-form">
                        <div class="span2">
							<span class="top title" name="rep_detail">Detail:</span>
                        </div>
						<div class="span10">
						    <textarea name="detail"></textarea>
                        </div>
                    </div>	
                </div>
            </div>                   
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Send</button> 
            </div>
			<?php echo form_close();?>
        </div>      
		<!-- End of modal reporting -->
        
		<!-- Bootrstrap modal -->
        <div id="ModalApprove" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Accept Task</h3>
            </div>
            <?php echo form_open("task/action/approve_assign/");?>
			<div class="modal-body">
				<p>Are you sure ?</p>
			</div>
            <div class="modal-footer">
               	<input type="hidden" name="task_id" value="<?php echo $task_id;?>">
				<button type="submit" class="btn btn-warning" >Confirm</button> 
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>            
            </div>
			<?php echo form_close();?>
        </div>                        
		
		<!-- Bootrstrap modal form -->
        <div id="ModalReject" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Reject</h3>
            </div>        
            <?php echo form_open("task/action/reject_assign/");?>
			<div class="row-fluid">
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span12">
							<input type="hidden" name="task_id" value="<?php echo $task_id;?>">
							<span class="top title">Reason:</span>
                            <textarea name="reason"></textarea>
                        </div>
                    </div>       
                </div>
            </div>                   
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Send</button> 
            </div>
			<?php echo form_close();?>
        </div>      
		
		<!-- Bootrstrap modal form Reject request complete -->
        <div id="rejectreqModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Reject</h3>
            </div>        
            <?php echo form_open("task/action/reject_request_complete/");?>
			<div class="modal-body">
				<p>Are you sure ?</p>
			</div>
            <div class="modal-footer">
               	<input type="hidden" name="task_id" value="<?php echo $task_id;?>">
				<button type="submit" class="btn btn-warning" >Confirm</button> 
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>            
            </div>
           <?php echo form_close();?>
        </div>      
		
		
	</div>

</div>
<?php include($this->config->item('footer')); ?>