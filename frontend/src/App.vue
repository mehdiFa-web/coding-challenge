<template>
  <Navbar :routes="routes"/>
  <router-view/>
</template>

<style>

</style>
<script>
import Navbar from "./components/Navbar";

export default {
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
      ]
    }
  }
}
</script>