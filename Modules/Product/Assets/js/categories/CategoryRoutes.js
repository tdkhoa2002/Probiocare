import CategoryTable from "./components/CategoryTable.vue";
import CategoryForm from "./components/CategoryForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/product/categories",
    name: "admin.product.category.index",
    component: CategoryTable,
  },
  {
    path: "/product/categories/create",
    name: "admin.product.category.create",
    component: CategoryForm,
    props: {
      locales,
      categoryTitle: "create category",
    },
  },
  {
    path: "/product/categories/:categoryId/edit",
    name: "admin.product.category.edit",
    component: CategoryForm,
    props: {
      locales,
      categoryTitle: "edit category",
    },
  },
];
