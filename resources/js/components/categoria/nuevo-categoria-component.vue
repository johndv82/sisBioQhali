<template>
    <ModalLayout>
        <template #mbody>
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" maxlength="250">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observaciones" class="form-control-label">Observaciones:</label>
                        <textarea rows="3" id="observaciones" name="observaciones" class="form-control" style="resize: none;" maxlength="500"></textarea>
                    </div>
                </div>
            </div>
        </template>
        <template #mfooter>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnRegistrar">Guardar</button>
        </template>
    </ModalLayout>
</template>

<script lang="js">
import ModalLayout from '../ModalLayout.vue';

export default {
    name:"nuevo-categoria-component",
    components:{
        ModalLayout
    },
    data(){
    },
    methods:{
    }
}
</script>

<style>
</style>
