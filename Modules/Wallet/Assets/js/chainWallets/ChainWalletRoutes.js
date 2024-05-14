import ChainWalletTable from "./components/ChainWalletTable.vue";
import ChainWalletForm from "./components/ChainWalletForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/chainwallets",
    name: "admin.wallet.chainwallet.index",
    component: ChainWalletTable,
  },
  {
    path: "/wallet/chainwallets/create",
    name: "admin.wallet.chainwallet.create",
    component: ChainWalletForm,
    props: {
      locales,
      postTitle: "create chainwallet",
    },
  },
  {
    path: "/wallet/chainwallets/:chainwalletId/edit",
    name: "admin.wallet.chainwallet.edit",
    component: ChainWalletForm,
    props: {
      locales,
      postTitle: "edit chainwallet",
    },
  },
];
