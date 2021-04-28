import CategoryService from "@/services/CategoryService"

import  {
    SET_CATEGORIES_OPTIONS,
    SET_CATEGORIES,
    SET_LOADING
} from "./CategoryMutations"

export const namespaced = true

export const state = {
    loading : true,
    error : false,
    categories : [],
    categoriesOptions : []
}

export const mutations =  {
    [SET_CATEGORIES] (state, categories) {
        state.categories = categories
    },
    [SET_CATEGORIES_OPTIONS] (state, options) {
        state.categoriesOptions = options
    },
    [SET_LOADING] (state, isLoading) {
        state.loading = isLoading
    },
}
export const actions = { 
    async fetchCategories({commit}) {
        let categoriesResponse;

        try {
            categoriesResponse = await CategoryService.getCategories()
        }catch (ex) {
            console.log(ex.response)
            return;
        }

        commit(SET_CATEGORIES, categoriesResponse.data.data)
    },
    async fetchCategoriesOptions({commit}) {
        let categoriesOptionsResponse ;

        try {
            categoriesOptionsResponse = await CategoryService.getCategoriesForInput()
        }catch (ex) {
            console.log(ex.response)
            return;
        }

        commit(SET_CATEGORIES_OPTIONS, categoriesOptionsResponse.data.data)
    },
}

export const getters = {

}