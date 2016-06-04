Vue.config.debug = true;
var currentApiary = new Apiary(handover.current_apiary);
var currentTab = handover.current_tab;
var apiaries = handover.apiaries.map(function(el){
	return new Apiary(el);
});

Vue.component('beehive', {
	props: ['beehive'],
	template: '#beehive'
});

Vue.component('info', {
	props: [
		'name',
		'location',
		'flora',
	],
	template: '#info'
});

Vue.component('beehives', {
	props: [
		'create',
		'beehives'
	],
	template: '#beehives'
});

Vue.component('settings', {
	props: [
		'editor',
	],
	template: '#settings',
	methods: {
		deleteApiary: function(){
			this.$dispatch('delete');
		}
	}
})

Vue.component('apiary', {
	props: ['apiary'],
	template: '#apiary',
	data: function(){
		return {
			active: currentTab
		}
	},
	methods: {
		setActiveComponent: function(component){
			this.active = component;
			
			$.ajax({
				url: 'http://mel.local/apiarios/sessao',
				data: {
					'_token': handover.token,
					'data': {
						tab: this.active
					}
				},
				method: 'POST',
				success: function(){
					console.log('success');
				},
				error: function(){
					console.log('error');
				}
			});
		},
		activeComponent: function(component){
			if(this.active === component){
				return true;
			}	
		}
	}
});

var app = new Vue({
	el: '#app',
	data: {
		apiaries: apiaries,
		selectedApiary: currentApiary
	},
	methods: {
		selectApiary: function(apiary){
			this.selectedApiary = apiary;
			this.selectedApiary.saveInSession();
		},
		deleteApiary: function(apiary){
			if (confirm('Tem a certeza que quer apagar este apiário?')) {
				var index = this.apiaries.indexOf(apiary);
				if (index > -1) {
				    this.apiaries.splice(index, 1);
				    this.selectedApiary.remove(apiary);
				    this.selectedApiary = this.apiaries[0];
				}
			}
		},
		isCurrentApiary: function(apiary){
			return apiary === this.selectedApiary;
		}
	},
	events: {
		'delete': function(){
			this.deleteApiary(this.selectedApiary);
		}
	}
});

//constructors
function Apiary(model){
	this.id = model.id;
	this.user_id = model.user_id;
	this.name = model.name;
	this.location = model.location;
	this.dominant_flora = model.dominant_flora;
	this.editor_route = model.editor_route;
	this.create_beehive_route = model.create_beehive_route;
	this.beehives = model.beehives;
	this.remove = function(){
		this.ajaxRequest(this, 'http://mel.local/apiarios/apagar', 'POST');
	};
	this.saveInSession = function(){
		this.ajaxRequest(this, 'http://mel.local/apiarios/sessao', 'POST');	
	}
	this.ajaxRequest = function(item, url, method){
		$.ajax({
			url: url,
			data: {
				'_token': handover.token,
				'item_id': item.id
			},
			method: method,
			success: function(){
				console.log('success');
			},
			error: function(){
				console.log('error');
			}
		});
	};
}


