<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("transactions.title.transactions") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("transactions.title.transactions") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="search el-col el-col-5" style="margin-left: 5px;">
                  <el-select v-model="searchQuery.action" placeholder="Select action" @change="performSearch">
                    <el-option
                      v-for="item in actions"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                    </el-option>
                  </el-select>
                </div>
                <div class="search el-col el-col-5" style="margin-left: 5px;">
                  <el-select v-model="searchQuery.currency" placeholder="Select currency" @change="performSearch">
                    <el-option
                      v-for="item in currencies"
                      :key="item.id"
                      :label="item.code"
                      :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </div>
                <div class="search el-col el-col-5" style="margin-left: 5px;">
                  <el-select v-model="searchQuery.status" placeholder="Select status" @change="performSearch">
                    <el-option
                      v-for="item in statuses"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                    </el-option>
                  </el-select>
                </div>
                <div class="search el-col el-col-5" >
                  <el-input
                    v-model="searchQuery.search"
                    prefix-icon="el-icon-search"
                    @keyup.native="performSearch"
                  ></el-input>
                </div>
              </div>

              <el-table
                ref="pageTable"
                v-loading.body="tableIsLoading"
                :data="data"
                stripe
                style="width: 100%"
                @sort-change="handleSortChange"
              >
                <el-table-column
                  prop="id"
                  label="Id"
                  width="75"
                  sortable="custom"
                >
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.currency_id')"
                  prop="currency_id"
                >
                  <template slot-scope="scope">
                    <a
                      :href="editRoute(scope)"
                      @click.prevent="goToEdit(scope)"
                    >
                      {{ scope.row.currency.title }}
                    </a>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.blockchain_id')"
                  prop="blockchain_id"
                >
                  <template slot-scope="scope">
                    <a
                      :href="editRoute(scope)"
                      @click.prevent="goToEdit(scope)"
                    >
                      {{
                        scope.row.blockchain != null
                          ? scope.row.blockchain.title
                          : "-"
                      }}
                    </a>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.action')"
                  prop="action"
                >
                  <template slot-scope="scope">
                    {{ scope.row.action }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.amount')"
                  prop="amount"
                >
                  <template slot-scope="scope">
                    {{ scope.row.amount }} {{ scope.row.currency.title }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.email')"
                  prop="email"
                >
                  <template slot-scope="scope">
                    {{ scope.row.customer.email }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.fee')"
                  prop="fee"
                >
                  <template slot-scope="scope">
                    {{ scope.row.fee }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.txhash')"
                  prop="txhash"
                >
                  <template slot-scope="scope">
                    <span v-if="scope.row.link != ''"
                      ><a :href="scope.row.link" target="_blank">{{
                        scope.row.txhash
                      }}</a>
                    </span>
                    <span v-if="scope.row.link == ''">{{
                      scope.row.txhash
                    }}</span>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('transactions.table.status')"
                  width="100"
                >
                  <template slot-scope="scope">
                    {{ scope.row.status }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('core.table.created at')"
                  prop="created_at"
                  sortable="custom"
                >
                </el-table-column>
                <el-table-column
                  :label="trans('core.table.actions')"
                  prop="actions"
                  width="150"
                >
                  <template slot-scope="scope">
                    <el-button-group>
                      <el-button
                        v-if="
                          scope.row.action == 'WITHDRAW' &&
                          scope.row.status === 'FAIL'
                        "
                        @click="sendWithdrawTransaction(scope.row.id)"
                        type="warning"
                        size="mini"
                      >
                        Re-send
                      </el-button>
                      <el-button
                        v-if="
                          scope.row.action == 'WITHDRAW' &&
                          ['ACCEPTED', 'CREATED'].includes(scope.row.status)
                        "
                        @click="sendWithdrawTransaction(scope.row.id)"
                        type="warning"
                        size="mini"
                      >
                        Approve
                      </el-button>
                      <el-button
                        v-if="
                          scope.row.action == 'WITHDRAW' &&
                          ['ACCEPTED', 'CREATED', 'FAIL'].includes(
                            scope.row.status
                          )
                        "
                        @click="cancelWithdrawTransaction(scope.row.id)"
                        type="info"
                        size="mini"
                      >
                        Cancel
                      </el-button>
                      <!-- <edit-button
                        :to="{
                          name: 'admin.wallet.transaction.edit',
                          params: { transactionId: scope.row.id },
                        }"
                      ></edit-button>
                      <delete-button
                        :scope="scope"
                        :rows="data"
                      ></delete-button> -->
                    </el-button-group>
                  </template>
                </el-table-column>
              </el-table>
              <div
                class="pagination-wrap"
                style="text-align: center; padding-top: 20px"
              >
                <el-pagination
                  :current-page.sync="meta.current_page"
                  :page-sizes="[10, 20, 30, 50, 100]"
                  :page-size="parseInt(meta.per_page)"
                  :total="meta.total"
                  layout="total, sizes, prev, pager, next, jumper"
                  @size-change="handleSizeChange"
                  @current-change="handleCurrentChange"
                ></el-pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button
      v-show="false"
      v-shortkey="['c']"
      @shortkey="pushRoute({ name: 'admin.wallet.transaction.create' })"
    ></button>
  </div>
</template>

<script>
import axios from "axios";
import debounce from "lodash/debounce";
import map from "lodash/map";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import EditButton from "../../../../../Core/Assets/js/components/EditButtonComponent.vue";

let data;

export default {
  components: { DeleteButton, EditButton },
  mixins: [ShortcutHelper],
  data() {
    return {
      data,
      statuses: [],
      currencies: [],
      actions: [],
      meta: {
        current_page: 1,
        per_page: 10,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      links: {},
      searchQuery: {
        search: "",
        status: "",
        action: "",
        currency: "",
      },
      tableIsLoading: false,
    };
  },
  created() {
    this.getStaticTransaction();
    this.getCurrency();
    this.fetchData();
  },
  methods: {
    queryServer(customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
      };

      axios
        .get(
          route("api.wallet.transaction.indexServerSide", {
            ...properties,
            ...this.searchQuery,
            ...customProperties,
          })
        )
        .then((response) => {
          this.tableIsLoading = false;
          this.data = response.data.data;
          this.meta = response.data.meta;
          this.links = response.data.links;

          this.order_meta.order_by = properties.order_by;
          this.order_meta.order = properties.order;
        });
    },
    fetchData() {
      this.tableIsLoading = true;
      this.queryServer();
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
      this.tableIsLoading = true;
      this.queryServer();
    }, 300),
    goToEdit(scope) {
      this.pushRoute({
        name: "admin.wallet.transaction.edit",
        params: { transactionId: scope.row.id },
      });
    },
    editRoute(scope) {
      return route("admin.wallet.transaction.edit", [scope.row.id]);
    },
    sendWithdrawTransaction(transactionId) {
      this.loading = true;
      axios
        .post(
          route("api.wallet.transaction.resendWithdraw", {
            transaction: transactionId,
          })
        )
        .then((response) => {
          this.loading = false;
          if (response.data.error == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.data.message,
            });
          }
        });
    },
    cancelWithdrawTransaction(transactionId) {
      this.loading = true;
      axios
        .post(
          route("api.wallet.transaction.cancelWithdraw", {
            transaction: transactionId,
          })
        )
        .then((response) => {
          this.loading = false;
          if (response.data.error == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.data.message,
            });
          }
        });
    },
    getStaticTransaction() {
      this.loading = true;
      axios
        .get(route("api.wallet.transaction.getstatictransaction"))
        .then((response) => {
          this.loading = false;
          if (response.data.error == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
          } else {
            this.actions = response.data.actions;
            this.statuses = response.data.status;
          }
        });
    },
    getCurrency(){
      axios
        .get(route("api.wallet.currency.all"))
        .then((response) => {
          this.loading = false;
          if (response.data.error == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
          } else {
            this.currencies = response.data.data;
          }
        });
    }
  },
};
</script>

<style>
.text-success {
  color: #13ce66;
}

.text-danger {
  color: #ff4949;
}
</style>
