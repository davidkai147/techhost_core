import {ApiService} from '../api.service.js'

const resource = 'account/shelf/item'

export default {
    getShelfs(params = {}) {
        return ApiService.get(`${resource}`, params)
    },

    batchUpdate(params = {}) {
        return ApiService.post(`${resource}`, params)
    },

    uploadCSV(payload) {
        return ApiService.post(`${resource}/import`, payload)
    },

    downloadCSV(params = {}) {
        return ApiService.get(`${resource}/download`, params)
    },
}
