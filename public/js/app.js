Vue.config.debug = true;

var windowWidth = $('.content').width();
console.log(windowWidth/50);
console.log(windowWidth);

var beehiveFactory = new BeehiveFactory();
var currentApiary = new Apiary(handover.current_apiary, beehiveFactory);
currentApiary.setBeehives();
var currentTab = handover.current_tab;

var apiaries = handover.apiaries.map(function(el){
	var beehiveFactory = new BeehiveFactory();
	var apiary = new Apiary(el, beehiveFactory);
	apiary.setBeehives();
	return apiary;
});

Vue.component('beehive', {
	props: ['beehive'],
	template: '#beehive',
	data: function(){
		return {

		};
	},
	computed: {
		isFirstInRow: function(){
			return this.beehive.index % (Math.floor(windowWidth/60.62)) === 0;
		},
		isĹastInRow: function(){
			return this.beehive.index % (Math.floor(windowWidth/60.62)) === ((Math.floor(windowWidth/60.62)) - 1);
		},
		beehivesCount: function(){
			return this.$parent.beehivesCount;
		},
		inOddRow: function(){
			var numberOfColumns = Math.floor(windowWidth/60.62);
			var numberOfRows = Math.ceil(this.beehivesCount/numberOfColumns);
			for(var i = 0; i < numberOfRows; i++){
				if(this.beehive.index >= (i * numberOfColumns) &&
				   this.beehive.index < ((i * numberOfColumns) + numberOfColumns)) {
					return i % 2 !== 0;
				} 
			}
		},
		addMargin: function(){
			return this.isFirstInRow && this.inOddRow;
		}
	}
});

Vue.component('beehives', {
	props: [
		'beehives'
	],
	template: '#beehives',
	computed: {
		beehivesCount: function(){
			return this.beehives.length;
		}
	}
});

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
function Apiary(model, factory){
	this.id = model.id;
	this.user_id = model.user_id;
	this.name = model.name;
	this.location = model.location;
	this.dominant_flora = model.dominant_flora;
	this.editor_route = model.editor_route;
	this.create_beehive_route = model.create_beehive_route;
	this.setBeehives = function(){
		this.beehives = model.beehives.map(function(el){
			return factory.createBeehive(el);
		});
	};
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

function BeehiveFactory(){
	this.index = 0;
	this.createBeehive = function(model){
		return {
			index: this.index++,
			id: model.id,
			apiary_id: model.apiary_id,
			name: model.name,
			type: model.type
		};
	}
}


//# sourceMappingURL=app.js.map
