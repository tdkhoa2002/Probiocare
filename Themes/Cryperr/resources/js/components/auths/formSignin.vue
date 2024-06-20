<template>
  <form class="row" action="#">
    <loading :active.sync="visibleLoading"></loading>
    <div class="col-12 mb-3">
      <label for="email" class="form-label">{{ trans('auth.email') }}</label>
      <input
        type="email"
        class="form-control input"
        id="email"
        aria-describedby="emailHelp"
        v-model="dataRequest.email"
      />
      <div
        v-if="form.errors.has('email')"
        class="form-text error"
        v-text="form.errors.first('email')"
      ></div>
    </div>
    <div class="col-12 mb-3">
      <label for="password" class="form-label">Password</label>
      <div class="input-group-password">
        <input
          type="password"
          class="form-control input"
          id="password"
          v-model="dataRequest.password"
        />
        <span class="togglePassword" id="">
          <img :src="getPathImg('images/icons/eye.png')" alt="" />
        </span>

        <div
          v-if="form.errors.has('password')"
          class="form-text error"
          v-text="form.errors.first('password')"
        ></div>
      </div>
    </div>
    <div class="d-flex justify-content-between w-100">
      <div class="mb-3 form-check">
        <input
          type="checkbox"
          class="form-check-input"
          id="remember"
          v-model="dataRequest.remember"
        />
        <label class="form-check-label" for="remember">Remember</label>
      </div>
      <a class="form-link" :href="linkForgot">Forgot password</a>
    </div>
    <div class="action mt-3 d-flex justify-content-center">
      <button type="button" class="btn btn-primary" @click="submitLogin">
        Sign in
      </button>
    </div>
    <!-- <ModalVerifyLogin
      @closeModal="closeModal"
      :objectData="dataRequest"
      :modalShowConfirmCode="modalShowConfirmCode"
    ></ModalVerifyLogin> -->
  </form>
</template>
<script>
import _ from "lodash";
import Form from "form-backend-validation";
import GetPathImg from "../../mixins/GetPathImg";
import ModalVerifyLogin from "./ModalVerifyLogin.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading,
    ModalVerifyLogin,
  },
  props: {
    linkForgot: {
      default: null,
      type: String,
    },
  },
  mixins: [GetPathImg],
  created() {},
  data() {
    return {
      translations : window.translations,
      modalShowConfirmCode: false,
      visibleLoading: false,
      form: new Form(),
      dataRequest: {
        email: "",
        password: "",
        remember: false,
      },
    };
  }, 
  methods: {
    closeModal() {
      this.modalShowConfirmCode = false;
    },
    submitLogin() {
      this.visibleLoading = true;
      this.form = new Form(this.dataRequest);
      this.form
        .post("/customer/login")
        .then((response) => {
          this.visibleLoading = false;
          if (response.error == true) {
            this.$bvToast.toast(response.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
            console.log(response);
            window.location.href = response.data.url;
          } else {
            this.modalShowConfirmCode = true;
            console.log(response);
            window.location.href = response.data.url;
          }
        })
        .catch((error) => {
          this.visibleLoading = false;
          console.log(error);
        });
      // this.form
      //   .post("/customer/handle-login")
      //   .then((response) => {
      //     console.log(response);
      //     if (response.error == true) {
      //       this.$bvToast.toast(response.message, {
      //         variant: "danger",
      //         solid: true,
      //         noCloseButton: true,
      //       });
      //       console.log(response);
      //       window.location.href = response.data.url;
      //     } else {
      //       this.$bvToast.toast(response.data.message, {
      //         variant: "success",
      //         solid: true,
      //         noCloseButton: true,
      //       });
      //       window.location.href = response.data.url;
      //     }
      //   })
      //   .catch((error) => {
      //     console.log(error);
      //   });
    },
  },
};
</script>