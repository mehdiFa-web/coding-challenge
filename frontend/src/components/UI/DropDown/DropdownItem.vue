<template>
    <li>
        <a :id="id" 
            :ref="id" 
            class="block px-4 py-2 bg-white hover:bg-gray-100 focus:outline-black focus:outline-none focus:ring focus:border-blue-300" 
            href=""
            v-on:click.prevent="$emit('change-sorting-type',id)"
            >{{title}}</a>
    </li>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props : {
        title : {
            type: String,
            required : true
        },
        focus : {
            type : Boolean,
            default : false
        },
        id:{
            type: String,
            required : true
        }
    },
    emits: ['change-sorting-type'],
    mounted () {
        if(this.$props.focus) {
            this.$refs[this.$props.id].focus();
        }
    }
})
</script>
