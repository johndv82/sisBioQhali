<template>
    <div class="modal fade" id="modalRegistroCategoria" tabindex="-1" role="dialog"
         aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <mbody>
                        <slot name="mbody"></slot>
                    </mbody>
                </div>
                <div class="modal-footer">
                    <mfooter>
                        <slot name="mfooter"></slot>
                    </mfooter>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="js">
export default{
    name: "ModalLayout",
    props:{
        nombre: String,
        titulo: String,
    }
}
</script>