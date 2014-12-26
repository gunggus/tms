<body>    
    <div id="loader"><img src="<?php echo base_url(); ?>wp-content/themes/ods/img/loader.gif"/></div>
    <div class="wrapper">
        <!--
        <div class="sidebar">
            
            <div class="top">
                <a href="index-2.html" class="logo"></a>
                <div class="search">
                    <div class="input-prepend">
                        <span class="add-on orange"><span class="icon-search icon-white"></span></span>
                        <input type="text" placeholder="search..."/>                                                      
                    </div>            
                </div>
            </div>
            <div class="nContainer">                
                <ul class="navigation">         
                    <li class="active"><a href="index-2.html" class="blblue">Dashboard</a></li>
                    <li>
                        <a href="#" class="blyellow">UI Elements</a>
                        <div class="open"></div>
                        <ul>
                            <li><a href="ui.html">UI Elements</a></li>
                            <li><a href="widgets.html">Widgets</a></li>
                            <li><a href="buttons.html">Buttons</a></li>
                            <li><a href="icons.html">Icons</a></li>
                            <li><a href="grid_sys.html">Grid System</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="blgreen">Forms Stuff</a>
                        <div class="open"></div>
                        <ul>
                            <li><a href="forms.html">Form Elements</a></li>
                            <li><a href="validation.html">Validation</a></li>
                            <li><a href="grid.html">Grid</a></li>
                            <li><a href="editor.html">Editors</a></li>  
                            <li><a href="wizard.html">Wizard</a></li>
                        </ul>
                    </li>
                    <li><a href="statistic.html" class="blred">Statistic</a></li>                
                    <li>
                        <a href="#" class="bldblue">Tables</a>
                        <div class="open"></div>
                        <ul>
                            <li><a href="tables.html">Simple</a></li>
                            <li><a href="tables_dynamic.html">Dynamic</a></li>                    
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="blpurple">Samples</a>
                        <div class="open"></div>
                        <ul>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="login.html">Login</a></li>
                        </ul>                    
                    </li>
                    <li>
                        <a href="#" class="blorange">Other</a>
                        <div class="open"></div>
                        <ul>
                            <li><a href="files.html">File handling</a></li>
                            <li><a href="images.html">Images</a></li>
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="404.html">Error 404</a></li>
                        </ul>
                    </li>
                </ul>
                <a class="close">
                    <span class="ico-remove"></span>
                </a>
            </div>
            <div class="widget">
                <div class="datepicker"></div>
            </div>
            
        </div>
        
        -->
		
		<div class="body">
            <ul class="navigation">
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
            
         
            
        