<template>
  <section class="section-4">
    <div class="container-custom">
      <h2 class="title home-title">{{ title }}</h2>
      <p class="description">{{ description }}</p>
      <div class="row g-2 g-lg-4">
        <div class="col-sm-4 col-md-3" v-for="(item,index) in packages" :key="index">
          <div class="card-apr-token light-card">
            <div class="card-title">Stake {{ item.currency_stake.code }} -> Earn {{ item.currency_reward.code }}</div>
            <div>APR: <span class="apr price-up">{{ item.terms | getMinAPR }}% - {{ item.terms | getMaxAPR }}%</span></div>
            <div class="d-flex justify-content-between w-100 mt-2">
              <div class="d-flex align-items-center">
                <img
                  width="32px"
                  height="32px"
                  :src="item.currency_stake.icon"
                />
                <img
                  width="32px"
                  height="32px"
                  :src="item.currency_reward.icon"
                />
                <!-- <span class="symbol ms-2">{{ item.currency_stake.title }}</span> -->
              </div>
              <a :href="stakingurl"
                ><img
                  width="22px"
                  height="22px"
                  :src="getPathImg('images/arrow-right-circle.png')"
              /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import _ from "lodash";
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    layout: {
      default: "grid",
    },
    title: {
      default: null,
    },
    description: {
      default: null,
    },
    stakingurl: {
      default: "/staking",
    },
  },
  mixins: [GetPathImg],
  created() {
    this.getPackages();
  },
  data() {
    return {
      packages: [],
    };
  },
  methods: {
    getPackages() {
      Axios.get("/api/public/staking/list-packages")
        .then((response) => {
          if (response.data.error === false) {
            this.packages = response.data.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {},
  filters: {
    getMinAPR: function (terms) {
      if (!terms) return "";
      let value = _.minBy(terms, 'apr_reward');
      return value.apr_reward;
    },
    getMaxAPR: function (terms) {
      if (!terms) return "";
      let value = _.maxBy(terms, 'apr_reward');
      return value.apr_reward;
    },
  },
};
</script>