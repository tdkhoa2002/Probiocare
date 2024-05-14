<template>
  <section class="section-2">
    <div class="container-custom">
      <h2 class="title home-title">Popular cryptocurrencies</h2>
      <table class="table-popular table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Last Price</th>
            <th scope="col">Market Cap</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in currencies" :key="item.id">
            <td class="row-name">
              <div class="d-flex align-items-center">
                <img
                  class="me-2"
                  width="32px"
                  height="32px"
                  :src="item.icon"
                  alt=""
                />
                <span class="symbol">{{item.code}}</span>
              </div>
            </td>
            <td>${{item.usd_rate}}</td>
            <td>${{item.usd_rate * item.total_supply}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
import _ from "lodash";
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    layout: {
      default: 'list',
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getCurrencies();
    console.log(this.currencies);
  },
  data() {
    return {
      currencies: [],
    };
  },
  methods: {
    getCurrencies() {
      Axios.get("/api/public/wallet/currencies/")
        .then((response) => {
          if (response.data.error === false) {
            this.currencies = response.data.data.currencies;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>