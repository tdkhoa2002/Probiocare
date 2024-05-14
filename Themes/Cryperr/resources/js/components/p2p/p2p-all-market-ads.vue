<template>
  <div class="merchant-view-market">
    <div class="bg-secondary py-3" style="border-bottom: 1px solid #989898">
      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="btn-group">
            <a
              class="btn"
              v-bind:class="{
                'btn-green': type == 'SELL',
                'btn-outline': type != 'SELL',
              }"
              style="width: 80px"
              @click="handleClickType('SELL')"
              >BUY</a
            >
            <a
              class="btn btn-outline"
              v-bind:class="{
                'btn-danger': type == 'BUY',
                'btn-outline': type != 'BUY',
              }"
              style="width: 80px"
              @click="handleClickType('BUY')"
              >SELL</a
            >
          </div>
          <!-- <div class="btn-group" v-else>
            <a
              class="btn btn-outline"
              style="width: 80px"
              @click="handleClickType('SELL')"
              >BUY</a
            >
            <a
              class="btn btn-danger"
              style="width: 80px"
              @click="handleClickType('BUY')"
              >SELL</a
            >
          </div> -->
          <div class="symbol-list px-2 px-sm-3">
            <a
              class="btn btn-text"
              v-bind:class="{ 'bottom-border': currency === 'ALL' }"
              @click="handleClickCrypto('ALL')"
              >ALL</a
            >
            <a
              class="btn btn-text"
              :key="key"
              v-for="(item, key) in crypto"
              v-bind:class="{ 'bottom-border': currency === item.id }"
              @click="handleClickCrypto(item.id)"
              >{{ item.code }}</a
            >
            <!-- <a class="btn btn-text bottom-border" href="">BTC</a> -->
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid pt-4">
      <form action="" class="form-wallet-history row mb-2">
        <!-- <div class="col-6 col-md-6 col-lg-3">
          <div class="form-item">
            <label for="amount" class="form-label"> Amount </label>
            <div class="input-group">
              <input type="text" class="input" placeholder="Enter Amount" />
              <div class="input-suffix ps-2">
                | <button class="btn btn-text p-0 ms-2">Search</button>
              </div>
            </div>
          </div>
        </div> -->
        <div class="col-6 col-md-6 col-lg-3">
          <div class="form-item">
            <label for="fiat" class="form-label"> Fiat </label>
            <select id="fiat" class="input secondary">
              <option selected value="All">All Fiat</option>
              <option v-for="item in fiats" :value="item.id" :key="item.id">
                {{ item.code }}
              </option>
            </select>
          </div>
        </div>
        <!-- <div class="col-6 col-md-6 col-lg-3">
          <div class="form-item">
            <label for="payment" class="form-label"> Payment </label>
            <select id="payment" class="input secondary">
              <option selected value="All">All Payment</option>
              <option v-for="item in paymentMethods" :value="item.id">
                {{ item.title }}
              </option>
            </select>
          </div>
        </div> -->
        <!-- <div class="col-6 col-md-6 col-lg-3">
          <div class="form-item">
            <label for="region" class="form-label"> Available Region(s) </label>
            <select id="region" class="input secondary">
              <option selected>All Regions</option>
              <option value="BANK">BANK</option>
              <option value="MOMO">MOMO</option>
            </select>
          </div>
        </div> -->
      </form>
      <div class="wrap-table">
        <table class="table" style="min-width: 700px">
          <thead>
            <tr>
              <th scope="col">Advertiser</th>
              <th scope="col">Price</th>
              <th scope="col">Available / Limit</th>
              <th scope="col">Payment Method</th>
              <th scope="col ">
                <div class="text-end">Trade: 0 Fee</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ad in ads" :key="ad.id">
              <td>
                <div class="d-flex me-3">
                  <!-- <img
                    class="pointer me-2"
                    width="24px"
                    height="24px"
                    :src="getPathImg('images/logo.png')"
                    alt=""
                  /> -->
                  <div class="d-flex flex-column">
                    <a :href="ad.url.agent_url">
                      <div class="d-flex align-items-center">
                      <span class="email fs-7 fw-medium me-2">{{
                        ad.customer.full_name
                      }}</span>
                      <img
                        class="pointer"
                        width="14px"
                        height="14px"
                        :src="getPathImg('images/icons/checked-round-blue.png')"
                        alt=""
                      />
                    </div>
                    </a>
                    <!-- <span class="name fw-light fs-7">Join on 22-02-2022</span> -->
                  </div>
                </div>
              </td>
              <td>{{ ad.fixed_price }} {{ ad.fiat_currency.code }}</td>
              <td>
                <div class="fw-light fs-7">
                  Available:
                  <span class="fs-6 fw-normal"
                    >{{ ad.total_trade_amount - ad.total_filled }}
                    {{ ad.asset_currency.code }}</span
                  >
                </div>
                <div class="fw-light fs-7">
                  Limit:
                  <span class="fs-6 fw-normal">
                    {{ ad.order_limit_min }}-{{ ad.order_limit_max
                    }}{{ ad.asset_currency.code }}</span
                  >
                </div>
              </td>
              <td>
                
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline me-2 fs-7 py-0 px-2"
                    style="height: 36px"
                    v-for="payment in ad.paymentMethods" :key="payment.id"
                  >
                  {{ payment.paymentMethod.title ?? "" }}
                  </button>
                </div>
              </td>
              <td>
                <div class="text-end">
                  <a :href="ad.url.create_order">
                    <button class="btn btn-danger" v-if="ad.type == 'BUY'">
                      SELL {{ ad.asset_currency.code }}
                    </button>
                    <button class="btn btn-green" v-if="ad.type == 'SELL'">
                      BUY {{ ad.asset_currency.code }}
                    </button>
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- pagination -->
        <!-- <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link text-span me-2" href="#">Previous</a>
            </li>
            <li class="page-item">
              <a class="page-link active" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link text ms-2" href="#">Next</a>
            </li>
          </ul>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    currencies: {
      default: null,
    },
    paymentMethods: {
      default: null,
    },
    // ordertype: {
    //   default: "ask",
    // },
  },
  mixins: [GetPathImg],
  created() {
    this.getP2POrders(this.type, this.currency, this.fiat, this.paymentMethod);
    this.crypto = _.filter(this.currencies, { type: "CRYPTO" });
    this.fiats = _.filter(this.currencies, { type: "FIAT" });
    // this.getOrderBidAsk(this.pairsymbol, this.ordertype);
  },
  data() {
    return {
      type: "SELL",
      currency: "ALL",
      fiat: "ALL",
      paymentMethod: "ALL",
      crypto: [],
      fiats: [],
      ads: [],
    };
  },
  methods: {
    handleClickType(type) {
      this.type = type;
      this.getP2POrders(
        this.type,
        this.currency,
        this.fiat,
        this.paymentMethod
      );
    },
    handleClickCrypto(itemID) {
      this.currency = itemID;
      this.getP2POrders(
        this.type,
        this.currency,
        this.fiat,
        this.paymentMethod
      );
    },
    getP2POrders(type, currency, fiat, paymentMethod) {
      let url =
        "/api/p2p/get-ads?" +
        "type=" +
        type +
        "&currency=" +
        currency +
        "&fiat=" +
        fiat +
        "&paymentMethod=" +
        paymentMethod;
      console.log(url);
      Axios.get(url)
        .then((response) => {
          if (response.data.error === false) {
            this.ads = response.data.data;
            console.log("ads======>", this.ads);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    // console.log("mounted",this.crypto);
    // console.log("mounted",this.fiats);
  },
  
};
</script>
