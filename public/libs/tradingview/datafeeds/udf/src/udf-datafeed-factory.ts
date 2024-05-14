import UDFCompatibleDatafeed from "./udf-compatible-datafeed";

export function createDatafeed(config: { datafeedURL: string; updateFrequency?: number }) {
  return new UDFCompatibleDatafeed(config.datafeedURL, config.updateFrequency);
}
