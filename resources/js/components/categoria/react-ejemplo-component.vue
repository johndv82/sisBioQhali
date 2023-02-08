
<script>
import { ref } from 'vue';
import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net-bs4';

DataTable.use(DataTablesLib);

export default {
    components: {DataTable},
    data() {
        return {
            counter : 0,
            data: ref([]),
            columns:[
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
            ]
        }
    },
    mounted() {
        for (let i = 0; i < 5; i++) {
            this.add();
        }
    },
    methods: {
        add() {
            console.log(this.data);
            this.data.push({
                a: 'A-' + this.counter,
                b: 'B-' + this.counter,
                c: 'C-' + this.counter,
            });
            this.counter += 1;
        }
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

        <button @click="add">Add new row</button><br />

        <DataTable class="display" :columns="columns" :data="data"/>
    </div>
</template>

<style>

</style>
