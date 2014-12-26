<?php #$this->load->view ('template_admin/admin_logo')?>

<?php #$this->load->view ('template_admin/admin_header')?>			

	<div class="container_12">

	<?php #$this->load->view('template_admin/admin_navigation_user_level')?>

	<div class="content">

	<div class="container_12">

	<h2 class="page-title">Form Position<span class="breadcrumbs">

	<a href="<?php echo base_url()?>index.php/position/tabel_position">Tabel Position</a> &rsaquo; Form Position</span></h2>

	</div>
	
	<div class="grid_4">
    		
			<?php echo form_open_multipart('position/submit'); ?>
			<?php echo form_hidden('vp_code',$fvp_code); ?>
        
        
			<tr>
				<td> <strong><?php echo form_label('Position Code'); ?></strong></td>
				<td> <input class="text-box"<?php echo form_input('vp_code',$fvp_code,'id="vp_code"'); ?></td>
			</tr>
			
			<tr>
				<td> <strong><?php echo form_label('Position Name '); ?></strong></td>
				<td> <input class="text-box"<?php echo form_input('vp_name',$fvp_name,'id="vp_name"'); ?></td>
			</tr> 
			
			<tr>
				<td> <strong><?php echo form_label('Team Code '); ?></strong></td>
				<td> <input class="text-box"<?php echo form_input('vp_vt_code',$fvp_vt_code,'id="vp_vt_code"'); ?></td>
			</tr> 
			
			<tr>
				<td> <strong><?php echo form_label('Function Code '); ?></strong></td>
				<td> <input class="text-box"<?php echo form_input('vp_vf_code',$fvp_vf_code,'id="vp_vf_code"'); ?></td>
			</tr> 
			
			<tr>
				<td> <strong><?php echo form_label('Position Level'); ?></strong></td>
				<td> <input class="text-box"<?php echo form_input('vp_level',$fvp_level,'id="vp_level" '); ?></td>
			</tr>
			<br></br>
			<tr>	
			
			 <button type="submit" class="button orange" <?php echo form_submit('update','UPDATE','id="submit"'); echo form_close(); ?> Update</button>
			
			</tr>
		
			<div class="clear"></div>
	</div>
	</article><!-- end of stats article -->
	
    <div id="extended-form-container"></div>
			
			<?php form_close(); ?>
		   
	<div class="clear"></div>
		<?php #$this->load->view ('footer')?>
            
            

		</div>
			
    </article><!-- end of stats article -->
	
	
	
 <div class="clear"></div>