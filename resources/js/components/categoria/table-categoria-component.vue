<template>
    <DataTable
        class="table table-striped table-bordered display"
        :data="categorias" :columns="columnas"
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
            },
            buttons: botones}">
        <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Observación</th>
            <th>Acción</th>
        </tr>
        </thead>
    </DataTable>
</template>

<script>
import DataTable from 'datatables.net-vue3'
import DataTableLib from 'datatables.net-bs4'
import Buttons from 'datatables.net-buttons-bs4'
import ButtonHtml5 from 'datatables.net-buttons/js/buttons.html5'
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts'
import 'datatables.net-responsive-bs4'
import JsZip from 'jszip'
import axios from 'axios'

//Exportar a PDF
pdfmake.vfs = pdfFonts.pdfMake.vfs;

window.JSZip = JsZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonHtml5);

export default {
    name: "table-categoria-component",
    components: {DataTable},
    data(){
        return{
            categorias:null,
            columnas:[
                {data:null, render: function(data, type, row, meta){
                        return `${meta.row+1}`
                    }},
                {data:'nombre_cat'},
                {data:'codigo_cat'},
                {data:'obs_cat'},
                {data:null, render: function(data, type, row, meta){
                        return `<a href='#' class="btn btn-warning btn-sm">Editar</a>`
                    }}
            ],
            botones: [
                {
                    title: "Reporte de Categorías",
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                    },
                    text: "<i class='fas fa-file-excel'></i> Excel",
                    className: "btn btn-success"
                },
                {
                    title: "Reporte de Categorías",
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                    },
                    text: "<i class='fas fa-file-pdf'></i> PDF",
                    className: "btn btn-danger"
                },
                {
                    title: "Reporte de Categorías",
                    extend: "print",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                    },
                    text: "<i class='fas fa-print'></i> Imprimir",
                    className: "btn btn-dark"
                }
            ]
        }
    },
    async mounted(){
        //Call endpoint categorias.list
        const response = await axios.get(this.list);
        this.categorias = response.data.data;
    },
    props:{
        list: String
    }
}
</script>

<style scoped>

</style>
