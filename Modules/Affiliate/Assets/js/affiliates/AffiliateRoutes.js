import AffiliateTable from "./components/AffiliateTable.vue";
import AffiliateForm from "./components/AffiliateForm.vue";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/affiliate/affiliates",
    name: "admin.affiliate.affiliate.index",
    component: AffiliateTable,
  },
  {
    path: "/affiliate/affiliates/create",
    name: "admin.affiliate.affiliate.create",
    component: AffiliateForm,
    props: {
      locales,
      postTitle: "create affiliate",
    },
  },
  {
    path: "/affiliate/affiliates/:affiliateId/edit",
    name: "admin.affiliate.affiliate.edit",
    component: AffiliateForm,
    props: {
      locales,
      postTitle: "edit affiliate",
    },
  },
];
