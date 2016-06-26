<template id="apiary">
	<div class="beehives-container">
		<beehive v-for="beehive in apiary.beehives" :beehive="beehive"></beehive>
	</div>
	<div class="info-panel">
        <div class="create-beehive">
            <a class="add-item" href="@{{ apiary.create_beehive_route }}">+</a>
            <span>Adicionar colmeia</span>
        </div>
        <div class="beehive-info" v-if="currentBeehive">
        	<div class="field-display">
        		<label for="beehive-name">Nome</label>
        		<div class="field-info" id="beehive-name">@{{ currentBeehive.name }}</div>	
        	</div>
        	<div class="field-display">
        		<label for="field-label beehive-type">Tipo</label>
        		<div class="field-info" id="beehive-type">@{{ currentBeehive.type }}</div>	
        	</div>
            <div class="field-display">
                <label for="field-label beehive-population">População da colónia</label>
                <div class="field-info" id="beehive-population">@{{ currentBeehive.colony.population }}</div>  
            </div>
            <div class="field-display">
                <label for="field-label beehive-colony-formation">Data de formação da colónia</label>
                <div class="field-info" id="beehive-type">@{{ currentBeehive.type }}</div>  
            </div>
        	<div class="beehive-settings">
        		<a class="link"  @click="showModal = true"><i class="fa fa-eye" aria-hidden="true"></i>Detalhes</a>
                <a class="link" href="@{{ currentBeehive.editorRoute }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a>
                <a class="link" @click="deleteBeehive"><i class="fa fa-trash" aria-hidden="true"></i>Apagar</a>
        	</div>
        </div>
    </div>
    <modal :show.sync="showModal" :beehive.sync="currentBeehive">
        <div slot="body" v-if="currentBeehive !== null">
            <div class="field">
                <label for="name">Nome</label>
                <input type="text" name="name" v-model="currentBeehive.name" value="@{{ currentBeehive.name }}">
            </div>
            <div class="field">
                <label for="name">Tipo</label>
                <input type="text" name="type" v-model="currentBeehive.type" value="@{{ currentBeehive.type }}">
            </div>
            <div class="field">
                <label for="population">População</label>
                <input type="text" name="population" v-model="currentBeehive.colony.population" value="@{{ currentBeehive.colony.population }}">
            </div>
        </div>
    </modal>
</template>