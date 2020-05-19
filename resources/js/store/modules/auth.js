import {ApiService} from '../../api/api.service'

const state = () => {
    return {
        currentUser: {},
    }
}

const getters = {
    currentUser: state => state.currentUser,
}

const mutations = {
    updateUser(state, payload) {
        state.currentUser = payload
    },
    resetUser(state) {
        state.currentUser = {}
    },
}

const actions = {

    login({commit}, data) {
        try {
            return ApiService.post('/auth/login', data).then(resp => {
                commit('updateUser', resp.data.data)
                $cookies.set('access_token', resp.data.access_token);
                $cookies.set('type', resp.data.typeAuth);
                return resp.data
            })
        } catch (e) {
            throw (e)
        }
    },

    logout({commit}) {
        try {
            return ApiService.get('/auth/logout').then(resp => {
                commit('resetUser')
                $cookies.remove('access_token');
                $cookies.remove('type');
                return resp.data
            })
        } catch (e) {
            throw (e)
        }
    },

    checkAuth({commit}) {
        return ApiService.get('/auth/user').then(
            (resp) => {
                commit('updateUser', resp.data.data)
                return resp.data.data
            },
        )
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}
