<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Listado de Ventas</strong>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="nuevoRegistro">
                                    Nueva Venta
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dtInicio" class="col-sm-2 col-form-label">Filtrar desde: </label>
                            <div class="col-sm-3">
                                <VueDatePicker id="dtInicio"
                                    v-model="filtro_fecha_ini" 
                                    auto-apply 
                                    :close-on-auto-apply="true"
                                    :enable-time-picker="false"
                                    locale="es" 
                                    :format="formatDate"
                                    :clearable="false">
                                </VueDatePicker>
                            </div>
                            <label for="dtFin" class="col-sm-2 col-form-label">Hasta: </label>
                            <div class="col-sm-3">
                                <VueDatePicker id="dtFin"
                                    v-model="filtro_fecha_fin" 
                                    auto-apply 
                                    :close-on-auto-apply="true"
                                    :enable-time-picker="false"
                                    locale="es" 
                                    :format="formatDate"
                                    :clearable="false">
                                </VueDatePicker>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary" id="btnFiltrar" @click="filtrarVentas">
                                    Buscar
                                </button>
                            </div>
                        </div>
                        <ListaVenta
                            :datos="datos" 
                            @eliminar_trigger="eliminarVenta"
                            @verdetalle_trigger="verDetalleVenta">
                        </ListaVenta>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>
    <ModalLayout id="modalVerDetalleVenta" titulo="Detalle de Venta" ref="thisModal" class_modal="modal-lg">
        <template #mcontenido>
            <div class="modal-body">
                <div class="table-responsive table--no-card m-b-30">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th class="text-right" style="width: 5%;">Cant.</th>
                                <th style="width: 50%;">Descripción</th>
                                <th class="text-right" style="width: 25%;">Precio</th>
                                <th class="text-right" style="width: 20%;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in datos_detalle" :key="item.id_detven">
                                <td class="text-right">{{ item.cantidad_detven }}</td>
                                <td>{{ item.producto.nombre_prod }}</td>
                                <td class="text-right">{{ formatoNumero(item.precio_detven, "currency") }}</td>
                                <td class="text-right">{{ formatoNumero(item.cantidad_detven * item.precio_detven, "currency") }}</td>
                            </tr>
                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                <td></td><td></td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>SUB TOTAL: </strong>
                                </td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>{{ (total_datos_detalle - (total_datos_detalle * 0.18)).toFixed(2) }}</strong>
                                </td>
                            </tr>
                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                <td></td><td></td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>IGV (18%): </strong>
                                </td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>{{ (total_datos_detalle * 0.18).toFixed(2) }}</strong>
                                </td>
                            </tr>
                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                <td></td><td></td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>TOTAL: </strong>
                                </td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>{{ formatoNumero(total_datos_detalle, "currency") }}</strong>
                                </td>
                            </tr>
                            <tr class="table-info" v-show="datos_detalle.length > 0">
                                <td></td><td></td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>TOTAL Dscto. ({{ dscto_venta }}%): </strong>
                                </td>
                                <td class="text-right" style="width: 20%;">
                                    <strong>{{ formatoNumero(total_datos_detalle - (total_datos_detalle * (dscto_venta / 100)), "currency") }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import ListaVenta from "./ListaVenta.vue";
import { ref } from 'vue';
import axios from "axios";
import VueDatePicker from '@vuepic/vue-datepicker';
import ModalLayout from '../ModalLayout.vue'

export default {
    name: "VentaComponent",
    components: {MainLayout, ListaVenta, VueDatePicker, ModalLayout},
    data(){
        return{
            datos: ref([]),
            datos_detalle: ref([]),
            filtro_fecha_ini: new Date(),
            filtro_fecha_fin: new Date(),
            dscto_venta: 0
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            let req = {
                fecha_ini : this.filtro_fecha_ini,
                fecha_fin : this.filtro_fecha_fin
            }
            axios.post(this.raiz + '/ventas/list', req).then(response =>{
                self.datos = response.data.data;
            });
        },
        listDetalleVenta(id){
            let self = this;
            axios.get(this.raiz + '/ventas/listdetalle/' + id).then(response =>{
                self.datos_detalle = response.data.data;
            });
        },
        eliminarVenta(id){
            this.$swal({
            title: '¿Está seguro que desea eliminar el registro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    //Eliminar
                    let self = this;
                    axios.delete(this.raiz + '/ventas/' +id)
                    .then(response =>{
                        self.$swal({
                            title: response.data.msg,
                            icon: 'info',
                            iconColor: 'white',
                            color: 'white',
                            toast: true,
                            position: 'top-right',
                            background: '#3fc3ee',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                        self.listRegistros();
                    });
                }
            })
        },
        formatoNumero(n, tipo="decimal"){
            let numero = Math.round(n * 100) / 100;
            const formateado = numero.toLocaleString("es-PE", {
                style: tipo,
                currency: "PEN"
            });
            return formateado;
        },
        nuevoRegistro(){
            window.location.href = this.raiz + '/ventas/create';
        },
        filtrarVentas(){
            this.listRegistros();
        },
        verDetalleVenta(id, dscto){
            this.listDetalleVenta(id);
            this.abrirModal();
            this.dscto_venta = dscto;
        }
    },
    computed:{
        total_datos_detalle(){
            let importeTotal = 0;
            for (let i = 0; i < this.datos_detalle.length; i++) {
                let importe = this.datos_detalle[i].precio_detven * this.datos_detalle[i].cantidad_detven;
                importeTotal += importe;
            }
            return importeTotal;
        }
    },
    setup() {
        const date = ref(new Date());
        const formatDate = (date) => {
            const day = ('0'+ (date.getDate())).slice(-2);
            const month = ('0'+ (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        let thisModal= ref(null);
        function abrirModal(){
            thisModal.value.show();
        }

        function cerrarModal(){
            thisModal.value.close();
        }
        return {abrirModal, cerrarModal, thisModal, formatDate}
    },
    mounted() {
        this.listRegistros();
    },
    props:{
        raiz: String
    }
}
</script>

<style scoped>
</style>
