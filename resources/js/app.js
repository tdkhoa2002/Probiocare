require("./bootstrap");

import "@babel/polyfill";
import Vue from "vue";
import VueI18n from "vue-i18n";
import VueRouter from "vue-router";
import ElementUI from "element-ui";
import VueEvents from "vue-events";
import locale from "element-ui/lib/locale/lang/en";
import MediaRoutes from "../../Modules/Media/Assets/js/MediaRoutes";
import UserRoutes from "../../Modules/User/Assets/js/UserRoutes";

import CustomerRoutes from "../../Modules/Customer/Assets/js/customers/CustomerRoutes";
import PaymentmethodRoutes from "../../Modules/Customer/Assets/js/paymentmethods/PaymentmethodRoutes";

import BlockchainRoutes from "../../Modules/Wallet/Assets/js/blockchains/BlockchainRoutes";
import CrawHistoryRoutes from "../../Modules/Wallet/Assets/js/crawlHistories/CrawHistoryRoutes";
import ChainWalletRoutes from "../../Modules/Wallet/Assets/js/chainWallets/ChainWalletRoutes";
import TransactionRoutes from "../../Modules/Wallet/Assets/js/transactions/TransactionRoutes";
import WalletRoutes from "../../Modules/Wallet/Assets/js/wallets/WalletRoutes";
import CurrencyWalletRoutes from "../../Modules/Wallet/Assets/js/currencies/CurrencyRoutes";

import MarketRoutes from "../../Modules/Trade/Assets/js/markets/MarketRoutes";
import TradeRoutes from "../../Modules/Trade/Assets/js/trades/TradeRoutes";

import PackageRoutes from "../../Modules/Staking/Assets/js/packages/PackageRoutes";
import OrderRoutes from "../../Modules/Staking/Assets/js/orders/OrderRoutes";

import PackageRoutesLoyalty from "../../Modules/Loyalty/Assets/js/packages/PackageRoutes";
import OrderRoutesLoyalty from "../../Modules/Loyalty/Assets/js/orders/OrderRoutes";

import AffiliateRoutes from "../../Modules/Affiliate/Assets/js/affiliates/AffiliateRoutes";

import CategoryRoutes from "../../Modules/Product/Assets/js/categories/CategoryRoutes";
import ProductRoutes from "../../Modules/Product/Assets/js/products/ProductRoutes";
import OrderShoppingCartRoutes from "../../Modules/ShoppingCart/Assets/js/orders/OrderRoutes";

Vue.use(ElementUI, { locale });
Vue.use(VueI18n);
Vue.use(VueRouter);
Vue.use(require("vue-shortkey"), { prevent: ["input", "textarea"] });

Vue.use(VueEvents);
require("./mixins");

Vue.component("ckeditor", require("../../Modules/Core/Assets/js/components/CkEditor.vue").default);

const { currentLocale, adminPrefix } = window.AsgardCMS;

function makeBaseUrl() {
  if (window.AsgardCMS.hideDefaultLocaleInURL === "1") {
    return adminPrefix;
  }
  return `${currentLocale}/${adminPrefix}`;
}

const router = new VueRouter({
  mode: "history",
  base: makeBaseUrl(),
  routes: [
    ...MediaRoutes, ...UserRoutes, ...CustomerRoutes,
    ...CrawHistoryRoutes,
    ...BlockchainRoutes, ...ChainWalletRoutes, ...CurrencyWalletRoutes, ...MarketRoutes,
    ...PackageRoutes, 
    ...TransactionRoutes, 
    ...OrderRoutes, 
    ...WalletRoutes, ...TradeRoutes,
    ...PaymentmethodRoutes,
    ...AffiliateRoutes,
    ...CategoryRoutes,
    ...ProductRoutes,
    ...OrderShoppingCartRoutes,
    ...PackageRoutesLoyalty,
    ...OrderRoutesLoyalty]
}),
  messages = {
    [currentLocale]: window.AsgardCMS.translations,
  },
  i18n = new VueI18n({
    locale: currentLocale,
    messages,
  }),
  app = new Vue({
    el: "#app",
    router,
    i18n,
  });

window.axios.interceptors.response.use(null, (error) => {
  console.log(error);
  if (error.response === undefined) {
    console.log(error);
    return;
  }
  if (error.response.status === 403) {
    app.$notify.error({
      title: app.$t("core.unauthorized"),
      message: app.$t("core.unauthorized-access"),
    });
    window.location = route("dashboard.index");
  }
  if (error.response.status === 401) {
    app.$notify.error({
      title: app.$t("core.unauthenticated"),
      message: app.$t("core.unauthenticated-message"),
    });
    window.location = route("login");
  }
  return Promise.reject(error);
});
