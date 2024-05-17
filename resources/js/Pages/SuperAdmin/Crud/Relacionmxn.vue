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
                url: this.table.url + '/' + this.id,
                method: 'put',
                data: {
                    'relacionmxn': this.editableData
                }
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
    props: ['columns', 'table', 'options', 'id'],
    expose: ['editableData']
}
</script>

<template>
    <Dialog v-model:visible="visible" modal header="Editar datos de la relacion" @update:visible="cancelar()" dismissableMask >

        <MultiSelect v-model="editableData" :options="options" filter :maxSelectedLabels="3" class="w-full md:w-20rem" />

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
        </template>
    </Dialog>
</template>

