<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Performance</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">Performance</i> </h4>
		</div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
          <div class="block">
            <div class="head purple">
                <div class="icon"><span class="ico-location"></span></div>
                <h2>Chart</h2>     
                <ul class="buttons">
                    <li><a href="#" onClick="source('table_hover'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                </ul>
			</div>  
			<br>
			<div class="data-fluid">
				<div class="row">
					<?php echo form_open("performance/manage/chart"); ?>
					<div class="span6"></div>
					<div class="span2"> 
						<?php 
							$var_user[""]="";
							foreach($list_user as $lu){
								$usr = $this->encrypt->decode($lu->ui_nama,$this->config->item('encryption_key'));
								$usrnipp = $lu->ui_nipp.";".$usr;
								$var_user[$usrnipp] = $usr;
							}
							echo form_dropdown("user",$var_user,"");
						?>
					</div>
					<div class="span1"> <?php echo form_input("start",""," id='inputStart' class='mask_date' placeholder='start date' "); ?></div>
					<div align="center" class="span1"> <?php echo "s/d"; ?></div>
					<div class="span1"> <?php echo form_input("end",""," id='inputStart' class='mask_date' placeholder='end date' "); ?></div>
					<div align="right" class="span1"> <?php echo form_submit("submit","Search"); ?></div>
					<?php echo form_close();?>
				</div>
				<div class="row"> <br><br></div>
			</div>
			
            <!-- wigget content -->
            <div class="data-fluid">
								
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
					<script type="text/javascript"
						  src="https://www.google.com/jsapi?autoload={
							'modules':[{
							  'name':'visualization',
							  'version':'1',
							  'packages':['corechart']
							}]
						  }">
					</script>

					<script type="text/javascript">
					  google.setOnLoadCallback(drawChart);

					  function drawChart(){
						var data = google.visualization.arrayToDataTable([
						  ['Date', 'Point', 'Target'],
						  ['0000-00-00',0,0],
						 <?php 
						foreach($result as $row){ 
							$date = substr($row->point_date,0,9);
							$point  = $row->point + $row->reward - $row->penalty;
							echo "['".$date."',".$point.",".$target."],";
						} 
						?>	
						]);
						
						var options = {
						  title: "Performance",
						  curveType: 'function',
						  legend: { position: 'bottom' }
						};

						var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

						chart.draw(data, options);
					  }
					</script>
					<div id="curve_chart" style="width: 900px; height: 500px"></div>
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