<template>
  <div class="trading-pair-orderform">
    <!-- <div class="tab-orderform">
      <ul class="tabs-list nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Spot</a>
        </li>
      </ul>
      <div class="tabs-right">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
          <path
            d="M10.5 20v-3h3v3h-3zM10.5 7V4h3v3h-3zM10.5 10.5v3h3v-3h-3z"
            fill="#76808F"
          ></path>
        </svg>
      </div>
    </div> -->
    <div class="tab-content-1">
      <div class="orderform">
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label for="price" class="form-label"
                ><span class="text-span">Avbl</span> - {{ balances.quote }}
                {{ dataPairInfo?.quote?.symbol }}</label
              >
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Price</span>
                </div>
                <input
                  type="number"
                  @keyup="changeDataModel('BUY', 'PRICE')"
                  class="input fw-light text-end"
                  v-model="dataBuy.price"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.quote?.symbol }}</span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Amount</span>
                </div>
                <input
                  class="input fw-light text-end"
                  v-model="dataBuy.amount"
                  @keyup="changeDataModel('BUY', 'AMOUNT')"
                  type="number"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.base?.symbol }}</span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <!-- <div class="bn-slider-container">
                <div class="bn-slider-available-bar">
                  <div class="bn-slider-progress-bar"></div>
                </div>
                <div class="bn-slider-disabled-bar"></div>
                <div class="bn-slider-radio-button"></div>
                 <div
                  class="bn-slider-stepper bn-slider-progress-stepper"
                  style="margin: 0 0 0 25%"
                ></div> 
                <div class="bn-slider-stepper" style="margin: 0 0 0 0%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 25%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 50%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 75%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 100%"></div>
                <div
                  class="bn-slider-stepper bn-slider-split-stepper"
                  style="margin: 0 0 0 100%"
                ></div>
              </div> -->
            </div>
            <div class="mb-3">
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Total</span>
                </div>
                <input
                  class="input fw-light text-end"
                  type="number"
                  @keyup="changeDataModel('BUY', 'TOTAL')"
                  v-model="dataBuy.total"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.quote?.symbol }}</span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="btn btn-outline w-100" v-if="!checkAuth">
                <a class="text-primary" v-bind:href="linkLogin">Sign In</a> or
                <a class="text-primary" v-bind:href="linkRegister">Sign Up</a>
              </div>
              <button
                class="btn btn-green w-100"
                v-if="checkAuth"
                @click="submitTrade('BUY')"
              >
                <span class="text-white"
                  >BUY {{ dataPairInfo?.base?.symbol }}</span
                >
              </button>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label for="price" class="form-label"
                ><span class="text-span">Avbl</span> - {{ balances.base }}
                {{ dataPairInfo?.base?.symbol }}</label
              >
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Price</span>
                </div>
                <input
                  type="number"
                  class="input fw-light text-end"
                  v-model="dataSell.price"
                  @keyup="changeDataModel('SELL', 'PRICE')"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.quote?.symbol }}</span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Amount</span>
                </div>
                <input
                  class="input fw-light text-end"
                  v-model="dataSell.amount"
                  @keyup="changeDataModel('SELL', 'AMOUNT')"
                  type="number"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.base?.symbol }}</span>
                </div>
              </div>
            </div>
            <!-- <div class="mb-3">
              <div class="bn-slider-container">
                <div class="bn-slider-available-bar">
                  <div class="bn-slider-progress-bar"></div>
                </div>
                <div class="bn-slider-disabled-bar"></div>
                <div class="bn-slider-radio-button"></div>
                 <div
                  class="bn-slider-stepper bn-slider-progress-stepper"
                  style="margin: 0 0 0 25%"
                ></div> 
                <div class="bn-slider-stepper" style="margin: 0 0 0 0%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 25%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 50%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 75%"></div>
                <div class="bn-slider-stepper" style="margin: 0 0 0 100%"></div>
                <div
                  class="bn-slider-stepper bn-slider-split-stepper"
                  style="margin: 0 0 0 100%"
                ></div>
              </div>
            </div> -->
            <div class="mb-3">
              <div class="input-group">
                <div class="input-prefix pe-2">
                  <span class="text-span fw-light">Total</span>
                </div>
                <input
                  class="input fw-light text-end"
                  type="number"
                  @keyup="changeDataModel('SELL', 'TOTAL')"
                  v-model="dataSell.total"
                />
                <div class="input-suffix ps-2">
                  <span class="">{{ dataPairInfo?.quote?.symbol }}</span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="btn btn-outline w-100" v-if="!checkAuth">
                <a class="text-primary" v-bind:href="linkLogin">Sign In</a> or
                <a class="text-primary" v-bind:href="linkRegister">Sign Up</a>
              </div>
              <button
                class="btn btn-danger w-100"
                v-if="checkAuth"
                @click="submitTrade('SELL')"
              >
                <span class="text-white"
                  >SELL {{ dataPairInfo?.base?.symbol }}</span
                >
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import EventBus from '../../EventBus'

export default {
  props: {
    pairsymbol: {
      default: null,
    },
    pairInfo: {
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
  },
  created() {
    this.dataPairInfo = this.pairInfo;
    if (this.pairsymbol != null) {
      this.getBalanceTrade(this.pairsymbol);
    }
  },
  data() {
    return {
      dataPairInfo: null,
      dataBuy: {
        price: "",
        amount: "",
        total: "",
      },
      dataSell: {
        price: "",
        amount: "",
        total: "",
      },
      balances: {
        base: 0,
        quote: 0,
      },
    };
  },
  methods: {
    getBalanceTrade(pairsymbol) {
      if (pairsymbol != "") {
        Axios.get("/api/trade/getBalanceTrade/" + pairsymbol)
          .then((response) => {
            if (response.data.error === false) {
              this.balances = response.data.data;
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.balances = {
          base: 0,
          quote: 0,
        };
      }
    },
    submitTrade(type) {
      let dataTrade = this.dataBuy;
      if (type == "SELL") {
        dataTrade = this.dataSell;
      }

      if (dataTrade.price == 0 || dataTrade.amount == 0) {
        this.$bvToast.toast("Please enter amount or price", {
          variant: "danger",
          solid: true,
          noCloseButton: true,
        });
        return false;
      }
      dataTrade.symbol = this.pairsymbol;
      dataTrade.type = type;
      Axios.post("/api/trade/handle", dataTrade)
        .then((response) => {
          if (response.data.error === false) {
            this.$bvToast.toast(response.data.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
            EventBus.$emit('LOAD_MY_TRADE');
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
            return false;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeDataModel(type, field) {
      if (type == "SELL") {
        if (field == "PRICE" || field == "AMOUNT") {
          const price = +this.dataSell.price;
          const amount = +this.dataSell.amount;
          this.dataSell.total = price * amount;
        }
        if (field == "TOTAL") {
          const price = +this.dataSell.price;
          const total = +this.dataSell.total;
          this.dataSell.amount = total / price;
        }
      } else {
        if (field == "PRICE" || field == "AMOUNT") {
          const price = +this.dataBuy.price;
          const amount = +this.dataBuy.amount;
          this.dataBuy.total = price * amount;
        }
        if (field == "TOTAL") {
          const price = +this.dataBuy.price;
          const total = +this.dataBuy.total;
          this.dataBuy.amount = total / price;
        }
      }
    },
  },
  watch: {
    pairInfo: function (newVal) {
      this.dataPairInfo = newVal;
    },
  },
};
</script>
