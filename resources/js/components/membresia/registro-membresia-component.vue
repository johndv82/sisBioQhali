<template>
    <div class="modal-body">
        <form id="frmMembresia" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                               :class="{ 'is-invalid': v$.membresia.nombre_mem.$error }"
                               v-model="v$.membresia.nombre_mem.$model">
                        <div v-for="(error, index) of v$.membresia.nombre_mem.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="monto" class="form-control-label">Monto:</label>
                        <vue-numeric id="monto" name="monto" class="form-control" 
                            :class="{ 'is-invalid': v$.membresia.monto_mem.$error }"
                            v-model="v$.membresia.monto_mem.$model"
                            separator="," :precision="0">
                        </vue-numeric>
                        <div v-for="(error, index) of v$.membresia.monto_mem.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="monto" class="form-control-label">Descuento:</label>
                        <vue-numeric id="monto" name="monto" class="form-control" 
                            :class="{ 'is-invalid': v$.membresia.descuento_mem.$error }"
                            v-model="v$.membresia.descuento_mem.$model"
                            separator="," :precision="0">
                        </vue-numeric>
                        <div v-for="(error, index) of v$.membresia.descuento_mem.$errors" :key="index">
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
                                  v-model="membresia.obs_mem"></textarea>
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
import { required, minValue, helpers } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    components: { VueNumeric },
    name: "RegistroMembresiaComponent",
    setup () {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            membresia: {
                nombre_mem: {
                    required: helpers.withMessage('Nombre de Membresia es Obligatorio', required),
                },
                monto_mem:{
                    minValue: helpers.withMessage('Valor m??nimo es 1.', minValue(1))
                },
                descuento_mem:{
                    minValue: helpers.withMessage('Valor m??nimo es 1.', minValue(1))
                },
            }
        }
    },
    emits: ["refresh-table"],
    methods:{
        guardar() {
            this.v$.$validate()
            if (!this.v$.$error) {
                let self = this;
                let idmembresia = this.membresia.id_mem;
                let peticion = null;
                if(idmembresia == 0){
                    peticion = axios.post(this.routebase, this.membresia)
                }else{
                    peticion = axios.put(this.routebase + '/' + idmembresia, this.membresia)
                }

                peticion.then(function (response) {
                    //Actualizar Tabla
                    self.$emit('refresh-table');
                    self.$swal({
                        title: response.data.msg,
                        icon: 'success',
                        iconColor: 'white',
                        color: 'white',
                        toast: true,
                        position: 'top-right',
                        background: '#62c429',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
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
        routebase: String,
        membresia: Object
    }
}
</script>
<style scoped>

</style>
