<script setup> import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';
import ContextMenu from 'primevue/contextmenu';


//MIS COMPONENTES
import NavbarLink from '@/Components/SuperAdmin/NavbarLink.vue';
</script>

<script>
export default {
    data() {
        return {
            submitted: false,
            extra: false,
            eliminar: false,
            create: false,

            createData: [],

            selectedData: [],
            selectedRow: null,

            menuModel: [
                {label: 'Detalles', icon: 'pi pi-fw pi-search', command: () => this.detalles(this.selectedData) },
                {label: 'Editar', icon: 'pi pi-fw pi-pen-to-square', command: () => this.editar(this.selectedRow) },
                {label: 'Eliminar', icon: 'pi pi-fw pi-times', command: () => this.confirmarEliminacion(this.selectedRow) }
            ],

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
            createColumns: [],
            editColumns: [],
        }
    },
    methods: {
        editar(row){
            console.log(row);
        },
        onRowContextMenu(event) {
            this.$refs.cm.show(event.originalEvent);
        },
        confirmarEliminacion(row = null) {
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
                    if (row) {
                        this.remove(row);
                    } else{
                        this.selectedData.forEach(row => {
                            this.remove(row);
                        });
                    }

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
                console.log(response.data);
                this.datos = response.data.data;
                this.columns = response.data.columns;
                this.createColumns = response.data.createColumns;
                this.editColumns = response.data.editColumns;
            }).catch(error => {
                this.datos = [];
                this.columns = [];
                this.createColumns = [];
                this.editColumns = [];
                this.selected = null;
                console.log(error);
            });
        },


        changeSelection(tabla) {
            this.selected = tabla;
            this.refreshDataTable();
        },


        store(){
            console.log(this.createData);
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
                <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2" @click="create = true" />
                <Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="confirmarEliminacion()" :disabled="!selectedData || !selectedData.length" />
            </template>
            <template #end>
                <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>
        </Toolbar>

        <ContextMenu ref="cm" :model="menuModel" @hide="selectedRow = null" />
        <DataTable :value="datos" tableStyle="min-width: 50rem" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort
                showGridlines ref="dt" v-model:selection="selectedData" @row-contextmenu="onRowContextMenu"
                v-model:contextMenuSelection="selectedRow" :contextMenuSelection="selectedRow" contextMenu>

            <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
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

<!--DIALOGO PARA CREAR-->
<Dialog v-model:visible="create" modal>
    <template #header>
        <span class="p-text-secondary block mb-5 w-full">Crear nuevo registro.</span>
    </template>


    <div class="w-full flex justify-content-center " v-for="col in createColumns">

        <FloatLabel class="w-full mt-5 mb-5" :id="col.field">

            <InputText :id="col.field" class="w-full" autocomplete="off" v-if="col.type === 'text' || col.type === 'email'" v-model="createData[col.field]" />

            <!-- <Calendar v-if="col.type === 'date'" class="w-full" :id="col.field" v-model="createData[col.field]" /> -->

            <MultiSelect :id="col.field" :options="col.options" class="w-full" v-if="col.type === 'select'" display="chip" v-model="createData[col.field]"
            :maxSelectedValues="2" />

            <Password v-if="col.type === 'password'" :feedback="false" :inputId="col.field"  class="w-full" toggleMask v-model="createData[col.field]" />


            <label :for="col.field" class="font-semibold ">
                {{ col.header }}
            </label>

        </FloatLabel>

    </div>

    <template #footer>
        <Button label="Cancelar" text severity="secondary" @click="create = false" autofocus />
        <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
    </template>
</Dialog>

<!--TOAST-->
<Toast/>

</template>

