(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.DatafeedFactory = {}));
}(this, (function (exports) { 'use strict';

    // Makes requests to CryptoCompare API
    async function makeApiRequest(datafeedURL, path) {
        try {
            const response = await fetch(`${datafeedURL}/${path}`);
            return response.json();
        }
        catch (error) {
            throw new Error(`CryptoCompare request error: ${error.status}`);
        }
    }
    function convertToOHLC(data, interval) {
        const sData = [, , ...data.sort((a, b) => a.time - b.time)];
        console.log("convertToOHLC Data===>", data);
        console.log("convertToOHLC sData===>", sData);
        var result = [];
        let isFirst = true;
        let lastBar;
        let rangeTime = sData[2].time + interval;
        var tempObject = {};
        sData.forEach((bar) => {
            // console.log("convertToOHLC bar===>", bar);
            if (bar.time <= rangeTime) {
                if (isFirst) {
                    tempObject.time = bar.time;
                    tempObject.open = bar.price;
                    tempObject.close = bar.price;
                    tempObject.high = bar.price;
                    tempObject.low = bar.price;
                    tempObject.volume = bar.volume;
                }
                else {
                    const high = tempObject.high > bar.price ? tempObject.high : bar.price;
                    const low = tempObject.low < bar.price ? tempObject.low : bar.price;
                    const volume = tempObject.volume + bar.volume;
                    tempObject.time = bar.time;
                    tempObject.open = lastBar.close;
                    tempObject.close = bar.price;
                    tempObject.high = high;
                    tempObject.low = low;
                    tempObject.volume = volume;
                }
            }
            else if (tempObject.time) {
                lastBar = Object.assign({}, tempObject);
                rangeTime = tempObject.time + interval;
                result.push(Object.assign({}, lastBar));
                isFirst = false;
                tempObject.time = bar.time;
                tempObject.open = lastBar.close;
                tempObject.close = bar.price;
                tempObject.high = bar.price;
                tempObject.low = bar.price;
                tempObject.volume = bar.volume;
            }
        });

        // console.log("convertToOHLC result===>", result);
        
        return result;
    }

    const configurationData = {
        supported_resolutions: ["1", "3", "5", "15", "30", "60", "120", "240", "480", "720", "1D", "1W", "1M", "12M"],
        supports_marks: false,
        supports_timescale_marks: false,
        supports_time: true,
        symbols_types: [{ name: "crypto", value: "Cryptocurrency" }],
    };
    function parseTime(time) {
        const tt = new Date(time * 1000).toLocaleString();
        return tt;
    }
    class DataFeed {
        constructor(datafeedURL, updateFrequency = 1000) {
            this._initLastBarTime = -1;
            this._subs = new Array();
            this.TIME_LIST_MAP_NUMBER = {
                1: 60,
                3: 60 * 3,
                5: 60 * 5,
                15: 60 * 15,
                30: 60 * 30,
                60: 60 * 60 * 1,
                120: 60 * 60 * 2,
                240: 60 * 60 * 4,
                480: 60 * 60 * 8,
                720: 60 * 60 * 12,
                "1D": 60 * 60 * 24 * 1,
                "1W": 60 * 60 * 24 * 7,
                "1M": 60 * 60 * 24 * 30,
                "12M": 60 * 60 * 24 * 360,
            };
            this._mapInterval = {
                1: "MIN_1",
                3: "MIN_3",
                5: "MIN_5",
                15: "MIN_15",
                30: "MIN_30",
                60: "HOUR_1",
                120: "HOUR_2",
                240: "HOUR_4",
                480: "HOUR_8",
                720: "HOUR_12",
                "1D": "DAY",
                "1W": "WEEK",
                "1M": "MONTH",
                "12M": "YEAR",
            };
            this.datafeedURL = datafeedURL;
            this._updateFrequency = updateFrequency;
        }
        onReady(callback) {
            console.log("[onReady]: Method call");
            setTimeout(() => callback(configurationData));
        }
        searchSymbols(userInput, exchange, symbolType, onResultReadyCallback) {
            // only need searchSymbols when search is enabled
            console.log("[searchSymbols]: Method call");
            return;
        }
        async resolveSymbol(symbolName, onSymbolResolvedCallback, onResolveErrorCallback) {
            console.log("[resolveSymbol]: Method call", { symbolName });
            if (!symbolName) {
                onResolveErrorCallback("unknown_symbol");
                return;
            }
            const symbolResult = {
                ticker: symbolName,
                name: symbolName,
                full_name: symbolName,
                description: symbolName,
                exchange: "Exchange",
                listed_exchange: "Exchange",
                type: "crypto",
                pricescale: 1000000,
                currency_code: symbolName,
                session: "24x7",
                timezone: "Etc/UTC",
                has_intraday: true,
                has_daily: true,
                minmov: 1,
                format: "price",
                has_weekly_and_monthly: true,
                supported_resolutions: ["1", "3", "5", "15", "30", "60", "120", "480", "1D", "3D"],
            };
            onSymbolResolvedCallback(symbolResult);
        }
        async getBars(symbolInfo, resolution, periodParams, onHistoryCallback, onErrorCallback) {
            const { from, to, firstDataRequest } = periodParams;
            console.log("[getBars]: Method call", { symbolInfo, resolution, resolutionName: this._mapInterval[resolution], from: parseTime(from), to: parseTime(to), firstDataRequest });
            const query = `?from=${from}&to=${to}`;
            try {
                const res = await makeApiRequest(this.datafeedURL, "trading-data/market-trades/" + symbolInfo.currency_id + query);
                console.log("getBars res==>", res);
                if (res.error == true || res.data.tradeHistories.length == 0) {
                    onHistoryCallback([], { noData: true });
                    return;
                }
                const bars = convertToOHLC(res.data.tradeHistories.map((item) => ({ time: new Date(item.created_at).getTime() / 1000, price: item.price, volume: item.amount })), this.TIME_LIST_MAP_NUMBER[resolution])
                    .sort((a, b) => {
                    b.time - a.time;
                })
                    .map((bar) => (Object.assign(Object.assign({}, bar), { time: bar.time * 1000 })));
                if (firstDataRequest) {
                    this._lastBar = bars[bars.length - 1];
                    this._initLastBarTime = this._lastBar.time / 1000 + 1; // get last time
                }

                // console.log("getBars bars===>", bars);
                onHistoryCallback(bars, { noData: false });
            }
            catch (error) {
                console.log("[getBars]: Get error", error);
                onErrorCallback(error);
            }
        }
        async subscribeBars(symbolInfo, resolution, onRealtimeCallback, subscriberUID, onResetCacheNeededCallback) {
            console.log("[subscribeBars]: Method call with subscriberUID:", { subscriberUID, symbolInfo, resolution });
            var channel = Pusher.subscribe(`Market.${symbolInfo.currency_id}`);
            const that = this;
            channel.bind("HookTradeMarket", function (data) {
                const trade = data.dataTrade;
                if (this._lastBar) {
                    const currentCandleTime = Math.floor(new Date().getTime());
                    const nextCandleTime = this._lastBar.time + that.TIME_LIST_MAP_NUMBER[resolution];
                    const open = currentCandleTime >= nextCandleTime ? this._lastBar.close : this._lastBar.open;
                    const close = trade.price;
                    const high = this._lastBar.high > trade.price ? this._lastBar.high : trade.price;
                    const low = this._lastBar.low < trade.price ? this._lastBar.low : trade.price;
                    // time: Math.floor(new Date(trade.created_at).getTime()),
                    this._lastBar = {
                        time: Math.floor(new Date().getTime()),
                        open,
                        close,
                        high,
                        low,
                    };
                    onRealtimeCallback(this._lastBar);
                }
                else {
                    this._lastBar = {
                        time: Math.floor(new Date().getTime()),
                        open: trade.price,
                        close: trade.price,
                        high: trade.price,
                        low: trade.price,
                    };
                    onRealtimeCallback(this._lastBar);
                }
            });
        }
        unsubscribeBars(listenerGuid) {
            console.log("[unsubscribeBars]: Method call with subscriberUID:", { listenerGuid });
            const subIndex = this._subs.findIndex((e) => e.id == listenerGuid);
            if (subIndex < 0)
                return;
            clearInterval(this._subs[subIndex].interval);
            this._subs.splice(subIndex, 1);
        }
    }

    function createDatafeed(config) {
        return new DataFeed(config.datafeedURL, config.updateFrequency);
    }

    exports.createDatafeed = createDatafeed;

    Object.defineProperty(exports, '__esModule', { value: true });

})));
