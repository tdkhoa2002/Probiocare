<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`affiliates.title.${postTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.affiliate.index' }">
          {{ trans("affiliates.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.wallet.affiliate.create' }">
          {{ trans(`affiliates.title.${postTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form
      ref="form"
      :model="affiliate"
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
                    :label="trans('affiliates.form.commission')"
                    :class="{
                      'el-form-item is-error': form.errors.has('commission'),
                    }"
                  >
                    <el-input-number v-model="affiliate.commission" :min="0"></el-input-number>
                    <div
                      v-if="form.errors.has('commission')"
                      class="el-form-item__error"
                      v-text="form.errors.first('commission')"
                    ></div>
                  </el-form-item>
                </div>
                <div class="col-lg-6">
                <el-form-item
                  :label="trans('affiliates.form.commission_type')"
                  :class="{
                    'el-form-item is-error': form.errors.has('commission_type'),
                  }"
                >
                  <el-select v-model="affiliate.commission_type" placeholder="Select">
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
              </div>
              <el-form-item
                :label="trans('affiliates.form.type')"
                :class="{
                  'el-form-item is-error': form.errors.has('type'),
                }"
              >
                <el-select v-model="affiliate.type" placeholder="Select">
                  <el-option :key="index" :label="type" :value="type" v-for="(type,index) in types"></el-option>
                </el-select>
                <div
                  v-if="form.errors.has('type')"
                  class="el-form-item__error"
                  v-text="form.errors.first('type')"
                ></div>
              </el-form-item>
              <el-form-item
                :label="trans('affiliates.form.status')"
                :class="{
                  'el-form-item is-error': form.errors.has('status'),
                }"
              >
                <el-switch
                  v-model="affiliate.status"
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
      @shortkey="pushRoute({ name: 'admin.post.affiliate.index' })"
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
      affiliate: {
        commission: 0,
        commission_type: 0,
        type: "",
        status: true,
      },
      form: new Form(),
      loading: false,
      types:[]
    };
  },
  created() {
    this.fetchTypeAffiliate()
    if (this.$route.params.affiliateId !== undefined) {
      this.fetchaffiliate();
    }
  },
  mounted() {},
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.affiliate);
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
            name: "admin.affiliate.affiliate.index",
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
        name: "admin.affiliate.affiliate.index",
      });
    },
    fetchaffiliate() {
      this.loading = true;
      axios
        .get(
          route("api.affiliate.affiliate.find", {
            affiliateId: this.$route.params.affiliateId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.affiliate = response.data.data;
        });
    },
    fetchTypeAffiliate() {
      axios
        .get(
          route("api.affiliate.affiliate.getTypeAffiliate")
        )
        .then((response) => {
         this.types= response.data.types
        });
    },
    getRoute() {
      if (this.$route.params.affiliateId !== undefined) {
        return route("api.affiliate.affiliate.update", {
          affiliateId: this.$route.params.affiliateId,
        });
      }
      return route("api.affiliate.affiliate.store");
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
