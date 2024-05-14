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
        <el-breadcrumb-item :to="{ name: 'admin.blog.blog.index' }">
          {{ trans("blogs.blogs") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.blog.blog.create' }">
          {{ trans(`blogs.${blogTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form ref="form" :model="blog" label-width="120px" label-position="top" @keydown="form.errors.clear($event.target.name)">
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
                    <el-input v-model="blog[locale].title" @input="generateSlug($event, locale)"></el-input>
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
                    <el-input v-model="blog[locale].slug">
                      <el-button slot="prepend" @click="generateSlug($event, locale)">Generate</el-button>
                    </el-input>
                    <div
                      v-if="form.errors.has(locale + '.slug')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.slug')"
                    ></div>
                  </el-form-item>

                  <el-form-item
                    :label="trans('blogs.sumary')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.sumary'),
                    }"
                  >
                    <el-input v-model="blog[locale].sumary" type="textarea" rows="4"></el-input>
                    <div
                      v-if="form.errors.has(locale + '.sumary')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.sumary')"
                    ></div>
                  </el-form-item>
                  <el-form-item
                    :label="trans('blogs.body')"
                    :class="{
                      'el-form-item is-error': form.errors.has(locale + '.body'),
                    }"
                  >
                    <component :is="getCurrentEditor()" v-model="blog[locale].body" :value="blog[locale].body"></component>
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
                          <el-input v-model="blog[locale].meta_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.meta_description')">
                          <el-input v-model="blog[locale].meta_description" type="textarea" autosize maxlength="186"></el-input>
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
                          <el-input v-model="blog[locale].og_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_description')">
                          <el-input v-model="blog[locale].og_description" type="textarea" autosize maxlength="186"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('pages.og_type')">
                          <el-select v-model="blog[locale].og_type" :placeholder="trans('pages.og_type')">
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
                :label="trans('blogs.category')"
                :class="{
                  'el-form-item is-error': form.errors.has('template'),
                }"
              >
                <el-select v-model="blog.category_id" filterable>
                  <el-option
                    v-for="category in categories"
                    :key="category.id"
                    :label="category.translations.title"
                    :value="category.id"
                  ></el-option>
                </el-select>
                <div v-if="form.errors.has('template')" class="el-form-item__error" v-text="form.errors.first('template')"></div>
              </el-form-item>
              <el-form-item
                :label="trans('blogs.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch v-model="blog.status" active-color="#13ce66" inactive-color="#ff4949"> </el-switch>
                <div v-if="form.errors.has('status')" class="el-form-item__error" v-text="form.errors.first('status')"></div>
              </el-form-item>
              <el-form-item
                :label="trans('blogs.show_homepage')"
                :class="{
                  'el-form-item is-error': form.errors.has('show_homepage'),
                }"
              >
                <el-switch v-model="blog.show_homepage" active-color="#13ce66" inactive-color="#ff4949"> </el-switch>
                <div
                  v-if="form.errors.has('show_homepage')"
                  class="el-form-item__error"
                  v-text="form.errors.first('show_homepage')"
                ></div>
              </el-form-item>
              <single-media
                :entity-id="blog.id"
                zone="blog_avatar"
                entity="Modules\blog\Entities\blog"
                @single-file-selected="selectSingleFile($event, 'blog')"
              ></single-media>
              <br />
              <single-media
                :entity-id="blog.id"
                zone="blog_banner"
                entity="Modules\blog\Entities\blog"
                @single-file-selected="selectSingleFile($event, 'blog')"
              ></single-media>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.blog.blog.index' })"></button>
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
  components: { FormErrors, SingleMedia, TagsInput },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: { default: null, type: Object },
    blogTitle: { default: null, type: String },
  },
  data() {
    return {
      blog: window
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
          },
        ])
        .fromPairs()
        .merge({ id: null, status: false })
        .value(),
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
      categories: [],
    };
  },
  mounted() {
    if (this.$route.params.blogId !== undefined) {
      this.fetchBlog();
    }

    this.fetchCategory();
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.blog);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          this.$message({
            type: "success",
            message: response.message,
          });
          this.pushRoute({ name: "admin.blog.blog.index" });
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
      this.pushRoute({ name: "admin.blog.blog.index" });
    },
    generateSlug(event, locale) {
      this.blog[locale].slug = this.slugify(this.blog[locale].title);
    },
    fetchBlog() {
      this.loading = true;
      axios
        .get(
          route("api.blog.blog.find", {
            blogId: this.$route.params.blogId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.blog = response.data.data;
          $(".publicUrl").attr("href", this.blog.urls.public_url).show();
        });
    },
    fetchCategory() {
      this.loading = true;
      axios.get(route("api.blog.category.all")).then((response) => {
        this.loading = false;
        this.categories = response.data.data;
      });
    },
    getRoute() {
      if (this.$route.params.blogId !== undefined) {
        return route("api.blog.blog.update", {
          blog: this.$route.params.blogId,
        });
      }
      return route("api.blog.blog.store");
    },
  },
};
</script>
