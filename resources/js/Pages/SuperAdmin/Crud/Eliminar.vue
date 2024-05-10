<script setup>
import ConfirmDialog from 'primevue/confirmdialog';
</script>

<script>
export default {
    data() {
        return {
            visible: false,
            columns: [],
        }
    },
    methods: {
        remove(row){
            window.axios({
                url: this.table.url + '/' + row.id,
                method: 'delete'
            }).catch(error => {
                console.log(error);
                this.cancelar();
            });
        },

        cancelar() {
            this.$emit('canceled');
        },

        confirmarEliminacion(rows) {
            let message;

            if(rows.deleted_at == null && rows.length === 1)
                message = '¿Estás seguro de que deseas eliminar este registro?';
            else if(rows.deleted_at != null && rows.length === 1)
                message = '¿Estás seguro de que deseas restaurar este registro?';

            else if(rows.length > 1)
                message = '¿Estás seguro de que deseas eliminar estos registros?';


            this.$confirm.require({
                group: 'eliminar',
                header: 'Confirmar eliminación',
                message: message,
                icon: 'pi pi-exclamation-circle',
                acceptIcon: 'pi pi-check',
                rejectIcon: 'pi pi-times',
                rejectClass: 'p-button-outlined p-button-sm',
                acceptClass: 'p-button-sm',
                rejectLabel: 'Cancelar',
                acceptLabel: 'Eliminar',
                accept: () => {
                    rows.forEach(row => {
                        this.remove(row);
                    });

                    this.$emit('confirmed');
                },
                reject: () => {
                    this.cancelar();
                }
            });
        },
    },
    emits: ['confirmed', 'canceled'],

    props: ['table'],

    expose: ['confirmarEliminacion'],
}
</script>

<template>
    <ConfirmDialog group="eliminar">
        <template #message="slotProps">
            <div class="flex flex-column align-items-center w-full gap-3 border-bottom-1 surface-border">
                <i :class="slotProps.message.icon" class="text-5xl text-primary-500"></i>
                <p>{{ slotProps.message.message }}</p>
            </div>
        </template>
    </ConfirmDialog>
</template>

