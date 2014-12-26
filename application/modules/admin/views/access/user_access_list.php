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
                        <th>Start</th>
                        <th>End</th>
                        <th>Action</th>
                	</tr> 
		
					
                	<?php foreach ($query as $key ): ?>                    
                	<?php echo form_open('admin/access/update'); ?>
					<?php echo form_hidden('ua_id', $key->ua_id); ?>
                    <?php echo form_hidden('ua_vm_id', $key->ua_vm_id); ?>
                    <?php echo form_hidden('ua_nipp', $nipp); ?>
                    <?php echo form_hidden('ua_module', $key->ua_module); ?>
                    <?php echo form_hidden('ua_sub_module', $key->ua_sub_module); ?>
					<tr>    	
                       
                        <td> <?php echo $nipp; ?> </td>
                        <td> <?php echo $key->ua_module; ?> </td>
                        <td> <?php echo $key->ua_sub_module; ?> </td>
                        <td> 
								<select class="form-control" name="roles">
								<?php $current_roles = $key->ua_roles; ?> 
								<?php if($current_roles == 0){ ?>
								  <option value="0" selected="selected">guest (no access)</option>
                                  <option value="10">user (read only)</option>
                                  <option value="20">management (read only)</option>
                                  <option value="30">operator (read/add)</option>
                                  <option value="40">supervisor (read/add/edit/del)</option>
                                  <option value="50">admin (read/add/edit/del)</option>
								<?php }elseif($current_roles == 10){ ?>
								 <option value="0">guest (no access)</option>
                                  <option value="10" selected="selected">user (read only)</option>
                                  <option value="20">management (read only)</option>
                                  <option value="30">operator (read/add)</option>
                                  <option value="40">supervisor (read/add/edit/del)</option>
                                  <option value="50">admin (read/add/edit/del)</option>
                                <?php }elseif($current_roles == 20){ ?>
								 <option value="0">guest (no access)</option>
                                  <option value="10">user (read only)</option>
                                  <option value="20" selected="selected">management (read only)</option>
                                  <option value="30">operator (read/add)</option>
                                  <option value="40">supervisor (read/add/edit/del)</option>
                                  <option value="50">admin (read/add/edit/del)</option>
                                  <?php }elseif($current_roles == 30){ ?>
								 <option value="0">guest (no access)</option>
                                  <option value="10">user (read only)</option>
                                  <option value="20">management (read only)</option>
                                  <option value="30"  selected="selected">operator (read/add)</option>
                                  <option value="40">supervisor (read/add/edit/del)</option>
                                  <option value="50">admin (read/add/edit/del)</option>
                                  <?php }elseif($current_roles == 40){ ?>
								 <option value="0">guest (no access)</option>
                                  <option value="10">user (read only)</option>
                                  <option value="20">management (read only)</option>
                                  <option value="30">operator (read/add)</option>
                                  <option value="40"  selected="selected">supervisor (read/add/edit/del)</option>
                                  <option value="50">admin (read/add/edit/del)</option>
                                  <?php }elseif($current_roles == 50){ ?>
								 <option value="0">guest (no access)</option>
                                  <option value="10">user (read only)</option>
                                  <option value="20">management (read only)</option>
                                  <option value="30">operator (read/add)</option>
                                  <option value="40">supervisor (read/add/edit/del)</option>
                                  <option value="50"  selected="selected">admin (read/add/edit/del)</option>
								<?php } ?>
                                
                                 
                                </select>
                        </td>
                        <td> <?php echo $key->ua_start; ?> </td>
                        <td> <?php echo $key->ua_end; ?> </td>
                        <td>
                    	<?php if($access_level >= 0 ){ ?><?php echo form_submit('update', 'update access roles', 'class="btn btn-primary"'); ?><?php } ?>
						</td>
					</tr>
          			<?php echo form_close(); ?>
                	<?php endforeach; ?>
                	
                </table>
                
                <?php if($access_level >= 40 ){ ?><div class="col-lg-2"><?php echo anchor('admin/access/add/' . $nipp,'<i class="fa fa-plus-square"></i>   add access roles', 'class="btn btn-primary pull-right"'); ?></div> <?php } ?>
                <?php echo anchor('admin/user/manage/', '<i class = "fa fa-plus-square"></i> back user list', 'class="btn btn-primary pull-left"');?>
                
            </div>
      	  </div>
       	</div>
      </div> 
	</div>	
<?php include($this->config->item('footer')); ?>
