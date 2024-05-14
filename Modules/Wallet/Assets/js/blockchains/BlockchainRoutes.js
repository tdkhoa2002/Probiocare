import BlockchainTable from "./components/BlockchainTable.vue";
import BlockchainForm from "./components/BlockchainForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/wallet/blockchains",
    name: "admin.wallet.blockchain.index",
    component: BlockchainTable,
  },
  {
    path: "/wallet/blockchains/create",
    name: "admin.wallet.blockchain.create",
    component: BlockchainForm,
    props: {
      locales,
      postTitle: "create blockchain",
    },
  },
  {
    path: "/wallet/blockchains/:blockchainId/edit",
    name: "admin.wallet.blockchain.edit",
    component: BlockchainForm,
    props: {
      locales,
      postTitle: "edit blockchain",
    },
  },
];
