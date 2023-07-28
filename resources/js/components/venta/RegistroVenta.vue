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
                                <label class="form-check-label float-right"><input type="checkbox" id="chkAcumular" 
                                    v-model="acumulado"/> 
                                    Acumular Venta</label>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Serie:</label>
                                        <div class="float-right">
                                            <span class="invalid-feedback d-inline">{{ validateSerie }}</span>
                                        </div>
                                        <vue-numeric id="serie_comprobante" class="form-control" 
                                            v-model="venta.seriecomp_ven"
                                            separator="," :precision="0" :disabled="acumulado">
                                        </vue-numeric>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Número:</label>
                                        <div class="float-right">
                                            <span class="invalid-feedback d-inline">{{ validateNumero  }}</span>
                                        </div>
                                        <vue-numeric id="numero_comprobante" class="form-control" 
                                            v-model="venta.numerocomp_ven"
                                            separator="," :precision="0" :disabled="acumulado">
                                        </vue-numeric>
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
                                        {{venta.fecha_ven}}
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
                                                <td class="text-right">{{ formatoNumero(item.preciov, "currency") }}</td>
                                                <td class="text-right">{{ formatoNumero(item.cantidad * item.preciov, "currency") }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" @click="eliminarDetalle(item.id_producto)">Eliminar</button></td>
                                            </tr>
                                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                                <td></td><td></td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>SUB TOTAL: </strong>
                                                </td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>{{ (total_datos_detalle - (total_datos_detalle * 0.18)).toFixed(2) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                                <td></td><td></td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>IGV (18%): </strong>
                                                </td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>{{ (total_datos_detalle * 0.18).toFixed(2) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                                <td></td><td></td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>TOTAL: </strong>
                                                </td>
                                                <td class="text-right" style="width: 20%;">
                                                    <strong>{{ formatoNumero(total_datos_detalle, "currency") }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="observaciones" class="form-control-label">Observaciones:</label>
                                            <textarea rows="3" id="observaciones" class="form-control" 
                                                v-model="venta.obs_ven"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    @click="cancelar()">Cancelar</button>
                                
                                <button type="button" class="btn btn-primary float-right" id="btnRegistrar"
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
import VueNumeric from '@handcrafted-market/vue3-numeric';
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    name: "RegistroVenta",
    components: { VueNumeric, MainLayout, ModalLayout, RegistroCliente, BuscarProducto, BuscarCliente, VueDatePicker},
    data() {
        return {
            venta: {
                idcliente_ven: 0,
                seriecomp_ven: 1,
                numerocomp_ven: 0,
                tipocomp_ven: 0,
                total_ven: 0,
                subtotal_ven: 0,
                igv_ven: 0,
                valorigv_ven: 0,
                dscto_ven: 0,
                fecha_ven: new Date(),
                obs_ven: ''
            },
            datos_detalle: [],
            datos_cliente: ref([]),
            id_cliente: -1,
            acumulado: false
        }
    },
    created(){
        this.cargarNumeroComprobante();
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
        cargarNumeroComprobante(){
            //Obtenemos el número de comprobante próximo para el registro de la venta.
            let self = this;
            axios.get(this.raiz + '/ventas/getnumerocomp').then(response => {
                self.venta.numerocomp_ven = response.data.data;
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
            let self = this;
            let peticion = null;
            this.venta['detalle_venta'] = this.datos_detalle;
            peticion = axios.post(this.raiz + '/ventas/', this.venta)

            peticion.then(function (response) {
                if(response.data.code == 200){
                    self.$swal({
                        title: "Éxito",
                        text: "Venta Registrada Correctamente",
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result)=>{
                        if (result.isConfirmed) {
                            //Redirigir a Consulta de Ventas
                            window.location.href = self.raiz + '/ventas/';
                        }
                    });
                }else{
                    console.error(response.data.msg);
                }
            }).catch(function (error) {
                console.error(error);
            });
        }
    },
    computed:{
        total_datos_detalle(){
            let importeTotal = 0;
            for (let i = 0; i < this.datos_detalle.length; i++) {
                let importe = this.datos_detalle[i].preciov * this.datos_detalle[i].cantidad;
                importeTotal += importe;
            }
            return importeTotal;
        },
        producto_cliente_select(){
            return (this.datos_detalle.length > 0) && 
                    (this.venta.idcliente_ven > 0) && 
                    (this.validateNumero == "") && (this.validateSerie == "");
        },
        validateSerie(){
            if(!this.acumulado){
                return (this.venta.seriecomp_ven > 0) ? "": "(*)Oblig.";
            }else{
                return "";
            }
        },
        validateNumero(){
            if(!this.acumulado){
                if(!this.acumulado){
                    return (this.venta.numerocomp_ven > 0 ) ? "": "(*)Oblig.";
                }
            }else{
                return "";
            }
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
button:disabled{
    cursor: default;
}
</style>
