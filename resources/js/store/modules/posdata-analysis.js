import Vue from 'vue'
import posDataAnalysisService from '../../api/service/postdata-analysis.service'
import moment from 'moment'
import {chartInterface3MGradient} from '../../components/chart/shared/line-chart-all-shop-3m.data'
import {barChartSaleProductData} from '../../components/chart/shared/bar-chart.data'

export const namespaced = true

const initialState = {
    dialogTableVisible: false,
    paginator: {},
    filteredData: {},
    shopList: [],
    categoryList: [],
    shelfNoList: [],
    top10Categories: [],
    filteredCategories: [],
    filteredConditionDesignation: [],
    filterCategoryTable: [],
    filteredShelfByShelf: [],
    shopDashBoard: {},
    shopSalesMonth: {},
    shopTop10CategoryMonth: {},
    shopDashBoard2: {},
    shopSalesMonth2: {},
    shopTop10CategoryMonth2: {},
    salesProductShelfChart: {},
    queryParams: {
        page: 1,
        perPage: 10
    },
    queryCategoryParams: {
        page: 1,
        perPage: 10
    }
}

const state = {...initialState}

const getters = {
    shopList: state => state.shopList,
    categoryList: state => state.categoryList,
    shelfNoList: state => state.shelfNoList,
    top10Categories: state => state.top10Categories,
    filteredCategories: state => state.filteredCategories,
    filteredConditionDesignation: state => state.filteredConditionDesignation,
    filterCategoryTable: state => state.filterCategoryTable,
    filteredShelfByShelf: state => state.filteredShelfByShelf,
    filteredData: state => state.filteredData,
    shopDashBoard: state => state.shopDashBoard,
    shopSalesMonth: state => state.shopSalesMonth,
    shopTop10CategoryMonth: state => state.shopTop10CategoryMonth,
    shopDashBoard2: state => state.shopDashBoard2,
    shopSalesMonth2: state => state.shopSalesMonth2,
    shopTop10CategoryMonth2: state => state.shopTop10CategoryMonth2,
    salesProductShelfChart: state => state.salesProductShelfChart,
    dialogTableVisible: state => state.dialogTableVisible,
    pagination: state => state.paginator,
    getQueryParams: state => state.queryParams,
    getQueryCategoryParams: state => state.queryCategoryParams
}

const mutations = {
    setShopList(state, payload) {
        state.shopList = payload
    },
    setCategoryList(state, payload) {
        state.categoryList = payload
    },
    setShelfNoList(state, payload) {
        state.shelfNoList = payload
    },
    setTop10Categories(state, payload) {
        state.top10Categories = payload
    },
    setFilterCategories(state, payload) {
        state.filteredCategories = payload
    },
    setFilterConditionDesignation(state, {list, queryParams = {}}) {
        state.filteredConditionDesignation = [...list]
        state.queryParams = {...queryParams}
    },
    setFilterCategoryTable(state, {list, queryCategoryParams = {}}) {
        state.filterCategoryTable = [...list]
        state.queryCategoryParams = {...queryCategoryParams}
    },
    setFilterShelfByShelf(state, {list, queryParams = {}}) {
        state.filteredShelfByShelf = [...list]
        state.queryParams = {...queryParams}
    },
    setFilteredData(state, payload) {
        state.filteredData = payload
    },
    setPaginator(state, paginator) {
        state.paginator = {...paginator}
    },

    setDashBoardShop(state, payload) {
        state.shopDashBoard = {...payload}
    },

    setShopSalesMonth(state, payload) {
        state.shopSalesMonth = {...payload}
    },

    setTop10CategoriesChart(state, payload) {
        state.shopTop10CategoryMonth = {...payload}
    },

    setDashBoardShop2(state, payload) {
        state.shopDashBoard2 = {...payload}
    },

    setShopSalesMonth2(state, payload) {
        state.shopSalesMonth2 = {...payload}
    },

    setTop10CategoriesChart2(state, payload) {
        state.shopTop10CategoryMonth2 = {...payload}
    },

    setDialogTableVisible(state, payload) {
        state.dialogTableVisible = payload;
    },

    /**
     * set sale & product to state for showing in chart
     * @param state
     * @param payload
     */
    setSalesProductShelfChart(state, payload) {
        const data = {...payload}

        // Mapping data
        const dataTmp = _.cloneDeep(data)
        let barChartData = _.cloneDeep(barChartSaleProductData)

        barChartData.labels = _.map(data, function (item) {
            return item.shelf_no
        })

        // map data for sales
        barChartData.datasets[0].data = _.map(dataTmp, function (item) {
            return Number(item['total_sales_amount'])
        })

        // map data for product
        barChartData.datasets[1].data = _.map(dataTmp, function (item) {
            return Number(item['total_sales_quantity'])
        })

        state.salesProductShelfChart = barChartData
    },

    resetState(state) {
        _.each(state, (item, index) => {
            Vue.set(state, index, initialState[index])
        })
    },
}

