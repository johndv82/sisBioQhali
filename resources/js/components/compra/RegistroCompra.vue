<template>
    <MainLayout>
        <template #mbody>
            <form id="frmVenta" autocomplete="off" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-8">
                        <BuscarProveedor :raiz="raiz" :datos="datos_proveedor" 
                            @buscar_proveedor_trigger="buscarProveedor">
                        </BuscarProveedor>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Comprobante</strong>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Serie:</label>
                                        <div class="float-right">
                                            <span class="invalid-feedback d-inline">{{ validateSerie }}</span>
                                        </div>
                                        <vue-numeric id="serie_comprobante" class="form-control" 
                                            v-model="compra.seriecomp_com"
                                            separator="," :precision="0">
                                        </vue-numeric>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dni" class="form-control-label">Número:</label>
                                        <div class="float-right">
                                            <span class="invalid-feedback d-inline">{{ validateNumero  }}</span>
                                        </div>
                                        <vue-numeric id="numero_comprobante" class="form-control" 
                                            v-model="compra.numerocomp_com"
                                            separator="," :precision="0">
                                        </vue-numeric>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="dni" class="form-control-label">Fecha:</label>
                                        <VueDatePicker 
                                            v-model="compra.fecha_com" 
                                            auto-apply 
                                            :close-on-auto-apply="true"
                                            :enable-time-picker="false"
                                            locale="es" 
                                            :format="formatDate"
                                            :clearable="false">
                                        </VueDatePicker>
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
                                <strong class="card-title">Detalle de Compra</strong>
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
                                                <td class="text-right">{{ formatoNumero(item.precioc, "currency") }}</td>
                                                <td class="text-right">{{ formatoNumero(item.cantidad * item.precioc, "currency") }}</td>
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
                                                v-model="compra.obs_com"></textarea>
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
</template>

<script lang="js">
import MainLayout from "../MainLayout.vue";
import BuscarProducto from "../producto/BuscarProducto.vue"
import BuscarProveedor from '../proveedor/BuscarProveedor.vue'
import { ref } from 'vue';
import VueNumeric from '@handcrafted-market/vue3-numeric';
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    name: "RegistroCompra",
    components: { VueNumeric, MainLayout, BuscarProducto, BuscarProveedor, VueDatePicker},
    data() {
        return {
            compra: {
                idproveedor_com: 0,
                seriecomp_com: 0,
                numerocomp_com: 0,
                fecha_com: new Date(),
                obs_com: ''
            },
            datos_detalle: [],
            datos_proveedor: ref([])
        }
    },
    created(){
        this.cargarDatosProveedor();
    },
    methods: {
        cargarDatosProveedor(){
            //Obtener datos de proveedores para autocomplete
            let self = this;
            axios.get(this.raiz + '/proveedores/list').then(response => {
                self.datos_proveedor = response.data.data;
            });
        },
        buscarProveedor(new_id){
            this.compra.idproveedor_com = new_id;
        },
        cancelar() {
            window.location.href = this.raiz + '/compras';
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
        guardar(){ //Guardar Compra
            let self = this;
            let peticion = null;
            this.compra['detalle_compra'] = this.datos_detalle;
            peticion = axios.post(this.raiz + '/compras/', this.compra)

            peticion.then(function (response) {
                if(response.data.code == 200){
                    self.$swal({
                        title: "Éxito",
                        text: "Compra Registrada Correctamente",
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result)=>{
                        if (result.isConfirmed) {
                            //Redirigir a Consulta de Compras
                            window.location.href = self.raiz + '/compras/';
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
                let importe = this.datos_detalle[i].precioc * this.datos_detalle[i].cantidad;
                importeTotal += importe;
            }
            return importeTotal;
        },
        producto_cliente_select(){
            return (this.datos_detalle.length > 0) && 
                    (this.compra.idproveedor_com > 0) && 
                    (this.validateNumero == "") && (this.validateSerie == "");
        },
        validateSerie(){
            return (this.compra.seriecomp_com > 0) ? "": "(*)Oblig.";
        },
        validateNumero(){
            return (this.compra.numerocomp_com > 0 ) ? "": "(*)Oblig.";
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
        return {formatDate }
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
