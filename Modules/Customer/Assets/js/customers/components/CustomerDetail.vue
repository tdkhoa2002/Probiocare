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
    <div class="box box-primary">
      <div class="box-body">
        <el-tabs v-model="activeName">
          <el-tab-pane label="Customer" name="first">
            <el-form ref="form" :model="customer" label-width="120px" label-position="top"
              @keydown="form.errors.clear($event.target.name)">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.firstname')" :class="{
                        'el-form-item is-error': form.errors.has('firstname'),
                      }">
                        <el-input v-model="customer.profile.firstname"></el-input>
                        <div v-if="form.errors.has('firstname')" class="el-form-item__error"
                          v-text="form.errors.first('firstname')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.lastname')" :class="{
                        'el-form-item is-error': form.errors.has('lastname'),
                      }">
                        <el-input v-model="customer.profile.lastname"></el-input>
                        <div v-if="form.errors.has('lastname')" class="el-form-item__error"
                          v-text="form.errors.first('lastname')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.phone_number')" :class="{
                        'el-form-item is-error':
                          form.errors.has('phone_number'),
                      }">
                        <el-input v-model="customer.profile.phone_number"></el-input>
                        <div v-if="form.errors.has('phone_number')" class="el-form-item__error"
                          v-text="form.errors.first('phone_number')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.address')" :class="{
                        'el-form-item is-error': form.errors.has('address'),
                      }">
                        <el-input v-model="customer.profile.address"></el-input>
                        <div v-if="form.errors.has('address')" class="el-form-item__error"
                          v-text="form.errors.first('address')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.email')" :class="{
                        'el-form-item is-error': form.errors.has('email'),
                      }">
                        <el-input v-model="customer.email"></el-input>
                        <div v-if="form.errors.has('email')" class="el-form-item__error"
                          v-text="form.errors.first('email')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.password')" :class="{
                        'el-form-item is-error': form.errors.has('password'),
                      }">
                        <el-input v-model="customer.password"></el-input>
                        <div v-if="form.errors.has('password')" class="el-form-item__error"
                          v-text="form.errors.first('password')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.ref_code')" :class="{
                        'el-form-item is-error': form.errors.has('ref_code'),
                      }">
                        <el-input v-model="customer.ref_code" disabled></el-input>
                        <div v-if="form.errors.has('ref_code')" class="el-form-item__error"
                          v-text="form.errors.first('ref_code')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.birthday')" :class="{
                        'el-form-item is-error': form.errors.has('birthday'),
                      }">
                        <el-date-picker v-model="customer.profile.birthday" type="date" placeholder="Pick a day"
                          format="yyyy/MM/dd" value-format="yyyy-MM-dd">
                        </el-date-picker>
                        <div v-if="form.errors.has('birthday')" class="el-form-item__error"
                          v-text="form.errors.first('birthday')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <el-form-item :label="trans('customers.form.status')" :class="{
                        'el-form-item is-error': form.errors.has('status'),
                      }">
                        <el-switch v-model="customer.status" active-color="#13ce66" inactive-color="#ff4949">
                        </el-switch>
                        <div v-if="form.errors.has('status')" class="el-form-item__error"
                          v-text="form.errors.first('status')"></div>
                      </el-form-item>
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
                </div>
              </div>
            </el-form>
          </el-tab-pane>
          <el-tab-pane label="KYC" name="second">
            <CustomerKyc :customer-id="customer_id"></CustomerKyc>
          </el-tab-pane>
          <!-- <el-tab-pane label="History" name="third">Role</el-tab-pane> -->
          <el-tab-pane v-if="isWalletModuleActive" label="Wallets" name="four">
            <div class="box-body">
              <div class="sc-table">
                <div class="tool-bar el-row" style="padding-bottom: 20px">
                  <div class="actions el-col el-col-10">
                    <router-link :to="{ name: 'admin.customer.transaction.add_balance' }">
                      <el-button type="success">
                        {{ trans("wallets.button.add_balance") }}
                      </el-button>
                    </router-link>
                    <router-link :to="{ name: 'admin.customer.transaction.sub_balance' }">
                      <el-button type="danger">
                        {{ trans("wallets.button.sub_balance") }}
                      </el-button>
                    </router-link>
                  </div>
                  <div class="search el-col-24 el-col-md-5">
                    <el-select v-model="searchQuery.currency_id" placeholder="Select currency" clearable
                      @change="performSearchWallets">
                      <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                        :value="item.id"></el-option>
                    </el-select>
                  </div>
                </div>
                <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="wallets" stripe style="width: 100%"
                  @sort-change="handleSortChange">
                  <el-table-column type="expand">
                    <template slot-scope="props">
                      <el-table :data="props.row.walletChains" style="width: 100%">
                        <el-table-column prop="blockchain" label="Blockchain" width="180">
                          <template slot-scope="scope">
                            {{
                              scope.row.blockchain
                              ? scope.row.blockchain.title
                              : ""
                            }}
                          </template>
                        </el-table-column>
                        <el-table-column prop="address" label="Address"></el-table-column>
                        <el-table-column prop="onhold" label="On hold"></el-table-column>
                        <el-table-column prop="is_sync" label="Sync address">
                          <template slot-scope="scope">
                            <i :class="scope.row.is_sync === 1
                                  ? 'text-success'
                                  : 'text-danger'
                                " class="fa fa-circle"></i>
                          </template>
                        </el-table-column>
                        <el-table-column prop="actions" label="Actions">
                          <template slot-scope="scope">
                            <el-button type="primary" v-if="scope.row.is_sync != 1" size="mini"
                              @click="resyncAddress(scope.row.id)" icon="el-icon-share"></el-button>
                          </template>
                        </el-table-column>
                      </el-table>
                    </template>
                  </el-table-column>
                    <el-table-column prop="id" label="Id" width="75" sortable="custom">
                    </el-table-column>
                    <el-table-column :label="trans('wallets.table.customer')" prop="customer">
                      <template slot-scope="scope">
                        {{ scope.row.customer ? scope.row.customer.email : "" }}
                      </template>
                    </el-table-column>
                    <el-table-column :label="trans('wallets.table.currency')" prop="currency">
                      <template slot-scope="scope">
                        {{ scope.row.currency ? scope.row.currency.title : "" }}
                      </template>
                    </el-table-column>
                    <el-table-column :label="trans('wallets.table.type')" prop="type">
                      <template slot-scope="scope">
                        {{ scope.row.type }}
                      </template>
                    </el-table-column>
                    <el-table-column :label="trans('wallets.table.balance')" prop="balance">
                      <template slot-scope="scope">
                        {{ scope.row.balance }}
                        {{ scope.row.currency ? scope.row.currency.code : "" }}
                      </template>
                    </el-table-column>
                    <el-table-column :label="trans('core.table.created at')" prop="created_at" sortable="custom">
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
          </el-tab-pane>
          <el-tab-pane v-if="isWalletModuleActive" label="Transactions" name="five">
            <div class="box-body">
              <div class="sc-table">
                <div class="tool-bar el-row" style="padding-bottom: 20px">
                  <div class="search el-col el-col-5" style="margin-left: 5px;">
                    <el-select v-model="searchTransactions.currency" placeholder="Select currency" clearable
                      @change="performSearch">
                      <el-option v-for="item in currencies" :key="item.id" :label="item.code" :value="item.id">
                      </el-option>
                    </el-select>
                  </div>
                </div>
                <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="transactions" stripe style="width: 100%"
                  @sort-change="handleSortChange">
                  <el-table-column prop="id" label="Id" width="75" sortable="custom">
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.currency_id')" prop="currency_id">
                    <template slot-scope="scope">
                      <a>
                        {{ scope.row.currency.title }}
                      </a>
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.blockchain_id')" prop="blockchain_id">
                    <template slot-scope="scope">
                      <a>
                        {{
                          scope.row.blockchain != null
                          ? scope.row.blockchain.title
                          : "-"
                        }}
                      </a>
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.action')" prop="action">
                    <template slot-scope="scope">
                      {{ scope.row.action }}
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.amount')" prop="amount">
                    <template slot-scope="scope">
                      {{ scope.row.amount }} {{ scope.row.currency.code }}
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.email')" prop="email">
                    <template slot-scope="scope">
                      {{ scope.row.customer.email }}
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.fee')" prop="fee">
                    <template slot-scope="scope">
                      {{ scope.row.fee }}
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.txhash')" prop="txhash">
                    <template slot-scope="scope">
                      <span v-if="scope.row.link != ''"><a :href="scope.row.link" target="_blank">{{
                        scope.row.txhash
                      }}</a>
                      </span>
                      <span v-if="scope.row.link == ''">{{
                        scope.row.txhash
                      }}</span>
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('transactions.table.status')" width="100">
                    <template slot-scope="scope">
                      {{ scope.row.status }}
                    </template>
                  </el-table-column>
                  <el-table-column :label="trans('core.table.created at')" prop="created_at" sortable="custom">
                  </el-table-column>
                  <el-table-column :label="trans('core.table.actions')" prop="actions" width="150">
                    <template slot-scope="scope">
                      <el-button-group>
                        <el-button v-if="scope.row.action == 'WITHDRAW' &&
                          scope.row.status === 'FAIL'
                          " @click="sendWithdrawTransaction(scope.row.id)" type="warning" size="mini">
                          Re-send
                        </el-button>
                        <el-button v-if="scope.row.action == 'WITHDRAW' &&
                          ['ACCEPTED', 'CREATED'].includes(scope.row.status)
                          " @click="sendWithdrawTransaction(scope.row.id)" type="warning" size="mini">
                          Approve
                        </el-button>
                        <el-button v-if="scope.row.action == 'WITHDRAW' &&
                          ['ACCEPTED', 'CREATED', 'FAIL'].includes(
                            scope.row.status
                          )
                          " @click="cancelWithdrawTransaction(scope.row.id)" type="info" size="mini">
                          Cancel
                        </el-button>
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
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from "axios";
import debounce from "lodash/debounce";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";
import CustomerKyc from "./CustomerKyc.vue";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";

