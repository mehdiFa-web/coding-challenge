<template>
  <div class="flex" v-if="fullyLoaded">
    <aside class="aside">
      <h3 class="text-xl font-semibold mb-3">Categories</h3>
      <div class="bg-white">
        <ul class="p-4">
          <MultiLevelCategory v-for="child in state.categories" :node="child" />
        </ul>
      </div>
    </aside>
    <section class="products">
      <div>
        <h3 class="text-xl font-semibold  mb-3">
          All Products :
        </h3>
        <section class="bg-white rounded">
          <div class="border-b-2 ">
            <div class="flex flex-end">
              <div class="relative ml-auto">
                <button class="font-semibold px-4 py-2 hover:text-purple-600 flex items-center"

                        :class="isDropdownActive && 'bg-gray-300'"
                        @click="isDropdownActive = !isDropdownActive"
                >
                  SortBy : {{sortingType}}
                  <svg aria-hidden="true" viewBox="0 0 24 24" class="fill-current hover:text-purple-600" width="18" height="18">
                    <path xmlns="http://www.w3.org/2000/svg" d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                  </svg>
                </button>
                <DropdownMenu :isDropdownActive="isDropdownActive">
                  <div  v-click-away="dropdownClickAway">
                    <DropdownItem
                        title="Low to high"
                        id="lth"
                        :focus="true"
                        @change-sorting-type="changeSortingType($event)"
                    />
                    <DropdownItem
                        title="High to low"
                        id="htl"
                        @change-sorting-type="changeSortingType($event)"
                    />
                    <DropdownItem
                        title="Name"
                        id="name"
                        @change-sorting-type="changeSortingType($event)"
                    />
                  </div>

                </DropdownMenu>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap">
            <div  v-for="product in state.products" :key="product.id" class="p-4 w-full sm:w-2/4 md:w-1/3">
              <ProductCard  :src="'http://localhost'+product.imageUrl"
                            :title="product.name"
                            :price="product.price"
              />
            </div>

          </div>
        </section>
      </div>
    </section>
  </div>
  <section class="text-center" v-if="loading">
    loading ...
  </section>
  <div class="bg-white p-4" v-if="noProducts && !loading">
    <h2 class="text-xl font-semibold">
      No Products Found
    </h2>
    <a class="text-blue-600 block" href="/">
      Return back
    </a>
  </div>

</template>
<script lang="ts">
import axios from "../axios";
import { defineComponent, ref } from "vue";

import ProductCard from "../components/ProductCard.vue"
import DropdownMenu from "../components/UI/DropDown/DropdownMenu.vue"
import DropdownItem from "../components/UI/DropDown/DropdownItem.vue"
import MultiLevelCategory from "../components/UI/MultiLevelCategory.vue";
import useProducts from "../hooks/useProducts";

export default defineComponent({
  name : "Home",
  data() {
    return {
      isDropdownActive : false,
    }
  },
  methods : {
    dropdownClickAway ():void {
      this.isDropdownActive = false
    },
    changeSortingType (type:string) {
      this.sortBy = type;
      this.isDropdownActive = false
    },
  },
  computed : {
    fullyLoaded (): boolean {
      return this.state.products.length !== 0 &&  !this.state.loading
    },
    loading (): boolean {
      return this.state.loading
    },
    noProducts ():boolean {
      return this.state.products.length === 0
    },
    sortingType () :string {
      interface sortingValueInterface {
        htl : string;
        lth : string;
        name : string;
      }
      const sortingValue : sortingValueInterface = {
        htl : "High to low",
        lth : "Low to high",
        name : "name"
      }
      // @ts-ignore
      return sortingValue[this.sortBy];
    }
  },
  setup() {
    const sortBy = ref("lth")
    const state = useProducts(sortBy)

    axios.get("/api/categories").then((res)=>{
      state.categories = res.data.data
    }).catch((err)=>{
    })
    return {
      state,
      sortBy
    }
  },
  components: {
    ProductCard,
    DropdownItem,
    DropdownMenu,
    MultiLevelCategory
  },
})

</script>
<style scoped>
.aside {
  padding: 0 1rem;
  flex: 0 0 25%;
}
.products {
  flex: 0 0 75%;
}
</style>
