$(document).ready(function() {
	
	// Language select system
	$('.language_select form select').change(function()
	{
		$(this).parents('form').submit();
	});
	
	$(".edit_form input").keydown(function(e) {
		if (e.keyCode == 13) {
			$(this).parent().submit();
			$(this).parent().parent().parent().next().find("input[name='string']").focus();
			return false;
		} else if (e.keyCode != 9) {
			$(this).parent().find('.change').fadeIn(200);
		}
	});
	
	$(".edit_form").submit(function(event) {
		var this2 = this;
		$(this).find('.change').fadeOut(200, function() {
			$(this2).find('.ajax').fadeIn(200);
		
		
			var id     = $(this2).find("input[name='id']").attr('value');
			var key_id = $(this2).find("input[name='key_id']").attr('value');
			var string = $(this2).find("input[name='string']").attr('value');
			
			if (id) {
				
				$.ajax({
					type: 'POST',
					data: 'id='+id+'&string='+string,
					success: function(result){
						// alert(result);
						$(this2).find('.ajax').fadeOut(200, function() {
							//$(this2).find('.change').fadeIn(200);
						});
						
					}
				});
				
			} else {
				
				$.ajax({
					type: 'POST',
					data: 'key_id='+key_id+'&string='+string,
					success: function(result){
						// alert(result);
						$(this2).find('.ajax').fadeOut(200, function() {
							//$(this2).find('.change').fadeIn(200);
						});
						
					}
				});
				
			}
			
		});
		return false;
	});
	
});