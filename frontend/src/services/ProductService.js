import {computed, reactive, ref, watch} from "vue";
import axios from "../axios";




class ProductService {
    constructor(sortBy) {
        this.state = reactive({
            loading : true,
            error : false,
            products : [],
            selected : null
        })

        this.sortBy = ref(sortBy)
        this.initWatchers()
        this.initComputedProps()
    }
    loadProducts(sortBy, categoryId) {
        axios.get(`/api/products`,{
            headers : {
                accept : "application-json"
            },
            params : {
                "sortBy":sortBy.value,
                "category_id" : categoryId
            }
        }).then((res)=> {
            this.state.products = res.data.data;
            this.state.loading = false
        }).catch((err)=>{
        })
    }
    setSortingType (sortBy) {
        this.sortBy.value = sortBy
    }
    actions () {
        return {
            changeSortingType : (sortBy) => this.setSortingType(sortBy),
            changeCategory : (id) => this.changeCategory(id)
        }
    }
    initWatchers() {
        watch( this.sortBy, () => {
            // loading data here
            this.loadProducts(this.sortBy,this.state.selected);
        },{
            immediate : true,
        })

        watch(() => this.state.selected,()=>{
            // loading data here
            this.loadProducts(this.sortBy,this.state.selected);
        })
    }
    initComputedProps() {
        this.noProducts = computed(() => this.state.products.length === 0)
        this.isLoading = computed(() => this.state.loading)
        this.fullyLoaded = computed(() => !this.noProducts.value && !this.isLoading.value)
        this.products = computed(() => this.state.products)
        this.sortLabel = computed(()=>{
            const sortingValue = {
                htl : "High to low",
                lth : "Low to high",
                name : "name"
            }
            return sortingValue[this.sortBy.value]
        })
    }
    changeCategory(id) {
        this.state.selected = id
    }
    getProducts() {
        return this.products;
    }
}


export default ProductService