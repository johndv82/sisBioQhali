<template>
    <div class="modal-body">
        <form id="frmCategoria" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                               :class="{ 'is-invalid': v$.categoria.nombre_cat.$error }"
                               v-model="v$.categoria.nombre_cat.$model" >
                        <div v-for="(error, index) of v$.categoria.nombre_cat.$errors" :key="index">
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
                        <textarea rows="3" id="observaciones" name="observaciones" class="form-control"
                            :class="{ 'is-invalid': v$.categoria.obs_cat.$error }"
                            v-model="v$.categoria.obs_cat.$model"></textarea>
                        <div v-for="(error, index) of v$.categoria.obs_cat.$errors" :key="index">
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
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength, helpers } from '@vuelidate/validators'

export default {
    name: "RegistroCategoria",
    setup () {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            categoria: {
                nombre_cat: {
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    maxLength: helpers.withMessage('Límite de caracteres superado.', maxLength(100)),
                    validarNombreUnico: helpers.withMessage('El nombre ya existe, intente con otro.', this.validarNombreUnico)
                },
                obs_cat:{
                    maxLength: helpers.withMessage('Límite de caracteres superado.', maxLength(250))
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
                let idcategoria = this.categoria.id_cat;
                let peticion = null;
                if(idcategoria == 0){
                    peticion = axios.post(this.routebase, this.categoria)
                }else{
                    peticion = axios.put(this.routebase + '/' + idcategoria, this.categoria)
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
                if(valor.nombre_cat.trim().toUpperCase() == value.trim().toUpperCase() && valor.id_cat != this.categoria.id_cat){
                    conteo++;
                }
                return conteo;
            }, 0);
            return cantidadDuplicados == 0;
        }
    },
    props:{
        routebase: String,
        categoria: Object,
        datos: Array
    }
}
</script>
<style scoped>
#nombre{
    text-transform: uppercase;
}
#observaciones{
    resize: none;
}
</style>
