import { createWebHistory, createRouter, RouteRecordRaw } from "vue-router"
import Home from "./views/Home.vue"
import CreateProducts from "./views/CreateProducts.vue"

const routes:Array<RouteRecordRaw> = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path : "/products/create",
        name : "Create Products",
        component : CreateProducts
    }
];

const router = createRouter({
    history:createWebHistory(),
    routes: routes
})

export default router