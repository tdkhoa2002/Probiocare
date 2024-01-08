import CategoryTable from "./components/CategoryTable.vue";
import CategoryForm from "./components/CategoryForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/category/categories",
    name: "admin.post.category.index",
    component: CategoryTable,
  },
  {
    path: "/category/categories/create",
    name: "admin.post.category.create",
    component: CategoryForm,
    props: {
      locales,
      postTitle: "create category",
    },
  },
  {
    path: "/category/categories/:categoryId/edit",
    name: "admin.post.category.edit",
    component: CategoryForm,
    props: {
      locales,
      postTitle: "edit category",
    },
  },
];
