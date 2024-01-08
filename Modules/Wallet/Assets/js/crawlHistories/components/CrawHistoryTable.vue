<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans("crawlhistories.title.crawlhistories") }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ trans("crawlhistories.title.crawlhistories") }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="sc-table">
              <div class="tool-bar el-row" style="padding-bottom: 20px">
                <div class="actions el-col el-col-24 el-col-lg-16">
                  <div class="row">
                    <div class="col-lg-4">
                      <el-select v-model="crawl.blockchain_id" placeholder="Select blockchain">
                        <el-option v-for="item in blockchains" :key="item.id" :label="item.title" :value="item.id">
                        </el-option>
                      </el-select>
                      <div v-if="form.errors.has('blockchain_id')" class="el-form-item__error"
                        v-text="form.errors.first('blockchain_id')"></div>
                    </div>
                    <div class="col-lg-4">
                      <el-select v-model="crawl.currency_id" placeholder="Select currency">
                        <el-option v-for="item in currencies" :key="item.id" :label="item.title" :value="item.id">
                        </el-option>
                      </el-select>
                      <div v-if="form.errors.has('currency_id')" class="el-form-item__error"
                        v-text="form.errors.first('currency_id')"></div>
                    </div>
                    <div class="col-lg-4"><el-button type="primary" @click="crawlDeposit">
                        <i class="el-icon-edit"></i>
                        {{ trans("crawlhistories.crawl") }}
                      </el-button></div>
                  </div>

                </div>
                <div class="search el-col el-col-24 el-col-lg-5">
                  <el-input v-model="searchQuery" prefix-icon="el-icon-search" @keyup.native="performSearch"></el-input>
                </div>
              </div>

              <el-table ref="pageTable" v-loading.body="tableIsLoading" :data="data" stripe style="width: 100%"
                @sort-change="handleSortChange">
                <el-table-column type="expand">
                  <template slot-scope="props">
                    <el-table :data="props.row.crawlHistories" style="width: 100%">
                      <el-table-column prop="address" label="Address" width="180">
                        <template slot-scope="scope">
                          {{
                            scope.row.wallet
                            ? scope.row.wallet?.address
                            : ""
                          }}
                        </template>
                      </el-table-column>
                      <el-table-column prop="amount" label="Amount"></el-table-column>
                      <el-table-column prop="txhash" label="Txhash"></el-table-column>
                    </el-table>
                  </template>
                </el-table-column>
                <el-table-column prop="id" label="Id" width="75" sortable="custom"> </el-table-column>

                <el-table-column :label="trans('crawlhistories.table.blockchain')" prop="blockchain">
                  <template slot-scope="scope">
                    {{ scope.row.blockchain?.title }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('crawlhistories.table.currency')" prop="currency">
                  <template slot-scope="scope">
                    {{ scope.row.currency?.title }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('crawlhistories.table.total')" prop="total">
                  <template slot-scope="scope">
                    {{ scope.row.total }}
                  </template>
                </el-table-column>
                <el-table-column :label="trans('crawlhistories.table.admin')" prop="user">
                  <template slot-scope="scope">
                    {{ scope.row.user?.email }}
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
        </div>
      </div>
    </div>
    <button v-show="false" v-shortkey="['c']" @shortkey="pushRoute({ name: 'admin.wallet.blockchain.create' })"></button>
  </div>
</template>

<script>
import axios from "axios";
import debounce from "lodash/debounce";
import map from "lodash/map";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import EditButton from "../../../../../Core/Assets/js/components/EditButtonComponent.vue";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";
let data;

export default {
  components: { DeleteButton, EditButton, FormErrors },
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
      crawl: {
        blockchain_id: "",
        currency_id: "",
      },
      links: {},
      searchQuery: "",
      tableIsLoading: false,
      blockchains: [],
      currencies: [],
      form: new Form(),
    };
  },
  created() {
    this.fetchBlockchain()
    this.fetchCurrency();
    this.fetchData();
  },
  mounted() {

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

      axios.get(route("api.wallet.crawlhistories.indexServerSide", { ...properties, ...customProperties })).then((response) => {
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
    fetchBlockchain() {
      axios.get(route("api.wallet.blockchain.all")).then((response) => {
        this.blockchains = response.data.data;
      });
    },
    fetchCurrency() {
      axios.get(route("api.wallet.currency.all")).then((response) => {
        this.currencies = response.data.data;
      });
    },
    crawlDeposit() {
      this.form = new Form(this.crawl);
      this.loading = true;

      this.form
        .post(route("api.wallet.crawlhistories.crawl"))
        .then((response) => {
          this.loading = false;
          if (response.errors == true) {
            this.$message({
              type: "error",
              message: response.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.message,
            });
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
