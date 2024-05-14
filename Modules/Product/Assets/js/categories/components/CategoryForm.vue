<template>
  <div class="div">
    <div class="content-header">
      <h1>
        Edit a category
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.category.index' }">
          {{ trans("categories.title.categories") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.category.create' }">
          Edit a category
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form ref="form" :model="category" label-width="120px" label-position="top"
      @keydown="form.errors.clear($event.target.name)">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item :label="trans('packages.form.title')" :class="{
                    'el-form-item is-error': form.errors.has(
                      'category.title'
                    ),
                  }">
                    <el-input v-model="category.title"></el-input>
                    <div v-if="form.errors.has('category.title')" class="el-form-item__error"
                      v-text="form.errors.first('category.title')"></div>
                  </el-form-item>
                  <el-form-item :label="trans('packages.form.description')" :class="{
                    'el-form-item is-error': form.errors.has(
                      'category.description'
                    ),
                  }">
                    <el-input v-model="category.description" type="textarea" :rows="4"></el-input>
                    <div v-if="form.errors.has('category.description')" class="el-form-item__error"
                      v-text="form.errors.first('category.description')"></div>
                  </el-form-item>
              <single-media :entity-id="category.id" zone="avatar" entity="Modules\Product\Entities\Category"
                @single-file-selected="selectSingleFile($event, 'category')"></single-media>
              <br>
              <el-form-item :label="trans('packages.form.status')" :class="{
                'el-form-item is-error': form.errors.has('status'),
              }">
                <el-switch v-model="category.status" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('status')" class="el-form-item__error" v-text="form.errors.first('status')">
                </div>
              </el-form-item>
              <el-form-item>
                <el-button :loading="loading" type="primary" @click="onSubmit()">
                  {{ trans("core.save") }}
                </el-button>
                <el-button @click="onCancel()">
                  {{ trans("core.button.cancel") }}
                </el-button>
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.page.category.index' })"></button>
  </div>
</template>

<script>
import axios from "axios";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";
import Slugify from "../../../../../Core/Assets/js/mixins/Slugify";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import ActiveEditor from "../../../../../Core/Assets/js/mixins/ActiveEditor";
import SingleMedia from "../../../../../Media/Assets/js/components/SingleMedia.vue";
import SingleFileSelector from "../../../../../Media/Assets/js/mixins/SingleFileSelector";
import TagsInput from "../../../../../Tag/Assets/js/components/TagInput.vue";
import Treeselect from "@riophae/vue-treeselect";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";

export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
    Treeselect,
  },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: {
      default: null,
      type: Object,
    }
  },
  data() {
    return {
      // category: window
      //   ._(this.locales)
      //   .keys()
      //   .map((locale) => [
      //     locale,
      //     {
      //     },
      //   ])
      //   .fromPairs()
      //   .merge({})
      //   .value(),
      category: {
        title: "",
        description: "",
        status: true
      },
      categories: [],
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
    };
  },
  created() {
    this.fetchCategoryAll()
    if (this.$route.params.categoryId !== undefined) {
      this.fetchCategory();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    fetchCategoryAll() {
      // this.loading = true;
      // if (this.$route.params.categoryId !== undefined) {
      //   axios
      //     .get(
      //       route("api.product.category.with.children", {
      //         categoryId: this.$route.params.categoryId,
      //       })
      //     )
      //     .then((response) => {
      //       this.loading = false;
      //       this.categories = response.data.data;
      //     });
      // } else {
      //   return axios.get(route("api.product.category.with.children")).then((response) => {
      //     this.loading = false;
      //     this.categories = response.data.data;
      //   });
      // }
    },
    onSubmit() {
      this.form = new Form(this.category);
      this.loading = true;
      console.log(this.category);
      this.form
        .post(this.getRoute())
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.$message({
            type: "success",
            message: response.message,
          });
          this.pushRoute({
            name: "admin.product.category.index",
          });
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    onCancel() {
      this.pushRoute({
        name: "admin.product.category.index",
      });
    },
    fetchCategory() {
      this.loading = true;
      axios
        .get(
          route("api.product.category.find", {
            categoryId: this.$route.params.categoryId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.category = response.data.data;
        });
    },
    getRoute() {
      if (this.$route.params.categoryId !== undefined) {
        return route("api.product.category.update", {
          categoryId: this.$route.params.categoryId,
        });
      }
      return route("api.product.category.store");
    },
  },
};
</script>

<style>
.select-tree {
  position: relative;
  width: 100%;
  text-align: left;
  outline: none;
  margin-bottom: 22px;
}

.select-tree p {
  float: none;
  display: inline-block;
  text-align: left;
  padding: 0 0 10px;
  line-height: normal;
  font-size: 14px;
  color: #606266;
  box-sizing: border-box;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
}
</style>
