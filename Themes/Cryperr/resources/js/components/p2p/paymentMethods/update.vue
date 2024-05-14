
<template>
  <div>
    <b-modal
      v-model="showModalUpdate"
      centered
      no-close-on-backdrop
      hide-footer
      hide-header
    >
      <div class="card-add-payment">
        <div class="card-title mb-3" v-if="paymentMethodCustomer != null">
          {{ paymentMethodCustomer.paymentMethod.title }}
        </div>
        <form
          class="form-profile"
          action=""
          v-if="paymentMethodCustomer != null && attrs.length > 0"
        >
          <div class="form-item" v-for="(item, index) in attrs" :key="index">
            <label for="name" class="form-label">{{ item.title }}</label>
            <div class="input-group">
              <input
                type="text"
                id="name"
                class="input secondary"
                v-model="item.value"
                :placeholder="item.title"
              />
            </div>
          </div>
          <div class="tip-box p-2 p-sm-4 border rounded">
            <div class="d-flex">
              <img
                class="me-2"
                width="24px"
                height="24px"
                :src="getPathImg('images/icons/warning.png')"
                alt=""
              />
              <p class="fw-light fs-7 fs-sm-6">
                Tips: The added payment method will be shown to the buyer during
                the transaction to accept fiat transfers. Please ensure that the
                information is correct, real, and matches your KYC information
                on Binance.
              </p>
            </div>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary" type="button" @click="submitForm">
              Update
            </button>
            <button class="btn btn-primary" type="button" @click="cancelForm">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
import Form from "form-backend-validation";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  props: {
    paymentMethodCustomerId: {
      default: null,
    },
    showModalUpdate: {
      default: false,
    },
  },
  components: { Loading },
  mixins: [GetPathImg],
  data() {
    return {
      paymentMethodCustomer: null,
      visibleLoading: false,
      attrs: [],
      form: new Form(),
    };
  },
  methods: {
    handleAttr() {
      let data = [];
      const paymentMethod = this.paymentMethodCustomer.paymentMethod;
      const attrs = paymentMethod.attrs;
      for (let i = 0; i < attrs.length; i++) {
        const attr = attrs[i];
        data.push({
          id: attr.id,
          title: attr.title,
          value: this.getValueInArray(
            this.paymentMethodCustomer.paymentMethodCustomerAttr,
            attr.id
          ),
        });
        this.attrs = data;
      }
    },
    getValueInArray(dataArr, id) {
      const data = _.find(dataArr, { payment_attr_id: id });
      if (data) {
        return data.value;
      } else {
        return "";
      }
    },
    submitForm() {
      this.form = new Form({ attrs: this.attrs });
      let url =
        "/api/customer/updatePaymentMethod/" + this.paymentMethodCustomerId;
      this.form
        .post(url)
        .then((response) => {
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
          this.cancelForm();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchPaymentMethodCustomer() {
      let url =
        "/api/customer/find-my-payment-method/" + this.paymentMethodCustomerId;
      Axios.get(url)
        .then((response) => {
          this.paymentMethodCustomer = response.data.data;
          this.handleAttr();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    cancelForm() {
      this.paymentMethodCustomer = null;
      this.attrs = [];
      this.$emit("closeForm");
    },
  },
  watch: {
    paymentMethodCustomerId: function (newVal, oldVal) {
      if (newVal != null) {
        this.fetchPaymentMethodCustomer();
      }
    },
  },
};
</script>
