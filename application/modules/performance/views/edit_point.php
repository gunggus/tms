<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Form Edit Point</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> FORM EDIT POINT</h4>
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
                    
                  	<?php echo form_open('performance/action/do_edit_point', 'class="form-horizontal"'); 
					echo  form_hidden("point_id",$point_id);
					foreach($result as $row){
					?>
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Type </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="Type" name="point_type" value="<?php if($row->point_task_id > 0){echo "TASK";} if($row->point_abs_id > 0){echo "ABSEN";} ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> NIPP </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="nipp" name="point_nipp" value="<?php echo $row->point_nipp; ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Name </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="username" name="point_username" value="<?php echo $row->point_username; ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Date </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="date" name="point_date" value="<?php echo $row->point_date; ?>" readonly>
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Point </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="point" name="point_point" value="<?php echo $row->point_point; ?>" >
                        </div>
                    </div>
  					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Reward </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="reward" name="point_reward" value="<?php echo $row->point_reward; ?>" >
                        </div>
                    </div>					
	  				<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Penalty </label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" placeholder="penalty" name="point_penalty" value="<?php echo $row->point_penalty; ?>" >
                        </div>
                    </div>				
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Description  </label>
                        <div class="span6 col-sm-6">
                          <?php echo form_textarea("point_description",$row->point_description,"class='form-control' "); ?>
						</div>
                    </div>  
					<div class="row-form">
                        <div class="span8 col-sm-offset-4 col-sm-8">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </div>            
                                            
				<?php 
					}
				echo form_close(); 
				?>                    
                    
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