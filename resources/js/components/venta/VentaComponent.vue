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
                        <ListaVenta
                            :datos="datos" 
                            @eliminar_trigger="eliminarRegistro">
                        </ListaVenta>
                    </div>
                </div>
            </div>
        </template>
    </MainLayout>
</template>

<script lang="js">

import MainLayout from "../MainLayout.vue";
//import RegistroMembresia from "./RegistroMembresia.vue";
import ListaVenta from "./ListaVenta.vue";
import { ref } from 'vue';
import axios from "axios";

export default {
    name: "VentaComponent",
    components: {MainLayout, ListaVenta},
    data(){
        return{
            datos: ref([])
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
            //Refrescar DataTable
            this.listRegistros();
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
        },
        nuevoRegistro(){
            window.location.href = this.routebase + '/create';
        }
    },
    mounted() {
        this.listRegistros();
    },
    props:{
        routebase: String
    }
}
</script>

<style scoped>
</style>
