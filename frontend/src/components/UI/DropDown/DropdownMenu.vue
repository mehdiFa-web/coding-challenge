<template>
    <ul class="absolute shadow inset-x-0" v-if="isDropdownActive">
        <slot></slot>
    </ul>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props : {
        isDropdownActive : {
            type : Boolean,
            required : true
        }
    }
})
</script>
