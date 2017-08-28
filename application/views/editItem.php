<?php

		$pId = '';
        $name = '';
		$hsn_gsn_code = '';
		$sgst = '';
		$cgst = '';
		$igst = '';
        $status = '';

if(!empty($itemInfo))
{
    foreach ($itemInfo as $uf)
    {
	    $ItemId = $uf->id;
		$pId = $uf->pid;
        $name = $uf->name;
		$hsn_gsn_code = $uf->hsn_gsn_code;
		$sgst = $uf->sgst;
		$cgst = $uf->cgst;
		$igst = $uf->igst;
        $status = $uf->status;

    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Management
        <small>Add / Edit Product Item</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Item Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addProductItem" action="<?php echo base_url() ?>editItm" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
									    <input value="<?php echo $ItemId; ?>" type="hidden" id="itemId" name="id">
                                        <label for="fname">Product: </label>
                                        <select class="form-control required" name="pid" id="pid">
										 <option value="">Select Product</option>
										<?php foreach($products as $prod) {?>
										  <option <?php if($prod->id == $pId) echo "selected=selected"; ?> value="<?php echo $prod->id; ?>"><?php echo $prod->name; ?></option>
										<?php } ?>
										</select>
                                    </div>  
                                </div>
                                
                            </div>
							 <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Item Name</label>
                                        <input value="<?php echo $name; ?>" type="text" class="form-control required" id="name" name="name" maxlength="128">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hsn_gsn_code">HSN/GSN Code</label>
                                        <input type="text" value="<?php echo $hsn_gsn_code; ?>" class="form-control required" id="hsn_gsn_code"  name="hsn_gsn_code" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sgst">SGST</label>
                                        <input type="text" value="<?php echo $sgst; ?>" class="form-control required" id="sgst"  name="sgst">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cgst">CGST</label>
                                        <input type="text" value="<?php echo $cgst; ?>" class="form-control required" id="cgst" name="cgst">
                                    </div>
                                </div>
								
                            </div>
                               <div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="igst">IGST</label>
                                        <input type="text" value="<?php echo $igst; ?>" class="form-control required" id="igst" name="igst">
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control required"  id="status"  name="status">
										  <option value="1" <?php if($status == 1) echo "selected='selected'"; ?>>Active</option>
										  <option value="0" <?php if($status == 0) echo "selected='selected'"; ?>>InActive</option>
										</select>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addProductItem.js" type="text/javascript"></script>