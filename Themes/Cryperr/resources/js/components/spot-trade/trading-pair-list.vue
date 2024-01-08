<template>
  <div>
    <div class="wrap-table mb-4">
      <table class="table mb-4" style="min-width: 840px">
        <thead>
          <tr>
            <th>Pair Symbol</th>
            <th>
              <div class="d-flex align-items-center pointer">Price</div>
            </th>
            <th>
              <div class="d-flex flex-wrap justify-content-center pointer">
                <div class="d-flex flex-nowrap">
                  <a class="text me-2">24h</a>
                </div>
                <div class="d-flex flex-nowrap">
                  <a class="text me-2">Change</a>
                </div>
              </div>
            </th>
            <th>
              <div class="d-flex flex-nowrap justify-content-center pointer">
                <div class="text-nowrap">24h High/ 24h Low</div>
              </div>
            </th>
            <th>
              <div class="d-flex flex-nowrap justify-content-center pointer">
                24h Volume
              </div>
            </th>
            <th>
              <div class="d-flex flex-nowrap justify-content-center pointer">
                Market Cap
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in markets" :key="index">
            <td>
              <a :href="item.url_detail">
                <div class="d-flex align-items-center flex-nowrap text-nowrap">
                  <img
                    class="me-1"
                    width="16px"
                    height="16px"
                    :src="item.base?.icon"
                    alt=""
                  />
                  <img
                    class="me-1"
                    width="16px"
                    height="16px"
                    :src="item.quote?.icon"
                    alt=""
                  />
                  {{ item.base?.code }} /
                  <span class="name text-span ms-1">
                    {{ item.quote?.code }}
                  </span>
                </div>
              </a>
            </td>
            <td>
              <div>${{ item.price * item.quote?.price_usd }}</div>
            </td>
            <td>
              <div
                :class="
                  item.price_change_24h > 0
                    ? 'price-up text-center'
                    : 'price-down text-center'
                "
              >
                {{
                  ((item.price_change_24h * 100) / item.price) | format_number
                }}%
              </div>
            </td>
            <td>
              <div class="text-center">
                {{ item.hight_24h }} / {{ item.low_24h }}
              </div>
            </td>
            <td>
              <div class="text-center">
                ${{ item.volume_24h * (item.price * item.quote?.price_usd) }}
              </div>
            </td>
            <td>
              <div class="text-center">
                ${{
                  item.base?.total_supply * (item.price * item.quote?.price_usd)
                }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pair-list">
      <div class="pair-item" v-for="(item, index) in markets" :key="index">
        <div class="d-flex justify-content-between mb-3">
          <div>Name :</div>
          <a :href="item.url_detail">
            <div class="d-flex align-items-center flex-nowrap text-nowrap">
              <img
                class="me-1"
                width="14px"
                height="14px"
                :src="item.base?.icon"
                alt=""
              />
              <img
                class="me-1"
                width="16px"
                height="16px"
                :src="item.quote?.icon"
                alt=""
              />{{ item.base?.code }} /
              <span class="name text-span ms-1"> {{ item.quote?.code }} </span>
            </div>
          </a>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Price:</div>
          <div>${{ item.price * item.quote?.price_usd }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div class="d-flex flex-wrap justify-content-center pointer">
            <div class="d-flex flex-nowrap">
              <a class="text me-2">24h</a>
            </div>
            <a class="text me-2">Change</a>
          </div>
          <div :class="item.price_change_24h > 0 ? 'price-up' : 'price-down'">
            {{ ((item.price_change_24h * 100) / item.price) | format_number }}%
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>24h High/ 24h Low:</div>
          <div>{{ item.hight_24h }}/{{ item.low_24h }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>24h Volume:</div>
          <div>
            ${{ item.volume_24h * (item.price * item.quote?.price_usd) }}
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Marketcap:</div>
          <div>
            ${{
              item.base?.total_supply * (item.price * item.quote?.price_usd)
            }}
          </div>
        </div>
        <div class="text-center mt-2">
          <a class="text-span" :href="item.url_detail">
            Go to trade
            <img
              class="ms-2"
              style="vertical-align: baseline"
              width="6px"
              height="10px"
              :src="getPathImg('images/icons/arrow-right.png')"
              alt=""
            />
          </a>
        </div>
      </div>
    </div>
    <paginate
      :page-count="meta.totalPage"
      :click-handler="changePage"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :container-class="'box-wrap-pagination'"
    >
    </paginate>
  </div>
</template>

<script>
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";
export default {
  mixins: [GetPathImg],
  created() {
    this.getMarketsList();
    const channelPairInfo = Pusher.subscribe(`Market.info`);
    let vm = this;
    channelPairInfo.bind("HookMarketInfo", function (data) {
      const dataInfo = data.dataInfo;
      console.log(dataInfo);
      if (dataInfo !== undefined) {
        for (let i = 0; i < vm.markets.length; i++) {
          const market = vm.markets[i];
          if (
            dataInfo.market_code !== undefined &&
            market.symbol == dataInfo.market_code
          ) {
            vm.markets[i].price = dataInfo.price;
            vm.markets[i].price_change_24h = dataInfo.price_change_24h;
            vm.markets[i].volume_24h = dataInfo.volume_24h;
            vm.markets[i].low_24h = dataInfo.low_24h;
            vm.markets[i].hight_24h = dataInfo.hight_24h;
            vm.markets[i].quote.price_usd = dataInfo.quote.priceUSD;
            break;
          }
        }
      }
    });
  },
  data() {
    return {
      markets: [],
      meta: { current_page: 1, per_page: 10, total: 0, totalPage: 0, page: 1 },
    };
  },
  methods: {
    changePage(p) {
      this.meta.page = p;
      this.getListWithdraw();
    },
    getMarketsList() {
      Axios.get("/api/trade/getListMarket", {
        params: {
          page: this.meta.page,
          per_page: this.meta.per_page,
        },
      })
        .then((response) => {
          this.markets = response.data.data.markets;
          this.meta = response.data.data.meta;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  filters: {
    format_number: function (value) {
      if (!value) return 0;
      return value.toFixed(2);
    },
  },
};
</script>