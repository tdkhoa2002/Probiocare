<template>
  <div class="staking-content">
    <loading :active.sync="visibleLoading"></loading>
    <div class="row g-2 g-lg-4">
      <div class="col-12 col-lg-8">
        <div class="staking-card">
          <div class="card-title fw-medium fs-4 mb-2">Staking</div>
          <div class="d-flex align-items-center fw-medium mb-2">
            <img
              v-if="packageData.currency_stake.icon"
              class="me-2"
              width="32px"
              height="32px"
              v-bind:src="packageData.currency_stake.icon"
              alt=""
            />
            {{ packageData.currency_stake.title }}
          </div>
          <p class="fw-light mb-3">
            Stake
            <span class="text">{{ packageData.currency_stake.title }}</span>
            earn
            <span class="text">{{ packageData.currency_reward.title }}</span>
          </p>

          <div class="duration mb-3">
            <div class="fs-5 fw-medium mb-2">Duration</div>
            <div class="d-flex align-items-center">
              <div
                class="item-term"
                v-for="(item, index) in packageData.terms"
                :key="index"
                style="margin-right: 10px"
              >
                <span
                  ><input
                    :id="item.id"
                    type="radio"
                    v-model="dataStake.term_id"
                    v-on:change="changeRadioTerm"
                    :value="item.id"
                  />
                  <label :for="item.id">{{ item.title }}</label></span
                >
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fs-5 fw-medium">Stake Amount</div>
            <div class="balance fw-light">
              Balance:
              <span class="text"
                >{{ balance }} {{ packageData.currency_stake.code }}</span
              >
            </div>
          </div>
          <div class="input-group bg-light mb-2">
            <input
              type="text"
              class="input"
              @keyup="changeInputAmount($event)"
              placeholder="Please enter the amount"
              v-model="dataStake.amount"
            />
            <div class="suffix fw-medium pointer" @click="stakeMax()">Max</div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-medium">Amount Limitation</div>
            <div class="balance">
              {{ packageData.max_stake }} {{ packageData.currency_stake.code }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="summary-card">
          <div class="card-title fs-5 mb-3">Summary</div>

          <div class="steps mb-3">
            <div class="steps-item">
              <div class="steps-item-name">Stake Date</div>
              <div class="steps-item-date fw-light">
                {{ start_date }}
              </div>
            </div>
            <div class="steps-item">
              <div class="steps-item-name">Value Date</div>
              <div class="steps-item-date fw-light">{{ value_date }}</div>
            </div>
            <div class="steps-item">
              <div class="steps-item-name">End Date</div>
              <div class="steps-item-date">{{ end_date }}</div>
            </div>
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-between mb-3">
              <div class="fw-light">Type:</div>
              <div>{{ type_stake }}</div>
            </div>

            <div class="d-flex justify-content-between mb-3">
              <div class="fw-light">Staked Amount :</div>
              <div id="stake_amount">
                {{ dataStake.amount }} {{ packageData.currency_stake.title }}
              </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div class="fw-light">Est APR :</div>
              <div v-if="est_apr != 0">{{ est_apr }}%</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div class="fw-light">Est Reward :</div>
              <div id="estimated_apr">
                {{ est_reward }} {{ packageData.currency_reward.title }}
              </div>
            </div>
          </div>

          <div class="checkbok mb-3">
            <div class="d-flex justify-content-between w-100">
              <div class="form-check d-flex align-items-center">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="remember"
                  name="remember"
                  style="min-width: 16px"
                />
                <label class="form-check-label ms-2" for="remember"
                  >I have read and agree MetaViral Cex Wallets Staking Service
                  Agreement</label
                >
              </div>
            </div>
          </div>

          <div class="text-center">
            <button class="btn btn-primary" @click="submitStake">
              Confirm Stake
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
import moment from "moment";
import _ from "lodash";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading,
  },
  props: {
    packageId: {
      default: null,
      type: Number,
    },
    balance: {
      default: 0,
    },
    termSelectedId: {
      default: 0,
    },
  },
  mixins: [],
  created() {
    console.log("info", this.packageId);
    this.getPackageInfo(this.packageId);
  },
  data() {
    return {
      dataStake: {
        packageId: this.packageId,
        amount: 0,
        term_id: this.termSelectedId,
      },
      visibleLoading: false,
      value_date: "",
      start_date: moment().format("YYYY-MM-DD HH:mm:ss"),
      end_date: "",
      type_stake: "",
      est_apr: 0,
      est_reward: 0,
      staked_amount: 0,
      day_reward: 0,
      packageData: {
        id: 0,
        currency_stake_id: "",
        currency_stake: {
          id: 0,
          code: "",
          title: "",
          icon: "",
        },
        currency_reward_id: "",
        currency_reward: {
          id: 0,
          code: "",
          title: "",
          icon: "",
        },
        terms: [],
        min_stake: 0,
        max_stake: "",
        start_date: null,
        end_date: null,
        title: "",
        description: "",
      },
    };
  },
  methods: {
    submitStake() {
      this.visibleLoading = true;
      Axios.post("/staking/submitStake", this.dataStake)
        .then((response) => {
          if (response.data.error === false) {
            this.$bvToast.toast(response.data.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
            setTimeout(() => {
              this.visibleLoading = false;
              window.location.href = response.data.data.url_return;
            }, 500);
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
            this.visibleLoading = false;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    stakeMax() {
      this.dataStake.amount = this.balance;
      this.changeAmount(this.dataStake.amount);
    },
    getPackageInfo(packageId) {
      this.visibleLoading = true;
      Axios.get("/staking/getPackageInfo/" + packageId)
        .then((response) => {
          if (response.data.error === false) {
            this.packageData = response.data.data.package;
            if (this.termSelectedId != "" && this.termSelectedId != 0) {
              this.changeTerm(this.termSelectedId);
            }
          } else {
            this.$bvToast.toast(response.data.data.message, {
              variant: "danger",
              solid: true,
            });
          }
          setTimeout(() => {
            this.visibleLoading = false;
          }, 500);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeRadioTerm(event) {
      const value = event.target.value;
      if (value != "") {
        this.dataStake.amount = 0;
        this.changeAmount(0);
        this.changeTerm(value);
      }
    },
    changeTerm(termId) {
      const terms = this.packageData.terms;
      const term = _.find(terms, (o) => {
        return o.id == termId;
      });
      if (term) {
        this.type_stake = term.type;
        this.est_apr = term.apr_reward;
        this.day_reward = term.day_reward;
        this.value_date = moment().add(1, "days").format("YYYY-MM-DD HH:mm:ss");
        if (term.type == "FLEXIBLE") {
          this.end_date = "FLEXIBLE";
        } else {
          this.end_date = moment()
            .add(this.day_reward + 1, "days")
            .format("YYYY-MM-DD HH:mm:ss");
        }
      } else {
        this.type_stake = "";
        this.est_apr = 0;
        this.day_reward = 0;
        this.end_date = "";
      }
    },
    changeInputAmount(event) {
      const value = event.target.value;
      if (value != "") {
        this.dataStake.amount = +value;
        this.changeAmount(value);
      }
    },
    changeAmount(amount) {
      const est_reward =
        ((this.est_apr * amount) / 100 / 365) * this.day_reward;
      this.est_reward = est_reward.toFixed(10);
    },
  },
  mounted() {},
};
</script>
