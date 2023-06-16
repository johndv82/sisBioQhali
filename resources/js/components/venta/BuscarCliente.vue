<template>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Buscar Cliente</strong>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="dni" class="form-control-label">Documento:</label>
                        </div>  
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Número de Documento" v-model="buscar_documento"
                            :readonly="habilitar_autocomplete">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-secondary btn-sm mr-2" id="btnBuscarCliente"
                                @click="buscarCliente()" :disabled="habilitar_autocomplete">Buscar</button>
                            <button type="button" class="btn btn-success btn-sm" id="btnBuscarCliente"
                            @click="agregarCliente()">Nuevo</button>
                        </div>
                        <div class="col-md-3">
                            Búsqueda Dinámica
                            <label class="switch switch-3d switch-primary mr-3" >
                                <input type="checkbox" class="switch-input" v-model="habilitar_autocomplete" @click="cambiarTipoBusquedaCliente">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-2 align-self-center">
                            <label for="lblcliente" class="form-control-label">Cliente:</label>
                        </div>
                        <div class="col-md-10">
                            <div class="invalid-feedback d-block" v-if="venta_id_cliente == 0">El cliente es obligatorio.</div>
                            <input type="text" placeholder="Nombre Completo"
                                class="form-control" :readonly="!habilitar_autocomplete" v-model="buscar_nombre"
                                @focus="cambiarFocoNombreCliente" @blur="perderFocoNombreCliente" :class="{ 'is-invalid': (venta_id_cliente == 0) }">
                            <span class="select2-container select2-container--default select2-container--open" v-show="busquedaClientesDinamic">
                                <span class="select2-dropdown">
                                    <span class="select2-results">
                                        <ul class="select2-results__options" role="tree" id="select2-property-va-results" aria-expanded="true" aria-hidden="false">
                                            <li class="select2-results__option" role="treeitem" aria-selected="false" 
                                            v-for="cliente in busquedaClientesDinamic" :key="cliente.id_cli" @click="seleccionarCliente(cliente)">
                                                {{ cliente.nombrec_cli }}
                                            </li>
                                        </ul>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang='js'>
import { ref } from 'vue';

export default {
    name: 'BuscarCliente',
    data() {
        return {
            venta_id_cliente: 0,
            buscar_documento: '',
            buscar_nombre: '',
            habilitar_autocomplete: false,
            buscar_nombre_foco: false
        }
    },
    emits: ['agregar_cliente_trigger'],
    methods: {
        buscarCliente() {
            let self = this;
            if(this.buscar_documento.trim() != ''){
                axios.post(this.raiz + '/clientes/findbydocument/', { 'numero_documento': this.buscar_documento }).then(response => {
                    let cliente = response.data.data;
                    if (cliente == null) {
                        self.buscar_nombre = "";
                        self.$swal({
                            title: "Cliente no Encontrado.",
                            icon: 'warning',
                            iconColor: 'white',
                            color: 'white',
                            toast: true,
                            position: 'top-right',
                            background: '#f27474',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                    } else {
                        self.buscar_nombre = cliente.nombrec_cli;
                        self.venta_id_cliente = cliente.id_cli;
                        self.habilitar_autocomplete = false;
                    }
                });
            }
        },
        agregarCliente(){
            this.$emit('agregar_cliente_trigger');
        },
        cambiarTipoBusquedaCliente(){
            this.habilitar_autocomplete = !this.habilitar_autocomplete;
            this.buscar_documento = '';
            this.buscar_nombre = '';
            this.venta_id_cliente = 0;
        },
        seleccionarCliente(cliente){
            this.venta_id_cliente = cliente.id_cli;
            this.buscar_nombre = cliente.nombrec_cli;
            this.buscar_nombre_foco = false;
        },
        cambiarFocoNombreCliente(){
            if(this.habilitar_autocomplete == true){
                this.buscar_nombre_foco = true;
            }
        },
        perderFocoNombreCliente(){
            if(this.buscar_nombre == ""){
                this.venta_id_cliente = 0;
            }
        }
    },
    computed:{
        busquedaClientesDinamic(){
            if(this.habilitar_autocomplete == true){
                if (this.buscar_nombre === '' || this.buscar_nombre_foco == false) {
                    return []
                }
                let concidencias = 0
                return this.datos.filter(cliente => {
                    if (cliente.nombrec_cli.toLowerCase().includes(this.buscar_nombre.toLowerCase()) && concidencias < 10) {
                        concidencias++;
                        return cliente;
                    }
                });
            }
        }
    },
    props: {
        raiz: String,
        datos: Array,
    },
}
</script>

<style scoped>
</style>