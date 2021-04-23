import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import CLickAway from "vue3-click-away"

const app = createApp(App)
app.use(store)
app.use(router)
app.use(CLickAway)
app.mount('#app')
