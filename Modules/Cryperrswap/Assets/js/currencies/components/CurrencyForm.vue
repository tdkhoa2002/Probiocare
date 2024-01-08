<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`currencies.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.cryperrswap.currency.index' }">
          {{ trans("currencies.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.cryperrswap.currency.create' }">
          {{ trans(`currencies.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="currency"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item
                :label="trans('currencies.form.service_id')"
                :class="{
                  'el-form-item is-error': form.errors.has('service_id'),
                }"
              >
                <el-select v-model="currency.service_id" placeholder="Select">
                  <el-option
                    v-for="item in services"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
                <div
                  v-if="form.errors.has('service_id')"
                  class="el-form-item__error"
                  v-text="form.errors.first('service_id')"
                ></div>
              </el-form-item>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.code')"
                    :class="{
                      'el-form-item is-error': form.errors.has('code'),
                    }"
                  >
                    <el-input v-model="currency.code"></el-input>
                    <div
                      v-if="form.errors.has('code')"
                      class="el-form-item__error"
                      v-text="form.errors.first('code')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.coin')"
                    :class="{
                      'el-form-item is-error': form.errors.has('coin'),
                    }"
                  >
                    <el-input v-model="currency.coin"></el-input>
                    <div
                      v-if="form.errors.has('coin')"
                      class="el-form-item__error"
                      v-text="form.errors.first('coin')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.name')"
                    :class="{
                      'el-form-item is-error': form.errors.has('name'),
                    }"
                  >
                    <el-input v-model="currency.name"></el-input>
                    <div
                      v-if="form.errors.has('name')"
                      class="el-form-item__error"
                      v-text="form.errors.first('name')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.network')"
                    :class="{
                      'el-form-item is-error': form.errors.has('network'),
                    }"
                  >
                    <el-input v-model="currency.network"></el-input>
                    <div
                      v-if="form.errors.has('network')"
                      class="el-form-item__error"
                      v-text="form.errors.first('network')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.send')"
                    :class="{
                      'el-form-item is-error': form.errors.has('send'),
                    }"
                  >
                    <el-switch
                      v-model="currency.send"
                      active-color="#13ce66"
                      inactive-color="#ff4949"
                    >
                    </el-switch>
                    <div
                      v-if="form.errors.has('send')"
                      class="el-form-item__error"
                      v-text="form.errors.first('send')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.recv')"
                    :class="{
                      'el-form-item is-error': form.errors.has('recv'),
                    }"
                  >
                    <el-switch
                      v-model="currency.recv"
                      active-color="#13ce66"
                      inactive-color="#ff4949"
                    >
                    </el-switch>
                    <div
                      v-if="form.errors.has('recv')"
                      class="el-form-item__error"
                      v-text="form.errors.first('recv')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.tag')"
                    :class="{
                      'el-form-item is-error': form.errors.has('tag'),
                    }"
                  >
                    <el-input v-model="currency.tag"></el-input>
                    <div
                      v-if="form.errors.has('tag')"
                      class="el-form-item__error"
                      v-text="form.errors.first('tag')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('currencies.form.logo')"
                    :class="{
                      'el-form-item is-error': form.errors.has('logo'),
                    }"
                  >
                    <el-input v-model="currency.logo"></el-input>
                    <div
                      v-if="form.errors.has('logo')"
                      class="el-form-item__error"
                      v-text="form.errors.first('logo')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <el-form-item
                :label="trans('currencies.form.color')"
                :class="{
                  'el-form-item is-error': form.errors.has('color'),
                }"
              >
                <el-color-picker v-model="currency.color"></el-color-picker>
                <div
                  v-if="form.errors.has('color')"
                  class="el-form-item__error"
                  v-text="form.errors.first('color')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('currencies.form.priority')"
                :class="{
                  'el-form-item is-error': form.errors.has('priority'),
                }"
              >
                <el-input-number
                  v-model="currency.priority"
                  :min="1"
                ></el-input-number>
                <div
                  v-if="form.errors.has('priority')"
                  class="el-form-item__error"
                  v-text="form.errors.first('priority')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('currencies.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="currency.status"
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
      @shortkey="pushRoute({ name: 'admin.post.currency.index' })"
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
      currency: {
        id: null,
        service_id: "",
        code: "",
        coin: "",
        name: "",
        network: "",
        priority: 0,
        recv: false,
        send: false,
        tag: "",
        logo: "",
        color: "",
        status: false,
      },
      services: [],
      form: new Form(),
      loading: false,
    };
  },
  created() {
    this.fetchService();
    if (this.$route.params.currencyId !== undefined) {
      this.fetchCurrency();
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.currency);
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
            name: "admin.cryperrswap.currency.index",
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
        name: "admin.cryperrswap.currency.index",
      });
    },
    fetchCurrency() {
      this.loading = true;
      axios
        .get(
          route("api.cryperrswap.currency.find", {
            currencyId: this.$route.params.currencyId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.currency = response.data.data;
        });
    },
    fetchService() {
      axios.get(route("api.cryperrswap.service.all")).then((response) => {
        this.services = response.data.data;
      });
    },
    getRoute() {
      if (this.$route.params.currencyId !== undefined) {
        return route("api.cryperrswap.currency.update", {
          currency: this.$route.params.currencyId,
        });
      }
      return route("api.cryperrswap.currency.store");
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
