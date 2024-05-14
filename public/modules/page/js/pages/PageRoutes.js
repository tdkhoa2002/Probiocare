import PageTable from "./components/PageTable.vue";
import PageForm from "./components/PageForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/page/pages",
    name: "admin.page.page.index",
    component: PageTable,
    props: {
      type: "page",
    },
  },
  {
    path: "/page/pages/create",
    name: "admin.page.page.create",
    component: PageForm,
    props: {
      locales,
      pageTitle: "create page",
      type: "page",
    },
  },
  {
    path: "/page/pages/:pageId/edit",
    name: "admin.page.page.edit",
    component: PageForm,
    props: {
      locales,
      pageTitle: "edit page",
      type: "page",
    },
  },

  {
    path: "/page/posts",
    name: "admin.page.post.index",
    component: PageTable,
    props: {
      type: "post",
    },
  },
  {
    path: "/page/posts/create",
    name: "admin.page.post.create",
    component: PageForm,
    props: {
      locales,
      pageTitle: "create post",
      type: "post",
    },
  },
  {
    path: "/page/posts/:pageId/edit",
    name: "admin.page.post.edit",
    component: PageForm,
    props: {
      locales,
      pageTitle: "edit post",
      type: "post",
    },
  },
];
