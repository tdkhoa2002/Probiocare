<template>
  <div class="swap-box p-2">
    <div class="swap-from" ref="formContainer">
      <div class="swap-title">
        <p>From</p>
      </div>
      <div class="swap-input">
        <div class="d-flex flex-column w-100">
          <span class="swap-input_desc">Send:</span>
          <input
            type="number"
            placeholder="0.12334"
            v-model="dataExchange.amount_from"
            :min="dataFrom.min"
            :max="dataFrom.max"
            @change="calExchangePrice('from')"
          />
        </div>
        <div class="swap-select1" @click="openModalFrom()">
          <div class="d-flex align-items-center">
            <img
              class="me-2"
              width="18px"
              height="18px"
              v-bind:src="dataFrom.logo"
              alt="deco"
            />
            <span class="coin-name">{{ dataFrom.code }}</span>
            <img
              class="ms-2"
              width="12px"
              height="8px"
              v-bind:src="getPathImg('images/down-outline.png')"
              alt="deco"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="swap-icon" @click="transferCurrency()">
      <img
        v-bind:src="getPathImg('images/icons/arrow-up-down-outline.svg')"
        alt=""
      />
    </div>
    <div class="swap-to">
      <div class="swap-title">
        <p>To</p>
      </div>
      <div class="swap-input">
        <div class="d-flex flex-column w-100">
          <span class="swap-input_desc">Receive:</span>
          <input
            type="number"
            placeholder="0.12334"
            v-model="dataExchange.amount_to"
            readonly
          />
        </div>
        <div class="swap-select1" @click="openModalTo()">
          <div class="d-flex align-items-center">
            <img
              class="me-2"
              width="18px"
              height="18px"
              v-bind:src="dataTo.logo"
              alt="deco"
            />
            <span class="coin-name">{{ dataTo.code }}</span>
            <img
              class="ms-2"
              width="12px"
              height="8px"
              v-bind:src="getPathImg('images/down-outline.png')"
              alt="deco"
            />
          </div>
        </div>
      </div>

      <div class="swap-input swap-address">
        <div class="d-flex flex-column w-100">
          <span class="swap-input_desc">Receiving Wallet Address:</span>
          <input
            type="text"
            placeholder="Your receiving address"
            v-model="dataExchange.toAddress"
          />
        </div>
      </div>
    </div>
    <div class="swap-btn">
      <input type="button" value="SWAP NOW" @click="submitSwap()" />
    </div>

    <b-modal
      hide-footer
      hide-header
      v-model="modalCurrencyFrom"
      @hidden="resetModalData"
    >
      <div class="select-wrapper token-wrapper">
        <div class="wrap-content">
          <div class="select-box">
            <p class="select-title">Select Chain</p>

            <div class="select-input">
              <img
                class="me-2"
                width="20px"
                height="20px"
                v-bind:src="getPathImg('images/search.png')"
                alt=""
              />
              <input
                type="text"
                placeholder="Search by name or chain ID"
                @keyup="filterCurrency($event)"
              />
            </div>

            <div class="select-items">
              <div
                class="select-item"
                v-for="(item, key) in currencies"
                :key="key"
                @click="selectCurrency(item.id, 'from')"
              >
                <div class="select-img">
                  <img v-bind:src="item.logo" />
                </div>
                <div class="select-info">
                  <p class="select-name">{{ item.coin }}</p>
                  <p class="select-desc">{{ item.network }}</p>
                </div>
              </div>
            </div>
            <div class="select-btn" data-dismiss="modal">
              <p data-bs-dismiss="modal" aria-label="Close">close</p>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
    <b-modal
      hide-footer
      hide-header
      v-model="modalCurrencyTo"
      @hidden="resetModalData"
    >
      <div class="select-wrapper token-wrapper">
        <div class="wrap-content">
          <div class="select-box">
            <p class="select-title">Select Currencies</p>

            <div class="select-input">
              <img
                class="me-2"
                width="20px"
                height="20px"
                v-bind:src="getPathImg('images/search.png')"
                alt=""
              />
              <input
                type="text"
                placeholder="Search by name or chain ID"
                @keyup="filterCurrency($event)"
              />
            </div>

            <div class="select-items">
              <div
                class="select-item"
                v-for="(item, key) in currencies"
                :key="key"
                @click="selectCurrency(item.id, 'to')"
              >
                <div class="select-img">
                  <img v-bind:src="item.logo" />
                </div>
                <div class="select-info">
                  <p class="select-name">{{ item.coin }}</p>
                  <p class="select-desc">{{ item.network }}</p>
                </div>
              </div>
            </div>
            <div class="select-btn" data-dismiss="modal">
              <p data-bs-dismiss="modal" aria-label="Close">close</p>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>
  
  <script>
