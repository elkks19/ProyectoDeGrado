<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    title: String,
    isActive: Boolean
});
</script>

<script>
export default{
    data() {
      return {
        nonActiveClass: 'bg-white text-gray-900',
        activeClass: 'bg-gray-900 text-white'
      }
    }
}
</script>


<template>
    <button class="text-center block py-2 px-4 hover:bg-gray-700 hover:text-white w-full transition-colors"
            :class="isActive ? activeClass : nonActiveClass">

        {{ title }}
    </button>
</template>
