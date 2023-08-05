<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Ventas Acumuladas</strong>
                    </div>
                    <div class="card-body">
                        <form id="frmAcumulado" autocomplete="off" onsubmit="return false;">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <BuscarCliente :raiz="raiz" :datos="datos_cliente" :display_btn_add="false"
                                        @agregar_cliente_trigger="agregarCliente"
                                        @buscar_cliente_trigger="buscarCliente">
                                    </BuscarCliente>
                                </div>
                            </div>
                        </form>
                        <ListaAcumulado
                            :datos="datos"
                            @procesar_acumulados="procesarAcumulados">
                        </ListaAcumulado>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>
    <ModalLayout id="modalProcesarAcumulados" titulo="Nueva Venta  con Acumulados" ref="thisModal">
        <template #mcontenido>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="serie_comprobante" class="form-control-label">Serie:</label>
                        <div class="float-right">
                            <span class="invalid-feedback d-inline">{{ validateSerie }}</span>
                        </div>
                        <vue-numeric id="serie_comprobante" class="form-control" 
                            v-model="seriecomp_ven"
                            separator="," :precision="0">
                        </vue-numeric>
                    </div>
                    <div class="col-md-6">
                        <label for="numero_comprobante" class="form-control-label">Número:</label>
                        <div class="float-right">
                            <span class="invalid-feedback d-inline">{{ validateNumero  }}</span>
                        </div>
                        <vue-numeric id="numero_comprobante" class="form-control" 
                            v-model="numerocomp_ven"
                            separator="," :precision="0">
                        </vue-numeric>
                    </div>
                </div>
            </div>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import ListaAcumulado from "./ListaAcumulado.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue';
import axios from "axios";
import BuscarCliente from "../cliente/BuscarCliente.vue";
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "AcumuladoComponent",
    components: {VueNumeric, MainLayout, ListaAcumulado, ModalLayout, BuscarCliente},
    data(){
        return{
            datos: ref([]),
            datos_cliente: ref([]),
            idcliente: -1,
            seriecomp_ven: 1,
            numerocomp_ven: 0
        }
    },
    mounted(){
        this.cargarDatosCliente();
    },
    methods:{
        cargarDatosCliente(){
            //Obtener datos de clientes para autocomplete y también para enviar al componente RegistroCliente como propiedad
            let self = this;
            axios.get(this.raiz + '/clientes/list').then(response => {
                self.datos_cliente = response.data.data;
            });
        },
        listRegistros(id_cliente){
            let self = this;
            axios.post(this.raiz + '/acumulados/list', {'idcliente': id_cliente}).then(response =>{
                self.datos = response.data.data;
            });
        },
        agregarCliente(){
        },
        buscarCliente(new_id, dscto_membresia){
            this.idcliente = new_id;
        },
        procesarAcumulados(ids){
            this.abrirModal();
        }
    },
    computed:{
        validateSerie(){
            return (this.seriecomp_ven > 0) ? "": "(*)Oblig.";
        },
        validateNumero(){
            return (this.numerocomp_ven > 0 ) ? "": "(*)Oblig.";
        }
    },
    props:{
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
        return {abrirModal, cerrarModal, thisModal}
    },
    watch:{
        'idcliente'(new_id_cliente){
            this.listRegistros(new_id_cliente);
        }
    },
}
</script>

<style scoped>
</style>
