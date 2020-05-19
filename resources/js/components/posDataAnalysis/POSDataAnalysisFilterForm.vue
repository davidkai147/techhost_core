<template>
    <form role="search" id="filter-form" method="get" @submit.prevent="handleSearch">
        <div class="row">
            <div class="col-sm-6">
                <div class="start-date">
                    <label for="売上期間">売上期間</label>
                    <el-date-picker
                        @change="onChange"
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="日次">日次/月次</label>
                    <el-select v-model="inputData.search_result_axes" id="日次" clearable placeholder="日次/月次を選択してください">
                        <el-option
                            v-for="item in axes"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>

        <div class="row" v-if="formName === 'category'">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="jicfs_name">カテゴリ</label>
                    <input id="jicfs_name" type="text" class="form-control" name="jicfs_name"
                           placeholder="カテゴリ名を入力してください。" v-model="inputData.search_jicfs_name"/>
                </div>
            </div>
        </div>

        <div class="row" v-if="formName === 'shelf-by-shelf'">
            <div class="col-sm-12">売上期間
                <div class="form-group">
                    <label for="棚番号">棚番号</label>
                    <el-select v-model="inputData.search_shelf_no" id="shelf_no" multiple placeholder="棚番号を入力してください">
                        <el-option
                            v-for="item in shelfNoList"
                            :key="item.id"
                            :label="item.shelf_no"
                            :value="item.shelf_no">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group" v-if="formName === 'shelf-by-shelf' || formName === 'category'">
                    <label for="店舗">店舗</label>
                    <el-select v-model="inputData.search_shop_id" multiple placeholder="店舗を選択してください">
                        <el-option
                            v-for="item in shopList"
                            :key="item.id"
                            :label="item.shop_name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </div>
                <div class="form-group" v-if="formName === 'condition-designation'">
                    <label for="店舗">比較店舗</label>
                    <el-select v-model="inputData.search_shop_compare_id" multiple placeholder="店舗を選択してください">
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
                    <label for="曜日">曜日</label>
                    <el-select v-model="inputData.search_day_of_week" multiple placeholder="曜日を選択してください">
                        <el-option
                            v-for="item in dayOfWeekOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-3 pull-right">
                <button type="submit" id="submit" name="search" class="btn btn-block btn-primary ">
                    <i class="fa fa-search"></i>
                    検索する
                </button>
            </div>
        </div>

    </form>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "POSDataAnalysisFilterForm",
        props: ['formName'],
        data() {
            return {
                search_sales_date: '',
                inputData: {
                    search_result_axes: this.$router.currentRoute.query.search_result_axes || '',
                    search_sales_start_date: this.$router.currentRoute.query.search_sales_start_date || '',
                    search_sales_end_date: this.$router.currentRoute.query.search_sales_end_date || '',
                    search_jicfs_name: this.$router.currentRoute.query.search_jicfs_name || '',
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
                defaultQueries: 'getQueryParams',
            }),
        },
        methods: {
            ...mapActions('posDataAnalysis', ['postFilterCategories', 'postFilterConditionDesignation', 'postFilterShelfByShelf']),

            handleSearch() {
                // get new list
                if (this.formName !== 'category') {
                    const queries = this.getUpdateQuery();
                    queries.page = 1;
                }

                // Clone inputData when click Search button
                // It won't reset data of the form (ex: datetime picker)
                const cloneInputData = {...this.inputData};
                const dataTmp = {};
                dataTmp.date_start = cloneInputData.search_sales_start_date;
                dataTmp.date_end = cloneInputData.search_sales_end_date;
                dataTmp.days = cloneInputData.search_day_of_week;
                dataTmp.display = cloneInputData.search_result_axes;
                if (this.formName === 'category') dataTmp.jicfs_name = cloneInputData.search_jicfs_name;
                if (this.formName === 'condition-designation') {
                    dataTmp.shop = this.filteredData.shop || '';
                    dataTmp.compare_shops = cloneInputData.search_shop_compare_id;
                }
                if (this.formName === 'shelf-by-shelf' || this.formName === 'category') dataTmp.shops = cloneInputData.search_shop_id;
                if (this.formName === 'shelf-by-shelf') dataTmp.shelf_no = cloneInputData.search_shelf_no;

                if (this.formName === 'category') this.postFilterCategories(dataTmp);
                if (this.formName === 'condition-designation') this.postFilterConditionDesignation({
                    params: this.defaultQueries,
                    body: dataTmp
                }, this.getUpdateQuery());
                if (this.formName === 'shelf-by-shelf') this.postFilterShelfByShelf({
                    params: this.defaultQueries,
                    body: dataTmp
                }, this.getUpdateQuery());
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
                const params = Object.assign({}, this.defaultQueries);
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
