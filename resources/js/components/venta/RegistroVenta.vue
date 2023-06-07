<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Nueva Venta</strong>
                    </div>
                    <div class="card-body">
                        <form id="frmVenta" autocomplete="off" onsubmit="return false;">
                            <div class="row form-group">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label for="dni" class="form-control-label">Cliente:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="dni" name="dni" class="form-control" placeholder="Número Documento"
                                            v-model="documento_cliente">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-secondary" id="btnBuscarCliente"
                                            @click="buscarCliente()">Buscar</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success" id="btnBuscarCliente"
                                            @click="agregarCliente()">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label for="lblcliente" class="form-control-label">Nombre:</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" id="nombre_cli" name="nombre_cli" class="form-control" readonly="true"
                                            v-model="nombre_cliente">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="obs_ven" class="form-control-label">Observaciones:</label>
                                        <textarea rows="3" id="obs_ven" name="obs_ven" class="form-control"
                                            :class="{ 'is-invalid': v$.venta.obs_ven.$error }"
                                            v-model="v$.venta.obs_ven.$model"></textarea>
                                        <div v-for="(error, index) of v$.venta.obs_ven.$errors" :key="index">
                                            <div class="invalid-feedback d-block">
                                                {{ error.$message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="cancelar()">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnRegistrar">Guardar</button>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>
    <ModalLayout id="modalRegistroCliente" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroCliente
                :raiz="raiz"
                :datos="datos_cliente"
                :id_cliente="id_cliente"
                @refresh-table="retornoModalCliente">
            </RegistroCliente>
        </template>
    </ModalLayout>
</template>

<script lang="js">
import MainLayout from "../MainLayout.vue";
import ModalLayout from "../ModalLayout.vue";
import RegistroCliente from "../cliente/RegistroCliente.vue";
import useVuelidate from '@vuelidate/core'
import { ref } from 'vue';
import { required, maxLength, minLength, helpers, minValue, email, numeric } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "RegistroVenta",
    components: { VueNumeric, MainLayout, ModalLayout, RegistroCliente},
    data() {
        return {
            venta: {
                idcliente_ven: 0,
                numerocomp_ven: '',
                seriecomp_ven: 0,
                tipocomp_ven: 0,
                total_ven: 0,
                subtotal_ven: 0,
                igv_ven: 0,
                valorigv_ven: 0,
                dscto_ven: 0,
                fecha_ven: new Date(1900, 0, 1),
                obs_ven: 0
            },
            datos_cliente: ref([]),
            titulomodal: '',
            membresia_list: [],
            detalle_venta: [],
            documento_cliente: '',
            nombre_cliente: '',
            nombre_producto: '',
            id_cliente: -1
        }
    },
    validations() {
        return {
            venta: {
                obs_ven: {
                    maxLength: helpers.withMessage('Limite de caracteres superado.', maxLength(250))
                }
            }
        }
    },
    methods: {
        buscarCliente(){
            let self = this;
            axios.post(this.raiz + '/clientes/findbydocument/', {'numero_documento': this.documento_cliente}).then(response =>{
                let cliente = response.data.data;
                if(cliente == null){
                    self.nombre_cliente = "";
                    self.$swal({
                        title: "Cliente no Encontrado.",
                        icon: 'warning',
                        iconColor: 'white',
                        color: 'white',
                        toast: true,
                        position: 'top-right',
                        background: '#f27474',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                }else{
                    self.nombre_cliente = cliente.nombrec_cli;
                }
            });
        },
        agregarCliente(){
            //Obtener datos de clientes para evaluar duplicidad
            let self = this;
            axios.get(this.raiz + '/clientes/list').then(response =>{
                self.datos_cliente = response.data.data;
            });
            this.id_cliente = 0;
            this.titulomodal = 'Registro de Nuevo Cliente';
            this.abrirModal();
        },
        retornoModalCliente(){
            //Cerrar el Modal
            this.cerrarModal();
        },
        cancelar() {
            //this.v$.$reset()
        }
    },
    props: {
        raiz: String
    },
    setup(){
        let thisModal= ref(null);
        function abrirModal(){
            thisModal.value.show();
        }

        function cerrarModal(){
            thisModal.value.close();
        }
        return {abrirModal, cerrarModal, thisModal, v$: useVuelidate()}
    }
}
</script>
<style scoped>
.form-group {
    margin-bottom: 3px !important;
}

#observaciones {
    resize: none;
}</style>
