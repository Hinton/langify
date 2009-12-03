$(document).ready(function() {
	
	// Language select system
	$('.language_select form select').change(function()
	{
		$(this).parents('form').submit();
	});
	
	$(".edit_form").submit(function(event) {
		var this2 = this;
		$(this).find('.change').fadeOut(200, function() {
			$(this2).find('.ajax').fadeIn(200);
		
		
			var id     = $(this).find("input[name='id']").attr('value');
			var key_id = $(this).find("input[name='key_id']").attr('value');
			var string = $(this).find("input[name='string']").attr('value');
			
			if (id) {
				
				$.ajax({
					type: 'POST',
					data: 'id='+id+'&string='+string,
					success: function(result){
						
						$(this2).find('.ajax').fadeOut(200, function() {
							$(this2).find('.change').fadeIn(200);
						});
						
					}
				});
				
				return false;
				
			} else {
				
				$.ajax({
					type: 'POST',
					data: 'key_id='+key_id+'&string='+string,
					success: function(result){
						
						$(this2).find('.ajax').fadeOut(200, function() {
							$(this2).find('.change').fadeIn(200);
						});
						
					}
				});
			}
		});
		
		return false;
		
	});
	
});