import ServiceTable from "./components/ServiceTable.vue";
import ServiceForm from "./components/ServiceForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/cryperrswap/services",
    name: "admin.cryperrswap.service.index",
    component: ServiceTable,
  },
  {
    path: "/cryperrswap/services/create",
    name: "admin.cryperrswap.service.create",
    component: ServiceForm,
    props: {
      locales,
      postTitle: "create service",
    },
  },
  {
    path: "/cryperrswap/services/:serviceId/edit",
    name: "admin.cryperrswap.service.edit",
    component: ServiceForm,
    props: {
      locales,
      postTitle: "edit service",
    },
  },
];
