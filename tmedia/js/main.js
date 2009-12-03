$(document).ready(function() {
	
	$(".edit_form").submit(function(event) {
		
		var id     = $(this).find("input[name='id']").attr('value');
		var key_id = $(this).find("input[name='key_id']").attr('value');
		var string = $(this).find("input[name='string']").attr('value');
		
		if (id) {
			
			$.ajax({
				type: 'POST',
				data: 'id='+id+'&string='+string,
				success: function(result){
					
				}
			});
			
			return false;
			
		} else {
			
			$.ajax({
				type: 'POST',
				data: 'key_id='+key_id+'&string='+string,
				success: function(result){
					
				}
			});
		}
		
		
		return false;
		
	});
	
});