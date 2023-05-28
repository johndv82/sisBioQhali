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
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="nuevoRegistro">
                                    Nueva Categoria
                                </button>
                            </div>
                        </div>
                        <ListaCategoria
                            :datos="datos" 
                            @editar_trigger="editarRegistro" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListaCategoria>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroCategoria" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroCategoria
                :routebase="routebase"
                :categoria="categoria"
                :datos="datos"
                @refresh-table="cargarTableCategoria">
            </RegistroCategoria>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import RegistroCategoria from "./RegistroCategoria.vue";
import ListaCategoria from "./ListaCategoria.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue'
import axios from "axios";

export default {
    name: "CategoriaComponent",
    components: { MainLayout, RegistroCategoria, ModalLayout, ListaCategoria },
    data(){
        return{
            titulomodal: '',
            datos: ref([]),
            categoria : {}
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            axios.get(this.routebase + '/list').then(response =>{
                self.datos = response.data.data;
            });
        },
        cargarTableCategoria(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            this.listRegistros();
        },
        nuevoRegistro(){
            this.categoria = {
                id_cat: 0,
                nombre_cat: '',
                codigo_cat: '',
                obs_cat: ''
            };
            this.titulomodal = 'Registro de Nueva Categoria';
            this.abrirModal();
        },
        editarRegistro(id){
            let self = this;
            axios.get(this.routebase + '/' +id).then(response =>{
                self.categoria = response.data.data;
                self.titulomodal = 'Actualización Categoria';
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
        routebase: String
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
