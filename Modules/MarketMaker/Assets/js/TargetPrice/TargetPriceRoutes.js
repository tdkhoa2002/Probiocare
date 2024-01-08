import TargetPriceForm from "./components/TargetPriceForm";

const { locales } = window.AsgardCMS;

export default [
  {
    path: "/marketmaker/targetprices",
    name: "admin.marketmaker.targetprice.index",
    component: TargetPriceForm,
    props: {
      locales,
      postTitle: "create targetprice",
    }
  },
  {
    path: "/marketmaker/targetprices/:targetPriceId/edit",
    name: "admin.marketmaker.targetprice.edit",
    component: TargetPriceForm,
    props: {
      locales,
      postTitle: "edit targetprice",
    }
  },
];
