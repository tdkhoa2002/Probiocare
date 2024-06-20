<template>
  <div>
    <b-modal
      centered
      no-close-on-backdrop
      v-model="modalShowConfirmCode"
      hide-footer
      hide-header
    >
      <div class="d-block text-center">
        <h3>Verification Code</h3>
        <p>Please check your email for OTP</p>
        <VerifyCodeInput v-on:complete="onComplete"></VerifyCodeInput>
        <div
          v-if="form.errors.has('code')"
          class="form-text error"
          v-text="form.errors.first('code')"
        ></div>
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
</template>
<script>
import VerifyCodeInput from "../VerifyCodeInput.vue";
import _ from "lodash";
import Form from "form-backend-validation";
export default {
  components: {
    VerifyCodeInput,
  },
  props: {
    modalShowConfirmCode: {
      default: false,
      type: Boolean,
    },
    objectData: {
      type: Object,
    },
  },
  data() {
    return {
      form: new Form(),
      code: "",
    };
  },
  methods: {
    submitVerifyCode() {
      // if (this.code == "") {
      //   return false;
      // }
      let dataRequest = this.objectData;
      dataRequest.code = this.code;
      this.form = new Form(dataRequest);
      this.form
        .post("/customer/handle-login")
        .then((response) => {
          if (response.error == true) {
            this.$bvToast.toast(response.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
            console.log(response);
            window.location.href = response.data.url;
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
            window.location.href = response.data.url;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    closeModal() {
      this.$emit("closeModal");
    },
    onComplete(e) {
      this.code = e;
    },
  },
};
</script>