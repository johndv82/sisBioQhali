<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog"
         aria-labelledby="mediumModalLabel" aria-hidden="true" ref="modalEle">
        <div class="modal-dialog" :class="class_modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">{{ titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <slot name="mcontenido"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { Modal } from "bootstrap";

defineProps({
    titulo: {
        type: String,
        default: "Sin Titulo",
    },
    id: String,
    class_modal: {
        type: String,
        default: "modal-md"
    },
});

let modalEle = ref(null);
let thisModalObj = null;

onMounted(() => {
    thisModalObj = new Modal(modalEle.value);
});

function _show() {
    thisModalObj.show();
}

function _close(){
    thisModalObj.hide()
}

defineExpose({ show: _show, close: _close });
</script>