import _ from "lodash";
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  mixins: [GetPathImg],
  created() {
    this.getListcurrency();
  },
  data() {
    return {
      modalCurrencyFrom: false,
      modalCurrencyTo: false,
      dataExchange: {
        fromCcy: "ETH",
        toCcy: "BTC",
        amount_from: 10,
        amount_to: 0,
        direction: "from",
        type: "fixed",
        toAddress: "",
      },
      dataFrom: {
        code: "ETH",
        color: "#ffffff",
        logo: "https://fixedfloat.com/assets/images/coins/svg/eth.svg",
        min: 0.005,
        max: 45,
      },
      dataTo: {
        code: "BTC",
        color: "#f7931a",
        logo: "https://fixedfloat.com/assets/images/coins/svg/btc.svg",
        min: 0.0004,
        max: 2,
      },
      currencies: [],
      currenciesFull: [],
    };
  },
  methods: {
    transferCurrency() {
      const dataFrom = this.dataFrom;
      const dataTo = this.dataTo;
      const dataExchange = this.dataExchange;
      this.dataFrom = dataTo;
      this.dataTo = dataFrom;
      this.dataExchange = {
        fromCcy: dataExchange.toCcy,
        toCcy: dataExchange.fromCcy,
        amount_from: dataExchange.amount_to,
        amount_to: dataExchange.amount_from,
        direction: "from",
        type: "fixed",
        toAddress: dataExchange.toAddress,
      };
      this.calExchangePrice("from");
    },
    getListcurrency() {
      Axios.get("/cryperrswap/currency")
        .then((response) => {
          if (response.data.error === false) {
            this.currencies = response.data.data;
            this.currenciesFull = response.data.data;
            // this.calExchangePrice("from");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    selectCurrency(id, direction) {
      const currency = _.find(this.currencies, { id: id });
      if (currency) {
        if (direction == "from") {
          this.dataFrom = {
            code: currency.coin,
            color: currency.color,
            logo: currency.logo,
          };
          this.dataExchange.fromCcy = currency.code;
        } else {
          this.dataTo = {
            code: currency.coin,
            color: currency.color,
            logo: currency.logo,
          };
          this.dataExchange.toCcy = currency.code;
        }
        this.calExchangePrice(direction);
      }
      this.resetModalData();
    },
    filterCurrency(event) {
      const value = event.target.value;
      if (value != "") {
        this.currencies = _.filter(this.currencies, (o) =>
          o.coin.toLowerCase().includes(value.toLowerCase())
        );
      } else {
        this.currencies = this.currenciesFull;
      }
    },
    calExchangePrice(direction) {
      let amount = this.dataExchange.amount_from;
      if (direction == "to") {
        amount = this.dataExchange.amount_to;
      }
      if (amount < 0) {
        this.dataExchange.amount_from = 0;
        this.dataExchange.amount_to = 0;
        return false;
      }
      const data = {
        type: this.dataExchange.type,
        fromCcy: this.dataExchange.fromCcy,
        toCcy: this.dataExchange.toCcy,
        amount,
        direction: direction,
      };
      Axios.post("/cryperrswap/cal-exchange-price", data)
        .then((response) => {
          if (response.data.error === false) {
            this.dataExchange.amount_from =
              response.data.data.from.amount < 0
                ? 0
                : +response.data.data.from.amount;
            this.dataExchange.amount_to =
              response.data.data.to.amount < 0
                ? 0
                : +response.data.data.to.amount;
            this.dataFrom.min = +response.data.data.from.min;
            this.dataFrom.max = +response.data.data.from.max;
            this.dataTo.min = +response.data.data.to.min;
            this.dataTo.max = +response.data.data.to.max;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    openModalFrom() {
      this.modalCurrencyFrom = true;
      this.currencies = _.filter(this.currenciesFull, { recv: 1 });
    },
    openModalTo() {
      this.modalCurrencyTo = true;
      this.currencies = _.filter(this.currenciesFull, { send: 1 });
    },
    resetModalData() {
      this.currencies = this.currenciesFull;
      this.modalCurrencyFrom = false;
      this.modalCurrencyTo = false;
    },
    submitSwap() {
      console.log(this.dataExchange);
      if (
        this.dataExchange.amount_from == 0 ||
        this.dataExchange.amount_to == 0 ||
        this.dataExchange.fromCcy == "" ||
        this.dataExchange.toCcy == ""
      ) {
        this.$bvToast.toast("Please enter full data.", {
          variant: "danger",
          solid: true,
          noCloseButton: true,
        });
      }
      if (this.dataExchange.toAddress == "") {
        this.$bvToast.toast("Please enter receiving wallet address.", {
          variant: "danger",
          solid: true,
          noCloseButton: true,
        });
      }

      const dataCreate = {
        fromCcy: this.dataExchange.fromCcy,
        toCcy: this.dataExchange.toCcy,
        amount: this.dataExchange.amount_from,
        type: this.dataExchange.type,
        toAddress: this.dataExchange.toAddress,
      };
      Axios.post("/cryperrswap/exchange", dataCreate)
        .then((response) => {
          if (response.data.error == true) {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          } else {
            window.location.href = response.data.data.url;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>