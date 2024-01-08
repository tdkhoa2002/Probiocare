<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`services.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.cryperrswap.service.index' }">
          {{ trans("services.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.cryperrswap.service.create' }">
          {{ trans(`services.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="service"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <form-errors :form="form"></form-errors>
      <div class="row">
        <div class="col-md-12">
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
                    :label="trans('services.form.title')"
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        locale + '.title'
                      ),
                    }"
                  >
                    <el-input v-model="service[locale].title"></el-input>
                    <div
                      v-if="form.errors.has(locale + '.title')"
                      class="el-form-item__error"
                      v-text="form.errors.first(locale + '.title')"
                    ></div>
                  </el-form-item>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item
                :label="trans('services.form.code')"
                :class="{
                  'el-form-item is-error': form.errors.has('code'),
                }"
              >
                <el-input v-model="service.code" ></el-input>
                <div
                  v-if="form.errors.has('code')"
                  class="el-form-item__error"
                  v-text="form.errors.first('code')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('services.form.api_key')"
                :class="{
                  'el-form-item is-error': form.errors.has('api_key'),
                }"
              >
                <el-input v-model="service.api_key" ></el-input>
                <div
                  v-if="form.errors.has('api_key')"
                  class="el-form-item__error"
                  v-text="form.errors.first('api_key')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('services.form.serect_key')"
                :class="{
                  'el-form-item is-error': form.errors.has('serect_key'),
                }"
              >
                <el-input v-model="service.serect_key" ></el-input>
                <div
                  v-if="form.errors.has('serect_key')"
                  class="el-form-item__error"
                  v-text="form.errors.first('serect_key')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('services.form.refcode')"
                :class="{
                  'el-form-item is-error': form.errors.has('refcode'),
                }"
              >
                <el-input v-model="service.refcode" ></el-input>
                <div
                  v-if="form.errors.has('refcode')"
                  class="el-form-item__error"
                  v-text="form.errors.first('refcode')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('services.form.afftax')"
                :class="{
                  'el-form-item is-error': form.errors.has('afftax'),
                }"
              >
                <el-input-number v-model="service.afftax" :min="0" ></el-input-number>
                <div
                  v-if="form.errors.has('afftax')"
                  class="el-form-item__error"
                  v-text="form.errors.first('afftax')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('services.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="service.status"
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
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button
      v-show="false"
      v-shortkey="['b']"
      @shortkey="pushRoute({ name: 'admin.post.service.index' })"
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
    postTitle: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      service: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          status: false,
          code: "",
          api_key: "",
          serect_key: "",
          recode: "",
          afftax:0
        })
        .value(),
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
  mounted() {
    if (this.$route.params.serviceId !== undefined) {
      this.fetchService();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.service);
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
            name: "admin.cryperrswap.service.index",
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
        name: "admin.cryperrswap.service.index",
      });
    },
    fetchService() {
      this.loading = true;
      axios
        .get(
          route("api.cryperrswap.service.find", {
            serviceId: this.$route.params.serviceId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.service = response.data.data;
        });
    },
    getRoute() {
      if (this.$route.params.serviceId !== undefined) {
        return route("api.cryperrswap.service.update", {
          service: this.$route.params.serviceId,
        });
      }
      return route("api.cryperrswap.service.store");
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
