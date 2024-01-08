<template>
  <b-modal
    centered
    v-model="showModalDetailStake"
    hide-footer
    title=" Staking Information"
    header-close-content=""
    id="modalStakingDetail"
    @hidden="closeModal"
  >
    <loading :active.sync="visibleLoading"></loading>
    <div class="box-content-detail-stake" v-if="order != null">
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex align-items-center">
          <div class="count-num line"></div>
          <div>Stake Date</div>
        </div>
        <div class="fw-light">{{ order.subscription_date }}</div>
      </div>
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex align-items-center">
          <div class="count-num line"></div>
          <div>Value Date</div>
        </div>
        <div class="fw-light">{{ order.subscription_date }}</div>
      </div>
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex align-items-center">
          <div class="count-num"></div>
          <div>End Date</div>
        </div>
        <div
          class="time"
          v-if="order.packageterm && order.packageterm.type === 'FLEXIBLE'"
        >
          Flexible
        </div>
        <div class="time" v-else>{{ order.redemption_date }}</div>
      </div>
      <div class="tx-detail">
        <div class="d-flex justify-content-between mb-3">
          <div class="fw-light">Type :</div>
          <div
            class="time"
            v-if="order.packageterm && order.packageterm.type === 'FLEXIBLE'"
          >
            Flexible
          </div>
          <div class="time" v-else>{{ order.redemption_date }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div class="fw-light">Staked Amount :</div>
          <div class="">
            {{ order.amount_stake }}
            {{ order.currencyStake ? order.currencyStake.code : "" }}
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div class="fw-light">Est APR :</div>
          <div>{{ order.packageterm ? order.packageterm.apr_reward : 0 }}%</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div class="fw-light">Est Reward :</div>
          <div class="">
            {{ order.amount_reward * order.packageterm.apr_reward / 100 }}
            {{ order.currencyReward ? order.currencyReward.code : "" }}
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <button
          class="btn btn-primary"
          disabled
          style="min-width: 170px"
          v-if="order.status === 1"
        >
          UnLocked in {{ order.updated_at }}
        </button>
        <button
          class="btn btn-primary"
          style="min-width: 170px"
          v-if="order.status === 0 && order.redemption_date === null"
          @click="submitUnstake"
        >
          Redeem
        </button>
        <button
          class="btn btn-outline"
          style="min-width: 170px"
          v-if="order.status === 0 && order.redemption_date !== null"
        >
          Locked
        </button>
      </div>
    </div>
  </b-modal>
</template>

<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    showModalDetailStake: {
      default: false,
    },
    order: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {},
  data() {
    return {
      visibleLoading: false,
    };
  },
  methods: {
    closeModal() {
      this.$emit("closeModal");
    },
    submitUnstake() {
      const vm = this;
      this.$bvModal
        .msgBoxConfirm("are you sure unstake this ?", {
          title: "Confirmation",
          size: "sm",
          buttonSize: "sm",
          okClass: "btn btn-primary",
          okTitle: "Confirm",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
          footerClass: "justify-content-center",
          headerCloseVariant: "243234",
        })
        .then((value) => {
          if (value == true) {
            vm.visibleLoading = true;
            Axios.post("/staking/redeem-stake", { orderId: vm.order.id })
              .then((response) => {
                if (response.data.error === false) {
                  this.$bvToast.toast(response.data.data.message, {
                    variant: "success",
                    solid: true,
                    noCloseButton: true,
                  });
                  vm.closeModal();
                } else {
                  this.$bvToast.toast(response.data.data.message, {
                    variant: "danger",
                    solid: true,
                    noCloseButton: true,
                  });
                }
                setTimeout(() => {
                  vm.visibleLoading = false;
                }, 500);
              })
              .catch((error) => {
                console.log(error);
              });
          }
        })
        .catch((err) => {
          // An error occurred
        });
    },
  },
};
</script>