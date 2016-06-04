<template id="beehives">
	<a href="@{{ create }}" class="add-item">Adicionar colmeia</a>
	<beehive v-for="beehive in beehives" :beehive="beehive"></beehive>
</template>
@include('apiary.components.beehives.beehive')