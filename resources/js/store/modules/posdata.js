import posDataService from '../../api/service/posdata.service'
import Vue from 'vue'

export const namespaced = true

const initialState = {
    list: [],
}

const state = {...initialState}

const getters = {
    list: state => state.list,
    getQueryParams: state => state.queryParams,
}

const mutations = {
    setList(state, {list, queryParams = {}}) {
        state.list = [...list]
        state.queryParams = {...queryParams}
    },

    resetState(state) {
        _.each(state, (item, index) => {
            Vue.set(state, index, initialState[index])
        })
    },
}

const actions = {
    async getLists({commit}, params) {
        if (_.keys(params).length === 0) {
            params = {...state.queryParams}
        }

        params = {...params}

        await posDataService.getPOSData(params).then(res => {
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

    uploadCSV({commit}, body) {
        return posDataService.uploadCSV(body)
    },
}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
