<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`products.title.${productTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.product.index' }">
          {{ trans("products.title.products") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.product.product.create' }">
          {{ trans(`products.title.${productTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-form ref="form" :model="product" label-width="120px" label-position="top"
      @keydown="form.errors.clear($event.target.name)">
      <form-errors :form="form"></form-errors>
      <div class="row">
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body">
              <el-tabs v-model="activeTab">
                <el-tab-pane v-for="(localeArray, locale) in locales" :key="localeArray.name" :label="localeArray.name"
                  :name="locale">
                  <span slot="label" :class="{ error: form.errors.has(locale) }"><i
                      :class="'flag-icon flag-icon-' + locale"></i> &nbsp;
                    {{ localeArray.name }}</span>
                  <el-form-item :label="trans('products.form.title')" :class="{
                    'el-form-item is-error': form.errors.has(
                      locale + '.title'
                    ),
                  }">
                    <el-input v-model="product[locale].title" @input="generateSlug($event, locale)"></el-input>
                    <div v-if="form.errors.has(locale + '.title')" class="el-form-item__error"
                      v-text="form.errors.first(locale + '.title')"></div>
                  </el-form-item>
                  <el-form-item :label="trans('products.form.slug')" :class="{
                    'el-form-item is-error': form.errors.has(
                      locale + '.slug'
                    ),
                  }">
                    <el-input v-model="product[locale].slug">
                      <el-button slot="prepend" @click="generateSlug($event, locale)">Generate</el-button>
                    </el-input>
                    <div v-if="form.errors.has(locale + '.slug')" class="el-form-item__error"
                      v-text="form.errors.first(locale + '.slug')"></div>
                  </el-form-item>
                  <el-form-item :label="trans('products.form.sumary')" :class="{
                    'el-form-item is-error': form.errors.has(
                      locale + '.sumary'
                    ),
                  }">
                    <el-input v-model="product[locale].sumary" type="textarea" rows="4"></el-input>
                    <div v-if="form.errors.has(locale + '.sumary')" class="el-form-item__error"
                      v-text="form.errors.first(locale + '.sumary')"></div>
                  </el-form-item>
                  <el-form-item :label="trans('products.form.product_info')" :class="{
                    'el-form-item is-error': form.errors.has(
                      locale + '.product_info'
                    ),
                  }">
                    <component :is="getCurrentEditor()" v-model="product[locale].product_info"
                      :value="product[locale].product_info"></component>
                    <div v-if="form.errors.has(locale + '.product_info')" class="el-form-item__error"
                      v-text="form.errors.first(locale + '.product_info')"></div>
                  </el-form-item>
                  <div class="panel box box-primary">
                    <div class="box-header">
                      <h4 class="box-title">
                        <a :href="`#collapseMeta-${locale}`" class="collapsed" data-toggle="collapse"
                          data-parent="#accordion">
                          {{ trans("core.form.meta_data") }}
                        </a>
                      </h4>
                    </div>
                    <div :id="`collapseMeta-${locale}`" style="height: 0" class="panel-collapse collapse">
                      <div class="box-body">
                        <el-form-item :label="trans('core.form.meta_title')">
                          <el-input v-model="product[locale].meta_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('core.form.meta_description')">
                          <el-input v-model="product[locale].meta_description" type="textarea" autosize maxlength="186"
                            :rows="4"></el-input>
                        </el-form-item>
                      </div>
                    </div>
                  </div>

                  <div class="panel box box-primary">
                    <div class="box-header">
                      <h4 class="box-title">
                        <a :href="`#collapseFacebook-${locale}`" class="collapsed" data-toggle="collapse"
                          data-parent="#accordion">
                          {{ trans("core.form.facebook_data") }}
                        </a>
                      </h4>
                    </div>
                    <div :id="`collapseFacebook-${locale}`" style="height: 0" class="panel-collapse collapse">
                      <div class="box-body">
                        <el-form-item :label="trans('core.form.og_title')">
                          <el-input v-model="product[locale].og_title"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('core.form.og_description')">
                          <el-input v-model="product[locale].og_description" type="textarea" autosize :rows="4"
                            maxlength="186"></el-input>
                        </el-form-item>
                        <el-form-item :label="trans('core.form.og_type')">
                          <el-select v-model="product[locale].og_type" :placeholder="trans('core.form.og_type')">
                            <el-option :label="trans('core.facebook-types.website')" value="website"></el-option>
                            <el-option :label="trans('core.facebook-types.product')" value="product"></el-option>
                            <el-option :label="trans('core.facebook-types.article')" value="article"></el-option>
                          </el-select>
                        </el-form-item>
                      </div>
                    </div>
                  </div>

                  <el-form-item>
                    <el-button :loading="loading" type="primary" @click="onSubmit()">
                      {{ trans("core.save") }}
                    </el-button>
                    <el-button @click="onCancel()">
                      {{ trans("core.button.cancel") }}
                    </el-button>
                  </el-form-item>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body">
              <el-form-item :label="trans('products.form.total_sold')" :class="{
                'el-form-item is-error': form.errors.has('total_sold'),
              }">
                <el-input-number v-model="product.total_sold" :min="0"></el-input-number>
                <div v-if="form.errors.has('total_sold')" class="el-form-item__error"
                  v-text="form.errors.first('total_sold')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.code')" :class="{
                'el-form-item is-error': form.errors.has('code'),
              }">
                <el-input v-model="product.code"></el-input>
                <div v-if="form.errors.has('code')" class="el-form-item__error" v-text="form.errors.first('code')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.category')" :class="{
                'el-form-item is-error': form.errors.has('category_id'),
              }">
                <el-select v-model="product.category_id" placeholder="Select">
                  <el-option v-for="item in categories" :key="item.id" :label="item.title" :value="item.id">
                  </el-option>
                </el-select>
                <div v-if="form.errors.has('category_id')" class="el-form-item__error"
                  v-text="form.errors.first('category_id')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.product_status')" :class="{
                'el-form-item is-error': form.errors.has('product_status'),
              }">
                <el-select v-model="product.product_status" placeholder="Select">
                  <el-option :key="1" label="Order" :value="1"></el-option>
                  <el-option :key="2" label="Stocking" :value="2"></el-option>
                  <el-option :key="3" label="Out Of Stock" :value="3"></el-option>
                </el-select>
                <div v-if="form.errors.has('product_status')" class="el-form-item__error"
                  v-text="form.errors.first('product_status')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.price')" :class="{
                'el-form-item is-error': form.errors.has('price'),
              }">
                <el-input-number v-model="product.price" :min="0"></el-input-number>
                <div v-if="form.errors.has('price')" class="el-form-item__error" v-text="form.errors.first('price')">
                </div>
              </el-form-item>
              <el-form-item :label="trans('products.form.price_member')" :class="{
                'el-form-item is-error': form.errors.has('price_member'),
              }">
                <el-input-number v-model="product.price_member" :min="0"></el-input-number>
                <div v-if="form.errors.has('price_member')" class="el-form-item__error" v-text="form.errors.first('price_member')">
                </div>
              </el-form-item>
              <el-form-item :label="trans('products.form.price_sale')" :class="{
                'el-form-item is-error': form.errors.has('price_sale'),
              }">
                <el-input-number v-model="product.price_sale" :min="0"></el-input-number>
                <div v-if="form.errors.has('price_sale')" class="el-form-item__error"
                  v-text="form.errors.first('price_sale')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.status')" :class="{
                'el-form-item is-error': form.errors.has('status'),
              }">
                <el-switch v-model="product.status" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('status')" class="el-form-item__error" v-text="form.errors.first('status')">
                </div>
              </el-form-item>
              <el-form-item :label="trans('products.form.show_homepage')" :class="{
                'el-form-item is-error': form.errors.has('show_homepage'),
              }">
                <el-switch v-model="product.show_homepage" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('show_homepage')" class="el-form-item__error"
                  v-text="form.errors.first('show_homepage')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.is_best_selling')" :class="{
                'el-form-item is-error': form.errors.has('is_best_selling'),
              }">
                <el-switch v-model="product.is_best_selling" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('is_best_selling')" class="el-form-item__error"
                  v-text="form.errors.first('is_best_selling')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.is_promotion')" :class="{
                'el-form-item is-error': form.errors.has('is_promotion'),
              }">
                <el-switch v-model="product.is_promotion" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('is_promotion')" class="el-form-item__error"
                  v-text="form.errors.first('is_promotion')"></div>
              </el-form-item>
              <el-form-item :label="trans('products.form.is_new_arrivals')" :class="{
                'el-form-item is-error': form.errors.has('is_new_arrivals'),
              }">
                <el-switch v-model="product.is_new_arrivals" active-color="#13ce66" inactive-color="#ff4949">
                </el-switch>
                <div v-if="form.errors.has('is_new_arrivals')" class="el-form-item__error"
                  v-text="form.errors.first('is_new_arrivals')"></div>
              </el-form-item>
              <single-media :entity-id="product.id" zone="avatar" entity="Modules\Product\Entities\Product"
                @single-file-selected="selectSingleFile($event, 'product')"></single-media>
              <br />
              <multiple-media zone="slider_product" @multiple-file-selected="selectMultipleFile($event, 'product')"
                @file-unselected="unselectFile($event, 'product')" entity="Modules\Product\Entities\Product"
                :entity-id="product.id"></multiple-media>
            </div>
          </div>
        </div>
      </div>
    </el-form>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.page.product.index' })"></button>
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
import MultipleMedia from "../../../../../Media/Assets/js/components/MultipleMedia.vue";
import SingleFileSelector from "../../../../../Media/Assets/js/mixins/SingleFileSelector";
import MultipleFileSelector from "../../../../../Media/Assets/js/mixins/MultipleFileSelector";
import TagsInput from "../../../../../Tag/Assets/js/components/TagInput.vue";
import Treeselect from "@riophae/vue-treeselect";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";

