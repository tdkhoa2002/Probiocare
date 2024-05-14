<template>
  <div>
    <div class="box-curency-attr">
      <el-descriptions v-for="currencyAttr in currencyAttrs" :key="currencyAttr.id" border>
        <template slot="extra">
          <el-button type="primary" icon="el-icon-edit" size="small" circle
            @click="openForm(currencyAttr.id)"></el-button>
          <el-button type="danger" icon="el-icon-delete" size="small" circle
            @click="deleteCurrencyAttr(currencyAttr.id)"></el-button>
        </template>
        <el-descriptions-item label="Blockchain">{{ currencyAttr.blockchain.title }}</el-descriptions-item>
        <el-descriptions-item label="Token Address">{{ currencyAttr.token_address }}</el-descriptions-item>
        <el-descriptions-item label="Native Token">{{ currencyAttr.nativeToken.title }}</el-descriptions-item>
        <el-descriptions-item label="Decimal">{{ currencyAttr.decimal }}</el-descriptions-item>
        <el-descriptions-item label="Withdraw Fee Token">{{ currencyAttr.withdraw_fee_token }}</el-descriptions-item>
        <el-descriptions-item
          label="Withdraw Fee Token Type">{{ currencyAttr.withdraw_fee_token_type }}</el-descriptions-item>
        <el-descriptions-item label="Value need approve">{{ currencyAttr.value_need_approve }}</el-descriptions-item>
        <!-- <el-descriptions-item label="Value need approve currency">{{currencyAttr.value_need_approve_currency_title}}</el-descriptions-item> -->
        <el-descriptions-item label="Max time withdraw in day">{{ currencyAttr.max_times_withdraw }}</el-descriptions-item>
        <el-descriptions-item
          label="Max amount withdraw daily">{{ currencyAttr.max_amount_withdraw_daily }}</el-descriptions-item>
        <!-- <el-descriptions-item label="Max amount withdraw daily currency">{{currencyAttr.max_amount_withdraw_daily_currency_title}}</el-descriptions-item> -->
        <el-descriptions-item label="Max withdraw">{{ currencyAttr.max_withdraw }}</el-descriptions-item>
        <el-descriptions-item label="Min withdraw">{{ currencyAttr.min_withdraw }}</el-descriptions-item>
        <el-descriptions-item label="Type withdraw">{{ currencyAttr.type_withdraw }}</el-descriptions-item>
        <el-descriptions-item label="Type deposit">{{ currencyAttr.type_deposit }}</el-descriptions-item>
        <el-descriptions-item label="Type transfer">{{ currencyAttr.type_transfer }}</el-descriptions-item>
        <el-descriptions-item label="Status">
          <template>
            <i :class="currencyAttr.status === true ? 'text-success' : 'text-danger'" class="fa fa-circle"></i>
          </template>
        </el-descriptions-item>
      </el-descriptions>
    </div>
    <el-button type="text" @click="openForm(0)">Add more currency Attr</el-button>

    <el-dialog title="Currency Attribute" :visible.sync="dialogFormVisible" width="90%" top="0"
      :close-on-click-modal="false">
      <el-form ref="form" :model="currencyAttr" label-width="120px" label-position="top"
        @keydown="form.errors.clear($event.target.name)">
        <div class="row">
          <div class="col-md-12">
            <div class="box-body">
              <el-form-item :label="trans('chainwallets.form.blockchain_id')" :class="{
                'el-form-item is-error': form.errors.has('blockchain_id'),
              }">
                <el-select v-model="currencyAttr.blockchain_id" placeholder="Select">
                  <el-option v-for="item in blockchains" :key="item.id" :label="item.title" :value="item.id">
                  </el-option>
                </el-select>
                <div v-if="form.errors.has('blockchain_id')" class="el-form-item__error"
                  v-text="form.errors.first('blockchain_id')"></div>
              </el-form-item>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item :label="trans('currencies.form.token_address')" :class="{
                    'el-form-item is-error': form.errors.has('token_address'),
                  }">
                    <el-input v-model="currencyAttr.token_address"></el-input>
                    <div v-if="form.errors.has('token_address')" class="el-form-item__error"
                      v-text="form.errors.first('title')"></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <el-form-item :label="trans('currencies.form.abi')" :class="{
                    'el-form-item is-error': form.errors.has('abi'),
                  }">
                    <el-input v-model="currencyAttr.abi" type="textarea"
                      :autosize="{ minRows: 4, maxRows: 10 }"></el-input>
                    <div v-if="form.errors.has('abi')" class="el-form-item__error" v-text="form.errors.first('abi')">
                    </div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.native_token')" :class="{
                    'el-form-item is-error': form.errors.has('native_token'),
                  }">
                    <el-select v-model="currencyAttr.native_token" placeholder="Select">
                      <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                        :value="item.id"></el-option>
                    </el-select>
                    <div v-if="form.errors.has('native_token')" class="el-form-item__error"
                      v-text="form.errors.first('native_token')"></div>
                  </el-form-item>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.decimal')" :class="{
                    'el-form-item is-error': form.errors.has('decimal'),
                  }">
                    <el-input-number v-model="currencyAttr.decimal" :min="0"></el-input-number>
                    <div v-if="form.errors.has('decimal')" class="el-form-item__error"
                      v-text="form.errors.first('decimal')"></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.withdraw_fee_token')" :class="{
                    'el-form-item is-error':
                      form.errors.has('withdraw_fee_token'),
                  }">
                    <el-input-number v-model="currencyAttr.withdraw_fee_token" :min="0"></el-input-number>
                    <div v-if="form.errors.has('withdraw_fee_token')" class="el-form-item__error"
                      v-text="form.errors.first('withdraw_fee_token')"></div>
                  </el-form-item>
                </div>
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.withdraw_fee_token_type')" :class="{
                    'el-form-item is-error': form.errors.has(
                      'withdraw_fee_token_type'
                    ),
                  }">
                    <el-select v-model="currencyAttr.withdraw_fee_token_type" placeholder="Select">
                      <el-option :key="0" label="Fixed" :value="0"></el-option>
                      <el-option :key="1" label="Percent" :value="1"></el-option>
                    </el-select>
                    <div v-if="form.errors.has('withdraw_fee_token_type')" class="el-form-item__error"
                      v-text="form.errors.first('withdraw_fee_token_type')"></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.value_need_approve')" :class="{
                    'el-form-item is-error':
                      form.errors.has('value_need_approve'),
                  }">
                    <el-input-number v-model="currencyAttr.value_need_approve" :min="0"></el-input-number>
                    <div v-if="form.errors.has('value_need_approve')" class="el-form-item__error"
                      v-text="form.errors.first('value_need_approve')"></div>
                  </el-form-item>
                </div>
                <!-- <div class="col-md-4">
                  <el-form-item
                    :label="
                      trans('currencies.form.value_need_approve_currency')
                    "
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        'value_need_approve_currency'
                      ),
                    }"
                  >
                    <el-select
                      v-model="currencyAttr.value_need_approve_currency"
                      placeholder="Select"
                    >
                      <el-option
                        v-for="item in currencies"
                        :key="item.id"
                        :label="item.title"
                        :value="item.id"
                      ></el-option>
                    </el-select>
                    <div
                      v-if="form.errors.has('value_need_approve_currency')"
                      class="el-form-item__error"
                      v-text="form.errors.first('value_need_approve_currency')"
                    ></div>
                  </el-form-item>
                </div> -->
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.max_times_withdraw')" :class="{
                    'el-form-item is-error':
                      form.errors.has('max_times_withdraw'),
                  }">
                    <el-input-number v-model="currencyAttr.max_times_withdraw" :min="0"></el-input-number>
                    <div v-if="form.errors.has('max_times_withdraw')" class="el-form-item__error"
                      v-text="form.errors.first('max_times_withdraw')"></div>
                  </el-form-item>
                </div>
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.max_amount_withdraw_daily')" :class="{
                    'el-form-item is-error': form.errors.has(
                      'max_amount_withdraw_daily'
                    ),
                  }">
                    <el-input-number v-model="currencyAttr.max_amount_withdraw_daily" :min="0"></el-input-number>
                    <div v-if="form.errors.has('max_amount_withdraw_daily')" class="el-form-item__error"
                      v-text="form.errors.first('max_amount_withdraw_daily')"></div>
                  </el-form-item>
                </div>
                <!-- <div class="col-md-4">
                  <el-form-item
                    :label="
                      trans(
                        'currencies.form.max_amount_withdraw_daily_currency'
                      )
                    "
                    :class="{
                      'el-form-item is-error': form.errors.has(
                        'max_amount_withdraw_daily_currency'
                      ),
                    }"
                  >
                    <el-select
                      v-model="currencyAttr.max_amount_withdraw_daily_currency"
                      placeholder="Select"
                    >
                      <el-option
                        v-for="item in currencies"
                        :key="item.id"
                        :label="item.title"
                        :value="item.id"
                      ></el-option>
                    </el-select>
                    <div
                      v-if="
                        form.errors.has('max_amount_withdraw_daily_currency')
                      "
                      class="el-form-item__error"
                      v-text="
                        form.errors.first('max_amount_withdraw_daily_currency')
                      "
                    ></div>
                  </el-form-item>
                </div> -->
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.min_withdraw')" :class="{
                    'el-form-item is-error': form.errors.has('min_withdraw'),
                  }">
                    <el-input-number v-model="currencyAttr.min_withdraw" :min="0"></el-input-number>
                    <div v-if="form.errors.has('min_withdraw')" class="el-form-item__error"
                      v-text="form.errors.first('min_withdraw')"></div>
                  </el-form-item>
                </div>
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.max_withdraw')" :class="{
                    'el-form-item is-error': form.errors.has('max_withdraw'),
                  }">
                    <el-input-number v-model="currencyAttr.max_withdraw" :min="0"></el-input-number>
                    <div v-if="form.errors.has('max_withdraw')" class="el-form-item__error"
                      v-text="form.errors.first('max_withdraw')"></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.type_withdraw')" :class="{
                    'el-form-item is-error': form.errors.has('type_withdraw'),
                  }">
                    <el-select v-model="currencyAttr.type_withdraw" placeholder="Select">
                      <el-option v-for="item in type_withdraws" :key="item" :label="item" :value="item"></el-option>
                    </el-select>
                    <div v-if="form.errors.has('type_withdraw')" class="el-form-item__error"
                      v-text="form.errors.first('type_withdraw')"></div>
                  </el-form-item>
                </div>
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.type_deposit')" :class="{
                    'el-form-item is-error': form.errors.has('type_deposit'),
                  }">
                    <el-select v-model="currencyAttr.type_deposit" placeholder="Select">
                      <el-option v-for="item in type_deposits" :key="item" :label="item" :value="item"></el-option>
                    </el-select>
                    <div v-if="form.errors.has('type_deposit')" class="el-form-item__error"
                      v-text="form.errors.first('type_deposit')"></div>
                  </el-form-item>
                </div>
                <div class="col-md-4">
                  <el-form-item :label="trans('currencies.form.type_transfer')" :class="{
                    'el-form-item is-error': form.errors.has('type_transfer'),
                  }">
                    <el-select v-model="currencyAttr.type_transfer" placeholder="Select">
                      <el-option v-for="item in type_transfers" :key="item" :label="item" :value="item"></el-option>
                    </el-select>
                    <div v-if="form.errors.has('type_transfer')" class="el-form-item__error"
                      v-text="form.errors.first('type_transfer')"></div>
                  </el-form-item>
                </div>
              </div>
              <el-form-item :label="trans('currencies.form.status')" :class="{
                'el-form-item is-error': form.errors.has('status'),
              }">
                <el-switch v-model="currencyAttr.status" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('status')" class="el-form-item__error" v-text="form.errors.first('status')">
                </div>
              </el-form-item>
            </div>
          </div>
        </div>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="closeForm()">Cancel</el-button>
        <el-button type="primary" @click="submitForm()">Confirm</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
