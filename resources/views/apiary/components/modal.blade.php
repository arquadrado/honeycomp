<template id="modal">
<div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper" v-if="beehive !== null">
         
        <div class="modal-container">
            <div class="my-modal-header">
                <slot name="header">
                    <h3>Editar colmeia - @{{ beehive.name }}</h3>
                </slot>
            </div>
            
            <div class="my-modal-body">
                <slot name="body">
                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" name="name" v-model="name" value="@{{ beehive.name }}">
                    </div>
                    <div class="field">
                        <label for="name">Tipo</label>
                        <input type="text" name="type" value="@{{ beehive.type }}">
                    </div>
                    <div class="field">
                        <label for="population">População</label>
                        <input type="text" name="population" value="@{{ beehive.colony.population }}">
                    </div>
                </slot>
            </div>
            <div class="my-modal-footer">
                <slot name="footer">
                default footer
                </slot>
            </div>
            <div class="confirm-button">
                <button class="confirm-button" @click="saveInformation">Confirmar</button>
            </div>

            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="554.26px" height="640px" viewBox="0 0 554.26 640" enable-background="new 0 0 554.26 640" xml:space="preserve">
                <polygon fill="#FECE06" points="554.257,479.999 277.128,639.999 0,479.999 0,160 277.128,0 554.257,160 "/>
            </svg> 
        </div>
    </div>
</div>
</template>