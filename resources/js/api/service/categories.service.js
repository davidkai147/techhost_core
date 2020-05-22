import {ApiService} from '../api.service.js'

const resource = '/categories'

export default {
    getCategories(params = {}) {
        return ApiService.get(`${resource}`, {
            ...params,
        })
    },
    getCategory(categoryId, params = {}) {
        return ApiService.get(`${resource}/${categoryId}`, {
            ...params,
        })
    },
    postCategory(payload = {}) {
        return ApiService.post(`${resource}`, payload)
    },

    putCategory(categoryId, params = {}) {
        return ApiService.put(`${resource}/${categoryId}`, params)
    },

    deleteCategory(categoryId) {
        return ApiService.delete(`${resource}/${categoryId}`)
    },
}
