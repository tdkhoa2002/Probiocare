import ProductTable from "./components/ProductTable.vue";
import ProductForm from "./components/ProductForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/product/products",
    name: "admin.product.product.index",
    component: ProductTable,
  },
  {
    path: "/product/products/create",
    name: "admin.product.product.create",
    component: ProductForm,
    props: {
      locales,
      productTitle: "create product",
    },
  },
  {
    path: "/product/products/:productId/edit",
    name: "admin.product.product.edit",
    component: ProductForm,
    props: {
      locales,
      productTitle: "edit product",
    },
  },
];
