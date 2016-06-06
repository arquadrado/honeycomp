<template id="apiary">
	<div class="beehives-container">
		<beehive v-for="beehive in apiary.beehives" :beehive="beehive"></beehive>
	</div>
	<div class="info-panel">
        <div class="create-beehive">
            <a class="add-item" href="@{{ apiary.create_beehive_route }}">+</a>
            <span>Adicionar colmeia</span>
        </div>
        <div class="beehive-info">
        	<div class="field-label field-display">
        		<label for="beehive-name">Nome</label>
        		<div class="field-info" id="beehive-name">@{{ currentBeehive.name }}</div>	
        	</div>
        	<div class="field-display">
        		<label for="field-label beehive-type">Tipo</label>
        		<div class="field-info" id="beehive-type">@{{ currentBeehive.type }}</div>	
        	</div>
        	<div class="beehive-editor">
        		<a href="@{{ currentBeehive.editorRoute }}">Editar</a>
        	</div>
        </div>
    </div>
</template>