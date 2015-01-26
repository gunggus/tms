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
 				?>
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Task </label>
                    <div class="span8 col-sm-8"><?php echo "<b>".strtoupper($row->task_name)."</b>"; ?></div>
				</div>  
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Status </label>
                    <div class="span6 col-sm-6"><?php echo "<b>".$row->task_status."</b>"; if($row->task_closed == 'yes'){ echo "<b>[CLOSED]</b>";} ?></div>
				</div>
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Duration </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_duration." hour(s)   / ".$row->task_sch_duration_minute." minute(s); ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Target Start </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_start;?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Target Finish </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_sch_finish; ?></div>
                </div>  
				<div class="row-form">
                    <label for="inputNama" class="span4 col-sm-4 control-label"> Desc </label>
                    <div class="span8 col-sm-8"><?php echo $row->task_description; ?></div>
                </div>  
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
			  
			  
		<!-- history status -->	
		<!-- col -->
		<?php /*
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
        */ ?>
		
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
							<input type="hidden" name="assigned_to" value="<?php echo $assigned_name;?>">
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