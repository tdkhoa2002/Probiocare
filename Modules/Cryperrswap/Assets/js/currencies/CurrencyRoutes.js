import CurrencyTable from "./components/CurrencyTable.vue";
import CurrencyForm from "./components/CurrencyForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/cryperrswap/currencies",
    name: "admin.cryperrswap.currency.index",
    component: CurrencyTable,
  },
  {
    path: "/cryperrswap/currencies/create",
    name: "admin.cryperrswap.currency.create",
    component: CurrencyForm,
    props: {
      locales,
      postTitle: "create currency",
    },
  },
  {
    path: "/cryperrswap/currencies/:currencyId/edit",
    name: "admin.cryperrswap.currency.edit",
    component: CurrencyForm,
    props: {
      locales,
      postTitle: "edit currency",
    },
  },
];
