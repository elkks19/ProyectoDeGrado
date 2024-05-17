<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel'
import Dropdown from 'primevue/dropdown';
</script>

<script>
export default {
    data() {
        return {
            visible: false,
            newData: {},
        }
    },
    methods: {
        store() {
            window.axios({
                method: 'post',
                url: this.table.url,
                data: this.newData,
            }).then(response => {
                this.newData = {};
                this.$emit('confirmed');
            }).catch(error => {
                console.log(error);
                this.cancelar();
            });
        },
        cancelar() {
            this.newData = {};
            this.$emit('canceled');
        },
    },
    emits: ['canceled', 'confirmed'],
    props: ['columns', 'table'],
}
</script>

<template>
    <Dialog v-model:visible="visible" modal header="Crear nuevo registro" @update:visible="cancelar()" dismissableMask >

        <div class="w-full flex flex-col space-y-8 mt-7 mb-1" v-for="col in columns">

            <FloatLabel>

                <InputText :id="col.field" class="w-full" autocomplete="off" v-if="col.type === 'text'" v-model="newData[col.field]" />

                <InputText :id="col.field" class="w-full" autocomplete="off" v-if="col.type === 'email'" v-model="newData[col.field]" />

                <Calendar v-if="col.type === 'date'" class="w-full" :id="col.field" v-model="newData[col.field]" :maxDate="new Date()"/>

                <MultiSelect :id="col.field" :options="col.options" class="w-full" v-if="col.type === 'multiselect'" display="chip" v-model="newData[col.field]"
                :maxSelectedValues="2" />

                <Dropdown :id="col.field" :options="col.options" class="w-full" v-if="col.type === 'select'" v-model="newData[col.field]" />

                <Password :feedback="false" :inputId="col.field"  class="w-full" toggleMask v-model="newData[col.field]" v-if="col.type === 'password'" />


                <label :for="col.field" class="font-semibold"> {{ col.header }} </label>

            </FloatLabel>

            <Button v-if="col.type === 'button'" label="Editar" @click="col.action(newData)" />

        </div>

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
        </template>
    </Dialog>
</template>

