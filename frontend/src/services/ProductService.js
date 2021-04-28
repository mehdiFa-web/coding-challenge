import apiClient from "../axios";
import { forEach } from "@/helpers";

export default {
    getProducts : function (sortBy, categoryId) {
        return apiClient.get("/api/products",{
            headers : {
                accept : "application-json"
            },
            params : {
                "sortBy":sortBy,
                "category_id" : categoryId
            }
        });
    },
    getCategoriesForInput : function () {
        return apiClient.get("/api/category/options")
    },
    createNewProduct : async function (newProduct) {
        const formData = await this.prepareFormData(newProduct)
        return apiClient.post('/api/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    prepareFormData : function (object) {
        let formData = new FormData();
        forEach(object,(key,value)=> {
            formData.append(key,value instanceof Array ? JSON.stringify(value): value)
        });
        return Promise.resolve(formData)
    }
}