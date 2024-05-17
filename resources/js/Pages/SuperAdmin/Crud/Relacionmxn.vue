<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel'
import Dropdown from 'primevue/dropdown';
import Chip from 'primevue/chip';
import OrderList from 'primevue/orderlist';
</script>

<script>
export default {
    data() {
        return {
            visible: false,
            editableData: [],
        }
    },
    methods: {
        store(){
            window.axios({
                url: this.table.url + '/' + this.editableData.id,
                method: 'put',
                data: this.editableData
            }).then(response => {
                this.$emit('confirmed');
            }).catch(error => {
                console.log(error);
            });
        },
        cancelar() {
            this.editableData = [];
            this.$emit('canceled');
        },
    },
    emits: ['canceled', 'confirmed'],
    props: ['columns', 'table'],
    expose: ['editableData']
}
</script>

<template>
    <Dialog v-model:visible="visible" modal header="Editar datos de la relacion" @update:visible="cancelar()" dismissableMask >

        <OrderList v-model="editableData" listStyle="height:auto" dataKey="id">
            <template #header> Datos de la relacion </template>

            <template #item="slotProps">

                <div class="flex flex-wrap p-2 align-items-center gap-3">
                    <div class="flex-1 flex flex-column gap-2">
                        <!-- <span class="font-bold">{{ slotProps.item.nombre }}</span> -->
                        <span class="font-bold">a</span>
                    </div>
                    <!-- <span class="font-bold">$ {{ slotProps.item.precio }}</span> -->
                    <span class="font-bold">b</span>
                </div>

            </template>
        </OrderList>

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
        </template>
    </Dialog>
</template>

