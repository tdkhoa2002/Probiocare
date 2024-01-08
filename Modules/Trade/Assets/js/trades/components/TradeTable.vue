<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("trades.title.trades") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("trades.title.trades") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="actions el-col el-col-8"></div>
                <div class="tool-bar el-row" style="padding-bottom: 20px">
                  <div class="actions el-col-24 el-col-md-8"></div>
                  <div class="search el-col-24 el-col-md-5">
                    <el-select v-model="searchQuery.market_id" placeholder="Select market" clearable
                      @change="performSearch">
                      <el-option v-for="item in markets" :key="item.id" :label="item.symbol" :value="item.id"></el-option>
                    </el-select>
                  </div>
                  <div class="search el-col-24 el-col-md-5" style="margin-right: 10px">
                    <el-select v-model="searchQuery.customer_id" filterable remote clearable reserve-keyword
                      @change="performSearch" placeholder="Please enter a email customer"
                      :remote-method="remoteCustomerMethod">
                      <el-option v-for="item in customers" :key="item.id" :label="item.email" :value="item.id">
                      </el-option>
                    </el-select>
                  </div>
                </div>
              </div>

              <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="data" stripe style="width: 100%"
                @sort-change="handleSortChange">
                <el-table-column prop="id" label="Id" width="75" sortable="custom">
                </el-table-column>
                <el-table-column :label="trans('trades.table.market')" prop="symbol">
                  <template slot-scope="scope">
                    {{ scope.row.market.symbol }}
                  </template>
                </el-table-column>

                <el-table-column :label="trans('trades.table.customer')" prop="customer">
                  <template slot-scope="scope">
                    {{ scope.row.customer.email }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('trades.table.amount')" prop="amount">
                  <template slot-scope="scope">
                    {{ scope.row.amount }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('trades.table.trade_type')" prop="trade_type">
                  <template slot-scope="scope">
                    {{ scope.row.trade_type }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('trades.table.fee')" prop="fee">
                  <template slot-scope="scope">
                    {{ scope.row.fee }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('trades.table.status')" prop="status">
                  <template slot-scope="scope">
                    <el-button type="primary" v-if="scope.row.status == 0">Open</el-button>
                    <el-button type="warning" v-if="scope.row.status == 1">Canceled</el-button>
                    <el-button type="success" v-if="scope.row.status == 2">Completed</el-button>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('core.table.created at')" prop="created_at" sortable="custom">
                </el-table-column>
                <el-table-column :label="trans('core.table.actions')" prop="actions">
                  <template slot-scope="scope">
                    <el-button type="info" v-if="scope.row.status == 0"
                      @click="cancelTrade(scope.row.id)">Cancel</el-button>
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
    <button v-show="false" v-shortkey="['c']" @shortkey="pushRoute({ name: 'admin.trade.trade.create' })"></button>
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
        per_page: 10,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      links: {},
      searchQuery: {
        market_id: "",
        customer_id: "",
      },
      markets: [],
      customers: [],
      tableIsLoading: false,
    };
  },
  mounted() {
    this.fetchArrMarket();
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
          route("api.trade.trade.indexServerSide", {
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
    performSearch: debounce(function (query) {
      this.tableIsLoading = true;
      this.queryServer();
    }, 300),
    remoteCustomerMethod(query) {
      if (query != "" && query.length > 3) {
        axios
          .get(route("api.customer.customer.allWithFilter", { query }))
          .then((response) => {
            this.customers = response.data.data;
          });
      }
    },

    fetchArrMarket() {
      axios.get(route("api.trade.market.all")).then((response) => {
        this.markets = response.data.data;
      });
    },
    cancelTrade(id) {
      this.tableIsLoading = true;
      axios
        .post(route("api.trade.trade.cancelTrade", { tradeId: id }))
        .then((response) => {
          this.tableIsLoading = false;
          if (response.data.errors == true) {
            this.$notify.error({
              title: "Error",
              message: response.data.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.message,
            });
          }
        });
    },
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
