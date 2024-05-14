import OrderTable from "./components/OrderTable.vue";
import OrderDetail from "./components/OrderDetail.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/loyalty/orders",
    name: "admin.loyalty.order.index",
    component: OrderTable,
  },
  {
    path: "/loyalty/orders/:orderId/detail",
    name: "admin.loyalty.order.detail",
    component: OrderDetail,
    props: {
      locales,
      orderTitle: "order detail",
    },
  },
];
