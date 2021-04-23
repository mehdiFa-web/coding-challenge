<template>
  <textarea class="py-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
  >
  </textarea>
</template>

<script>
export default {
  name: "TextAreaField",
  props: ['modelValue'],
  emits: ['update:modelValue'],
}
</script>