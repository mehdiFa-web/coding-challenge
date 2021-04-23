import {computed, reactive, watch} from "vue";
import axios from "../axios";




class CategoryService {
    constructor() {
        this.state = reactive({
            loading : true,
            error : false,
            categories : [],
            categoriesOptions : []
        })
        this.loadCategories()
        this.initWatchers()
        this.initComputedProps()
    }
    async loadCategories() {
        try {
            const categoryTree = await axios.get("/api/categories")
            const categoryOptions = await axios.get("/api/category/options")

            this.state.categories = categoryTree.data.data
            this.state.categoriesOptions = categoryOptions.data.data
        }catch (e) {
            console.log(e.response)
            this.state.error = true
        }

        this.state.loading = false
    }
    initWatchers() {
    }
    initComputedProps() {
        this.noCategories = computed(() => this.state.categories.length === 0)
        this.isLoading = computed(() => this.state.loading)
        this.categoriesForInput =  computed(() => this.state.categoriesOptions)
        this.categories =  computed(() => this.state.categories)
    }
    getCategories() {
        return this.categories
    }
    getCategoriesForInput() {
        return this.categoriesForInput
    }
}


export default CategoryService