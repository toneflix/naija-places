import { AlovaGenerics, Method, createAlova } from 'alova';
import VueHook, { VueHookType } from 'alova/vue';
import fetchAdapter, { FetchRequestInit } from 'alova/fetch';

import { bootstrapStore } from '../store/bootstrap';
import { createClientTokenAuthentication } from 'alova/client';

type ResponseMethod =
    Method<AlovaGenerics<any, any, FetchRequestInit, Response, Headers, any, any, any>>
/**
 *
 */
const responded = async (response: Response) => {
    const json = await response.clone().json()

    return new Promise((resolve, reject) => {
        if (response.status >= 400) {
            if (response.status === 401) {
                const boot = bootstrapStore();
                bootstrapStore().clearAuth().then(() => {
                    boot.setRedirect('portal/login')
                })
            }

            if (json.errors) {
                json.errors = Object.assign(
                    {},
                    ...Object.keys(json.errors).map((e) => {
                        return {
                            [e]: Array.isArray(json?.errors?.[e])
                                ? json.errors[e][0]
                                : json.errors?.[e],
                        };
                    }),
                );
            }
            reject(json);
        } else {
            resolve(json)
        }
    });
};

const { onAuthRequired, onResponseRefreshToken } = createClientTokenAuthentication<VueHookType>({
    refreshToken: {
        isExpired: () => {
            return false;
        },
        handler: async () => {
            const boot = bootstrapStore();
            await boot.clearAuth();
        }
    },
    assignToken: method => {
        const boot = bootstrapStore();
        method.config.headers.Authorization = 'Bearer ' + boot.token;
    },
    login (response, method) {
        method.promise?.then((data) => {
            const boot = bootstrapStore();
            boot.saveAuthUser(data.data, data.token)
        })
    },
    async logout () {
        const boot = bootstrapStore();
        bootstrapStore().clearAuth().then(() => {
            boot.setRedirect('portal/login')
        })
    },
});

const baseURL = import.meta.env.DEV
    ? import.meta.env.VITE_BASEURL_DEV
    : import.meta.env.VITE_BASEURL

export const alova = createAlova({
    baseURL,
    statesHook: VueHook,
    responded: onResponseRefreshToken(responded) as any,
    requestAdapter: fetchAdapter(),
    beforeRequest: onAuthRequired((method: ResponseMethod, withCredentials?: boolean) => {
        method.config.headers['Access-Control-Allow-Credentials'] = 'true'
        method.config.headers['X-Requested-With'] = 'XMLHttpRequest'
        method.config.headers['Accept'] = 'application/json'
    }),
});
