<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Task</h1>
			<?php echo "<div align='right'>".anchor("task/action/add/task","<input type='button' value='add new task' >")."</div>"; ?>
			</h2>
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
        <div class="span8 col-lg-8">
		  <?php $style_all = ""; $style_open = ""; $style_taken = ""; $style_complete = ""; $style_closed = "";$style_mytask = "";?>	
          <?php if($this->uri->segment(3) == 'task'){$style_all = "style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'open'){$style_open = "style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'taken'){$style_taken = "style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'complete'){$style_complete ="style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'closed_task'){$style_closed ="style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'my_task'){$style_mytask ="style='font-weight:bold'";}?>
		  <?php if($this->uri->segment(3) == 'my_complete'){$style_mycomplete ="style='font-weight:bold'";}?>
		  <div class="span2"> <?php echo anchor("task/manage/task","ALL TASK","$style_all"); ?> </div>
          <div class="span2"> <?php echo anchor("task/manage/open","OPEN","$style_open"); ?> </div>
          <div class="span2"> <?php echo anchor("task/manage/taken","PROGRESS","$style_taken"); ?> </div>
          <div class="span2"> <?php echo anchor("task/manage/complete","COMPLETE","$style_complete"); ?> </div>
          <div class="span2"> <?php echo anchor("task/manage/closed_task","CLOSED","$style_closed"); ?> </div>
          <div class="span2"> <?php echo anchor("task/manage/my_task","MY TASK","$style_mytask"); ?> </div>
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
								<td>Task</td>
								<!--
								<td>Unit</td>
								<td>Category</td>
								<td>Skill</td>
								<td>Point</td>
								-->
								<td>Target Start</td>
								<td>Target Finish</td>
								<td>Target Duration <br> (in hours)</td>
								<?php if($this->uri->segment(3) == 'task'){echo "<td>Status</td>";} ?>
								<td>By</td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							if($row->task_status == 'complete'){$bg = " style=' background-color: #CCFFCC' ";}
							else if(($row->task_status != 'complete') AND ($row->task_sch_finish < $current) AND ($row->task_act_finish == "0000-00-00 00:00:00")){$bg=" style=' background-color: #FFFFDD' ";}
							else if(($row->task_status == 'complete') AND ($row->task_sch_finish < $row->task_act_finish)){$bg=" style=' background-color: #FFDDDD' ";}
							else{$bg="";}
							
							?>
							<tr>
								<td <?php echo "$bg";?>><?php echo $i;?></td>
								<td <?php echo "$bg";?>><?php echo anchor("task/detail/task/".$row->task_id,strtoupper($row->task_name));?></td>
								<!--
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_unit);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_category);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_skill);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_point);?></td>
								-->
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_sch_start);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_sch_finish);?></td>
								<td <?php echo "$bg";?>><?php echo number_format($row->task_sch_duration,0,'.',',');?></td>
								<?php if($this->uri->segment(3) == 'task'){?>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_status);?></td>
								<?php } ?>
								<td <?php echo "$bg";?>>
									<?php 
										if($row->task_status == 'open'){echo strtoupper($row->task_created_by);}
										if($row->task_status == 'taken'){echo strtoupper($row->task_taken_by);}
										if($row->task_status == 'complete'){echo strtoupper($row->task_complete_by);}
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="11"> <?php echo $this->pagination->create_links();?> </td>
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
          
		  <!-- announcment -->
		  <div class="span4">
			<div class="span2"></div>
			<div class="block">
                <div class="head blue">
                    <h2>Announcement</h2>
                </div>
                <div class="toolbar">
                    <div class="left">
                        <?php echo form_open("task/manage/my_task/");?>
						<div class="input-append input-prepend">
								<div class="add-on"><span class="icon-search icon-white"></span></div>
                                <input type="text" name="search_announcement" placeholder="Keyword..." id="faqSearchKeyword"/>
                                <button class="btn" id="faqSearch" type="button">Search</button>
                        </div>                            
						<?php echo form_close();?>
                    </div>
					<div class="right tar">
                        <div class="btn-group">
							<?php echo anchor("task/action/add/announcement","ADD"," class='btn btn-success' ");?>
                        </div>
                    </div>
				</div>

                <div class="data-fluid faq" style="height: 555px; overflow-y: scroll;" >
                        <?php
						$no =0;
						foreach($result_announcement as $ra)
						{
							$faq = "faq-".$no++;
						?>
						<div class="item" id="<?php echo $faq;?>">
                            <div class="title"><?php echo $ra->tan_title; ?></div>
                            <div class="text"><p><?php echo $ra->tan_detail; ?></p></div>
                        </div>
						<?php	
							}
						?>
				</div>                    

			</div>
		  </div>
		  <!-- end of announcement -->
		  
		  
        </div>
        <!-- row -->

</div>
<?php include($this->config->item('footer')); ?>