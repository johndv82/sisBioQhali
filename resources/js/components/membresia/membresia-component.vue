<template>
    <MainLayout>
        <template #mbody>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Listado de Membresias</strong>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary" id="btnNuevo" @click="nuevoRegistro">
                                    Nueva Membresia
                                </button>
                            </div>
                        </div>
                        <ListMembresiaComponent 
                            :datos="datos" 
                            @editar_trigger="editarRegistro" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListMembresiaComponent>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>

    <ModalLayout id="modalRegistroMembresia" :titulo="titulomodal" ref="thisModal">
        <template #mcontenido>
            <RegistroMembresiaComponent 
                :routebase="routebase"
                :membresia="membresia"
                @refresh-table="cargarTableMembresia">
            </RegistroMembresiaComponent>
        </template>
    </ModalLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
import RegistroMembresiaComponent from "./registro-membresia-component.vue";
import ListMembresiaComponent from "./list-membresia-component.vue";
import { ref } from 'vue';
import ModalLayout from '../ModalLayout.vue'
import axios from "axios";

export default {
    name: "membresia-component",
    components: {MainLayout, ListMembresiaComponent, RegistroMembresiaComponent, ModalLayout},
    data(){
        return{
            titulomodal: '',
            datos: ref([]),
            membresia : {}
        }
    },
    methods:{
        listRegistros(){
            let self = this;
            axios.get(this.routebase + '/list').then(response =>{
                self.datos = response.data.data;
            });
        },
        cargarTableMembresia(){
            //Cerrar el Modal y Refrescar DataTable
            this.cerrarModal();
            this.listRegistros();
        },
        nuevoRegistro(){
            this.membresia = {
                id_mem: 0,
                nombre_mem: '',
                monto_mem: 0,
                descuento_mem: 0,
                obs_mem: ''
            };
            this.titulomodal = 'Registro de Nueva Membresia';
            this.abrirModal();
        },
        editarRegistro(id){
            let self = this;
            axios.get(this.routebase + '/' +id).then(response =>{
                self.membresia = response.data.data;
            });
            this.titulomodal = 'Actualizaci??n de Membresia';
            this.abrirModal();
        },
        eliminarRegistro(id){
            this.$swal({
            title: '??Est?? seguro que desea eliminar el registro?',
            text: "??No podr??s revertir esto!",
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
