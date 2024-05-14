<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`markets.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.market.index' }">
          {{ trans("markets.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.market.create' }">
          {{ trans(`markets.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="market"
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
                    :label="trans('markets.form.symbol')"
                    :class="{
                      'el-form-item is-error': form.errors.has('symbol'),
                    }"
                  >
                    <el-input v-model="market.symbol"></el-input>
                    <div
                      v-if="form.errors.has('symbol')"
                      class="el-form-item__error"
                      v-text="form.errors.first('symbol')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.currency_id')"
                    :class="{
                      'el-form-item is-error': form.errors.has('currency_id'),
                    }"
                  >
                    <el-select
                      v-model="market.currency_id"
                      placeholder="Select"
                    >
                      <el-option
                        v-for="item in currencies"
                        :key="item.id"
                        :label="item.title"
                        :value="item.id"
                      >
                      </el-option>
                    </el-select>
                    <div
                      v-if="form.errors.has('currency_id')"
                      class="el-form-item__error"
                      v-text="form.errors.first('currency_id')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.currency_pair_id')"
                    :class="{
                      'el-form-item is-error':
                        form.errors.has('currency_pair_id'),
                    }"
                  >
                    <el-select
                      v-model="market.currency_pair_id"
                      placeholder="Select"
                    >
                      <el-option
                        v-for="item in currencies"
                        :key="item.id"
                        :label="item.title"
                        :value="item.id"
                      >
                      </el-option>
                    </el-select>
                    <div
                      v-if="form.errors.has('currency_pair_id')"
                      class="el-form-item__error"
                      v-text="form.errors.first('currency_pair_id')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.min_amount')"
                    :class="{
                      'el-form-item is-error': form.errors.has('min_amount'),
                    }"
                  >
                    <el-input-number
                      v-model="market.min_amount"
                      :min="0"
                    ></el-input-number>
                    <div
                      v-if="form.errors.has('min_amount')"
                      class="el-form-item__error"
                      v-text="form.errors.first('min_amount')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.max_amount')"
                    :class="{
                      'el-form-item is-error': form.errors.has('max_amount'),
                    }"
                  >
                    <el-input-number
                      v-model="market.max_amount"
                      :min="0"
                    ></el-input-number>
                    <div
                      v-if="form.errors.has('max_amount')"
                      class="el-form-item__error"
                      v-text="form.errors.first('max_amount')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.taker')"
                    :class="{
                      'el-form-item is-error': form.errors.has('taker'),
                    }"
                  >
                    <el-input-number
                      v-model="market.taker"
                      :min="0"
                    ></el-input-number>
                    <div
                      v-if="form.errors.has('taker')"
                      class="el-form-item__error"
                      v-text="form.errors.first('taker')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.maker')"
                    :class="{
                      'el-form-item is-error': form.errors.has('maker'),
                    }"
                  >
                    <el-input-number
                      v-model="market.maker"
                      :min="0"
                    ></el-input-number>
                    <div
                      v-if="form.errors.has('maker')"
                      class="el-form-item__error"
                      v-text="form.errors.first('maker')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.price_usd')"
                    :class="{
                      'el-form-item is-error': form.errors.has('price_usd'),
                    }"
                  >
                    <el-input-number
                      v-model="market.price_usd"
                      :min="0"
                    ></el-input-number>
                    <div
                      v-if="form.errors.has('price_usd')"
                      class="el-form-item__error"
                      v-text="form.errors.first('price_usd')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('markets.form.type')"
                    :class="{
                      'el-form-item is-error': form.errors.has('type'),
                    }"
                  >
                    <el-select v-model="market.type" placeholder="Select">
                      <el-option
                        key="spot"
                        label="Spot"
                        value="spot"
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
              <el-form-item
                :label="trans('markets.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="market.status"
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
      @shortkey="pushRoute({ name: 'admin.post.market.index' })"
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
      market: {
        symbol: "",
        currency_id: "",
        currency_pair_id: "",
        type: "spot",
        taker: 0,
        maker: 0,
        min_amount: 0,
        max_amount: 0,
        price_usd: 0,
        status: true,
      },
      form: new Form(),
      loading: false,
      currencies: [],
    };
  },
  created() {
    this.fetchCurrencies();
    if (this.$route.params.marketId !== undefined) {
      this.fetchMarket();
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.market);
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
            name: "admin.trade.market.index",
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
        name: "admin.trade.market.index",
      });
    },
    fetchMarket() {
      this.loading = true;
      axios
        .get(
          route("api.trade.market.find", {
            marketId: this.$route.params.marketId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.market = response.data.data;
        });
    },
    fetchCurrencies() {
      axios.get(route("api.wallet.currency.all")).then((response) => {
        this.currencies = response.data.data;
      });
    },
    getRoute() {
      if (this.$route.params.marketId !== undefined) {
        return route("api.trade.market.update", {
          market: this.$route.params.marketId,
        });
      }
      return route("api.trade.market.store");
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
