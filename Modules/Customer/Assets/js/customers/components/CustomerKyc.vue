<template>
  <div>
    <h3 v-if="kyc == null">Customer has not requested KYC</h3>
    <el-descriptions title="KYC Info" v-if="kyc != null">
      <el-descriptions-item label="Firstname">
        {{ kyc.first_name }}
      </el-descriptions-item>
      <el-descriptions-item label="Lastname">{{
        kyc.last_name
      }}</el-descriptions-item>
      <el-descriptions-item label="Type">{{ kyc.type }}</el-descriptions-item>
      <el-descriptions-item label="Number">{{
        kyc.number
      }}</el-descriptions-item>
      <el-descriptions-item label="Birthday">{{
        kyc.birthday
      }}</el-descriptions-item>
      <el-descriptions-item label="Country">{{
        kyc.country != null ? kyc.country.name : ""
      }}</el-descriptions-item>
      <el-descriptions-item label="Front Image">
        <el-image
          style="width: 200px; height: 200px"
          :src="kyc.front_image"
          fit="contain"
          v-if="kyc.front_image != null"
        ></el-image>
      </el-descriptions-item>
      <el-descriptions-item label="Back Image">
        <el-image
          style="width: 200px; height: 200px"
          :src="kyc.back_image"
          fit="contain"
          v-if="kyc.back_image != null"
        ></el-image>
      </el-descriptions-item>
      <el-descriptions-item label="Selfi Image">
        <el-image
          style="width: 200px; height: 200px"
          :src="kyc.selfi_image"
          fit="contain"
          v-if="kyc.selfi_image != null"
        ></el-image>
      </el-descriptions-item>
    </el-descriptions>
    <div class="box-status">
      <div class="row">
        <div class="col-lg-6">
          <el-select v-model="status_kyc" placeholder="Select">
            <el-option
              v-for="item in status_kycs"
              :key="item.id"
              :label="item.title"
              :value="item.id"
            >
            </el-option>
          </el-select>
        </div>
      </div>
      <div class="row mt-4" v-if="status_kyc == 3">
        <div class="col-lg-12">
          <label for="">Reason</label>
          <el-input
            type="textarea"
            :rows="4"
            placeholder="Please input"
            v-model="reason"
          >
          </el-input>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12">
          <el-button type="primary" @click="updateStatusKyc"
            >Update Status</el-button
          >
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import axios from "axios";
import Form from "form-backend-validation";
export default {
  props: {
    customerId: {
      default: null,
      type: Number,
    },
  },
  data() {
    return {
      kyc: null,
      status_kyc: 0,
      reason: "",
      status_kycs: [
        { id: 0, title: "-" },
        { id: 1, title: "Request" },
        { id: 2, title: "Complete" },
        { id: 3, title: "Reject" },
      ],
    };
  },
  mounted() {
    this.findKycCustomer();
  },
  methods: {
    findKycCustomer() {
      this.loading = true;
      axios
        .get(
          route("api.customer.customerKyc.find", {
            customerId: this.customerId,
          })
        )
        .then((response) => {
          this.loading = false;
          const kyc = response.data.kyc;
          if (kyc != null) {
            this.status_kyc = response.data.status_kyc;
            this.kyc = response.data.kyc;
            this.reason = this.kyc.reason;
          }
        });
    },
    updateStatusKyc() {
      this.form = new Form({
        reason: this.reason,
        status_kyc: this.status_kyc,
      });
      this.loading = true;

      this.form
        .post(
          route("api.customer.customerKyc.update", {
            customerId: this.customerId,
          })
        )
        .then((response) => {
          this.$message({
            type: "success",
            message: response.message,
          });
          this.findKycCustomer();
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
  },
};
</script>
<style scoped>
.mt-4 {
  margin-top: 30px;
}
</style>