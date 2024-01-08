<template>
  <div>
    <b-overlay :show="showLoading" rounded="sm">
      <div
        class="order-pending-payment"
        v-if="order != null && order.status !== 2"
      >
        <div class="bg-secondary py-4">
          <div class="container-custom">
            <div class="d-flex align-items-center mb-3 mb-md-0">
              <button class="btn btn-danger me-3" style="min-width: 120px">
                SELL
              </button>
              <div class="fw-medium fs-4">
                SELL {{ order.asset_currency.code }}
              </div>
            </div>
            <div class="d-flex justify-content-between flex-column flex-md-row">
              <div
                class="d-flex align-items-center flex-column flex-md-row mb-4 mb-md-0"
                v-if="order.status == 0 || order.status == 1"
              >
                <div class="fw-light me-3">
                  The order is created, please wait for system confirmation
                </div>
                <div class="countdown mt-3 mt-md-0">
                  <span class="count me-2">1</span>
                  <span class="colon mx-2">:</span>
                  <span class="count">19</span>
                </div>
              </div>
              <div
                class="d-flex align-items-center flex-column flex-md-row mb-4 mb-md-0"
                v-if="
                  order.status == 3 || order.status == 4
                "
              >
                <div class="fw-light me-3">
                  {{ order.status_string }}
                </div>
              </div>
              <div class="ms-3">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                  <span class="fw-light me-2">Order number:</span>
                  {{ order.code }}
                  <a class="copy-wrap ms-2">
                    <img
                      class="pointer"
                      width="24px"
                      height="24px"
                      :src="getPathImg('images/icons/copy.png')"
                      alt=""
                    />
                    <div class="copy-notify">Success</div>
                  </a>
                </div>
                <div class="">
                  <span class="fw-light me-2">Time created:</span>
                  {{ order.created_at }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-custom py-3 mt-3 mt-md-5 mb-4">
          <ul class="progressbar d-none d-md-flex mb-5">
            <li :class="order.status >= 0 && order.status < 3 ? 'active' : ''">
              Pending Payment <span class="round"></span>
            </li>
            <li :class="order.status >= 1 && order.status < 3 ? 'active' : ''">
              Release of Crypto Assets <span class="round"></span>
            </li>
            <li :class="order.status >= 2 && order.status < 3 ? 'active' : ''">
              Completed <span class="round"></span>
            </li>
          </ul>
          <ul class="progressbar vertical d-flex d-md-none mb-4">
            <li :class="order.status >= 0 && order.status < 3 ? 'active' : ''">
              Pending Payment <span class="round"></span>
            </li>
            <li :class="order.status >= 1 && order.status < 3 ? 'active' : ''">
              Release of Crypto Assets <span class="round"></span>
            </li>
            <li :class="order.status >= 2 && order.status < 3 ? 'active' : ''">
              Completed <span class="round"></span>
            </li>
          </ul>

          <div class="fw-medium fs-5 mb-1 mb-md-3">Order info</div>
          <div
            class="d-flex justify-content-between justify-content-md-start mb-4 mb-md-3"
          >
            <div class="d-flex flex-column me-5">
              <div class="mb-2">Fiat Amount</div>
              <div class="fw-medium fs-5">
                {{ order.total_fiat_amount }} {{ order.fiat_currency.code }}
              </div>
            </div>
            <div class="d-flex flex-column me-5">
              <div class="mb-2">Price</div>
              <div class="fw-medium fs-5">
                {{ order.fixed_price }} {{ order.fiat_currency.code }}
              </div>
            </div>
            <div class="d-flex flex-column">
              <div class="mb-2">Crypto Amount</div>
              <div class="fw-medium fs-5">
                {{ order.total_asset_amount }} {{ order.asset_currency.code }}
              </div>
            </div>
          </div>
          <div class="fw-medium fs-5 mb-3">Payment Method</div>
          <div class="item-payment-method" v-if="paymentMethodSelected != null">
            <div class="d-flex align-items-center mb-2">
              <img
                class="me-2"
                width="24px"
                height="24px"
                :src="paymentMethodSelected.paymentMethod.logo"
                alt=""
              />
              <span class="fw-medium">{{
                paymentMethodSelected.paymentMethod.title
              }}</span>
            </div>

            <div class="wrap-table mb-3 d-none d-md-block">
              <table class="table" style="min-width: 500px">
                <thead>
                  <tr>
                    <th
                      scope="col"
                      v-for="(attr, i) in paymentMethodSelected.paymentMethod
                        .attrs"
                      :key="i"
                    >
                      {{ attr.title }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td
                      v-for="(
                        attr, i
                      ) in paymentMethodSelected.paymentMethodCustomerAttr"
                      :key="i"
                    >
                      <div class="d-flex align-items-center">
                        <div class="fw-medium me-3">{{ attr.value }}</div>
                        <a class="copy-wrap">
                          <img
                            class="pointer"
                            width="24px"
                            height="24px"
                            :src="getPathImg('images/icons/copy.png')"
                            alt=""
                          />
                          <div class="copy-notify">Success</div>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mobile-table-list d-block d-md-none mb-4">
              <div class="col-item border-bottom py-3">
                <div
                  class="d-flex justify-content-between mb-3"
                  v-for="(attr, i) in paymentMethodSelected.paymentMethod.attrs"
                  :key="i"
                >
                  <div>{{ attr.title }}:</div>
                  <div>
                    {{
                      getValueInArray(
                        paymentMethodSelected.paymentMethodCustomerAttr,
                        attr.id
                      )
                    }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex">
            <button
              class="btn btn-outline me-3"
              v-if="order.status == 0"
              @click="openModalCancelOrder"
            >
              Cancel
            </button>
            <button class="btn btn-outline me-3" v-if="order.status == 1">
              Appeals
            </button>
            <button class="btn btn-outline me-3" v-if="order.status == 3">
              Support
            </button>
            <button
              class="btn btn-primary"
              v-if="order.status == 1"
              @click="openModalPaymentReceived"
            >
              Payment Received
            </button>
          </div>
        </div>
      </div>
      <div
        class="order-pending-payment"
        v-if="order != null && order.status === 2"
      >
        <div class="bg-secondary py-4">
          <div class="container-custom">
            <div class="d-flex align-items-center mb-3 mb-md-0">
              <button class="btn btn-danger me-3" style="min-width: 120px">
                SELL
              </button>
              <div class="fw-medium fs-4">Order Completed</div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
              <div class="d-flex align-items-center mb-3 mb-md-0">
                <div class="fw-light me-3">
                  <span class="fw-light">You have successfully sold:</span>
                  <span class="text"
                    >{{ order.total_asset_amount }}
                    {{ order.asset_currency.code }}</span
                  >
                </div>
              </div>
              <div>
                <div class="d-flex align-items-center mb-2 mb-md-0">
                  <span class="fw-light me-2">Order number:</span>
                  {{ order.code }}
                  <a class="copy-wrap ms-2">
                    <img
                      class="pointer"
                      width="24px"
                      height="24px"
                      :src="getPathImg('images/icons/copy.png')"
                      alt=""
                    />
                    <div class="copy-notify">Success</div>
                  </a>
                </div>
                <div class="">
                  <span class="fw-light me-2">Time created:</span>
                  {{ order.created_at }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-custom py-3 mt-3 mt-md-4 mb-4">
          <ul class="progressbar d-none d-md-flex mb-5">
            <li :class="order.status >= 0 && order.status < 3 ? 'active' : ''">
              Pending Payment <span class="round"></span>
            </li>
            <li :class="order.status >= 1 && order.status < 3 ? 'active' : ''">
              Release of Crypto Assets <span class="round"></span>
            </li>
            <li :class="order.status >= 2 && order.status < 3 ? 'active' : ''">
              Completed <span class="round"></span>
            </li>
          </ul>
          <ul class="progressbar vertical d-flex d-md-none mb-4">
            <li :class="order.status >= 0 && order.status < 3 ? 'active' : ''">
              Pending Payment <span class="round"></span>
            </li>
            <li :class="order.status >= 1 && order.status < 3 ? 'active' : ''">
              Release of Crypto Assets <span class="round"></span>
            </li>
            <li :class="order.status >= 2 && order.status < 3 ? 'active' : ''">
              Completed <span class="round"></span>
            </li>
          </ul>
          <div class="secondary-card">
            <div
              class="d-flex justify-content-center flex-column align-items-center"
            >
              <div class="text-success fs-4 fw-medium mb-2">
                Order Successfully
              </div>
              <p class="fw-light mb-4">
                Your order has been completed, please check your balance
              </p>
              <img
                class="mb-4"
                width="190px"
                height="190px"
                :src="getPathImg('images/docs-success.png')"
                alt=""
              />
              <button class="btn btn-primary">Check My balance</button>
            </div>
          </div>
        </div>
      </div>
      <ModalCancelOrder
        :orderId="orderId"
        :modalCancelOrder="modalCancelOrder"
        @closeModal="closeModal"
      ></ModalCancelOrder>
      <ModalPaymentReceived
        :orderId="orderId"
        :paymentMethod="paymentMethod"
        :paymentMethodId="payment_method_id"
        :showModalPaymentReceived="showModalPaymentReceived"
        @closeModal="closeModal"
      >
      </ModalPaymentReceived>
    </b-overlay>
  </div>
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
import ModalCancelOrder from "./modal-cancel-order.vue";
import ModalTransferedOrder from "./modal-transfered.vue";
import ModalPaymentReceived from "./modal-payment-received.vue";

export default {
  props: {
    orderId: {
      default: null,
    },
  },
  components: {
    ModalCancelOrder,
    ModalPaymentReceived,
  },
  mixins: [GetPathImg],
  created() {
    this.getP2POrder();
  },
  data() {
    return {
      status: "ALL",
      order: null,
      fiat_currency: null,
      asset_currency: null,
      paymentMethodSelected: null,
      modalCancelOrder: false,
      showModalPaymentReceived: false,
      showLoading: false,
      payment_method_id: null,
      paymentMethod: null,
    };
  },
  methods: {
    getP2POrder() {
      let url = "/p2p/get-order-detail/" + this.orderId;
      Axios.get(url)
        .then((response) => {
          if (response.data.error === false) {
            this.order = response.data.data;
            this.payment_method_id = this.order.paymentmethod_id;
            this.paymentMethodSelected = this.order.paymentmethod;
            this.paymentMethod = this.order.paymentmethod;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    openModalCancelOrder() {
      this.modalCancelOrder = true;
    },
    openModalPaymentReceived() {
      this.showModalPaymentReceived = true;
    },
    closeModal() {
      this.modalCancelOrder = false;
      this.showModalPaymentReceived = false;
      this.payment_method_id = null;
      this.paymentMethod = null;
      this.getP2POrder();
    },
  },
  mounted() {},
};
</script>
  