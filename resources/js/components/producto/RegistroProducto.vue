<template>
    <div class="modal-body">
        <form id="frmProducto" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre/Descripción:</label>
                        <textarea rows="2" id="nombre" name="nombre" class="form-control" style="resize: none;" 
                            :class="{ 'is-invalid': v$.producto.nombre_prod.$error }"
                            v-model="v$.producto.nombre_prod.$model"></textarea>
                        <div v-for="(error, index) of v$.producto.nombre_prod.$errors" :key="index">
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
                        <label for="categoria" class="form-control-label">Categoria</label>
                        <select name="categoria" id="categoria" class="form-control"
                            :class="{ 'is-invalid': v$.producto.idcat_prod.$error }"
                            v-model="v$.producto.idcat_prod.$model">
                            <option value="0">Seleccione</option>
                            <template v-for="item in categoria_list">
                                <option :value="item.id_cat" :selected="item.id_cat == producto.idcat_prod">
                                    {{ item.nombre_cat }}
                                </option>
                            </template>
                        </select>
                        <div v-for="(error, index) of v$.producto.idcat_prod.$errors" :key="index">
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
                        <label for="codigo" class="form-control-label">Código:</label>
                        <input type="text" id="codigo" name="codigo" class="form-control" 
                            :class="{ 'is-invalid': v$.producto.codigo_prod.$error }"
                            v-model="v$.producto.codigo_prod.$model">
                        <div v-for="(error, index) of v$.producto.codigo_prod.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="puntos" class="form-control-label">Puntos:</label>
                        <vue-numeric id="puntos" name="puntos" class="form-control" 
                            :class="{ 'is-invalid': v$.producto.puntos_prod.$error }"
                            v-model="v$.producto.puntos_prod.$model"
                            separator="," :precision="2">
                        </vue-numeric>
                        <div v-for="(error, index) of v$.producto.puntos_prod.$errors" :key="index">
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
                        <label for="precioc" class="form-control-label">Precio Compra:</label>
                        <vue-numeric id="precioc" name="precioc" class="form-control" 
                            :class="{ 'is-invalid': v$.producto.precioc_prod.$error }"
                            v-model="v$.producto.precioc_prod.$model"
                            separator="," :precision="2" currency="S/.">
                        </vue-numeric>
                        <div v-for="(error, index) of v$.producto.precioc_prod.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="preciov" class="form-control-label">Precio Venta:</label>
                        <vue-numeric id="preciov" name="preciov" class="form-control" 
                            :class="{ 'is-invalid': v$.producto.preciov_prod.$error }"
                            v-model="v$.producto.preciov_prod.$model"
                            separator="," :precision="2" currency="S/.">
                        </vue-numeric>
                        <div v-for="(error, index) of v$.producto.preciov_prod.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.producto.obs_prod.$error }"
                            v-model="v$.producto.obs_prod.$model"></textarea>
                        <div v-for="(error, index) of v$.producto.obs_prod.$errors" :key="index">
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
import { required, maxLength, helpers, minValue, maxValue } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "RegistroProducto",
    components: { VueNumeric },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            producto: {
                nombre_prod: {
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(300)),
                },
                codigo_prod:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(20)),
                },
                idcat_prod: {
                    minValue: helpers.withMessage('Campo de selección obligatorio.', minValue(1))
                },
                puntos_prod:{
                    maxValue: helpers.withMessage('Valor máximo es 99999.', maxValue(99999))
                },
                precioc_prod:{
                    minValue: helpers.withMessage('Valor mínimo es 1.', minValue(1)),
                    maxValue: helpers.withMessage('Valor máximo es 10000.', maxValue(10000))
                },
                preciov_prod:{
                    minValue: helpers.withMessage('Valor mínimo es 1.', minValue(1)),
                    maxValue: helpers.withMessage('Valor mínimo es 10000.', maxValue(10000))
                },
                obs_prod:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(250)),
                }
            }
        }
    },
    emits: ["refresh-table"],
    methods: {
        guardar() {
            this.v$.$validate()
            if (!this.v$.$error) {
                let self = this;
                let idproducto = this.producto.id_prod;
                let peticion = null;
                if (idproducto == 0) {
                    peticion = axios.post(this.routebase, this.producto)
                } else {
                    peticion = axios.put(this.routebase + '/' + idproducto, this.producto)
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
        cancelar() {
            this.v$.$reset()
        }
    },
    props: {
        routebase: String,
        producto: Object,
        categoria_list: Array
    }
}
</script>
<style scoped>
.form-group {
    margin-bottom: 3px !important;
}
#codigo{
    text-transform:uppercase;
}
#observacion{
    resize: none;
}
</style>
