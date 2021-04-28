import ProductService from "@/services/ProductService"

import {
    SET_PRODUCTS,
    CHANGE_SORTING_TYPE,
    SET_LOADING,
    CHANGE_SELECTED_CATEGORY_ID,
    PRODUCT_SUBMITTED,
    SET_SUBMITTED
} from "./ProductMutations"

export const namespaced = true

export const state = {
    loading : true,
    error : false,
    products : [],
    selected : null,
    sortBy : 'htl',
    submitted : false
}

export const mutations =  { 
    [SET_PRODUCTS] (state, products) {
        console.log(products)
        state.products = products
    },
    [CHANGE_SORTING_TYPE] (state, sortBy) {
        state.sortBy = sortBy
    },
    [SET_LOADING] (state, isLoading) {
        state.loading = isLoading
    },
    [CHANGE_SELECTED_CATEGORY_ID] (state, id) {
        state.selected = id
    },
    [PRODUCT_SUBMITTED] (state) {
        state.submitted = true
    },
    [SET_SUBMITTED] (state, isSubmitted) {
        state.submitted = isSubmitted
    }
}
export const actions = { 
    fetchProducts ({ commit, getters}) {
        return ProductService.getProducts(getters.getSortType, getters.selectedCategoryId)
                .then(response => {
                    commit(SET_PRODUCTS, response.data.data)
                    commit(SET_LOADING, true)
                }).catch((error) =>{
                    console.log(error.response)
                })
    },
    createProduct({commit}, newProduct) {
        console.log("sub")
        return ProductService.createNewProduct(newProduct)
                            .then(() => {
                                commit(PRODUCT_SUBMITTED)
                                console.log("sub done")
                            }).catch((err)=> {
                                console.log(err.response)
                            })
    },
    changeSortingType({commit}, sortingType) {
        commit(CHANGE_SORTING_TYPE, sortingType)
    },
    changeCategory({commit},id) {
        commit(CHANGE_SELECTED_CATEGORY_ID, id)
    },
    resetSubmitState({commit}) {
        commit(SET_SUBMITTED, false)
    }
}

export const getters = {
    getSortType (state) {
        return state.sortBy
    },
    getSortLabel (state) {
        const labels = {
            "lth" : 'Low to high',
            'htl' : 'High to Low',
            'name' : 'name'
        };
        return labels[state.sortBy]
    },
    selectedCategoryId(state) {
        return state.selected
    },
    productIsSubmitted (state) {
        return state.submitted
    }
}