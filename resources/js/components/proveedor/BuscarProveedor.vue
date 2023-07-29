<template>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Buscar Proveedor</strong>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-md-5">
                    <label for="documento" class="form-control-label">Documento:</label>
                    <div class="input-group">
                        <input id="documento" type="text" class="form-control" placeholder="Número de RUC" v-model="buscar_documento"
                        :readonly="habilitar_autocomplete">
                        <div class="input-group-btn">
                            <button id="btnBuscarProveedor" class="btn btn-secondary" 
                            @click="buscarProveedor()" :disabled="habilitar_autocomplete">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="align-self-end">
                        <label id="lblTipoBusqqueda" for="chkTipoBusqueda">
                            <label class="switch switch-3d switch-primary mr-3" >
                                <input id="chkTipoBusqueda" type="checkbox" class="switch-input" v-model="habilitar_autocomplete" @click="cambiarTipoBusquedaProveedor">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                            Búsqueda Dinámica
                        </label>
                        <div class="float-right">
                            <span class="invalid-feedback d-inline" v-if="id_proveedor == 0">(*)Obligatorio</span>
                        </div>
                    </div>
                    <input type="text" placeholder="Nombre Completo" id="txtBuscarProveedorNombre"
                            class="form-control" :readonly="!habilitar_autocomplete" v-model="buscar_nombre"
                            @focus="cambiarFocoNombreProveedor" @blur="perderFocoNombreProveedor" :class="{ 'is-invalid': (id_proveedor == 0) }">
                    <span class="select2-container select2-container--default select2-container--open" v-show="busquedaProveedoresDinamic">
                        <span class="select2-dropdown">
                            <span class="select2-results">
                                <ul class="select2-results__options" role="tree" id="select2-property-va-results" aria-expanded="true" aria-hidden="false">
                                    <li class="select2-results__option" role="treeitem" aria-selected="false" 
                                    v-for="prov in busquedaProveedoresDinamic" :key="proveedor.id_prov" @click="seleccionarProveedor(prov)">
                                        {{ prov.nombre_prov }}
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
                <div class="col-md-6">
                    <label class="form-control-label">Contacto:</label>
                    <input type="text" class="form-control" v-model="contacto" readonly="true">
                </div>
            </div>
        </div>
    </div>
</template>

<script lang='js'>
import { ref } from 'vue';

export default {
    name: 'BuscarProveedor',
    data() {
        return {
            id_proveedor: 0,
            buscar_documento: '',
            buscar_nombre: '',
            habilitar_autocomplete: false,
            buscar_nombre_foco: false,
            domicilio: '',
            contacto: ''
        }
    },
    emits: ['buscar_proveedor_trigger'],
    methods: {
        buscarProveedor() {
            let self = this;
            if(this.buscar_documento.trim() != ''){
                axios.post(this.raiz + '/proveedores/findbyruc/', { 'numero_ruc': this.buscar_documento }).then(response => {
                    let proveedor = response.data.data;
                    if (proveedor == null) {
                        self.buscar_nombre = '';
                        self.domicilio = '';
                        self.contacto = '';
                        self.$swal({
                            title: "Proveedor no Encontrado.",
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
                        self.buscar_nombre = proveedor.nombre_prov;
                        self.domicilio = proveedor.domicilio_prov;
                        self.contacto = proveedor.contacto_prov;
                        self.id_proveedor = proveedor.id_prov;
                        self.habilitar_autocomplete = false;
                    }
                });
            }
        },
        cambiarTipoBusquedaProveedor(){
            this.habilitar_autocomplete = !this.habilitar_autocomplete;
            this.buscar_documento = '';
            this.buscar_nombre = '';
            this.domicilio = '';
            this.contacto = '';
            this.id_proveedor = 0;
        },
        seleccionarProveedor(proveedor){
            this.id_proveedor = proveedor.id_prov;
            this.buscar_nombre = proveedor.nombre_prov;
            this.domicilio = proveedor.domicilio_prov;
            this.contacto = proveedor.contacto_prov;
            this.buscar_documento = proveedor.ruc_prov;
            this.buscar_nombre_foco = false;
        },
        cambiarFocoNombreProveedor(){
            if(this.habilitar_autocomplete == true){
                this.buscar_nombre_foco = true;
            }
        },
        perderFocoNombreProveedor(){
            if(this.buscar_nombre == ""){
                this.id_proveedor = 0;
            }
        }
    },
    computed:{
        busquedaProveedoresDinamic(){
            if(this.habilitar_autocomplete == true){
                if (this.buscar_nombre === '' || this.buscar_nombre_foco == false) {
                    return []
                }
                let concidencias = 0
                return this.datos.filter(prov => {
                    if (prov.nombre_prov.toLowerCase().includes(this.buscar_nombre.toLowerCase()) && concidencias < 10) {
                        concidencias++;
                        return prov;
                    }
                });
            }
        }
    },
    watch:{
        'id_proveedor'(new_id_proveedor){
            this.$emit('buscar_proveedor_trigger', new_id_proveedor);
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
#txtBuscarProveedorNombre{
    text-transform: uppercase;
}
</style>