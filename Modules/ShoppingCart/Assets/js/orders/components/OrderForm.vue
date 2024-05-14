<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`orders.title.${orderTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.shoppingcart.order.index' }">
          {{ trans("orders.title.orders") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.shoppingcart.order.create' }">
          {{ trans(`orders.title.${orderTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form ref="form" :model="order" label-width="120px" label-position="top"
      @keydown="form.errors.clear($event.target.name)">
      <form-errors :form="form"></form-errors>
      <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-body">
              <el-descriptions class="margin-top" title="Customer Info" :column="2">
                <el-descriptions-item label="Fullname">{{
                  this.order.fullname
                }}</el-descriptions-item>
                <el-descriptions-item label="Email">{{
                  this.order.email
                }}</el-descriptions-item>
                <el-descriptions-item label="Phone number">{{
                  this.order.phone_number
                }}</el-descriptions-item>
                <el-descriptions-item label="Address">{{
                  this.order.address
                }}</el-descriptions-item>
              </el-descriptions>
              <el-table :data="orderDetails" style="width: 100%">
                <el-table-column label="Product">
                  <template slot-scope="scope">
                    <el-image style="width: 100px; height: 100px" :src="scope.row.product.avatar"
                      fit="contain"></el-image>
                    <p class="demonstration">{{ scope.row.product.title }}</p>
                  </template>
                </el-table-column>
                <el-table-column prop="price" label="Price" width="100">
                </el-table-column>
                <el-table-column prop="qty" label="Quantity" width="100">
                </el-table-column>
                <el-table-column prop="total" label="Total" width="100">
                </el-table-column>
              </el-table>
              <el-form-item class="mt-5">
                <el-button :loading="loading" type="primary" @click="onSubmit()">
                  {{ trans("core.save") }}
                </el-button>
                <el-button @click="onCancel()">
                  {{ trans("core.button.cancel") }}
                </el-button>
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-body">
              <el-descriptions class="margin-top" title="Order Info" :column="1">
                <el-descriptions-item label="Total">{{
                  this.order.total
                }}</el-descriptions-item>
                <el-descriptions-item label="Note">{{
                  this.order.note
                }}</el-descriptions-item>
                <el-descriptions-item label="Payment Method">
                  <el-select v-model="order.payment_method" placeholder="Select">
                    <el-option key="1" label="COD" :value="1">
                    </el-option>
                    <el-option key="2" label="Bank Transfer" :value="2">
                    </el-option>
                    <el-option key="3" label="Visa" :value="3">
                    </el-option>
                  </el-select>
                </el-descriptions-item>
                <el-descriptions-item label="Delivery Option">
                  <el-select v-model="order.delivery_method" placeholder="Select">
                    <el-option key="1" label="Standard delivery" :value="1">
                    </el-option>
                    <el-option key="2" label="VIP delivery" :value="2">
                    </el-option>
                  </el-select>
                </el-descriptions-item>
                <el-descriptions-item label="Status">
                  <el-select v-model="order.status" placeholder="Select">
                    <el-option v-for="itemStatus in statusOrder" :key="itemStatus" :label="itemStatus"
                      :value="itemStatus"></el-option>
                  </el-select>
                </el-descriptions-item>
              </el-descriptions>
              <el-descriptions class="margin-top" title="Payment Info" :column="1" v-if="order.payment_method == 3">
                <el-descriptions-item label="Payment code">{{
                  this.order.payment_code
                }}</el-descriptions-item>
              </el-descriptions>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.page.order.index' })"></button>
  </div>
</template>

<script>
import axios from "axios";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";
import Slugify from "../../../../../Core/Assets/js/mixins/Slugify";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import ActiveEditor from "../../../../../Core/Assets/js/mixins/ActiveEditor";
import SingleMedia from "../../../../../Media/Assets/js/components/SingleMedia.vue";
import SingleFileSelector from "../../../../../Media/Assets/js/mixins/SingleFileSelector";
import TagsInput from "../../../../../Tag/Assets/js/components/TagInput.vue";
import Treeselect from "@riophae/vue-treeselect";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";

export default {
  components: {
    FormErrors,
    SingleMedia,
    TagsInput,
    Treeselect,
  },
  mixins: [Slugify, ShortcutHelper, ActiveEditor, SingleFileSelector],
  props: {
    locales: {
      default: null,
      type: Object,
    },
    orderTitle: {
      default: null,
      type: Object,
    },
  },
  data() {
    return {
      order: {},
      orderDetails: [],
      statusOrders: [],
    };
  },
  created() {
    this.getStatusOrder()
    if (this.$route.params.orderId !== undefined) {
      this.fetchOrder();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.order);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          this.$message({
            type: "success",
            message: response.message,
          });
          this.pushRoute({
            name: "admin.shoppingcart.order.index",
          });
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
    onCancel() {
      this.pushRoute({
        name: "admin.shoppingcart.order.index",
      });
    },
    generateSlug(event, locale) {
      this.order[locale].slug = this.slugify(this.order[locale].title);
    },
    fetchOrder() {
      this.loading = true;
      axios
        .get(
          route("api.shoppingcart.order.find", {
            orderId: this.$route.params.orderId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.order = response.data.data;
          this.orderDetails = response.data.data.orderDetails;
        });
    },
    getStatusOrder() {
      this.loading = true;
      axios
        .get(
          route("api.shoppingcart.order.getStatusOrder")
        )
        .then((response) => {
          this.loading = false;
          this.statusOrders = response.data.statusOrders;
        });
    },
    getRoute() {
      if (this.$route.params.orderId !== undefined) {
        return route("api.shoppingcart.order.update", {
          orderId: this.$route.params.orderId,
        });
      }
      return route("api.shoppingcart.order.store");
    },
  },
};
</script>

<style>
.select-tree {
  position: relative;
  width: 100%;
  text-align: left;
  outline: none;
  margin-bottom: 22px;
}

.select-tree p {
  float: none;
  display: inline-block;
  text-align: left;
  padding: 0 0 10px;
  line-height: normal;
  font-size: 14px;
  color: #606266;
  box-sizing: border-box;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
}
</style>
