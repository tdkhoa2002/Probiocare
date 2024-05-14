<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`orders.title.${orderTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.staking.order.index' }">
          {{ trans("orders.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.staking.order.create' }">
          {{ trans(`orders.title.${orderTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-lg-12">
                <el-descriptions title="Package" border :column="1">
                  <el-descriptions-item label="Title">{{
                    order.packageterm.title
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Apr reward"
                    >{{ order.packageterm.apr_reward }}%</el-descriptions-item
                  >
                  <el-descriptions-item label="Day reward"
                    >{{
                      order.packageterm.day_reward
                    }}
                    Day</el-descriptions-item
                  >
                  <el-descriptions-item label="Type">{{
                    order.packageterm.type
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Stake Currency">{{
                    order.currencyStake.code
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Reward Currency">{{
                    order.currencyReward.code
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Principal Currency">{{
                    order.currencyReward.code
                  }}</el-descriptions-item>
                </el-descriptions>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-lg-12">
                <el-descriptions title="Order" :column="1" border>
                  <el-descriptions-item label="Code">{{
                    order.code
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Customer">{{
                    order.customer.email
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Amount stake"
                    >{{ order.amount_stake }}
                    {{ order.currencyStake.code }}</el-descriptions-item
                  >
                  <el-descriptions-item label="Amount reward"
                    >{{ order.amount_reward }}
                    {{ order.currencyReward.code }}</el-descriptions-item
                  >
                  <el-descriptions-item label="Total reward received"
                    >{{ order.total_amount_reward }}
                    {{ order.currencyReward.code }}</el-descriptions-item
                  >
                  <el-descriptions-item label="Subscription date">{{
                    order.subscription_date
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Redemption date">{{
                    order.redemption_date
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Last time reward">{{
                    order.last_time_reward
                  }}</el-descriptions-item>
                </el-descriptions>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-lg-12">
            <h4>Transactions</h4>
            <el-table
              ref="pageTable"
              :data="transactions"
              stripe
              style="width: 100%"
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
                  {{ scope.row.currency.title }}
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
                  {{ scope.row.amount }} {{ scope.row.currency.code }}
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
              >
              </el-table-column>
            </el-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";

export default {
  components: {
    FormErrors,
  },
  props: {
    locales: {
      default: null,
      type: Object,
    },
    orderTitle: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      order: null,
      transactions: [],
      form: new Form(),
      loading: false,
    };
  },
  created() {
    this.fetchOrder();
    console.log(this.orderTitle);
    this.fetchTransaction();
  },
  methods: {
    fetchOrder() {
      this.loading = true;
      axios
        .get(
          route("api.staking.order.detail", {
            order: this.$route.params.orderId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.order = response.data.data;
        });
    },
    fetchTransaction() {
      axios
        .get(
          route("api.staking.order.transaction", {
            orderId: this.$route.params.orderId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.transactions = response.data.data;
          console.log(this.transactions);
        });
    },
  },
};
</script>