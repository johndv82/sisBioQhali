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
                        <ListClienteComponent 
                            :datos="datos" 
                            @editar_trigger="editarRegistro" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListClienteComponent>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroCliente" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroClienteComponent 
                :routebase="routebase"
                :cliente="cliente"
                :membresia_list="membresia_list"
                @refresh-table="cargarTableCliente">
            </RegistroClienteComponent>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import RegistroClienteComponent from "./registro-cliente-component.vue";
import ListClienteComponent from "./list-cliente-component.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue'
import axios from "axios";

export default {
    name: "clienteComponent",
    components: {MainLayout, ListClienteComponent, RegistroClienteComponent, ModalLayout},
    data(){
        return{
            titulomodal: '',
            datos: ref([]),
            cliente: {},
            membresia_list: []
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            axios.get(this.routebase + '/list').then(response =>{
                self.datos = response.data.data;
            });
        },
        cargarTableCliente(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            this.listRegistros();
        },
        nuevoRegistro(){
            this.cliente = {
                id_cli: 0,
                nombrec_cli: '',
                codigo_cli: '',
                tipodoc_cli: '',
                numerodoc_cli: '',
                domicilio_cli: '',
                telefono_cli: '',
                email_cli: '',
                membresia: {},
                obs_cli: ''
            };
            this.titulomodal = 'Registro de Nuevo Cliente';
            this.cargarMembresiasList();
            this.abrirModal();
        },
        cargarMembresiasList(){
            let self = this;
            axios.get(this.routemembresias + '/list').then(response =>{
                self.membresia_list = response.data.data;
            });
        },
        editarRegistro(id){
            let self = this;
            axios.get(this.routebase + '/' +id).then(response =>{
                self.cliente = response.data.data;
            });
            this.titulomodal = 'Actualización de Cliente';
            this.cargarMembresiasList();
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
        routemembresias: String
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
