Vue.config.debug = true;

var app = new Vue({
	el: '#app',
	data: {
		apiaries: handover.apiaries,
		selectedApiary: handover.apiaries[0]
	},
	methods: {
		selectApiary: function(apiary){
			this.selectedApiary = apiary;
		},
		deleteApiary: function(apiary){
			var index = this.apiaries.indexOf(apiary);
			if (index > -1) {
			    this.apiaries.splice(index, 1);
			    this.selectedApiary = this.apiaries[0];
			    ajax('hey');
			}
		}
	}
});

//helpers
function ajax(data){
	$.ajax({
		url: 'http://mel.local/delete',
		data: data,
		method: 'POST',
		success: function(){
			console.log('success');
		},
		error: function(){
			console.log('error');
		}
	});
}
//# sourceMappingURL=app.js.map
