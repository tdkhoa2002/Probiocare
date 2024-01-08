<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("wallets.title.wallets") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("wallets.title.wallets") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="actions el-col-24 el-col-md-8"></div>
                <div class="search el-col-24 el-col-md-5">
                  <el-select
                    v-model="searchQuery.currency_id"
                    placeholder="Select currency"
                    clearable
                    @change="performSearch"
                  >
                    <el-option
                      v-for="item in currencies"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"
                    ></el-option>
                  </el-select>
                </div>
                <div
                  class="search el-col-24 el-col-md-5"
                  style="margin-right: 10px"
                >
                  <el-select
                    v-model="searchQuery.customer_id"
                    filterable
                    remote
                    clearable
                    reserve-keyword
                    @change="performSearch"
                    placeholder="Please enter a email customer"
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
                <el-table-column type="expand">
                  <template slot-scope="props">
                    <el-table
                      :data="props.row.walletChains"
                      style="width: 100%"
                    >
                      <el-table-column
                        prop="blockchain"
                        label="Blockchain"
                        width="180"
                      >
                        <template slot-scope="scope">
                          {{
                            scope.row.blockchain
                              ? scope.row.blockchain.title
                              : ""
                          }}
                        </template>
                      </el-table-column>
                      <el-table-column
                        prop="address"
                        label="Address"
                      ></el-table-column>
                      <el-table-column
                        prop="onhold"
                        label="On hold"
                      ></el-table-column>
                      <el-table-column prop="is_sync" label="Sync address">
                        <template slot-scope="scope">
                          <i
                            :class="
                              scope.row.is_sync === 1
                                ? 'text-success'
                                : 'text-danger'
                            "
                            class="fa fa-circle"
                          ></i>
                        </template>
                      </el-table-column>
                      <el-table-column prop="actions" label="Actions">
                        <template slot-scope="scope">
                          
                          <el-button type="primary" v-if="scope.row.is_sync != 1" size="mini" @click="resyncAddress(scope.row.id)" icon="el-icon-share"></el-button>
                        </template>
                      </el-table-column>
                    </el-table>
                  </template>
                </el-table-column>
                <el-table-column
                  prop="id"
                  label="Id"
                  width="75"
                  sortable="custom"
                >
                </el-table-column>
                <el-table-column
                  :label="trans('wallets.table.customer')"
                  prop="customer"
                >
                  <template slot-scope="scope">
                    {{ scope.row.customer ? scope.row.customer.email : "" }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('wallets.table.currency')"
                  prop="currency"
                >
                  <template slot-scope="scope">
                    {{ scope.row.currency ? scope.row.currency.title : "" }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('wallets.table.type')"
                  prop="type"
                >
                  <template slot-scope="scope">
                    {{ scope.row.type }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('wallets.table.balance')"
                  prop="balance"
                >
                  <template slot-scope="scope">
                    {{ scope.row.balance }}
                    {{ scope.row.currency ? scope.row.currency.code : "" }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('core.table.created at')"
                  prop="created_at"
                  sortable="custom"
                >
                </el-table-column>
                <!-- <el-table-column
                  :label="trans('core.table.actions')"
                  prop="actions"
                >
                  <template slot-scope="scope">
                    <el-button-group>
                      <edit-button
                        :to="{
                          name: 'admin.wallet.wallet.edit',
                          params: { walletId: scope.row.id },
                        }"
                      ></edit-button>
                    </el-button-group>
                  </template>
                </el-table-column> -->
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
      meta: {
        current_page: 1,
        per_page: 30,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      links: {},
      searchQuery: {
        customer_id: "",
        currency_id: "",
      },
      tableIsLoading: false,
      customers: [],
      currencies: [],
    };
  },
  mounted() {
    this.fetchArrCurrency();
    this.fetchData();
  },
  methods: {
    queryServer(customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
      };

      axios
        .get(
          route("api.wallet.wallet.indexServerSide", {
            ...properties,
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
    remoteCustomerMethod(query) {
      if (query != "" && query.length > 3) {
        axios
          .get(route("api.customer.customer.allwithfilter", { query }))
          .then((response) => {
            this.customers = response.data.data;
          });
      }
    },
    goToEdit(scope) {
      this.pushRoute({
        name: "admin.wallet.wallet.edit",
        params: { walletId: scope.row.id },
      });
    },
    performSearch: debounce(function () {
      this.tableIsLoading = true;
      this.queryServer();
    }, 300),
    editRoute(scope) {
      return route("admin.wallet.wallet.edit", [scope.row.id]);
    },
    fetchArrCurrency() {
      axios.get(route("api.wallet.currency.all")).then((response) => {
        this.currencies = response.data.data;
      });
    },
    resyncAddress(walletChainId){
      axios.get(route("api.wallet.wallet.resyncAddress",{walletChainId})).then((response) => {
        if(response.data.errors == true){
          this.$message({
            type: "error",
            message: response.data.message,
          });
        }else {
          this.$message({
            type: "success",
            message: response.data.message,
          });
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
