<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

</script>

<template>
    <DataTable :value="products" tableStyle="min-width: 50rem">
        <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header"></Column>
    </DataTable>
</template>

<script>
export default {
    data() {
        return {
            columns: [],
            products: [],
        };
    },
    mounted(){
        window.axios.get('/users').then(response => {
            this.columns = response.data.columns;
            this.products = response.data.data;
            console.log(response.data);
        }).catch(error => {
            console.log(error);
        });
    },
};
</script>
