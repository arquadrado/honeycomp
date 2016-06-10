Vue.config.debug = true;

var windowWidth = $('.content').width();
console.log(windowWidth/50);
console.log(windowWidth);

var beehiveFactory = new BeehiveFactory();

var apiaries = handover.apiaries.map(function(el){
	var beehiveFactory = new BeehiveFactory();
	var apiary = new Apiary(el, beehiveFactory);
	apiary.setBeehives();
	return apiary;
});

var currentApiary = (function(){
	for(var i = 0; i < apiaries.length; i++){
		if(handover.current_apiary.id === apiaries[i].id){
			return apiaries[i];
		}
	};
})();

var currentBeehive = (function(){
	for(var i = 0; i < currentApiary.beehives.length; i++){
		if (currentApiary.beehives[i].id === handover.current_beehive.id){
			return currentApiary.beehives[i];
		}
	};
	return currentApiary.beehives[0];
})();

Vue.component('beehive', {
	props: ['beehive'],
	template: '#beehive',
	data: function(){
		return {

		};
	},
	computed: {
		isActive: function(){
			return this.beehive === this.$parent.currentBeehive ? '#fece06' : '#dddddd';
		},
		isFirstInRow: function(){
			console.log(this.beehive.index);
			return this.beehive.index % (Math.floor(windowWidth/60.62)) === 0;
		},
		isĹastInRow: function(){
			return this.beehive.index % (Math.floor(windowWidth/60.62)) === ((Math.floor(windowWidth/60.62)) - 1);
		},
		beehivesCount: function(){
			console.log('hey');
			console.log(this.beehive);
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
	},
	methods: {
		activateBeehive: function(){
			this.$dispatch('activateBeehive', this.beehive);
			this.active = true;
		}
	}
});

Vue.component('apiary', {
	props: ['apiary'],
	template: '#apiary',
	data: function(){
		return {
			
		}
	},
	computed: {
		beehivesCount: function(){
			return this.apiary.beehives.length;
		},
		currentBeehive: function(){
			return this.$parent.selectedBeehive;
		} 
	},
	methods: {
		deleteBeehive: function(){
			if (confirm('Tem a certeza que quer remover esta colmeia?')){
				this.apiary.removeBeehive(this.currentBeehive);
				this.$dispatch('currentBeehive', this.apiary.beehives[0]);
			}
		}
	}
});

var app = new Vue({
	el: '#app',
	data: {
		apiaries: apiaries,
		selectedApiary: currentApiary,
		selectedBeehive: currentBeehive
	},
	methods: {
		selectApiary: function(apiary){
			this.selectedApiary = apiary;
			this.selectedBeehive = this.selectedApiary.beehives[0]; 
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
		},
		'activateBeehive': function(beehive){
			this.selectedBeehive = beehive;
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
	this.removeBeehive = function(beehive){
		var index = this.beehives.indexOf(beehive);
		if (index > -1) {
		    this.beehives.splice(index, 1);
		}
		this.ajaxRequest(beehive, beehive.deleteRoute, 'POST')
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
			type: model.type,
			editorRoute: model.editor_route,
			deleteRoute: model.delete_route
		};
	}
}

