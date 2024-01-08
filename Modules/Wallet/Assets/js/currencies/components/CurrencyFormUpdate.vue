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
        <el-breadcrumb-item :to="{ name: 'admin.wallet.currency.index' }">
          {{ trans("currencies.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.currency.create' }">
          {{ trans(`currencies.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <el-tabs type="border-card">
      <el-tab-pane label="Currency">
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
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.title')"
                        :class="{
                          'el-form-item is-error': form.errors.has('title'),
                        }"
                      >
                        <el-input v-model="currency.title"></el-input>
                        <div
                          v-if="form.errors.has('title')"
                          class="el-form-item__error"
                          v-text="form.errors.first('title')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.type')"
                        :class="{
                          'el-form-item is-error': form.errors.has('type'),
                        }"
                      >
                        <el-select v-model="currency.type" placeholder="Select">
                          <el-option
                            key="CRYPTO"
                            label="CRYPTO"
                            value="CRYPTO"
                          ></el-option>
                          <el-option
                            key="FIAT"
                            label="FIAT"
                            value="FIAT"
                          ></el-option>
                        </el-select>
                        <div
                          v-if="form.errors.has('type')"
                          class="el-form-item__error"
                          v-text="form.errors.first('type')"
                        ></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.min_crawl')"
                        :class="{
                          'el-form-item is-error': form.errors.has('min_crawl'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.min_crawl"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('min_crawl')"
                          class="el-form-item__error"
                          v-text="form.errors.first('min_crawl')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.transfer_fee')"
                        :class="{
                          'el-form-item is-error':
                            form.errors.has('transfer_fee'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.transfer_fee"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('transfer_fee')"
                          class="el-form-item__error"
                          v-text="form.errors.first('transfer_fee')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.transfer_fee_type')"
                        :class="{
                          'el-form-item is-error':
                            form.errors.has('transfer_fee_type'),
                        }"
                      >
                        <el-select
                          v-model="currency.transfer_fee_type"
                          placeholder="Select"
                        >
                          <el-option
                            :key="0"
                            label="Fixed"
                            :value="0"
                          ></el-option>
                          <el-option
                            :key="1"
                            label="Percent"
                            :value="1"
                          ></el-option>
                        </el-select>
                        <div
                          v-if="form.errors.has('transfer_fee_type')"
                          class="el-form-item__error"
                          v-text="form.errors.first('transfer_fee_type')"
                        ></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.swap_enable')"
                        :class="{
                          'el-form-item is-error':
                            form.errors.has('swap_enable'),
                        }"
                      >
                        <el-select
                          v-model="currency.swap_enable"
                          placeholder="Select"
                          multiple
                        >
                          <el-option
                            v-for="item in currencies"
                            :key="item.id"
                            :label="item.title"
                            :value="item.id"
                          ></el-option>
                        </el-select>
                        <div
                          v-if="form.errors.has('swap_fee')"
                          class="el-form-item__error"
                          v-text="form.errors.first('swap_fee')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.swap_fee')"
                        :class="{
                          'el-form-item is-error': form.errors.has('swap_fee'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.swap_fee"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('swap_fee')"
                          class="el-form-item__error"
                          v-text="form.errors.first('swap_fee')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.swap_fee_type')"
                        :class="{
                          'el-form-item is-error':
                            form.errors.has('swap_fee_type'),
                        }"
                      >
                        <el-select
                          v-model="currency.swap_fee_type"
                          placeholder="Select"
                        >
                          <el-option
                            :key="0"
                            label="Fixed"
                            :value="0"
                          ></el-option>
                          <el-option
                            :key="1"
                            label="Percent"
                            :value="1"
                          ></el-option>
                        </el-select>
                        <div
                          v-if="form.errors.has('swap_fee_type')"
                          class="el-form-item__error"
                          v-text="form.errors.first('swap_fee_type')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.min_swap')"
                        :class="{
                          'el-form-item is-error': form.errors.has('min_swap'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.min_swap"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('min_swap')"
                          class="el-form-item__error"
                          v-text="form.errors.first('min_swap')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.max_swap')"
                        :class="{
                          'el-form-item is-error': form.errors.has('max_swap'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.max_swap"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('max_swap')"
                          class="el-form-item__error"
                          v-text="form.errors.first('max_swap')"
                        ></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.usd_rate')"
                        :class="{
                          'el-form-item is-error': form.errors.has('usd_rate'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.usd_rate"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('usd_rate')"
                          class="el-form-item__error"
                          v-text="form.errors.first('usd_rate')"
                        ></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item
                        :label="trans('currencies.form.total_supply')"
                        :class="{
                          'el-form-item is-error': form.errors.has('total_supply'),
                        }"
                      >
                        <el-input-number
                          v-model="currency.total_supply"
                          :min="0"
                        ></el-input-number>
                        <div
                          v-if="form.errors.has('total_supply')"
                          class="el-form-item__error"
                          v-text="form.errors.first('total_supply')"
                        ></div>
                      </el-form-item>
                    </div>
                  </div>
                  <single-media
                    :entity-id="currency.id"
                    zone="CURRENCY_ICON"
                    entity="Modules\Wallet\Entities\Currency"
                    @single-file-selected="selectSingleFile($event, 'currency')"
                  ></single-media>
                  <br />
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
      </el-tab-pane>
      <el-tab-pane label="CurrencyAttr">
        <CurrencyAttrForm
          v-if="currencyId != null"
          :currencyId="currencyId"
          :currencies="currencies"
        />
      </el-tab-pane>
    </el-tabs>
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
import CurrencyAttrForm from "./CurrencyAttrForm.vue";
export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
    Treeselect,
    CurrencyAttrForm,
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
        code: "",
        title: "",
        type: "",
        min_crawl: 0,
        transfer_fee: 0,
        transfer_fee_type: 0,
        swap_enable: [],
        swap_fee: 0,
        swap_fee_type: 0,
        min_swap: 0,
        max_swap: 0,
        total_supply: 0,
        usd_rate: 0,
        link_rate: "",
        status: true,
      },
      currencies: [],
      fetchCurrencyAttrs: [],
      form: new Form(),
      currencyId: null,
      loading: false,
    };
  },
  created() {
    this.fetchArrCurrency();
    if (this.$route.params.currencyId !== undefined) {
      this.fetchCurrency();
      this.fetchCurrencyAttr();
      this.currencyId = +this.$route.params.currencyId;
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    fetchArrCurrency() {
      axios.get(route("api.wallet.currency.all")).then((response) => {
        this.currencies = response.data.data;
      });
    },
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
            name: "admin.wallet.currency.index",
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
        name: "admin.wallet.currency.index",
      });
    },
    fetchCurrency() {
      this.loading = true;
      axios
        .get(
          route("api.wallet.currency.find", {
            currencyId: this.$route.params.currencyId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.currency = response.data.data;
        });
    },
    fetchCurrencyAttr() {
      this.loading = true;
      axios
        .get(
          route("api.wallet.currency.find", {
            currencyId: this.$route.params.currencyId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.currency = response.data.data;
        });
    },
    getRoute() {
      return route("api.wallet.currency.update", {
        currency: this.$route.params.currencyId,
      });
    },
  },
};
</script>