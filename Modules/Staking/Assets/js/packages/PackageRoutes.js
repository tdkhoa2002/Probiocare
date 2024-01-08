import PackageTable from "./components/PackageTable.vue";
import PackageForm from "./components/PackageForm.vue";
import PackageFormUpdate from "./components/PackageFormUpdate.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/staking/packages",
    name: "admin.staking.package.index",
    component: PackageTable,
  },
  {
    path: "/staking/packages/create",
    name: "admin.staking.package.create",
    component: PackageForm,
    props: {
      locales,
      packageTitle: "create package",
    },
  },
  {
    path: "/staking/packages/:packageId/edit",
    name: "admin.staking.package.edit",
    component: PackageFormUpdate,
    props: {
      locales,
      packageTitle: "edit package",
    },
  },
];
