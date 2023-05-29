<template>
    <div class="modal-body">
        <form id="frmCliente" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            :class="{ 'is-invalid': v$.cliente.nombrec_cli.$error }"
                            v-model="v$.cliente.nombrec_cli.$model">
                        <div v-for="(error, index) of v$.cliente.nombrec_cli.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.cliente.codigo_cli.$error }"
                            v-model="v$.cliente.codigo_cli.$model"
                            :disabled="v$.cliente.codigo_cli.$model != '' && v$.cliente.$model.id_cli != 0">
                        <div v-for="(error, index) of v$.cliente.codigo_cli.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="membresia" class="form-control-label">Membresia:</label>
                        <select name="membresia" id="membresia" class="form-control"
                            :class="{ 'is-invalid': v$.cliente.idmembresia_cli.$error }"
                            v-model="v$.cliente.idmembresia_cli.$model">
                            <option value="0">Seleccione</option>
                            <template v-for="item in membresia_list">
                                <option :value="item.id_mem" :selected="item.id_mem == cliente.idmembresia_cli">
                                    {{ item.nombre_mem }}
                                </option>
                            </template>
                        </select>
                        <div v-for="(error, index) of v$.cliente.idmembresia_cli.$errors" :key="index">
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
                        <label for="tipodoc" class="form-control-label">Tipo Doc.:</label>
                        <select name="tipodoc" id="tipodoc" class="form-control"
                            :class="{ 'is-invalid': v$.cliente.tipodoc_cli.$error }"
                            v-model="v$.cliente.tipodoc_cli.$model"
                            :disabled="v$.cliente.tipodoc_cli.$model != '' && v$.cliente.$model.id_cli != 0">
                            <option value="">Seleccione</option>
                            <option value="DNI">D.N.I.</option>
                            <option value="RUC">R.U.C.</option>
                            <option value="CE">C.E.</option>
                        </select>
                        <div v-for="(error, index) of v$.cliente.tipodoc_cli.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numerodoc" class="form-control-label">Número Doc.:</label>
                        <input type="text" id="numerodoc" name="numerodoc" class="form-control"
                            :class="{ 'is-invalid': v$.cliente.numerodoc_cli.$error }"
                            v-model="v$.cliente.numerodoc_cli.$model"
                            :disabled="v$.cliente.numerodoc_cli.$model != '' && v$.cliente.$model.id_cli != 0">
                        <div v-for="(error, index) of v$.cliente.numerodoc_cli.$errors" :key="index">
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
                        <label for="domicilio" class="form-control-label">Domicilio:</label>
                        <input type="text" id="domicilio" name="domicilio" class="form-control" 
                            :class="{ 'is-invalid': v$.cliente.domicilio_cli.$error }"
                            v-model="v$.cliente.domicilio_cli.$model">
                        <div v-for="(error, index) of v$.cliente.domicilio_cli.$errors" :key="index">
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
                        <label for="telefono" class="form-control-label">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" 
                            :class="{ 'is-invalid': v$.cliente.telefono_cli.$error }"
                            v-model="v$.cliente.telefono_cli.$model">
                        <div v-for="(error, index) of v$.cliente.telefono_cli.$errors" :key="index">
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
                        <label for="email" class="form-control-label">E-mail:</label>
                        <input type="text" id="email" name="email" class="form-control" 
                            :class="{ 'is-invalid': v$.cliente.email_cli.$error }"
                            v-model="v$.cliente.email_cli.$model">
                        <div v-for="(error, index) of v$.cliente.email_cli.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.cliente.obs_cli.$error }"
                            v-model="v$.cliente.obs_cli.$model"></textarea>
                        <div v-for="(error, index) of v$.cliente.obs_cli.$errors" :key="index">
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
import { required, maxLength, minLength, helpers, minValue, email, numeric } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "RegistroCliente",
    components: { VueNumeric },
    setup() {
        return { v$: useVuelidate() }
    },
    data(){
        return {
            length_numerodoc :0
        }
    },
    validations() {
        return {
            cliente: {
                nombrec_cli: {
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(200)),
                    validarNombreUnico: helpers.withMessage('El nombre ya existe, intente con otro.', this.validarNombreUnico)
                },
                codigo_cli:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(20))
                },
                tipodoc_cli:{
                    required: helpers.withMessage('Campo de selección obligatorio.', required)
                },
                numerodoc_cli:{
                    maxLength: helpers.withMessage('Longitud del campo es '+this.length_numerodoc+'.', maxLength(this.length_numerodoc)),
                    minLength: helpers.withMessage('Longitud del campo es '+this.length_numerodoc+'.', minLength(this.length_numerodoc)),
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    numeric: helpers.withMessage('Campo de solo números', numeric),
                },
                idmembresia_cli: {
                    minValue: helpers.withMessage('Campo de selección obligatorio.', minValue(1))
                },
                domicilio_cli:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(200))
                },
                telefono_cli:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(20)),
                },
                email_cli:{
                    email: helpers.withMessage('E-mail inválido.', email),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(150))
                },
                obs_cli:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(250))
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
                let idcliente = this.cliente.id_cli;
                let peticion = null;
                if (idcliente == 0) {
                    peticion = axios.post(this.routebase, this.cliente)
                } else {
                    peticion = axios.put(this.routebase + '/' + idcliente, this.cliente)
                }

                peticion
                .then(function (response) {
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
                }
                ).catch(function (error) {
                    console.log(error);
                });
            }
        },
        cancelar() {
            this.v$.$reset()
        },
        validarNombreUnico(value){
            const cantidadDuplicados = this.datos.reduce((conteo, valor) =>{
                if(valor.nombrec_cli.trim().toUpperCase() == value.trim().toUpperCase() && valor.id_cli != this.cliente.id_cli){
                    conteo++;
                }
                return conteo;
            }, 0);
            return cantidadDuplicados == 0;
        }
    },
    watch:{
        'cliente.tipodoc_cli'(new_value){
            if(new_value == "DNI"){
                this.length_numerodoc = 8;
            }else if (new_value == "RUC"){
                this.length_numerodoc = 11;
            }else{
                this.length_numerodoc = 12;
            }
        }
    },
    props: {
        routebase: String,
        cliente: Object,
        membresia_list: Array,
        datos: Array
    }
}
</script>
<style scoped>
.form-group {
    margin-bottom: 3px !important;
}
#codigo{
    text-transform: uppercase;
}
#nombre{
    text-transform: uppercase;
}
#observaciones{
    resize: none;
}
</style>
