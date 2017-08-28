/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addProductForm = $("#addProductItem");
	
	var validator = addProductForm.validate({
		
		rules:{
		    pid :{ required : true },
			name :{ required : true },
			hsn_gsn_code :{ required : true },
			sgst :{ required : true },
			cgst :{ required : true },
			igst :{ required : true }
		},
		messages:{
            pid :{ required : "This field is required" },
			name :{ required : "This field is required" },
			hsn_gsn_code :{ required : "This field is required" },
			sgst :{ required : "This field is required" },
			cgst :{ required : "This field is required" },
			igst :{ required : "This field is required" }			
		}
	});
});



jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteItem", function(){
		var pId = $(this).data("itemid"),
			hitURL = baseURL + "deleteItem",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Product item ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { itemId : pId } 
			}).done(function(data){
				if(data.status = true) { currentRow.parents('tr').remove(); alert("Product item successfully deleted"); }
				else if(data.status = false) { alert("Product item deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
});
