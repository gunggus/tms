<?php include($this->config->item('header')); ?>
				
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('ioc/dashboard', 'ADMIN', 'title="Inter Office Correspondence"');?> <i class="fa fa-angle-double-right"></i> UNIT </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> edit unit</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">

			<?php echo form_open('admin/unit/update'); ?>
        
            
			<table class="table table-bordered">
            
            <?php 
				foreach($query as $items) : 
					$unit_code = $items->vu_code;
					$unit_name = $items->vu_name;
					$parent_id = $items->vu_vs_id;
					$id = $items->vu_id;
				endforeach; 
			?>
            <?php echo form_hidden('parent_id', $parent_id); ?>
            <?php echo form_hidden('id', $id); ?>
			<tr>
				<td>Code</td>
				<td><?php echo form_input('code', strtoupper($unit_code),'class="form-group" readonly="readonly"'); ?></td>
			</tr>
			
			<tr>
				<td>Name</td>
				<td><?php echo form_input('name', strtoupper($unit_name),'class="form-group"'); ?></td>
			</tr> 
			
			
			
            </table>
            
            <?php echo form_submit('update','UPDATE', 'class="btn btn-primary"'); ?>
            	
    		<?php echo form_close(); ?>
       
		
			</div>
      	  </div>
       	</div>
      </div> 
       
<?php include($this->config->item('footer')); ?>
