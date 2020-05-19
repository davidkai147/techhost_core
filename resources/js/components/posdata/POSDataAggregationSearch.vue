<template>
    <div class="box box-primary">
        <div class="box-body">
            <form role="search" method="get" @submit.prevent="handleSearch">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="店舗">店舗</label>
                        <select name="search_shop_id" id="店舗" class="form-control"
                                v-model="inputData.search_shop_id">
                            <option value="">選択してください</option>
                            <option
                                v-for="(item, index) in list"
                                :key="item.id"
                                :value="item.id">
                                {{ item.shop_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="start-date">
                            <label for="販売期間">販売期間</label>
                            <el-date-picker
                                @change="onChange"
                                v-model="search_sales_date"
                                type="daterange"
                                align="right"
                                size="small"
                                start-placeholder="販売開始日"
                                end-placeholder="販売終了日"
                                value-format="yyyy-MM-dd"
                                style="width: 100%">
                            </el-date-picker>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="JANコード">JANコード</label>
                        <input
                            type="text"
                            name="search_jan_code"
                            class="form-control"
                            id="JANコード"
                            placeholder="JANコードを入力してください"
                            v-model="inputData.search_jan_code">
                    </div>
                    <div class="col-sm-2">
                        <label for="商品名">商品名</label>
                        <input
                            type="text"
                            name="search_item_name"
                            class="form-control"
                            id="商品名"
                            placeholder="商品名を入力してください"
                            v-model="inputData.search_item_name">
                    </div>
                    <div class="col-sm-2">
                        <label for="submit">&nbsp;</label>
                        <button type="submit" id="submit" name="search" class="btn btn-block btn-primary">
                            <i class="fa fa-search"></i>
                            検索する
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'POSDataAggregationSearch',

        data() {
            return {
                search_sales_date: '',
                inputData: {
                    search_shop_id: this.$router.currentRoute.query.search_shop_id || '',
                    search_sales_start_date: this.$router.currentRoute.query.search_sales_start_date || '',
                    search_sales_end_date: this.$router.currentRoute.query.search_sales_end_date || '',
                    search_jan_code: this.$router.currentRoute.query.search_jan_code || '',
                    search_item_name: this.$router.currentRoute.query.search_item_name || '',
                }
            }
        },

        computed: {
            ...mapGetters('shops', {
                list: 'list',
                defaultQueries: 'getQueryParams',
            }),
        },

        created() {
            if (this.$router.currentRoute.query.search_sales_start_date && this.$router.currentRoute.query.search_sales_end_date) {
                this.search_sales_date = [new Date(this.$router.currentRoute.query.search_sales_start_date), new Date(this.$router.currentRoute.query.search_sales_end_date)]
            }
        },

        methods: {
            ...mapActions('posdata', ['getLists']),

            handleSearch() {
                this.getLists(this.getUpdateQuery())
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
                const params = this.inputData
                this.handleReplaceUrl(params)

                return params
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({query: query})
                }
            },
        },
    }
</script>
