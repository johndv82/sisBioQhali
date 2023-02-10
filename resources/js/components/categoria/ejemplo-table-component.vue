<script>
import { ref, onMounted } from 'vue';

import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import  'datatables.net-dt';

DataTable.use(DataTablesLib);

export default{

    name: 'ejemplo-table-component',
    data(){
        return{
        }
    },
    setup(){
        let counter = 0;
        let dt;
        const data = ref([]);
        const table = ref();
        const columns = [
            {
                data: 'a',
                title: 'First',
            },
            {
                data: 'b',
                title: 'Second',
            },
            {
                data: 'c',
                title: 'Third',
            },
            {
                data: null, render: function(data, type, row, meta){
                    return `<button id="btnEditar" class="btn btn-warning btn-sm">Editar</button>`
                }, title:'Acción'
            }
        ];

        // Initial data
        for (let i = 0; i < 5; i++) {
            add();
        }

        //onMounted(function () {
        console.log(table.value);
        dt = table.value.dt();
        //});

        function add() {
            data.value.push({
                a: 'A-' + counter,
                b: 'B-' + counter,
                c: 'C-' + counter,
            });
            counter += 1;
        }


        (dt.table().body()).on('click', 'button.btnEditar', function () {
            alert("click");
        });
        return {columns, data, dt, table}
    }
}




</script>

<template>
    <div>
        <h1>Simple table</h1>
        <h2>DataTables + Vue3 example</h2>
        <p>
            This example demonstrates the <code>datatables.net-vue3</code> package
            being used to display an interactive DataTable in a Vue application.
        </p>

        <DataTable
            class="display"
            :columns="columns"
            :data="data"
            ref="table"
        />
    </div>
</template>

<style>
</style>
