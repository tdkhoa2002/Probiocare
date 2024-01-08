<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`volumnizers.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.volumnizer.index' }">
          {{ trans("volumnizers.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.trade.volumnizer.create' }">
          {{ trans(`volumnizers.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-8">
        <el-form ref="form" :model="volumnizer" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item :label="trans('volumnizers.form.symbol')" :class="{
                        'el-form-item is-error': form.errors.has('symbol'),
                      }">
                        <el-select v-model="volumnizer.symbol" placeholder="Select" @change="onSelectMarket">
                          <el-option v-for="item in markets" :key="item.id" :label="item.symbol" :value="item.symbol">
                          </el-option>
                        </el-select>
                        <div v-if="form.errors.has('symbol')" class="el-form-item__error"
                          v-text="form.errors.first('symbol')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('volumnizers.form.amount')" :class="{
                        'el-form-item is-error': form.errors.has('amount'),
                      }">
                        <el-input-number v-model="volumnizer.amount" :min="0"></el-input-number>
                        <div v-if="form.errors.has('amount')" class="el-form-item__error"
                          v-text="form.errors.first('amount')">
                        </div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('volumnizers.form.time_on_minutes')" :class="{
                        'el-form-item is-error': form.errors.has('time'),
                      }">
                        <el-input-number v-model="volumnizer.time" :min="0"></el-input-number>
                        <div v-if="form.errors.has('time')" class="el-form-item__error"
                          v-text="form.errors.first('time')">
                        </div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('volumnizers.form.start_time')" :class="{
                        'el-form-item is-error': form.errors.has('schedule'),
                      }">
                        <el-date-picker v-model="volumnizer.start_time" type="datetime" placeholder="Pick a day"
                          format="yyyy/MM/dd HH:mm:ss" value-format="yyyy/MM/dd HH:mm:ss">
                        </el-date-picker>
                        <div v-if="form.errors.has('schedule')" class="el-form-item__error"
                          v-text="form.errors.first('schedule')">
                        </div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('volumnizers.form.end_time')" :class="{
                        'el-form-item is-error': form.errors.has('schedule'),
                      }">
                        <el-date-picker v-model="volumnizer.end_time" type="datetime" placeholder="Pick a day"
                          format="yyyy/MM/dd HH:mm:ss" value-format="yyyy/MM/dd HH:mm:ss">
                        </el-date-picker>
                        <div v-if="form.errors.has('schedule')" class="el-form-item__error"
                          v-text="form.errors.first('schedule')">
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
        <el-form ref="formCustomerBot" :model="volumnizer.customer" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('volumnizers.form.customer')" :class="{
                        'el-form-item is-error':
                          form.errors.has('customer_id'),
                      }">
                        <el-select v-model="volumnizerCustomerBot.customer_id" filterable reserve-keyword remote
                          placeholder="Please enter an email" :remote-method="queryCustomers"
                          @change="onCustomerSelectChange">
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
        <el-form ref="form" :model="volumnizer" label-width="120px" label-position="top"
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
                      <el-table-column :label="trans('volumnizers.table.status')" width="100">
                        <template slot-scope="scope">
                          <i :class="scope.row.status == true
                            ? 'text-success'
                            : 'text-danger'
                            " class="fa fa-circle"></i>
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('volumnizers.table.symbol')" prop="symbol">
                        <template slot-scope="scope">
                          <a :href="editRoute(scope)" @click.prevent="goToEdit(scope)">
                            {{ scope.row.symbol }}
                          </a>
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('volumnizers.table.amount')" prop="amount">
                        <template slot-scope="scope">
                          {{ scope.row.amount }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('volumnizers.table.time_on_minutes')" prop="time" sortable="custom">
                        <template slot-scope="scope">
                          {{ scope.row.time }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('volumnizers.table.start_time')" prop="start_time" sortable="custom">
                        <template slot-scope="scope">
                          {{ scope.row.start_time }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('volumnizers.table.end_time')" prop="end_time" sortable="custom">
                        <template slot-scope="scope">
                          {{ scope.row.end_time }}
                        </template>
                      </el-table-column>
                      <el-table-column :label="trans('core.table.created at')" prop="created_at" sortable="custom">
                      </el-table-column>
                      <el-table-column :label="trans('core.table.actions')" prop="actions">
                        <template slot-scope="scope">
                          <el-button-group>
                            <el-button type="info" icon="el-icon-edit" size="mini"
                              @click="editVolumnizer(scope.row)"></el-button>
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
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.trade.volumnizer.index' })"></button>
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
import "@riophae/vue-treeselect/dist/vue-treeselect.css";
import debounce from "lodash/debounce";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import EditButton from "../../../../../Core/Assets/js/components/EditButtonComponent.vue";

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

      volumnizer: {
        id: "",
        symbol: "",
        market_id: "",
        amount: "",
        time: "",
        start_time: moment.utc().format('YYYY/MM/DD HH:mm:ss'),
        end_time: moment.utc().format('YYYY/MM/DD HH:mm:ss'),
        customer: {
          id: "",
          email: ""
        }
      },
      volumnizerCustomerBot: {
        customer_id: ""
      },
      markets: [],
      customers: [],
      form: new Form(),
      loading: false,
    };
  },
  created() {
    this.fetchMarkets();
    if (this.$route.params.volumnizer != undefined) {
      this.fetchVolumnizer();
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
    editVolumnizer(data) {
      const selectedMarket = this.markets.find((market) => market.symbol === data.symbol);
      this.volumnizer.market_id = selectedMarket.id;
      this.volumnizer.id = data.id;
      this.volumnizer.start_time = data.start_time;
      this.volumnizer.end_time = data.end_time;
      this.volumnizer.time = data.interval;
      this.volumnizer.amount = data.amount;
      this.volumnizer.symbol = data.symbol;
    },
    onSelectMarket(selectedSymbol) {
      const selectedMarket = this.markets.find((market) => market.symbol === selectedSymbol);
      this.volumnizer.symbol = selectedMarket.symbol;
      this.volumnizer.market_id = selectedMarket.id;
      this.fetchData(selectedSymbol);
    },
    fetchData(query) {
      this.tableIsLoading = true;
      this.queryServer({ pair: query });
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
          route("api.marketmaker.volumnizer.indexServerSide", {
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
    fetchVolumnizer() {
      this.loading = true;
      axios
        .get(
          route("api.marketmaker.volumnizer.find", {
            volumnizer: this.$route.params.volumnizer,
          })
        )
        .then((response) => {
          this.loading = false;
          this.volumnizer = response.data.data;
        });
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
            this.volumnizerCustomerBot.customer_id = customer.id;
          }
        })
        .catch((error) => {
          console.log(error);
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
      console.log(this.customers);
    },
    onCustomerSelectChange(value) {
      this.volumnizer.id = value;
    },
    onSubmit() {
      this.form = new Form(this.volumnizer);
      this.loading = true;

      this.form
        .post(this.getRoute(this.volumnizer.id))
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
              name: "admin.marketmaker.volumnizer.index",
              query: {
                pair: this.volumnizer.symbol
              }
            });
            this.fetchData(this.volumnizer.symbol);
            this.initVolumnizer();
          }
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
    initVolumnizer() {
      this.volumnizer.market_id = "";
      this.volumnizer.id = "";
      this.volumnizer.start_time = moment.utc().format('YYYY/MM/DD HH:mm:ss');
      this.volumnizer.end_time = moment.utc().format('YYYY/MM/DD HH:mm:ss');
      this.volumnizer.time = "";
      this.volumnizer.amount = "";
      this.volumnizer.symbol = "";
    },
    onCancel() {
      this.pushRoute({
        name: "admin.marketmaker.volumnizer.index",
      });
    },
    getRoute(id) {
      if (id !== "") {
        return route("api.marketmaker.volumnizer.update", {
          volumnizer: id,
        });
      }
      return route("api.marketmaker.volumnizer.store");
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
        name: "admin.marketmaker.volumnizer.edit",
        params: { volumnizerId: data.id },
      });
    },
    editRoute(scope) {
      return route("admin.marketmaker.volumnizer.edit", [scope.row.id]);
    }
  },
};
</script>