export default {
  components: {
    FormErrors,
    SingleMedia,
    MultipleMedia,
    TagsInput,
    Treeselect,
  },
  mixins: [
    Slugify,
    ShortcutHelper,
    ActiveEditor,
    SingleFileSelector,
    MultipleFileSelector,
  ],
  props: {
    locales: {
      default: null,
      type: Object,
    },
    productTitle: {
      default: null,
      type: Object,
    },
  },
  data() {
    return {
      product: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
            slug: "",
            body: "",
            sumary: "",
            product_info: "",
            video: "",
            specifications: "",
            meta_title: "",
            meta_description: "",
            og_title: "",
            og_description: "",
            og_type: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          status: true,
          show_homepage: false,
          category_id: null,
          is_best_selling: false,
          is_new_arrivals: false,
          is_best_choice: false,
          is_promotion: false,
          product_status: 1,
          price: 0,
          total_sold: 0,
          code: "",
          price_sale: 0,
          price_member: 0,
        })
        .value(),
      categories: [],
      form: new Form(),
      loading: false,
      activeTab: window.AsgardCMS.currentLocale || "en",
    };
  },
  created() {
    this.fetchCategory();
    if (this.$route.params.productId !== undefined) {
      this.fetchProduct();
    }
  },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.product);
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
            name: "admin.product.product.index",
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
        name: "admin.product.product.index",
      });
    },
    generateSlug(event, locale) {
      this.product[locale].slug = this.slugify(this.product[locale].title);
    },
    fetchCategory() {
      this.loading = true;
      axios.get(route("api.product.category.all")).then((response) => {
        this.loading = false;
        this.categories = response.data.data;
      });
    },
    fetchProduct() {
      this.loading = true;
      axios
        .get(
          route("api.product.product.find", {
            productId: this.$route.params.productId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.product = response.data.data;
        });
    },
    getRoute() {
      if (this.$route.params.productId !== undefined) {
        return route("api.product.product.update", {
          productId: this.$route.params.productId,
        });
      }
      return route("api.product.product.store");
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
