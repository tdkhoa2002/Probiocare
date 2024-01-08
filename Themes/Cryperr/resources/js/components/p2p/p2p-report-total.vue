<template>
    <div class="total-info">
        <div class="row g-2 g-lg-3">
            <div class="col-12 col-md-6 col-lg-5i">
                <div class="card-total-info h-100">
                    <h6 class="fw-normal mb-2">All Trades</h6>
                    <p class="fs-5 fw-medium mb-2">{{ dataReport.totalBuy + dataReport.totalSell }} Time</p>
                    <div class="d-flex justify-content-center fs-7">
                        <span class="price-up  fw-light me-1">Buy {{ dataReport.totalBuy }}</span> / <span
                            class="price-down  fw-light ms-1">Sell
                            {{ dataReport.totalSell }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-5i">
                <div class="card-total-info h-100">
                    <h6 class="fw-normal mb-2">30d Trades</h6>
                    <p class="fs-5 fw-medium mb-2">{{ dataReport.totalTrade30 }} Time</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-5i">
                <div class="card-total-info h-100">
                    <h6 class="fw-normal mb-2">30d Completion Rate</h6>
                    <p class="fs-5 fw-medium mb-2">{{ dataReport.totalTrade30Complete }} Time</p>
                </div>
            </div>
            <!-- <div class="col-12 col-md-6 col-lg-5i">
                    <div class="card-total-info h-100">
                        <h6 class="fw-normal mb-2">Avg. Release Time</h6>
                        <p class="fs-5 fw-medium mb-2">2789 Time(s)</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5i">
                    <div class="card-total-info h-100">
                        <h6 class="fw-normal mb-2">Avg. Pay Time</h6>
                        <p class="fs-5 fw-medium mb-2">2789 Time(s)</p>
                    </div>
                </div> -->
        </div>
    </div>
</template>

<script>
import Axios from "axios";
import _ from "lodash";

export default {
    props: {
        customerId: {
            default: null,
        },
    },
    created() {
        this.getDataReportTrade();
    },
    data() {
        return {
            dataReport: {
                "totalBuy": 0,
                "totalSell": 0,
                "totalTrade30": 0,
                "totalTrade30Complete": 0
            }
        };
    },
    methods: {
        getDataReportTrade() {
            let url = "/api/p2p/countTotalTrade";
            if(this.customerId != null){
                url=url+"?customer_id="+this.customerId
            }
            console.log(url);
            Axios.get(url)
                .then((response) => {
                    if (response.data.error === false) {
                        this.dataReport = response.data.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

};
</script>
