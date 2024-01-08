import WalletTable from "./components/WalletTable.vue";
import WalletForm from "./components/WalletForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/wallets",
    name: "admin.wallet.wallet.index",
    component: WalletTable,
  },
  {
    path: "/wallet/wallets/:walletId/edit",
    name: "admin.wallet.wallet.edit",
    component: WalletForm,
    props: {
      locales,
      postTitle: "edit wallet",
    },
  },
];
