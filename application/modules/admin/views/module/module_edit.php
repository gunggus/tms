<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Module</h1>
        </div>
		
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/module/manage', 'MODULE', 'title="Inter Office Correspondence"');?> <i class="fa fa-angle-double-right"></i> MODUL </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> edit modul</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
		
			<?php echo form_open('admin/module/update'); ?>
        
            
			<table class="table table-bordered">
			<?php foreach($query as $row) : ?>
            <?php $id = $row->vm_name; ?>
            <?php $publish = $row->vm_active; ?>
            <?php 
			
				foreach($query as $items) : 
				 
					$mod_name 		= $items->vm_name;
					$mod_active 	= $items->vm_active;
					$mod_hide 		= $items->vm_hide;
				endforeach; 
			?>
			<?php endforeach;?>
            
			<tr>
				<td>Module Name</td>
               
				<td><?php echo form_input('mod_name',$mod_name,'class="form-group" readonly="readonly"'); ?></td>
			</tr>
			
			<tr>
				<td>Module active </td>
				<td><?php echo form_input('mod_active',$mod_active,'class="form-group"'); ?></td>
			</tr> 
			
			<tr>
				<td>Module hide</td>
				<td><?php echo form_input('mod_hide',$mod_hide,'class="form-group" disabled="disabled"'); ?></td>
			</tr>
			
            </table>
			
			<?php if($publish == 'n') { ?> 
            <div class="col-lg-2"><?php echo anchor('admin/module/publish_post/' . $id . '/','<i class="fa fa-thumbs-o-up"></i>active module', 'class="btn btn-primary"'); ?></div>
            <?php }else{ ?>
            <div class="col-lg-2"><?php echo anchor('admin/module/undo_publish_post/' . $id . '/','<i class="fa fa-thumbs-o-down"></i> inactive module', 'class="btn btn-primary"'); ?></div>
            <?php } ?>
    		<?php echo form_close(); ?>
       
		
			</div>
      	  </div>
       	</div>
      </div> 
    </div>   
<?php include($this->config->item('footer')); ?>
