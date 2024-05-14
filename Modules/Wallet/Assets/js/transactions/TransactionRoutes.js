import TransactionTable from "./components/TransactionTable.vue";
import TransactionForm from "./components/TransactionForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/transactions",
    name: "admin.wallet.transaction.index",
    component: TransactionTable,
  },
  {
    path: "/wallet/transactions/create",
    name: "admin.wallet.transaction.create",
    component: TransactionForm,
    props: {
      locales,
      postTitle: "create transaction",
    },
  },
  {
    path: "/wallet/transactions/:transactionId/edit",
    name: "admin.wallet.transaction.edit",
    component: TransactionForm,
    props: {
      locales,
      postTitle: "edit transaction",
    },
  },
];
