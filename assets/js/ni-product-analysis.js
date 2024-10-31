// JavaScript Document
jQuery(function($){
    $(document).on("click","._display_order_product_info",function(event){
        event.preventDefault();
        

        var form_data = {};
        form_data["action"] = "sales_order";
        form_data["ajax_function"] = "display_order_product_info";
        form_data["page"] = "ni-product-analysis-report";
        form_data["product_id"] = $(this).attr("data-product_id");
        form_data["variation_id"]  = $(this).attr("data-variation_id");
        //alert(JSON.stringify(form_data));

        $.ajax({
			//url: ajaxurl,
			url:ni_sales_report_ajax_object.ni_sales_report_ajaxurl,
			//data:$("#frmOrderItem").serialize(),
			//data: "{action:'my_action',sub_action:'order_item',select_order:'"+ $("#select_order").val() +"'}",
			data: form_data,
			success:function(data) {
				// This outputs the result of the ajax request
				//console.log(data);
				//alert(data);
				//alert(JSON.stringify(data));
                //alert(JSON.stringify(data));
				$("._data_product_information").html(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		
		});


    });
});