<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Listado de Producto</strong>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="nuevoRegistro">
                                    Nuevo Producto
                                </button>
                            </div>
                        </div>
                        <ListaProducto
                            :datos="datos" 
                            @editar_trigger="editarRegistro" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListaProducto>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroProducto" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroProducto 
                :routebase="routebase"
                :routecategorias="routecategorias"
                :producto="producto"
                :datos="datos"
                @refresh-table="cargarTableProducto">
            </RegistroProducto>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import RegistroProducto from "./RegistroProducto.vue";
import ListaProducto from "./ListaProducto.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue'
import axios from "axios";

export default {
    name: "ProductoComponent",
    components: {MainLayout, ListaProducto, RegistroProducto, ModalLayout},
    data(){
        return{
            titulomodal: '',
            datos: ref([]),
            producto: {}
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            axios.get(this.routebase + '/list').then(response =>{
                self.datos = response.data.data;
            });
        },
        cargarTableProducto(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            this.listRegistros();
        },
        nuevoRegistro(){
            this.producto = {
                id_prod: 0,
                nombre_prod: '',
                codigo_prod: '',
                idcat_prod: 0,
                puntos_prod: 0,
                precioc_prod: 0,
                preciov_prod: 0,
                obs_prod: ''
            };
            this.titulomodal = 'Registro de Nuevo Producto';
            this.abrirModal();
        },
        editarRegistro(id){
            let self = this;
            axios.get(this.routebase + '/' +id).then(response =>{
                self.producto = response.data.data;
                self.titulomodal = 'Actualización de Producto';
                self.abrirModal();
            });
        },
        eliminarRegistro(id){
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
                    axios.delete(this.routebase + '/' +id)
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
        }
    },
    mounted() {
        this.listRegistros();
    },
    props:{
        routebase: String,
        routecategorias: String
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
