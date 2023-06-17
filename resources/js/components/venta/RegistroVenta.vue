<template>
    <MainLayout>
        <template #mbody>
            <form id="frmVenta" autocomplete="off" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-8">
                        <BuscarCliente :raiz="raiz" :datos="datos_cliente" @agregar_cliente_trigger="agregarCliente">
                        </BuscarCliente>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Comprobante</strong>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="dni" class="form-control-label">Número:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="numero_comprobante" name="numero_comprobante"
                                                    class="form-control" placeholder="000">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="dni" class="form-control-label">Serie:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="serie" name="serie" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <VueDatePicker 
                                        v-model="venta.fecha_ven" 
                                        auto-apply 
                                        :close-on-auto-apply="true"
                                        :enable-time-picker="false"
                                        locale="es">
                                    </VueDatePicker>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <BuscarProducto :raiz="raiz" @agregar_detalle_trigger="agregarDetalle">
                        </BuscarProducto>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="cancelar()">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnRegistrar">Guardar</button>
                    </div>
                </div>
            </form>
        </template>
    </MainLayout>
    <ModalLayout id="modalRegistroCliente" titulo="Registro de Nuevo Cliente" ref="thisModal">
        <template #mcontenido>
            <RegistroCliente :raiz="raiz" :datos="datos_cliente" :id_cliente="id_cliente"
                @refresh-table="retornoModalCliente">
            </RegistroCliente>
        </template>
    </ModalLayout>
</template>

<script lang="js">
import MainLayout from "../MainLayout.vue";
import ModalLayout from "../ModalLayout.vue";
import RegistroCliente from "../cliente/RegistroCliente.vue";
import BuscarProducto from "./BuscarProducto.vue"
import BuscarCliente from './BuscarCliente.vue'
import useVuelidate from '@vuelidate/core'
import { ref } from 'vue';
import { required, maxLength, minLength, helpers, minValue, email, numeric } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    name: "RegistroVenta",
    components: { VueNumeric, MainLayout, ModalLayout, RegistroCliente, BuscarProducto, BuscarCliente, VueDatePicker},
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
                fecha_ven: new Date(),
                obs_ven: 0
            },
            datos_cliente: ref([]),
            id_cliente: -1
        }
    },
    validations() {
        return {
            venta: {
            }
        }
    },
    created(){
        this.cargarDatosCliente();
    },
    methods: {
        cargarDatosCliente(){
            //Obtener datos de clientes para autocomplete y también para enviar al componente RegistroCliente como propiedad
            let self = this;
            axios.get(this.raiz + '/clientes/list').then(response => {
                self.datos_cliente = response.data.data;
            });
        },
        agregarCliente() {
            this.id_cliente = 0;
            this.abrirModal();
        },
        retornoModalCliente() {
            //Cerrar el Modal y actualizar datos de cliente para el autocomplete
            this.cerrarModal();
            this.cargarDatosCliente();
        },
        cancelar() {
            //this.v$.$reset()
        },
        agregarDetalle(det){
            console.log(det);
        }
    },
    computed:{
    },
    props: {
        raiz: String
    },
    setup() {
        let thisModal = ref(null);
        function abrirModal() {
            thisModal.value.show();
        }

        function cerrarModal() {
            thisModal.value.close();
        }
        return { abrirModal, cerrarModal, thisModal, v$: useVuelidate() }
    }
}
</script>
<style scoped>

</style>
