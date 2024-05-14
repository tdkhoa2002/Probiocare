import OrderTable from "./components/OrderTable.vue";
import OrderDetail from "./components/OrderDetail.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/staking/orders",
    name: "admin.staking.order.index",
    component: OrderTable,
  },
  {
    path: "/staking/orders/:orderId/detail",
    name: "admin.staking.order.detail",
    component: OrderDetail,
    props: {
      locales,
      orderTitle: "order detail",
    },
  },
];
