const namespaced = true;

const state = {
    loading: false
};

const getters = {};

const actions = {
    showLoading({commit}) {
        commit("show");
    },
    hideLoading({commit}) {
        commit("hide");
    }
};

const mutations = {
    show(state) {
        state.loading = true;
    },
    hide(state) {
        state.loading = false;
    }
};

export default {
    namespaced,
    state,
    actions,
    mutations,
    getters
};