import axios from "axios";
import Form from "form-backend-validation";

export default {
  props: {
    currencyId: {
      type: Number,
    },
    currencies: {
      default: null,
      type: Array,
    },
  },
  data() {
    return {
      dialogFormVisible: false,
      currencyAttr: {
        blockchain_id: "",
        token_address: "",
        abi: "",
        native_token: "",
        decimal: 0,
        withdraw_fee_token: 0,
        withdraw_fee_token_type: 0,
        withdraw_fee_chain: 0,
        value_need_approve: 0,
        value_need_approve_currency: "",
        max_amount_withdraw_daily: 0,
        max_amount_withdraw_daily_currency: "",
        max_times_withdraw: 0,
        min_withdraw: 0,
        max_withdraw: 0,
        type_withdraw: "",
        type_deposit: "",
        type_transfer: "",
        status: true,
      },
      formLabelWidth: "120px",
      blockchains: [],
      currencyAttrs: [],
      currencyAttrId: 0,
      form: new Form(),
      loading: false,
      type_withdraws: ["ONCHAIN"],
      type_deposits: ["ONCHAIN"],
      type_transfers: ["INTERNAL_TRANSFER", "ONCHAIN_WITHDRAW"],
    };
  },
  created() {
    this.fetchCurrencyAttrs();
    this.fetchBlockchain();
  },
  methods: {
    submitForm() {
      this.form = new Form(this.currencyAttr);
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
      this.dialogFormVisible = false;
      this.currencyAttrId = 0;
      this.currencyAttr = {
        blockchain_id: "",
        token_address: "",
        abi: "",
        native_token: "",
        decimal: 0,
        withdraw_fee_token: 0,
        withdraw_fee_token_type: 0,
        withdraw_fee_chain: 0,
        value_need_approve: 0,
        value_need_approve_currency: "",
        max_amount_withdraw_daily: 0,
        max_amount_withdraw_daily_currency: "",
        max_times_withdraw: 0,
        min_withdraw: 0,
        max_withdraw: 0,
        type_withdraw: "",
        type_deposit: "",
        type_transfer: "",
        status: true,
      };
      this.fetchCurrencyAttrs();
    },
    openForm($currencyAttrId) {
      if ($currencyAttrId != 0) {
        this.currencyAttrId = $currencyAttrId;

        axios
          .get(
            route("api.wallet.currencyattr.find", {
              currencyAttrId: this.currencyAttrId,
            })
          )
          .then((response) => {
            this.currencyAttr = response.data.data;
          });
      }
      this.dialogFormVisible = true;
    },
    deleteCurrencyAttr(currencyAttrId) {
      this.$confirm(this.trans('core.modal.confirmation-message'), this.trans('core.modal.title'), {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        axios
          .delete(
            route("api.wallet.currencyattr.destroy", {
              currencyAttrId: currencyAttrId,
            })
          )
          .then((response) => {
            this.$message({
              type: 'success',
              message: response.data.message
            });
            this.currencyAttrs = this.currencyAttrs.filter(function (obj) {
              return obj.id !== currencyAttrId;
            });
          });

      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled'
        });
      });
    },

    fetchBlockchain() {
      axios.get(route("api.wallet.blockchain.all")).then((response) => {
        this.blockchains = response.data.data;
      });
    },
    getRoute() {
      if (this.currencyAttrId != 0) {
        return route("api.wallet.currencyattr.update", {
          currencyId: this.currencyId,
          currencyAttrId: this.currencyAttrId,
        });
      } else {
        return route("api.wallet.currencyattr.store", {
          currencyId: this.currencyId,
        });
      }
    },
    fetchCurrencyAttrs() {
      axios
        .get(
          route("api.wallet.currencyattr.listByCurrency", {
            currencyId: this.currencyId,
          })
        )
        .then((response) => {
          this.currencyAttrs = response.data.data;
        });
    },
  },
};
</script>
<style>
.box-curency-attr .el-descriptions {
  margin-top: 30px;
  border: 1px solid #EBEEF5;
  padding: 5px;
}
</style>