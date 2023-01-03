<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog"
         aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">{{ titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <mbody class="modal-body">
                    <slot name="mbody"></slot>
                </mbody>
                <mfooter class="modal-footer">
                    <slot name="mfooter"></slot>
                </mfooter>
            </div>
        </div>
    </div>
</template>

<script lang="js">
export default{
    name: "ModalLayout",
    props:{
        id: String,
        titulo: String,
    }
}
</script>
