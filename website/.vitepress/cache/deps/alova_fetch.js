import {
  JSONStringify,
  ObjectCls,
  clearTimeoutTimer,
  falseValue,
  isSpecialRequestBody,
  isString,
  newInstance,
  promiseReject,
  setTimeoutFn,
  trueValue,
  undefinedValue
} from "./chunk-IQORDQIB.js";
import "./chunk-BUSYA2B4.js";

// node_modules/alova/dist/adapter/fetch.esm.js
var isBodyData = (data) => isString(data) || isSpecialRequestBody(data);
function adapterFetch() {
  return (elements, method) => {
    const adapterConfig = method.config;
    const timeout = adapterConfig.timeout || 0;
    const ctrl = new AbortController();
    const { data, headers } = elements;
    const isContentTypeSet = /content-type/i.test(ObjectCls.keys(headers).join());
    const isDataFormData = data && data.toString() === "[object FormData]";
    if (!isContentTypeSet && !isDataFormData) {
      headers["Content-Type"] = "application/json;charset=UTF-8";
    }
    const fetchPromise = fetch(elements.url, {
      ...adapterConfig,
      method: elements.type,
      signal: ctrl.signal,
      body: isBodyData(data) ? data : JSONStringify(data)
    });
    let abortTimer;
    let isTimeout = falseValue;
    if (timeout > 0) {
      abortTimer = setTimeoutFn(() => {
        isTimeout = trueValue;
        ctrl.abort();
      }, timeout);
    }
    return {
      response: () => fetchPromise.then((response) => {
        clearTimeoutTimer(abortTimer);
        return response.clone();
      }, (err) => promiseReject(isTimeout ? newInstance(Error, "fetchError: network timeout") : err)),
      // headers函数内的then需捕获异常，否则会导致内部无法获取到正确的错误对象
      headers: () => fetchPromise.then(({ headers: responseHeaders }) => responseHeaders, () => ({})),
      // 因nodeFetch库限制，这块代码无法进行单元测试，但已在浏览器中通过测试
      /* c8 ignore start */
      onDownload: async (cb) => {
        let isAborted = falseValue;
        const response = await fetchPromise.catch(() => {
          isAborted = trueValue;
        });
        if (!response)
          return;
        const { headers: responseHeaders, body } = response.clone();
        const reader = body ? body.getReader() : undefinedValue;
        const total = Number(responseHeaders.get("Content-Length") || responseHeaders.get("content-length") || 0);
        if (total <= 0) {
          return;
        }
        let loaded = 0;
        if (reader) {
          const pump = () => reader.read().then(({ done, value = new Uint8Array() }) => {
            if (done || isAborted) {
              isAborted && cb(total, 0);
            } else {
              loaded += value.byteLength;
              cb(total, loaded);
              return pump();
            }
          });
          pump();
        }
      },
      onUpload() {
        console.error("fetch API does'nt support uploading progress. please consider to change `@alova/adapter-xhr` or `@alova/adapter-axios`");
      },
      /* c8 ignore stop */
      abort: () => {
        ctrl.abort();
        clearTimeoutTimer(abortTimer);
      }
    };
  };
}
export {
  adapterFetch as default
};
//# sourceMappingURL=alova_fetch.js.map
