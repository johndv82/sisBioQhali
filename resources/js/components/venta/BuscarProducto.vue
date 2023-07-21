<template>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Buscar Producto</strong>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-md-10">
                    <div class="form-group row">
                        <div class="col-md-12" style="display: inline-flex;">
                            Producto:&nbsp;
                            <span class="invalid-feedback d-flex" v-if="venta_id_producto == 0">(*)Obligatorio</span>
                        </div>
                    </div>
                    <input type="text" placeholder="Descripción"
                        class="form-control" v-model="buscar_nombre"
                        @focus="buscar_nombre_foco = true" @blur="perderFocoProducto" :class="{ 'is-invalid': (venta_id_producto == 0) }">
                    <span class="select2-container select2-container--default select2-container--open" v-show="busquedaProductoDinamic">
                        <span class="select2-dropdown">
                            <span class="select2-results">
                                <ul class="select2-results__options" role="tree" id="select2-property-va-results" aria-expanded="true" aria-hidden="false">
                                    <li class="select2-results__option" role="treeitem" aria-selected="false" 
                                    v-for="producto in busquedaProductoDinamic" :key="producto.id_prod" @click="seleccionarProducto(producto)">
                                        {{ producto.nombre_prod }}
                                    </li>
                                </ul>
                            </span>
                        </span>
                    </span>
                </div>
                <div class="col-md-2">
                    <label class="form-control-label">Puntos:</label>
                    <vue-numeric class="form-control" readonly="true" v-model="puntos"
                        separator="," :precision="2">
                    </vue-numeric>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="form-control-label">Categoria:</label>
                    <input type="text" class="form-control" v-model="categoria" readonly="true">
                </div>
                <div class="col-md-2">
                    <label class="form-control-label">Precio:</label>
                    <vue-numeric class="form-control" 
                        v-model="preciov" readonly="true"
                        separator="," :precision="2" currency="S/.">
                    </vue-numeric>
                </div>
                <div class="col-md-2">
                    <label class="form-control-label">Cantidad:</label>
                    <vue-numeric class="form-control" 
                        v-model="cantidad" 
                        separator="," :precision="2" v-bind:min="1" v-bind:max="100">
                    </vue-numeric>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="button" class="btn btn-success btn-sm" id="btnAgregarProducto"
                        @click="agregarProductoDetalle()">Agregar a Detalle</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="js">
import { ref } from 'vue';
import VueNumeric from '@handcrafted-market/vue3-numeric';

export default {
    name: "BuscarProducto",
    components: { VueNumeric },
    data() {
        return {
            venta_id_producto: 0,
            buscar_nombre: '',
            buscar_nombre_foco: false,
            datos_producto: ref([]),
            categoria: '',
            puntos: 0,
            preciov: 0,
            cantidad: 0
        }
    },
    created(){
        //Obtener datos de productos para autocomplete y también para enviar al componente RegistroPropiedad como propiedad
        let self = this;
        axios.get(this.raiz + '/productos/list').then(response => {
            self.datos_producto = response.data.data;
        });
    },
    methods: {
        seleccionarProducto(producto){
            this.venta_id_producto = producto.id_prod;
            this.buscar_nombre = producto.nombre_prod;
            this.puntos = producto.puntos_prod;
            this.categoria = producto.categoria.nombre_cat;
            this.preciov = producto.preciov_prod;
            this.buscar_nombre_foco = false;
        },
        perderFocoProducto(){
            if(this.buscar_nombre.trim() === ''){
                this.venta_id_producto = 0;
            }
        },
        agregarProductoDetalle(){
            if(this.cantidad > 0 && this.venta_id_producto != 0){
                const detalle = {
                    id_producto: this.venta_id_producto,
                    descripcion: this.buscar_nombre,
                    categoria: this.categoria,
                    preciov: this.preciov,
                    cantidad: this.cantidad
                }
                this.$emit('agregar_detalle_trigger', detalle);
            }
            
        }
    },
    computed:{
        busquedaProductoDinamic(){
            if (this.buscar_nombre === '' || this.buscar_nombre_foco == false) {
                return []
            }
            let concidencias = 0
            return this.datos_producto.filter(producto => {
                if (producto.nombre_prod.toLowerCase().includes(this.buscar_nombre.toLowerCase()) && concidencias < 10) {
                    concidencias++;
                    return producto;
                }
            });
        }
    },
    props: {
        raiz: String
    },
    emits:['agregar_detalle_trigger'],
    watch:{
        'venta_id_producto'(new_value){
            if(new_value == 0){
                this.buscar_nombre = '';
                this.puntos = 0;
                this.categoria = '';
                this.preciov = 0;
            }
        }
    }
}
</script>
<style scoped>
.form-group {
    margin-bottom: 5px !important;
}
</style>
