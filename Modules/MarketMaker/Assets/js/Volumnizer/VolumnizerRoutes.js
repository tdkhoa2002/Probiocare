import VolumnizerForm from "./components/VolumnizerForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/marketmaker/volumnizers",
    name: "admin.marketmaker.volumnizer.index",
    component: VolumnizerForm,
    props: {
      locales,
      postTitle: "create volumnizer",
    },
  },
  {
    path: "/marketmaker/volumnizers/create",
    name: "admin.marketmaker.volumnizer.create",
    component: VolumnizerForm,
    props: {
      locales,
      postTitle: "create volumnizer",
    },
  },
  {
    path: "/marketmaker/volumnizers/:volumnizerId/edit",
    name: "admin.marketmaker.volumnizer.edit",
    component: VolumnizerForm,
    props: {
      locales,
      postTitle: "edit volumnizer",
    },
  },
];
