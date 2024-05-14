<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`pages.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.post.post.index' }">
          {{ trans("pages.posts") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans(`pages.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form ref="form" :model="post" label-width="120px" label-position="top" @keydown="form.errors.clear($event.target.name)">
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
                    :label="trans('pages.title')"
                    :class="{ 'el-form-item is-error': form.errors.has(locale + '.title') }"
                  >
                    <el-input v-model="post[locale].title" @input="generateSlug($event, locale)"></el-input>
                    <div
                      v-if="form.errors.has(locale + '.title')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.title')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('pages.slug')"
                    :class="{ 'el-form-item is-error': form.errors.has(locale + '.slug') }"
                  >
                    <el-input v-model="post[locale].slug">
                      <el-button slot="prepend" @click="generateSlug($event, locale)">Generate</el-button>
                    </el-input>
                    <div
                      v-if="form.errors.has(locale + '.slug')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.slug')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('pages.status')"
                    :class="{ 'el-form-item is-error': form.errors.has(locale + '.status') }"
                  >
                    <el-switch v-model="post[locale].status" active-color="#13ce66" inactive-color="#ff4949"> </el-switch>
                    <div
                      v-if="form.errors.has(locale + '.status')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.status')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('pages.body')"
                    :class="{ 'el-form-item is-error': form.errors.has(locale + '.body') }"
                  >
                    <component :is="getCurrentEditor()" v-model="post[locale].body" :value="post[locale].body"></component>
                    <div
                      v-if="form.errors.has(locale + '.body')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.body')"
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
                          <el-input v-model="post[locale].meta_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.meta_description')">
                          <el-input v-model="post[locale].meta_description" type="textarea" autosize maxlength="186"></el-input>
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
                          <el-input v-model="post[locale].og_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_description')">
                          <el-input v-model="post[locale].og_description" type="textarea" autosize maxlength="186"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_type')">
                          <el-select v-model="post[locale].og_type" :placeholder="trans('pages.og_type')">
                            <el-option :label="trans('pages.facebook-types.website')" value="website"></el-option>
                            <el-option :label="trans('pages.facebook-types.product')" value="product"></el-option>
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
              <el-form-item :label="trans('pages.template')" :class="{ 'el-form-item is-error': form.errors.has('template') }">
                <el-select v-model="post.template" filterable>
                  <el-option v-for="(template, key) in templates" :key="template" :label="template" :value="key"></el-option>
                </el-select>
                <div v-if="form.errors.has('template')" class="el-form-item__error" v-text="form.errors.first('template')"></div>
              </el-form-item>

              <div class="select-tree">
                <p>{{ trans("pages.category") }}</p>

                <div v-if="post.categories" class="wrap-box-check-box">
                  <div class="wrap-box-check-box">
                    <el-checkbox-group v-model="post.categories">
                      <CheckBox :categories="categories" />
                    </el-checkbox-group>
                  </div>
                </div>
              </div>

              <tags-input v-model="post.tags" :current-tags="post.tags" namespace="asgardcms/post"></tags-input>

              <single-media
                :entity-id="post.id"
                zone="image"
                entity="Modules\Page\Entities\Page"
                @single-file-selected="selectSingleFile($event, 'post')"
              ></single-media>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.post.post.index' })"></button>
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
import CheckBox from "./CheckBox.vue";

export default {
  components: { FormErrors, SingleMedia, TagsInput, Treeselect, CheckBox },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: { default: null, type: Object },
    postTitle: { default: null, type: String },
    type: { default: null, type: String },
  },
  data() {
    return {
      post: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
            slug: "",
            body: "",
            meta_title: "",
            meta_description: "",
            og_title: "",
            og_description: "",
            og_type: "",
            status: false,
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          template: "default",
          is_home: 0,
          tags: [],
          urls: {},
          categories: [],
          type: this.type,
        })
        .value(),
      templates: {
        index: "index",
        home: "home",
        default: "default",
      },
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
      categories: [],
    };
  },
  mounted() {
    this.fetchTemplates();
    this.fetchCategory();

    if (this.$route.params.postId !== undefined) {
      this.fetchPost();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.post);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          this.$message({
            type: "success",
            message: response.message,
          });
          this.pushRoute({ name: "admin.post.post.index" });
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
      this.pushRoute({ name: "admin.post.post.index" });
    },
    fetchTemplates() {
      axios.get(route("api.post.post-templates.index", ["blog"])).then((response) => {
        this.templates = response.data;
      });
    },
    generateSlug(event, locale) {
      this.post[locale].slug = this.slugify(this.post[locale].title);
    },
    fetchPost() {
      this.loading = true;
      axios.post(route("api.post.post.find", { post: this.$route.params.postId })).then((response) => {
        this.loading = false;
        this.post = response.data.data;
        $(".publicUrl").attr("href", this.post.urls.public_url).show();
      });
    },
    getRoute() {
      if (this.$route.params.postId !== undefined) {
        return route("api.post.post.update", { post: this.$route.params.postId });
      }
      return route("api.post.post.store");
    },
    fetchCategory() {
      this.loading = true;
      axios.get(route("api.post.category.with.floor")).then((response) => {
        this.loading = false;
        this.categories = response.data.data;
      });
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

.wrap-box-check-box {
  border: 1px solid rgba(102, 102, 102, 0.3);
  padding: 8px;
}

.wrap-box-check-box .wrap-box-check-box {
  padding: 16px;
}

.check-box {
  display: block;
  margin-bottom: 0;
  padding-top: 7px;
  margin-bottom: -2px;
}

.check-box-has-child {
  padding-left: 15px;
  overflow: hidden;
  padding-top: 7px;
}
</style>
