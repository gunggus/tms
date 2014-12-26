<?php include($this->config->item('header')); ?>
				
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('ioc/dashboard', 'ADMIN', 'title="Inter Office Correspondence"');?> <i class="fa fa-angle-double-right"></i> STATION </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> edit company</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">

			<?php echo form_open('admin/company/update'); ?>
        
            
			<table class="table table-bordered">
            
            <?php 
				foreach($query as $items) :
					$parent_id = $items->vd_vc_id;
					$id = $items->vd_id; 
					$code = $items->vd_code;
					$name = $items->vd_name;
				endforeach; 
			?>
            
            <tr>
				<td>ID</td>
				<td><?php echo form_input('id', $id,'class="form-group" readonly="readonly"'); ?></td>
			</tr>
            
			<tr>
				<td>Code</td>
				<td><?php echo form_input('code', $code,'class="form-group" readonly="readonly"'); ?></td>
			</tr>
			
			<tr>
				<td>Name</td>
				<td><?php echo form_input('name', $name,'class="form-group"'); ?></td>
			</tr> 
			
			
			
            </table>
            
            <?php echo form_submit('update','UPDATE', 'class="btn btn-primary"'); ?>
            	
    		<?php echo form_close(); ?>
       
		
			</div>
      	  </div>
       	</div>
      </div> 
       
<?php include($this->config->item('footer')); ?>
