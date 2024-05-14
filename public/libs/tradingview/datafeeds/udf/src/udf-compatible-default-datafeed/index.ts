import { Requester } from "../requester";
import { QuotesProvider } from "./quotes-provider";
import { UDFCompatibleDatafeedBase } from "./udf-compatible-datafeed-base";

export default class UDFCompatibleDefaultDatafeed extends UDFCompatibleDatafeedBase {
  public constructor(datafeedURL: string, updateFrequency: number = 10 * 1000) {
    const requester = new Requester();
    const quotesProvider = new QuotesProvider(datafeedURL, requester);
    super(datafeedURL, quotesProvider, requester, updateFrequency);
  }
}
