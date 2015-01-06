<body>    
    <div id="loader"><img src="<?php echo base_url(); ?>wp-content/themes/ods/img/loader.gif"/></div>
    <div class="wrapper">
        
		<div class="body">
            <ul class="navigation">
                <li>
                    <?php echo anchor('task/manage/master',' <div class="icon"><span class="ico-folder-close"></span></div><div class="name">Master Task List</div>', 'class="button red"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/',' <div class="icon"><span class="ico-folder"></span></div><div class="name">Task List</div>', 'class="button red"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/message',' <div class="icon"><span class="ico-envelope"></span></div><div class="name">Task Message</div>', 'class="button red"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/closed_task',' <div class="icon"><span class="ico-zip"></span></div><div class="name">Closed Task</div>', 'class="button red"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/performance',' <div class="icon"><span class="ico-time"></span></div><div class="name">Performance</div>', 'class="button red"');?>
				</li>
				<li>
                    <?php echo anchor('admin/module',' <div class="icon"><span class="ico-collapse"></span></div><div class="name">Module</div>', 'class="button red"');?>
				</li>
				<li>
                    <?php echo anchor('admin/user',' <div class="icon"><span class="ico-user"></span></div><div class="name">User</div>', 'class="button red"');?>
				</li>
                <li>
                    <?php echo anchor('task/manage/form_search',' <div class="icon"><span class="ico-search"></span></div><div class="name">Search</div>', 'class="button red"');?>
				</li>
                <li>
                    <div class="user">
                        <a href="#" class="name">
                            <?php if($this->session->userdata('logged_in')) { 
							echo anchor("user/profile", 
							"<span>".$this->session->userdata['logged_in']['ui_nama']."</span>
                            <span class='sm'>".$this->session->userdata['logged_in']['ui_level']."</span>
							","class='name'");
							echo anchor("user/logout", 
							"<span class='ico-signout' title='logout'>logout</span>
                            ","class='name'");
							} ?>
						</a>
                    </div>
					
                </li>                
            </ul>
            
         
            
        