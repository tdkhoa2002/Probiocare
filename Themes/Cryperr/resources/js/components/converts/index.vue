<template>
  <div class="box-conent-convert">
    <div class="content-convert">
      <div class="header-box">
        <h3>Convert</h3>
        <span class="reload" @click="actionReloadCurrency()">
          <img
            width="18px"
            height="18px"
            :src="getPathImg('images/icons/icon-reload.png')"
            alt="deco"
            class="me-2"
          />
        </span>
      </div>

      <div class="body-box-swap">
        <div class="item-input">
          <div class="swap-title">
            <p class="label">From</p>
            <p class="balance">
              <span>Balance</span>: <strong>{{ fromBalance }}</strong>
            </p>
          </div>
          <div class="swap-input">
            <div class="box-currency" v-if="fromCurrency != null">
              <div
                class="d-flex align-items-center"
                @click="openModalChooseCurrencyfrom"
              >
                <img
                  width="18px"
                  height="18px"
                  :src="fromCurrency.icon"
                  alt="deco"
                  class="me-2"
                />
                <span class="coin-name">{{ fromCurrency.title }}</span>
                <img
                  width="12px"
                  height="8px"
                  :src="getPathImg('images/icons/icon-arrow-down.png')"
                  alt="deco"
                  class="ms-2"
                />
              </div>
            </div>
            <div class="box-input">
              <input
                type="text"
                placeholder="0.12334"
                min="0.005"
                max="20"
                v-model="dataSwap.from"
                @keypress="onlyNumber"
                @keyup="changeValueFrom"
              />
              <span class="swap-input_desc" v-if="fromCurrency != null"
                >≈ ${{ fromCurrency.price_usd * dataSwap.from }}</span
              >
            </div>
          </div>
          <div
            v-if="form.errors.has('from_currency_id')"
            class="form-text error"
            v-text="form.errors.first('from_currency_id')"
          ></div>
          <div
            v-if="form.errors.has('amount_from')"
            class="form-text error"
            v-text="form.errors.first('amount_from')"
          ></div>
        </div>
        <div class="box-quick-amount">
          <div class="quick-amount">
            <div class="item" @click="changeValueFromInput(25)">25%</div>
            <div class="item" @click="changeValueFromInput(50)">50%</div>
            <div class="item" @click="changeValueFromInput(75)">75%</div>
            <div class="item" @click="changeValueFromInput(100)">MAX</div>
          </div>
        </div>
        <div class="box-icon-change">
          <span>
            <img
              width="24px"
              height="24px"
              :src="getPathImg('images/icons/icon-change.png')"
              alt="deco"
              class="me-2"
            />
          </span>
        </div>
        <div class="item-input">
          <div class="swap-title">
            <p class="label">To</p>
            <p class="balance">
              <span>Balance</span>: <strong>{{ toBalance }}</strong>
            </p>
          </div>
          <div class="swap-input">
            <div class="box-currency" v-if="toCurrency != null">
              <div
                class="d-flex align-items-center"
                @click="openModalChooseCurrencyTo"
              >
                <img
                  width="18px"
                  height="18px"
                  :src="toCurrency.icon"
                  alt="deco"
                  class="me-2"
                />
                <span class="coin-name">{{ toCurrency.title }}</span>
                <img
                  width="12px"
                  height="8px"
                  :src="getPathImg('images/icons/icon-arrow-down.png')"
                  alt="deco"
                  class="ms-2"
                />
              </div>
            </div>
            <div class="box-input">
              <input
                type="text"
                placeholder="0.12334"
                v-model="dataSwap.to"
                @keypress="onlyNumber"
                @keyup="changeValueTo"
              />
              <span class="swap-input_desc" v-if="toCurrency != null"
                >≈ ${{ toCurrency.price_usd * dataSwap.to }}</span
              >
            </div>
          </div>
          <div
            v-if="form.errors.has('to_currency_id')"
            class="form-text error"
            v-text="form.errors.first('to_currency_id')"
          ></div>
        </div>
        <div class="box-action">
          <button @click="openModalConvertConfirm">Convert</button>
        </div>
        <div class="box-price">
          <div class="item">Price:</div>
          <div class="item">
            <span v-if="fromCurrency != null && toCurrency != null">
              {{ dataPrice.from }} {{ dataPrice.fromCode }} ≈ {{ dataPrice.to
              }}{{ dataPrice.toCode }}</span
            >
            <span class="icon-change" @click="switchDataPrice">
              <img
                width="15px"
                height="14px"
                :src="getPathImg('images/icons/icon-change-2.png')"
                alt="deco"
                class="me-2"
            /></span>
          </div>
        </div>
        <div class="box-price">
          <div class="item">Fee:</div>
          <div class="item">
            <span
              >{{ feeTrade }}
              <span v-if="fromCurrency != null">{{
                fromCurrency.code
              }}</span></span
            >
          </div>
        </div>
      </div>
    </div>
    <b-modal
      hide-footer
      v-model="modalConvertConfirm"
      title="Convert Confirmation"
    >
      <b-overlay :show="showLoading" rounded="sm">
        <div class="body-box-swap">
          <div class="item-input">
            <div class="swap-input">
              <div class="box-currency" v-if="fromCurrency != null">
                <div class="d-flex align-items-center">
                  <img
                    width="18px"
                    height="18px"
                    :src="fromCurrency.icon"
                    alt="deco"
                    class="me-2"
                  />
                  <span class="coin-name">{{ fromCurrency.title }}</span>
                  <img
                    width="12px"
                    height="8px"
                    :src="getPathImg('images/icons/icon-arrow-down.png')"
                    alt="deco"
                    class="ms-2"
                  />
                </div>
              </div>
              <div class="box-input">
                <input
                  type="text"
                  placeholder="0.12334"
                  min="0.005"
                  max="20"
                  v-model="dataSwap.from"
                  readonly
                />
                <span class="swap-input_desc" v-if="fromCurrency != null"
                  >≈ ${{ fromCurrency.price_usd * dataSwap.from }}</span
                >
              </div>
            </div>
          </div>
          <div class="box-icon-change">
            <span>
              <img
                width="12px"
                height="15px"
                :src="getPathImg('images/icons/icon-d-arrow-down.png')"
                alt="deco"
                class="me-2"
              />
            </span>
          </div>
          <div class="item-input">
            <div class="swap-input">
              <div class="box-currency" v-if="toCurrency != null">
                <div class="d-flex align-items-center">
                  <img
                    width="18px"
                    height="18px"
                    :src="toCurrency.icon"
                    alt="deco"
                    class="me-2"
                  />
                  <span class="coin-name">{{ toCurrency.title }}</span>
                  <img
                    width="12px"
                    height="8px"
                    :src="getPathImg('images/icons/icon-arrow-down.png')"
                    alt="deco"
                    class="ms-2"
                  />
                </div>
              </div>
              <div class="box-input">
                <input
                  type="text"
                  placeholder="0.12334"
                  min="0.005"
                  max="20"
                  v-model="dataSwap.to"
                  readonly
                />
                <span class="swap-input_desc" v-if="toCurrency != null"
                  >≈ ${{ toCurrency.price_usd * dataSwap.to }}</span
                >
              </div>
            </div>
          </div>
          <p class="sumary">
            You will receive {{ dataSwap.to }}
            <span v-if="toCurrency != null">{{ toCurrency.code }}</span> or the
            transaction will revert
          </p>
          <div class="box-price-modal">
            <div class="box-price">
              <div class="item">Price:</div>
              <div class="item">
                <span v-if="fromCurrency != null && toCurrency != null"
                  >1{{ fromCurrency.code }} ≈ {{ pricePair
                  }}{{ toCurrency.code }}</span
                >
                <span class="icon-change">
                  <img
                    width="15px"
                    height="14px"
                    :src="getPathImg('images/icons/icon-change-2.png')"
                    alt="deco"
                    class="me-2"
                /></span>
              </div>
            </div>
            <div class="box-price">
              <div class="item">Fee:</div>
              <div class="item">
                <span
                  >{{ feeTrade }}
                  <span v-if="fromCurrency != null">{{
                    fromCurrency.code
                  }}</span></span
                >
              </div>
            </div>
          </div>
        </div>
        <div class="d-block text-center">
          <b-button
            class="mt-3"
            variant="outline-danger"
            block
            @click="closeModal"
            >Cancel</b-button
          >
          <b-button
            class="mt-3"
            variant="outline-warning"
            block
            @click="submitForm()"
            >Confirm!</b-button
          >
        </div>
      </b-overlay>
    </b-modal>
    <b-modal hide-footer v-model="modalCurrencyFrom" title="Select Tokens">
      <div class="wrapper-select-token">
        <div class="wrap-content">
          <div class="select-box">
            <div class="select-input">
              <img
                class="me-2"
                width="20px"
                height="20px"
                v-bind:src="getPathImg('images/icons/search.png')"
                alt=""
              />
              <input
                type="text"
                placeholder="Search name token"
                @keyup="filterCurrencyFrom($event)"
              />
            </div>

            <div class="select-items">
              <div
                class="select-item"
                v-for="(item, key) in fromCurrencies"
                :key="key"
                @click="selectCurrency(item.id, 'from')"
              >
                <div class="select-img">
                  <img v-bind:src="item.icon" />
                </div>
                <div class="select-info">
                  <p class="select-name">{{ item.code }}</p>
                  <p class="select-desc">{{ item.title }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
    <b-modal hide-footer v-model="modalCurrencyTo" title="Select Tokens">
      <div class="wrapper-select-token">
        <div class="wrap-content">
          <div class="select-box">
            <div class="select-input">
              <img
                class="me-2"
                width="20px"
                height="20px"
                v-bind:src="getPathImg('images/icons/search.png')"
                alt=""
              />
              <input
                type="text"
                placeholder="Search name token"
                @keyup="filterCurrencyTo($event)"
              />
            </div>

            <div class="select-items">
              <div
                class="select-item"
                v-for="(item, key) in toCurrencies"
                :key="key"
                @click="selectCurrency(item.id, 'to')"
              >
                <div class="select-img">
                  <img v-bind:src="item.icon" />
                </div>
                <div class="select-info">
                  <p class="select-name">{{ item.code }}</p>
                  <p class="select-desc">{{ item.title }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../mixins/GetPathImg";
import Form from "form-backend-validation";

export default {
  mixins: [GetPathImg],
  data() {
    return {
      fromCurrencies: [],
      toCurrencies: [],
      fromStaticCurrencies: [],
      toStaticCurrencies: [],
      fromCurrency: null,
      pricePair: 0,
      feeTrade: 0,
      fromBalance: 0,
      toBalance: 0,
      toCurrency: null,
      modalCurrencyFrom: false,
      modalCurrencyTo: false,
      modalConvertConfirm: false,
      form: new Form(),
      dataSwap: {
        from: 0,
        to: 0,
      },
      dataPrice: {
        from: 1,
        fromCode: "",
        to: this.pricePair,
        toCode: "",
      },
      showLoading: false,
    };
  },
  created() {
    this.getCurrencies();
  },
  methods: {
    getCurrencies() {
      Axios.get("/api/public/wallet/swap-currencies")
        .then((response) => {
          if (response.data.error === false) {
            this.fromCurrencies = response.data.data.currencies;
            this.fromStaticCurrencies = response.data.data.currencies;
            this.fromCurrency = this.fromCurrencies[0];
            this.dataSwap.from = this.fromCurrency.min_swap;
            this.getBalance(this.fromCurrency.id).then((response) => {
              this.fromBalance = response.data.data.balance;
            });
            this.getCurrencySwapEnable(this.fromCurrency.id);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getBalance(currencyId) {
      let url = "/wallet/get-balance/" + currencyId;
      return await Axios.get(url);
    },
    selectCurrency(e, type) {
      if (type == "from") {
        this.changeFromCurrency(e);
      } else {
        this.changeToCurrency(e);
      }

      this.modalCurrencyFrom = false;
      this.modalCurrencyTo = false;
    },
    changeFromCurrency(e) {
      const currency = _.find(this.fromCurrencies, { id: +e });
      if (currency != undefined) {
        this.fromCurrency = currency;
        this.getBalance(+e).then((response) => {
          this.fromBalance = response.data.data.balance;
        });
        this.dataSwap.from = this.fromCurrency.min_swap;
        this.getCurrencySwapEnable(e);
        this.onChangeTrigger();
      }
    },
    onChangeTrigger() {
      this.changeFee();
      this.changePricePair();
      this.changeDataPrice();
    },
    changeDataPrice() {
      this.dataPrice = {
        from: 1,
        fromCode: this.fromCurrency.code,
        to: this.pricePair,
        toCode: this.toCurrency.code,
      };
    },
    changeToCurrency(e) {
      const currency = _.find(this.toCurrencies, { id: +e });
      if (currency != undefined) {
        this.toCurrency = currency;
        this.getBalance(+e).then((response) => {
          this.toBalance = response.data.data.balance;
        });
        this.onChangeTrigger();
      }
    },
    getCurrencySwapEnable(currencyId) {
      Axios.get("/api/public/wallet/swap-currencies-enable/" + currencyId)
        .then((response) => {
          if (response.data.error === false) {
            this.toCurrencies = response.data.data.currencies;
            this.toStaticCurrencies = response.data.data.currencies;
            this.toCurrency = this.toCurrencies[0];
            this.getBalance(this.toCurrency.id).then((response) => {
              this.toBalance = response.data.data.balance;
            });
            this.onChangeTrigger();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    openModalChooseCurrencyfrom() {
      this.modalCurrencyFrom = true;
    },
    openModalChooseCurrencyTo() {
      this.modalCurrencyTo = true;
    },
    openModalConvertConfirm() {
      this.modalConvertConfirm = true;
    },
    closeModal() {
      this.modalConvertConfirm = false;
    },
    changePricePair() {
      const priceUsdFrom = this.fromCurrency.price_usd;
      const priceUsdTo = this.toCurrency.price_usd;
      if (priceUsdFrom == 0 || priceUsdTo == 0) {
        this.pricePair = 0;
        this.dataSwap.to = 0;
      } else {
        this.pricePair = priceUsdFrom / priceUsdTo;
        this.dataSwap.to = this.dataSwap.from * this.pricePair;
      }
    },
    filterCurrencyFrom(e) {
      const value = e.target.value;
      if (value != "") {
        this.fromCurrencies = _.filter(this.fromStaticCurrencies, (item) => {
          return item.code.toLowerCase().indexOf(value.toLowerCase()) > -1;
        });
      } else {
        this.fromCurrencies = this.fromStaticCurrencies;
      }
    },
    filterCurrencyTo(e) {
      const value = e.target.value;
      if (value != "") {
        this.toCurrencies = _.filter(this.toStaticCurrencies, (item) => {
          return item.code.toLowerCase().indexOf(value.toLowerCase()) > -1;
        });
      } else {
        this.toCurrencies = this.toStaticCurrencies;
      }
    },
    changeValueFromInput(percent) {
      const val = (this.fromBalance * percent) / 100;
      this.dataSwap.from = val;
      this.dataSwap.to = val * this.pricePair;
      this.onChangeTrigger();
    },
    changeValueFrom(e) {
      const val = e.target.value;
      this.dataSwap.to = val * this.pricePair;
      this.onChangeTrigger();
    },
    changeValueTo(e) {
      const val = e.target.value;
      this.dataSwap.from = val / this.pricePair;
      this.onChangeTrigger();
    },
    switchDataPrice() {
      const dataPrice = this.dataPrice;
      if (dataPrice.to == this.pricePair) {
        this.dataPrice = {
          from: 1,
          fromCode: this.toCurrency.code,
          to: 1 / this.pricePair,
          toCode: this.fromCurrency.code,
        };
      } else {
        this.dataPrice = {
          from: 1,
          fromCode: this.fromCurrency.code,
          to: this.pricePair,
          toCode: this.toCurrency.code,
        };
      }
    },
    changeFee() {
      const value = this.dataSwap.from;
      const fee = this.fromCurrency.swap_fee;
      const feeType = this.fromCurrency.swap_fee_type;
      if (feeType == 0) {
        this.feeTrade = fee;
      } else {
        this.feeTrade = (value * fee) / 100;
      }
    },
    submitForm() {
      const dataSwap = {
        from_currency_id: this.fromCurrency.id,
        to_currency_id: this.toCurrency.id,
        amount_from: this.dataSwap.from,
      };
      this.showLoading = true;
      this.form = new Form(dataSwap);
      this.form
        .post("/wallet/convert")
        .then((response) => {
          this.showLoading = false;
          this.modalConvertConfirm = false;
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
          }
        })
        .catch((error) => {
          this.showLoading = false;
          this.modalConvertConfirm = false;
          console.log(error);
        });
    },
    async fetchDetailCurrency(currencyId) {
      return await Axios.get(
        "/api/public/wallet/detail-currency/" + currencyId
      );
    },
    actionReloadCurrency() {
      if (this.fromCurrency != null) {
        this.fetchDetailCurrency(this.fromCurrency.id).then((response) => {
          this.fromCurrency = response.data.data.currency;
          this.onChangeTrigger();
        });
      }
      if (this.toCurrency != null) {
        this.fetchDetailCurrency(this.toCurrency.id).then((response) => {
          this.toCurrency = response.data.data.currency;
          this.onChangeTrigger();
        });
      }
    },
  },
};
</script>