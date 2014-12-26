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
        <div class="col-lg-6">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> sub unit list</h3> </div>
            
            
           
            
            <!-- wigget content -->
            <div class="widget-content">
            
            	<table class="table table-bordered table-hover">
                	<tr align="center">
                        <th>ID</th>
                        <th>CODE</th>
                        <th>NAME</th>
                        <th colspan="3">ACTION</th>
                	</tr> 
		

                	<?php foreach ($records as $key ): ?>                    
                	
                    <?php $parent_id = $key->vsu_vu_id; ?>
                    
					<tr>    	
                        <td> <?php echo strtoupper($key->vsu_id); ?> </td>
                        <td> <?php echo strtoupper($key->vsu_code); ?> </td>
                        <td> <?php echo strtoupper($key->vsu_name); ?> </td>
                        
                        <td align="center">
                    	<a title="edit sub unit" href="<?php echo base_url().'admin/sub_unit/edit/' . $key->vsu_id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                        </td>
                        <td align="center">
						<a title="delete sub unit" href="<?php echo base_url().'admin/sub_unit/delete/' . $key->vsu_id; ?>"><i class="fa fa-times-circle"></i></a>
                        </td>
                        <td align="center">
                        <a title="view team" href="<?php echo base_url().'admin/team/manage/' . $key->vsu_id; ?>"><i class="fa fa-caret-square-o-down"></i></a>
						</td>
					</tr>
          
                	<?php endforeach; ?>
                
                </table>
                
                <div class="col-lg-2"><?php echo anchor('admin/sub_unit/add/'. $parent_id ,'<i class="fa fa-plus-square"></i>   add new sub_unit', 'class="btn btn-primary"'); ?></div> 
                
            </div>
      	  </div>
       	</div>
      </div> 
      
     
       
<?php include($this->config->item('footer')); ?>
