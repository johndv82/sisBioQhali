<template>
    <MainLayout>
        <template #mbody>
            <form id="frmVenta" autocomplete="off" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-8">
                        <BuscarCliente :raiz="raiz" :datos="datos_cliente" 
                            @agregar_cliente_trigger="agregarCliente"
                            @buscar_cliente_trigger="buscarCliente">
                        </BuscarCliente>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Comprobante</strong>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Número:</label>
                                        <input type="text" id="numero_comprobante" name="numero_comprobante"
                                            class="form-control" placeholder="000">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Serie:</label>
                                        <input type="text" id="serie" name="serie" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Fecha:</label>
                                        <VueDatePicker 
                                            v-model="venta.fecha_ven" 
                                            auto-apply 
                                            :close-on-auto-apply="true"
                                            :enable-time-picker="false"
                                            locale="es" 
                                            :format="formatDate"
                                            :clearable="false">
                                        </VueDatePicker>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tipo" class="form-control-label">Tipo:</label>
                                        <input type="text" id="tipo" class="form-control" value="BOLETA" readonly="true">
                                    </div>
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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Detalle de Venta</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th class="text-right" style="width: 10%;">Cantidad</th>
                                                <th style="width: 50%;">Descripción</th>
                                                <th class="text-right" style="width: 20%;">Precio</th>
                                                <th class="text-right" style="width: 20%;">Importe</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in datos_detalle" :key="item.id_producto">
                                                <td class="text-right">{{ item.cantidad }}</td>
                                                <td>{{ item.descripcion }}</td>
                                                <td class="text-right">{{ item.preciov }}</td>
                                                <td class="text-right">{{ formatoNumero(item.cantidad * item.preciov) }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" @click="eliminarDetalle(item.id_producto)">Eliminar</button></td>
                                            </tr>
                                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                                <td></td><td></td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>TOTAL: </strong>
                                                </td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>{{ total_datos_detalle }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    @click="cancelar()">Cancelar</button>
                                <button type="button" class="btn btn-primary float-right" id="btnRegistrar"
                                    :class="{'disabled': !producto_cliente_select}" 
                                    :disabled="!producto_cliente_select"
                                    @click="guardar()">
                                    Guardar</button>
                            </div>
                        </div>
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
            datos_detalle: [],
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
        buscarCliente(new_id){
            this.venta.idcliente_ven = new_id;
        },
        retornoModalCliente() {
            //Cerrar el Modal y actualizar datos de cliente para el autocomplete
            this.cerrarModal();
            this.cargarDatosCliente();
        },
        cancelar() {
            //this.v$.$reset()
            window.location.href = this.raiz + '/ventas';
        },
        agregarDetalle(det){
            this.datos_detalle.push(det);
            this.datos_detalle = this.agruparArrayDetalle(this.datos_detalle);
        },
        agruparArrayDetalle(arreglo){
            var helper = {};
            var result = arreglo.reduce(function(r, o) {
            var key = o.id_producto;
            
            if(!helper[key]) {
                helper[key] = Object.assign({}, o);
                r.push(helper[key]);
            } else {
                helper[key].cantidad += o.cantidad;
            }
            return r;
            }, []);
            return result;
        },
        formatoNumero(n, tipo="decimal"){
            let numero = Math.round(n * 100) / 100;
            const formateado = numero.toLocaleString("es-PE", {
                style: tipo,
                currency: "PEN"
            });
            return formateado;
        },
        eliminarDetalle(id){
            const index = this.datos_detalle.findIndex(item => item.id_producto === id);
            if (index !== -1) {
                this.datos_detalle.splice(index, 1);
            }
        },
        guardar(){ //Guardar Venta

        }
    },
    computed:{
        total_datos_detalle(){
            let importeTotal = 0;
            for (let i = 0; i < this.datos_detalle.length; i++) {
                let importe = this.datos_detalle[i].preciov * this.datos_detalle[i].cantidad;
                importeTotal += importe;
            }
            return this.formatoNumero(importeTotal, "currency");
        },
        producto_cliente_select(){
            let valid = false;
            valid = (this.datos_detalle.length > 0) ? true : false;
            valid = (this.venta.idcliente_ven > 0) ? true : false;
            return valid;
        }
    },
    props: {
        raiz: String
    },
    setup() {
        const date = ref(new Date());
        const formatDate = (date) => {
            const day = ('0'+ (date.getDate())).slice(-2);
            const month = ('0'+ (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        let thisModal = ref(null);
        function abrirModal() {
            thisModal.value.show();
        }

        function cerrarModal() {
            thisModal.value.close();
        }
        return { abrirModal, cerrarModal, thisModal, v$: useVuelidate(), formatDate }
    }
}
</script>
<style scoped>
.form-group {
    margin-bottom: 5px !important;
}
.table-data3 tbody td{
    font-size: 16px;
}
</style>
