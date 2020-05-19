import {ApiService} from '../api.service.js'

const resource = '/account/pos/item'

export default {
    getPOSData(params = {}) {
        return ApiService.get(`${resource}/analytics`, {
            ...params,
        })
    },
    getPOSDataItem(params = {}) {
        return ApiService.get(`${resource}`, {
            ...params,
        })
    },

    uploadCSV(body) {
        return ApiService.post(`${resource}/import`, body)
    }
}
