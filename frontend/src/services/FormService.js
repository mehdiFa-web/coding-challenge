import {computed, reactive, watch} from "vue";
import axios from "../axios";
import {forEach} from "../helpers";
import router from "../router";




class FormService {
    constructor() {
        this.state = reactive({
            FormData : {
                description : '',
                image : null,
                name : '',
                price : 0,
                category_ids : []
            },
            loading:  false,
            submitted : false,
            errors : []
        })
        this.initWatchers()
        this.initComputedProps()
    }
    async submitForm() {
        this.state.loading = true
        let formData = new FormData();
        forEach(this.state.FormData,(key,value)=> {
            formData.append(key,value instanceof Array ? JSON.stringify(value): value)
        })
        try {
            const response = await axios.post('/api/products',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            this.state.submitted = true
        } catch (error) {
            this.state.errors = error.response.data.errors
        }
    }
    getFormData() {
        return this.state.FormData
    }
    setImage (image) {
        this.state.FormData.image = image
    }
    actions () {
        return {
            setImage : (image) => this.setImage(image),
            submit : () => this.submitForm()
        }
    }
    getErrors() {
        return this.errors
    }
    initWatchers() {
        watch(
            () => this.state.submitted,
            (submitted, oldSubmitted) => {
                if(submitted) {
                    router.push({
                        path : "/"
                    })
                }
            }
        )
    }
    initComputedProps() {
        this.errors = computed( () => this.state.errors )
    }

}


export default FormService