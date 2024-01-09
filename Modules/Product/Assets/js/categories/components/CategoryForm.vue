<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`categories.title.${categoryTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.category.index' }">
          {{ trans("categories.title.categories") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.category.create' }">
          {{ trans(`categories.title.${categoryTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="category"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <form-errors :form="form"></form-errors>
      <div class="row">
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body">
              <el-tabs v-model="activeTab">
                <el-tab-pane
                  v-for="(localeArray, locale) in locales"
                  :key="localeArray.name"
                  :label="localeArray.name"
                  :name="locale"
                >
                  <span slot="label" :class="{ error: form.errors.has(locale) }"
                    ><i :class="'flag-icon flag-icon-' + locale"></i> &nbsp;
                    {{ localeArray.name }}</span
                  >
                  <el-form-item
                    :label="trans('categories.form.title')"
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        locale + '.title'
                      ),
                    }"
                  >
                    <el-input
                      v-model="category[locale].title"
                      @input="generateSlug($event, locale)"
                    ></el-input>
                    <div
                      v-if="form.errors.has(locale + '.title')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.title')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('categories.form.slug')"
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        locale + '.slug'
                      ),
                    }"
                  >
                    <el-input v-model="category[locale].slug">
                      <el-button
                        slot="prepend"
                        @click="generateSlug($event, locale)"
                        >Generate</el-button
                      >
                    </el-input>
                    <div
                      v-if="form.errors.has(locale + '.slug')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.slug')"
                    ></div>
                  </el-form-item>
                  <el-form-item
                    :label="trans('categories.form.sumary')"
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        locale + '.sumary'
                      ),
                    }"
                  >
                    <el-input
                      v-model="category[locale].sumary"
                      type="textarea"
                      rows="4"
                    ></el-input>
                    <div
                      v-if="form.errors.has(locale + '.sumary')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.sumary')"
                    ></div>
                  </el-form-item>
                  <el-form-item
                    :label="trans('categories.form.body')"
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        locale + '.body'
                      ),
                    }"
                  >
                    <component
                      :is="getCurrentEditor()"
                      v-model="category[locale].body"
                      :value="category[locale].body"
                    ></component>
                    <div
                      v-if="form.errors.has(locale + '.body')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.body')"
                    ></div>
                  </el-form-item>
                  <div class="panel box box-primary">
                    <div class="box-header">
                      <h4 class="box-title">
                        <a
                          :href="`#collapseMeta-${locale}`"
                          class="collapsed"
                          data-toggle="collapse"
                          data-parent="#accordion"
                        >
                          {{ trans("core.form.meta_data") }}
                        </a>
                      </h4>
                    </div>
                    <div
                      :id="`collapseMeta-${locale}`"
                      style="height: 0"
                      class="panel-collapse collapse"
                    >
                      <div class="box-body">
                        <el-form-item :label="trans('core.form.meta_title')">
                          <el-input
                            v-model="category[locale].meta_title"
                          ></el-input>
                        </el-form-item>
                        <el-form-item
                          :label="trans('core.form.meta_description')"
                        >
                          <el-input
                            v-model="category[locale].meta_description"
                            type="textarea"
                            autosize
                            maxlength="186"
                            :rows="2"
                          ></el-input>
                        </el-form-item>
                      </div>
                    </div>
                  </div>

                  <div class="panel box box-primary">
                    <div class="box-header">
                      <h4 class="box-title">
                        <a
                          :href="`#collapseFacebook-${locale}`"
                          class="collapsed"
                          data-toggle="collapse"
                          data-parent="#accordion"
                        >
                          {{ trans("core.form.facebook_data") }}
                        </a>
                      </h4>
                    </div>
                    <div
                      :id="`collapseFacebook-${locale}`"
                      style="height: 0"
                      class="panel-collapse collapse"
                    >
                      <div class="box-body">
                        <el-form-item :label="trans('core.form.og_title')">
                          <el-input
                            v-model="category[locale].og_title"
                          ></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('core.form.og_description')">
                          <el-input
                            v-model="category[locale].og_description"
                            type="textarea"
                            autosize
                            maxlength="186"
                          ></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('core.form.og_type')">
                          <el-select
                            v-model="category[locale].og_type"
                            :placeholder="trans('core.form.og_type')"
                          >
                            <el-option
                              :label="trans('core.facebook-types.website')"
                              value="website"
                            ></el-option>
                            <el-option
                              :label="trans('core.facebook-types.product')"
                              value="product"
                            ></el-option>
                            <el-option
                              :label="trans('core.facebook-types.article')"
                              value="article"
                            ></el-option>
                          </el-select>
                        </el-form-item>
                      </div>
                    </div>
                  </div>

                  <el-form-item>
                    <el-button
                      :loading="loading"
                      type="primary"
                      @click="onSubmit()"
                    >
                      {{ trans("core.save") }}
                    </el-button>
                    <el-button @click="onCancel()">
                      {{ trans("core.button.cancel") }}
                    </el-button>
                  </el-form-item>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item
                :label="trans('categories.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="category.status"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('status')"
                  class="el-form-item__error"
                  v-text="form.errors.first('status')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('categories.form.parent_id')"
                :class="{
                  'el-form-item is-error': form.errors.has('parent_id'),
                }"
              >
              <treeselect
                      v-model="category.parent_id"
                      :multiple="false"
                      :searchable="false"
                      :default-expand-level="100"
                      :options="categories"
                      :normalizer="normalizer"
                    />
              </el-form-item>
              <el-form-item
                :label="trans('categories.form.show_homepage')"
                :class="{
                  'el-form-item is-error': form.errors.has('show_homepage'),
                }"
              >
                <el-switch
                  v-model="category.show_homepage"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('show_homepage')"
                  class="el-form-item__error"
                  v-text="form.errors.first('show_homepage')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('categories.form.show_sidebar')"
                :class="{
                  'el-form-item is-error': form.errors.has('show_sidebar'),
                }"
              >
                <el-switch
                  v-model="category.show_sidebar"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('show_sidebar')"
                  class="el-form-item__error"
                  v-text="form.errors.first('show_sidebar')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('categories.form.show_menu')"
                :class="{
                  'el-form-item is-error': form.errors.has('show_menu'),
                }"
              >
                <el-switch
                  v-model="category.show_menu"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('show_menu')"
                  class="el-form-item__error"
                  v-text="form.errors.first('show_menu')"
                ></div>
              </el-form-item>
              <single-media
                :entity-id="category.id"
                zone="avatar"
                entity="Modules\Product\Entities\Category"
                @single-file-selected="selectSingleFile($event, 'category')"
              ></single-media>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button
      v-show="false"
      v-shortkey="['b']"
      @shortkey="pushRoute({ name: 'admin.page.category.index' })"
    ></button>
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
    },
    categoryTitle: {
      default: null,
      type: Object,
    },
  },
  data() {
    return {
      category: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
            slug: "",
            body: "",
            sumary: "",
            meta_title: "",
            meta_description: "",
            og_title: "",
            og_description: "",
            og_type: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          parent_id: null,
          status: true,
          show_homepage: false,
          show_menu: false,
          show_sidebar: false,
        })
        .value(),
      categories: [],
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
      normalizer(node) {
        return {
          id: node.id,
          label: node.title,
          children: node.children,
        };
      },
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
      this.loading = true;
      if (this.$route.params.categoryId !== undefined) {
        axios
          .get(
            route("api.product.category.with.children", {
              categoryId: this.$route.params.categoryId,
            })
          )
          .then((response) => {
            this.loading = false;
            this.categories = response.data.data;
          });
      } else {
        return axios.get(route("api.product.category.with.children")).then((response) => {
          this.loading = false;
          this.categories = response.data.data;
        });
      }
    },
    onSubmit() {
      this.form = new Form(this.category);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
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
    generateSlug(event, locale) {
      this.category[locale].slug = this.slugify(this.category[locale].title);
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
