<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`chainwallets.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.chainwallet.index' }">
          {{ trans("chainwallets.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.chainwallet.create' }">
          {{ trans(`chainwallets.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="chainwallet"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item
                :label="trans('chainwallets.form.blockchain_id')"
                :class="{
                  'el-form-item is-error': form.errors.has('blockchain_id'),
                }"
              >
                <el-select
                  v-model="chainwallet.blockchain_id"
                  placeholder="Select"
                >
                  <el-option
                    v-for="item in blockchains"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
                <div
                  v-if="form.errors.has('blockchain_id')"
                  class="el-form-item__error"
                  v-text="form.errors.first('blockchain_id')"
                ></div>
              </el-form-item>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('chainwallets.form.address')"
                    :class="{
                      'el-form-item is-error': form.errors.has('address'),
                    }"
                  >
                    <el-input v-model="chainwallet.address"></el-input>
                    <div
                      v-if="form.errors.has('address')"
                      class="el-form-item__error"
                      v-text="form.errors.first('address')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row" v-if="showPrivate">
                <div class="col-md-12">
                  <el-form-item
                    :label="trans('chainwallets.form.private_key')"
                    :class="{
                      'el-form-item is-error': form.errors.has('private_key'),
                    }"
                  >
                    <el-input v-model="chainwallet.private_key"></el-input>
                    <div
                      v-if="form.errors.has('private_key')"
                      class="el-form-item__error"
                      v-text="form.errors.first('private_key')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <el-form-item
                :label="trans('chainwallets.form.using')"
                :class="{
                  'el-form-item is-error': form.errors.has('using'),
                }"
              >
                <el-switch
                  v-model="chainwallet.using"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch>
                <div
                  v-if="form.errors.has('using')"
                  class="el-form-item__error"
                  v-text="form.errors.first('using')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('chainwallets.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="chainwallet.status"
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
              <el-form-item>
                <el-button
                  :loading="loading"
                  type="primary"
                  @click="onSubmit()"
                >
                  {{ trans("core.save") }}
                </el-button>
                <el-button @click="onCancel()">
                  {{ trans("core.button.cancel") }}
                </el-button>
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button
      v-show="false"
      v-shortkey="['b']"
      @shortkey="pushRoute({ name: 'admin.post.chainwallet.index' })"
    ></button>
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
    postTitle: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      chainwallet: {
        blockchain_id: "",
        address: "",
        private_key: "",
        using: false,
        status: true,
      },
      blockchains: [],
      form: new Form(),
      loading: false,
      showPrivate: true,
    };
  },
  created() {
    this.fetchBlockchain();
    if (this.$route.params.chainwalletId !== undefined) {
      this.fetchChainwallet();
      this.showPrivate = false;
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    fetchBlockchain() {
      axios.get(route("api.wallet.blockchain.all")).then((response) => {
        this.blockchains = response.data.data;
      });
    },
    onSubmit() {
      this.form = new Form(this.chainwallet);
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
            name: "admin.wallet.chainwallet.index",
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
        name: "admin.wallet.chainwallet.index",
      });
    },
    fetchChainwallet() {
      this.loading = true;
      axios
        .get(
          route("api.wallet.chainwallet.find", {
            chainwalletId: this.$route.params.chainwalletId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.chainwallet = response.data.data;
        });
    },
    getRoute() {
      if (this.$route.params.chainwalletId !== undefined) {
        return route("api.wallet.chainwallet.update", {
          chainwallet: this.$route.params.chainwalletId,
        });
      }
      return route("api.wallet.chainwallet.store");
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
