<template>
  <div>
    <el-dialog
      title="Commission"
      :visible.sync="dialogFormVisible"
      width="50%"
      top="0"
      :close-on-click-modal="false"
    >
      <el-form
        ref="form"
        :model="commission"
        label-width="120px"
        label-position="top"
        @keydown="form.errors.clear($event.target.name)"
      >
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                  :label="trans('commissions.form.commission')"
                  :class="{
                    'el-form-item is-error': form.errors.has('commission'),
                  }"
                >
                  <el-input-number
                    v-model="commission.commission"
                    :min="0"
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('commission')"
                    class="el-form-item__error"
                    v-text="form.errors.first('commission')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-lg-6">
                <el-form-item
                  :label="trans('commissions.form.type')"
                  :class="{
                    'el-form-item is-error': form.errors.has('type'),
                  }"
                >
                  <el-select v-model="commission.type" placeholder="Select">
                    <el-option :key="0" label="Fixed" :value="0"></el-option>
                    <el-option :key="1" label="Percent" :value="1"></el-option>
                  </el-select>
                  <div
                    v-if="form.errors.has('type')"
                    class="el-form-item__error"
                    v-text="form.errors.first('type')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                :label="trans('commissions.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="commission.status"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('status')"
                  class="el-form-item__error"
                  v-text="form.errors.first('status')"
                ></div>
              </el-form-item>
              </div>
            </div>
            <el-form-item>
              <el-button
                :loading="loading"
                type="primary"
                @click="submitForm()"
              >
                {{ trans("core.save") }}
              </el-button>
              <el-button @click="closeForm()">
                {{ trans("core.button.cancel") }}
              </el-button>
            </el-form-item>
          </div>
        </div>
      </el-form>
    </el-dialog>
  </div>
</template>
    <script>
import axios from "axios";
import Form from "form-backend-validation";

export default {
  props: {
    commissionId: {
      type: Number,
    },
    packageId: {
      type: Number,
    },
    dialogFormVisible: Boolean,
  },
  data() {
    return {
      commission: {
        commission: 0,
        type: 0,
        status: false,
      },
      form: new Form(),
      loading: false,
    };
  },
  created() {
    console.log(this.commissionId);
  },
  methods: {
    submitForm() {
      this.form = new Form(this.commission);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          if (response.errors) {
            this.$message({
              type: "error",
              message: response.message,
            });
          } else {
            this.$message({
              type: "success",
              message: response.message,
            });
          }
          this.closeForm();
        })
        .catch((error) => {
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    closeForm() {
      this.commission = {
        commission: 0,
        type: 0,
        status: false,
      };
      this.$emit("closeForm");
    },
    getRoute() {
      if (this.commissionId != 0) {
        return route("api.staking.commission.update", {
          commissionId: this.commissionId,
        });
      } else {
        return route("api.staking.commission.store", {
          packageId: this.packageId,
        });
      }
    },
    fetchCommission() {
      console.log(this.commissionId);
      if (this.commissionId != 0) {
        axios
          .get(
            route("api.staking.commission.find", {
              commissionId: this.commissionId,
            })
          )
          .then((response) => {
            this.loading = false;
            this.commission = response.data.data;
          });
      } else {
        this.closeForm();
      }
    },
  },
  watch: {
    commissionId: function (newVal, oldVal) {
      this.fetchCommission();
    },
  },
};
</script>