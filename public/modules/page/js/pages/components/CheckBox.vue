<template>
  <div class="div">
    <div v-for="category in categories">
      <el-checkbox class="check-box" :label="category.id" :key="category.id">
        {{ category.label }}
      </el-checkbox>

      <div class="check-box-has-child" v-if="category.children">
        <CheckBox :categories="category.children" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CheckBox",
  props: {
    categories: { default: null, type: Object },
  },
};
</script>
