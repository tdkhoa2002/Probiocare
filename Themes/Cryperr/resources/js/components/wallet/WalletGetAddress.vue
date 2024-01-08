<template>
  <div class="box">
    <form action="" class="form-deposit row g-4" ref="form">
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
                :key="currency.id"
                v-bind:value="currency.id"
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
        </div>
      </div>
      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label"> Select Chain </label>
          <div class="input-group">
            <select
              class="input"
              required
              @change="changeBlockchain($event)"
              v-model="dataGeneral.blockchain_id"
            >
              <option value="" disabled selected hidden>Select chain</option>
              <option
                :key="blockchain.id"
                v-bind:value="blockchain.id"
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
        </div>
      </div>
      <div class="col-12">
        <div class="form-item mb-0">
          <label for="currency" class="form-label">
            <div>Address</div>
            <div class="form-sublabel">
              Use the wallet address below to deposit
            </div>
          </label>
          <div class="group-input-custom">
            <input
              type="text"
              class="input bg-secondary"
              placeholder="0x"
              v-model="address"
            />
            <a class="copy-wrap d-flex align-items-center ms-3">
              <img
                class="icon"
                width="32px"
                height="32px"
                :src="getPathImg('images/icon-copy.png')"
                alt=""
                style="min-width: 32px"
              />
              <div class="copy-notify">Success</div>
            </a>
            <a class="d-flex align-items-center ms-3" @click="showQrCode">
              <img
                class="icon-right icon-qr-code pointer"
                width="32px"
                height="32px"
                :src="getPathImg('images/icon-qr-code.png')"
                style="min-width: 32px"
              />
            </a>
          </div>
        </div>
      </div>
    </form>
    <ul class="deposit-note">
      <li v-if="currency != null">
        Send only {{ currency.title }}
        <span class="fw-light">to this deposit address</span>
      </li>
      <li v-if="blockchain != null">
        <span class="fw-light">Ensure the network is</span>
        {{ blockchain.title }}
      </li>
    </ul>
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
              <td>{{ item.blockchain.title }}</td>
              <td>{{ item.amount }}</td>
              <td class="row-name">
                <div class="d-flex align-items-center">
                  <img
                    class="me-2"
                    width="32px"
                    height="32px"
                    :src="item.currency.icon"
                    alt=""
                  />
                  <span class="symbol">
                    {{ item.currency.code }}
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
                <span class="box-status success">{{ item.status }}</span>
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
      v-if="transactions.length > 0"
      :page-count="meta.totalPage"
      :click-handler="changePage"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :container-class="'box-wrap-pagination'"
    >
    </paginate>
    <b-modal
      centered
      v-model="showModalQrCode"
      hide-footer
      content-class="modalQrCode"
      title="Scan to Deposit"
      header-close-content=""
    >
      <qrcode :value="address" :options="{ width: 300 }" tag="img"></qrcode>
    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    currency_id: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getListCurrency();
    if (this.currency_id !== 0) {
      this.dataGeneral.currency_id = this.currency_id;
      this.changeCurrency(this.dataGeneral.currency_id);
    }
    this.getRecentTransaction();
  },
  data() {
    return {
      dataGeneral: {
        currency_id: "",
        blockchain_id: "",
      },
      showModalQrCode: false,
      address: "",
      blockchains: [],
      transactions: [],
      meta: { current_page: 1, per_page: 10, total: 0, totalPage: 0, page: 1 },
      currencies: [],
      currency: null,
      blockchain: null,
    };
  },
  methods: {
    showQrCode() {
      if (this.address != "") {
        this.showModalQrCode = true;
      }
    },
    selectChangeCurrency(event) {
      const value = event.target.value;
      if (value != "") {
        this.address = "";
        this.changeCurrency(value);
      } else {
        this.blockchains = [];
      }
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
    changeCurrency(currencyId) {
      if (currencyId != "") {
        this.dataGeneral.blockchain_id = "";
        Axios.get("/wallet/getBlockchainSupport/" + currencyId)
          .then((response) => {
            if (response.data.error === false) {
              this.blockchains = response.data.data.blockchains;
              this.dataGeneral.currency_id = +currencyId;
              this.currency = _.find(this.currencies, (item) => {
                return item.id == currencyId;
              });
              this.getRecentTransaction();
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.blockchains = [];
      }
    },
    handleReloadTable() {
      this.meta.page = 1;
      this.getRecentTransaction();
    },
    changePage(p) {
      this.meta.page = p;
      this.getRecentTransaction();
    },
    getRecentTransaction() {
      Axios.get("/transaction/get-recent-transaction", {
        params: {
          type: "DEPOSIT",
          currency: this.dataGeneral.currency_id,
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
    changeBlockchain(event) {
      const value = event.target.value;
      if (value != "") {
        this.dataGeneral.blockchain_id = +value;
        Axios.get("/wallet/getAddress", { params: this.dataGeneral })
          .then((response) => {
            if (response.data.error === false) {
              this.address = response.data.data.address;
              this.blockchain = _.find(this.blockchains, (item) => {
                return item.id == this.dataGeneral.blockchain_id;
              });
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        this.blockchain = null;
        this.dataGeneral.blockchain_id = "";
      }
    },
  },
  mounted() {},
};
</script>
