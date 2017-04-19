window.addEvent('domready', function() {
	$('agent_search').addEvent('keyup',function(){
		var input_value = this.value;
			new Request.JSON({
				url: "ajax/ajax_get_agent_address_function.php", 
				onSuccess: function(response){	

						$('response_agent').set('html','<strong>Agent Address:</strong><br /> '+response.address+'<br /> ');
					
				}
			}).get($('form_id'));		
		
	});

});


window.addEvent('domready', function() {
	$('shipper_search').addEvent('keyup',function(){
		var input_value = this.value;
			new Request.JSON({
				url: "ajax/ajax_get_shipper_address_function.php", 
				onSuccess: function(response){	

						$('response_shipper').set('html','<strong>shipper Address:</strong><br /> '+response.address+'<br /> ');
					
				}
			}).get($('form_id'));		
		
	});

});

window.addEvent('domready', function() {
	$('consignee_search').addEvent('keyup',function(){
		var input_value = this.value;
			new Request.JSON({
				url: "ajax/ajax_get_consignee_address_function.php", 
				onSuccess: function(response){	

						$('response_consignee').set('html','<strong>consignee Address:</strong><br /> '+response.address+'<br /> ');
					
				}
			}).get($('form_id'));		
		
	});

});


window.addEvent('domready', function() {
	$('notify_party_search').addEvent('keyup',function(){
		var input_value = this.value;
			new Request.JSON({
				url: "ajax/ajax_get_notify_party_address_function.php", 
				onSuccess: function(response){	

						$('response_notify_party').set('html','<strong>Notify Party Address:</strong><br /> '+response.address+'<br /> ');
					
				}
			}).get($('form_id'));		
		
	});

});


window.addEvent('domready', function() {
	$('customer_search').addEvent('keyup',function(){
		var input_value = this.value;
			new Request.JSON({
				url: "ajax/ajax_get_chart_of_account_address_function.php", 
				onSuccess: function(response){	

						$('response_customer').set('html','<strong>Customer Address:</strong><br /> '+response.address+'<br /> ');
					
				}
			}).get($('form_id'));		
		
	});

});