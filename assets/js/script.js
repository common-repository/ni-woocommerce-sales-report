jQuery(function($) {
    $("._datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    $("._datepicker").datepicker("option", "showAnim", "blind");
    $("._datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    $( "#frmOrderItem" ).submit(function( event ) {
        $(".ajax_content").html("Please wait..");

        // Serialize form data
        var formData = $(this).serialize();

        // Add nonce to form data
        formData += '&nonce=' + ni_sales_report_ajax_object.nonce;

        $.ajax({
            url: ni_sales_report_ajax_object.ni_sales_report_ajaxurl,
            type: 'POST', // Specify POST method explicitly
            data: formData,
            success: function(data) {
                $(".ajax_content").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        }); 
        return false; 
    });

    // Trigger form submission when the page loads
    $("#frmOrderItem").trigger("submit");

    $("#select_order").change(function(){
        // Handle change event if needed
    });
});
