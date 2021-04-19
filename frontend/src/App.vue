<template>
  <Navbar :routes="routes"/>
  <div class="mx-auto p-4">
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "./components/Navbar.vue";
import {RoutesProp} from "./components/types";

export default defineComponent({
  name: 'App',
  components: {Navbar},
  data() {
    return {
      routes : [
        {
          id : '2',
          name : "Home",
          path : "/"
        },
        {
          id : '3',
          name : "Create Product",
          path : "/products/create"
        }
      ] as RoutesProp[]
    }
  }
})
</script>
