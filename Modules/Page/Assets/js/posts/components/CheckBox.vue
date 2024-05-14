<template>
  <div class="div">
    <div class="wrap-checkbox" v-for="category in categories">
      <el-checkbox
        v-bind:class="{ 'check-box': true, 'not-has-child': !category.children }"
        :label="category.id"
        :key="category.id"
      >
        {{ category.title }}
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
    categories: { default: null },
  },
};
</script>

<style>
.wrap-checkbox .el-checkbox {
  position: relative;
}

.wrap-checkbox .el-checkbox::before {
  content: "";
  position: absolute;
  left: -7px;
  top: 50%;
  height: 2px;
  width: 7px;
  border-top: 1px dashed rgba(102, 102, 102, 0.4);
}

.wrap-checkbox .el-checkbox::after {
  content: "";
  position: absolute;
  left: -8px;
  top: -988px;
  height: 1000px;
  width: 2px;
  border-left: 1px dashed rgba(102, 102, 102, 0.4);
}

.el-checkbox-group > .div > .wrap-checkbox > .el-checkbox::after,
.el-checkbox-group > .div > .wrap-checkbox > .el-checkbox::before {
  content: unset;
}
</style>
