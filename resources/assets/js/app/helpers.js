function beehiveAjaxUpdate(data, url, method){
	$.ajax({
		url: url,
		data: {
			'_token': handover.token,
			'data': data
		},
		method: method,
		success: function(){
			console.log('success');
		},
		error: function(){
			console.log('error');
		}
	});
}