let data;

export default {
  components: {
    FormErrors,
    CustomerKyc,
  },
  mixins: [ShortcutHelper],
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
      activeName: "first",
      meta: {
        current_page: 1,
        per_page: 10,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      customer: {
        id: null,
        email: "",
        password: "",
        ref_code: "",
        sponsor_id: 0,
        status: false,
        profile: {
          firstname: "",
          lastname: "",
          phone_number: "",
          address: "",
          birthday: "",
        },
      },
      customer_id: +this.$route.params.customerId,
      customers: [],
      form: new Form(),
      loading: false,
      tableIsLoading: false,
      searchQuery: {
        currency_id: "",
      },
      searchTransactions: {
        currency: "",
      },
      statuses: [],
      currencies: [],
      actions: [],
      chains: [],
      transactions: [],
      wallets: [],
      isWalletModuleActive: false,
    };
  },
  async created() {
    await this.checkModuleWalletStatus();
    this.fetchCustomer();
    this.fetchTransactions();
    this.fetchCurrencies();
    this.fetchWallets();
    this.fetchChains();
  },
  mounted() { },
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
        })
        .catch((error) => {
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
    fetchCustomer() {
      this.loading = true;
      axios
        .get(
          route("api.customer.customer.find", {
            customerId: this.$route.params.customerId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.customer = response.data.data;
          if (this.customer.sponsor_id != 0) {
            this.queryCustomers(this.customer.sponsor_id);
          }
        });
    },
    fetchTransactions() {
      this.tableIsLoading = true;
      this.queryTransactions();
    },
    queryTransactions(customProperties) {
      if (this.isWalletModuleActive) {
        const properties = {
          page: this.meta.current_page,
          per_page: this.meta.per_page,
          order_by: this.order_meta.order_by,
          order: this.order_meta.order,
        };

        axios
          .get(
            route("api.customer.transaction.listTransactions", {
              customer: this.$route.params.customerId,
              ...properties,
              ...this.searchTransactions,
              ...customProperties,
            })
          )
          .then((response) => {
            this.tableIsLoading = false;
            this.transactions = response.data.data;
            this.meta = response.data.meta;
            this.links = response.data.links;

            this.order_meta.order_by = properties.order_by;
            this.order_meta.order = properties.order;
          });
      }
    },
    fetchWallets() {
      this.tableIsLoading = true;
      this.queryWallets();
    },
    queryWallets(customProperties) {
      if (this.isWalletModuleActive) {
        const properties = {
          page: this.meta.current_page,
          per_page: this.meta.per_page,
          order_by: this.order_meta.order_by,
          order: this.order_meta.order,
          search: this.searchQuery,
        };

        axios
          .get(
            route("api.customer.wallet.listWallets", {
              customer: this.$route.params.customerId,
              ...properties,
              ...customProperties,
            })
          )
          .then((response) => {
            this.tableIsLoading = false;
            this.wallets = response.data.data;
            this.meta = response.data.meta;
            this.links = response.data.links;

            this.order_meta.order_by = properties.order_by;
            this.order_meta.order = properties.order;
          });
      }
    },
    performSearch: debounce(function (query) {
      this.tableIsLoading = true;
      this.queryTransactions();
    }, 300),
    performSearchWallets: debounce(function (query) {
      this.tableIsLoading = true;
      this.queryWallets();
    }, 300),
    getRoute() {
      return route("api.customer.customer.update", {
        customer: this.$route.params.customerId,
      });
    },
    handleSizeChange(event) {
      console.log(`per page :${event}`);
      this.tableIsLoading = true;
      this.queryTransactions({ per_page: event });
    },
    handleCurrentChange(event) {
      console.log(`current page :${event}`);
      this.tableIsLoading = true;
      this.queryTransactions({ page: event });
    },
    handleSortChange(event) {
      console.log("sorting", event);
      this.tableIsLoading = true;
      this.queryTransactions({ order_by: event.prop, order: event.order });
    },
    fetchCurrencies() {
      if (this.isWalletModuleActive) {
        axios
          .get(route("api.wallet.currency.all"))
          .then((response) => {
            this.currencies = response.data.data;
          });
      }
    },
    fetchChains() {
      if (this.isWalletModuleActive) {
        axios.get(route("api.wallet.blockchain.all")).then((response) => {
          this.chains = response.data.data;
        });
      }
    },
    queryCustomers(id) {
      axios
        .get(route("api.customer.customer.allwithfilter", { id: id }))
        .then((response) => {
          this.customers = response.data.data;
        });
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
    async checkModuleWalletStatus() {
      try {
        await axios
          .get(route("api.customer.wallet.check-wallet-module"))
          .then((response) => {
            if (response.data.error == true) {
              this.isWalletModuleActive = response.data.message.enabled;
            } else {
              this.isWalletModuleActive = response.data.data.enabled;
            }
          });
      } catch (error) {
        console.error('Error fetching module status:', error);
      }
    }
  },
};
</script>
  