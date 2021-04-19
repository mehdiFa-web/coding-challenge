import {reactive} from "vue"
import axios from "../axios"
import {forEach} from "../helpers/"
import {watch} from "vue"
import router from "../router";

interface FormInfo<T> {
    loading : boolean;
    submitted : boolean;
    FormData : T
}

export default function useForm<T>(options:FormInfo<T>) {
    const state = reactive(options)

    watch(
        () => state.submitted,
        (submitted, oldSubmitted) => {
            if(submitted) {
                router.push({
                    path : "/"
                })
            }
        }
    )
    const handleSubmit = async () => {
        state.loading = true
        let formData = new FormData();
        forEach(state.FormData as Object,(key,value)=> {
            formData.append(key,value instanceof Array ? JSON.stringify(value): value)
        });
        try {
            const response = await axios.post('/api/products',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            state.submitted = true
        } catch (error) {
            console.log(error.response)
        }
    }



    return {
        state ,
        handleSubmit
    };
}
