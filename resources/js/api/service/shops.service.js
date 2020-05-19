import {ApiService} from '../api.service.js'

const resource = '/account/shop'

export default {
    getShops(params = {}) {
        return ApiService.get(`${resource}`, {
            ...params,
        })
    },

    getShop(shopId, queries = {}) {
        return ApiService.get(`${resource}/${shopId}`, {
            ...queries,
        })
    },

    postShop(payload = {}) {
        return ApiService.post(`${resource}`, payload)
    },

    putShop(shopId, params = {}) {
        return ApiService.put(`${resource}/${shopId}`, params)
    },

    deleteShop(shopId) {
        return ApiService.delete(`${resource}/${shopId}`)
    },
}
