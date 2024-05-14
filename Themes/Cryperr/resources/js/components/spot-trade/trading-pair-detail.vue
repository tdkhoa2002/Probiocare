<template>
  <fragment>
    <div class="trading-pair-body">
      <!-- Desktop -->
      <div v-if="!isMobile">
        <div class="trading-pair-content">
          <trading-pair-pair-info
            :pairInfo="pairInfo"
            :priceDirection="priceDirection"
            :price24hDirection="price24hDirection"
            v-if="pairInfo != null"
          ></trading-pair-pair-info>
          <trading-pair-market-list
            :infoPairSocket="dataInfoPairSocket"
          ></trading-pair-market-list>
          <trading-pair-trade-history
            :marketTrades="marketTrades"
            :pairInfo="pairInfo"
          ></trading-pair-trade-history>

          <!-- <div class="trading-pair-orderbook">
            <trading-pair-ask
              :pairsymbol="pairsymbol"
              ordertype="ask"
            ></trading-pair-ask>
            <trading-pair-bid
              :pairsymbol="pairsymbol"
              ordertype="bid"
            ></trading-pair-bid>
          </div> -->

          <trading-pair-chart
            :pairsymbol="pairsymbol"
            :tradingData="tradingData"
            :linkRoute="linkRoute"
          ></trading-pair-chart>
          <trading-pair-orderbook
            :pairsymbol="pairsymbol"
            :check-auth="checkAuth"
            :link-login="linkLogin"
            :pairInfo="pairInfo"
            :link-register="linkRegister"
          ></trading-pair-orderbook>
        </div>
        <trading-pair-my-trade
          v-if="checkAuth"
          :dataTradeSocket="dataTradeSocket"
          :pairsymbol="pairsymbol"
          :customerid="customer"
        />
      </div>

      <!-- Mobile -->
      <div class="trading-pair-mobile pt-3" v-else>
        <trading-pair-pair-info
          :pairInfo="pairInfo"
          v-if="pairInfo != null"
        ></trading-pair-pair-info>
        <trading-pair-chart
          :pairsymbol="pairsymbol"
          :tradingData="tradingData"
          :linkRoute="linkRoute"
        ></trading-pair-chart>
        <trading-pair-orderbook
          :pairsymbol="pairsymbol"
          :pairInfo="pairInfo"
          :check-auth="checkAuth"
          :link-login="linkLogin"
          :link-register="linkRegister"
        ></trading-pair-orderbook>

        <div class="order-history" v-if="!checkAuth">
          <div class="tab-orderform">
            <ul class="tabs-list nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active pointer" aria-current="page" href="#"
                  >Open Orders (0)</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link pointer" href="#">Order History</a>
              </li>
            </ul>
          </div>
          <div class="tab-content-1">
            <span class="text-primary">Sign In</span>
            <span class="px-2">or</span>
            <span class="text-primary">Sign Up</span>
          </div>
        </div>

        <trading-pair-my-trade
          v-else
          :pairsymbol="pairsymbol"
          :customerid="customer"
          :dataTradeSocket="dataTradeSocket"
        ></trading-pair-my-trade>
      </div>
    </div>

    <div class="group-btn-trade-fixed">
      <button class="btn btn-buy">Buy</button>
      <button class="btn btn-sell">Sell</button>
    </div>
  </fragment>
</template>

<script>
import Axios from "axios";
import { Fragment } from "vue-fragment";
import { isMobile } from "mobile-device-detect";

export default {
  components: { Fragment },
  props: {
    customer: {
      default: null,
    },
    pairsymbol: {
      default: null,
    },
    checkAuth: {
      default: false,
    },
    linkLogin: {
      default: null,
    },
    linkRegister: {
      default: null,
    },
    linkRoute: {
      default: null,
    },
  },
  mixins: [],
  data() {
    return {
      isMobile,
      tradingData: [],
      marketTrades: [],
      pairInfo: null,
      price24hDirection: "",
      priceDirection: "",
      dataInfoPairSocket: null,
      dataTradeSocket: null,
      // historyTrades: [],
    };
  },
  created() {
    this.getPairInfo(this.pairsymbol);
    let vm = this;
    const channel = Pusher.subscribe(`Market.${this.pairsymbol}`);
    const channelPairInfo = Pusher.subscribe(`Market.info`);
    channel.bind("HookTradeMarket", function (data) {
      var newArray = vm.marketTrades.slice();
      newArray.unshift(data.dataTrade);
      vm.marketTrades = newArray;
      vm.dataTradeSocket=data.dataTrade
    });
    channelPairInfo.bind("HookMarketInfo", function (data) {
      const dataInfo = data.dataInfo;
      const pairInfo = vm.pairInfo;
      vm.dataInfoPairSocket = dataInfo;
      if (dataInfo !== undefined && pairInfo != null) {
        if (pairInfo.symbol == dataInfo.market_code) {
          vm.pairInfo.hight24h = dataInfo.hight_24h;
          vm.pairInfo.low24h = dataInfo.low_24h;
          vm.pairInfo.price = dataInfo.price;
          vm.pairInfo.priceChange24h = dataInfo.price_change_24h;
          vm.pairInfo.volume24h = dataInfo.volume_24h;
          vm.pairInfo.volumePair24h = dataInfo.volume_pair_24h;
          vm.pairInfo.quote.priceUSD = dataInfo.quote.priceUSD;
          if (dataInfo.price_change_24h > 0) {
            vm.price24hDirection = "price-up";
            vm.priceDirection = "price-up";
          } else {
            vm.price24hDirection = "price-down";
            vm.priceDirection = "price-down";
          }
        }
      }
    });
  },
  methods: {
    getPairInfo(pairsymbol) {
      if (pairsymbol != "") {
        Axios.get("/api/trading-data/pair-info/" + pairsymbol)
          .then((response) => {
            if (response.data.error === false) {
              const pairInfoResponse = response.data.data.pairInfo;
              const tradeHistoriesResponse = response.data.data.tradeHistories;
              this.pairInfo = pairInfoResponse;
              if (pairInfoResponse.priceChange24h > 0) {
                this.price24hDirection = "price-up";
                this.priceDirection = "price-up";
              } else {
                this.price24hDirection = "price-down";
                this.priceDirection = "price-down";
              }

              this.marketTrades = tradeHistoriesResponse;
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.pairInfo = null;
      }
    },
  },
  mounted() {},
};
</script>