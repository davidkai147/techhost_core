import shopsService from '../../api/service/shops.service'
import Vue from 'vue'

export const namespaced = true

const initialState = {
    list: [],
    item: {},
    paginator: {},
    queryParams: {
        page: 1,
        perPage: 10,
    },
}

const state = {...initialState}

const getters = {
    list: state => state.list,
    item: state => state.item,
    pagination: state => state.paginator,
    getQueryParams: state => state.queryParams,
}

const mutations = {
    setList(state, {list, queryParams = {}}) {
        state.list = [...list]
        state.queryParams = {...queryParams}
    },

    setItem(state, item) {
        state.item = {...item}
    },

    resetState(state) {
        _.each(state, (item, index) => {
            Vue.set(state, index, initialState[index])
        })
    },

    setPaginator: (state, paginator) => {
        state.paginator = {...paginator}
    },
}

const actions = {
    async getLists({commit}, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        if (params.perPage === 0) {
            params = {}
        }

        params = {...params}

        await shopsService.getShops(params).then(res => {
            const pagination = res.data.pagination
            const list = res.data.data

            commit('setList', {
                list: list,
                queryParams: params,
            })

            if (pagination) {
                commit('setPaginator', {
                    totalPages: pagination.totalPages || 0,
                    page: pagination.currentPage,
                    perPage: pagination.perPage,
                })
            }
        })
    },

    async getItem({commit}, id) {
        const params = {}
        await shopsService.getShop(`${id}`, params).then(res => {
            commit('setItem', res.data.data)
        })
    },

    createItem({state, commit}, body = {}) {
        return shopsService.postShop(body)
    },

    putItem({state, commit}, body = {}) {
        return shopsService.putShop(`${body.id}`, body.shopData)
    },

    deleteItem({commit}, contractId) {
        return shopsService.deleteShop(`${contractId}`)
    },

    resetState({commit}) {
        commit('resetState')
    },
}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
