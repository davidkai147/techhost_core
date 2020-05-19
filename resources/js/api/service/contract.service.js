import {ApiService} from '../api.service.js'

const resource = '/admin/contract'

export default {
    getContracts(params = {}) {
        return ApiService.get(`${resource}`, {
            ...params,
        })
    },
    getContract(contractId, params = {}) {
        return ApiService.get(`${resource}/${contractId}`, {
            ...params,
        })
    },
    postContract(payload = {}) {
        return ApiService.post(`${resource}`, payload)
    },

    putContract(contractId, params = {}) {
        return ApiService.put(`${resource}/${contractId}`, params)
    },

    deleteContract(contractId) {
        return ApiService.delete(`${resource}/${contractId}`)
    },
}
