import OrderTable from "./components/OrderTable.vue";
import OrderForm from "./components/OrderForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/shoppingcart/orders",
    name: "admin.shoppingcart.order.index",
    component: OrderTable,
  },
  {
    path: "/shoppingcart/orders/:orderId/edit",
    name: "admin.shoppingcart.order.edit",
    component: OrderForm,
    props: {
      locales,
      orderTitle: "edit order",
    },
  },
];
