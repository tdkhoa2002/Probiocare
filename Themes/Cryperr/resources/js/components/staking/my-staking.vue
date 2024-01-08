<template>
  <div class="my-staking-list">
    <loading :active.sync="visibleLoading"></loading>
    <h1 class="fs-5 fs-sm-4 mb-2 mb-md-4">My Staking</h1>
    <div class="tabs">
      <div class="tab-content pt-3 pt-md-4">
        <div
          class="tab-pane active"
          id="all"
          role="tabpanel"
          aria-labelledby="all-tab"
          tabindex="0"
        >
          <div class="wrap-table d-none d-md-block">
            <table class="table" style="min-width: 700px">
              <thead>
                <tr>
                  <th scope="col">Stake Currency</th>
                  <th scope="col">Reward Currency</th>
                  <th scope="col">Stake Amount</th>
                  <th scope="col">Reward</th>
                  <th scope="col">Principal</th>
                  <th scope="col">Est.APR</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">End Date</th>
                  <th scope="col text-end"></th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item, index) in orders"
                  :key="index"
                  @click="openDetailStake(item)"
                  class="pointer"
                >
                  <td>
                    <div class="d-flex align-items-center">
                      <img
                        class="me-2"
                        width="32px"
                        height="32px"
                        :src="item.currencyStake ? item.currencyStake.icon : ''"
                        alt=""
                      />
                      <span class="symbol">
                        {{ item.currencyStake ? item.currencyStake.code : "" }}
                      </span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img
                        class="me-2"
                        width="32px"
                        height="32px"
                        :src="
                          item.currencyReward ? item.currencyReward.icon : ''
                        "
                        alt=""
                      />
                      <span class="symbol">
                        {{
                          item.currencyReward ? item.currencyReward.code : ""
                        }}
                      </span>
                    </div>
                  </td>
                  <td>
                    {{ item.amount_stake }}
                    {{ item.currencyStake ? item.currencyStake.code : "" }}
                  </td>
                  <td>
                    {{ item.total_amount_reward }}
                    {{ item.currencyReward ? item.currencyReward.code : "" }}
                  </td>
                  <td>{{ item.principal }}</td>
                  <td>
                    {{ item.packageterm ? item.packageterm.apr_reward : 0 }}%
                  </td>

                  <td>
                    <div class="fw-light">{{ item.subscription_date }}</div>
                  </td>
                  <td>
                    <div
                      class="fw-light"
                      v-if="
                        item.packageterm && item.packageterm.type === 'FLEXIBLE'
                      "
                    >
                      FLEXIBLE
                    </div>
                    <div class="fw-light" v-else>
                      {{ item.redemption_date }}
                    </div>
                  </td>
                  <td>
                    <button
                      class="btn btn-primary"
                      disabled
                      style="min-width: 170px"
                      v-if="item.status === 1"
                    >
                      UnLocked
                    </button>
                    <button
                      class="btn btn-primary"
                      style="min-width: 170px"
                      v-if="item.status === 0 && item.redemption_date === null"
                    >
                      Redeem
                    </button>
                    <button
                      class="btn btn-outline"
                      style="min-width: 170px"
                      v-if="item.status === 0 && item.redemption_date !== null"
                    >
                      Locked
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="package-list d-block d-md-none">
            <div
              class="package-item border-bottom py-3"
              v-for="(item, index) in orders"
              :key="index"
            >
              <div class="d-flex justify-content-between mb-3">
                <div>Stake Currency:</div>
                <a>
                  <div
                    class="d-flex align-items-center flex-nowrap text-nowrap"
                  >
                    <img
                      class="me-1"
                      width="24px"
                      height="24px"
                      :src="item.currencyStake ? item.currencyStake.icon : ''"
                      alt=""
                    />
                    <span>
                      {{ item.currencyStake ? item.currencyStake.code : "" }}
                    </span>
                  </div>
                </a>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Reward Currency:</div>
                <a>
                  <div
                    class="d-flex align-items-center flex-nowrap text-nowrap"
                  >
                    <img
                      class="me-1"
                      width="24px"
                      height="24px"
                      :src="item.currencyReward ? item.currencyReward.icon : ''"
                      alt=""
                    />
                    <span>
                      {{ item.currencyReward ? item.currencyReward.code : "" }}
                    </span>
                  </div>
                </a>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Stake Amount :</div>
                <div class="price-up">
                  {{ item.amount_stake }}
                  {{ item.currencyStake ? item.currencyStake.code : "" }}
                </div>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Reward :</div>
                <div>
                  {{ item.total_amount_reward }}
                  {{ item.currencyReward ? item.currencyReward.code : "" }}
                </div>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Principal :</div>
                <div>{{ item.principal }}</div>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Est.APR :</div>
                <div class="price-up">
                  {{ item.packageterm ? item.packageterm.apr_reward : 0 }}%
                </div>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>Start Date :</div>
                <div class="fw-light">{{ item.subscription_date }}</div>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div>End Date :</div>
                <div
                  class="fw-light"
                  v-if="
                    item.packageterm && item.packageterm.type === 'FLEXIBLE'
                  "
                >
                  FLEXIBLE
                </div>
                <div class="fw-light" v-else>
                  {{ item.redemption_date }}
                </div>
              </div>
              <div class="text-center mt-3">
                <button
                  class="btn btn-primary"
                  disabled
                  style="min-width: 170px"
                  v-if="item.status === 1"
                >
                  UnLocked
                </button>
                <button
                  class="btn btn-primary"
                  style="min-width: 170px"
                  v-if="item.status === 0 && item.redemption_date === null"
                >
                  Redeem
                </button>
                <button
                  class="btn btn-outline"
                  style="min-width: 170px"
                  v-if="item.status === 0 && item.redemption_date !== null"
                >
                  Locked
                </button>
              </div>

              <div class="text-center mt-3">
                <a class="text-span pointer" @click="openDetailStake(item)">
                  Go to detail
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
    </div>
    <ModalDetail
      :showModalDetailStake="showModalDetailStake"
      :order="order"
      @closeModal="closeModal"
    ></ModalDetail>
  </div>
</template>
<script>
import Axios from "axios";
import moment from "moment";
import _ from "lodash";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import GetPathImg from "../../mixins/GetPathImg";
import ModalDetail from "./modalDetail.vue";
export default {
  components: {
    Loading,
    ModalDetail,
  },
  mixins: [GetPathImg],
  created() {
    this.getListMyStake();
  },
  data() {
    return {
      orders: [],
      visibleLoading: false,
      showModalDetailStake: false,
      order: null,
    };
  },
  methods: {
    openDetailStake(order) {
      this.showModalDetailStake = true;
      this.order = order;
    },
    closeModal() {
      this.showModalDetailStake = false;
      this.order = null;
      this.getListMyStake()
    },
    getListMyStake() {
      this.visibleLoading = true;
      Axios.get("/staking/get-list-my-stake")
        .then((response) => {
          if (response.data.error === false) {
            this.orders = response.data.data.orders;
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
  },
};
</script>
