import Vuex from 'vuex'
import Vue from 'vue'

// import modules
import auth from './modules/auth'
import contract from './modules/contract'
import category from './modules/category'
import accounts from './modules/accounts'
import shops from './modules/shops'
import shelf from './modules/shelf-location'
import posdata from './modules/posdata'
import posdataitem from './modules/posdataitem'
import dashboard from './modules/dashboard'
import posDataAnalysis from './modules/posdata-analysis'
import loader from './modules/loader'

Vue.use(Vuex)

const modules = {
    auth,
    contract,
    category,
    accounts,
    shops,
    shelf,
    posdata,
    posdataitem,
    dashboard,
    posDataAnalysis,
    loader
}

const state = {}

const getters = {}

const mutations = {}

const actions = {}

export default new Vuex.Store({
    modules,
    state,
    getters,
    mutations,
    actions,
})
