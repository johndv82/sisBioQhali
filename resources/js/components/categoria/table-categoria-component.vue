<template>
    <DataTable
        class="table table-striped table-bordered display"
        :data="datos" :columns="columnas"
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
            buttons: botones, select: true
        }">
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

//Exportar a PDF
pdfmake.vfs = pdfFonts.pdfMake.vfs;

window.JSZip = JsZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonHtml5);

export default {
    name: "TableCategoriaComponent",
    components: {DataTable},
    data(){
        return{
            //categorias: [],
            columnas:[
                {data:null, render: function(data, type, row, meta){
                        return `${meta.row+1}`
                    }, title:'#'},
                {data:'nombre_cat', title:'Nombre'},
                {data:'codigo_cat', title: 'Código'},
                {data:'obs_cat', title: 'Observación'}
            ],
            botones: [
                {
                    title: "Reporte de Categorías",
                    extend: "excelHtml5",
                    text: "<i class='fas fa-file-excel'></i> Excel",
                    className: "btn btn-success"
                },
                {
                    title: "Reporte de Categorías",
                    extend: "pdfHtml5",
                    text: "<i class='fas fa-file-pdf'></i> PDF",
                    className: "btn btn-danger"
                },
                {
                    title: "Reporte de Categorías",
                    extend: "print",
                    text: "<i class='fas fa-print'></i> Imprimir",
                    className: "btn btn-dark"
                }
            ]
        }
    },
    props:{
        routelist: String,
        datos:{
            type: [Object, Array],
            default: () => {}
        }
    }
}
</script>

<style scoped>

</style>
