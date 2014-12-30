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
                    <?php echo anchor('admin/module',' <div class="icon"><span class="ico-collapse"></span></div><div class="name">Module</div>', 'class="button red"');?>
				</li>
				<li>
                    <?php echo anchor('admin/user',' <div class="icon"><span class="ico-user"></span></div><div class="name">User</div>', 'class="button red"');?>
				</li>
                <!--
				<li class="active">
                    <a href="#" class="button dblue">
                        <div class="icon">
                            <span class="ico-gear"></span>
                        </div>                    
                        <div class="name">Setting</div>
                    </a> 
                    <ul class="sub">
                        <li><?php echo anchor("ioc/document/type","Type"); ?></li>
                        <li><?php echo anchor("ioc/document/access","Access"); ?></li>
                    </ul>                                        
                </li>
				<li>
                    <a href="#" class="button dblue">
                        <div class="icon">
                            <span class="ico-user"></span>
                        </div>                    
                        <div class="name">User</div>
                    </a> 
                    <ul class="sub">
                        <li><a href="tables.html">Simple</a></li>
                        <li><a href="tables_dynamic.html">Dynamic</a></li>
                    </ul>                                        
                </li>
                -->
				<li>
                    <div class="user">
                        <a href="#" class="name">
                            <?php if($this->session->userdata('logged_in')) { 
							echo anchor("user/profile", 
							"<span>".$this->session->userdata['logged_in']['ui_nama']."</span>
                            <span class='sm'>".$this->session->userdata['logged_in']['ui_level']."</span>
							","class='name'");
							} ?>
						</a>
                    </div>
					<!--
                    <div class="buttons">
                        <div class="sbutton green navButton">
                            <a href="#"><span class="ico-align-justify"></span></a>
                        </div>
                        <div class="sbutton blue">
                            <a href="#"><span class="ico-cogs"></span></a>
                            <div class="popup">
                                <div class="arrow"></div>
                                <div class="row-fluid">
                                    <div class="row-form">
                                        <div class="span12"><strong>SETTINGS</strong></div>
                                    </div>                                    
                                    <div class="row-form">
                                        <div class="span4">Navigation:</div>
                                        <div class="span8"><input type="radio" class="cNav" name="cNavButton" value="default"/> Default <input type="radio" class="cNav" name="cNavButton" value="bordered"/> Bordered</div>
                                    </div>                                    
                                    <div class="row-form">
                                        <div class="span4">Content:</div>
                                        <div class="span8"><input type="radio" class="cCont" name="cContent" value=""/> Responsive <input type="radio" class="cCont" name="cContent" value="fixed"/> Fixed</div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
					-->
                </li>                
            </ul>
            
         
            
        