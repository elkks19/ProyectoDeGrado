<script setup>
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import ContextMenu from 'primevue/contextmenu';
import Password from 'primevue/password';
import Tag from 'primevue/tag';
import Chip from 'primevue/chip';
import ToggleButton from 'primevue/togglebutton';


//MIS COMPONENTES
import NavbarLink from '@/Components/SuperAdmin/NavbarLink.vue';
import Crear from '@/Pages/SuperAdmin/Crud/Crear.vue';
import Editar from '@/Pages/SuperAdmin/Crud/Editar.vue';
import Eliminar from '@/Pages/SuperAdmin/Crud/Eliminar.vue';
import Restaurar from '@/Pages/SuperAdmin/Crud/Restaurar.vue';
import Relacion from '@/Pages/SuperAdmin/Crud/Relacion.vue';
</script>

<script>
export default {
    data() {
        return {
            create: false,
            edit: false,
            showDeleted: false,
            relation: false,

            selectedRows: [],
            selectedRow: null,

            filtros: {},

            menuModel: [],

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
                    title: 'envios',
                    url: '/envios',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
                {
                    title: 'categorias',
                    url: '/categorias',
                    options: {
                        create: true,
                        edit: true,
                        delete: true,
                        extra: true,
                    },
                },
            ],

            selectedTable: null,

            datos: [],
            deletedDatos: [],
            relationData: [],
            columns: [],
            createColumns: [],
            editColumns: [],
            relationColumns: [],
        }
    },
    methods: {
        refreshDataTable(){
            this.selectedRows = [];
            this.selectedRow = null;
            this.showDeleted = false;
            this.updateMenu();

            window.axios({
                url: this.selectedTable.url,

            }).then(response => {
                this.datos = response.data.data;
                this.deletedDatos = response.data.deletedData;
                this.columns = response.data.columns;
                this.columns = this.columns.filter(col => col.field !== 'deleted_at');

                this.createColumns = response.data.createColumns;
                this.editColumns = response.data.editColumns;
                console.log(response.data);

            }).catch(error => {
                this.datos = [];
                this.columns = [];
                this.createColumns = [];
                this.editColumns = [];
                this.selectedTable = null;
                console.log(error);
            });
        },

        changeSelection(tabla) {
            this.selectedTable = tabla;
            this.refreshDataTable();
        },

        confirmarEliminacion(row = null) {
            if(row){
                this.$refs.deleteModal.confirmarEliminacion([row]);
                return;
            }
            this.$refs.deleteModal.confirmarEliminacion(this.selectedRows);
        },
        confirmarRestauracion(row = null) {
            if(row){
                this.$refs.restoreModal.confirmarRestauracion([row]);
                return;
            }
            this.$refs.restoreModal.confirmarRestauracion(this.selectedRows);
        },
        editar(){
            this.edit = true;
            this.$refs.editModal.editableData = this.selectedRow;
        },

        getSeverity(status) {
            if(status === null){
                return 'success';
            }
            return 'danger';
        },
        toggleDeleted() {
            if(this.showDeleted){
                this.datos = this.deletedDatos;
            }
            else{
                this.refreshDataTable();
            }
            this.updateMenu();
        },


        // NOTIFICACIONES PARA EL TOAST
        restored() {
            this.$toast.add({ severity: 'success', summary: 'Restaurado', detail: 'Haz restaurado el registro correctamente', life: 3000 });
            this.refreshDataTable();
        },
        notRestored() {
            this.$toast.add({ severity: 'error', summary: 'Cancelado', detail: 'Restauración cancelada', life: 3000 });
        },

        deleted() {
            this.$toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Haz eliminado el registro correctamente', life: 3000 });
            this.refreshDataTable();
        },
        notDeleted() {
            this.$toast.add({ severity: 'error', summary: 'Cancelado', detail: 'Eliminación cancelada', life: 3000 });
        },

        created() {
            this.create = false;
            this.$toast.add({ severity: 'success', summary: 'Creado', detail: 'Haz creado el registro correctamente', life: 3000 });
            this.refreshDataTable();
        },
        notCreated() {
            this.create = false;
            this.$toast.add({ severity: 'error', summary: 'Cancelado', detail: 'Creación cancelada', life: 3000 });
        },

        updated() {
            this.edit = false;
            this.$toast.add({ severity: 'success', summary: 'Actualizado', detail: 'Haz editado el registro correctamente', life: 3000 });
            this.refreshDataTable();
        },
        notUpdated() {
            this.edit = false;
            this.$toast.add({ severity: 'error', summary: 'Cancelado', detail: 'Edición cancelada', life: 3000 });
        },

        relationUpdated() {
            this.relation = false;
            this.$toast.add({ severity: 'success', summary: 'Actualizado', detail: 'Haz editado la relación correctamente', life: 3000 });
            this.refreshDataTable();
        },
        relacionNotUpdated() {
            this.relation = false;
            this.$toast.add({ severity: 'error', summary: 'Cancelado', detail: 'Edición de la relación cancelada', life: 3000 });
        },

        // OPCIONES DEL MENU CONTEXTUAL
        updateMenu(){
            if(!this.showDeleted){
                this.menuModel = [
                    { label: 'Editar', icon: 'pi pi-fw pi-pen-to-square', command: () => this.editar(this.selectedRow) },
                    { label: 'Eliminar', icon: 'pi pi-fw pi-times', command: () => this.confirmarEliminacion(this.selectedRow) }
                ];
            }
            else{
                this.menuModel = [
                    { label: 'Editar', icon: 'pi pi-fw pi-pen-to-square', command: () => this.editar(this.selectedRow) },
                    { label: 'Restaurar', icon: 'pi pi-fw pi-undo', command: () => this.confirmarRestauracion(this.selectedRow) }
                ];
            }
        },
        onRowContextMenu(event) {
            this.selectedRow = event.data;

            this.$refs.cm.show(event.originalEvent);
        },
        // EXPORTAR LA TABLA A CSV
        exportCSV() {
            this.$refs.dt.exportCSV();
        },

        // PARA EDITAR LAS RELACIONES
        editarRelacion(data, columns){
            this.$refs.relationModal.editableData = data;
            this.relationColumns = columns;
            this.relationData = data;
            this.relation = true;
        },

    },

    mounted() {
        this.changeSelection(this.tablas[0]);
        this.updateMenu();

        console.log(this.showDeleted);
    },
}
</script>


