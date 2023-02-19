<template>
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
                    <button v-bind:id="'btnEditar-'+item.id_cat" class="btn btn-sm btn-warning">Editar</button>&nbsp;
                    <button v-bind:id="'btnEliminar-'+item.id_cat" class="btn btn-sm btn-danger">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="total-registros">Total de registros: {{ datos.length }}
    </div>
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item" :class="current_page == 1 ? 'disabled': ''">
                <a class="page-link" @click="previous_page_click()">Previous</a>
            </li>
            <template v-for="b in botones_a_pintar">
                <li class="page-item" :class="current_page == b ? 'active': ''">
                    <a class="page-link" @click="boton_page_click(b)">{{ b }}</a>
                </li>
            </template>
            <li class="page-item" :class="current_page == botones_a_pintar ? 'disabled': ''">
                <a class="page-link" @click="next_page_click()">Next</a>
            </li>
        </ul>
    </nav>
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
            hasta: 0
        }
    },
    mounted() {
        this.hasta = this.rows;
    },
    computed: {
        botones_a_pintar() {
            let mod = this.datos.length % this.rows;
            return parseInt(this.datos.length / this.rows) + (mod > 0 ? 1 : 0);
        },
        datos_a_pintar(){
            return this.datos.slice(this.desde, this.hasta);
        }
    },
    methods: {
        boton_page_click(bot){
            this.current_page = bot;
            this.desde = this.current_page == 1 ? 0: (this.current_page * this.rows) - this.rows;
            this.hasta = this.current_page * this.rows;
        },
        next_page_click(){
            this.boton_page_click(this.current_page + 1);
        },
        previous_page_click(){
            this.boton_page_click(this.current_page - 1);
        }
    },
    props:{
        routeUpdate: String,
        datos:{
            type: [Object, Array],
            default: () => {}
        }
    }
}
</script>

<style scoped>
.page-item{
    cursor: pointer;
}
.page-item.disabled{
    cursor: not-allowed;
}
#total-registros{
    margin: 10px 10px 0px 10px;
    text-align: right;
}
</style>
