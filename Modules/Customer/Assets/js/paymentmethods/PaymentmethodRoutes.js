import PaymentmethodTable from "./components/PaymentmethodTable.vue";
import PaymentmethodForm from "./components/PaymentmethodForm.vue";
import PaymentmethodFormUpdate from "./components/PaymentmethodFormUpdate.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/customer/paymentmethods",
    name: "admin.customer.paymentmethod.index",
    component: PaymentmethodTable,
  },
  {
    path: "/customer/paymentmethods/create",
    name: "admin.customer.paymentmethod.create",
    component: PaymentmethodForm,
    props: {
      locales,
      paymentmethodTitle: "create paymentmethod",
    },
  },
  {
    path: "/customer/paymentmethods/:paymentmethodId/edit",
    name: "admin.customer.paymentmethod.edit",
    component: PaymentmethodFormUpdate,
    props: {
      locales,
      paymentmethodTitle: "edit paymentmethod",
    },
  },
];
