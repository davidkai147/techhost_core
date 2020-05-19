import {ApiService} from '../api.service.js'

const resource = '/admin/account'

export default {
    getAccounts(params = {}) {
        return ApiService.get(`${resource}`, {
            ...params,
        })
    },

    getAccount(id, params = {}) {
        return ApiService.get(`${resource}/${id}`, {
            ...params,
        })
    },

    // insert user
    postAccount(payload) {
        return ApiService.post(`${resource}`, payload)
    },

    // update user
    putAccount(accountId, params = {}) {
        return ApiService.put(`${resource}/${accountId}`, params)
    },

    deleteAccount(id) {
        return ApiService.delete(`${resource}/${id}`)
    },

    // unlock user
    unlockAccount(accountId) {
        return ApiService.put(`${resource}/${accountId}/unlock`)
    },
}
