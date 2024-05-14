<template>
  <div class="p2p-order">
    <div class="bg-secondary py-3" style="border-bottom: 1px solid #989898">
      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <button
            class="btn btn-text"
            v-bind:class="{ 'bottom-border': status === 'ALL' }"
            @click="handleClickStatus('ALL')"
          >
            All Orders
          </button>
          <button
            class="btn btn-text"
            v-bind:class="{ 'bottom-border': status === 1 }"
            @click="handleClickStatus(1)"
          >
            Completed
          </button>
        </div>
      </div>
    </div>
    <div class="container-fluid pt-3 pt-md-4">
      <!-- <form action="" class="form-wallet-history row mb-2">
          <div class="col-6 col-md-6 col-lg-3">
            <div class="form-item mb-2">
              <label for="coin" class="form-label"> Coins </label>
              <select id="fiat" class="input secondary">
                <option selected>All Coins</option>
                <option value="EUR">EUR</option>
                <option value="EUR1">EUR1</option>
                <option value="EUR2">EUR2</option>
              </select>
            </div>
          </div>
          <div class="col-6 col-md-6 col-lg-3">
            <div class="form-item mb-2">
              <label for="type" class="form-label"> Order Type </label>
              <select id="type" class="input secondary">
                <option selected>Buy/Sell</option>
                <option value="EUR">EUR</option>
                <option value="EUR1">EUR1</option>
                <option value="EUR2">EUR2</option>
              </select>
            </div>
          </div>
          <div class="col-6 col-md-6 col-lg-3">
            <div class="form-item mb-2">
              <label for="status" class="form-label"> Status </label>
              <select id="status" class="input secondary">
                <option selected>All Status</option>
                <option value="COMPLETE">COMPLETE</option>
                <option value="PENDING">PENDING</option>
              </select>
            </div>
          </div>
          <div class="col-6 col-md-6 col-lg-3">
            <div class="form-item mb-2">
              <label for="date" class="form-label"> Date </label>
              <div class="input-group">
                <input type="date" class="input" />
              </div>
            </div>
          </div>
        </form> -->
      <div class="wrap-table d-none d-md-block">
        <table class="table" style="min-width: 700px">
          <thead>
            <tr>
              <th scope="col">Time</th>
              <th scope="col">Order Number</th>
              <th scope="col">Order Type</th>
              <th scope="col">Ads Type</th>
              <th scope="col">Fiat Amount</th>
              <th scope="col">Price</th>
              <th scope="col">Crypto Amount</th>
              <th scope="col">Status</th>
              <th scope="col "></th>
              <th scope="col "></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td>
                <div class="d-flex flex-column">
                  <div>{{ order.created_at }}</div>
                </div>
              </td>
              <td>
                <a class="message" :href="order.url.get_order">{{
                  order.code
                }}</a>
              </td>
              <td>
                <div
                  v-bind:class="{
                    'price-up': order.type == 'BUY',
                    'price-down': order.type == 'SELL',
                  }"
                >
                  {{ order.type }}
                </div>
              </td>
              <td>
                <div
                  v-bind:class="{
                    'price-up': order.type == 'SELL',
                    'price-down': order.type == 'BUY',
                  }"
                >
                  {{ order.type == "BUY" ? "SELL" : "BUY" }}
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="me-1">{{ order.total_fiat_amount }}</div>
                  <span class="fw-light fs-7">{{
                    order.fiat_currency.code
                  }}</span>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="me-1">
                    {{ order.fixed_price }}
                  </div>
                  <span class="fw-light fs-7">{{
                    order.fiat_currency.code
                  }}</span>
                </div>
              </td>
              <td>
                <div class="text-nowrap">
                  {{ order.total_asset_amount }} {{ order.asset_currency.code }}
                </div>
              </td>
              <td>
                <div
                  class="fw-light fs-7"
                  v-bind:class="{
                    'text-success': order.status == 1,
                    'text-info': order.status == 3,
                    'text-warning': order.status != 1,
                  }"
                >
                  {{ order.status_string }}
                </div>
              </td>

              <td>
                <img
                  width="18px"
                  height="18px"
                  :src="getPathImg('images/icons/message.png')"
                  alt=""
                />
                <!-- <span class="notify">3</span> -->
              </td>

              <td>
                <div class="d-flex align-items-center justify-content-end">
                  <img
                    width="8px"
                    height="12px"
                    :src="getPathImg('images/icons/right-outline.png')"
                    alt=""
                  />
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
      <div class="mobile-table-list d-block d-md-none mb-4">
        <div
          class="col-item border-bottom py-3"
          v-for="order in orders"
          :key="order.id"
        >
          <div class="d-flex justify-content-between mb-3">
            <div>Time:</div>
            <div class="d-flex flex-column">
              <div class="text-end fw-light">{{ order.created_at }}</div>
              <!-- <div>2023/06/06</div> -->
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Order Number:</div>
            <div class="d-flex align-items-center">
              <span class="fw-medium me-2"
                ><a class="message" :href="order.url.get_order">{{
                  order.code
                }}</a></span
              >
              <img
                class="pointer"
                width="24px"
                height="24px"
                :src="getPathImg('images/icons/copy.png')"
                alt=""
              />
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Type:</div>
            <div class="price-up">{{ order.type }}</div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Fiat Amount</div>
            <div class="d-flex align-items-center">
              <div class="me-1">{{ order.total_fiat_amount }}</div>
              <span class="fw-light fs-7">{{ order.fiat_currency.code }}</span>
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Price</div>
            <div class="fw-medium">
              {{ order.fixed_price }}{{ order.fiat_currency.code }}
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Crypto Amount</div>
            <div class="text-nowrap">
              {{ order.total_asset_amount }} {{ order.asset_currency.code }}
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Counterparty</div>
            <div class="fw-medium">
              <a :href="order.url.agent_url">{{
                order.ad.customer.full_name
              }}</a>
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Status</div>
            <div>
              <!-- <div class="fw-light fs-7">Pending Payment</div>
              <div class="d-flex align-items-center justify-content-end">
                <img
                  class="me-2"
                  width="16px"
                  height="16px"
                  :src="getPathImg('images/icons/clock.png')"
                  alt=""
                />
                14:40
              </div> -->
              <div
                class="fw-light fs-7"
                v-bind:class="{
                  'text-success': order.status == 1,
                  'text-info': order.status == 3,
                  'text-warning': order.status != 1,
                }"
              >
                {{ order.status_string }}
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <div>Actions</div>
            <div class="message">
              <a class="message" :href="order.url.get_order">
                <img
                  width="18px"
                  height="18px"
                  :src="getPathImg('images/icons/message.png')"
                  alt=""
                />
                <span class="notify">0</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";

export default {
  props: {
    customerid: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    if (window.innerWidth <= 800) {
      this.isMobile = true;
    }
  },
  data() {
    return {
      status: "ALL",
      orders: [],
      isMobile: false,
    };
  },
  methods: {
    handleClickStatus(status) {
      this.status = status;
      this.getP2POrders(this.status);
    },
    getP2POrders() {
      let url = "/p2p/agent/get-list-order?status=" + this.status;
      console.log(url);
      Axios.get(url)
        .then((response) => {
          if (response.data.error === false) {
            this.orders = response.data.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getP2POrders();
  },
  filters: {
    format_date: function (value) {
      if (!value) return "";
      return moment(String(value)).format("hh:mm:ss");
    },
  },
};
</script>
  