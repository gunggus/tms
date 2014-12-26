<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Admin Access</h1>
        </div>
		
	<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/module', 'ADMIN', 'title="admin area"');?> <i class="fa fa-angle-double-right"></i> USER </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-12">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> <?php echo $nipp; ?> access list</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            
            	<table class="table table-bordered table-hover">
                	<tr align="center">
                        <th>NIPP</th>
                        <th>Module</th>
                        <th>Sub Module</th>
                        <th>Access Roles</th>
                    
                        <th>Action</th>
                	</tr> 
		
					
                	<?php foreach ($query as $key ): ?>
                    <?php echo form_open('admin/access/save'); ?>                    
                	<?php echo form_hidden('vm_id', $key->vm_id); ?>
                    <?php echo form_hidden('nipp', $nipp); ?>
                    <?php echo form_hidden('vm_name', $key->vm_name); ?>
                    <?php echo form_hidden('vm_sub_module', $key->vm_sub_module); ?>
					<tr>    	
                       
                        <td> <?php echo $nipp; ?> </td>
                        <td> <?php echo $key->vm_name; ?> </td>
                        <td> <?php echo $key->vm_sub_module; ?> </td>
                        <td> 
								<input type="radio" name="<?php echo $key->vm_id; ?>-access" value="0">  guest ( no access )<br />
								<input type="radio" name="<?php echo $key->vm_id; ?>-access" value="10">  user ( read only )<br />
                                <input type="radio" name="<?php echo $key->vm_id; ?>-access" value="20">  management ( read only )<br />
                                <input type="radio" name="<?php echo $key->vm_id; ?>-access" value="30">  operator ( read, input)<br />
                                <input type="radio" name="<?php echo $key->vm_id; ?>-access" value="40">  supervisor ( read, input, edit, delete)<br />
                                <input type="radio" name="<?php echo $key->vm_id; ?>-access" value="50">  admin ( read, input, edit, delete)<br />
                        </td>
                     
                        <td>
                    	<?php echo form_submit('update', 'set access roles to user', 'class="btn btn-primary"'); ?>
						</td>
					</tr>
          			<?php echo form_close(); ?>
                	<?php endforeach; ?>
                	
                </table>
                
                
                
            </div>
      	  </div>
       	</div>
      </div> 
	</div>
       
<?php include($this->config->item('footer')); ?>
