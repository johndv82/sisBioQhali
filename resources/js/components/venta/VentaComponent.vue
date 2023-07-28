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
import ListaVenta from "./ListaVenta.vue";
import { ref } from 'vue';
import axios from "axios";
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    name: "VentaComponent",
    components: {MainLayout, ListaVenta, VueDatePicker},
    data(){
        return{
            datos: ref([]),
            filtro_fecha_ini: new Date(),
            filtro_fecha_fin: new Date()
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
        nuevoRegistro(){
            window.location.href = this.raiz + '/ventas/create';
        },
        filtrarVentas(){
            this.listRegistros();
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
        return { formatDate }
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
