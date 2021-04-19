<template>
    <li class="px-4">
      <div class="flex items-center">
        <button v-if="hasChildren" class="mr-1" @click="expanded = !expanded">
          <svg v-if="!expanded" xmlns="http://www.w3.org/2000/svg" class="fill-current w-3 text-gray-800" viewBox="0 0 16 16">
            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
          </svg>
          <svg v-if="expanded" xmlns="http://www.w3.org/2000/svg" class="fill-current w-3 text-gray-800" viewBox="0 0 16 16">
            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
          </svg>
        </button>
        <router-link :to="`/categories/${node.id}`">
          {{node.name}}
        </router-link>
      </div>
      <ul>
      <MultiLevelCategory v-show="expanded" v-for="child in node.children"
                          :node="child"
                          :key="child.id"
      />
      </ul>
    </li>
</template>

<script lang="ts">
import {defineComponent,PropType} from "vue";

interface CategoryNodeInterface {
  name : string;
  id : number;
  children : Array<CategoryNodeInterface>;
}

export default defineComponent({
  name: "MultiLevelCategory",
  props : {
    node:  {
       type: Object as PropType<CategoryNodeInterface>
    }
  },
  data () {
    return {
      expanded : false
    }
  },
  computed : {
    hasChildren():boolean {
      return !!this.node?.children.length;
    }
  }
})
</script>
