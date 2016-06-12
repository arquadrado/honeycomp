Vue.config.debug = true;

var windowWidth = $('.content').width();

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
	return null;
})();

var currentBeehive = (function(){
	if (currentApiary !== null && handover.current_beehive){
		for(var i = 0; i < currentApiary.beehives.length; i++){
			if (currentApiary.beehives[i].id === handover.current_beehive.id){
				return currentApiary.beehives[i];
			}
		};
		return currentApiary.beehives[0];
	}
	return null;
})();

Vue.component('beehive', {
	props: ['beehive'],
	template: '#beehive',
	data: function(){
		return {

		};
	},
	computed: {
		beehivesCount: function(){
			return this.$parent.beehivesCount;
		},
		beehiveIndex: function(){
			return this.$parent.apiary.beehives.indexOf(this.beehive);
		},
		isActive: function(){
			return this.beehive === this.$parent.currentBeehive ? '#fece06' : '#dddddd';
		},
		isFirstInRow: function(){
			return this.beehiveIndex % (Math.floor(this.$root.width/60.62)) === 0;
		},
		isĹastInRow: function(){
			return this.beehiveIndex % (Math.floor(this.$root.width/60.62)) === ((Math.floor(this.$root.width/60.62)) - 1);
		},
		inOddRow: function(){

			var numberOfColumns = Math.floor(this.$root.width/60.62);
			var numberOfRows = Math.ceil(this.beehivesCount/numberOfColumns);
			for(var i = 0; i < numberOfRows; i++){
				if(this.beehiveIndex >= (i * numberOfColumns) &&
				   this.beehiveIndex < ((i * numberOfColumns) + numberOfColumns)) {
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
			showModal: false	
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
				var beehiveIndex = this.apiary.beehives.indexOf(this.$root.selectedBeehive);
				this.apiary.removeBeehive(this.currentBeehive);
				console.log(this.apiary.beehives.length);
				var beehiveToActivate = beehiveIndex >= this.apiary.beehives.length ? beehiveIndex - 1 : beehiveIndex;
				this.$dispatch('activateBeehive', this.apiary.beehives[beehiveToActivate]);
			}
		}
	}
});

Vue.component('modal', {
    template: '#modal',
    props: [
    	'show',
    	'beehive'
    ],
    methods: {
    	saveInformation: function(){
    		console.log('saving');
    		var data = {
    			name: this.$parent.currentBeehive.name,
    			type: this.$parent.currentBeehive.type,
    			population: this.$parent.currentBeehive.colony.population,
    		};
    		var url = this.beehive.editor_route;
    		beehiveAjaxUpdate(data, url, 'POST');
    		this.show = false;
    	}
    }
});  




var app = new Vue({
	el: '#app',
	data: {
		apiaries: apiaries,
		selectedApiary: currentApiary,
		selectedBeehive: currentBeehive,
		width: windowWidth
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
		},
		'test': function(width){
			this.width = width;
		}
	}
});

$(window).on('resize', (event) => {
	var containerWidth = $('.content').width();
	app.$emit('test', containerWidth);
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
		//this.ajaxRequest(beehive, beehive.deleteRoute, 'POST')
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
			colony: model.colony,
			editorRoute: model.editor_route,
			deleteRoute: model.delete_route
		};
	}
}

