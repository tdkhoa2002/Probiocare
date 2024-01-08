<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`targetprices.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.targetprice.index' }">
          {{ trans("targetprices.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.targetprice.create' }">
          {{ trans(`targetprices.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="row">
      <div class="col-md-8">
        <el-form ref="form" :model="targetPrice" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item :label="trans('targetprices.form.schedule')" :class="{
                        'el-form-item is-error': form.errors.has('schedule'),
                      }">
                        <el-date-picker v-model="targetPrice.schedule" type="datetime" placeholder="Pick a day"
                          format="yyyy/MM/dd HH:mm:ss" value-format="yyyy/MM/dd HH:mm:ss">
                        </el-date-picker>
                        <div v-if="form.errors.has('schedule')" class="el-form-item__error"
                          v-text="form.errors.first('schedule')">
                        </div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('targetprices.form.symbol')" :class="{
                        'el-form-item is-error': form.errors.has('symbol'),
                      }">
                        <el-select v-model="targetPrice.symbol" placeholder="Select" @change="onSelectMarket">
                          <el-option v-for="item in markets" :key="item.id" :label="item.symbol" :value="item.symbol">
                          </el-option>
                        </el-select>
                        <div v-if="form.errors.has('symbol')" class="el-form-item__error"
                          v-text="form.errors.first('symbol')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('targetprices.form.price')" :class="{
                        'el-form-item is-error': form.errors.has('price'),
                      }">
                        <el-input-number v-model="targetPrice.price" :min="0"></el-input-number>
                        <div v-if="form.errors.has('price')" class="el-form-item__error"
                          v-text="form.errors.first('price')">
                        </div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item>
                        <el-button :loading="loading" type="primary" @click="onSubmit()">
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
            </div>
          </div>
        </el-form>
      </div>

      <div class="col-md-4">
        <el-form ref="formCustomerBot" :model="targetPriceCustomerBot" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('targetprices.form.customer')" :class="{
                        'el-form-item is-error':
                          form.errors.has('customer_id'),
                      }">
                        <el-select v-model="targetPriceCustomerBot.customer_id" filterable reserve-keyword remote
                          placeholder="Please enter an email" :remote-method="queryCustomers">
                          <el-option v-for="item in customers" :key="item.id" :label="item.email" :value="item.id">
                          </el-option>
                        </el-select>
                        <div v-if="form.errors.has('customer_id')" class="el-form-item__error"
                          v-text="form.errors.first('customer_id')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item>
                        <el-button :loading="loading" type="primary" @click="onSubmitSetBot()">
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
            </div>
          </div>
        </el-form>

      </div>
      <div class="col-md-12">
        <el-form ref="form" :model="targetPrice" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="sc-table">
                    <div class="tool-bar el-row" style="padding-bottom: 20px">
                      <div class="search el-col el-col-5">
                        <el-input v-model="search" prefix-icon="el-icon-search" @keyup.native="performSearch"></el-input>
                      </div>
                    </div>

                    <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="data" stripe style="width: 100%"
                      @sort-change="handleSortChange">
                      <el-table-column :label="trans('targetprices.table.status')" width="100">
                        <template slot-scope="scope">
                          <i :class="scope.row.status == true
                            ? 'text-success'
                            : 'text-danger'
                            " class="fa fa-circle"></i>
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('targetprices.table.symbol')" prop="symbol">
                        <template slot-scope="scope">
                          <a :href="editRoute(scope)" @click.prevent="goToEdit(scope)">
                            {{ scope.row.symbol }}
                          </a>
                        </template>
                      </el-table-column>

                      <el-table-column :label="trans('targetprices.table.price')" prop="service_base_id">
                        <template slot-scope="scope">
                          {{ scope.row.price }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('targetprices.table.amount')" prop="service_quote_id">
                        <template slot-scope="scope">
                          {{ scope.row.amount }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('targetprices.table.schedule')" prop="schedule" sortable="custom">
                      </el-table-column>
                      <el-table-column :label="trans('core.table.created at')" prop="created_at" sortable="custom">
                      </el-table-column>
                      <el-table-column :label="trans('core.table.actions')" prop="actions">
                        <template slot-scope="scope">
                          <el-button-group>
                            <el-button type="info" icon="el-icon-edit" size="mini"
                              @click="editTargetPrice(scope.row)"></el-button>
                            <delete-button :scope="scope" :rows="data"></delete-button>
                          </el-button-group>
                        </template>
                      </el-table-column>
                    </el-table>
                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px">
                      <el-pagination :current-page.sync="meta.current_page" :page-sizes="[10, 20, 30, 50, 100]"
                        :page-size="parseInt(meta.per_page)" :total="meta.total"
                        layout="total, sizes, prev, pager, next, jumper" @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"></el-pagination>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </el-form>
      </div>
    </div>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.trade.targetprice.index' })"></button>
  </div>
</template>

<script>
import moment from 'moment';
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
import debounce from "lodash/debounce";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import EditButton from "../../../../../Core/Assets/js/components/EditButtonComponent.vue";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";

let data;

export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
    Treeselect,
    DeleteButton,
    EditButton
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
      data,
      meta: {
        current_page: 1,
        per_page: 30,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      links: {},
      search: null,
      tableIsLoading: false,

      targetPrice: {
        id: "",
        market_id: "",
        symbol: "",
        price: 0,
        amount: "",
        status: 1,
        schedule: moment.utc().format('YYYY/MM/DD HH:mm:ss')
      },
      targetPriceCustomerBot: {
        customer_id: ""
      },
      form: new Form(),
      loading: false,
      markets: [],
      customers: []
    };
  },
  created() {
    this.fetchMarkets();
    if (this.$route.params.targetPriceId != undefined) {
      this.fetchTargetPrice();
    }
    this.getSettingBotCustomer();
  },
  mounted() {
    const searchParam = this.$route.query.search;
    if (searchParam) {
      this.search = searchParam;
    }
    this.fetchData();
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    editTargetPrice(data) {
      const selectedMarket = this.markets.find((market) => market.symbol === data.symbol);
      this.targetPrice.market_id = selectedMarket.id;
      this.targetPrice.id = data.id;
      this.targetPrice.schedule = data.schedule;
      this.targetPrice.price = data.price;
      this.targetPrice.amount = data.amount;
      this.targetPrice.symbol = data.symbol;
    },
    onSelectMarket(selectedSymbol) {
      const selectedMarket = this.markets.find((market) => market.symbol === selectedSymbol);
      this.targetPrice.symbol = selectedSymbol;
      this.targetPrice.market_id = selectedMarket.id;
      this.fetchData(selectedSymbol);
    },
    onSubmit() {
      this.form = new Form(this.targetPrice);
      this.loading = true;
      this.form
        .post(this.getRoute(this.targetPrice.id))
        .then((response) => {
          this.loading = false;
          if (response.data.errors == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
            return false;
          } else {
            this.$message({
              type: "success",
              message: response.data.message,
            });
            this.pushRoute({
              name: "admin.marketmaker.targetprice.index",
              query: {
                pair: this.targetPrice.symbol
              }
            })
            this.fetchData(this.targetPrice.symbol);
            this.initTargetPrice();
          }
        })
        .catch((error) => {
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    onSubmitSetBot() {
      axios.post(route("api.marketmaker.targetprice.setBotTrade"), {
        customer_id: this.targetPriceCustomerBot.customer_id
      })
        .then((response) => {
          console.log(response);
          this.loading = false;
          if (response.data.errors == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.data.message,
            });
            return false;
          } else {
            this.$message({
              type: "success",
              message: response.data.data.message,
            });
          }
        })
        .catch((error) => {
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    initTargetPrice() {
      this.targetPrice.market_id = "";
      this.targetPrice.id = "";
      this.targetPrice.schedule = moment.utc().format('YYYY/MM/DD HH:mm:ss');
      this.targetPrice.price = 0;
      this.targetPrice.amount = "";
      this.targetPrice.symbol = "";
    },
    fetchTargetPrice() {
      this.loading = true;
      axios
        .get(
          route("api.marketmaker.targetprice.find", {
            targetprice: this.$route.params.targetPriceId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.targetPrice = response.data.data;
        });
    },
    fetchMarkets() {
      axios.get("/api/trade/getListMarket")
        .then((response) => {
          if (response.data.error === false) {
            this.markets = response.data.data.markets;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getRoute(id) {
      console.log(id);
      if (id !== "") {
        return route("api.marketmaker.targetprice.update", {
          targetprice: id,
        });
      }
      return route("api.marketmaker.targetprice.store");
    },
    queryCustomers(query) {
      if (query !== "") {
        axios
          .get(route("api.customer.customer.allwithfilter", { query: query }))
          .then((response) => {
            this.customers = response.data.data;
          });
      } else {
        this.customers = [];
      }
    },
    getSettingBotCustomer() {
      axios.get(route('api.marketmaker.targetprice.getBotTrade'))
        .then((response) => {
          const customer = response.data.data.customer;
          if (customer) {
            this.customers = [
              {
                id: customer.id,
                email: customer.email
              }
            ]
            this.targetPriceCustomerBot.customer_id = customer.id;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    queryServer(customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.search,
      };

      axios
        .get(
          route("api.marketmaker.targetprice.indexServerSide", {
            ...properties,
            ...customProperties
          })
        )
        .then((response) => {
          this.tableIsLoading = false;
          this.data = response.data.data;
          this.meta = response.data.meta;
          this.links = response.data.links;
          this.search = properties.search;

          this.order_meta.order_by = properties.order_by;
          this.order_meta.order = properties.order;
        });
    },
    fetchData(query) {
      this.tableIsLoading = true;
      this.queryServer({ pair: query });
    },
    handleSizeChange(event) {
      console.log(`per page :${event}`);
      this.tableIsLoading = true;
      this.queryServer({ per_page: event });
    },
    handleCurrentChange(event) {
      console.log(`current page :${event}`);
      this.tableIsLoading = true;
      this.queryServer({ page: event });
    },
    handleSortChange(event) {
      console.log("sorting", event);
      this.tableIsLoading = true;
      this.queryServer({ order_by: event.prop, order: event.order });
    },
    performSearch: debounce(function (query) {
      console.log(`searching:${query.target.value}`);
      this.tableIsLoading = true;
      this.queryServer({ search: query.target.value });
    }, 300),
    goToEdit(data) {
      this.pushRoute({
        name: "admin.marketmaker.targetprice.edit",
        params: { targetPriceId: data.id },
      });
    },
    editRoute(scope) {
      return route("admin.marketmaker.targetprice.edit", [scope.row.id]);
    }
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