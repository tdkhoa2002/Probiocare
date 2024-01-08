require('./bootstrap');
import Vue from "vue";
import helpers from './helpers/helper'
import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
const plugins = {
    install() {
        Vue.helpers = helpers;
        Vue.prototype.$helpers = helpers;
    }
}
Vue.use(plugins);

Vue.component('cryperr-swap', require('./components/cryperrSwap/swap.vue').default);

const app=new Vue({
    el: '#app',
});

