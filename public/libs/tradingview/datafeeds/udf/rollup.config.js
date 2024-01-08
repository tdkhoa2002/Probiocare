/* globals process */

import { nodeResolve } from "@rollup/plugin-node-resolve";
import { terser } from "rollup-plugin-terser";

const environment = process.env.ENV || "development";
const isDevelopmentEnv = environment === "development";

export default [
  {
    input: "lib/udf-datafeed-factory.js",
    output: {
      name: "DatafeedFactory",
      format: "umd",
      file: "dist/bundle.js",
    },
    plugins: [
      nodeResolve(),
      !isDevelopmentEnv &&
        terser({
          ecma: 2017,
          safari10: true,
          output: { inline_script: true },
        }),
    ],
  },
];
