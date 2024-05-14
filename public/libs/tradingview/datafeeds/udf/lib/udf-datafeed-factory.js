import UDFCompatibleDatafeed from "./udf-compatible-datafeed";
export function createDatafeed(config) {
    return new UDFCompatibleDatafeed(config.datafeedURL, config.updateFrequency);
}
