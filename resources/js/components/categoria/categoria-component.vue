<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Listado de Categorias</strong>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="abrirModal">Nueva Categoria</button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <TableCategoriaComponent :routelist="routelist" :datos="datos"></TableCategoriaComponent>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroCategoria" titulo="Registro de Nueva Categoria" ref="thisModal">
        <template #mcontenido>
            <RegistroCategoriaComponent :routestore="routestore" @refresh-table="cargarTableCategoria"></RegistroCategoriaComponent>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout";
import TableCategoriaComponent from "./table-categoria-component";
import RegistroCategoriaComponent from "./registro-categoria-component";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout'
import axios from "axios";

export default {
    name: "categoria-component",
    components: {MainLayout, TableCategoriaComponent, RegistroCategoriaComponent, ModalLayout},
    data(){
        return{
            NombreModal: 'modalRegistroCategoria',
            IdModal: '#modalRegistroCategoria',
            datos: ref([])
        }
    },
    methods:{
        cargarTableCategoria(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            let d = this;
            axios.get(this.routelist).then(response =>{
                d.datos = response.data.data;
            });
        },
        editarCategoria(){
            this.abrirModal();
        }
    },
    mounted() {
        this.cargarTableCategoria()
    },
    props:{
        routelist: String,
        routestore: String
    },
    setup(){
        let thisModal= ref(null);
        function abrirModal(){
            thisModal.value.show();
        }

        function cerrarModal(){
            thisModal.value.close();
        }
        return {abrirModal, cerrarModal,thisModal}
    }
}
</script>

<style scoped>

</style>
