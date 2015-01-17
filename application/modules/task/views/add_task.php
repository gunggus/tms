<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Task</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ADD TASK</h4>
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
                    
                  	<?php echo form_open('task/action/save_task', 'class="form-horizontal"'); 
					echo  form_hidden("master_id",$master_id);
					echo  form_hidden("parent_id",$parent_id);
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Task Name" name="task_name">
                        </div>
                    </div>
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Unit </label>
                        <div class="span4 col-sm-4">
							<select name="task_unit" id="unit" class="form-control">
								<option value="">select unit</option>
								<?php foreach($list_unit as $lu){ ?>
								<option value="<?php echo $lu->vu_name; ?>"><?php echo strtoupper( $lu->vu_name ) ?></option>
								<?php } ?>
							</select>
						</div>
                    </div>
					
					<div class="row-form">
						<label for="inputUnit" class="span2 col-sm-2 control-label">Category</label>
						<div class="span4 col-sm-6">
							<select  name="task_category" id="category" class="form-control">
								<option value="">select category</option>
							</select>
						</div>
					</div>
	  
					<!--
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Category </label>
                        <div class="span4 col-sm-4">
							<?php 
							foreach($list_cat as $lc){
								$vc = $lc->tc_category;
								$var_category[$vc] = strtoupper($vc);
							}
							echo form_dropdown("task_category",$var_category,$cat);	
							?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Skill </label>
                        <div class="span4 col-sm-4">
							<?php 
							foreach($list_skill as $ls){
								$vs = $ls->skill_level.";".$ls->skill_point;
								$var_skill[$vs] = $ls->skill_level." [".$ls->skill_point."]";
							}
							echo form_dropdown("task_skill",$var_skill);	
							?>
						</div>
                    </div>
					-->	
					<!--
					<div class="row-form">
                        <label for="inputPoint" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <?php //echo form_input("task_point","","class='form-control'"); ?>
						</div>
                    </div>
					-->	
					<div class="row-form">
                        <label for="inputStart" class="span2 col-sm-2 control-label"> Scheduled Start On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_start",""," id='inputStart' class='mask_datetime'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputFinish" class="span2 col-sm-2 control-label"> Scheduled Finish On </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_finish",""," id='inputFinish' class='mask_datetime'"); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <label for="inputDuration" class="span2 col-sm-2 control-label"> Duration  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_input("task_sch_duration",""," id='inputDuration' class='form-control' placeholder='Project Duration in hours' "); ?>
						</div>
                    </div>
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span4 col-sm-4">
                          <?php echo form_textarea("task_description","","class='form-control'"); ?>
						</div>
                    </div>  
						
					<div class="row-form">
                        <div class="span6 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </div>            
                                            
				<?php echo form_close(); ?>                    
                    
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

<script type="text/javascript">
	
	$(document).ready(function(){
	
		/* pengaturan id select dropdown */
		$_unit			= $('select#unit');
		$_category		= $('select#category');
		
		$_unit.change(function(){
		$this = $(this);

			$.get( '<?php echo base_url() ?>task/ajax_controller/category_task/' + $this.val(), function(data){
			$_category.html( data ? data : '<option value=""></option>' );
				
			});
			
		});
		
		
		return false;
	
	});
	
</script>