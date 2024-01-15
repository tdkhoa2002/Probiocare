<template>
    <div class="my-staking-list" style="margin-left: 50px;">
        <loading :active.sync="visibleLoading"></loading>
        <div class="tabs">
            <div class="tab-content pt-3 pt-md-4">
                <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                    <div class="wrap-table d-none d-md-block">
                        <div @click="">
                            <span style="font-size: 18px; font-weight: 500; line-height: 26.91px;">All Package <img class="pointer" :src="getPathImg('images/arrow-bottom.png')"></span>
                        </div>
                        <table class="table" style="min-width: 700px">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in orders" :key="index" @click="openDetailStake(item)"
                                    class="pointer">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="action">
                                                Pay
                                            </span>
                                            <img class="me-2" width="32px" height="32px" :src="getPathImg('images/pdf.png')"
                                                alt="" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="amount"
                                                style="color: #BD1207; font-weight: 500; font-size: 16px; line-height: 23.92px;">
                                                -{{
                                                    item.amount_stake
                                                }} USD
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ item.title }}
                                    </td>
                                    <td :style="getStatusColor(item.status)">
                                        {{ item.status === 0 ? 'Processing' : 'Completed' }}
                                    </td>
                                    <td>{{ formatSubscriptionDate(item.subscription_date) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <span style="color: #000000; font-size: 16px; line-height: 23.92px; font-weight: 400;">More information about all packages</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Axios from "axios";
import moment from "moment";
import _ from "lodash";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import GetPathImg from "../../mixins/GetPathImg";
export default {
    components: {
        Loading,
    },
    mixins: [GetPathImg],
    created() {
        this.getListMyStake();
    },
    data() {
        return {
            orders: [],
            visibleLoading: false,
            order: null,
        };
    },
    methods: {
        getStatusColor(status) {
            return {
                'color': status === 0 ? '#FDC22A' : '#1A773B',
            };
        },
        formatSubscriptionDate(date) {
            const formattedDate = new Date(date).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            }).replace(/\//g, '-');
            return formattedDate;
        },
        openDetailStake(order) {
            this.order = order;
        },
        closeModal() {
            this.order = null;
            this.getListMyStake()
        },
        getListMyStake() {
            this.visibleLoading = true;
            Axios.get("/loyalty/get-list-my-stake")
                .then((response) => {
                    if (response.data.error === false) {
                        this.orders = response.data.data.orders;
                        this.orders.sort((a, b) => a.amount_stake - b.amount_stake);
                        console.log(this.orders);
                    } else {
                        this.$bvToast.toast(response.data.data.message, {
                            variant: "danger",
                            solid: true,
                        });
                    }
                    setTimeout(() => {
                        this.visibleLoading = false;
                    }, 500);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
  