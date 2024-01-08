<template>
  <div>
    <b-overlay :show="showOverlay" rounded="sm">
      <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-8">
          <div class="tab-ads tabs">
            <ul class="tab-list nav nav-tabs" id="order-tab" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link"
                  :class="classSell"
                  type="button"
                  @click="changeType('SELL')"
                >
                  I want to sell
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  :class="classBuy"
                  type="button"
                  @click="changeType('BUY')"
                >
                  I want to buy
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div
                class="buy-form tab-pane active"
                id="buy"
                role="tabpanel"
                tabindex="3"
              >
                <form action="" class="row gx-3 gx-md-4">
                  <div class="col-12">
                    <div class="d-flex align-items-center">
                      <div class="form-item" :class="orderFiat">
                        <label for="" class="form-label">Fiat</label>
                        <div class="input-group bg-light has-validation">
                          <select
                            v-model="ads.fiat_currency_id"
                            @change="changeFiatCurrency"
                          >
                            <option
                              :value="item.id"
                              v-for="(item, index) in fiatCurrencies"
                              :key="index"
                            >
                              {{ item.title }}
                            </option>
                          </select>
                          <img
                            class="arrow-down"
                            :src="getPathImg('images/icons/down-outline.png')"
                            alt=""
                          />
                        </div>
                        <div
                          v-if="form.errors.has('fiat_currency_id')"
                          class="form-text error-ab"
                          v-text="form.errors.first('fiat_currency_id')"
                        ></div>
                      </div>
                      <div class="mx-2 order-2">
                        <img
                          width="14px"
                          :src="
                            getPathImg('images/icons/arrow-right-outline.png')
                          "
                          alt=""
                        />
                      </div>
                      <div class="form-item" :class="orderAsset">
                        <label for="" class="form-label">Asset</label>
                        <div class="input-group bg-light">
                          <select
                            v-model="ads.asset_currency_id"
                            @change="changeAssetCurrency"
                          >
                            <option
                              :value="item.id"
                              v-for="(item, index) in assetCurrencies"
                              :key="index"
                            >
                              {{ item.title }}
                            </option>
                          </select>
                          <img
                            class="arrow-down"
                            :src="getPathImg('images/icons/down-outline.png')"
                            alt=""
                          />
                        </div>
                        <div
                          v-if="form.errors.has('asset_currency_id')"
                          class="form-text error-ab"
                          v-text="form.errors.first('asset_currency_id')"
                        ></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="price-type form-item mb-3">
                      <label for="" class="form-label">Price Type</label>
                      <div class="form-check form-check-inline mb-2">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="inlineRadioOptions"
                          id="inlineRadio1"
                          value="option1"
                          checked
                        />
                        <label class="form-check-label" for="inlineRadio1"
                          >Fixed</label
                        >
                      </div>
                      <div class="up-down-input">
                        <div class="sub" @click="decreasePrice()">-</div>
                        <input type="text" v-model="ads.fixed_price" />
                        <div class="plus" @click="increasePrice()">+</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex mb-3">
                      <div class="d-flex flex-column me-5">
                        <div class="">Your Price</div>
                        <div class="fs-5">
                          {{ ads.fixed_price }}
                          <span v-if="fiatCurrency != null">
                            {{ fiatCurrency.title }}
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <div class="">Highest Order Price</div>
                        <div class="fs-5">100 <span v-if="fiatCurrency != null">
                            {{ fiatCurrency.title }}
                          </span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label">
                        Total Trading Amount
                      </label>
                      <div class="input-group bg-light">
                        <input
                          type="text"
                          class="input"
                          placeholder="1000"
                          v-model="ads.total_trade_amount"
                        />
                        <div class="ps-2" v-if="assetCurrency != null">
                          {{ assetCurrency.title }}
                        </div>
                      </div>
                      <div
                        v-if="form.errors.has('total_trade_amount')"
                        class="form-text error-ab"
                        v-text="form.errors.first('total_trade_amount')"
                      ></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-center">
                      <div class="form-item">
                        <label for="" class="form-label">Order Limit</label>
                        <div class="d-flex align-items-center">
                          <div class="input-group bg-light">
                            <input
                              type="text"
                              class="input"
                              placeholder="1000"
                              v-model="ads.order_limit_min"
                            />
                            <div class="ps-2" v-if="assetCurrency != null">
                              {{ assetCurrency.title }}
                            </div>
                          </div>
                          <div class="mx-2 fw-medium fs-5">~</div>
                          <div class="input-group bg-light">
                            <input
                              type="text"
                              class="input"
                              v-model="ads.order_limit_max"
                              placeholder="1000"
                            />
                            <div class="ps-2" v-if="assetCurrency != null">
                              {{ assetCurrency.title }}
                            </div>
                          </div>
                        </div>
                        <div class="invalid-feedback">Error</div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label">Payment Method</label>
                      <p class="text-span fw-light mb-2">
                        Select up to {{ limitPaymentMethod }} method
                      </p>
                      <div class="d-flex">
                        <div
                          class="tag me-3"
                          v-for="(item, index) in selectedPaymentMethods"
                          :key="index"
                        >
                          <div class="left-border">{{ item.title }}</div>
                          <img
                            class="ms-2"
                            width="13px"
                            height="13px"
                            :src="getPathImg('images/icons/close-outline.png')"
                            @click="removePayment(item.id)"
                          />
                        </div>
                        <div
                          class="tag bg-primary pointer"
                          @click="openAddPayment"
                        >
                          <div class="fs-4 me-2">+</div>
                          Add
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label">
                        Payment Time Limit
                      </label>
                      <select
                        name=""
                        id=""
                        class="input bg-light"
                        style="max-width: 190px"
                        v-model="ads.payment_time_limit"
                      >
                        <option
                          :value="payment_time_limit"
                          v-for="payment_time_limit in payment_time_limits"
                          :key="payment_time_limit"
                        >
                          {{ payment_time_limit }} Minutes
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label">Terms (Optional)</label>
                      <textarea
                        class="input"
                        name=""
                        id=""
                        cols="30"
                        rows="10"
                        placeholder="Do not include crypto related words like BTC, USDT, ETH etc"
                        style="height: 112px"
                        v-model="ads.term"
                      ></textarea>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label"
                        >Auto Reply (Optional)</label
                      >
                      <textarea
                        class="input"
                        name=""
                        id=""
                        cols="30"
                        rows="10"
                        placeholder="This is an auto reply message"
                        style="height: 112px"
                        v-model="ads.auto_reply"
                      ></textarea>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label"
                        >Counterparty Conditions</label
                      >
                      <div class="form-check">
                        <input
                          type="checkbox"
                          id="flexCheckKyc"
                          class="form-check-input"
                          :true-value="true"
                          :false-value="false"
                          v-model="ads.require_kyc"
                        />
                        <label class="fw-light" for="flexCheckKyc"
                          >KYC completed</label
                        >
                      </div>
                      <div class="form-check mb-2">
                        <input
                          type="checkbox"
                          id="flexCheckRegisterDay"
                          class="form-check-input"
                          :true-value="true"
                          :false-value="false"
                          v-model="ads.require_registered"
                        />
                        <label class="fw-light" for="flexCheckRegisterDay"
                          >Registered days</label
                        >
                      </div>
                      <input
                        class="input text-center mb-2"
                        type="text"
                        style="height: 40px; max-width: 310px"
                        v-model="ads.require_registered_day"
                      />
                      <div class="form-check mb-2">
                        <input
                          type="checkbox"
                          id="flexCheckHolding"
                          class="form-check-input"
                          :true-value="true"
                          :false-value="false"
                          v-model="ads.require_holding"
                        />
                        <label class="fw-light" for="flexCheckHolding"
                          >Hoding more than <span v-if="assetCurrency != null">
                            {{ assetCurrency.title }}
                          </span></label
                        >
                      </div>
                      <input
                        class="input text-center mb-2"
                        type="text"
                        style="height: 40px; max-width: 310px"
                        v-model="ads.require_holding_amount"
                      />
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-item">
                      <label for="" class="form-label">Status</label>
                      <div class="d-flex">
                        <div class="form-check me-4">
                          <input
                            type="radio"
                            :value="true"
                            v-model="ads.status"
                            id="flexStatusOnline"
                            class="form-check-input"
                          />
                          <label for="flexStatusOnline" class="fw-light"
                            >Online</label
                          >
                        </div>
                        <div class="form-check">
                          <input
                            type="radio"
                            :value="false"
                            v-model="ads.status"
                            id="flexStatusOffline"
                            class="form-check-input"
                          />
                          <label for="flexStatusOffline" class="fw-light"
                            >Offline</label
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="secondary-card">
            <div class="card-title fw-medium fs-5 mb-4">Summary</div>
            <div class="mb-2">Type & Price</div>

            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Asset:</div>
              <div class="fw-light" v-if="assetCurrency != null">
                {{ assetCurrency.title }}
              </div>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Fiat:</div>
              <div class="fw-light" v-if="fiatCurrency != null">
                {{ fiatCurrency.title }}
              </div>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Price:</div>
              <div class="fw-light">$100</div>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Fixed:</div>
              <div class="fw-medium fs-4">$100</div>
            </div>

            <div class="border-bottom my-2"></div>

            <div class="mb-2">Total Amount & Payment Method</div>
            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Amount:</div>
              <div class="fw-light" v-if="assetCurrency != null">
                {{ ads.total_trade_amount }} {{ assetCurrency.title }}
              </div>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <div class="fw-light">Limit:</div>
              <div class="fw-light" v-if="assetCurrency != null">
                {{ ads.order_limit_min }}{{ assetCurrency.title }} ~
                {{ ads.order_limit_max }}{{ assetCurrency.title }}
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <div class="fw-light">Payment method:</div>
              <div class="d-flex flex-column">
                <div
                  class="text-end right-border"
                  v-for="(item, index) in selectedPaymentMethods"
                  :key="index"
                >
                  {{ item.title }}
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <div class="fw-light">Payment Time Limit:</div>
              <div class="fw-light">{{ ads.payment_time_limit }} minutes</div>
            </div>

            <div class="border-bottom my-2"></div>

            <div class="mb-2">Terms & Automatic Response</div>
            <div class="d-flex flex-nowrap mb-1">
              <div class="fw-light mb-2" style="width: 34%">Terms:</div>
              <div class="fw-light" style="width: 66%">
                {{ ads.term }}
              </div>
            </div>

            <div class="d-flex flex-nowrap mb-1">
              <div class="fw-light mb-2" style="width: 34%">Auto Reply:</div>
              <div class="fw-light" style="width: 66%">
                {{ ads.auto_reply }}
              </div>
            </div>

            <div class="d-flex flex-nowrap mb-1">
              <div class="fw-light mb-2" style="width: 34%">Counterparty:</div>
              <div class="fw-light" style="width: 66%" v-if="ads.require_kyc">
                KYC completed
              </div>
            </div>

            <div class="d-flex flex-nowrap mb-1">
              <div class="fw-light mb-2" style="width: 34%">Conditions:</div>
              <div class="" style="width: 66%">
                <div class="fw-light" v-if="ads.require_registered">
                  Registered {{ ads.require_registered_day }} day(s) ago
                </div>
                <div class="fw-light" v-if="ads.require_holding">
                  Holding more than {{ ads.require_holding_amount }}
                </div>
              </div>
            </div>

            <div class="border-bottom mb-4 mt-3"></div>

            <div class="d-flex justify-content-center">
              <button class="btn btn-primary" @click="submitForm">
                Confirm
              </button>
            </div>
          </div>
        </div>

        <b-modal v-model="showModalPayment" centered hide-footer hide-header>
          <div class="payment-list">
            <div
              class="item"
              v-for="(item, index) in myPaymentMethods"
              :key="index"
            >
              <div class="d-flex align-items-center mb-2">
                <img
                  class="me-2"
                  width="24px"
                  height="24px"
                  :src="item.paymentMethod.logo"
                  alt=""
                />
                <span class="fw-medium">{{ item.paymentMethod.title }}</span>
              </div>
              <div class="mobile-table-list d-block mb-4">
                <div class="mobile-item border-bottom py-3">
                  <div
                    class="d-flex justify-content-between mb-3"
                    v-for="(attr, i) in item.paymentMethod.attrs"
                    :key="i"
                  >
                    <div>{{ attr.title }}:</div>
                    <div>
                      {{
                        getValueInArray(item.paymentMethodCustomerAttr, attr.id)
                      }}
                    </div>
                  </div>
                  <div class="text-center mt-3">
                    <a
                      class="text-span pointer"
                      @click="addPaymentMethod(item.id)"
                    >
                      Choose
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
            </div>
          </div>
        </b-modal>
      </div>
    </b-overlay>
  </div>
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
import Form from "form-backend-validation";

