import apiClient from "../axios";


export default {
    getCategories : function () {
        return apiClient.get("/api/categories");
    },
    getCategoriesForInput : function () {
        return apiClient.get("/api/category/options")
    }
}