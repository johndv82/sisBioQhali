<template>    
    <div class="row form-group">
        <div class="col-md-12">
            <div class="table-responsive table--no-card m-b-30">
                <table id="tblCompras" class="table table-sm table-striped table-bordered display">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Serie-Número</th>
                            <th>Total</th>
                            <th>Dscto.</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in datos_a_pintar" :key="item.id_com">
                            <td>{{ item.proveedor.nombre_prov }}</td>
                            <td>{{ item.seriecomp_com + " - " + item.numerocomp_com }}</td>
                            <td>{{ formatoNumero(item.total_com, 'currency') }}</td>
                            <td>{{ formatoNumero(item.dscto_com, 'currency') }}</td>
                            <td>{{ item.fecha_com }}</td>
                            <td>
                                <button v-bind:id="'btnVerdetalle' + item.id_com" class="btn btn-sm btn-info"
                                    @click="verdetalle(item.id_com)">Ver Detalle</button>&nbsp;
                                <button v-bind:id="'btnEliminar' + item.id_com" class="btn btn-sm btn-danger"
                                    @click="eliminar(item.id_com)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="total-registros">Total de registros: {{ datos_parciales.length }}</div>

                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item" :class="current_page == 1 ? 'disabled' : ''">
                            <a class="page-link" @click="previous_page_click()">Anterior</a>
                        </li>
                        <template v-for="b in botones_a_pintar">
                            <li class="page-item" :class="current_page == b ? 'active' : ''">
                                <a class="page-link" @click="boton_page_click(b)">{{ b }}</a>
                            </li>
                        </template>
                        <li class="page-item" :class="current_page == botones_a_pintar ? 'disabled' : ''">
                            <a class="page-link" @click="next_page_click()">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script lang="js">

export default {
    name: "ListaCompra",
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
            if(this.datos_parciales.length == 0){
                return 1;
            }else{
                let mod = this.datos_parciales.length % this.rows;
                return parseInt(this.datos_parciales.length / this.rows) + (mod > 0 ? 1 : 0);
            }
        },
        datos_a_pintar() {
            this.datos_parciales = this.datos; //aplicar filtro
            return this.datos_parciales.slice(this.desde, this.hasta);
        }
    },
    emits: ['eliminar_trigger', 'verdetalle_trigger'],
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
        eliminar(id) {
            this.$emit('eliminar_trigger', id);
        },
        formatoNumero(n, tipo="decimal"){
            let numero = Math.round(n * 100) / 100;
            const formateado = numero.toLocaleString("es-PE", {
                style: tipo,
                currency: "PEN"
            });
            return formateado;
        },
        verdetalle(id){
            this.$emit('verdetalle_trigger', id);
        }
    },
    props: {
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
