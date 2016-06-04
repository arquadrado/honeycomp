<template id="beehives">
	<div class="beehives-container">
		<beehive v-for="beehive in beehives" :beehive="beehive"></beehive>
	</div>
</template>
@include('apiary.components.beehives.beehive')