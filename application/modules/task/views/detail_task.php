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
        <div class="row-fluid">
        
		  <div class="span12 col-lg-12">
          <!-- widget -->
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
							echo " &nbsp;&nbsp;";	
							echo "<div class='span3' align='right'>";
							echo form_open("task/action/complete"); echo form_hidden("task_id",$row->task_id);echo form_submit("submit","complete","class='btn btn-success'");echo form_close();
							echo "</div>";
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
                    <div class="span8 col-sm-8"><?php echo "<b>".$row->task_status."</b>"; if($row->task_closed == 'yes'){ echo "<b>[CLOSED]</b>";} ?></div>
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
		</div>
		<div class="row-fluid">
		<!-- col -->
		  <div class="span4 col-lg-4">
          
            <!-- widget -->
            <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Child Task</h2>
					<ul class="buttons">
                    <?php if($parent_id == 0){ echo anchor("task/detail/task/$parent_id","<li>GO TO PARENT TASK <div class='icon'><span class='ico-arrow-up'></span></div></li>");} ?>
                    </ul>                              
                </div>                
                <div class="data-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="25%">No</th>
                                <th width="75%">Task</th>
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
								<td><?php echo $rc->task_name;?></td>
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
		<div class="span8 col-lg-8">
          
            <!-- widget -->
            <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        		<div class="head blue">
                    <h2>Status History</h2>
				</div>                
                <div class="data-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table">
                        <thead>
                            <tr>
                                <th width="20%">No</th>
                                <th width="20%">Status</th>
                                <th width="40%">Description</th>
                                <th width="20%">By</th>
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

</div>
<?php include($this->config->item('footer')); ?>