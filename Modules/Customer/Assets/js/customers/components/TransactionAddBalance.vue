<template>
    <div class="div">
        <div class="content-header">
            <h1>
                {{ trans(`transactions.title.${postTitle}`) }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/backend">Home</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{ name: 'admin.wallet.transaction.index' }">
                    {{ trans("transactions.list resource") }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{ name: 'admin.wallet.transaction.create' }">
                    {{ trans(`transactions.title.${postTitle}`) }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form ref="form" :model="transaction" label-width="120px" label-position="top"
            @keydown="form.errors.clear($event.target.name)">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <el-form-item :label="trans('transactions.form.currency_id')" :class="{
                                        'el-form-item is-error': form.errors.has('currency_id'),
                                    }">
                                        <el-select v-model="transaction.currency_id" placeholder="Select currency">
                                            <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                                                :value="item.id"></el-option>
                                        </el-select>
                                        <div v-if="form.errors.has('currency_id')" class="el-form-item__error"
                                            v-text="form.errors.first('currency_id')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-2">
                                    <el-form-item :label="trans('transactions.form.action')" :class="{
                                        'el-form-item is-error': form.errors.has('action'),
                                    }">
                                        <el-select v-model="transaction.action" placeholder="Select action">
                                            <el-option value='DEPOSIT'>DEPOSIT</el-option>
                                            <!-- <el-option value='WITHDRAW'>WITHDRAW</el-option> -->
                                        </el-select>
                                        <div v-if="form.errors.has('action')" class="el-form-item__error"
                                            v-text="form.errors.first('action')"></div>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <el-form-item :label="trans('transactions.form.amount')" :class="{
                                        'el-form-item is-error': form.errors.has('amount'),
                                    }">
                                        <el-input-number v-model="transaction.amount" :min="0"></el-input-number>
                                        <div v-if="form.errors.has('amount')" class="el-form-item__error"
                                            v-text="form.errors.first('amount')"></div>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <el-form-item :label="trans('transactions.form.note')" :class="{
                                        'el-form-item is-error': form.errors.has('note'),
                                    }">
                                        <el-input v-model="transaction.note" autosize type="textarea"
                                            placeholder="Input note"></el-input>
                                        <div v-if="form.errors.has('note')" class="el-form-item__error"
                                            v-text="form.errors.first('note')"></div>
                                    </el-form-item>
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
                        </div>
                    </div>
                </div>
            </div>
        </el-form>
        <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.post.transaction.index' })"></button>
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
            transaction: {
                customer_id: "",
                currency_id: "",
                blockchain_id: null,
                action: '',
                amount: "",
                note: ""
            },
            form: new Form(),
            loading: false,
            currencies: [],
            customers: []
        };
    },
    created() {

    },
    mounted() {
        this.fetchCurrencies();
    },
    destroyed() {
        $(".publicUrl").hide();
    },
    methods: {
        onSubmit() {
            this.form = new Form(this.transaction);
            this.loading = true;
            this.form
                .post(this.getRoute())
                .then((response) => {
                    console.log(response);
                    this.loading = false;
                    if(response.error == false) {
                        this.$message({
                            type: "success",
                            message: response.data,
                        });
                    } else {
                        this.$message({
                            type: "error",
                            message: response.message,
                        });
                    }
                    this.pushRoute({
                        name: "admin.customer.customer.index",
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
                name: "admin.customer.transaction.index",
            });
        },
        fetchCurrencies() {
            axios.get(route("api.wallet.currency.all")).then((response) => {
                this.currencies = response.data.data;
            });
        },
        remoteCustomerMethod(query) {
            if (query != "" && query.length > 3) {
                axios
                    .get(route("api.customer.customer.allwithfilter", { query }))
                    .then((response) => {
                        this.customers = response.data.data;
                    });
            }
        },
        getRoute() {
            return route("api.customer.transaction.deposit", {
                customer: this.$route.params.customerId
            });
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
  