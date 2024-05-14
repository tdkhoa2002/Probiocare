<template>
  <b-overlay :show="showOverlayTransferedOrder" rounded="sm">
    <b-modal
      v-model="modalTransferedOrder"
      hide-footer
      title="Payment Confirmation"
    >
      <p class="fw-light mb-2">
        Please confirm that you have successfully received the funds from the
        buyer via the following payment method before clicking the “Payment
        Received” button
      </p>
      <div class="light-card mb-3" v-if="dataPaymentMethod != null">
        <div class="d-flex align-items-center mb-3">
          <img
            class="me-2"
            width="24px"
            height="24px"
            :src="dataPaymentMethod.paymentMethod.logo"
            alt=""
          />
          <span class="fw-medium">{{
            dataPaymentMethod.paymentMethod.title
          }}</span>
        </div>
        <div
          class="d-flex justify-content-between mb-3"
          v-for="(attr, i) in dataPaymentMethod.paymentMethod.attrs"
          :key="i"
        >
          <div>{{ attr.title }}:</div>
          <div>
            {{
              getValueInArray(
                dataPaymentMethod.paymentMethodCustomerAttr,
                attr.id
              )
            }}
          </div>
        </div>
      </div>

      <div class="form-check mb-3">
        <input
          type="checkbox"
          class="form-check-input"
          v-model="checkSubmit"
          :true-value="true"
          :false-value="false"
        />
        <label for="" class="form-check-lable fw-light"
          >I have confirmed that the payment was correct</label
        >
      </div>

      <div class="d-flex justify-content-center">
        <button class="btn btn-outline me-2" @click="closeModal">Cancel</button>
        <button class="btn btn-primary ms-2" @click="transferedFiat">
          Confirm
        </button>
      </div>
    </b-modal></b-overlay
  >
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";

export default {
  props: {
    orderId: {
      default: null,
    },
    paymentMethodId: {
      default: null,
    },
    paymentMethod: {
      default: null,
    },
    modalTransferedOrder: {
      default: false,
    },
  },
  mixins: [GetPathImg],
  data() {
    return {
      showOverlayTransferedOrder: false,
      checkSubmit: false,
      dataPaymentMethod: null,
    };
  },
  methods: {
    transferedFiat() {
      this.showOverlayTransferedOrder = true;
      if (this.checkSubmit == false) {
        this.$bvToast.toast("Please check confirmed that the payment was correct", {
          variant: "danger",
          solid: true,
          noCloseButton: true,
        });
        this.showOverlayTransferedOrder = false;
        return false;
      }
      let url = "/p2p/agent/transfered-order/" + this.orderId;
      Axios.post(url)
        .then((response) => {
          this.showOverlayTransferedOrder = false;
          this.closeModal();
          if (response.data.error == true) {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          } else {
            this.$bvToast.toast(response.data.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    closeModal() {
      this.$emit("closeModal");
    },
  },
  watch: {
    paymentMethod: function (newVal, oldVal) {
      this.dataPaymentMethod = newVal;
    },
  },
};
</script>
  