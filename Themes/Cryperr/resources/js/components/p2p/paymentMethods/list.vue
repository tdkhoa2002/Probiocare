<template>
  <div class="payment-list">
    <div class="item" v-for="(item, index) in myPaymentMethods" :key="index">
      <div class="d-flex align-items-center mb-2">
        <img class="me-2" width="24px" height="24px" :src="item.paymentMethod.logo" alt="" />
        <span class="fw-medium">{{ item.paymentMethod.title }}</span>
      </div>
      <div class="wrap-table d-none d-md-block mb-3">
        <table class="table" style="min-width: 700px">
          <thead>
            <tr>
              <th scope="col" v-for="(attr, i) in item.paymentMethod.attrs" :key="i">
                {{ attr.title }}
              </th>
              <th scope="col ">
                <div class="text-end">Action</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td v-for="(attr, i) in item.paymentMethodCustomerAttr" :key="i">
                {{ attr.value }}
              </td>
              <td>
                <div class="d-flex align-items-center justify-content-end">
                  <img class="me-4" width="24px" height="24px" :src="getPathImg('images/icons/edit.png')" alt=""
                    @click="openModalEdit(item.id)" />
                  <img class="" width="24px" height="24px" data-bs-target="#modalDeletePayment" data-bs-toggle="modal"
                    :src="getPathImg('images/icons/delete.png')" alt="" />
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mobile-table-list d-block d-md-none mb-4">
        <div class="mobile-item border-bottom py-3">
          <div class="d-flex justify-content-between mb-3" v-for="(attr, i) in item.paymentMethod.attrs" :key="i">
            <div>{{ attr.title }}:</div>
            <div>
              {{ getValueInArray(item.paymentMethodCustomerAttr, attr.id) }}
            </div>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div>Action:</div>
            <div class="d-flex align-items-center justify-content-end">
              <img class="me-3" width="24px" height="24px" :src="getPathImg('images/icons/edit.png')" alt=""
                @click="openModalEdit(item.id)" />
              <img class="" width="24px" height="24px" data-bs-target="#modalDeletePayment" data-bs-toggle="modal"
                :src="getPathImg('images/icons/delete.png')" alt="" />
            </div>
          </div>
          <div class="text-center mt-3">
            <a class="text-span pointer" @click="openModalEdit(item.id)">
              Go to detail
              <img class="ms-2" style="vertical-align: baseline" width="6px" height="10px"
                :src="getPathImg('images/icons/arrow-right.png')" alt="" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <update-payment-method :paymentMethodCustomerId="paymentMethodCustomerId" :showModalUpdate="showModalUpdate"
      @closeForm="closeForm()"></update-payment-method>
  </div>
</template>
<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
export default {
  props: {
    customerId: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  created() {
    this.fetchListMyPaymentMethod();
  },
  data() {
    return {
      paymentMethodCustomerId: null,
      showModalUpdate: false,
      myPaymentMethods: [],
    };
  },
  methods: {
    fetchListMyPaymentMethod() {
      let url = "/api/customer/list-my-payment-method";
      if (this.customerId != null) {
        url = url + "?customer_id=" + this.customerId
      }
      Axios.get(url)
        .then((response) => {
          this.myPaymentMethods = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getValueInArray(dataArr, id) {
      const data = _.find(dataArr, { payment_attr_id: id });
      if (data) {
        return data.value;
      } else {
        return "";
      }
    },
    closeForm() {
      this.paymentMethodCustomerId = null;
      this.showModalUpdate = false;
      this.fetchListMyPaymentMethod();
    },
    openModalEdit(id) {
      this.paymentMethodCustomerId = id;
      this.showModalUpdate = true;
    },
  },
};
</script>
