import MarketTable from "./components/MarketTable.vue";
import MarketForm from "./components/MarketForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/trade/markets",
    name: "admin.trade.market.index",
    component: MarketTable,
  },
  {
    path: "/trade/markets/create",
    name: "admin.trade.market.create",
    component: MarketForm,
    props: {
      locales,
      postTitle: "create market",
    },
  },
  {
    path: "/trade/markets/:marketId/edit",
    name: "admin.trade.market.edit",
    component: MarketForm,
    props: {
      locales,
      postTitle: "edit market",
    },
  },
];
