<template>
    <DataTable
        class="table table-striped table-bordered display"
        :data="productos" :columns="columnas"
        :options="{
            responsive:true,
            autoWidth:false,
            dom:'Bfrtip',
            language:{
                search: 'Buscar',
                zeroRecords: 'No hay registros para mostrar.',
                info: 'Mostrando de _START_ a _END_ de _TOTAL_ registros.',
                paginate: {
                    first:'Primero',
                    previous:'Anterior',
                    next:'Siguiente',
                    last: 'Último'
                }
            }}">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Categoría</th>
                <th>Puntos</th>
                <th>Precio C.</th>
                <th>Precio V.</th>

                <th>Acción</th>
            </tr>
        </thead>
    </DataTable>
</template>

<script>
import axios from 'axios'
import DataTable from 'datatables.net-vue3'
import DataTableLib from 'datatables.net-bs4'
import Buttons from 'datatables.net-buttons-bs4'
import ButtonHtml5 from 'datatables.net-buttons/js/buttons.html5'
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts'
import 'datatables.net-responsive-bs4'
import JsZip from 'jszip'

window.JsZip = JsZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonHtml5);

export default {
    name: "table-producto-component",
    components: {DataTable},
    data(){
        return{
            productos:null,
            columnas:[
                {data:null, render: function(data, type, row, meta){
                        return `${meta.row+1}`
                    }},
                {data:'nombre_prod'},
                {data:'codigo_prod'},
                {data:'idcat_prod'},
                {data:'puntos_prod'},
                {data:'precioc_prod'},
                {data:'preciov_prod'},
                {data:null, render: function(data, type, row, meta){
                    return `<a href='#' class="btn btn-warning btn-sm">Editar</a>`
                    }}
            ]
        }
    },
    mounted() {
        //this.getProductos()
        this.productos = this.data_prod;
    },
    props: {
        data_prod: {
            type: Array,
            default: () => []
        }
    },
    methods:{
        /*getProductos(){
            axios.get('/productos/list').then(
                response=>(
                    this.productos = response.data
                )
            );
        }*/
    }
}
</script>

<style>
@import 'datatables.net-bs4';
</style>
