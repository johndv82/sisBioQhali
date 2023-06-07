<template>
    <div class="modal-body">
        <form id="frmProveedor" autocomplete="off" onsubmit="return false;">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                               :class="{ 'is-invalid': v$.proveedor.nombre_prov.$error }"
                               v-model="v$.proveedor.nombre_prov.$model">
                        <div v-for="(error, index) of v$.proveedor.nombre_prov.$errors" :key="index">
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
                        <label for="contacto" class="form-control-label">Contacto:</label>
                        <input type="text" id="contacto" name="contacto" class="form-control"
                               :class="{ 'is-invalid': v$.proveedor.contacto_prov.$error }"
                               v-model="v$.proveedor.contacto_prov.$model">
                        <div v-for="(error, index) of v$.proveedor.contacto_prov.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.proveedor.codigo_prov.$error }"
                            v-model="v$.proveedor.codigo_prov.$model"
                            :readonly="v$.proveedor.codigo_prov.$model != '' && v$.proveedor.$model.id_prov != 0">
                        <div v-for="(error, index) of v$.proveedor.codigo_prov.$errors" :key="index">
                            <div class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ruc" class="form-control-label">R.U.C.:</label>
                        <input type="text" id="ruc" name="ruc" class="form-control"
                            :class="{ 'is-invalid': v$.proveedor.ruc_prov.$error }"
                            v-model="v$.proveedor.ruc_prov.$model"
                            :readonly="v$.proveedor.ruc_prov.$model != '' && v$.proveedor.$model.id_prov != 0">
                        <div v-for="(error, index) of v$.proveedor.ruc_prov.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.proveedor.domicilio_prov.$error }"
                            v-model="v$.proveedor.domicilio_prov.$model">
                        <div v-for="(error, index) of v$.proveedor.domicilio_prov.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.proveedor.telefono_prov.$error }"
                            v-model="v$.proveedor.telefono_prov.$model">
                        <div v-for="(error, index) of v$.proveedor.telefono_prov.$errors" :key="index">
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
                            :class="{ 'is-invalid': v$.proveedor.email_prov.$error }"
                            v-model="v$.proveedor.email_prov.$model">
                        <div v-for="(error, index) of v$.proveedor.email_prov.$errors" :key="index">
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

export default {
    name: "RegistroProveedor",
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            proveedor: {
                nombre_prov: {
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(200)),
                    validarNombreUnico: helpers.withMessage('El nombre ya existe, intente con otro.', this.validarNombreUnico)
                },
                contacto_prov: {
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(200))
                },
                codigo_prov:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(20))
                },
                ruc_prov:{
                    maxLength: helpers.withMessage('Longitud del campo es 11.', maxLength(11)),
                    minLength: helpers.withMessage('Longitud del campo es 11.', minLength(11)),
                    required: helpers.withMessage('Campo de ingreso obligatorio.', required),
                    numeric: helpers.withMessage('Campo de solo números', numeric),
                },
                domicilio_prov:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(200))
                },
                telefono_prov:{
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(20)),
                },
                email_prov:{
                    email: helpers.withMessage('E-mail inválido.', email),
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(150))
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
                let idproveedor = this.proveedor.id_prov;
                let peticion = null;
                if (idproveedor == 0) {
                    peticion = axios.post(this.raiz + '/proveedores/', this.proveedor)
                } else {
                    peticion = axios.put(this.raiz + '/proveedores/' + idproveedor, this.proveedor)
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
                if(valor.nombre_prov.trim().toUpperCase() == value.trim().toUpperCase() && valor.id_prov != this.proveedor.id_prov){
                    conteo++;
                }
                return conteo;
            }, 0);
            return cantidadDuplicados == 0;
        }
    },
    props: {
        raiz: String,
        proveedor: Object,
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