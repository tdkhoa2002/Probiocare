
<template>
  <div class="card-add-payment">
    <div class="card-title mb-3" v-if="paymentMethod != null">
      {{ paymentMethod.title }}
    </div>
    <form
      class="form-profile"
      action=""
      v-if="paymentMethod != null && paymentMethod.attrs.length > 0"
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
            Tips: The added payment method will be shown to the buyer during the
            transaction to accept fiat transfers. Please ensure that the
            information is correct, real, and matches your KYC information on
            Binance.
          </p>
        </div>
      </div>

      <div class="text-center mt-4">
        <button class="btn btn-primary" type="button" @click="submitForm">
          Confirm Create!
        </button>
      </div>
    </form>
    <loading :active.sync="visibleLoading"></loading>
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
    paymentMethodId: {
      default: null,
    },
  },
  components: {
    Loading,
  },
  mixins: [GetPathImg],
  created() {
    this.fetchPaymentMethod();
  },
  data() {
    return {
      visibleLoading: false,
      paymentMethod: null,
      attrs: [],
      form: new Form(),
    };
  },
  methods: {
    handleAttr(attrs) {
      let data = [];
      for (let i = 0; i < attrs.length; i++) {
        const attr = attrs[i];
        data.push({
          id: attr.id,
          title: attr.title,
          value: "",
        });
        this.attrs = data;
      }
    },
    submitForm() {
      this.visibleLoading = true;
      const data = _.merge(
        { attrs: this.attrs },
        { paymentMethodId: +this.paymentMethodId }
      );
      this.form = new Form(data);
      let url = "/api/customer/submitPaymentMethod";
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
            setTimeout(() => {
              this.visibleLoading = false;
              window.location.href = response.data.url;
            }, 500);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchPaymentMethod() {
      let url = "/api/customer/payment-method/" + this.paymentMethodId;
      Axios.get(url)
        .then((response) => {
          this.paymentMethod = response.data.data;
          this.handleAttr(this.paymentMethod.attrs);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
