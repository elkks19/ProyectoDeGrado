<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel'
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
    <Dialog v-model:visible="visible" modal header="Editar registro" @update:visible="cancelar()" dismissableMask >

        <div class="w-full flex flex-col space-y-8 mt-7 mb-1">

            <FloatLabel v-for="col in columns">

                <InputText :id="col.field" class="w-full" autocomplete="off" v-if="col.type === 'text'" v-model="editableData[col.field]" />

                <InputText :id="col.field" class="w-full" autocomplete="off" v-if="col.type === 'email'" v-model="editableData[col.field]" />

                <Calendar v-if="col.type === 'date'" class="w-full" :id="col.field" v-model="editableData[col.field]" />

                <MultiSelect :id="col.field" :options="col.options" class="w-full" v-if="col.type === 'select'" display="chip" v-model="editableData[col.field]"
                :maxSelectedValues="2" />

                <Password :feedback="false" :inputId="col.field"  class="w-full" toggleMask v-model="editableData[col.field]" v-if="col.type === 'password'" />


                <label :for="col.field" class="font-semibold"> {{ col.header }} </label>

            </FloatLabel>

        </div>

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
        </template>
    </Dialog>
</template>

