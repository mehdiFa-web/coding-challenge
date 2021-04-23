<template>
  <div class="max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold">
      Create New Product :
    </h3>
    <form @submit.prevent="handleSubmitAction">
      <div class="my-4">
        <Label text="Product Name" for="productName" />
        <InputField v-model="formData.name" id="productName" placeholder="Blue bag" class="w-full" type="text" />
      </div>
      <Alert v-if="errors['name']">
        {{errors["name"][0]}}
      </Alert>
      <div class="my-4">
        <Label text="Product Price" for="productPrice" />
        <InputField v-model="formData.price" id="productPrice" placeholder="0.99" class="w-full" type="number" step=any min=1 />
      </div>
      <Alert  v-if="errors['price']">
        {{errors["price"][0]}}
      </Alert>
      <div class="my-4">
        <Label text="Product Category" />
        <Multiselect v-model="formData.category_ids"
                     class="bg-white rounded-md"
                     mode="multiple"
                     :searchable="true"
                     :options="categories" />
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
        <TextAreaField v-model="formData.description" id="productDescription" placeholder="Description" class="w-full h-44"/>
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
import InputField from "../components/UI/InputField.vue";
import Label from "../components/UI/Label.vue";
import Button from "../components/UI/Button.vue";
import TextAreaField from "../components/UI/TextAreaField.vue"

import Multiselect from '@vueform/multiselect'

//services
import CategoryService from "../services/CategoryService";
import FormService from "../services/FormService"
import Alert from "../components/UI/Alert";

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
  setup() {
    // mapping services instances
    const categoryService = new CategoryService()
    const formService     = new FormService()

    return {
      formData : formService.getFormData(),
      errors : formService.getErrors(),
      categories : categoryService.getCategoriesForInput(),
      // actions
      handleSubmitAction : formService.actions().submit,
      setImageAction : formService.actions().setImage,
    }
  }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