export default {
  props: {
    paymentMethodId: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getCurrencies();
    this.getFiatCurrencies();
    this.fetchListMyPaymentMethod();
  },
  data() {
    return {
      paymentMethod: null,
      showOverlay: false,
      showModalPayment: false,
      ads: {
        fiat_currency_id: "",
        asset_currency_id: "",
        fixed_price: 0,
        total_trade_amount: 0,
        order_limit_min: 0,
        order_limit_max: 0,
        payment_time_limit: 15,
        type: "SELL",
        term: "",
        auto_reply: "",
        status: true,
        paymentMethod: [],
        require_kyc: false,
        require_registered: false,
        require_registered_day: 0,
        require_holding: false,
        require_holding_amount: 0,
      },
      classBuy: "",
      classSell: "active",
      orderFiat: "order-3",
      orderAsset: "order-1",
      form: new Form(),
      selectedPaymentMethods: [],
      myPaymentMethods: [],
      assetCurrencies: [],
      assetCurrency: null,
      fiatCurrencies: [],
      fiatCurrency: null,
      limitPaymentMethod: 3,
      payment_time_limits: [15, 30, 45],
    };
  },
  methods: {
    changeType(type) {
      this.ads.type = type;
      if (type == "SELL") {
        this.classBuy = "";
        this.classSell = "active";
        this.orderFiat = "order-3";
        this.orderAsset = "order-1";
      } else {
        this.classBuy = "active";
        this.classSell = "";
        this.orderFiat = "order-1";
        this.orderAsset = "order-3";
      }
    },
    getCurrencies() {
      Axios.get("/api/public/wallet/currencies/")
        .then((response) => {
          if (response.data.error === false) {
            this.assetCurrencies = response.data.data.currencies;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getFiatCurrencies() {
      Axios.get("/api/public/wallet/fiat-currencies/")
        .then((response) => {
          if (response.data.error === false) {
            this.fiatCurrencies = response.data.data.currencies;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeFiatCurrency(event) {
      const value = event.target.value;
      this.fiatCurrency = _.find(this.fiatCurrencies, { id: +value });
    },
    changeAssetCurrency(event) {
      const value = event.target.value;
      this.assetCurrency = _.find(this.assetCurrencies, { id: +value });
    },
    fetchListMyPaymentMethod() {
      let url = "/api/customer/list-my-payment-method";
      Axios.get(url)
        .then((response) => {
          this.myPaymentMethods = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    increasePrice() {
      this.ads.fixed_price = this.ads.fixed_price + 1;
    },
    decreasePrice() {
      const newPrice = this.ads.fixed_price - 1;
      if (newPrice > 0) {
        this.ads.fixed_price = newPrice;
      }
    },
    openAddPayment() {
      this.showModalPayment = true;
    },
    getValueInArray(dataArr, id) {
      const data = _.find(dataArr, { payment_attr_id: id });
      if (data) {
        return data.value;
      } else {
        return "";
      }
    },
    addPaymentMethod(payment_customer_id) {
      if (
        !this.ads.paymentMethod.includes(+payment_customer_id) &&
        this.limitPaymentMethod > this.ads.paymentMethod.length
      ) {
        this.ads.paymentMethod.push(+payment_customer_id);
        const payment = _.find(this.myPaymentMethods, {
          id: +payment_customer_id,
        });
        this.selectedPaymentMethods.push({
          id: +payment_customer_id,
          title: payment.paymentMethod.title,
        });
      }
      this.showModalPayment = false;
    },
    removePayment(id) {
      const index = this.ads.paymentMethod.indexOf(+id);
      if (index > -1) {
        this.ads.paymentMethod.splice(index, 1);
      }
      const i = _.findIndex(this.selectedPaymentMethods, {
        id: +id,
      });
      this.selectedPaymentMethods.splice(i, 1);
    },
    submitForm() {
      this.showOverlay = true;
      this.form = new Form(this.ads);
      let url = "/p2p/agent/createAds";
      this.form
        .post(url)
        .then((response) => {
          this.showOverlay = false;
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
          this.showOverlay = false;
          console.log(error);
        });
    },
  },
};
</script>
