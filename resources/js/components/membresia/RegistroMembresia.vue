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
                                :class="{ 'is-invalid': v$.membresia.obs_mem.$error }"
                                v-model="v$.membresia.obs_mem.$model"></textarea>
                        <div v-for="(error, index) of v$.membresia.obs_mem.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
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
import { required, maxValue, helpers, maxLength } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    components: { VueNumeric },
    name: "RegistroMembresia",
    setup () {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            membresia: {
                nombre_mem: {
                    required: helpers.withMessage('Campo de Ingreso es Obligatorio', required),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(100)),
                    validarNombreUnico: helpers.withMessage('El nombre ya existe, intente con otro.', this.validarNombreUnico)
                },
                monto_mem:{
                    maxValue: helpers.withMessage('Valor máximo es 99999.', maxValue(99999))
                },
                descuento_mem:{
                    maxValue: helpers.withMessage('Valor máximo es 99999.', maxValue(99999))
                },
                obs_mem:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(250))
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
        },
        validarNombreUnico(value){
            const cantidadDuplicados = this.datos.reduce((conteo, valor) =>{
                if(valor.nombre_mem.toUpperCase() == value.toUpperCase() && valor.id_mem != this.membresia.id_mem){
                    conteo++;
                }
                return conteo;
            }, 0);
            return cantidadDuplicados == 0;
        }
    },
    props:{
        routebase: String,
        membresia: Object,
        datos: Array
    }
}
</script>
<style scoped>
#nombre{
    text-transform: uppercase;
}
</style>
