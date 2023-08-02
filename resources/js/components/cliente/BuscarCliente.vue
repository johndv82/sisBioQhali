<template>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Buscar Cliente</strong>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="dni" class="form-control-label">Documento:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Número de Documento" v-model="buscar_documento"
                        :readonly="habilitar_autocomplete">
                        <div class="input-group-btn">
                            <button id="btnBuscarCliente" class="btn btn-secondary" 
                            @click="buscarCliente()" :disabled="habilitar_autocomplete"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="align-self-end">
                        <label id="lblTipoBusqqueda" for="chkTipoBusqueda">
                            <label class="switch switch-3d switch-primary mr-3" >
                                <input id="chkTipoBusqueda" type="checkbox" class="switch-input" v-model="habilitar_autocomplete" @click="cambiarTipoBusquedaCliente">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                            Búsqueda Dinámica
                        </label>
                        <div class="float-right">
                            <span class="invalid-feedback d-inline" v-if="venta_id_cliente == 0">(*)Obligatorio</span>
                        </div>
                    </div>
                    <input type="text" placeholder="Nombre Completo" id="txtBuscarClienteNombre"
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
            <div class="row form-group">
                <div class="col-md-6">
                    <label class="form-control-label">Domicilio:</label>
                    <input type="text" class="form-control" v-model="domicilio" readonly="true">
                </div>
                <div class="col-md-4">
                    <label class="form-control-label">Membresia:</label>
                    <input type="text" class="form-control" v-model="membresia" readonly="true">
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="button" class="btn btn-success float-right" id="btnBuscarCliente"
                    @click="agregarCliente()">Nuevo</button>
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
            buscar_nombre_foco: false,
            domicilio: '',
            membresia: '',
            descuento_membresia: 0
        }
    },
    emits: ['agregar_cliente_trigger', 'buscar_cliente_trigger'],
    methods: {
        buscarCliente() {
            let self = this;
            if(this.buscar_documento.trim() != ''){
                axios.post(this.raiz + '/clientes/findbydocument/', { 'numero_documento': this.buscar_documento }).then(response => {
                    let cliente = response.data.data;
                    if (cliente == null) {
                        self.buscar_nombre = '';
                        self.domicilio = '';
                        self.membresia = '';
                        self.descuento_membresia = 0;
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
                        self.domicilio = cliente.domicilio_cli;
                        self.membresia = cliente.membresia.nombre_mem;
                        self.descuento_membresia = cliente.membresia.descuento_mem;
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
            this.domicilio = '';
            this.membresia = '';
            this.descuento_membresia = 0;
            this.venta_id_cliente = 0;
        },
        seleccionarCliente(cliente){
            this.venta_id_cliente = cliente.id_cli;
            this.buscar_nombre = cliente.nombrec_cli;
            this.domicilio = cliente.domicilio_cli;
            this.membresia = cliente.membresia.nombre_mem;
            this.descuento_membresia = cliente.membresia.descuento_mem;
            this.buscar_documento = cliente.numerodoc_cli;
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
    watch:{
        'venta_id_cliente'(new_id_cliente){
            this.$emit('buscar_cliente_trigger', new_id_cliente, this.descuento_membresia);
        }
    },
    props: {
        raiz: String,
        datos: Array,
    },
}
</script>

<style scoped>
.form-group {
    margin-bottom: 5px !important;
}
#txtBuscarClienteNombre{
    text-transform: uppercase;
}
</style>