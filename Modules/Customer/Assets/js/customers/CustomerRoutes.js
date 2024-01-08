import CustomerTable from "./components/CustomerTable.vue";
import CustomerForm from "./components/CustomerForm.vue";
import CustomerDetail from "./components/CustomerDetail.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/customer/customers",
    name: "admin.customer.customer.index",
    component: CustomerTable,
  },
  {
    path: "/customer/customers/create",
    name: "admin.customer.customer.create",
    component: CustomerForm,
    props: {
      locales,
      postTitle: "create customer",
    },
  },
  {
    path: "/customer/customers/:customerId/edit",
    name: "admin.customer.customer.edit",
    component: CustomerDetail,
    props: {
      locales,
      postTitle: "edit customer",
    },
  },
];
