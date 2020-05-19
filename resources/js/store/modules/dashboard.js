import dashboardService from '../../api/service/dashboard.service'

const namespaced = true;

const initialState = {
    trendSaleAllShopLast3M: [],
    trendSaleAllShopThisM: {
        sales_amount: 0,
        sales_quantity: 0
    },
    top10Categories: [],
    top10CategoriesThisM: [],
    monthlyShopSalesAmount: [],
    monthlyShopSalesQty: [],
    queryParams: {},
};

const state = {...initialState};

const getters = {
    trendSaleAllShopLast3M: state => state.trendSaleAllShopLast3M,
    trendSaleAllShopThisM: state => state.trendSaleAllShopThisM,
    top10Categories: state => state.top10Categories,
    top10CategoriesThisM: state => state.top10CategoriesThisM,
    monthlyShopSalesAmount: state => state.monthlyShopSalesAmount,
    monthlyShopSalesQty: state => state.monthlyShopSalesQty
};

const mutations = {
    setTrendSaleAllShopLast3M(state, payload) {
        state.trendSaleAllShopLast3M = payload;
    },
    setTrendSaleAllShopThisM(state, payload) {
        state.trendSaleAllShopThisM = payload;
    },
    setTop10Categories(state, payload) {
        state.top10Categories = payload;
    },
    setTop10CategoriesThisM(state, payload) {
        state.top10CategoriesThisM = payload;
    },
    setMonthlyShopSalesAmount(state, payload) {
        state.monthlyShopSalesAmount = payload;
    },
    setMonthlyShopSalesQty(state, payload) {
        state.monthlyShopSalesQty = payload;
    }
};

const actions = {
    async getTrendSaleAllShop(ctx, params) {
        const hasParams = _.keys(params).length === 0;
        if (hasParams) {
            params = {...state.queryParams}
        }

        params = {...params}
        await dashboardService.getTrendSaleAllShop(params).then(res => {
            const data = res.data.data;
            if (hasParams)
                ctx.commit('setTrendSaleAllShopLast3M', data);
            else if (data.length > 0) ctx.commit('setTrendSaleAllShopThisM', data[0]);
        })
    },

    async getTop10Categories(ctx, params) {
        const hasParams = _.keys(params).length === 0;
        if (hasParams) {
            params = {...state.queryParams}
        }

        params = {...params}
        await dashboardService.getTop10Categories(params).then(res => {
            const data = res.data.data;
            if (hasParams)
                ctx.commit('setTop10CategoriesThisM', data);
            else
                ctx.commit('setTop10Categories', data);
        })
    },

    async getMonthlyShopSales(ctx, params) {
        const hasParams = _.keys(params).length === 0;
        const isAmount = _.has(params, 'sales_amount');
        if (hasParams) {
            params = {...state.queryParams}
        }

        params = {...params}
        await dashboardService.getMonthlyShopSales(params).then(res => {
            const data = res.data.data;
            if (isAmount)
                ctx.commit('setMonthlyShopSalesAmount', data);
            else
                ctx.commit('setMonthlyShopSalesQty', data);
        })
    }
};

export default {
    namespaced,
    state,
    getters,
    mutations,
    actions,
}
