<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`blockchains.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.blockchain.index' }">
          {{ trans("blockchains.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.blockchain.create' }">
          {{ trans(`blockchains.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="blockchain"
      label-width="120px"
      label-position="top"
      @keydown="form.errors.clear($event.target.name)"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.code')"
                    :class="{
                      'el-form-item is-error': form.errors.has('code'),
                    }"
                  >
                    <el-input v-model="blockchain.code"></el-input>
                    <div
                      v-if="form.errors.has('code')"
                      class="el-form-item__error"
                      v-text="form.errors.first('code')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.title')"
                    :class="{
                      'el-form-item is-error': form.errors.has('title'),
                    }"
                  >
                    <el-input v-model="blockchain.title"></el-input>
                    <div
                      v-if="form.errors.has('title')"
                      class="el-form-item__error"
                      v-text="form.errors.first('title')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.rpc')"
                    :class="{
                      'el-form-item is-error': form.errors.has('rpc'),
                    }"
                  >
                    <el-input v-model="blockchain.rpc"></el-input>
                    <div
                      v-if="form.errors.has('rpc')"
                      class="el-form-item__error"
                      v-text="form.errors.first('rpc')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.scan')"
                    :class="{
                      'el-form-item is-error': form.errors.has('scan'),
                    }"
                  >
                    <el-input v-model="blockchain.scan"></el-input>
                    <div
                      v-if="form.errors.has('scan')"
                      class="el-form-item__error"
                      v-text="form.errors.first('scan')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.native_token')"
                    :class="{
                      'el-form-item is-error': form.errors.has('native_token'),
                    }"
                  >
                    <el-input v-model="blockchain.native_token"></el-input>
                    <div
                      v-if="form.errors.has('native_token')"
                      class="el-form-item__error"
                      v-text="form.errors.first('native_token')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-md-6">
                  <el-form-item
                    :label="trans('blockchains.form.chainid')"
                    :class="{
                      'el-form-item is-error': form.errors.has('chainid'),
                    }"
                  >
                    <el-input-number v-model="blockchain.chainid" :min="0" :max="10"></el-input-number>
                    <div
                      v-if="form.errors.has('chainid')"
                      class="el-form-item__error"
                      v-text="form.errors.first('chainid')"
                    ></div>
                  </el-form-item>
                </div>
              </div>
              <el-form-item
                :label="trans('blockchains.form.type')"
                :class="{
                  'el-form-item is-error': form.errors.has('type'),
                }"
              >
                <el-select v-model="blockchain.type" placeholder="Select">
                  <el-option key="ETHEREUM" label="Ethereum" value="ETHEREUM"></el-option>
                </el-select>
                <div
                  v-if="form.errors.has('type')"
                  class="el-form-item__error"
                  v-text="form.errors.first('type')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('blockchains.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="blockchain.status"
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
      @shortkey="pushRoute({ name: 'admin.post.blockchain.index' })"
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
      blockchain: {
        code: "",
        title: "",
        rpc: "",
        scan: "",
        native_token: "",
        type: "",
        chainid: "",
        status: true,
      },
      form: new Form(),
      loading: false,
    };
  },
  created() {
    if (this.$route.params.blockchainId !== undefined) {
      this.fetchBlockchain();
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.blockchain);
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
            name: "admin.wallet.blockchain.index",
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
        name: "admin.wallet.blockchain.index",
      });
    },
    fetchBlockchain() {
      this.loading = true;
      axios
        .get(
          route("api.wallet.blockchain.find", {
            blockchainId: this.$route.params.blockchainId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.blockchain = response.data.data;
        });
    },
    getRoute() {
      if (this.$route.params.blockchainId !== undefined) {
        return route("api.wallet.blockchain.update", {
          blockchain: this.$route.params.blockchainId,
        });
      }
      return route("api.wallet.blockchain.store");
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
