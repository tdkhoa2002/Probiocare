import PackageTable from "./components/PackageTable.vue";
import PackageForm from "./components/PackageForm.vue";
import PackageFormUpdate from "./components/PackageFormUpdate.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/loyalty/packages",
    name: "admin.loyalty.package.index",
    component: PackageTable,
  },
  {
    path: "/loyalty/packages/create",
    name: "admin.loyalty.package.create",
    component: PackageForm,
    props: {
      locales,
      packageTitle: "create package",
    },
  },
  {
    path: "/loyalty/packages/:packageId/edit",
    name: "admin.loyalty.package.edit",
    component: PackageFormUpdate,
    props: {
      locales,
      packageTitle: "edit package",
    },
  },
];
