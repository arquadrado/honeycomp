<template id="settings">
    <div class="action">
            <a href="@{{ editor }}">Editar</a>
        </div>
        <div class="action" v-on:click="deleteApiary(apiary)">
            <a href="#">Apagar</a>
        </div>
</template>