<template>
  <b-overlay :show="showOverlayCancelOrder" rounded="sm">
    <b-modal v-model="modalCancelOrder" hide-footer title="Cancel Order">
      <div class="fw-medium mb-2">Why did you cancel the order?</div>
      <p class="fw-light mb-3">
        We keep your feedback confidential and strive to serve you better next
        time.
      </p>
      <div
        class="form-check form-check-inline mb-2"
        v-for="(item, index) in reasons"
        :key="index"
      >
        <input
          class="form-check-input"
          type="radio"
          name="reason"
          :id="'reason_' + index"
          :value="item"
          v-model="reason"
          v-on:change="changeReason"
        />
        <label class="form-check-label" :for="'reason_' + index">{{
          item
        }}</label>
      </div>
      <div class="input-group bg-light mb-3" v-if="showInputOther">
        <input
          type="text"
          class="input"
          placeholder="Please enter your reasons"
          v-model="reason"
        />
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="agree" />
        <label for="agree" class="form-check-lable fw-light"
          >I have not paid the seller / seller has agree to refund</label
        >
      </div>
      <div class="d-block text-center">
        <b-button
          class="mt-3"
          variant="outline-danger"
          block
          @click="closeModalCancelOrder"
          >Cancel</b-button
        >
        <b-button
          class="mt-3"
          variant="outline-warning"
          block
          @click="cancelOrder()"
          >Confirm!</b-button
        >
      </div>
    </b-modal>
  </b-overlay>
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
    modalCancelOrder: {
      default: false,
    },
  },
  mixins: [GetPathImg],
  data() {
    return {
      showOverlayCancelOrder: false,
      showInputOther: false,
      reason: "",
      reasons: [
        "I do not want to trade anymore",
        "I do not meet the requirements of the advertiser’s trading terms and condition",
        "Seller is asking for extra fee",
        "Problem with seller’s payment method result in unsuccessful payment",
        "Other reasons",
      ],
    };
  },
  methods: {
    cancelOrder() {
      let url = "/p2p/cancel-order/" + this.orderId;
      Axios.post(url, { reason: this.reason })
        .then((response) => {
          this.closeModalCancelOrder();
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
    closeModalCancelOrder() {
      this.$emit("closeModal");
    },
    changeReason(e) {
      const value = e.target.value;
      if (value == "Other reasons") {
        this.showInputOther = true;
        this.reason = "";
      } else {
        this.showInputOther = false;
      }
    },
  },
};
</script>
  