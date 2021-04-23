import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import CreateProducts from "../views/CreateProducts"

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path : "/products/create",
    name : "Create Products",
    component : CreateProducts
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
