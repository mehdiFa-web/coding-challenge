import { createStore } from 'vuex'
// importing modules
import * as product from "./modules/product"
import * as category from "./modules/category"

export default createStore({
  modules : {
    product,
    category
  }
})
