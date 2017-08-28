<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Item Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">

        <div class="row">
		    <div class="col-sm-6">
			   <form action="<?php echo base_url() ?>itemListing" method="POST" id="all_prod">
					<select onchange="getProdItem();" class="form-control required" name="prod" id="prod">
					
					 <option value="">All Product</option>
					<?php foreach($products as $prod) {?>
					  <option <?php if($pid==$prod->id) echo "selected='selected'" ?> value="<?php echo $prod->id; ?>"><?php echo $prod->name; ?></option>
					<?php } ?>
					</select>
				</form>
			</div>
            <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewProdItem"><i class="fa fa-plus"></i>Add New Item</a>
            </div>
        </div>
		  <div class="row">
             <div class="col-xs-12">
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
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Item List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>itemListing" method="POST" id="searchList">
                            <div class="input-group">
							  
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
							  <input type="hidden" name="sort_field" id="sort_field" value='<?php echo $sort_field; ?>' />
							  <input type="hidden" name="sort_ord" id="sort_ord" value='<?php echo $sort_ord; ?>' />
							  <input type="hidden" name="pid" id="pid" value='<?php echo $pid; ?>' />
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover dataTable">
				   <thead>
                    <tr>
                      <th>#</th>
					  <th>Product</th>
                      <th <?php if($sort_field == "name" && $sort_ord=="asc") { ?> class="sorting_asc" <?php } else if($sort_field == "name" && $sort_ord=="desc"){ ?> class="sorting_desc" <?php } ?> ><a href="#" onclick="sortData('name')">Item</a></th>
					   <th <?php if($sort_field == "created" && $sort_ord=="asc") { ?> class="sorting_asc" <?php } else if($sort_field == "created" && $sort_ord=="desc"){ ?> class="sorting_desc" <?php } ?>><a href="#" onclick="sortData('created')">Created On</a></th>
                      <th>Status</th>
                      <!--<th <?php if($sort_field == "modified" && $sort_ord=="asc") { ?> class="sorting_asc" <?php } else if($sort_field == "modified" && $sort_ord=="desc"){ ?> class="sorting_desc" <?php } ?>><a href="#" onclick="sortData('modified')">Modified On</a></th>-->
                      <th class="text-center">Actions</th>
                    </tr>
				</thead>
				<tbody>
                    <?php
                    if(!empty($productRecords))
                    {
					 
					  if($segment == '')
					    $segment = 0;
                        foreach($productRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo ++$segment ?></td>
					  <td><?php echo $record->prod_name ?></td>
                      <td><?php echo $record->name ?></td>
					  <td><?php echo $record->created ?></td>
                      <td><?php if($record->status == 1) echo "Active"; else echo "Inactive"; ?></td>
                      <!--<td><?php echo $record->modified ?></td>-->
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editItem/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteItem" href="#" data-itemid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
					 
                        }
                    }
					else
					{
                    ?>
					<tr>
                      <td>NO RECORD FOUND.</td>
                    </tr>
				    <?php
					 }
					 ?>
					</tbody>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addProductItem.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "itemListing/" + value);
            jQuery("#searchList").submit();
        });
    });
	
	function sortData(field)
	{
	   jQuery("#sort_field").val(field);
	   var sortOrd = jQuery("#sort_ord").val();
	   if(sortOrd == "asc")
	    {
	     jQuery("#sort_ord").val('desc');
	    }	
	   else
	    {
	     jQuery("#sort_ord").val('asc');
		}
		
		jQuery("#searchList").submit();
	}
	
	function getProdItem()
	 {
	   jQuery("#pid").val(jQuery('#prod').val());
	   jQuery("#searchList").submit();
	 }
</script>
