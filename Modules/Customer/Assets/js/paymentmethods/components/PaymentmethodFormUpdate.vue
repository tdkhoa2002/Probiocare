<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`paymentmethods.title.${paymentmethodTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item
          :to="{ name: 'admin.customer.paymentmethod.index' }"
        >
          {{ trans("paymentmethods.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item
          :to="{ name: 'admin.customer.paymentmethod.create' }"
        >
          {{ trans(`paymentmethods.title.${paymentmethodTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="box box-primary">
      <div class="box-body">
        <el-tabs v-model="activeNameTab">
          <el-tab-pane label="Payment Method" name="first">
            <el-form
              ref="form"
              :model="paymentmethod"
              label-width="120px"
              label-position="top"
              @keydown="form.errors.clear($event.target.name)"
            >
              <div class="row">
                <div class="col-md-12">
                  <el-tabs v-model="activeTab">
                    <el-tab-pane
                      v-for="(localeArray, locale) in locales"
                      :key="localeArray.name"
                      :label="localeArray.name"
                      :name="locale"
                    >
                      <span
                        slot="label"
                        :class="{ error: form.errors.has(locale) }"
                        ><i :class="'flag-icon flag-icon-' + locale"></i> &nbsp;
                        {{ localeArray.name }}</span
                      >
                      <el-form-item
                        :label="trans('paymentmethods.form.title')"
                        :class="{
                          'el-form-item is-error': form.errors.has(
                            locale + '.title'
                          ),
                        }"
                      >
                        <el-input
                          v-model="paymentmethod[locale].title"
                        ></el-input>
                        <div
                          v-if="form.errors.has(locale + '.title')"
                          class="el-form-item__error"
                          v-text="form.errors.first(locale + '.title')"
                        ></div>
                      </el-form-item>
                    </el-tab-pane>
                  </el-tabs>
                  <single-media
                    :entity-id="paymentmethod.id"
                    zone="PAYMEN_METHOD_LOGO"
                    entity="Modules\Customer\Entities\Paymentmethod"
                    @single-file-selected="
                      selectSingleFile($event, 'paymentmethod')
                    "
                  ></single-media>
                  <br />
                  <el-form-item
                    :label="trans('paymentmethods.form.status')"
                    :class="{
                      'el-form-item is-error': form.errors.has('status'),
                    }"
                  >
                    <el-switch
                      v-model="paymentmethod.status"
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
            </el-form>
          </el-tab-pane>
          <el-tab-pane label="Payment Method Attr" name="second">
            <PaymentmethodAttrTable
              :paymentmethodId="paymentmethodId"
              :locales="locales"
            ></PaymentmethodAttrTable>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
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
import PaymentmethodAttrTable from "./PaymentmethodAttrTable.vue";

export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
    PaymentmethodAttrTable,
  },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: {
      default: null,
      type: Object,
    },
    paymentmethodTitle: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      activeNameTab: "first",
      paymentmethod: window
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
          status: true,
        })
        .value(),
      form: new Form(),
      activeTab: window.AsgardCMS.currentLocale || "en",
      loading: false,
      currencies: [],
      paymentmethodId: +this.$route.params.paymentmethodId,
    };
  },
  created() {
    this.fetchPaymentMethod();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.paymentmethod);
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
            name: "admin.customer.paymentmethod.index",
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
        name: "admin.customer.paymentmethod.index",
      });
    },
    fetchPaymentMethod() {
      this.loading = true;
      axios
        .get(
          route("api.customer.paymentmethod.find", {
            paymentmethodId: this.$route.params.paymentmethodId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.paymentmethod = response.data.data;
        });
    },
    getRoute() {
      return route("api.customer.paymentmethod.update", {
        paymentmethod: this.$route.params.paymentmethodId,
      });
    },
  },
};
</script>