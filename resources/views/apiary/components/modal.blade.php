<template id="modal">
<div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
         
        <div class="modal-container">
            <div class="my-modal-header">
                <slot name="header">
                @{{ data.name }}
                </slot>
            </div>
            
            <div class="my-modal-body">
                <slot name="body">
                default body
                </slot>
            </div>
            <div class="my-modal-footer">
                <slot name="footer">
                default footer
                </slot>
            </div>
            <div class="confirm-button">
                <button class="confirm-button" @click="show = false">Confirmar</button>
            </div>

            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="60.62px" height="70px" viewBox="0 0 60.62 70" enable-background="new 0 0 60.62 70" xml:space="preserve">
            <polygon points="60.621,52.5 30.311,70 0,52.5 0,17.5 30.311,0 60.621,17.5 "/>
            </svg>  
        </div>
    </div>
</div>
</template>