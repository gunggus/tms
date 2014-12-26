<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Add Memo</h1>
        </div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
          <h4 class="page-title"><?php echo anchor('ioc/dashboard', 'IOC', 'title="Inter Office Correspondence"');?> <i class="fa fa-angle-double-right"></i> ADD MEMO</h4>
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
                    
                  	<?php echo form_open_multipart('ioc/add/save', 'class="form-horizontal"'); ?>
                    
                    <div class="row-form">
                        <label for="inputTanggal" class="span2 col-sm-2 control-label">Tanggal Penerimaan</label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" id="datepicker" placeholder="Tanggal Terima" name="docs_date_in">
                        </div>
                      </div>  
                    
                     <div class="row-form">
                        <label for="inputNomorAgenda" class="span2 col-sm-2 control-label">Nomor Agenda</label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" id="inputNomorAgenda" placeholder="Nomor Agenda" name="docs_reg_no" title="input nomor agenda (free format)">
                        </div>
                      </div>  
                      
					 <div class="row-form">
                            <label for="inputJenis" class="span2 col-sm-2 control-label">Jenis</label>
                            <div class="span4 col-sm-4">
                            		<select name="docs_type" class="form-control">
                                      <option value="memo">Memo</option>
                                      <option value="notadinas" selected="selected">Nota Dinas</option>
                                      <option value="surat">Surat</option>
                                      <option value="sk">Surat Keputusan</option>
                                      <option value="ba">Berita Acara</option>
                                      <option value="sk">Surat Keputusan</option>
                                    </select>
                            </div>
                  	</div>
					  
                     <div class="row-form">
                        <label for="inputNomor" class="span2 col-sm-2 control-label">Nomor Dokumen</label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" id="inputNomor" placeholder="Nomor Dokumen" name="docs_no"  title="input nomor dokumen (free format)">
						</div>
                      </div>  
       
					 <div class="row-form">
                        <label for="inputTanggal" class="span2 col-sm-2 control-label">Tanggal Dokumen</label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" id="datepicker2" placeholder="Tanggal Dokumen" name="docs_date">
                        </div>
                     </div>  

                     <div class="row-form">
                        <label for="inputDari" class="span2 col-sm-2 control-label">Dari</label>
                        <div class="span4 col-sm-4">
                          <input type="text" class="form-control" id="inputDari" placeholder="Dari" name="docs_from">
                        </div>
                     </div>       
                      
                      
                     <div class="row-form">
                        <label for="inputKepada" class="span2 col-sm-2 control-label">Kepada</label>
                        <div class="span4 col-sm-4">
                          	<input type="text" class="form-control" id="inputKepada" placeholder="Kepada" name="docs_to">
                        </div>
                     </div>      
                      
                     <div class="row-form">
                        <label for="inputTembusan" class="span2 col-sm-2 control-label">Tembusan</label>
                        <div class="span4 col-sm-4">
                          	<input type="text" class="form-control" id="inputKepada" placeholder="Kepada" name="docs_copy">
                        </div>
                     </div>         
					
                     <div class="row-form">
                        <label for="inputPerihal" class="span2 col-sm-2 control-label">Perihal</label>
                        <div class="span4 col-sm-4">
                          	<input type="text" class="form-control" id="inputPerihal" placeholder="Perihal" name="docs_subject">
                        </div>
                      </div>      	

                      <div class="row-form">
                        <label for="inputFile" class="span2 col-sm-2 control-label">Lampiran</label>
                        <div class="span4 col-sm-4">
                          	<input type="file" value="file" class="form-control" id="inputFile" name="file">
                        </div>
                      </div>      
                          
                      <div class="row-form">
                        <div class="span4 col-sm-offset-4 col-sm-6">			
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