import {ApiService} from '../api.service.js'

const resource = '/chart';

export default {
    getTrendSaleAllShop(params = {}) {
        return ApiService.get(`${resource}/dashboard`, {
            ...params,
        })
    },

    getTop10Categories(params = {}) {
        return ApiService.get(`${resource}/itemCategory`, {
            ...params,
        })
    },

    getMonthlyShopSales(params = {}) {
        return ApiService.get(`${resource}/shop`, {
            ...params,
        })
    }
}
