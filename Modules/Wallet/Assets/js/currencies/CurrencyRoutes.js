import CurrencyTable from "./components/CurrencyTable.vue";
import CurrencyForm from "./components/CurrencyForm.vue";
import CurrencyFormUpdate from "./components/CurrencyFormUpdate.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/currencies",
    name: "admin.wallet.currency.index",
    component: CurrencyTable,
  },
  {
    path: "/wallet/currencies/create",
    name: "admin.wallet.currency.create",
    component: CurrencyForm,
    props: {
      locales,
      postTitle: "create currency",
    },
  },
  {
    path: "/wallet/currencies/:currencyId/edit",
    name: "admin.wallet.currency.edit",
    component: CurrencyFormUpdate,
    props: {
      locales,
      postTitle: "edit currency",
    },
  },
];
