<template>
    <div class="form-group row">
        <label for="txtBuscar" class="col-sm-2 col-form-label">Buscar [Nombre]: </label>
        <div class="col-sm-10">
            <input type="seach" class="form-control" id="txtBuscar" placeholder="Criterio de búsqueda"
                v-model="busqueda" />
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-12">
            <div class="table-responsive table--no-card m-b-30">
                <table id="tblCategorias" class="table table-striped table-bordered display">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Observación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in datos_a_pintar" :key="item.id_cat">
                            <td>{{ item.nombre_cat }}</td>
                            <td>{{ item.codigo_cat }}</td>
                            <td>{{ item.obs_cat }}</td>
                            <td>
                                <button v-bind:id="'btnEditar-' + item.id_cat" class="btn btn-sm btn-warning"
                                    @click="editar(item.id_cat)">Editar</button>&nbsp;
                                <button v-bind:id="'btnEliminar-' + item.id_cat" class="btn btn-sm btn-danger"
                                    @click="eliminar(item.id_cat)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="total-registros">Total de registros: {{ datos_parciales.length }}</div>

                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item" :class="current_page == 1 ? 'disabled' : ''">
                            <a class="page-link" @click="previous_page_click()">Previous</a>
                        </li>
                        <template v-for="b in botones_a_pintar">
                            <li class="page-item" :class="current_page == b ? 'active' : ''">
                                <a class="page-link" @click="boton_page_click(b)">{{ b }}</a>
                            </li>
                        </template>
                        <li class="page-item" :class="current_page == botones_a_pintar ? 'disabled' : ''">
                            <a class="page-link" @click="next_page_click()">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ListCategoriaComponent",
    data() {
        return {
            datos_parciales: [],
            current_page: 1,
            rows: 10,
            desde: 0,
            hasta: 0,
            busqueda: ''
        }
    },
    mounted() {
        this.hasta = this.rows;
    },
    computed: {
        botones_a_pintar() {
            if(this.datos_parciales.length == 0){
                return 1;
            }else{
                let mod = this.datos_parciales.length % this.rows;
                return parseInt(this.datos_parciales.length / this.rows) + (mod > 0 ? 1 : 0);
            }
        },
        datos_a_pintar() {
            this.datos_parciales = this.datos.filter(cat => cat.nombre_cat.toLowerCase().includes(this.busqueda.toLowerCase()));
            return this.datos_parciales.slice(this.desde, this.hasta);
        }
    },
    watch:{
        busqueda(){
            this.boton_page_click(1);
        }
    },
    emits: ['editar_trigger', 'eliminar_trigger'],
    methods: {
        boton_page_click(bot) {
            this.current_page = bot;
            this.desde = this.current_page == 1 ? 0 : (this.current_page * this.rows) - this.rows;
            this.hasta = this.current_page * this.rows;
        },
        next_page_click() {
            this.boton_page_click(this.current_page + 1);
        },
        previous_page_click() {
            this.boton_page_click(this.current_page - 1);
        },
        editar(id) {
            this.$emit('editar_trigger', id);
        },
        eliminar(id) {
            this.$emit('eliminar_trigger', id);
        }
    },
    props: {
        routeUpdate: String,
        datos: {
            type: [Object, Array],
            default: () => { }
        }
    }
}
</script>

<style scoped>
.page-item {
    cursor: pointer;
}

.page-item.disabled {
    cursor: not-allowed;
}

#total-registros {
    margin: 10px 10px 0px 10px;
    text-align: right;
}
</style>
