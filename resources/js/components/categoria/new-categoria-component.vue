<template>
    <ModalLayout :id=id titulo="Registro de Nueva Categoria">
        <template #mbody>
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
        </template>
        <template #mfooter>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelar()">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnRegistrar" @click="guardar()">Guardar</button>
        </template>
    </ModalLayout>
</template>

<script lang="js">
import ModalLayout from '../ModalLayout.vue'
import useVuelidate from '@vuelidate/core'
import { required, minLength, maxLength, helpers } from '@vuelidate/validators'
import {datos} from './datos.js'

export default {
    name:"NewCategoria",
    components:{
        ModalLayout
    },
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
    methods:{
        guardar() {      
            this.v$.$validate()
            if (!this.v$.$error) {
                let ruta = this.list;
                axios.post(this.store, this.categoria)
                .then(function (response) {
                    //refresh repository reactivo
                    axios.get(ruta).then(resp => {
                        datos.categoriaRepo = resp.data.data;
                        console.log(datos.categoriaRepo);
                    });
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
        id: String,
        store: String,
        list: String
    }
}
</script>

<style>
</style>
