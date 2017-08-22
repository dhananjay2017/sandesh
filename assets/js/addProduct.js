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
	
	var addProductForm = $("#addProduct");
	
	var validator = addProductForm.validate({
		
		rules:{
			name :{ required : true }
		},
		messages:{
			name :{ required : "This field is required" }		
		}
	});
});

jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var pId = $(this).data("productid"),
			hitURL = baseURL + "deleteProduct",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Product ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { prodId : pId } 
			}).done(function(data){
				if(data.status = true) { currentRow.parents('tr').remove(); alert("Product successfully deleted"); }
				else if(data.status = false) { alert("Product deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
