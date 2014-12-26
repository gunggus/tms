<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Module List</h1>
        </div>
		
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/module', 'ADMIN', 'title="admin area"');?> <i class="fa fa-angle-double-right"></i> MODULE </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
			<table class="table table-bordered table-hover">
                	<tr align="center">
                        <th>ID</th>
                        <th>Module Name</th>
                        <th>Sub Module Name</th>
                        <th>Status</th>
                        <th>Menu Option</th>
                        <th>Action</th>
                	</tr> 
		
				
                	<?php foreach ($query as $key ): ?>  
					<?php $id = $key->vm_id; ?>
					<?php $publish = $key->vm_active; ?>					
                
					<tr>    	
                        <td> <?php echo $key->vm_id; ?> </td>
                        <td> <?php echo $key->vm_name; ?> </td>
                        <td> <?php echo $key->vm_sub_module; ?> </td>
                        <td> <?php if($key->vm_active == 'y'){echo 'active';}else{echo '<p class="text-danger"><del>not active</del></p>';} ?></td>
                        <td> <?php if($key->vm_hide == 'y'){echo '<p class="text-danger"><del>hide</del></p>';}else{echo 'visible';} ?></td>
                        
                        <td>
                        
                        <?php if($key->vm_name <> 'admin'){ ?>
                        
						<?php if($access_level >= 40 ){ ?>
                        
                        <div class="row">
						
						<?php if($key->vm_active == 'y') { ?> 
						<div class="span4 col-lg-4"><?php echo anchor('admin/module/undo_publish_module/' . $id . '/','<i class="fa fa-thumbs-o-down"></i>  change to inactive', 'class="btn btn-primary"'); ?></div>
            			<?php }else{ ?>
            			<div class="span4 col-lg-4"><?php echo anchor('admin/module/publish_module/' . $id . '/','<i class="fa fa-thumbs-o-up"></i>  change to active ', 'class="btn btn-primary"'); ?></div>
            			<?php } ?>
                        
                        <?php if($key->vm_hide == 'y') { ?> 
						<div class="span4 col-lg-4"><?php echo anchor('admin/module/show_module/' . $id . '/','<i class="fa fa-thumbs-o-up"></i> show on menu ', 'class="btn btn-primary"'); ?></div>
            			<?php }else{ ?>
            			<div class="span4 col-lg-4"><?php echo anchor('admin/module/hide_module/' . $id . '/','<i class="fa fa-thumbs-o-down"></i> hide from menu ', 'class="btn btn-primary"'); ?></div>
            			<?php } ?>
                        </div>
                        <?php } ?>
                        <?php } ?>
						</td>
				    </tr>
                	
					<?php endforeach; ?>
                
                </table>
                <?php if($access_level >= 40 ){ ?>
                <div class="col-lg-2"><?php echo anchor('admin/module/add','<i class="fa fa-plus-square"></i>   add new module', 'class="btn "'); ?></div>
                <?php } ?> 
        </div>
    </div>   
<?php include($this->config->item('footer')); ?>
