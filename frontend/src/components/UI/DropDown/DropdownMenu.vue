<template>
    <ul class="absolute shadow inset-x-0" v-if="isDropdownActive">
        <slot></slot>
    </ul>
</template>
<script>
export default {
  props : {
    isDropdownActive : {
      type : Boolean,
      required : true
    }
  }
}
</script>
