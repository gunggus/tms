<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Announcement</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('task/manage', 'TMS', 'title="Task Management System"');?> <i class="fa fa-angle-double-right"></i> ADD ANNOUNCEMENT</h4>
        </div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
          <div class="block">
            
            <!-- wigget content -->
            <div class="data-fluid">
        			 
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
                    
                  	<?php echo form_open('task/action/save_announcement', 'class="form-horizontal"'); 
					?>
                    
                    <div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Title </label>
                        <div class="span8 col-sm-4">
                          <input type="text" class="form-control" placeholder="Announcement Title" name="title">
                        </div>
                    </div>  
					<div class="row-form">
                        <label for="inputNama" class="span2 col-sm-2 control-label"> Detail </label>
                        <div class="span8 col-sm-4">
								<div class="data-fluid editor">
								<div class="cleditorMain" style="width: 100%; height: 300px;">
								<div class="cleditorToolbar" style="height: 27px;">
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Bold"></div>
								<div class="cleditorButton" title="Italic" style="background-position: -24px 50%;"></div>
								<div class="cleditorButton" title="Underline" style="background-position: -48px 50%;"></div>
								<div class="cleditorButton" title="Strikethrough" style="background-position: -72px 50%;"></div>
								<div class="cleditorButton" title="Subscript" style="background-position: -96px 50%;"></div>
								<div class="cleditorButton" title="Superscript" style="background-position: -120px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Font" style="background-position: -144px 50%;"></div>
								<div class="cleditorButton" title="Font Size" style="background-position: -168px 50%;"></div>
								<div class="cleditorButton" title="Style" style="background-position: -192px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Font Color" style="background-position: -216px 50%;"></div>
								<div class="cleditorButton" title="Text Highlight Color" style="background-position: -240px 50%;"></div>
								<div class="cleditorButton cleditorDisabled" title="Remove Formatting" disabled="disabled" style="background-color: transparent; background-position: -264px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Bullets" style="background-color: transparent; background-position: -288px 50%;"></div>
								<div class="cleditorButton" title="Numbering" style="background-color: transparent; background-position: -312px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Outdent" style="background-position: -336px 50%;"></div>
								<div class="cleditorButton" title="Indent" style="background-position: -360px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Align Text Left" style="background-position: -384px 50%;"></div>
								<div class="cleditorButton" title="Center" style="background-position: -408px 50%;"></div>
								<div class="cleditorButton" title="Align Text Right" style="background-position: -432px 50%;"></div>
								<div class="cleditorButton" title="Justify" style="background-position: -456px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Undo" style="background-position: -480px 50%;"></div>
								<div class="cleditorButton cleditorDisabled" title="Redo" disabled="disabled" style="background-position: -504px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Insert Horizontal Rule" style="background-position: -528px 50%;"></div>
								<div class="cleditorButton" title="Insert Image" style="background-position: -552px 50%;"></div>
								<div class="cleditorButton" title="Insert Hyperlink" style="background-position: -576px 50%;"></div>
								<div class="cleditorButton cleditorDisabled" title="Remove Hyperlink" disabled="disabled" style="background-position: -600px 50%;"></div>
								<div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton cleditorDisabled" title="Cut" disabled="disabled" style="background-position: -624px 50%;"></div>
								<div class="cleditorButton cleditorDisabled" title="Copy" disabled="disabled" style="background-position: -648px 50%;"></div>
								<div class="cleditorButton cleditorDisabled" title="Paste" disabled="disabled" style="background-position: -672px 50%;"></div>
								<div class="cleditorButton" title="Paste as Text" style="background-position: -696px 50%;"></div><div class="cleditorDivider"></div>
								</div>
								<div class="cleditorGroup">
								<div class="cleditorButton" title="Print" style="background-position: -720px 50%;"></div>
								<div class="cleditorButton" title="Show Source" style="background-position: -744px 50%;"></div>
								</div>
								</div>
								<textarea id="wysiwyg" name="detail" style="height: 273px; display: none; width: 1209px;">
                                </textarea>
								<iframe frameborder="0" src="javascript:true;" style="width: 1209px; height: 273px;" __idm_frm__="3"></iframe>
								</div>
								</div>
                        </div>
                    </div>  
					<div class="row-form">
                        <div class="span10 col-sm-offset-4 col-sm-6">			
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </div>            
                                            
				<?php echo form_close(); ?>                    
                    
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