<template>
    <form role="search" id="filter-form" method="get" @submit.prevent="handleSearch">
        <div class="row">
            <div class="col-sm-6">
                <!-- Filter By Shop -->
                <div class="form-group" v-if="formName === 'shelf-by-shelf' || formName === 'category'">
                    <label for="shop_name">店舗</label>

                    <el-select v-model="inputData.search_shop_id" placeholder="店舗を選択してください">
                        <el-option
                            id="shop_name"
                            v-for="item in shopList"
                            :key="item.id"
                            :label="item.shop_name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- Filter by duration -->
                <div class="start-date">
                    <label for="search_sales_date">売上期間</label>

                    <el-date-picker
                        @change="onChange"
                        id="search_sales_date"
                        v-model="search_sales_date"
                        type="daterange"
                        align="right"
                        size="large"
                        start-placeholder="販売開始日"
                        end-placeholder="販売終了日"
                        value-format="yyyy-MM-dd">
                    </el-date-picker>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- Fiter By Shelf -->
                <div class="form-group">
                    <label for="shelf_no">棚番号</label>

                    <el-select v-model="inputData.search_shelf_no" multiple placeholder="棚番号を入力してください">
                        <el-option
                            id="shelf_no"
                            v-for="item in shelfNoList"
                            :key="item.id"
                            :label="item.shelf_no"
                            :value="item.shelf_no">
                        </el-option>
                    </el-select>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                    <label for="submit">&nbsp;</label>

                    <button type="submit" id="submit" name="search" class="btn btn-block btn-primary ">
                        <i class="fa fa-search"></i>
                        検索する
                    </button>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'POSDataAnalysisFilterShelfForm',
        props: ['formName'],
        data() {
            return {
                search_sales_date: '',
                inputData: {
                    search_result_axes: this.$router.currentRoute.query.search_result_axes || '',
                    search_sales_start_date: this.$router.currentRoute.query.search_sales_start_date || '',
                    search_sales_end_date: this.$router.currentRoute.query.search_sales_end_date || '',
                    search_jicfs_code: this.$router.currentRoute.query.search_jicfs_code || [],
                    search_shelf_no: this.$router.currentRoute.query.search_shelf_no || [],
                    search_shop_id: this.$router.currentRoute.query.search_shop_id || [],
                    search_shop_compare_id: this.$router.currentRoute.query.search_shop_compare_id || [],
                    search_day_of_week: this.$router.currentRoute.query.search_day_of_week || []
                },
                axes: [{value: 'day', label: '日次'}, {value: 'month', label: '月次'}],
                dayOfWeekOptions: [
                    {value: 1, label: '日曜日'},
                    {value: 2, label: '月曜日'},
                    {value: 3, label: '火曜日'},
                    {value: 4, label: '水曜日'},
                    {value: 5, label: '木曜日'},
                    {value: 6, label: '金曜日'},
                    {value: 7, label: '土曜日'}
                ]
            }
        },
        computed: {
            ...mapGetters('posDataAnalysis', {
                shopList: 'shopList',
                categoryList: 'categoryList',
                shelfNoList: 'shelfNoList',
                filteredData: 'filteredData',
                pagination: 'pagination',
                defaultQueries: 'getQueryParams'
            })
        },
        methods: {
            ...mapActions('posDataAnalysis',
                ['postFilterCategories', 'postFilterConditionDesignation', 'postFilterShelfByShelf']),

            handleSearch() {
                // get new list
                if (this.formName !== 'category') {
                    const queries = this.getUpdateQuery()
                    queries.page = 1
                }

                // Clone inputData when click Search button
                // It won't reset data of the form (ex: datetime picker)
                const cloneInputData = {...this.inputData}
                const dataTmp = {}

                dataTmp.date_start = cloneInputData.search_sales_start_date
                dataTmp.date_end = cloneInputData.search_sales_end_date
                dataTmp.days = cloneInputData.search_day_of_week
                dataTmp.display = cloneInputData.search_result_axes

                if (this.formName === 'category') dataTmp.category = cloneInputData.search_jicfs_code

                if (this.formName === 'condition-designation') {
                    dataTmp.shop = this.filteredData.shop || ''
                    dataTmp.compare_shops = cloneInputData.search_shop_compare_id
                }

                if (this.formName === 'shelf-by-shelf' || this.formName === 'category') {
                    dataTmp.shops = [cloneInputData.search_shop_id]
                }

                if (this.formName === 'shelf-by-shelf') {
                    dataTmp.shelf_no = cloneInputData.search_shelf_no
                }

                if (this.formName === 'category') {
                    this.postFilterCategories(dataTmp)
                }

                if (this.formName === 'condition-designation') {
                    this.postFilterConditionDesignation({
                        params: this.defaultQueries,
                        body: dataTmp
                    }, this.getUpdateQuery())
                }

                if (this.formName === 'shelf-by-shelf') {
                    this.postFilterShelfByShelf({params: this.defaultQueries, body: dataTmp}, this.getUpdateQuery())
                }
            },
            onChange(date) {
                if (date) {
                    [this.inputData.search_sales_start_date, this.inputData.search_sales_end_date] = date
                } else {
                    this.inputData.search_sales_start_date = ''
                    this.inputData.search_sales_end_date = ''
                }
            },
            getUpdateQuery() {
                const params = Object.assign({}, this.defaultQueries)
                this.handleReplaceUrl(params)
                return params
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({query: query})
                }
            }
        }
    }
</script>

<style lang="scss">
    /* We don't use scoped because If you want to overwrite Element UI css need css global */
    #filter-form {
        .form-group {
            margin-bottom: 10px;
        }

        .el-input__inner,
        .el-select {
            width: 100%;
        }

        .el-select .el-input__icon {
            line-height: 25px;
        }

        .el-input__inner {
            border-radius: 0;
            height: 34px;
        }

        .el-tag.el-tag--info {
            background-color: #3c8dbc;
            border-color: #3c8dbc;
            color: #ffffff;
        }

        .el-date-editor .el-range__icon {
            line-height: 27px;
        }
    }
</style>
