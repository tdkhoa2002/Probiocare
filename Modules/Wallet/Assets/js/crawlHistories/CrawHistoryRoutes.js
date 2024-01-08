import CrawHistoryTable from "./components/CrawHistoryTable.vue";
const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/crawlhistories",
    name: "admin.wallet.crawlhistory.index",
    component: CrawHistoryTable,
  },
];
