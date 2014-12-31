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
            <?php echo form_open('user/pin_login/pin_do_login'); ?>    
            <div class="row-form">
                <div class="span6">
                    <input type="email" placeholder="Your Email" class="form-control input-md" id="email" name="email">
                </div>
                <div class="span6" align ="right">
                    <button class="btn">Request Pin <span class="icon-arrow-next icon-white"></span></button>
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