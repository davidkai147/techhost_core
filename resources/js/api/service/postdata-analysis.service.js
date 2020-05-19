import {ApiService} from '../api.service.js'

const resource = '/chart/category';

const resourceChart = '/chart';

export default {
    getList(params = {}) {
        return ApiService.get(`${resourceChart}/getList`, {
            ...params,
        })
    },

    getTop10Categories(params = {}) {
        return ApiService.get(`${resource}/bar-chart`, {
            ...params,
        })
    },

    postFilterCategories(payload = {}) {
        return ApiService.post(`${resource}/line-chart`, payload)
    },

    postFilterConditionDesignation(payload = {}, body = {}) {
        return ApiService.post(`${resource}/store-filter`, body, {params: payload})
    },

    postFilterShelfByShelf(payload = {}, body = {}) {
        return ApiService.post(`${resource}/shelf-filter`, body, {params: payload})
    },

    postFilterCategoryTable(params = {}) {
        return ApiService.get(`${resourceChart}/categoryFilter`, {
            ...params,
        })
    },

    getDashboard(params = {}) {
        return ApiService.get(`${resourceChart}/dashboard`, {
            ...params,
        })
    },

    getShopCurrentMonth(params = {}) {
        return ApiService.get(`${resourceChart}/shop`, {
            ...params,
        })
    },

    getShopTop10CategoryMonth(param = {}) {
        return ApiService.get(`${resourceChart}/categoryFilter`, {
            ...param
        })
    }
}
