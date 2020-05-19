import shelfLocationService from '../../api/service/shelf-location.service'
import Vue from 'vue'

const namespaced = true

const initialState = {
    list: [],
    item: {},
    paginator: {},
    queryParams: {
        with: 'shop'
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
        state.item = {...item}
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

        await shelfLocationService.getShelfs(params).then(res => {
            const list = res.data.data
            commit('setList', {
                list: list,
                queryParams: params,
            })
        })
    },

    resetState({commit}) {
        commit('resetState')
    },

    batchUpdate({commit}, data) {
        return shelfLocationService.batchUpdate(data)
    },

    uploadCSV({commit}, data) {
        return shelfLocationService.uploadCSV(data)
    },

    downloadCSV({state, commit}, params = {}) {
        return shelfLocationService.downloadCSV(params)
    },
}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
