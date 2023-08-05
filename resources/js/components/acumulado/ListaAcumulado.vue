<template>    
    <div class="row form-group">
        <div class="col-md-12">
            <div class="table-responsive table--no-card m-b-30">
                <table id="tblAcumulados" class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th style="width: 5%;">Check</th>
                            <th style="width: 40%;">Producto</th>
                            <th style="width: 15%;">Precio Uni.</th>
                            <th style="width: 10%;">Cantidad</th>
                            <th style="width: 10%;">Medida</th>
                            <th style="width: 10%;">Puntos</th>
                            <th style="width: 10%;">Dscto.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in datos_a_pintar" :key="item.id_acum">
                            <td>
                                <label class="au-checkbox">
                                    <input type="checkbox" class="checkbox" :value="item.id_acum">
                                    <span class="au-checkmark"></span>
                                </label>
                            </td>
                            <td>{{ item.producto.nombre_prod }}</td>
                            <td>{{ item.preciouni_acum }}</td>
                            <td>{{ item.cantidad_acum }}</td>
                            <td>{{ item.medidaprod_acum }}</td>
                            <td>{{ item.puntos_acum }}</td>
                            <td>{{ formatoNumero(item.dscto_acum) }}% </td>
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
    <div class="row form-group">
        <div class="col-md-12">
            <button type="button" class="btn btn-info float-right" id="btnProcesarAcumulados"
                @click="procesarAcumulados()">
                Procesar Acumulados</button>
        </div>
    </div>
</template>

<script lang="js">

export default {
    name: 'ListaAcumulado',
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
    emits: ['procesar_acumulados'],
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
        formatoNumero(n, tipo="decimal"){
            let numero = Math.round(n * 100) / 100;
            const formateado = numero.toLocaleString("es-PE", {
                style: tipo,
                currency: "PEN"
            });
            return formateado;
        },
        procesarAcumulados(){
            var checkboxes = document.getElementsByClassName("checkbox");
            var ids = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    ids.push(checkboxes[i].value);
                }
            }
            this.$emit('procesar_acumulados', ids);
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
