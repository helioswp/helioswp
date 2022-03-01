jQuery(document).ready(function($) {
    $("#billing_email").focusout(function() {
    	var mail = $("#billing_email").val();
 
		jQuery.ajax({
                url: pw_script_vars.ajax_url,
                type: 'POST',
                data: {
            	'action': 'send_abandoned_cart_details',
            	'mail': mail
        	},
                success: function (response) {
                    //alert( response.alert );
                }

            });	
		 e.preventDefault();
	});
});