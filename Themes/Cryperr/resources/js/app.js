require('./bootstrap');
import Vue from "vue";
import helpers from './helpers/helper'
import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Paginate from 'vuejs-paginate'
import VueQrcode from '@chenfengyuan/vue-qrcode';
import FontAwesomeIcon from "./helpers/fontawesome";
import { ValidationProvider } from "vee-validate";
import TranslationHelper from './mixins/TranslationHelper';


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


//profile
Vue.component('change-password', require('./components/profiles/changePassword.vue').default);
Vue.component('request-kyc', require('./components/profiles/requestKyc.vue').default);
Vue.component('VerifyCodeInput', require('./components/VerifyCodeInput.vue').default);
Vue.component('connect-wallet', require('./components/ConnectWallet.vue').default);
Vue.component('form-signin', require('./components/auths/formSignin.vue').default);

//convert
Vue.component('convert-index', require('./components/converts/index.vue').default);

//Loyalties
Vue.component('my-history', require('./components/loyalties/my-history.vue').default);
Vue.mixin(TranslationHelper);
new Vue({
    el: '#app',
});

