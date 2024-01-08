require('./bootstrap');
import Vue from "vue";
import helpers from './helpers/helper'
import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Paginate from 'vuejs-paginate'
import VueQrcode from '@chenfengyuan/vue-qrcode';
import FontAwesomeIcon from "./helpers/fontawesome";
import { ValidationProvider } from "vee-validate";

Vue.use(BootstrapVue)

const plugins = {
    install() {
        Vue.helpers = helpers;
        Vue.prototype.$helpers = helpers;
    }
}


Vue.component(VueQrcode.name, VueQrcode);
Vue.use(plugins);
Vue.component('paginate', Paginate)
Vue.component("font-awesome-icon", FontAwesomeIcon);
Vue.component("ValidationProvider", ValidationProvider);

// Wallets
Vue.component('wallet-get-address', require('./components/wallet/WalletGetAddress.vue').default);
Vue.component('withdraw', require('./components/wallet/Withdraw.vue').default);
Vue.component('currencies-list', require('./components/wallet/currencies.vue').default);
Vue.component('wallet-list', require('./components/wallet/WalletList.vue').default);

//staking
Vue.component('form-staking', require('./components/staking/form-staking.vue').default);
Vue.component('staking-list', require('./components/staking/staking-list.vue').default);
Vue.component('list-my-staking', require('./components/staking/my-staking.vue').default);

// spot-trade/
Vue.component('trading-pair-detail', require('./components/spot-trade/trading-pair-detail.vue').default);
Vue.component('trading-pair-list', require('./components/spot-trade/trading-pair-list.vue').default);
Vue.component('trading-pair-pair-info', require('./components/spot-trade/trading-pair-pair-info.vue').default);
Vue.component('trading-pair-market-list', require('./components/spot-trade/trading-pair-market-list.vue').default);
Vue.component('trading-pair-trade-history', require('./components/spot-trade/trading-pair-trade-history.vue').default);
Vue.component('trading-pair-chart', require('./components/spot-trade/trading-pair-chart.vue').default);
Vue.component('trading-pair-my-trade', require('./components/spot-trade/trading-pair-my-trade.vue').default);
Vue.component('trading-pair-bid', require('./components/spot-trade/trading-pair-bid.vue').default);
Vue.component('trading-pair-ask', require('./components/spot-trade/trading-pair-ask.vue').default);
Vue.component('trading-pair-orderbook', require('./components/spot-trade/trading-pair-orderbook.vue').default);

// P2P
Vue.component('p2p-all-market-ads', require('./components/p2p/p2p-all-market-ads.vue').default);
Vue.component('create-payment-method', require('./components/p2p/paymentMethods/create.vue').default);
Vue.component('update-payment-method', require('./components/p2p/paymentMethods/update.vue').default);
Vue.component('list-my-payment-method', require('./components/p2p/paymentMethods/list.vue').default);
Vue.component('create-ads', require('./components/p2p/ads/create.vue').default);
Vue.component('update-ads', require('./components/p2p/ads/update.vue').default);
Vue.component('list-my-ads', require('./components/p2p/ads/my-ads.vue').default);
Vue.component('create-order-buy', require('./components/p2p/orders/create-buy.vue').default);
Vue.component('create-order-sell', require('./components/p2p/orders/create-sell.vue').default);
Vue.component('p2p-my-orders', require('./components/p2p/orders/p2p-my-orders.vue').default);
Vue.component('my-order-buy-detail', require('./components/p2p/orders/my-order-buy-detail.vue').default);
Vue.component('my-order-sell-detail', require('./components/p2p/orders/my-order-sell-detail.vue').default);
Vue.component('p2p-report-total', require('./components/p2p/p2p-report-total.vue').default);
Vue.component('p2p-chat-box', require('./components/p2p/p2p-chat-box.vue').default);

Vue.component('list-agent-order', require('./components/p2p/agents/agent-orders.vue').default);
Vue.component('agent-order-sell-detail', require('./components/p2p/agents/agent-order-sell-detail.vue').default);
Vue.component('agent-order-buy-detail', require('./components/p2p/agents/agent-order-buy-detail.vue').default);

//profile
Vue.component('change-password', require('./components/profiles/changePassword.vue').default);
Vue.component('request-kyc', require('./components/profiles/requestKyc.vue').default);
Vue.component('VerifyCodeInput', require('./components/VerifyCodeInput.vue').default);
Vue.component('form-signin', require('./components/auths/formSignin.vue').default);


//convert
Vue.component('convert-index', require('./components/converts/index.vue').default);

new Vue({
    el: '#app',
});

