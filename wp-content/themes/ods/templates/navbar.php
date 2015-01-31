<body>    
    <!-- <div id="loader"><img src="<?php echo base_url(); ?>wp-content/themes/ods/img/loader.gif"/></div>
    -->
	<div class="wrapper">
        
		<div class="body">
            <ul class="navigation">
                <?php $data=array('ua_module'=>'task'); if($this->module_management->module_main_hide($data) == FALSE) { ?>
				<?php $data['ua_sub_module']='manage'; if($this->module_management->module_sub_hide($data) == FALSE) { ?>
				<li>
                 	<?php echo anchor('task/manage/absensi',' <div class="icon"><span class="ico-clipboard-2"></span></div><div class="name">Absensi</div>', 'class="button"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/master',' <div class="icon"><span class="ico-folder-close"></span></div><div class="name">Master Task</div>', 'class="button"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/',' <div class="icon"><span class="ico-folder"></span></div><div class="name">Task List</div>', 'class="button"');?>
				</li>
				<!--
                <li>
                    <?php echo anchor('task/manage/applyment',' <div class="icon"><span class="ico-envelope"></span></div><div class="name">Applyment</div>', 'class="button"');?>
				</li>
				-->
				<?php } ?>
				<?php } ?>
                <?php $data=array('ua_module'=>'performance'); if($this->module_management->module_main_hide($data) == FALSE) { ?>
				<?php $data['ua_sub_module']='manage'; if($this->module_management->module_sub_hide($data) == FALSE) { ?>
				<li>
                    <?php echo anchor('performance/manage/performance',' <div class="icon"><span class="ico-time"></span></div><div class="name">Performance</div>', 'class="button"');?>
				</li>
			    <li>
                    <?php echo anchor('performance/manage/chart',' <div class="icon"><span class="ico-chart-4"></span></div><div class="name">Chart</div>', 'class="button"');?>
				</li>
				<?php } ?>
				<?php } ?>
                <?php $data=array('ua_module'=>'admin'); if($this->module_management->module_main_hide($data) == FALSE) { ?>
				<?php $data['ua_sub_module']='module'; if($this->module_management->module_sub_hide($data) == FALSE) { ?>
				<li>
                    <?php echo anchor('admin/module',' <div class="icon"><span class="ico-collapse"></span></div><div class="name">Module</div>', 'class="button"');?>
				</li>
				<?php } ?>
				<?php $data['ua_sub_module']='user'; if($this->module_management->module_sub_hide($data) == FALSE) { ?>
				<li>
                    <?php echo anchor('admin/user',' <div class="icon"><span class="ico-group"></span></div><div class="name">User</div>', 'class="button"');?>
				</li>
                <?php } ?>
                <?php } ?>
                <?php $data=array('ua_module'=>'task'); if($this->module_management->module_main_hide($data) == FALSE) { ?>
				<?php $data['ua_sub_module']='manage'; if($this->module_management->module_sub_hide($data) == FALSE) { ?>
				<li>
                    <?php echo anchor('task/manage/form_search',' <div class="icon"><span class="ico-search"></span></div><div class="name">Search</div>', 'class="button"');?>
				</li>
                <?php } ?>
                <?php } ?>
				 <?php if($this->session->userdata('logged_in')) { ?>
				<li>
				    <?php echo anchor('user/profile',' <div class="icon" style="color:#ffffff;">'.strtoupper($this->session->userdata['logged_in']['ui_nama']).'<br/>'.strtoupper($this->session->userdata['logged_in']['ui_level']).'</div><div class="name"> </div>', ' style="height:55px; width:123px;" class="button" style="color:#000077"');?>
				</li>
				<li>
					<div style="width:77px"></div>
				</li>
				<li>
				    <?php echo anchor('user/logout',' <div class="icon"><span class="ico-signout" title="logout"></span></div><div class="name"> </div>', ' style="height:55px; width:25px" class="button red"');?>
				</li>
				<!--
				<li>
                    <div class="user">
                        <a href="#" class="name">
                            <?php if($this->session->userdata('logged_in')) { 
							echo anchor("user/profile", 
							"<span>".$this->session->userdata['logged_in']['ui_nama']."</span>
                            <span class='sm'>".$this->session->userdata['logged_in']['ui_level']."</span>
							","class='name'");
							/*
							echo anchor("user/logout", 
							"<span class='ico-signout' title='logout'>logout</span>
                            ","class='name'");
							*/
							} ?>
						</a>
                    </div>
				</li>
				-->
				<?php } ?>
                                
            </ul>
            
         
            
        