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


//MIS COMPONENTES
import NavbarLink from '@/Components/SuperAdmin/NavbarLink.vue';
import Crear from '@/Pages/SuperAdmin/Crud/Crear.vue';
import Editar from '@/Pages/SuperAdmin/Crud/Editar.vue';
import Eliminar from '@/Pages/SuperAdmin/Crud/Eliminar.vue';
</script>

<script>
export default {
    data() {
        return {
            create: false,
            edit: false,

            selectedRows: [],
            selectedRow: null,

            filtros: {},

            menuModel: [
                {label: 'Editar', icon: 'pi pi-fw pi-pen-to-square', command: () => this.editar(this.selectedRow) },
                {label: 'Eliminar', icon: 'pi pi-fw pi-times', command: () => this.confirmarEliminacion(this.selectedRow) }
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
                    title: 'envios',
                    url: '/envios',
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
            columns: [],
            createColumns: [],
            editColumns: [],
        }
    },
    methods: {
        refreshDataTable(){
            window.axios({
                url: this.selectedTable.url,

            }).then(response => {
                this.datos = response.data.data;
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


        // NOTIFICACIONES PARA EL TOAST
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

        // OPCIONES DEL MENU CONTEXTUAL
        onRowContextMenu(event) {
            this.selectedRow = event.data;

            if(this.selectedRow.deleted_at !== null){
                this.menuModel[1].label = 'Activar';
                this.menuModel[1].icon = 'pi pi-fw pi-check';
            }
            else{
                this.menuModel[1].label = 'Eliminar';
                this.menuModel[1].icon = 'pi pi-fw pi-times';
            }


            this.$refs.cm.show(event.originalEvent);
        },
        // EXPORTAR LA TABLA A CSV
        exportCSV() {
            this.$refs.dt.exportCSV();
        },



    },

    mounted() {
        this.changeSelection(this.tablas[0]);
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
                <Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="confirmarEliminacion()" :disabled="!selectedRows || !selectedRows.length" />
            </template>
            <template #end>
                <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>
        </Toolbar>

        <ContextMenu ref="cm" :model="menuModel" @hide="selectedRow = null" />

        <DataTable :value="datos" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort
                showGridlines ref="dt" v-model:selection="selectedRows" @row-contextmenu="onRowContextMenu"
                v-model:contextMenuSelection="selectedRow" :contextMenuSelection="selectedRow" contextMenu>

            <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>

            <div v-for="col of columns">

                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === 'chips'">
                    <template #body="slotProps">
                        <Chip v-for="rol in slotProps.data.roles" :label="rol" />
                    </template>
                </Column>

                <Column :key="col.field" :field="col.field" :header="col.header" sortable v-if="col.type === 'text'"/>

                <Column :key="col.field" :field="col.field" :header="col.header" v-if="col.type === 'status'" class="flex justify-center" >
                    <template #body="slotProps">
                        <!-- <Tag :value="slotProps.data.deleted_at == null ? 'ACTIVO' : 'INACTIVO' " :severity="getSeverity(slotProps.data.deleted_at)" class="w-9/12 text-lg" /> -->
                        <Tag value="a" severity="danger" class="w-9/12 text-lg" />
                    </template>
                </Column>

            </div>


        </DataTable>
    </div>
</div>


<!--DIALOGO PARA ELIMINAR-->
<Eliminar ref="deleteModal" @confirmed="deleted()" @canceled="notDeleted()" :table="selectedTable" />

<!--DIALOGO PARA CREAR-->
<Crear :visible="create" :columns="createColumns" @canceled="notCreated()" @confirmed="created()" :table="selectedTable" />

<!--DIALOGO PARA EDITAR-->
<Editar ref="editModal" :visible="edit" :columns="editColumns" @canceled="notUpdated()" @confirmed="updated()" :table="selectedTable" />

<!--TOAST-->
<Toast/>

</template>

