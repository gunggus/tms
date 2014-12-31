<?php include($this->config->item('header')); ?>
<div class="login">

        <div class="page-header">
            <div class="icon">
                <span class="ico-locked"></span>
            </div>
            <h1>PIN Login <small>TASK MANAGEMENT SYSTEM</small></h1>
        </div>        
        
        <div class="row-fluid">
            <?php if (isset($message)) { ?><p><?php echo '<p>error message : ' . $message . '</p>';?></p><?php } ?>
            <?php if (validation_errors()) { ?><p><?php echo '<p class="text-warning">error message : ' . validation_errors() . '</p>';?></p><?php } ?>
            <?php echo form_open('user/verification/do_pin_verification'); ?>    
            <div class="row-form">
                <div class="span12">
                        <input type="email" 
						<?php if ($email == '')
							{ 
								echo 'placeholder="Your Email"';
								
							}
							else
							{
								echo 'value="' . $email . '"'; 
							}
						?>
						class="form-control input-lg" id="email" name="email">
                </div>
            </div>
            <div class="row-form">
                <div class="span9">
                    <input type="text" placeholder="Your PIN" class="form-control input-lg" id="pin" name="pin">
                </div>
            </div>
            <div class="row-form">
                <div class="span12" align ="right">
                    <button class="btn">Login <span class="icon-arrow-next icon-white"></span></button>
                </div>                
            </div>
            <div class="row-form">
                <div class="span12">
					<?php echo anchor("user/password_login",'<span class="ico-loop icon-white" title="Change To Password Login"></span> Password Login');?>
                </div>                
            </div>
			<?php echo form_close();?>
        </div>
</div>

<?php include($this->config->item('footer')); ?>