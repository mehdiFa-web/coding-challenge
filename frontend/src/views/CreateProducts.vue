<template>
  <div class="max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold">
      Create New Product :
    </h3>
    <form @submit.prevent="handleSubmit">
      <div class="my-4">
        <Label text="Product Name" for="productName" />
        <InputField v-model="productForm.FormData.name" id="productName" placeholder="Blue bag" class="w-full" type="text" />
      </div>
      <div class="my-4">
        <Label text="Product Price" for="productPrice" />
        <InputField v-model="productForm.FormData.price" id="productPrice" placeholder="0.99" class="w-full" type="number" step=any min=1 />
      </div>
      <div class="my-4">
        <Label text="Product Category" />
        <Multiselect v-model="productForm.FormData.category_ids"
                     class="bg-white rounded-md"
                     mode="multiple"
                     :searchable="true"
                     :options="categories.options" />
      </div>

      <div class="my-4">
        <Label text="Product Image" for="productImage" />
        <input @change="changeImage($event.target.files)" class="block" type="file" id="productImage"/>
      </div>
      <div class="my-4">
        <Label text="Product Description" for="productDescription" />
        <TextAreaField v-model="productForm.FormData.description" id="productDescription" placeholder="Description" class="w-full h-44"/>
      </div>
      <Button type="submit" class="my-4">
        Register
      </Button>
    </form>
  </div>
</template>

<script lang="ts">
import {defineComponent, reactive} from "vue";
import InputField from "../components/UI/InputField.vue";
import Label from "../components/UI/Label.vue";
import Button from "../components/UI/Button.vue";
import TextAreaField from "../components/UI/TextAreaField.vue"
import useForm from "../hooks/useForm";
import Multiselect from '@vueform/multiselect'
import axios from "../axios";

interface FormStateInterface {
  name : string;
  description : string;
  price : number;
  image : File | undefined;
  category_ids : Array<Number>
}

export default defineComponent({
  name: "CreateProducts",
  components : {
    InputField,
    Label,
    Button,
    TextAreaField,
    Multiselect
  },
  data() {
    return {
      value: null,
      options: []
    }
  },
  methods : {
    changeImage(files : FileList) {
      this.productForm.FormData.image = files[0]
    }
  },
  setup() {
    const categories = reactive({
      options: []
    });
    axios.get("/api/category/options").then((res)=>{
      categories.options = res.data.data
    }).catch((err)=>{
    })
    const {state :productForm , handleSubmit} = useForm<FormStateInterface>({
      FormData : {
        description : '',
        image : undefined,
        name : '',
        price : 0,
        category_ids : []
      },
      loading:  false,
      submitted : false
    });
    return {
      productForm,
      handleSubmit,
      categories
    }
  }
})
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
