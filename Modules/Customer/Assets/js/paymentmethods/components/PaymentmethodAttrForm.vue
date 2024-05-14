<template>
  <div>
    <el-dialog
      title="Payment Method Attr"
      :visible.sync="dialogFormVisible"
      width="50%"
      top="0"
      :close-on-click-modal="false"
    >
      <el-form
        ref="form"
        :model="paymentmethodAttr"
        label-width="120px"
        label-position="top"
        @keydown="form.errors.clear($event.target.name)"
      >
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
                  :label="trans('packages.form.title')"
                  :class="{
                    'el-form-item is-error': form.errors.has(locale + '.title'),
                  }"
                >
                  <el-input
                    v-model="paymentmethodAttr[locale].title"
                  ></el-input>
                  <div
                    v-if="form.errors.has(locale + '.title')"
                    class="el-form-item__error"
                    v-text="form.errors.first(locale + '.title')"
                  ></div>
                </el-form-item>
              </el-tab-pane>
            </el-tabs>
            <el-form-item
              label="Type"
              :class="{
                'el-form-item is-error': form.errors.has('type'),
              }"
            >
              <el-select v-model="paymentmethodAttr.type" placeholder="Select">
                <el-option
                  v-for="item in types"
                  :key="item"
                  :label="item"
                  :value="item"
                >
                </el-option>
              </el-select>
              <div
                v-if="form.errors.has('title')"
                class="el-form-item__error"
                v-text="form.errors.first('title')"
              ></div>
            </el-form-item>
            <el-checkbox v-model="paymentmethodAttr.is_require"
              >Is Require</el-checkbox
            >
            <br />
            <el-checkbox v-model="paymentmethodAttr.is_show"
              >Show title</el-checkbox
            >
            <br />
            <el-form-item>
              <el-button
                :loading="loading"
                type="primary"
                @click="submitForm()"
              >
                {{ trans("core.save") }}
              </el-button>
              <el-button @click="closeForm()">
                {{ trans("core.button.cancel") }}
              </el-button>
            </el-form-item>
          </div>
        </div>
      </el-form>
    </el-dialog>
  </div>
</template>
  <script>
import axios from "axios";
import Form from "form-backend-validation";

export default {
  props: {
    locales: {
      default: null,
      type: Object,
    },
    paymentmethodAttrId: {
      type: Number,
    },
    paymentmethodId: {
      type: Number,
    },
    dialogFormVisible: Boolean,
  },
  data() {
    return {
      paymentmethodAttr: window
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
          is_require: false,
          is_show: false,
          type: "text",
        })
        .value(),
      form: new Form(),
      activeTab: window.AsgardCMS.currentLocale || "en",
      loading: false,
      types: ["text", "number", "email"],
    };
  },
  created() {
    console.log(this.paymentmethodAttrId);
  },
  methods: {
    submitForm() {
      let dataPaymentmethodAttr = this.paymentmethodAttr;
      dataPaymentmethodAttr.paymentmethod_id = this.paymentmethodId;
      this.form = new Form(dataPaymentmethodAttr);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          if (response.errors) {
            this.$message({
              type: "error",
              message: response.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.message,
            });
          }
          this.closeForm();
        })
        .catch((error) => {
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    closeForm() {
      this.paymentmethodAttr = window
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
          is_require: false,
        })
        .value();
      this.$emit("closeForm");
    },
    getRoute() {
      if (this.paymentmethodAttrId != 0) {
        return route("api.customer.paymentmethodattr.update", {
          paymentmethodId: this.paymentmethodId,
          paymentmethodAttrId: this.paymentmethodAttrId,
        });
      } else {
        return route("api.customer.paymentmethodattr.store");
      }
    },
    fetchPaymentmethodAttr() {
      if (this.paymentmethodAttrId != 0) {
        axios
          .get(
            route("api.customer.paymentmethodattr.find", {
              paymentmethodAttrId: this.paymentmethodAttrId,
              paymentmethodId: this.paymentmethodId,
            })
          )
          .then((response) => {
            this.loading = false;
            this.paymentmethodAttr = response.data.data;
          });
      } else {
        this.closeForm();
      }
    },
  },
  watch: {
    paymentmethodAttrId: function (newVal, oldVal) {
      this.fetchPaymentmethodAttr();
    },
  },
};
</script>