import { reactive, Ref } from "vue";
import { watch } from "vue";
import axios from "../axios";

const state = reactive({
    loading : true,
    error : false,
    products : [],
    categories : [],
    selected : null as number | null
});

export default function (sortBy:Ref<string>) {
    function loadProducts (sortBy: Ref<string>, categoryId : number | null) {
        axios.get(`/api/products`,{
            headers : {
                accept : "application-json"
            },
            params : {
                "sortBy":sortBy.value,
                "category_id" : categoryId
            }
        }).then((res)=> {
            state.products = res.data.data;
            state.loading = false
        }).catch((err)=>{
            state.error = err
        })
    }



    watch(sortBy,function (){
        // loading data here
        loadProducts(sortBy,state.selected);
    },{
        immediate : true,
    })

    watch(()=>state.selected,function (){
        // loading data here

        loadProducts(sortBy,state.selected);
    })

    return state
}

export function changeCategory(id : number) {
    state.selected = id;
}