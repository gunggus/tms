<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Absen OUT</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ABSEN OUT</h4>
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
                    
                  	<?php echo form_open('task/action/do_absensi/out', 'class="form-horizontal"'); 
					foreach($result as $row){ 
					echo form_hidden('abs_id',$row->abs_id);
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> SHIFT </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='pagi'  placeholder="" name="abs_shift" <?php if($row->abs_shift == 'pagi'){echo "checked";}else{echo " disabled=disabled ";} ?>> PAGI
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='siang'  placeholder="" name="abs_shift" <?php if($row->abs_shift == 'siang'){echo "checked";}else{echo " disabled=disabled ";} ?>> SIANG
                        </div>
                    	<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='malam'  placeholder="" name="abs_shift" <?php if($row->abs_shift == 'malam'){echo "checked";}else{echo " disabled=disabled ";} ?>> MALAM
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> YM </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='off'  placeholder="" name="abs_ym" <?php if($row->abs_ym == 'off'){echo "checked";}else{echo " disabled=disabled ";}  ?>> OFF
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='on'  placeholder="" name="abs_ym" <?php if($row->abs_ym == 'on'){echo "checked";}else{echo " disabled=disabled ";}  ?>> ON
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> SKYPE </label>
                        <div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='off'  placeholder="" name="abs_skype" <?php if($row->abs_skype == 'off'){echo "checked";}else{echo " disabled=disabled ";}  ?>> OFF
                        </div>
						<div class="span1 col-sm-1">
                          <input type="radio" class="form-control" value='on'  placeholder="" name="abs_skype" <?php if($row->abs_skype == 'on'){echo "checked";}else{echo " disabled=disabled ";}  ?>> ON
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa HP Studio </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_hp_std",$row->abs_hp_std,"class='form-control' readonly"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa HP Pandhawa </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_hp_pdw",$row->abs_hp_pdw,"class='form-control' readonly"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Pulsa Listrik </label>
                        <div class="span1 col-sm-1">
                          <?php echo form_input("abs_listrik",$row->abs_listrik,"class='mask_pulsa' readonly"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Plan  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("abs_plan",$row->abs_plan,"class='form-control' readonly"); ?>
						</div>
                    </div>  
						
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Report  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("abs_report",$row->abs_report,"class='form-control'"); ?>
						</div>
                    </div>  
					<?php } ?>
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label">   </label>
                        <div class="span4 col-sm-4">
						<table>
						<tr><td class="span1">No</td><td class="span1">Task</td><td class="span1">Point</td></tr>
						<?php 
						$no = 0;
						$performance = 0;
						foreach($result_task as $row_task){ 
						$no++;
						$performance = $performance + $row_task->task_performance;
						?>
						<tr><td><?php echo $no; ?></td><td><?php echo $row_task->task_name; ?></td><td><?php echo $row_task->task_performance; ?></td></tr>
						<?php } 
						?>
						<tr><td colspan="3"><?php echo "Total Point : $performance".form_hidden('performance',$performance,"readonly");?></td></tr>
						</table>
						</div>
                    </div>  
					<div class="row-form">
                        <div class="span6 col-sm-offset-4 col-sm-6">			
                            <?php if($performance >= $minpoint){ ?>
								<button class="btn btn-primary pull-right" type="submit">Send</button> 
							<?php echo form_close(); 
							}?>                    
                		</div>
                    </div>            
                                            
				    
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