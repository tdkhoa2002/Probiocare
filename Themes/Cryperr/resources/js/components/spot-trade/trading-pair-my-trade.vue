<template>
  <div class="trading-pair-orderHis">
    <div class="tab-orderform">
      <ul class="tabs-list nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active pointer"
            aria-current="page"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#openOrder"
            >Open Orders ({{ openOrders.length }})</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link pointer"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#openHistory"
            >Order History ({{ closeOrders.length }})</a
          >
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <div class="tab-pane active" id="openOrder" role="tabpanel" tabindex="0">
        <div v-if="openOrders.length > 0" class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="text-span" style="min-width: 140px">Date</th>
                <th class="text-span">Pair</th>
                <th class="text-span">Price</th>
                <th class="text-span">Side</th>
                <th class="text-span">Amount</th>
                <th class="text-span">Filled</th>
                <th class="text-span">Total</th>
                <th>
                  <div class="d-flex align-items-center justify-content-end">
                    <span class="text-primary me-2">Cancel All</span>
                    <img
                      class="opacity-50"
                      width="10px"
                      height="6px"
                      :src="getPathImg('images/down-outline.png')"
                      alt=""
                    />
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr :key="key" v-for="(item, key) in openOrders">
                <td>{{ item.created_at | format_date }}</td>
                <td>{{ pairsymbol }}</td>
                <td>{{ item.price_was }}</td>
                <td class="price-up" v-if="item.trade_type == 'BUY'">
                  {{ item.trade_type }}
                </td>
                <td class="price-down" v-if="item.trade_type == 'SELL'">
                  {{ item.trade_type }}
                </td>
                <td>{{ item.amount }}</td>
                <td>{{ item.fill }}</td>
                <td>{{ item.price_was * item.fill }}</td>
                <td>
                  <div
                    class="text-end text-warning"
                    @click="cancelTrade(item.id)"
                  >
                    Cancel
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="openOrders.length == 0">
          <div
            class="d-flex flex-column justify-content-center align-items-center"
            style="min-height: 150px"
          >
            <img
              width="36px"
              height="40px"
              :src="getPathImg('images/empty.png')"
              alt=""
            />
            <p class="text-span mt-3">You have no open order.</p>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="openHistory" role="tabpanel" tabindex="1">
        <div v-if="closeOrders.length > 0" class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="text-span" style="min-width: 140px">Date</th>
                <th class="text-span">Pair</th>
                <th class="text-span">Price</th>
                <th class="text-span">Side</th>
                <th class="text-span">Amount</th>
                <th class="text-span">Filled</th>
                <th class="text-span">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr :key="key" v-for="(item, key) in closeOrders">
                <td>{{ item.created_at | format_date }}</td>
                <td>{{ pairsymbol }}</td>
                <td>{{ item.price_was }}</td>
                <td class="price-up" v-if="item.trade_type == 'BUY'">
                  {{ item.trade_type }}
                </td>
                <td class="price-down" v-if="item.trade_type == 'SELL'">
                  {{ item.trade_type }}
                </td>
                <td>{{ item.amount }}</td>
                <td>{{ item.fill }}</td>
                <td>{{ item.price_was * item.fill }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="closeOrders.length == 0">
          <div
            class="d-flex flex-column justify-content-center align-items-center"
            style="min-height: 150px"
          >
            <img
              width="36px"
              height="40px"
              :src="getPathImg('images/empty.png')"
              alt=""
            />
            <p class="text-span mt-3">You have no open order.</p>
          </div>
        </div>
      </div>
    </div>
    <b-modal
      v-model="modalShowCancelTrade"
      title="Cancel Trade"
      hide-footer
      :hide-header-close="true"
    >
      <div class="d-block text-center">
        <p>Do you want cancel this trade?</p>
      </div>
      <div class="d-block text-center">
        <b-button
          class="mt-3"
          variant="outline-danger"
          block
          @click="closeModal()"
          >Cancel</b-button
        >
        <b-button
          class="mt-3"
          variant="outline-warning"
          block
          @click="handleCancelTrade()"
          >Confirm Cancel!</b-button
        >
      </div>
    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";
import EventBus from "../../EventBus";
export default {
  props: {
    pairsymbol: {
      default: null,
    },
    dataTradeSocket: {
      default: null,
    },
    customerid: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getMyOrders();
    EventBus.$on("LOAD_MY_TRADE", this.getMyOrders);
  },
  destroyed() {
    EventBus.$off("LOAD_MY_TRADE", this.getMyOrders);
  },
  data() {
    return {
      modalShowCancelTrade: false,
      cancelTradeId: 0,
      openOrders: [],
      closeOrders: [],
    };
  },
  methods: {
    getMyOrders() {
      Axios.get("/api/trade/my-trades/symbol/" + this.pairsymbol)
        .then((response) => {
          if (response.data.error === false) {
            var orders = response.data.data;
            this.openOrders = _.filter(orders, function (o) {
              return o.status == 0;
            });
            this.closeOrders = _.filter(orders, function (o) {
              return o.status != 0;
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    cancelTrade(tradeId) {
      this.cancelTradeId = tradeId;
      this.modalShowCancelTrade = true;
    },
    handleCancelTrade() {
      if (this.cancelTradeId === 0) {
        this.modalShowCancelTrade = false;
        return false;
      }
      Axios.post("/api/trade/cancelTrade/" + this.cancelTradeId)
        .then((response) => {
          if (response.data.error === false) {
            this.$bvToast.toast(response.data.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          }
          this.getMyOrders();
          this.closeModal();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    closeModal() {
      this.cancelTradeId = 0;
      this.modalShowCancelTrade = false;
    },
  },
  watch: {
    dataTradeSocket: function (newVal) {
      const tradeId = newVal.trade_id;
      const find = _.find(this.openOrders, { id: tradeId });
      if (find) {
        this.getMyOrders();
      }
    },
  },
  filters: {
    format_date: function (value) {
      if (!value) return "";
      return moment(String(value)).format("YY-MM-DD hh:mm:ss");
    },
  },
};
</script>
