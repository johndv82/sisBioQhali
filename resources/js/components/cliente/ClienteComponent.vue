<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Listado de Clientes</strong>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="nuevoRegistro">
                                    Nuevo Cliente
                                </button>
                            </div>
                        </div>
                        <ListaCliente
                            :datos="datos" 
                            @editar_trigger="editarRegistro" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListaCliente>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroCliente" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroCliente
                :raiz="raiz"
                :id_cliente="id_cliente"
                :datos="datos"
                @refresh-table="cargarTableCliente">
            </RegistroCliente>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import RegistroCliente from "./RegistroCliente.vue";
import ListaCliente from "./ListaCliente.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue'
import axios from "axios";

export default {
    name: "ClienteComponent",
    components: {MainLayout, ListaCliente, RegistroCliente, ModalLayout},
    data(){
        return{
            titulomodal: '',
            datos: ref([]),
            membresia_list: [],
            id_cliente: -1
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            axios.get(this.raiz + '/clientes/list').then(response =>{
                self.datos = response.data.data;
            });
        },
        cargarTableCliente(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            this.listRegistros();
        },
        nuevoRegistro(){
            this.id_cliente = 0;
            this.titulomodal = 'Registro de Nuevo Cliente';
            this.abrirModal();
        },
        editarRegistro(id){
            this.id_cliente = id;
            this.titulomodal = 'Actualización de Cliente';
            this.abrirModal();
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
                    axios.delete(this.raiz + '/clientes/' +id)
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
        return {abrirModal, cerrarModal,thisModal}
    }
}
</script>

<style scoped>
</style>
