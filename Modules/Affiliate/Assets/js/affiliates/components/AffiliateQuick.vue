<template>
  <div>
    <el-dialog
      title="affiliate"
      :visible.sync="dialogFormVisible"
      width="50%"
      top="0"
      :close-on-click-modal="false"
    >
      <el-form
        ref="form"
        :model="affiliate"
        label-width="120px"
        label-position="top"
        @keydown="form.errors.clear($event.target.name)"
      >
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                  :label="trans('affiliates.form.number_floor')"
                  :class="{
                    'el-form-item is-error': form.errors.has('number_floor'),
                  }"
                >
                  <el-input-number
                    v-model="affiliate.floors"
                    :min="1"
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('number_floor')"
                    class="el-form-item__error"
                    v-text="form.errors.first('number_floor')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                :label="trans('affiliates.form.type')"
                :class="{
                  'el-form-item is-error': form.errors.has('type'),
                }"
              >
                <el-select v-model="affiliate.type" placeholder="Select">
                  <el-option :key="index" :label="type" :value="type" v-for="(type,index) in dataTypes"></el-option>
                </el-select>
                <div
                  v-if="form.errors.has('type')"
                  class="el-form-item__error"
                  v-text="form.errors.first('type')"
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
    dataTypes: [],
    dialogFormVisible: Boolean,
  },
  data() {
    return {
      affiliate: {
        type: "",
        floors:1
      },
      form: new Form(),
      loading: false,
    };
  },
  created() {},
  methods: {
    submitForm() {
      this.form = new Form(this.affiliate);
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
      this.affiliate={
        floors:1,
        type:""
      };
      this.$emit("closeForm");
    },
    getRoute() {
      return route("api.affiliate.affiliate.quickStore");
    },
  },
};
</script>