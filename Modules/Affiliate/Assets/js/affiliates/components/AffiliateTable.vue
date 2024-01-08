<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("affiliates.title.affiliates") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("affiliates.title.affiliates") }}
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
                  <router-link
                    :to="{ name: 'admin.affiliate.affiliate.create' }"
                  >
                    <el-button type="primary">
                      <i class="el-icon-edit"></i>
                      {{ trans("affiliates.button.create affiliate") }}
                    </el-button>
                  </router-link>
                  <el-button type="primary" @click="openQuickCreate">
                    <i class="el-icon-edit"></i>
                    Quick Create
                  </el-button>
                </div>
                <div class="search el-col el-col-5">
                  <el-select
                    v-model="searchQuery"
                    placeholder="Commission Type"
                    @change="performSearch"
                  >
                    <el-option
                      :key="index"
                      :label="type"
                      :value="type"
                      v-for="(type, index) in types"
                    ></el-option>
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
                <el-table-column
                  :label="trans('affiliates.table.status')"
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
                  prop="id"
                  label="Id"
                  width="75"
                  sortable="custom"
                >
                </el-table-column>
                <el-table-column
                  :label="trans('affiliates.table.commission')"
                  prop="commission"
                >
                  <template slot-scope="scope">
                    <a
                      :href="editRoute(scope)"
                      @click.prevent="goToEdit(scope)"
                    >
                      {{ scope.row.commission }}
                    </a>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('affiliates.table.commission_type')"
                  prop="commission_type"
                >
                  <template slot-scope="scope">
                    <span v-if="scope.row.commission_type == 1">Percent</span>
                    <span v-if="scope.row.commission_type == 0">Fixed</span>
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('affiliates.table.type')"
                  prop="type"
                >
                  <template slot-scope="scope">
                    {{ scope.row.type }}
                  </template>
                </el-table-column>
                <el-table-column
                  :label="trans('affiliates.table.level')"
                  prop="level"
                >
                  <template slot-scope="scope">
                    {{ scope.row.level }}
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
                      <edit-button
                        :to="{
                          name: 'admin.affiliate.affiliate.edit',
                          params: { affiliateId: scope.row.id },
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
      @shortkey="pushRoute({ name: 'admin.affiliate.affiliate.create' })"
    ></button>
    <AffiliateQuick
      :dialogFormVisible="showModalQuickCreate"
      :data-types="types"
      @closeForm="closeForm"
    >
    </AffiliateQuick>
  </div>
</template>

<script>
import axios from "axios";
import debounce from "lodash/debounce";
import map from "lodash/map";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import EditButton from "../../../../../Core/Assets/js/components/EditButtonComponent.vue";
import AffiliateQuick from "./AffiliateQuick.vue";
let data;

export default {
  components: { DeleteButton, EditButton, AffiliateQuick },
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
      types: [],
      searchQuery: "",
      tableIsLoading: false,
      showModalQuickCreate: false,
    };
  },
  created() {
    this.fetchTypeAffiliate();
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
          route("api.affiliate.affiliate.indexServerSide", {
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
      console.log(`searching:${query}`);
      this.tableIsLoading = true;
      this.queryServer({ search: query });
    }, 300),
    goToEdit(scope) {
      this.pushRoute({
        name: "admin.affiliate.affiliate.edit",
        params: { affiliateId: scope.row.id },
      });
    },
    editRoute(scope) {
      return route("admin.affiliate.affiliate.edit", [scope.row.id]);
    },
    openQuickCreate() {
      this.showModalQuickCreate = true;
    },
    fetchTypeAffiliate() {
      axios
        .get(route("api.affiliate.affiliate.getTypeAffiliate"))
        .then((response) => {
          this.types = response.data.types;
        });
    },
    closeForm() {
      this.showModalQuickCreate = false;
      this.fetchData();
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
