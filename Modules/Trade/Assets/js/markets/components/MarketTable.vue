<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("markets.title.markets") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("markets.title.markets") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="actions el-col el-col-8">
                  <router-link :to="{ name: 'admin.trade.market.create' }">
                    <el-button type="primary">
                      <i class="el-icon-edit"></i>
                      {{ trans("markets.button.create market") }}
                    </el-button>
                  </router-link>
                </div>
                <div class="search el-col el-col-5">
                  <el-input
                    v-model="searchQuery"
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
                  :label="trans('markets.table.status')"
                  width="100"
                >
                  <template slot-scope="scope">
                    <i
                      :class="
                        scope.row.status === true
                          ? 'text-success'
                          : 'text-danger'
                      "
                      class="fa fa-circle"
                    ></i>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.symbol')"
                  prop="symbol"
                >
                  <template slot-scope="scope">
                    <a
                      :href="editRoute(scope)"
                      @click.prevent="goToEdit(scope)"
                    >
                      {{ scope.row.symbol }}
                    </a>
                  </template>
                </el-table-column>

                <el-table-column
                  :label="trans('markets.table.service_base_id')"
                  prop="service_base_id"
                >
                  <template slot-scope="scope">
                    {{ scope.row.service_base_id }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.service_quote_id')"
                  prop="service_quote_id"
                >
                  <template slot-scope="scope">
                    {{ scope.row.service_quote_id }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.min_amount')"
                  prop="min_amount"
                >
                  <template slot-scope="scope">
                    {{ scope.row.min_amount }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.max_amount')"
                  prop="max_amount"
                >
                  <template slot-scope="scope">
                    {{ scope.row.max_amount }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.maker')"
                  prop="maker"
                >
                  <template slot-scope="scope">
                    {{ scope.row.maker }}%
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('markets.table.taker')"
                  prop="taker"
                >
                  <template slot-scope="scope">
                    {{ scope.row.taker }}%
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
                >
                  <template slot-scope="scope">
                    <el-button-group>
                      <el-button
                        type="primary"
                        v-if="
                          scope.row.service_base_id == null ||
                          scope.row.service_quote_id == null
                        "
                        size="mini"
                        @click="reSyncService(scope.row.id)"
                        icon="el-icon-share"
                      ></el-button>

                      <edit-button
                        :to="{
                          name: 'admin.trade.market.edit',
                          params: { marketId: scope.row.id },
                        }"
                      ></edit-button>
                      <delete-button
                        :scope="scope"
                        :rows="data"
                      ></delete-button>
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
      @shortkey="pushRoute({ name: 'admin.trade.market.create' })"
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
      meta: {
        current_page: 1,
        per_page: 30,
      },
      order_meta: {
        order_by: "",
        order: "",
      },
      links: {},
      searchQuery: "",
      tableIsLoading: false,
    };
  },
  mounted() {
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
          route("api.trade.market.indexServerSide", {
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
      console.log(`searching:${query.target.value}`);
      this.tableIsLoading = true;
      this.queryServer({ search: query.target.value });
    }, 300),
    goToEdit(scope) {
      this.pushRoute({
        name: "admin.trade.market.edit",
        params: { marketId: scope.row.id },
      });
    },
    editRoute(scope) {
      return route("admin.trade.market.edit", [scope.row.id]);
    },
    reSyncService(marketId) {
      this.loading = true;
      axios
        .get(
          route("api.trade.market.reSyncService", {
            marketId: marketId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.fetchData();
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
