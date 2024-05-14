<template>
  <div>
    <div class="wrap-table d-none d-md-block">
      <table class="table" style="min-width: 700px">
        <thead>
          <tr>
            <th scope="col">Asset / Fiat</th>
            <th scope="col">Type</th>
            <th scope="col">Price</th>
            <th scope="col">Available / Limit</th>
            <th scope="col">Payment Method</th>
            <th scope="col">Last Updated/ Create Time</th>
            <th scope="col">Status</th>
            <th scope="col ">
              <div class="text-end">Action</div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in myAds" :key="index">
            <td>
              <div class="d-flex align-items-center flex-nowrap text-nowrap">
                <img
                  width="16px"
                  height="16px"
                  class="me-2"
                  :src="item.asset_currency.icon"
                  alt=""
                />
                {{ item.asset_currency.code }} /
                <span class="ms-1 fw-light">{{ item.fiat_currency.code }}</span>
              </div>
            </td>
            <td>
              <div
                v-bind:class="{
                  'price-up': item.type == 'BUY',
                  'price-down': item.type == 'SELL',
                }"
              >
                {{ item.type }}
              </div>
            </td>
            <td>
              {{ item.fixed_price }}
              <span class="ms-1 fw-light">{{ item.fiat_currency.code }}</span>
            </td>
            <td>
              <div class="fw-light fs-7">
                Available:
                <span class="fs-6 fw-normal">
                  {{ item.total_trade_amount - item.total_filled }}
                  {{ item.asset_currency.code }}</span
                >
              </div>
              <div class="fw-light fs-7">
                Limit:
                <span class="fs-6 fw-normal">
                  {{ item.order_limit_min }} ~ {{ item.order_limit_max }}
                  {{ item.asset_currency.code }}</span
                >
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <button
                  class="btn btn-outline me-2 fs-7 py-0 px-2"
                  style="height: 36px"
                  v-for="(payment, index) in item.paymentMethods"
                  :key="index"
                >
                  {{ payment.paymentMethod.title ?? "" }}
                </button>
              </div>
            </td>
            <td>
              <div class="fw-light fs-7">
                {{ item.created_at }}
              </div>
              <div class="fw-light fs-7">
                {{ item.updated_at }}
              </div>
            </td>
            <td>
              <div class="price-up">
                <img
                  class="pointer"
                  width="14px"
                  height="14px"
                  :src="getPathImg('images/icons/checked-round-blue.png')"
                  alt=""
                  v-if="item.status == 1"
                />
                <img
                  class="pointer"
                  width="14px"
                  height="14px"
                  :src="getPathImg('images/icons/close-round-red.png')"
                  alt=""
                  v-if="item.status == 0"
                />
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end">
                <img
                  class="me-3 pointer"
                  width="24px"
                  height="24px"
                  @click="openModalEdit(item.url.edit_ads)"
                  :src="getPathImg('images/icons/edit.png')"
                  alt=""
                />
                <img
                  class=""
                  width="24px"
                  height="24px"
                  @click="confirmDeleteAds(item.id)"
                  :src="getPathImg('images/icons/delete.png')"
                  alt=""
                />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mobile-table-list d-block d-md-none mb-4">
      <div
        class="mobile-item border-bottom py-3"
        v-for="(item, index) in myAds"
        :key="index"
      >
        <div class="d-flex justify-content-between mb-3">
          <div>Coin:</div>
          <div class="d-flex align-items-center flex-nowrap text-nowrap">
            <img
              width="16px"
              height="16px"
              class="me-2"
              :src="item.asset_currency.icon"
              alt=""
            />
            {{ item.asset_currency.code }} /
            <span class="ms-1 fw-light">{{ item.fiat_currency.code }}</span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Type:</div>
          <div
            v-bind:class="{
              'price-up': item.type == 'BUY',
              'price-down': item.type == 'SELL',
            }"
          >
            {{ item.type }}
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Price:</div>
          <div>{{ item.fixed_price }} {{ item.fiat_currency.code }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Available / Limit:</div>
          <div>
            <div class="text-end fw-light fs-7">
              Available:
              <span class="fs-6 fw-normal">
                {{ item.total_trade_amount - item.total_filled }}
                {{ item.asset_currency.code }}</span
              >
            </div>
            <div class="fw-light fs-7">
              Limit:
              <span class="fs-6 fw-normal">
                {{ item.order_limit_min }} ~ {{ item.order_limit_max }}
                {{ item.asset_currency.code }}</span
              >
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Payment:</div>
          <div
            class="d-flex align-items-center justify-content-end flex-wrap"
            style="max-width: 170px; row-gap: 8px"
          >
            <button
              class="btn btn-outline me-2 fs-7 py-0 px-2"
              style="height: 36px"
              v-for="(payment, index) in item.paymentMethods"
              :key="index"
            >
              {{ payment.paymentMethod.title ?? "" }}
            </button>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Status:</div>
          <div class="price-up">
            <img
              class="pointer"
              width="14px"
              height="14px"
              :src="getPathImg('images/icons/checked-round-blue.png')"
              alt=""
              v-if="item.status == 1"
            />
            <img
              class="pointer"
              width="14px"
              height="14px"
              :src="getPathImg('images/icons/close-round-red.png')"
              alt=""
              v-if="item.status == 0"
            />
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Last Updated / Create Time:</div>
          <div>
            <div class="fs-7">{{ item.updated_at }}</div>
            <div class="fs-7">{{ item.created_at }}</div>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Action:</div>
          <div class="d-flex align-items-center justify-content-end">
            <a class="me-3">
              <img
                @click="openModalEdit(item.url.edit_ads)"
                width="24px"
                height="24px"
                :src="getPathImg('images/icons/edit.png')"
                class="pointer"
                alt=""
              />
            </a>
            <a @click="confirmDeleteAds(item.id)">
              <img
                width="24px"
                height="24px"
                :src="getPathImg('images/icons/delete.png')"
                alt=""
              />
            </a>
          </div>
        </div>

        <div class="text-center mt-3">
          <a
            class="text-span pointer"
            @click="openModalEdit(item.url.edit_ads)"
          >
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
    <b-overlay :show="showOverlay" rounded="sm">
      <b-modal v-model="modalShowDeleteAds" hide-footer title="Delete Ads"
        >Are you sure you want to delete this Ads?
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
            @click="deleteAds()"
            >Confirm!</b-button
          >
        </div>
      </b-modal>
    </b-overlay>
  </div>
</template>
  <script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../../mixins/GetPathImg";
export default {
  mixins: [GetPathImg],
  created() {
    this.fetchListMyAds();
  },
  data() {
    return {
      modalShowDeleteAds: false,
      showOverlay: false,
      adsId: null,
      myAds: [],
    };
  },
  methods: {
    fetchListMyAds() {
      let url = "/p2p/agent/get-list-my-ads";
      Axios.get(url)
        .then((response) => {
          this.myAds = response.data.data;
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
    openModalEdit(url) {
      window.location.href = url;
    },
    confirmDeleteAds($id) {
      this.modalShowDeleteAds = true;
      this.adsId = $id;
    },
    deleteAds() {
      this.showOverlay = true;
      let url = "/p2p/agent/deleteAds/" + this.adsId;
      Axios.delete(url)
        .then((response) => {
          this.showOverlay = false;
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
          this.closeModal()
        })
        .catch((error) => {
          this.showOverlay = false;
          console.log(error);
        });
    },
    closeModal() {
      this.fetchListMyAds();
      this.modalShowDeleteAds = false;
      this.adsId = null;
    },
  },
};
</script>
  