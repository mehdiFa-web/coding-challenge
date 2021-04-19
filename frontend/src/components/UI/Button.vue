<template>
    <button class="px-5 py-2 
                  bg-gray-600 hover:bg-gray-700 
                  rounded-sm cursor-pointer 
                  text-white
                  focus:outline-none focus:ring focus:border-blue-300"
            :type="type"
                  >
      <slot></slot>
    </button>
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        type : {
            type : String,
            default : "button"
        }
    },
})
</script>
