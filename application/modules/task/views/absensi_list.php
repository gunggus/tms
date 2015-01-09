<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Absensi</h1>
        	<?php echo "<div align='right'>".anchor("task/action/absensi/in","<input type='button' value='absen' >")."</div>"; ?>
		</div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">ABSEN IN LIST</i> </h4>
		</div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
		 <div class="block">
			<div class="row">
					<?php echo form_open("task/manage/absensi_search"); ?>
					<div class="span6"></div>
					<div class="span2"> 
						<?php 
							$var_user[""]="";
							foreach($list_user as $lu){
								$usr = $this->encrypt->decode($lu->ui_nama,$this->config->item('encryption_key'));
								$var_user[$usr] = $usr;
							}
							echo form_dropdown("user",$var_user,"");
						?>
					</div>
					<div class="span1"> <?php echo form_input("start_date",""," id='inputStart' class='mask_date' placeholder='start date' "); ?></div>
					<div class="span1"> <?php echo form_input("end_date",""," id='inputStart' class='mask_date' placeholder='end date' "); ?></div>
					<div align="right" class="span1"> <?php echo form_submit("submit","Search"); ?></div>
					<?php echo form_close();?>
				</div>
				<div class="row"> <br><br></div>
			<div class="head purple">
                <div class="icon"><span class="ico-location"></span></div>
                <h2>Absensi</h2>     
                <ul class="buttons">
                    <li><a href="#" onClick="source('table_hover'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                </ul>
			</div> 
			<!-- wigget content -->
            <div class="data-fluid">
								
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover">
                        <thead>
							<tr>
								<td>No</td>
								<td>NAMA</td>
								<td>SHIFT</td>
								<td>IN</td>
								<td>OUT</td>
								<td>YM</td>
								<td>SKYPE</td>
								<td>HP STD</td>
								<td>HP PDW</td>
								<td>LISTRIK</td>
								<td>RENCANA</td>
								<td>ACTION </td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo strtoupper($row->abs_nama); ?></td>
								<td><?php echo strtoupper($row->abs_shift); ?></td>
								<td><?php echo $row->abs_in; ?></td>
								<td><?php echo $row->abs_out; ?></td>
								<td><?php echo $row->abs_ym; ?></td>
								<td><?php echo $row->abs_skype; ?></td>
								<td><?php echo $row->abs_hp_std; ?></td>
								<td><?php echo $row->abs_hp_pdw; ?></td>
								<td><?php echo $row->abs_listrik; ?></td>
								<td><?php echo $row->abs_plan; ?></td>
								<td>
									<?php
										echo "<div class='row'>";
										echo " &nbsp;&nbsp;";	
										echo "<div class='span4'>";
										if($row->abs_out == "0000-00-00 00:00:00"  AND  $row->abs_nama == $ui_nama){
											echo anchor("task/action/absensi/out/".$row->abs_id,"<input type='button' value='Absen OUT' >");
										}else{
											echo anchor("task/manage/detail_absensi/".$row->abs_id.'/'.mdate('%Y-%m-%d',strtotime($row->abs_out)),"<input type='button' value='detail absensi' >");
										}
										echo "</div>";
										echo "</div>";
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="12"> <?php echo $this->pagination->create_links();?> </td>
							</tr>
						</tfoot>						
                    </table>
        			<?php } ?>
        
 			</div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

</div>
<?php include($this->config->item('footer')); ?>