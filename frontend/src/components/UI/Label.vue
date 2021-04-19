<template>
  <label for="productName" class="text-lg">
    {{text}}
  </label>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "Label",
  props : {
    text : {
      type: String,
      required : true
    }
  }
})
</script>
