<template>
  <div class="orderbook-bid">
    <div class="table-trade-info">
      <div class="table-head">
        <div class="sort-item-wrap">
          <div class="sort-item-label-price price-up">19355.18</div>
        </div>
        <div class="sort-item-wrap">
          <div class="sort-item-label">$19,351.17</div>
        </div>
        <div class="sort-item-wrap d-flex justify-content-end">
          <div class="sort-item-label">More</div>
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
                <div class="item-symbol-text price-up">{{ item.price }}</div>
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
              class="progress-bar bid-bar"
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
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    pairsymbol: {
      default: null,
    },
    ordertype: {
      default: "bid",
    },
  },
  mixins: [GetPathImg],
  created() {
    // this.dataGeneral.currency_id = this.currency_id;
    // if (this.dataGeneral.currency_id != "") {
    //   this.changeCurrency(this.dataGeneral.currency_id);
    // }
    this.getOrderBidAsk(this.pairsymbol, this.ordertype);
  },
  data() {
    return {
      // dataGeneral: {
      //   currency_id: "",
      //   blockchain_id: "",
      // },
      // address: "",
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