<template>
    <form role="search" id="filter-form" method="get" @submit.prevent="handleSearch">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="店舗1">店舗</label>
                    <el-select id="店舗1" v-model="inputData.search_shop_id" placeholder="店舗を選択してくだささい">
                        <el-option
                            v-for="item in shopList"
                            :key="item.id"
                            :label="item.shop_name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="店舗2">比較店舗</label>
                    <el-select id="店舗2" v-model="inputData.search_shop_compare_id" placeholder="店舗を選択してください">
                        <el-option
                            v-for="item in shopList"
                            :key="item.id"
                            :label="item.shop_name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="start-date">
                    <label for="売上期間">売上期間</label>
                    <el-date-picker
                        v-model="inputData.search_sales_date"
                        type="daterange"
                        align="right"
                        size="large"
                        start-placeholder="販売開始日"
                        end-placeholder="販売終了日"
                        value-format="yyyy-MM-dd">
                    </el-date-picker>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="submit">&nbsp;</label>
                <button type="submit" id="submit" name="search" class="btn btn-block btn-primary ">
                    <i class="fa fa-search"></i>
                    検索する
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import store from '../../store'

    export default {
        name: 'POSDataAnalysisSearchForm',
        props: ['formName'],
        data() {
            return {
                inputData: {
                    search_shop_id: this.$router.currentRoute.query.search_shop_id || '',
                    search_shop_compare_id: this.$router.currentRoute.query.search_shop_compare_id || '',
                    search_sales_date: this.$router.currentRoute.query.search_sales_date || []
                }
            }
        },
        computed: {
            ...mapGetters('posDataAnalysis', {
                shopList: 'shopList',
                filteredData: 'filteredData',
                defaultQueries: 'getQueryParams'
            })
        },
        methods: {
            ...mapActions('posDataAnalysis', [
                'postFilterConditionDesignation',
                'getShopDashboard'
            ]),

            handleSearch() {
                // get new list
                const queries = this.getUpdateQuery()
                queries.page = 1

                const cloneInputData = {...this.inputData}
                const dataTmp = {...this.filteredData}
                dataTmp.shop = cloneInputData.search_shop_id

                this.handleReplaceUrl({...cloneInputData, ...queries})
                // get ShopDashboard
                store.dispatch('posDataAnalysis/getShopDashboard', {
                    shop_id: cloneInputData.search_shop_id,
                    date_start: cloneInputData.search_sales_date ? cloneInputData.search_sales_date[0] : null,
                    date_end: cloneInputData.search_sales_date ? cloneInputData.search_sales_date[1] : null,
                    shopCase: 1
                });

                if (cloneInputData.search_shop_compare_id) {
                    store.dispatch('posDataAnalysis/getShopDashboard', {
                        shop_id: cloneInputData.search_shop_compare_id,
                        date_start: cloneInputData.search_sales_date ? cloneInputData.search_sales_date[0] : null,
                        date_end: cloneInputData.search_sales_date ? cloneInputData.search_sales_date[1] : null,
                        shopCase: 2
                    });
                } else {
                    // clear store shop 2
                    store.dispatch('posDataAnalysis/clearShop2State');
                }
            },

            getUpdateQuery() {
                const params = Object.assign({}, this.defaultQueries)
                this.handleReplaceUrl(params)
                return params
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({name: this.$router.currentRoute.name, query: query})
                }
            }
        }
    }
</script>
