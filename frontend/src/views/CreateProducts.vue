<template>
  <div class="max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold">
      Create New Product :
    </h3>
    <form @submit.prevent="submitForm(product)">
      <div class="my-4">
        <Label text="Product Name" for="productName" />
        <InputField v-model="product.name" id="productName" placeholder="Blue bag" class="w-full" type="text" />
      </div>

      <Alert v-if="errors['name']">
        {{errors["name"][0]}}
      </Alert>
      <div class="my-4">
        <Label text="Product Price" for="productPrice" />
        <InputField v-model="product.price" id="productPrice" placeholder="0.99" class="w-full" type="number" step=any min=1 />
      </div>
      <Alert  v-if="errors['price']">
        {{errors["price"][0]}}
      </Alert>
      <div class="my-4">
        <Label text="Product Category" />
        <Multiselect v-model="product.category_ids"
                     class="bg-white rounded-md"
                     mode="multiple"
                     :searchable="true"
                     :options="categoriesOptions" />
      </div>

      <div class="my-4">
        <Label text="Product Image" for="productImage" />
        <input @change="setImageAction($event.target.files[0])" class="block" type="file" id="productImage"/>
      </div>
      <Alert v-if="errors['image']">
        {{errors["image"][0]}}
      </Alert>
      <div class="my-4">
        <Label text="Product Description" for="productDescription" />
        <TextAreaField v-model="product.description" id="productDescription" placeholder="Description" class="w-full h-44"/>
      </div>
      <Alert v-if="errors['description']">
      {{errors["description"][0]}}
      </Alert>
      <Button type="submit" class="my-4">
        Register
      </Button>
    </form>
  </div>
</template>

<script>
import InputField from "../components/UI/InputField.vue"
import Label from "../components/UI/Label.vue"
import Button from "../components/UI/Button.vue"
import TextAreaField from "../components/UI/TextAreaField.vue"
import Alert from "../components/UI/Alert"
import Multiselect from '@vueform/multiselect'
import store from "../store"
import { mapState ,mapActions, mapGetters } from "vuex"



async function getCategoriesDispatcher(next) {
  await store.dispatch('category/fetchCategoriesOptions')
  await store.dispatch('product/resetSubmitState')
  next()
}

export default {
  name: "CreateProducts",
  components : {
    Alert,
    InputField,
    Label,
    Button,
    TextAreaField,
    Multiselect
  },
  data() {
    return {
      product  : {
        description : '',
        image : null,
        name : '',
        price : 0,
        category_ids : []
      }
    }
  },
  computed : {
    ...mapState('category',[
        'categoriesOptions',
    ]),
    ...mapState('product',[
      'errors'
    ]),
    ...mapGetters('product',[
      'productIsSubmitted'
    ])
  },
  methods : {
    ...mapActions('product',[
      'createProduct'
    ]),
    setImageAction(image) {
      this.product.image = image
    },
    submitForm(product) {
      this.createProduct(product).then(()=> {
        if(this.productIsSubmitted) {
          this.$router.push({
            path : "/"
          })
        }
      })
    }
  },
  beforeRouteEnter(routeTo, routeFrom, next) {
    getCategoriesDispatcher(next)
  }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

