<template>
  <div class="orderbook-ask">
    <div class="orderbook-header">
      <div class="orderbook-header-tips">
        <button data-bn-type="button" data-testid="defaultModeButton">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path d="M4 4h7v7H4V4z" fill="#F6465D"></path>
            <path d="M4 13h7v7H4v-7z" fill="#0ECB81"></path>
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M13 4h7v4h-7V4zm0 6h7v4h-7v-4zm7 6h-7v4h7v-4z"
              fill="currentColor"
            ></path>
          </svg>
        </button>
        <button data-bn-type="button" data-testid="buyModeButton">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path d="M4 4h7v16H4V4z" fill="#0ECB81"></path>
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M13 4h7v4h-7V4zm0 6h7v4h-7v-4zm7 6h-7v4h7v-4z"
              fill="currentColor"
            ></path>
          </svg>
        </button>
        <button data-bn-type="button" data-testid="sellModeButton">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path d="M4 4h7v16H4V4z" fill="#F6465D"></path>
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M13 4h7v4h-7V4zm0 6h7v4h-7v-4zm7 6h-7v4h7v-4z"
              fill="currentColor"
            ></path>
          </svg>
        </button>
      </div>
      <div class="orderbook-tickSize">
        <div class="tick-content">
          <span class="label me-2">0.01</span
          ><svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              d="M16.5 8.49v2.25L12 15.51l-4.5-4.77V8.49h9z"
              fill="currentColor"
            ></path>
          </svg>
        </div>
        <div class="orderbook-contorl-overlay me-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M10 3h4v4h-4V3zm0 7h4v4h-4v-4zm4 7h-4v4h4v-4z"
              fill="currentColor"
            ></path>
          </svg>
        </div>
      </div>
    </div>
    <div class="table-trade-info">
      <div class="table-head">
        <div class="sort-item-wrap">
          <div class="sort-item-label">Price(USDT)</div>
        </div>
        <div class="sort-item-wrap">
          <div class="sort-item-label">Amount(BTC)</div>
        </div>
        <div class="sort-item-wrap d-flex justify-content-end">
          <div class="sort-item-label">Total</div>
        </div>
      </div>
      <div class="table-content">
        <div class="list-item-container fixed-size-list">
          <div
            class="process-container"
            :key="key"
            v-for="(item, key) in orderData"
          >
            <a class="content" href="/en/trade/ADA_TUSD">
              <div class="item item-symbol">
                <div class="item-symbol-text price-down">{{ item.price }}</div>
              </div>
              <div class="item">
                <div class="item-price-text">{{ item.amount }}</div>
              </div>
              <div class="item item-change d-flex justify-content-end">
                <div class="item-change-text item-color-sell">
                  {{ item.price * item.amount }}
                </div>
              </div>
            </a>
            <div
              class="progress-bar ask-bar"
              :style="{
                transform:
                  'translateX(-' + (item.amount / maxAmount) * 100 + '%)',
                left: '100%',
              }"
            ></div>
          </div>
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
    pairsymbol: {
      default: null,
    },
    ordertype: {
      default: "ask",
    },
  },
  created() {
    this.getOrderBidAsk(this.pairsymbol, this.ordertype);
  },
  data() {
    return {
      orderData: [],
      maxAmount: 0,
    };
  },
  methods: {
    getOrderBidAsk(pairsymbol, ordertype) {
      if (pairsymbol != "") {
        Axios.get(
          "/api/trading-data/get-order-data/" + pairsymbol + "/" + ordertype
        )
          .then((response) => {
            if (response.data.error === false) {
              this.orderData = response.data.data.data;
              this.handleOrderData(response.data.data.data);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.orderData = [];
      }
    },
    handleOrderData(data) {
      this.maxAmount = _.maxBy(data, "amount").amount;
    },
  },
  mounted() {
    
  },
};
</script>
