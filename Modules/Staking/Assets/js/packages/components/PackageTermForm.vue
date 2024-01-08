<template>
  <div>
    <el-dialog
      title="Package Term"
      :visible.sync="dialogFormVisible"
      width="50%"
      top="0"
      :close-on-click-modal="false"
    >
      <el-form
        ref="form"
        :model="packageTerm"
        label-width="120px"
        label-position="top"
        @keydown="form.errors.clear($event.target.name)"
      >
        <div class="box box-primary">
          <div class="box-body">
            <el-tabs v-model="activeTab">
              <el-tab-pane
                v-for="(localeArray, locale) in locales"
                :key="localeArray.name"
                :label="localeArray.name"
                :name="locale"
              >
                <span slot="label" :class="{ error: form.errors.has(locale) }"
                  ><i :class="'flag-icon flag-icon-' + locale"></i> &nbsp;
                  {{ localeArray.name }}</span
                >
                <el-form-item
                  :label="trans('packages.form.title')"
                  :class="{
                    'el-form-item is-error': form.errors.has(locale + '.title'),
                  }"
                >
                  <el-input v-model="packageTerm[locale].title"></el-input>
                  <div
                    v-if="form.errors.has(locale + '.title')"
                    class="el-form-item__error"
                    v-text="form.errors.first(locale + '.title')"
                  ></div>
                </el-form-item>
              </el-tab-pane>
            </el-tabs>
            <div class="row">
              <div class="col-md-4">
                <el-form-item
                  :label="trans('packages.form.day_reward')"
                  :class="{
                    'el-form-item is-error': form.errors.has('day_reward'),
                  }"
                >
                  <el-input-number
                    v-model="packageTerm.day_reward"
                    :min="0"
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('day_reward')"
                    class="el-form-item__error"
                    v-text="form.errors.first('day_reward')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-md-4">
                <el-form-item
                  :label="trans('packages.form.apr_reward')"
                  :class="{
                    'el-form-item is-error': form.errors.has('apr_reward'),
                  }"
                >
                  <el-input-number
                    v-model="packageTerm.apr_reward"
                    :min="0"
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('apr_reward')"
                    class="el-form-item__error"
                    v-text="form.errors.first('apr_reward')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-md-4">
                <el-form-item
                  :label="trans('packages.form.max_total_stake')"
                  :class="{
                    'el-form-item is-error': form.errors.has('max_total_stake'),
                  }"
                >
                  <el-input-number
                    v-model="packageTerm.max_total_stake"
                    :min="0"
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('max_total_stake')"
                    class="el-form-item__error"
                    v-text="form.errors.first('max_total_stake')"
                  ></div>
                </el-form-item>
              </div>
              <div class="col-md-4">
                <el-form-item
                  :label="trans('packages.form.total_staked')"
                  :class="{
                    'el-form-item is-error': form.errors.has('total_stake'),
                  }"
                >
                  <el-input-number
                    v-model="packageTerm.total_stake"
                    :min="0"
                    disabled
                  ></el-input-number>
                  <div
                    v-if="form.errors.has('total_stake')"
                    class="el-form-item__error"
                    v-text="form.errors.first('total_stake')"
                  ></div>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <el-form-item
                  :label="trans('packages.form.type')"
                  :class="{
                    'el-form-item is-error': form.errors.has('type'),
                  }"
                >
                  <el-select v-model="packageTerm.type" placeholder="Select">
                    <el-option
                      v-for="item in types"
                      :key="item"
                      :label="item"
                      :value="item"
                    ></el-option>
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
    locales: {
      default: null,
      type: Object,
    },
    packageTermId: {
      type: Number,
    },
    packageId: {
      type: Number,
    },
    dialogFormVisible: Boolean,
  },
  data() {
    return {
      packageTerm: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          day_reward: 0,
          apr_reward: 0,
          total_stake: 0,
          max_total_stake: 0,
          type: "LOCKED",
        })
        .value(),
      form: new Form(),
      activeTab: window.AsgardCMS.currentLocale || "en",
      loading: false,
      types: ["LOCKED", "FLEXIBLE"],
    };
  },
  created() {
    console.log(this.packageTermId);
  },
  methods: {
    submitForm() {
      this.form = new Form(this.packageTerm);
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
      this.packageTerm = window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          day_reward: 0,
          apr_reward: 0,
          total_stake: 0,
          type: "",
        })
        .value();
      this.$emit("closeForm");
    },
    getRoute() {
      if (this.packageTermId != 0) {
        return route("api.staking.packageTerm.update", {
          packageTermId: this.packageTermId
        });
      } else {
        return route("api.staking.packageTerm.store", {
          packageId: this.packageId,
        });
      }
    },
    fetchPackageTerm() {
      if(this.packageTermId != 0){
        axios
        .get(
          route("api.staking.packageTerm.find", {
            packageTermId: this.packageTermId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.packageTerm = response.data.data;
        });
      }else {
        this.closeForm();
      }
    },
  },
  watch: {
    packageTermId: function (newVal, oldVal) {
      this.fetchPackageTerm();
    },
  },
};
</script>