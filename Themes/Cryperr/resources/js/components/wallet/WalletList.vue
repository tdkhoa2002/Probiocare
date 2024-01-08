<template>
    <div class="wallet-list">
        <div class="wallet-list-head">
            <div class="table-title">
                Your Asset
            </div>
            <div class="right-action">
                <div class="form-check form-switch form-check-reverse">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckReverse" @click="toggleZeroBalance()">
                    <label class="form-check-label" for="flexSwitchCheckReverse">Hide Small Balance</label>
                </div>
                <div class="field-search input-group px-1">
                    <div class="input-prefix pe-2">
                        <img v-bind:src="getPathImg('images/icons/search.png')" alt="">
                    </div>
                    <input type="text" class="input" v-model="searchCurrency" placeholder="Search Curency">
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Currency</th>
                    <th scope="col">Amount</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(currency, key) in filteredCurrencies" :key="key">
                    <td>
                        <div class="d-flex align-items-center">
                            <img class="me-2" width="32px" height="32px" v-bind:src="currency.icon" alt="" />
                            <div class="d-flex flex-column">
                                <span class="symbol"> {{ currency.code }} </span>
                                <span class="name text-span fs-7"> {{ currency.title }} </span>
                            </div>
                        </div>
                    </td>
                    <td @click="">
                        <div class="d-flex flex-column">
                            <div class="balance">{{ getWalletBalance(currency) }}</div>
                            <div class="price text-span fs-7">${{ getWalletBalance(currency) * currency.usd_rate }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a class="action" :href="'/wallet/deposit?currency=' + currency.code">
                                <img width="24px" class="me-1" v-bind:src="getPathImg('images/icon-deposit.png')" alt="">
                                <span class="text">Deposit</span>
                            </a>
                            <a class="action" :href="'/wallet/withdraw?currency=' + currency.code">
                                <img width="24px" class="me-1" v-bind:src="getPathImg('images/icon-withdraw.png')" alt="">
                                <span class="text">Withdraw</span>
                            </a>
                            <a class="action" :href="'/trade/pairs?currency=' + currency.code">
                                <img width="24px" class="me-1" v-bind:src="getPathImg('images/icon-trade.png')" alt="">
                                <span class="text">Trade</span>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";

export default {
    props: {
        wallets: {
            default: null
        }
    },
    mixins: [GetPathImg],
    created() {
        this.getCurrencies();
    },
    data() {
        return {
            searchCurrency: "",
            showZeroBalance: false,
            currencies: [],
        };
    },
    computed: {
        filteredCurrencies() {
            const term = this.searchCurrency.toLowerCase();
            return this.sortedCurrencies.filter(
            currency =>
                currency.code.toLowerCase().includes(term) ||
                currency.title.toLowerCase().includes(term)
            );
        },
        filteredWallets() {
            return this.wallets;
        },
        sortedCurrencies() {
            const combinedCurrencies = this.currencies.map(currency => {
                const wallet = this.filteredWallets.find(wallet => wallet.currency_id === currency.id);
                return {
                    ...currency,
                    wallet: wallet || null,
                };
            });
            const sorted = combinedCurrencies.sort((a, b) => {
                if (a.wallet && !b.wallet) return -1;
                if (!a.wallet && b.wallet) return 1;
                return 0;
            });
            if (this.showZeroBalance) {
                return sorted.filter(currency => this.getWalletBalance(currency) > 0);
            }
            return sorted;
        }
    },
    methods: {
        getWalletBalance(currency) {
            const wallet = this.filteredWallets.find(wallet => wallet.currency_id === currency.id);
            return wallet ? wallet.balance : 0;
        },
        handleClick() {
        },
        toggleZeroBalance() {
            this.showZeroBalance = !this.showZeroBalance;
        },
        getCurrencies() {
            Axios.get("/api/public/wallet/currencies/")
                .then((response) => {
                if (response.data.error === false) {
                    this.currencies = response.data.data.currencies;
                }
                })
                .catch((error) => {
                console.log(error);
            });
        },
    },
    mounted() { },
};
</script>
  