<template>
    <div>
        {{ datos_parciales }}
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

<script lang="js">
export default {
    name: 'PaginatorLayout',
    data() {
        return {
            datos_parciales: [],
            current_page: 1,
            rows: 10
        }
    },
    mounted() {
        this.datos_parciales = this.datos.slice(0, this.rows);
    },
    computed: {
        botones_a_pintar() {
            let mod = this.datos.length % this.rows;
            return parseInt(this.datos.length / this.rows) + (mod > 0 ? 1 : 0);
        }
    },
    methods: {
        boton_page_click(bot){
            this.current_page = bot;
            let desde = this.current_page == 1 ? 0: (this.current_page * this.rows) - this.rows;
            let hasta = this.current_page * this.rows;
            this.datos = this.datos.slice(desde, hasta);
        },
        next_page_click(){
            this.boton_page_click(this.current_page + 1);
        },
        previous_page_click(){
            this.boton_page_click(this.current_page - 1);
        }
    },
    props:{
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
</style>