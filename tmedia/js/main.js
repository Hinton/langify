$(document).ready(function() {
	
	$(".edit").click(function() {
		
		// alert( $.trim( $(this).parent().parent().find('.info').text() ) );
		
		if ( $(this).parent().parent().find(".info").is(':visible') ) {
			
			$(this).parent().parent().find(".info").fadeOut("slow", function() {
			
				$(this).parent().parent().find(".form").fadeIn("slow");
			
			});
			
		} else {
			
			
			$(this).parent().parent().find(".form").fadeOut("slow", function() {
			
				$(this).parent().parent().find(".info").fadeIn("slow");
			
			});
			
			
		}
		
	});
	
});