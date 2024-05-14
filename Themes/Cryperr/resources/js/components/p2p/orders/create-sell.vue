<template>
  <b-overlay :show="showLoading" rounded="sm">
    <div class="row g-2 g-md-4" v-if="ads != null">
      <div class="col-12 col-md-8">
        <div class="secondary-card">
          <div class="card-title fs-5 mb-4">
            Sell {{ asset_currency.code }} with {{ fiat_currency.code }} 
          </div>
          <div class="mb-4">
            <div class="d-flex flex-column flex-md-row">
              <div class="text-span wi-100 wi-md-40 mb-2 mb-md-3">
                Price:
                <span class="price-down"
                  >{{ ads.fixed_price }} {{ fiat_currency.code }}</span
                >
              </div>
              <div class="text-span wi-100 wi-md-60 mb-2 mb-md-3">
                Available:
                <span class="text"
                  >{{ ads.total_trade_amount - ads.total_filled }}
                  {{ asset_currency.code }}</span
                >
              </div>
            </div>
            <div class="d-flex flex-column flex-lg-row">
              <div class="text-span wi-100 wi-lg-40 mb-2 mb-md-3">
                Time Limit:
                <span class="text">{{ ads.payment_time_limit }} Minutes</span>
              </div>
            </div>
          </div>
          <div class="card-title fs-5 mb-3">Terms & Conditions</div>
          <p class="fw-light mb-3">
            {{ ads.term }}
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="secondary-card h-100">
          <div class="form d-flex flex-column justify-content-between h-100">
            <div>
              <div class="form-item">
                <label for="pay" class="form-label">I want to pay</label>
                <div class="input-group bg-light">
                  <input
                    type="number"
                    id="pay"
                    class="input"
                    v-model="order.pay"
                    placeholder="50.00 ~ 497.28"
                    @keyup="onChangePay"
                  />
                  <div class="input-suffix">
                    <div class="ms-2">
                      {{ asset_currency.code }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-item">
                <label for="pay" class="form-label">I want to receive</label>
                <div class="input-group bg-light">
                  <input
                    type="number"
                    id="receive"
                    class="input"
                    v-model="order.receive"
                    placeholder="50.00 ~ 497.28"
                    @keyup="onChangeReceive"
                  />
                  <div class="input-suffix">
                    <div class="ms-2">
                      {{ fiat_currency.code }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-item">
                <label class="form-label">Payment Method</label>
                <div class="box-buy" v-if="ads.type == 'BUY'">
                  <div
                    class="d-flex justify-content-between bg-light p-3 pointer rounded"
                    v-for="(item, index) in paymentMethodAds"
                    :key="index"
                  >
                    <label> {{ item.title }} <input type="radio" v-model="order.payment_method_id" :value="item.id" name="payment_method_id" /> </label>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-center">
                <button class="btn btn-outline w-100 me-2">Cancel</button>
                <button
                  class="btn btn-danger w-100 ms-2"
                  @click="submitForm"
                >
                  SELL
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </b-overlay>
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
import Form from "form-backend-validation";

export default {
  props: {
    adsId: {
      default: null,
    },
  },
  data() {
    return {
      ads: null,
      fiat_currency: null,
      asset_currency: null,
      paymentMethodAds: null,
      showLoading:false,
      order: {
        receive: 0,
        pay: 0,
        adsId: this.adsId,
        payment_method_id:null
      },
      form: new Form(),
    };
  },
  created() {
    this.fetchAds();
    this.getPaymentMethodAvaliable();
  },
  methods: {
    getPaymentMethodAvaliable(){
      let url = "/p2p/get-payment-method-avaliable/" + this.adsId;
      Axios.get(url)
        .then((response) => {
          if (response.data.error === false) {
            this.paymentMethodAds = response.data.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchAds() {
      let url = "/p2p/agent/find-order-ads/" + this.adsId;
      Axios.get(url)
        .then((response) => {
          if (response.data.error === false) {
            this.ads = response.data.data.ads;
            this.fiat_currency = response.data.data.fiat_currency;
            this.asset_currency = response.data.data.asset_currency;
            this.asset_currency = response.data.data.asset_currency;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onChangePay(e) {
      const value = e.target.value;
      this.order.pay = +value;
      const price = this.ads.fixed_price;
      this.order.receive = this.order.pay * price;
    },
    onChangeReceive(e) {
      const value = e.target.value;
      this.order.receive = +value;
      const price = this.ads.fixed_price;
      this.order.pay = this.order.receive / price;
    },
    submitForm() {
      this.showLoading=true;
      const url = "/p2p/createOrder";
      this.form = new Form(this.order);
      this.form
        .post(url)
        .then((response) => {
          this.showLoading=false;
          if (response.error == true) {
            this.$bvToast.toast(response.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
            setTimeout(() => {
              window.location.href = response.data.url;
            }, 500);
          }
        })
        .catch((error) => {
          this.showLoading=false;
          console.log(error);
        });
    },
  },
};
</script>
