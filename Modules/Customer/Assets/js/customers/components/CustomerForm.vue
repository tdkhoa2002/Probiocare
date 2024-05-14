<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`customers.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.customer.customer.index' }">
          {{ trans("customers.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.customer.customer.create' }">
          {{ trans(`customers.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="customer"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.firstname')"
                    :class="{
                      'el-form-item is-error': form.errors.has('profile.firstname'),
                    }"
                  >
                    <el-input v-model="customer.profile.firstname"></el-input>
                    <div
                      v-if="form.errors.has('profile.firstname')"
                      class="el-form-item__error"
                      v-text="form.errors.first('profile.firstname')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.lastname')"
                    :class="{
                      'el-form-item is-error': form.errors.has('profile.lastname'),
                    }"
                  >
                    <el-input v-model="customer.profile.lastname"></el-input>
                    <div
                      v-if="form.errors.has('profile.lastname')"
                      class="el-form-item__error"
                      v-text="form.errors.first('profile.lastname')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.phone_number')"
                    :class="{
                      'el-form-item is-error': form.errors.has('profile.phone_number'),
                    }"
                  >
                    <el-input v-model="customer.profile.phone_number"></el-input>
                    <div
                      v-if="form.errors.has('profile.phone_number')"
                      class="el-form-item__error"
                      v-text="form.errors.first('profile.phone_number')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.address')"
                    :class="{
                      'el-form-item is-error': form.errors.has('profile.address'),
                    }"
                  >
                    <el-input v-model="customer.profile.address"></el-input>
                    <div
                      v-if="form.errors.has('profile.address')"
                      class="el-form-item__error"
                      v-text="form.errors.first('profile.address')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.email')"
                    :class="{
                      'el-form-item is-error': form.errors.has('email'),
                    }"
                  >
                    <el-input v-model="customer.email"></el-input>
                    <div
                      v-if="form.errors.has('email')"
                      class="el-form-item__error"
                      v-text="form.errors.first('email')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.password')"
                    :class="{
                      'el-form-item is-error': form.errors.has('password'),
                    }"
                  >
                    <el-input v-model="customer.password"></el-input>
                    <div
                      v-if="form.errors.has('password')"
                      class="el-form-item__error"
                      v-text="form.errors.first('password')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.ref_code')"
                    :class="{
                      'el-form-item is-error': form.errors.has('ref_code'),
                    }"
                  >
                    <el-input v-model="customer.ref_code"></el-input>
                    <div
                      v-if="form.errors.has('ref_code')"
                      class="el-form-item__error"
                      v-text="form.errors.first('ref_code')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.birthday')"
                    :class="{
                      'el-form-item is-error': form.errors.has('birthday'),
                    }"
                  >
                    <el-date-picker
                      v-model="customer.birthday"
                      type="date"
                      placeholder="Pick a day"
                      format="yyyy/MM/dd"
                      value-format="yyyy-MM-dd"
                    >
                    </el-date-picker>
                    <div
                      v-if="form.errors.has('birthday')"
                      class="el-form-item__error"
                      v-text="form.errors.first('birthday')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.sponsor_id')"
                    :class="{
                      'el-form-item is-error': form.errors.has('sponsor_id'),
                    }"
                  >
                    <el-select
                      v-model="customer.sponsor_id"
                      filterable
                      remote
                      reserve-keyword
                      placeholder="Please enter a keyword"
                      :remote-method="remoteCustomerMethod"
                    >
                      <el-option
                        v-for="item in customers"
                        :key="item.id"
                        :label="item.email"
                        :value="item.id"
                      >
                      </el-option>
                    </el-select>
                    <div
                      v-if="form.errors.has('sponsor_id')"
                      class="el-form-item__error"
                      v-text="form.errors.first('sponsor_id')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('customers.form.status')"
                    :class="{
                      'el-form-item is-error': form.errors.has('status'),
                    }"
                  >
                    <el-switch
                      v-model="customer.status"
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
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button
      v-show="false"
      v-shortkey="['b']"
      @shortkey="pushRoute({ name: 'admin.post.customer.index' })"
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
      customer: {
        id: null,
        email: "",
        password: "",
        ref_code: "",
        gg_auth: "",
        status_gg_auth: 0,
        status_kyc: 0,
        sponsor_id: 0,
        sponsor_floor: 0,
        status: false,
        profile: {
          firstname: "",
          lastname: "",
          phone_number: "",
          address: "",
          birthday: "",
        },
      },
      customers: [],
      form: new Form(),
      loading: false,
    };
  },
  created() {
    
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.customer);
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
            name: "admin.customer.customer.index",
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
        name: "admin.customer.customer.index",
      });
    },
    getRoute() {
      return route("api.customer.customer.store");
    },
    remoteCustomerMethod(query) {
      if (query != "" && query.length > 3) {
        axios
          .get(route("api.customer.customer.allwithfilter", { query }))
          .then((response) => {
            this.customers = response.data.data;
          });
      }
    },
  },
};
</script>