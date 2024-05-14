<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("orders.title.orders") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("orders.title.orders") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="mb-4">
              <el-row :gutter="20">
                <el-col :span="6">
                  <div>
                    <el-statistic :precision="0" :value="totalStake" title="Total Stake"></el-statistic>
                  </div>
                </el-col>
                <el-col :span="6">
                  <div>
                    <el-statistic group-separator="," :precision="2" :value="totalValueStake" title="Total Value Stake">
                      <template slot="suffix"><span class="symbol">$</span></template>
                    </el-statistic>
                  </div>
                </el-col>
                <el-col :span="6">
                  <div>
                    <el-statistic group-separator="," :precision="2" :value="totalPaidReward" title="Total Paid Reward"></el-statistic>
                  </div>
                </el-col>
              </el-row>
            </div>
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="search el-col el-col-5">
                  <el-input v-model="searchQuery" prefix-icon="el-icon-search" @keyup.native="performSearch"></el-input>
                </div>
              </div>

              <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="data" stripe style="width: 100%"
                @sort-change="handleSortChange">
                <el-table-column prop="id" label="Id" width="75" sortable="custom"> </el-table-column>
                <el-table-column :label="trans('orders.table.code')" prop="code" width="180">
                  <template slot-scope="scope">
                    <span>{{ scope.row.code }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.customer')" prop="customer" width="200">
                  <template slot-scope="scope">
                    <span>{{ scope.row.customer.email }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.packageterm')" prop="packageterm" width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.packageterm.title }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.amount_stake')" prop="amount_stake" width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.amount_stake }} {{ scope.row.currencyStake ? scope.row.currencyStake.code : ""
                    }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.subscription_date')" prop="subscription_date" width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.subscription_date }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.last_time_reward')" prop="last_time_reward" width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.last_time_reward }}</span>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('orders.table.status')" width="60">
                  <template slot-scope="scope">
                    <i :class="scope.row.status === true ? 'text-success' : 'text-danger'" class="fa fa-circle"></i>
                  </template>
                </el-table-column>
                <el-table-column :label="trans('core.table.actions')" prop="actions" fixed="right">
                  <template slot-scope="scope">
                    <el-button-group>
                      <el-button type="success" icon="el-icon-info" circle @click="goToDetail(scope)"></el-button>
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
  </div>
</template>

<script>
import axios from "axios";
import debounce from "lodash/debounce";
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
      searchQuery: "",
      tableIsLoading: false,
      totalPaidReward: 0,
      totalValueStake: 0,
      totalStake: 0
    };
  },
  created() {
    this.getReportTotal();
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

      axios.get(route("api.staking.order.indexServerSide", { ...properties, ...customProperties })).then((response) => {
        this.tableIsLoading = false;
        this.data = response.data.data;
        this.meta = response.data.meta;
        this.links = response.data.links;
        this.order_meta.order_by = properties.order_by;
        this.order_meta.order = properties.order;
      });
    },
    getReportTotal() {
      axios.get(route("api.staking.report.reportTotal")).then((response) => {
        const data = response.data;
        this.totalPaidReward = data.totalValueReward;
        this.totalValueStake = data.totalValueStake;
        this.totalStake = data.totalStake;
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
      console.log(`searching:${query.target.value}`);
      this.tableIsLoading = true;
      this.queryServer({ search: query.target.value });
    }, 300),
    goToDetail(scope) {
      this.pushRoute({ name: "admin.staking.order.detail", params: { orderId: scope.row.id } });
    },
  },
};
</script>

<style lang="scss">
.text-success {
  color: #13ce66;
}

.text-danger {
  color: #ff4949;
}

.el-statistic {
  .head {
    .title {
      font-size: 18px;
      font-weight: bold;
    }
  }

  .con {
    span {
      &.symbol,&.number {
        font-size: 28px;
      }
    }
  }
}
</style>
