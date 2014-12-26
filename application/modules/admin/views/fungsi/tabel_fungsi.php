<?php include($this->config->item('header')); ?>
				
		<!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('admin/fungsi', 'ADMIN', 'title="Manage Unit"');?> <i class="fa fa-angle-double-right"></i> FUNGSI </h4>
        </div>
      </div>
      <!-- row -->
        
        
      <!-- row -->
      <div class="row">
        
        <!-- col -->
        <div class="col-lg-8">
          
          <!-- widget -->
          <div class="widget">
          
          	<div class="widget-header">    <h3><i class="fa fa-check-square"></i> Pangkat List</h3> </div>
            
            <!-- wigget content -->
            <div class="widget-content">
            
    			<table class="table table-bordered table-hover">
                	<tr align="center">
                	<th>Function Code</th>
                    <th>Function Name</th>
                    <th>Function Level</th>
					
 					<th>ACTION</th>
                </tr> 
		
                <?php foreach ($records as $key ): ?>                    
                
				<tr>    	
                        <td> <?php echo $key->vf_code; ?> </td>
                        <td> <?php echo $key->vf_name; ?> </td>
						<td> <?php echo $key->vf_level; ?> </td>	
					<td>
						
						<a title="edit" href="<?php echo base_url().'admin/fungsi/edit/' . $key->vf_code;  ?>"><i class="fa fa-pencil-square-o"></i></a>
						<a title="delete" href="<?php echo base_url().'admin/fungsi/delete/' . $key->vf_code;  ?>"><i class="fa fa-times-circle"></i></a> 
                        
					</td>
                    
				</tr>
         
          
                <?php endforeach; ?>
 
            </table>
		
        	<a title="edit" href="<?php echo base_url().'admin/fungsi/add/' ;  ?>"><i class="fa fa-pencil-square-o"></i></a>
        
         </div>
      	  </div>
       	</div>
      </div> 
       
<?php include($this->config->item('footer')); ?>
