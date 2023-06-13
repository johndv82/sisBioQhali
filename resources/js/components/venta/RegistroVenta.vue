<template>
    <MainLayout>
        <template #mbody>
            <form id="frmVenta" autocomplete="off" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-8">
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
                                                <input type="text" class="form-control" placeholder="Número de Documento" v-model="bc.buscar_documento"
                                                :readonly="bc.habilitar_autocomplete">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-secondary btn-sm mr-2" id="btnBuscarCliente"
                                                    @click="buscarCliente()" :disabled="bc.habilitar_autocomplete">Buscar</button>
                                                <button type="button" class="btn btn-success btn-sm" id="btnBuscarCliente"
                                                @click="agregarCliente()">Nuevo</button>
                                            </div>
                                            <div class="col-md-3">
                                                Búsqueda Dinámica
                                                <label class="switch switch-3d switch-primary mr-3" >
                                                    <input type="checkbox" class="switch-input" v-model="bc.habilitar_autocomplete" @click="cambiarTipoBusquedaCliente">
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
                                                <div class="invalid-feedback d-block" v-if="venta.idcliente_ven == 0">El cliente es obligatorio.</div>
                                                <input type="text" placeholder="Nombre Completo"
                                                    class="form-control" :readonly="!bc.habilitar_autocomplete" v-model="bc.buscar_nombre"
                                                    @focus="cambiarFocoNombreCliente" :class="{ 'is-invalid': (venta.idcliente_ven == 0) }">
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
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Comprobante</strong>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="dni" class="form-control-label">Número de Comprobante:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="numero_comprobante" name="numero_comprobante"
                                                    class="form-control" placeholder="000">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="dni" class="form-control-label">Serie:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="serie" name="serie" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <BuscarProducto :raiz="raiz" @agregar_detalle_trigger="agregarDetalle">
                        </BuscarProducto>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="cancelar()">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnRegistrar">Guardar</button>
                    </div>
                </div>
            </form>
        </template>
    </MainLayout>
    <ModalLayout id="modalRegistroCliente" titulo="Registro de Nuevo Cliente" ref="thisModal">
        <template #mcontenido>
            <RegistroCliente :raiz="raiz" :datos="datos_cliente" :id_cliente="id_cliente"
                @refresh-table="retornoModalCliente">
            </RegistroCliente>
        </template>
    </ModalLayout>
</template>

<script lang="js">
import MainLayout from "../MainLayout.vue";
import ModalLayout from "../ModalLayout.vue";
import RegistroCliente from "../cliente/RegistroCliente.vue";
import BuscarProducto from "./BuscarProducto.vue"
import useVuelidate from '@vuelidate/core'
import { ref } from 'vue';
import { required, maxLength, minLength, helpers, minValue, email, numeric } from '@vuelidate/validators'
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "RegistroVenta",
    components: { VueNumeric, MainLayout, ModalLayout, RegistroCliente, BuscarProducto},
    data() {
        return {
            venta: {
                idcliente_ven: 0,
                numerocomp_ven: '',
                seriecomp_ven: 0,
                tipocomp_ven: 0,
                total_ven: 0,
                subtotal_ven: 0,
                igv_ven: 0,
                valorigv_ven: 0,
                dscto_ven: 0,
                fecha_ven: new Date(1900, 0, 1),
                obs_ven: 0
            },
            bc:{ //busqueda_cliente
                buscar_documento: '',
                buscar_nombre: '',
                habilitar_autocomplete: false,
                buscar_nombre_foco: false
            },
            bp:{ //busqueda_producto

            },
            datos_cliente: ref([]),
            datos_producto: ref([]),
            id_cliente: -1
        }
    },
    validations() {
        return {
            venta: {
            }
        }
    },
    created(){
        //Obtener datos de clientes para autocomplete y también para enviar al componente RegistroCliente como propiedad
        let self = this;
        axios.get(this.raiz + '/clientes/list').then(response => {
            self.datos_cliente = response.data.data;
        });
    },
    methods: {
        buscarCliente() {
            let self = this;
            if(this.bc.buscar_documento.trim() != ''){
                axios.post(this.raiz + '/clientes/findbydocument/', { 'numero_documento': this.bc.buscar_documento }).then(response => {
                    let cliente = response.data.data;
                    if (cliente == null) {
                        self.bc.buscar_nombre = "";
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
                        self.bc.buscar_nombre = cliente.nombrec_cli;
                        self.venta.idcliente_ven = cliente.id_cli;
                    }
                });
            }
        },
        agregarCliente() {
            this.id_cliente = 0;
            this.abrirModal();
        },
        retornoModalCliente() {
            //Cerrar el Modal
            this.cerrarModal();
        },
        cancelar() {
            //this.v$.$reset()
        },
        cambiarTipoBusquedaCliente(){
            this.bc.habilitar_autocomplete = !this.bc.habilitar_autocomplete;
            this.bc.buscar_documento = '';
            this.bc.buscar_nombre = '';
            this.venta.idcliente_ven = 0;
        },
        seleccionarCliente(cliente){
            this.venta.idcliente_ven = cliente.id_cli;
            this.bc.buscar_nombre = cliente.nombrec_cli;
            this.bc.buscar_nombre_foco = false;
        },
        cambiarFocoNombreCliente(){
            if(this.bc.habilitar_autocomplete == true){
                this.bc.buscar_nombre_foco = true;
            }
        },
        agregarDetalle(det){
            console.log(det);
        }
    },
    computed:{
        busquedaClientesDinamic(){
            if (this.bc.buscar_nombre === '' || this.bc.buscar_nombre_foco == false) {
                return []
            }
            let concidencias = 0
            return this.datos_cliente.filter(cliente => {
                if (cliente.nombrec_cli.toLowerCase().includes(this.bc.buscar_nombre.toLowerCase()) && concidencias < 10) {
                    concidencias++;
                    return cliente;
                }
            });
        }
    },
    props: {
        raiz: String
    },
    setup() {
        let thisModal = ref(null);
        function abrirModal() {
            thisModal.value.show();
        }

        function cerrarModal() {
            thisModal.value.close();
        }
        return { abrirModal, cerrarModal, thisModal, v$: useVuelidate() }
    }
}
</script>
<style scoped>.form-group {
    margin-bottom: 3px !important;
}

#observaciones {
    resize: none;
}</style>
