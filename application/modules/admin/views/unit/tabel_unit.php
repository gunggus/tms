<?php include($this->config->item('header')); ?>
				
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title">
			  <?php echo anchor($this->uri->segment(1, '') . '/' . $this->uri->segment(2, ''), strtoupper($this->uri->segment(1, '')), 'title="Manage Team"');?> 
              <i class="fa fa-angle-double-right"></i> 
              <?php echo strtoupper(str_replace('_', ' ', $this->uri->segment(2, ''))); ?> 
          </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-8">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> unit list</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            
    			<table class="table table-bordered table-hover">
                	<tr align="center">
                	
                    <th>Unit ID</th>
                    <th>Unit Code</th>
					<th>Unit Name</th>
 					<th>ACTION</th>
                </tr> 
		
                <?php foreach ($records as $key ): ?>                    
                
				<?php $parent_id = $key->vu_vs_id; ?>

				<tr>    	
                        <td> <?php echo strtoupper($key->vu_id); ?> </td>
                        <td> <?php echo strtoupper($key->vu_code); ?> </td>
						<td> <?php echo strtoupper($key->vu_name); ?> </td>	
					<td>
						
						<a title="edit" href="<?php echo base_url().'admin/unit/edit/' . $key->vu_id  ?>"><i class="fa fa-pencil-square-o"></i></a>
						<a title="delete" href="<?php echo base_url().'admin/unit/delete/' . $key->vu_id . '/' . $parent_id . '/' ?>"><i class="fa fa-times-circle"></i></a> 
                        <a title="view sub unit" href="<?php echo base_url().'admin/sub_unit/manage/' . $key->vu_id ?>"><i class="fa fa-caret-square-o-down"></i></a>
					</td>
                    
				</tr>
         
          
               <?php endforeach; ?>
 
            </table>
		
			 
             <div class="col-lg-8"> 
					<?php echo anchor('admin/station/manage/02/', '<i class="fa fa-list"></i> back to station list', 'class="btn btn-primary"'); ?> 
					<?php echo anchor('admin/unit/add/' . $this->uri->segment(4, 'error') . '','<i class="fa fa-plus-square"></i>   add new unit', 'class="btn btn-primary"'); ?>
			 </div>
              
         </div>
         
         
         
      	  </div>
       	</div>
      </div> 
       
<?php include($this->config->item('footer')); ?>
