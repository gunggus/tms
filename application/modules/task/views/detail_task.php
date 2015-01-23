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
        <div class="span8 col-lg-8">
        
		  <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Detail Task</h2>
					<ul class="buttons">
                        <li><a href="#" onClick="source('table_default'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                    </ul>                              
                </div>                
                <?php 
				$parent_id = 0;
				foreach($result as $row){ 
				$parent_id = $row->task_parent_id;
 				?>
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Task </label>
                    <div class="span4 col-sm-4"><?php echo "<b>".strtoupper($row->task_name)."</b>"; ?></div>
					<div class="span4 col-sm-4">
					<?php 
					$current = date("Y-m-d H:i:s");
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
					?>
					</div>
				</div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Status </label>
                    <div class="span6 col-sm-6"><?php echo "<b>".$row->task_status."</b>"; if($row->task_closed == 'yes'){ echo "<b>[CLOSED]</b>";} ?></div>
					<div class="span4 col-sm-4" align="right">
						<?php
							if($user_level > 30){
							echo " &nbsp;&nbsp;";	
							echo '<a href="#assignModal" role="button" class="btn btn-warning" data-toggle="modal" title="assign to" ><span class="ico-pencil"></span></a>';
							?>
							<!-- Bootrstrap modal form assign -->
								<div id="assignModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Reject</h3>
									</div>        
									<?php echo form_open("task/action/reject_request_complete/");?>
									<div class="row-fluid">
										<div class="block-fluid">
											<div class="row-form">
												<div class="span4">Assign To:</div>
												<div class="span8">
													<?php
													$var_assign_selected = $row->task_taken."|".$row->task_taken_by;
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
							<?php		
							}
						?>	
					</div>
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
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_duration; ?></div>
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
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Description </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_description; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span2 col-sm-2 control-label"> Report </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_report; ?></div>
                </div> 
				<?php }	?> 
        	</div>
            <!-- widget content -->
            
            </div>
            <!-- widget -->          
          
            </div>
            <!-- col -->
			<div class="span4 col-lg-4">
          <!-- widget -->
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
            <!-- col -->
		</div>
		<div class="row-fluid">
		<!-- col -->
		  <div class="span5 col-lg-5">
          
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
        	  
		<!-- history status -->	
		<!-- col -->
		<div class="span7 col-lg-7">
          
            <!-- widget -->
            <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Status History</h2>
				</div>                
                <div class="data-fluid" style="width: 100%; overflow-x: scroll;">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Status</th>
                                <th width="40%">Description</th>
                                <th width="10%">Start On</th>
                                <th width="10%">Finish On</th>
                                <th width="10%">Update On</th>
                                <th width="10%">Update By</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
							$no = 0;
							foreach($history as $his){ 
							$no++;
							?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $his->tsh_status;?></td>
								<td><?php echo $his->tsh_report;?></td>
								<td><?php echo $his->tsh_start;?></td>
								<td><?php echo $his->tsh_end;?></td>
								<td><?php echo $his->tsh_update_on;?></td>
								<td><?php echo $his->tsh_update_by;?></td>
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
        <!-- end of history status -->	
        </div>
		
		</div>
        <!-- col -->
		
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
                <!--
				<button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>            
				-->
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