import PostTable from "./components/PostTable.vue";
import PostForm from "./components/PostForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/post/posts",
    name: "admin.post.post.index",
    component: PostTable,
    props: {
      type: "post",
    },
  },
  {
    path: "/post/posts/create",
    name: "admin.post.post.create",
    component: PostForm,
    props: {
      locales,
      postTitle: "create post",
      type: "post",
    },
  },
  {
    path: "/post/posts/:postId/edit",
    name: "admin.post.post.edit",
    component: PostForm,
    props: {
      locales,
      postTitle: "edit post",
      type: "post",
    },
  },
];
