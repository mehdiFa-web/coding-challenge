<template>
  <div class="flex">
    <aside class="aside">
      <h3 class="text-xl font-semibold mb-3">Categories</h3>
      <div class="bg-white">
        <ul class="p-4">
          <MultiLevelCategory @change-category-id="changeCategory" v-for="child in categories" :node="child" />
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
                  SortBy : {{getSortLabel}}
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
                        @change-sorting-type="toggleSortingType($event)"
                    />
                    <DropdownItem
                        title="High to low"
                        id="htl"
                        @change-sorting-type="toggleSortingType($event)"
                    />
                    <DropdownItem
                        title="Name"
                        id="name"
                        @change-sorting-type="toggleSortingType($event)"
                    />
                  </div>

                </DropdownMenu>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap">
            <div  v-for="product in products" :key="product.id" class="p-4 w-full sm:w-2/4 md:w-1/3">
              <ProductCard  :src="product.imageUrl"
                            :title="product.name"
                            :price="product.price"
              />
            </div>

          </div>
        </section>
      </div>
    </section>
  </div>
</template>
<script>
import ProductCard from "../components/ProductCard.vue"
import DropdownMenu from "../components/UI/DropDown/DropdownMenu.vue"
import DropdownItem from "../components/UI/DropDown/DropdownItem.vue"
import MultiLevelCategory from "../components/UI/MultiLevelCategory.vue"

import store from "../store"

import {mapState, mapActions, mapGetters} from "vuex"

async function getCategoriesAndProductsDispatcher (next) {
  await store.dispatch('category/fetchCategories')
  await store.dispatch('product/fetchProducts')

  next()
}

export default {
  name : "Home",
  components: {
    ProductCard,
    DropdownItem,
    DropdownMenu,
    MultiLevelCategory
  },
  data() {
    return {
      isDropdownActive : false,
    }
  },
  computed : {
    ...mapState('product',[
        'products',
        'selected'
    ]),
    ...mapState('category',[
        'categories'
    ]),
    ...mapGetters('product',[
        'getSortLabel',
        'getSortType'
    ])
  },
  methods : {
    ...mapActions('product',[
        'changeSortingType',
        'changeCategory',
        'fetchProducts'
    ]),
    dropdownClickAway () {
      this.isDropdownActive = false
    },
    toggleSortingType (type) {
      this.changeSortingType(type)
      this.isDropdownActive = false
    },
  },
  watch : {
    getSortType : function() {
      this.fetchProducts()
    },
    selected : function() {
      this.fetchProducts()
    }
  },
  beforeRouteEnter(routeTo, routeFrom, next) {
    getCategoriesAndProductsDispatcher(next)
  }
}

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