const actions = {
    /**
     *
     * @param ctx
     * @param params
     * @returns {Promise<void>}
     */
    async getList(ctx, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        params = {...params}
        await posDataAnalysisService.getList(params).then(res => {
            const data = res.data.data
            if (params.source === 'shop') {
                ctx.commit('setShopList', data)
            } else if (params.source === 'category') {
                ctx.commit('setCategoryList', data)
            } else {
                ctx.commit('setShelfNoList', data)
            }
        })
    },

    /**
     *
     * @param ctx
     * @param params
     * @returns {Promise<void>}
     */
    async getTop10Categories(ctx, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        params = {...params}
        await posDataAnalysisService.getTop10Categories(params).then(res => {
            const data = res.data.data
            ctx.commit('setTop10Categories', data)
        })
    },

    /**
     *
     * @param ctx
     * @param body
     * @returns {Promise<void>}
     */
    async postFilterCategories(ctx, body = {}) {
        await posDataAnalysisService.postFilterCategories(body).then(res => {
            const data = res.data.data
            ctx.commit('setFilterCategories', data)
        })
    },

    /**
     *
     * @param ctx
     * @param payload
     * @returns {Promise<void>}
     */
    async postFilterConditionDesignation(ctx, payload) {
        let params = payload.params
        let body = payload.body
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }
        if (params.per_page === 0) {
            params = {}
        }

        params = {...params}
        ctx.commit('setFilteredData', body)
        await posDataAnalysisService.postFilterConditionDesignation(params, body).then(res => {
            const pagination = res.data
            const data = res.data.data
            ctx.commit('setFilterConditionDesignation', {
                list: data,
                queryParams: params
            })

            ctx.commit('setPaginator', {
                totalPages: pagination.last_page || 0,
                page: pagination.current_page,
                perPage: pagination.per_page
            })
        })
    },

    /**
     * /cms/admin/pos-analysis/condition-designation
     * show or hide modal to show categories
     * @param ctx
     * @param value
     */
    showOrHideModal(ctx, value) {
        ctx.commit('setDialogTableVisible', value);
    },

    /**
     * /cms/admin/pos-analysis/condition-designation
     * Get Categories when click on point of chart
     * @param ctx
     * @param payload
     * @returns {Promise<void>}
     */
    async postFilterCategoryTable(ctx, params = {}) {
        if (_.keys(params).length === 0) {
            params = {...state.queryCategoryParams}
        }
        if (params.per_page === 0) {
            params = {}
        }

        params = {...params}
        await posDataAnalysisService.postFilterCategoryTable(params).then(res => {
            const pagination = res.data.pagination
            const data = res.data.data
            ctx.commit('setFilterCategoryTable', {
                list: data,
                queryCategoryParams: params
            })

            ctx.commit('setPaginator', {
                totalPages: pagination.totalPages || 0,
                page: pagination.currentPage,
                perPage: pagination.perPage,
            })

            ctx.dispatch('showOrHideModal', true)

        })
    },

    /**
     * /cms/admin/pos-analysis/shelf-by-shelf Get list
     * @param commit
     * @param dispatch
     * @param payload
     * @returns {Promise<void>}
     */
    async postFilterShelfByShelf({commit, dispatch}, payload) {
        let params = payload.params
        let body = payload.body
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }
        if (params.per_page === 0) {
            params = {}
        }

        params = {...params}
        commit('setFilteredData', body)
        await posDataAnalysisService.postFilterShelfByShelf(params, body).then(res => {
            const pagination = res.data
            const data = res.data.data

            commit('setFilterShelfByShelf', {
                list: data,
                queryParams: params
            })

            commit('setPaginator', {
                totalPages: pagination.last_page || 0,
                page: pagination.current_page,
                perPage: pagination.per_page
            })

            // dispatch convert for chart
            if ('shops' in body && body.shops.length) {
                commit('setSalesProductShelfChart', data)
            }
        })
    },

    /**
     * call api sales & products in last 3 months
     * @param commit
     * @param dispatch
     * @param payload
     * @returns {Promise<void>}
     */
    async getShopDashboard({commit, dispatch}, payload) {
        const params = {...payload}

        if (!params.shop_id) {
            return
        }

        await posDataAnalysisService.getDashboard(params).then(response => {
            const {data: {data}} = response

            // Mapping data
            const dataTmp = _.cloneDeep(data)
            let lineChartData = _.cloneDeep(chartInterface3MGradient())

            // Shop ID
            lineChartData.shop_id = payload.shop_id;

            // convert date
            lineChartData.labels = _.map(data, function (item) {
                item.month = moment(item.month, 'YYYY/MM').format('YYYY年MM月')
                return item.month
            })

            // map data for sales
            lineChartData.datasets[0].data = _.map(dataTmp, function (item) {
                return Number(item['sales_amount'])
            })

            // map data for product
            lineChartData.datasets[1].data = _.map(dataTmp, function (item) {
                return Number(item['sales_quantity'])
            })

            // set to state
            if (params['shopCase'] && params['shopCase'] === 2) {
                commit('setDashBoardShop2', lineChartData)
            } else {
                commit('setDashBoardShop', lineChartData)
            }
        })

        // call current month
        dispatch('getShopCurrentMonth', payload)

        // call top 10 category
        dispatch('getShopTop10CategoryMonth', payload)
    },

    /**
     * call api get Sales & Products current month
     * @param commit
     * @param dispatch
     * @param payload
     * @returns {Promise<void>}
     */
    async getShopCurrentMonth({commit, dispatch}, payload) {
        const params = {
            ...payload,
            month: moment(new Date(), 'YYYY/MM/DD').format('YYYY-MM'),
            sales_amount: true,
            sales_quantity: true
        }

        await posDataAnalysisService.getShopCurrentMonth(params).then(response => {
            const {data: {data}} = response

            if (params['shopCase'] && params['shopCase'] === 2) {
                commit('setShopSalesMonth2', data)
            } else {
                commit('setShopSalesMonth', data)
            }
        })
    },

    /**
     * get top 10 category of shop
     * @param ctx
     * @param params
     * @returns {Promise<void>}
     */
    async getShopTop10CategoryMonth(ctx, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        params = {
            ...params,
            perPage: 10
        }
        await posDataAnalysisService.getShopTop10CategoryMonth(params).then(res => {
            const data = res.data.data

            // Mapping data
            const dataTmp = _.cloneDeep(data)
            let barChartData = _.cloneDeep(barChartSaleProductData)

            barChartData.labels = _.map(data, function (item) {
                return item.jicfs_name
            })

            // map data for sales
            barChartData.datasets[0].data = _.map(dataTmp, function (item) {
                return Number(item['sales_amount'])
            })

            // map data for product
            barChartData.datasets[1].data = _.map(dataTmp, function (item) {
                return Number(item['total_sales_quantity'])
            })

            if (params['shopCase'] && params['shopCase'] === 2) {
                ctx.commit('setTop10CategoriesChart2', barChartData)
            } else {
                ctx.commit('setTop10CategoriesChart', barChartData)
            }
        })
    },

    clearShop2State({commit, dispatch}, payload) {
        commit('setTop10CategoriesChart2', {})
        commit('setShopSalesMonth2', {})
        commit('setDashBoardShop2', {})
    },

    resetState({commit}) {
        commit('resetState')
    }
}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions
}
