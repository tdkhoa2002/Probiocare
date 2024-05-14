import TradeTable from "./components/TradeTable.vue";
import TradeForm from "./components/TradeForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/trade/trades",
    name: "admin.trade.trade.index",
    component: TradeTable,
  },
  {
    path: "/trade/trades/create",
    name: "admin.trade.trade.create",
    component: TradeForm,
    props: {
      locales,
      postTitle: "create trade",
    },
  },
  {
    path: "/trade/trades/:tradeId/edit",
    name: "admin.trade.trade.edit",
    component: TradeForm,
    props: {
      locales,
      postTitle: "edit trade",
    },
  },
];
