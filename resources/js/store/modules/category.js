import categoryService from '../../api/service/categories.service'
import Vue from 'vue'

export const namespaced = true

const initialState = {
    list: [],
    item: {},
    paginator: {},
    queryParams: {
        page: 1,
        perPage: 10
    },
}

const state = {...initialState}

const getters = {
    list: state => state.list,
    item: state => state.item,
    paginator: state => state.paginator,
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

    setQueryParams(state, queryParams) {
        state.queryParams = {...queryParams}
    }

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

        await categoryService.getCategories(params).then(res => {
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
                    perPage: pagination.perPage
                })
            }
        })
    },

    async getItem({commit}, payload = {}) {
        await categoryService.getCategory(`${ payload.id }`, payload.queries).then(res => {
            commit('setItem', res.data.data)
        })
    },

    resetState({commit}) {
        commit('resetState')
    },

    createItem({state, commit}, body = {}) {
        return categoryService.postCategory(body)
    },

    putItem({state, commit}, body = {}) {
        return categoryService.putCategory(`${body.id}`, body)
    },

    deleteItem({commit}, categoryId) {
        return categoryService.deleteCategory(`${categoryId}`)
    }

}

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
