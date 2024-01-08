<template>
  <div class="trading-pair-chart">
    <div id="tv_chart_container" :style="{ height: isMobile ? '380px' : '500px' }"></div>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
import GetPathImg from "../../mixins/GetPathImg";

export default {
  props: {
    pairsymbol: {
      default: null
    },
    tradingData: {
      type: Array,
      default: null
    },
    linkRoute: {
      default: null,
    },
  },
  mixins: [GetPathImg],
  data() {
    return {
      isMobile
    };
  },
  created() {
  },
  methods: {
    getParameterByName(name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
      return results === null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
    },
    initChart() {
      var datafeedUrl = this.linkRoute+"/api";
      var customDataUrl = this.getParameterByName("dataUrl");
      if (customDataUrl !== "") {
        datafeedUrl = customDataUrl.startsWith("https://") ? customDataUrl : `https://${customDataUrl}`;
      }

      new TradingView.widget({
        // debug: true, 
        // fullscreen: true,
        symbol: this.pairsymbol,
        interval: "1",
        container: "tv_chart_container",
        datafeed: new DatafeedFactory.createDatafeed(
          {
            datafeedURL: datafeedUrl,
          },
        ),
        library_path: "/libs/tradingview/charting_library/",
        locale: this.getParameterByName("lang") || "en",

        autosize: true,
        disabled_features: [
          "use_localstorage_for_settings",
          "header_compare",
          "header_symbol_search",
          "left_toolbar",
        ],
        enabled_features: [
          // "study_templates",
        ],
        charts_storage_url: "https://saveload.tradingview.com",
        charts_storage_api_version: "1.1",
        client_id: "tradingview.com",
        user_id: "public_user_id",
        theme: this.getParameterByName("theme"),
        overrides: {
          "mainSeriesProperties.style": 1,
        }
      });
    }
  },
  computed: {
    // uniqueArray() {
    //   return this.$helpers.getUniqueArray(this.duplicate_array)
    // }
  },
  mounted() {
    this.initChart()
  },
};
</script>