<template>

<div class="flex flex-none">
    <!--NAVBAR-->
    <nav class="w-60 h-screen">
        <ul class="flex flex-col h-full">
            <li class="mb-10">
                <NavbarLink title="<- Volver" @click="" isActive class="hover:bg-red-700"/>
            </li>
            <li v-for="tabla in tablas">
                <NavbarLink :title="tabla.title" @click="changeSelection(tabla)" :isActive="selectedTable === tabla"/>
            </li>
        </ul>
    </nav>


    <!--DATATABLE-->
    <div class="w-full flex-1" v-if="selectedTable">

        <Toolbar class="mb-4">
            <template #start>
                <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2" @click="create = true" />
                <Button :label="!showDeleted ? 'Eliminar' : 'Restaurar'"
                    :icon="!showDeleted ? 'pi pi-trash' : 'pi pi-undo' "
                    :severity="!showDeleted ? 'danger' : 'success'"
                    @click="!showDeleted ? confirmarEliminacion() : confirmarRestauracion()"
                    :disabled="!selectedRows || !selectedRows.length" class="mr-2" />
            </template>
            <template #end>
                <Button icon="pi pi-refresh" severity="info" @click="refreshDataTable()" class="mr-2"/>

                <ToggleButton offLabel="Ver Eliminados" onLabel="Ver Activos"
                offIcon="pi pi-eye" onIcon="pi pi-eye-slash"
                :disabled="deletedDatos.length === 0"  class="mr-2"
                v-model="showDeleted"
                @update:modelValue="toggleDeleted()" />

                <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>
        </Toolbar>

        <ContextMenu ref="cm" :model="menuModel" @hide="selectedRow = null" />

        <DataTable :value="datos" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort
                showGridlines ref="dt" v-model:selection="selectedRows" @row-contextmenu="onRowContextMenu"
                v-model:contextMenuSelection="selectedRow" :contextMenuSelection="selectedRow" contextMenu>

            <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>

            <div v-for="col of columns">

                <Column :key="col.field" :field="col.field" :header="col.header" v-if="col.type === 'chips'">
                    <template #body="slotProps">
                        <Chip v-for="rol in slotProps.data[col.field]" :label="rol" />
                    </template>
                </Column>


                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === 'text'"/>

                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === '1x1'" >
                    <template #body="slotProps">
                        <Button label="Ver" icon="pi pi-eye" class="p-button-rounded p-button-text p-button-sm" @click="editarRelacion(slotProps.data[col.field], col.data)"/>
                    </template>
                </Column>

                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === '1xm'" >
                    <template #body="slotProps">
                        <Button label="Ver" icon="pi pi-eye" class="p-button-rounded p-button-text p-button-sm" @click="editarRelacion(slotProps.data[col.field], col.data)"/>
                    </template>
                </Column>

                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === 'mxn'" >
                    <template #body="slotProps">
                        <Button label="Ver" icon="pi pi-eye" class="p-button-rounded p-button-text p-button-sm" />
                    </template>
                </Column>

            </div>

            <Column key="estado" field="deleted_at" header="Estado"  class="flex justify-center" >
                <template #body="slotProps">
                    <Tag :value="slotProps.data.deleted_at == null ? 'ACTIVO' : 'INACTIVO' " :severity="getSeverity(slotProps.data.deleted_at)" class="w-9/12 text-lg" />
                </template>
            </Column>


        </DataTable>
    </div>
    <!--<Column :key="col.field" :field="col.field" :header="col.header"  class="flex justify-center" >-->
</div>


<!--DIALOGO PARA RESTAURAR-->
<Restaurar ref="restoreModal" @confirmed="restored()" @canceled="notRestored()" :table="selectedTable" />

<!--DIALOGO PARA ELIMINAR-->
<Eliminar ref="deleteModal" @confirmed="deleted()" @canceled="notDeleted()" :table="selectedTable" />

<!--DIALOGO PARA CREAR-->
<Crear :visible="create" :columns="createColumns" @canceled="notCreated()" @confirmed="created()" :table="selectedTable" />

<!--DIALOGO PARA EDITAR-->
<Editar ref="editModal" :visible="edit" :columns="editColumns" @canceled="notUpdated()" @confirmed="updated()" :table="selectedTable" />

<!--DIALOGO PARA EDITAR RELACIONES-->
<Relacion ref="relationModal" :visible="relation" :columns="relationColumns" :data="relationData" @canceled="relacionNotUpdated()" @confirmed="relationUpdated()" />

<!--TOAST-->
<Toast/>

</template>

