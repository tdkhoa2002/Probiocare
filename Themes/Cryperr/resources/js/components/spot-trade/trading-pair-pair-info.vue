<template>
  <fragment>
    <div class="trading-pair-head" v-if="!isMobile">
      <div class="px-2 d-flex align-items-center justify-content-between w-100">
        <div class="left">
          <div class="childrenContainer">
            <h1 style="font-size: 20px; font-weight: 500">
              {{ dataPairInfo.base.symbol }}/{{ dataPairInfo.quote.symbol }}
            </h1>
            <div class="d-flex align-items-center">
              <svg
                width="7"
                height="11"
                viewBox="0 0 7 11"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M1 7.5V1.5L1.5 1.72222L5.5 3.5V9.5L1 7.5Z"
                  fill="#989898"
                />
                <path
                  d="M6 0.5L1 1.5M1 1.5V7.5L5.5 9.5V3.5L1.5 1.72222M1 1.5L1.5 1.72222M6.5 7.5V1.72222H1.5"
                  stroke="#989898"
                  stroke-width="0.8"
                />
                <path
                  d="M3.80078 4.4191C3.80078 4.45627 3.76167 4.48044 3.72842 4.46382L2.82842 4.01382C2.81148 4.00535 2.80078 3.98804 2.80078 3.9691L2.80078 3.0809C2.80078 3.04373 2.8399 3.01956 2.87314 3.03618L3.77314 3.48618C3.79008 3.49465 3.80078 3.51196 3.80078 3.5309L3.80078 4.4191Z"
                  fill="#333333"
                />
                <path
                  d="M3.80078 7.4191C3.80078 7.45627 3.76167 7.48044 3.72842 7.46382L2.82842 7.01382C2.81148 7.00535 2.80078 6.98804 2.80078 6.9691L2.80078 5.0809C2.80078 5.04373 2.8399 5.01956 2.87314 5.03618L3.77314 5.48618C3.79008 5.49465 3.80078 5.51196 3.80078 5.5309L3.80078 7.4191Z"
                  fill="#333333"
                />
              </svg>
              <a
                data-bn-type="link"
                href=""
                disabled=""
                target="_blank"
                class="fw-light"
                >{{ dataPairInfo.base.symbol }} Price</a
              >
            </div>
          </div>
          <div class="nowPrice">
            <div class="showPrice" :class="[priceDirection]">
              {{ dataPairInfo.price }}
            </div>
            <div class="subPrice">
              ${{ dataPairInfo.price * dataPairInfo.quote.priceUSD }}
            </div>
          </div>
          <div class="tickerListContainer">
            <div class="tickerList">
              <div style="grid-area: A / A / A / A">
                <div class="tickerItemLabel">24h Change</div>
                <div class="tickerPriceText">
                  <span style="color: rgb(14, 203, 129); display: flex">
                    <div style="direction: ltr" :class="[price24hDirection]">
                      {{ dataPairInfo.priceChange24h }}
                    </div>
                    &nbsp;
                    <div style="direction: ltr" :class="[price24hDirection]">
                      {{
                        ((dataPairInfo.priceChange24h * 100) /
                          dataPairInfo.price)
                          | format_number
                      }}%
                    </div>
                  </span>
                </div>
              </div>
              <div style="grid-area: B / B / B / B">
                <div class="tickerItemLabel">24h High</div>
                <div class="tickerPriceText">{{ dataPairInfo.hight24h }}</div>
              </div>
              <div style="grid-area: C / C / C / C">
                <div class="tickerItemLabel">24h Low</div>
                <div class="tickerPriceText">{{ dataPairInfo.low24h }}</div>
              </div>
              <div style="grid-area: D / D / D / D">
                <div class="tickerItemLabel">
                  24h Volume({{ dataPairInfo.base.symbol }})
                </div>
                <div class="tickerPriceText">{{ dataPairInfo.volume24h }}</div>
              </div>
              <div style="grid-area: E / E / E / E">
                <div class="tickerItemLabel">
                  24h Volume({{ dataPairInfo.quote.symbol }})
                </div>
                <div class="tickerPriceText">
                  {{ dataPairInfo.volumePair24h }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="trading-info" v-if="isMobile">
      <div class="d-flex flex-column">
        <div class="childrenContainer mb-2">
          <h1 style="font-size: 20px; font-weight: 500">
            {{ dataPairInfo.base.symbol }}/{{ dataPairInfo.quote.symbol }}
          </h1>
          <div class="d-flex align-items-center">
            <svg
              width="7"
              height="11"
              viewBox="0 0 7 11"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1 7.5V1.5L1.5 1.72222L5.5 3.5V9.5L1 7.5Z"
                fill="#989898"
              ></path>
              <path
                d="M6 0.5L1 1.5M1 1.5V7.5L5.5 9.5V3.5L1.5 1.72222M1 1.5L1.5 1.72222M6.5 7.5V1.72222H1.5"
                stroke="#989898"
                stroke-width="0.8"
              ></path>
              <path
                d="M3.80078 4.4191C3.80078 4.45627 3.76167 4.48044 3.72842 4.46382L2.82842 4.01382C2.81148 4.00535 2.80078 3.98804 2.80078 3.9691L2.80078 3.0809C2.80078 3.04373 2.8399 3.01956 2.87314 3.03618L3.77314 3.48618C3.79008 3.49465 3.80078 3.51196 3.80078 3.5309L3.80078 4.4191Z"
                fill="#333333"
              ></path>
              <path
                d="M3.80078 7.4191C3.80078 7.45627 3.76167 7.48044 3.72842 7.46382L2.82842 7.01382C2.81148 7.00535 2.80078 6.98804 2.80078 6.9691L2.80078 5.0809C2.80078 5.04373 2.8399 5.01956 2.87314 5.03618L3.77314 5.48618C3.79008 5.49465 3.80078 5.51196 3.80078 5.5309L3.80078 7.4191Z"
                fill="#333333"
              ></path>
            </svg>
            <a
              data-bn-type="link"
              href=""
              disabled=""
              target="_blank"
              class="fw-light"
              >{{ dataPairInfo.base.symbol }} Price</a
            >
          </div>
        </div>
        <div class="nowPrice">
          <div id="a313" class="showPrice" :class="[priceDirection]">
            {{ dataPairInfo.price }}
          </div>
          <div class="subPrice price-up">
            ${{ dataPairInfo.price * dataPairInfo.quote.priceUSD }}
          </div>
        </div>
      </div>
      <div class="tickerList row">
        <div class="col-6">
          <div class="tickerItemLabel">24h Change</div>
          <div class="tickerPriceText">
            <span style="color: rgb(14, 203, 129); display: flex">
              <div style="direction: ltr" :class="[price24hDirection]">
                {{ dataPairInfo.priceChange24h }}
              </div>
              &nbsp;
              <div style="direction: ltr" :class="[price24hDirection]">
                {{
                  ((dataPairInfo.priceChange24h * 100) / dataPairInfo.price)
                    | format_number
                }}%
              </div>
            </span>
          </div>
        </div>
        <div class="col-6">
          <div class="tickerItemLabel">24h Hight/Low</div>
          <div class="tickerPriceText">
            {{ dataPairInfo.hight24h }}/{{ dataPairInfo.low24h }}
          </div>
        </div>
        <div class="col-6">
          <div class="tickerItemLabel">
            24h Volume({{ dataPairInfo.base.symbol }})
          </div>
          <div class="tickerPriceText">{{ dataPairInfo.volume24h }}</div>
        </div>
        <div class="col-6">
          <div class="tickerItemLabel">
            24h Volume({{ dataPairInfo.quote.symbol }})
          </div>
          <div class="tickerPriceText">
            {{ dataPairInfo.volume24h * dataPairInfo.price }}
          </div>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
import Axios from "axios";
import { Fragment } from "vue-fragment";

export default {
  components: { Fragment },
  props: {
    pairInfo: {
      default: Object,
    },
    priceDirection: {
      default: "",
    },
    price24hDirection: {
      default: "",
    },
  },
  mixins: [],
  created() {
    this.dataPairInfo = this.pairInfo;
    this.dataPrice24hDirection = this.priceDirection;
    this.dataPriceDirection = this.price24hDirection;
  },
  data() {
    return {
      dataPairInfo: Object,
      dataPriceDirection: "",
      dataPrice24hDirection: "",
      isMobile: false,
    };
  },
  methods: {},
  mounted() {},
  filters: {
    format_number: function (value) {
      if (!value) return 0;
      return value.toFixed(2);
    },
  },
  watch: {
    pairInfo: function (newVal, oldVal) {
      this.dataPairInfo = newVal;
    },
    priceDirection: function (newVal, oldVal) {
      this.dataPriceDirection = newVal;
    },
    price24hDirection: function (newVal, oldVal) {
      this.dataPrice24hDirection = newVal;
    },
  },
};
</script>
