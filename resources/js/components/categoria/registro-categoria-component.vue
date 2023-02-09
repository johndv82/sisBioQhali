<template>
    <div class="modal-body">
        <form id="frmCategoria" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                               :class="{ 'is-invalid': v$.categoria.nombre.$error }"
                               v-model="v$.categoria.nombre.$model">
                        <div v-for="(error, index) of v$.categoria.nombre.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observaciones" class="form-control-label">Observaciones:</label>
                        <textarea rows="3" id="observaciones" name="observaciones" class="form-control" style="resize: none;"
                                  v-model="categoria.observaciones"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelar()">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnRegistrar" @click="guardar()">Guardar</button>
    </div>
</template>

<script lang="js">
import useVuelidate from '@vuelidate/core'
import { required, minLength, maxLength, helpers } from '@vuelidate/validators'

export default {
    name: "RegistroCategoriaComponent",
    setup () {
        return { v$: useVuelidate() }
    },
    data(){
        return {
            categoria: {
                nombre: '',
                observaciones: '',
            }
        }
    },
    validations() {
        return {
            categoria: {
                nombre: {
                    required: helpers.withMessage('Nombre de Categoria es Obligatorio', required),
                }
            }
        }
    },
    emits: ["refresh-table"],
    methods:{
        guardar() {
            this.v$.$validate()
            if (!this.v$.$error) {
                let self = this;
                axios.post(this.routestore, this.categoria)
                .then(function (response) {
                    //Actualizar Tabla
                    self.$emit('refresh-table');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        cancelar(){
            this.v$.$reset()
        }
    },
    props:{
        routestore: String
    }
}
</script>
<style scoped>

</style>
