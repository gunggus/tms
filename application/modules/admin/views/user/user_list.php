<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>User</h1>
        </div>
		
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/module', 'ADMIN', 'title="admin area"');?> <i class="fa fa-angle-double-right"></i> USER </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12">
          
          <!-- widget -->
          <div class="block">
			
			<div class="data-fluid">
				<?php echo form_open('admin/user/search_keyword'); ?>
				<div class="row-form">
					<div class="span4"><input type="text" name = "keyword" class="form-control" placeholder = "search by / name / nip / email"  /></div>
					<div class="span4"><input type="submit" value = "Search" class="btn btn-primary pull-left"/></div>
				</div>
				<?php echo form_close(); ?>
			</div>
		  </div>		
          <div class="block">  
			<div class="data-fluid">
			
				<table class="table table-bordered table-hover">
                	<tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>NIPP</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Level</th>
                        <th>Verification</th>
                        <th>Status</th>
                        <th>Action</th>
                	</tr> 
		

                	<?php foreach ($query as $key ): ?>                    
                
					<tr>    	
                        <td> <?php echo $key->ui_id; ?> </td>
                        <td> <?php echo $this->encrypt->decode($key->ui_nama); ?> </td>
                        <td> <?php echo $key->ui_nipp; ?> </td>
                        <td> <?php echo $this->encrypt->decode($key->ui_hp); ?> </td>
                        <td> <?php echo $key->ui_email; ?> </td>
                        <td> <?php echo $key->ui_jabatan; ?> </td>
                        <td> <?php echo $key->ui_level; ?> </td>
                        <td> <?php if($key->ui_verification == 'n'){echo 'no verified';}else{echo 'verified';}?> </td>
                        <td> <?php if($key->ui_approval == 'n'){echo 'suspend';}else{echo 'active';}?> </td>
                        <td>
                        <?php if($this->user_access->level() >= 40 ){ ?>
                        <?php 
						if($key->ui_approval == 'n')
						{
							echo '<a title="approve user status" href=" ' . base_url(). 'admin/user/activated_user/' . $key->ui_id . '"><i class="fa fa-thumbs-up"></i></a>'; 
						}
						else
						{
							echo '<a title="suspend user status" href=" ' . base_url(). 'admin/user/suspended_user/' . $key->ui_id . '"><i class="fa fa-thumbs-down"></i></a>';
						}
						?> 
                    	<a title="edit user" href="<?php echo base_url().'admin/user/edit/' . $key->ui_id; ?>"><span class="ico-pencil"></span></a>
						<a title="delete user" href="<?php echo base_url().'admin/user/delete/' . $key->ui_id; ?>"><span class="ico-trash"></span></a>
                        
                        <?php } ?>
                        <a title="view access roles" href="<?php echo base_url().'admin/access/manage/' . $key->ui_nipp; ?>"><i class="ico-double-angle-down"></i></a>
						</td>
					</tr>
          
                	<?php endforeach; ?>
                
                </table>
                
                <?php if($this->user_access->level() >= 40 ){ ?><div class="col-lg-2"><?php echo anchor('admin/user/add','<i class="fa fa-plus-square"></i>   add new user', 'class="btn btn-primary pull-left"'); ?></div> <?php } ?>
                
            </div>
		 </div>
       	</div>
      </div> 
	</div>
<?php include($this->config->item('footer')); ?>
