<template>
    <article class="p-4 hover:shadow">
      <img class="w-full" :src="src" alt="">
      <h2 class="font-semibold">{{ title }}</h2>
      <span class="font-bold text-2xl inline-block mt-2">{{ price }}</span>
      <div class="block mt-2">
        <button class="bg-gray-800 hover:bg-gray-900 px-8 py-2 text-white rounded">
          Add to cart
        </button>
      </div>
    </article>
</template>

<script>
export default {
  name: "ProductCard",
  props : {
    src : {
      type : String,
      required : true
    },
    title : {
      type : String,
      required : true
    },
    price: {
      type : Number,
      required : true
    }
  }
}
</script>

<style scoped>

</style>