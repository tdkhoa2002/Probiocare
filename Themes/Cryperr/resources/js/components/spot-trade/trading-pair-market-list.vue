<template>
  <div class="trading-pair-market">
    <div class="marketWrap">
      <div class="wrap-input">
        <div class="bn-input-prefix">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              d="M3 10.982c0 3.845 3.137 6.982 6.982 6.982 1.518 0 3.036-.506 4.149-1.416L18.583 21 20 19.583l-4.452-4.452c.81-1.113 1.416-2.631 1.416-4.149 0-1.922-.81-3.643-2.023-4.958C13.726 4.81 11.905 4 9.982 4 6.137 4 3 7.137 3 10.982zM13.423 7.44a4.819 4.819 0 011.416 3.441c0 1.315-.506 2.53-1.416 3.44a4.819 4.819 0 01-3.44 1.417 4.819 4.819 0 01-3.441-1.417c-1.012-.81-1.518-2.023-1.518-3.339 0-1.315.506-2.53 1.416-3.44.911-1.012 2.227-1.518 3.542-1.518 1.316 0 2.53.506 3.44 1.416z"
              fill="currentColor"
            ></path>
          </svg>
        </div>
        <input
          placeholder="Search Curency"
          class="trade-widget-search"
          value=""
        />
      </div>
      <div class="box-wrap-search-currency py-2">
        <!-- <div class="starFilledD">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M11.173 3.007L12.768 3l2.41 5.11 5.326.831.496 1.495-3.89 4.013.895 5.636-1.298.915-4.735-2.648L7.236 21l-1.296-.923.946-5.632L3 10.436l.496-1.495 5.322-.83 2.355-5.104z"
              fill="currentColor"
            ></path>
          </svg>
        </div> -->
        <div class="tabBtn">MTV</div>
        <div class="tabBtn">MUSD</div>
        <!-- <div class="rightArrow" style="z-index: 3">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M12.288 12l-3.89 3.89 1.768 1.767L15.823 12l-1.768-1.768-3.889-3.889-1.768 1.768 3.89 3.89z"
              fill="currentColor"
            ></path>
          </svg>
        </div> -->
      </div>
      <div class="table-trade-info">
        <div class="table-head">
          <div class="sort-item-wrap">
            <div class="sort-item-label">Pair</div>
            <!-- <svg
              width="6"
              height="9"
              viewBox="0 0 6 9"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M2.98523 8.28364C2.73539 8.57212 2.28787 8.57212 2.03803 8.28364L0.153954 6.10809C-0.197442 5.70233 0.0907869 5.07143 0.627553 5.07143H4.39571C4.93248 5.07143 5.2207 5.70233 4.86931 6.10809L2.98523 8.28364Z"
                fill="#989898"
              />
              <path
                d="M2.03821 0.716364C2.28804 0.427879 2.73557 0.427879 2.9854 0.716364L4.86948 2.89191C5.22088 3.29767 4.93265 3.92857 4.39588 3.92857H0.627727C0.0909614 3.92857 -0.197267 3.29767 0.154128 2.89191L2.03821 0.716364Z"
                fill="#989898"
              />
            </svg> -->
          </div>
          <div class="sort-item-wrap">
            <div class="sort-item-label">Price</div>
            <!-- <svg
              width="6"
              height="9"
              viewBox="0 0 6 9"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M2.98523 8.28364C2.73539 8.57212 2.28787 8.57212 2.03803 8.28364L0.153954 6.10809C-0.197442 5.70233 0.0907869 5.07143 0.627553 5.07143H4.39571C4.93248 5.07143 5.2207 5.70233 4.86931 6.10809L2.98523 8.28364Z"
                fill="#989898"
              />
              <path
                d="M2.03821 0.716364C2.28804 0.427879 2.73557 0.427879 2.9854 0.716364L4.86948 2.89191C5.22088 3.29767 4.93265 3.92857 4.39588 3.92857H0.627727C0.0909614 3.92857 -0.197267 3.29767 0.154128 2.89191L2.03821 0.716364Z"
                fill="#989898"
              />
            </svg>-->
          </div>
          <div class="sort-item-wrap d-flex justify-content-end">
            <div class="sort-item-label">Change 24h</div>
            <svg
              width="6"
              height="9"
              viewBox="0 0 6 9"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M2.98523 8.28364C2.73539 8.57212 2.28787 8.57212 2.03803 8.28364L0.153954 6.10809C-0.197442 5.70233 0.0907869 5.07143 0.627553 5.07143H4.39571C4.93248 5.07143 5.2207 5.70233 4.86931 6.10809L2.98523 8.28364Z"
                fill="#989898"
              />
              <path
                d="M2.03821 0.716364C2.28804 0.427879 2.73557 0.427879 2.9854 0.716364L4.86948 2.89191C5.22088 3.29767 4.93265 3.92857 4.39588 3.92857H0.627727C0.0909614 3.92857 -0.197267 3.29767 0.154128 2.89191L2.03821 0.716364Z"
                fill="#989898"
              />
            </svg>
          </div>
        </div>
        <div class="table-content">
          <div
            class="list-item-container fixed-size-list"
            :key="key"
            v-for="(item, key) in markets"
          >
            <a class="content" :href="'/trade/pair/' + item.symbol">
              <div class="item item-symbol">
                <!-- <div class="favorite">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                  >
                    <path
                      d="M21.4 10.8c-.3-1.1-.3-1.1-.7-2.1l-6-.1L12.8 3h-2.2l-2 5.6-5.9.1c-.3 1.1-.3 1.1-.7 2.1l4.8 3.6L5 20.1l1.8 1.3 4.9-3.4 4.9 3.4c.9-.7.9-.6 1.8-1.3l-1.8-5.7 4.8-3.6z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </div> -->
                <div class="item-symbol-text">
                  <span class="item-symbol-ba">{{ item.base.symbol }}</span
                  ><span>/{{ item.quote.symbol }}</span>
                </div>
                <!-- <span class="market-multiple">3x</span> -->
              </div>
              <div class="item">
                <div class="item-price-text item-color-buy" v-bind:class="item.priceChange24h > 0?'price-up':'price-down'">
                  {{ item.price }}
                </div>
              </div>
              <div class="item item-change d-flex justify-content-end">
                <div class="item-change-text item-color-sell" v-bind:class="item.priceChange24h > 0?'price-up':'price-down'">
                  {{((item.priceChange24h * 100) / item.price)}}%
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  props: {
    infoPairSocket: {
      default: null,
    },
  },
  mixins: [],
  created() {
    this.getMarketsList();
  },
  data() {
    return {
      markets: [],
    };
  },
  methods: {
    getMarketsList() {
      Axios.get("/api/trading-data/markets")
        .then((response) => {
          if (response.data.error === false) {
            this.markets = response.data.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  watch: {
    infoPairSocket: function (newVal) {
      for (let i = 0; i < this.markets.length; i++) {
        const market = this.markets[i];
        if (
          newVal.market_code !== undefined &&
          market.symbol == newVal.market_code
        ) {
          this.markets[i].price = newVal.price;
          this.markets[i].priceChange24h = newVal.price_change_24h;
          break;
        }
      }
    },
  },
};
</script>
