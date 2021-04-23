<template>
  <label for="productName" class="text-lg">
    {{text}}
  </label>
</template>

<script>
export default {
  name: "Label",
  props : {
    text : {
      type: String,
      required : true
    }
  }
}
</script>
