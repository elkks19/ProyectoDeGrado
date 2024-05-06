<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import { FilterMatchMode } from 'primevue/api';

//MIS COMPONENTES
import NavbarLink from '@/Components/SuperAdmin/NavbarLink.vue';
</script>

<script>
export default {
    data() {
        return {
            submitted: false,
            details: false,
            eliminar: false,

            filtros: {},
            estados: [
                { label: 'Activo', value: 1 },
                { label: 'Inactivo', value: 0 },
            ],

            tablas: [
                {
                    title: 'usuarios',
                    url: '/users',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'roles',
                    url: '/roles',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'ordenes',
                    url: '/ordenes',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'productos',
                    url: '/productos',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'detalle-ordenes',
                    url: '/detalle-ordenes',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'tipos-entrega',
                    url: '/tipos-entrega',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
            ],
            selected: null,
            datos: [],
            columns: [],
        }
    },
    methods: {
        confirmarEliminacion(row) {
            this.$confirm.require({
                group: 'eliminar',
                header: 'Confirmar eliminación',
                message: '¿Estás seguro de que deseas eliminar este registro?',
                icon: 'pi pi-exclamation-circle',
                acceptIcon: 'pi pi-check',
                rejectIcon: 'pi pi-times',
                rejectClass: 'p-button-outlined p-button-sm',
                acceptClass: 'p-button-sm',
                rejectLabel: 'Cancelar',
                acceptLabel: 'Eliminar',
                accept: () => {
                    this.remove(row);
                    this.$toast.add({ severity: 'info', summary: 'Confirmado', detail: 'Haz eliminado el registro correctamente', life: 3000 });
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Rejected', detail: 'Eliminación cancelada', life: 3000 });
                }
            });
        },

        exportCSV() {
            this.$refs.dt.exportCSV();
        },

        refreshDataTable(){
            window.axios({
                url: this.selected.url,
            }).then(response => {
                this.datos = response.data.data;
                this.columns = response.data.columns;
            }).catch(error => {
                this.datos = [];
                this.columns = [];
                this.selected = null;
                console.log(error);
            });
        },


        changeSelection(tabla) {
            this.selected = tabla;
            this.refreshDataTable();
        },


        remove(row){
            window.axios({
                url: this.selected.url + '/' + row.id,
                method: 'delete'
            }).then(response => {
                console.log(response);
                this.refreshDataTable();
            }).catch(error => {
                console.log(error);
            });
            this.refreshDataTable();
        },

        edit(row){
        },
        details(row){
        },
    },

    mounted() {
        this.changeSelection(this.tablas[0]);
    },
}
</script>


<template>
<div class="flex flex-none">
    <nav class="w-60 h-screen">
        <ul class="flex flex-col h-full">
            <li class="mb-10">
                <NavbarLink title="<- Volver" @click="" isActive class="hover:bg-red-700"/>
            </li>
            <li v-for="tabla in tablas">
                <NavbarLink :title="tabla.title" @click="changeSelection(tabla)" :isActive="selected === tabla"/>
            </li>
        </ul>
    </nav>


    <div class="w-full flex-1" v-if="selected">

        <Toolbar class="mb-4">
            <template #start>
                <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
                <Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="confirmarEliminacion" :disabled="!selectedProducts || !selectedProducts.length" />
            </template>
            <template #end>
                <!-- <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" chooseLabel="Import" class="mr-2 inline-block" /> -->
                <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>
        </Toolbar>

        <DataTable :value="datos" tableStyle="min-width: 50rem" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort
                showGridlines ref="dt">

            <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header" sortable />

        </DataTable>
    </div>
</div>


<!--DIALOGO PARA ELIMINAR-->
<ConfirmDialog group="eliminar">
    <template #message="slotProps">
        <div class="flex flex-column align-items-center w-full gap-3 border-bottom-1 surface-border">
            <i :class="slotProps.message.icon" class="text-5xl text-primary-500"></i>
            <p>{{ slotProps.message.message }}</p>
        </div>
    </template>
</ConfirmDialog>


<Toast/>

</template>

