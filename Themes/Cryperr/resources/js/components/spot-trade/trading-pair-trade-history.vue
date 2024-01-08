<template>
  <div class="trading-pair-trades">
    <div class="tabs-header">
      <a href="#" class="tab-label me-4 active">Market Trades </a>
    </div>
    <div class="table-trade-info">
      <div class="table-head">
        <div class="sort-item-wrap">
          <div class="sort-item-label" v-if="pairInfo != null">
            Price({{ pairInfo?.quote?.symbol }})
          </div>
        </div>
        <div class="sort-item-wrap">
          <div class="sort-item-label" v-if="pairInfo != null">
            Amount({{ pairInfo?.base?.symbol }})
          </div>
        </div>
        <div class="sort-item-wrap d-flex justify-content-end">
          <div class="sort-item-label">Time</div>
        </div>
      </div>
      <div class="table-content">
        <div class="list-item-container fixed-size-list">
          <a
            class="content"
            href="#"
            :key="key"
            v-for="(item, key) in marketTrades"
          >
            <div class="item item-symbol">
              <div v-if="item.trade_type == 'SELL'">
                <div class="item-symbol-text price-down">{{ item.price }}</div>
              </div>
              <div v-if="item.trade_type == 'BUY'">
                <div class="item-symbol-text price-up">{{ item.price }}</div>
              </div>
            </div>
            <div class="item">
              <div class="item-price-text">{{ item.amount }}</div>
            </div>
            <div class="item item-change d-flex justify-content-end">
              <div class="item-change-text item-color-sell">
                {{ item.created_at | format_date }}
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import _ from "lodash";

export default {
  props: {
    marketTrades: {
      default: [],
    },
    pairInfo: {
      default: Object,
    },
  },
  mixins: [],
  data() {
    return {
      dataMarketTrades: [],
    };
  },
  created() {
    this.dataMarketTrades = this.marketTrades;
  },
  methods: {},
  mounted() {},
  filters: {
    format_date: function (value) {
      if (!value) return "";
      return moment(String(value)).format("hh:mm:ss");
    },
  },
  watch: {
    marketTrades: function (newVal, oldVal) {
      this.dataMarketTrades = newVal;
    },
  },
};
</script>
