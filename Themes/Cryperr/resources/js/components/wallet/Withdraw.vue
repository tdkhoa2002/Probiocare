<template>
  <div class="box">
    <loading :active.sync="visibleLoading"></loading>
    <form class="form-withdraw row g-3 g-md-4 mb-3">
      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label"> Select Currency </label>
          <div class="input-group">
            <select
              class="input"
              required
              @change="selectChangeCurrency($event)"
              v-model="dataGeneral.currency_id"
            >
              <option value="" disabled selected hidden>Select currency</option>
              <option
                v-bind:value="currency.id"
                :key="currency.id"
                v-for="currency in currencies"
              >
                {{ currency.title }}
              </option>
            </select>
            <img
              width="12px"
              height="8px"
              :src="getPathImg('images/down-outline.png')"
              alt=""
            />
          </div>
          <div
            class="invalid-feedback d-block"
            v-if="dataError.currency_id != ''"
          >
            {{ dataError.currency_id }}
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label"> Select Chain </label>
          <div class="input-group">
            <select
              class="input"
              required
              v-model="dataGeneral.blockchain_id"
              @change="selectChangeBlockchain($event)"
            >
              <option value="" disabled selected hidden>Select chain</option>
              <option
                v-bind:value="blockchain.id"
                :key="blockchain.id"
                v-for="blockchain in blockchains"
              >
                {{ blockchain.title }}
              </option>
            </select>
            <img
              width="12px"
              height="8px"
              :src="getPathImg('images/down-outline.png')"
              alt=""
            />
          </div>
          <div
            class="invalid-feedback d-block"
            v-if="dataError.blockchain_id != ''"
          >
            {{ dataError.blockchain_id }}
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label">
            <div>Address</div>
          </label>
          <div class="group-input-custom">
            <input
              type="text"
              class="input secondary"
              placeholder="Address to withdraw"
              v-model="dataGeneral.address"
            />
            <a class="d-flex align-items-center ms-3" @click="pasteToTextArea">
              <img
                class="icon"
                width="32px"
                height="32px"
                :src="getPathImg('images/icon-copy.png')"
                alt=""
                style="min-width: 32px"
              />
            </a>
          </div>
          <div class="invalid-feedback d-block" v-if="dataError.address != ''">
            {{ dataError.address }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="form-item mb-0">
          <ul class="withdraw-note">
            <li>
              <span class="fw-light">
                Enter the correct address to withdraw
              </span>
            </li>
            <li>
              <span class="fw-light">Ensure the network is </span> Correct!
            </li>
          </ul>
        </div>
      </div>

      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label">
            <div class="d-flex justify-content-between w-100">
              <div class="form-label-left">Amount</div>
              <div class="form-label-right fs-6">
                <span class="fw-light">Available:</span>
                {{ amount_available }} {{ currency_available }}
              </div>
            </div>
          </label>
          <div class="input-group">
            <input
              type="text"
              class="input"
              placeholder="Amount"
              v-model="dataGeneral.amount"
            />
            <div class="suffix">
              <a class="btn-max text pointer" @click="setToMax">Max</a>
            </div>
          </div>
          <div class="invalid-feedback d-block" v-if="dataError.amount != ''">
            {{ dataError.amount }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="form-item mb-0">
          <div class="box-disclaimer light-card bg-secondary mt-3" v-if="selectedChain != null ">
            <div class="d-flex">
              <img
                width="26px"
                height="26px"
                class="me-2"
                :src="getPathImg('images/icons/warning-red.png')"
                alt=""
              />
              <div class="d-flex flex-column" >
                <div class="text-warning">Disclaimer</div>
                <div class="text fw-light fs-7 fs-sm-6">
                  The network you have selected is {{selectedChain.title}}, please make sure your
                  withdrawal address supports the {{selectedChain.title}} network. In
                  case the other platform does not support this network, your
                  assets may be lost. If you are unsure if the receiving
                  platform supports this network, you can click the button below
                  to verify it yourself.
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-center w-100 mt-4">
            <button type="button" class="btn btn-primary" @click="submitForm()">
              Withdraw
            </button>
          </div>
        </div>
      </div>
    </form>
    <div>
      <b-modal
        centered
        no-close-on-backdrop
        v-model="modalShowConfirmCode"
        hide-footer
        hide-header
      >
        <div class="d-block text-center box-modal-verify-code">
          <h3>Verification Code</h3>
          <p>Please check your email for OTP</p>
          <VerifyCodeInput v-on:complete="onComplete"></VerifyCodeInput>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="fw-light">
            <button
              type="button"
              class="btn mt-3 btn-outline-warning btn-block"
              @click="reSendVerifyCode"
            >
              Send Code
            </button>
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
            @click="submitVerifyCode()"
            >Confirm!</b-button
          >
        </div>
      </b-modal>
    </div>
    <div class="resent-transaction">
      <h2 class="fs-4 mb-3">Recent Transation</h2>
      <div class="wrap-table">
        <table
          class="table"
          style="min-width: 700px"
          v-if="transactions.length > 0"
        >
          <thead>
            <tr>
              <th scope="col">Time</th>
              <th scope="col">Action</th>
              <th scope="col">Network</th>
              <th scope="col">Amount</th>
              <th scope="col">Currency</th>
              <th scope="col">Txh</th>
              <th scope="col text-end">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, key) in transactions" :key="key">
              <td>
                <div class="text">{{ item.created_at }}</div>
              </td>
              <td>{{ item.action }}</td>
              <td>{{ item.blockchain?.title }}</td>
              <td>{{ item.amount }}</td>
              <td class="row-name">
                <div class="d-flex align-items-center">
                  <img
                    class="me-2"
                    width="32px"
                    height="32px"
                    :src="item?.currency?.icon"
                    alt=""
                  />
                  <span class="symbol">
                    {{ item?.currency?.code }}
                  </span>
                </div>
              </td>
              <td v-if="item.link_tx_hash != ''">
                <a
                  :href="item.link_tx_hash"
                  target="_blank"
                  rel="noopener noreferrer"
                  >{{ item.txhash }}</a
                >
              </td>
              <td v-if="item.link_tx_hash == ''">{{ item.txhash }}</td>
              <td>
                <span
                  class="box-status success"
                  v-if="item.status != 'CREATED'"
                  >{{ item.status }}</span
                >
                <span
                  class="box-status btn-primary pointer"
                  v-if="item.status == 'CREATED'"
                  @click="openModalVerify(item.id)"
                  >Verify</span
                >
              </td>
            </tr>
          </tbody>
        </table>

        <div class="table-empty" v-if="transactions.length <= 0">
          <img
            class=""
            width="36px"
            height="40px"
            :src="getPathImg('images/empty.png')"
            alt=""
          />
          Empty
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
import _ from "lodash";
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import VerifyCodeInput from "../VerifyCodeInput.vue";
export default {
  components: {
    Loading,
    VerifyCodeInput,
  },
  props: {
    currency_id: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getListCurrency();
    this.getListWithdraw();
    if (this.currency_id != 0) {
      this.dataGeneral.currency_id = this.currency_id;
      this.changeCurrency(this.dataGeneral.currency_id);
    }
  },
  data() {
    return {
      visibleLoading: false,
      modalShowConfirmCode: false,
      dataGeneral: {
        currency_id: "",
        blockchain_id: "",
        address: "",
        amount: "",
      },
      dataError: {
        currency_id: "",
        blockchain_id: "",
        address: "",
        amount: "",
      },
      dataCode: "",
      blockchains: [],
      selectedChain: null,
      amount_available: 0,
      currency_available: "",
      transactionId: 0,
      transactions: [],
      meta: { current_page: 1, per_page: 10, total: 0, totalPage: 0, page: 1 },
      currencies: [],
    };
  },
  methods: {
    setToMax() {
      this.dataGeneral.amount = this.amount_available;
    },
    onComplete(value) {
      this.dataCode = value;
    },
    getListCurrency() {
      Axios.get("/wallet/currencies")
        .then((response) => {
          if (response.data.error === false) {
            this.currencies = response.data.data.currencies;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    handleReloadTable() {
      this.meta.page = 1;
      this.getListWithdraw();
    },
    changePage(p) {
      this.meta.page = p;
      this.getListWithdraw();
    },
    selectChangeBlockchain(event) {
      const value = event.target.value;
      this.selectedChain = _.find(this.blockchains, {id:1});
      
      console.log(this.selectedChain);
    },
    selectChangeCurrency(event) {
      const value = event.target.value;
      if (value != "") {
        this.changeCurrency(value);
      } else {
        this.blockchains = [];
      }
    },
    changeCurrency(currencyId) {
      if (currencyId != "") {
        const currency = _.find(this.currencies, function (o) {
          return o.id == +currencyId;
        });
        this.currency_available = currency ? currency.title : "";
        Axios.get("/wallet/getBlockchainSupport/" + currencyId)
          .then((response) => {
            if (response.data.error === false) {
              this.blockchains = response.data.data.blockchains;
              this.amount_available = response.data.data.balance;
              this.dataGeneral.currency_id = +currencyId;
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.blockchains = [];
      }
    },
    pasteToTextArea() {
      if (navigator.clipboard) {
        navigator.clipboard
          .readText()
          .then((text) => {
            this.dataGeneral.address = text;
          })
          .catch((error) => {
            console.error("Failed to read clipboard contents: ", error);
          });
      } else {
        console.error("Clipboard API not supported in this browser.");
      }
    },
    reSendVerifyCode() {
      this.visibleLoading = true;
      if (this.transactionId != "") {
        Axios.post("/wallet/resend-verify-code-withdraw", {
          transactionId: this.transactionId,
        })
          .then((response) => {
            this.visibleLoading = false;
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
          })
          .catch((error) => {
            this.visibleLoading = false;
            console.log(error);
          });
      } else {
        this.visibleLoading = false;
      }
    },
    submitForm() {
      this.resetDataError();
      this.visibleLoading = true;
      Axios.post("/wallet/withdraw", this.dataGeneral)
        .then((response) => {
          this.visibleLoading = false;
          if (response.data.error === false) {
            this.modalShowConfirmCode = true;
            this.transactionId = response.data.data.transaction.id;
            this.handleReloadTable();
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
            if (response.data.validate) {
              if (response.data.data.address !== undefined) {
                this.dataError.address = response.data.data.address[0];
              }
              if (response.data.data.currency_id !== undefined) {
                this.dataError.currency_id = response.data.data.currency_id[0];
              }
              if (response.data.data.amount !== undefined) {
                this.dataError.amount = response.data.data.amount[0];
              }
              if (response.data.data.blockchain_id !== undefined) {
                this.dataError.blockchain_id =
                  response.data.data.blockchain_id[0];
              }
            }
          }
        })
        .catch((error) => {
          this.visibleLoading = false;
          console.log(error);
        });
    },
    resetDataError() {
      this.dataError = {
        currency_id: "",
        blockchain_id: "",
        address: "",
        amount: "",
      };
    },
    closeModal() {
      this.dataCode = "";
      this.transactionId = 0;
      this.modalShowConfirmCode = false;
    },
    openModalVerify(transactionId) {
      this.transactionId = transactionId;
      this.modalShowConfirmCode = true;
    },
    submitVerifyCode() {
      if (this.dataCode == "") {
        this.$bvToast.toast("Please enter verify code", {
          variant: "danger",
          solid: true,
          noCloseButton: true,
        });
        return false;
      }
      Axios.post("/wallet/verifyWithdraw", {
        code: this.dataCode,
        transactionId: this.transactionId,
      })
        .then((response) => {
          if (response.data.error === false) {
            this.closeModal();
            this.handleReloadTable();
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
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getListWithdraw() {
      Axios.get("/wallet/list-withdraw", {
        params: {
          page: this.meta.page,
          per_page: this.meta.per_page,
        },
      })
        .then((response) => {
          this.transactions = response.data.data.transactions;
          this.meta = response.data.data.meta;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>