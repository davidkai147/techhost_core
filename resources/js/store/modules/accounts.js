import accountService from '../../api/service/accounts.service'
import Vue from 'vue'

const namespaced = true

const initialState = {
    list: [],
    item: {},
    paginator: {},
    queryParams: {
        page: 1,
        perPage: 10,
        with: 'contract',
    },
}

export const state = {...initialState}

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
        state.item = item
    },

    resetState(state) {
        _.each(state, (item, index) => {
            Vue.set(state, index, initialState[index])
        })
    },

    setPaginator(state, paginator) {
        state.paginator = {...paginator}
    },

    removeItem(state, id) {
        state.list = _.filter(state.list, (item) => {
            return item.id !== id
        })
    },
}

const actions = {
    async getLists({commit}, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        params = {...params}

        await accountService.getAccounts(params).then(res => {
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
        await accountService.getAccount(`${id}`, params).then(res => {
            commit('setItem', res.data.data)
        })
    },

    resetState({commit}) {
        commit('resetState')
    },

    deleteItem({commit}, accountId) {
        return accountService.deleteAccount(`${accountId}`)
    },

    createItem({commit}, payload) {
        return accountService.postAccount(payload)
    },

    putItem({state, commit}, body = {}) {
        return accountService.putAccount(`${body.id}`, body.data)
    },

    unlockAccount({commit}, accountId) {
        return accountService.unlockAccount(accountId)
    },
}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
