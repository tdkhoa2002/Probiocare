<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`blogs.${blogTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.blog.category.index' }">
          {{ trans("blogs.categories") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.blog.category.create' }">
          {{ trans(`blogs.${blogTitle}`) }}
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
                    ><i :class="'flag-icon flag-icon-' + locale"></i> &nbsp; {{ localeArray.name }}</span
                  >
                  <el-form-item
                    :label="trans('blogs.title')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.title'),
                    }"
                  >
                    <el-input v-model="category[locale].title" @input="generateSlug($event, locale)"></el-input>
                    <div
                      v-if="form.errors.has(locale + '.title')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.title')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('blogs.slug')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.slug'),
                    }"
                  >
                    <el-input v-model="category[locale].slug">
                      <el-button slot="prepend" @click="generateSlug($event, locale)">Generate</el-button>
                    </el-input>
                    <div
                      v-if="form.errors.has(locale + '.slug')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.slug')"
                    ></div>
                  </el-form-item>

                  <!-- // <el-form-item
                  //   :label="trans('blogs.parent_id')"
                  //   :class="{
                  //     'el-form-item is-error': form.errors.has(locale + '.parent_id'),
                  //   }"
                  // >
                  //   <el-input v-model="category[locale].parent_id" @input="generateSlug($event, locale)"></el-input>
                  //   <div
                  //     v-if="form.errors.has(locale + '.parent_id')"
                  //     class="el-form-item__error"
                  //     v-text="form.errors.first(locale + '.parent_id')"
                  //   ></div>
                  // </el-form-item> -->

                  <el-form-item
                    :label="trans('blogs.parent_id')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.parent_id'),
                    }"
                  >
                    <select
                      v-model="category[locale].parent_id"
                      :style="{ width: 100 + '%', height: 40 + 'px', border: 1 + 'px solid #DCDFE6' }"
                    >
                      <option v-for="item in categories" :value="item.id">
                        {{ item.title }}
                      </option>
                    </select>
                  </el-form-item>

                  <el-form-item
                    :label="trans('blogs.sumary')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.sumary'),
                    }"
                  >
                    <el-input v-model="category[locale].sumary" type="textarea" rows="4"></el-input>
                    <div
                      v-if="form.errors.has(locale + '.sumary')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.sumary')"
                    ></div>
                  </el-form-item>
                  <div class="panel box box-primary">
                    <div class="box-header">
                      <h4 class="box-title">
                        <a :href="`#collapseMeta-${locale}`" class="collapsed" data-toggle="collapse" data-parent="#accordion">
                          {{ trans("pages.meta_data") }}
                        </a>
                      </h4>
                    </div>
                    <div :id="`collapseMeta-${locale}`" style="height: 0" class="panel-collapse collapse">
                      <div class="box-body">
                        <el-form-item :label="trans('pages.meta_title')">
                          <el-input v-model="category[locale].meta_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.meta_description')">
                          <el-input
                            v-model="category[locale].meta_description"
                            type="textarea"
                            autosize
                            maxlength="186"
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
                          {{ trans("pages.facebook_data") }}
                        </a>
                      </h4>
                    </div>
                    <div :id="`collapseFacebook-${locale}`" style="height: 0" class="panel-collapse collapse">
                      <div class="box-body">
                        <el-form-item :label="trans('pages.og_title')">
                          <el-input v-model="category[locale].og_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_description')">
                          <el-input v-model="category[locale].og_description" type="textarea" autosize maxlength="186"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_type')">
                          <el-select v-model="category[locale].og_type" :placeholder="trans('pages.og_type')">
                            <el-option :label="trans('pages.facebook-types.website')" value="website"></el-option>
                            <el-option :label="trans('pages.facebook-types.blog')" value="blog"></el-option>
                            <el-option :label="trans('pages.facebook-types.article')" value="article"></el-option>
                          </el-select>
                        </el-form-item>
                      </div>
                    </div>
                  </div>

                  <el-form-item>
                    <el-button :loading="loading" type="primary" @click="onSubmit()">
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
                :label="trans('blogs.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch v-model="category.status" active-color="#13ce66" inactive-color="#ff4949"> </el-switch>
                <div v-if="form.errors.has('status')" class="el-form-item__error" v-text="form.errors.first('status')"></div>
              </el-form-item>
              <br />
              <single-media
                :entity-id="category.id"
                zone="blog_category_banner"
                entity="Modules\Blog\Entities\Category"
                @single-file-selected="selectSingleFile($event, 'category')"
              ></single-media>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.blog.category.index' })"></button>
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

export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
  },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: {
      default: null,
      type: Object,
    },
    blogTitle: {
      default: null,
      type: String,
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
            parent_id: "",
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
          status: false,
        })
        .value(),
      categories: [
        {
          id: "",
          title: "",
        },
      ],
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
    };
  },
  mounted() {
    if (this.$route.params.categoryId !== undefined) {
      this.fetchCategory();
      this.fetchCategoryAll();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
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
            name: "admin.blog.category.index",
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
        name: "admin.blog.category.index",
      });
    },
    generateSlug(event, locale) {
      this.category[locale].slug = this.slugify(this.category[locale].title);
    },
    fetchCategory() {
      this.loading = true;
      axios
        .get(
          route("api.blog.category.find", {
            categoryId: this.$route.params.categoryId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.category = response.data.data;
        });
    },
    fetchCategoryAll() {
      this.loading = true;
      axios.get(route("api.blog.category.all")).then((response) => {
        this.loading = false;
        this.categories = response.data.data;
      });
    },
    getRoute() {
      if (this.$route.params.categoryId !== undefined) {
        return route("api.blog.category.update", {
          category: this.$route.params.categoryId,
        });
      }
      return route("api.blog.category.store");
    },
  },
};
</script>
